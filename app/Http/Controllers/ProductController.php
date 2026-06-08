<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
   
    public function indexHome(Request $request)
    {
        $query = Product::with('images');

        // Filtrar por búsqueda
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filtrar por categoría
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->get();

        // Generar URL pública de S3 para cada imagen
        $products->each(function ($product) {
            $product->images->each(function ($image) {
                $image->url = Storage::disk('s3')->url($image->path);
            });
        });

        $categories = Category::all();

        return Inertia::render('Product/Index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'search' => $request->search,
                'selectedCategory' => $request->category_id,
            ],
        ]);
    }
    function index()
    {
        $products = Product::with('category', 'images')->get();
        return Inertia::render('Admin/Products/Index', [
            'products' => $products
        ]);
    }

    function create()
    {
        $categories = Category::all();
        return Inertia::render('Admin/Products/Create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        try {
            Log::info('Inicio de creación de producto');
            Log::info('Datos recibidos:', $request->all());

            // Validación
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'images' => 'nullable|array',
                'images.*' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            Log::info('Validación pasada');

            // Crear producto
            $product = Product::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'category_id' => $request->input('category_id'),
            ]);

            Log::info('Producto creado con ID: ' . $product->id);

            // Guardar imágenes si existen
            if ($request->images && is_array($request->images)) {
                foreach ($request->images as $image) {
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $path = $image->store('images', 's3');
                        //dd($path);
                        // 2. Obtenemos la URL pública completa de la imagen en S3
                        $s3Url = Storage::disk('s3')->url($path);
                        //dd($s3Url);
                        $product->images()->create([
                            'path' => $path,
                        ]);
                        Log::info('Imagen subida a s3: ' . $s3Url);
                    } else {
                        Log::warning('Elemento en images no es un archivo: ', ['type' => gettype($image)]);
                    }
                }
            }

            Log::info('Todo finalizó correctamente');

            return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error en ProductController@store: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Ocurrió un error al crear el producto.',
                'mensaje' => $e->getMessage(),
            ], 500);
        }
    }


    public function edit(Product $product)
    {
        $product->load('images'); // Asegurate de cargar las imágenes relacionadas
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
            'categories' => Category::all(), // No te olvides de enviar también las categorías
        ]);
    }

    public function update(Request $request, Product $product)
    {
        try {

            Log::info('Inicio de actualización de producto ID: ' . $product->id);
            Log::info('Datos recibidos:', $request->all());

            $data = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'category_id' => 'required|exists:categories,id',
                'images' => 'nullable|array',
                'images.*.path' => 'nullable|string',
                'images.*.name' => 'nullable|string',
                'images.*.data' => 'nullable|string',
            ]);

            // Imágenes existentes que se conservarán
            $pathsToKeep = collect($request->images ?? [])
                ->filter(fn($img) => isset($img['path']))
                ->pluck('path')
                ->toArray();

            // Eliminar imágenes borradas por el usuario
            foreach ($product->images as $existingImage) {

                if (!in_array($existingImage->path, $pathsToKeep)) {

                    Storage::disk('s3')->delete($existingImage->path);

                    $existingImage->delete();

                    Log::info('Imagen eliminada: ' . $existingImage->path);
                }
            }

            // Guardar nuevas imágenes
            foreach ($request->images ?? [] as $img) {

                if (!empty($img['data']) && !empty($img['name'])) {

                    $imageName = time() . '_' . uniqid() . '_' . $img['name'];

                    $imageData = preg_replace(
                        '#^data:image/\w+;base64,#i',
                        '',
                        $img['data']
                    );

                    $imageData = str_replace(' ', '+', $imageData);

                    $path = 'images/' . $imageName;

                    Storage::disk('s3')->put(
                        $path,
                        base64_decode($imageData)
                    );

                    $product->images()->create([
                        'path' => $path,
                    ]);

                    Log::info('Imagen nueva guardada: ' . $path);
                }
            }

            // Actualizar producto
            $product->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'stock' => $data['stock'],
                'category_id' => $data['category_id'],
            ]);

            Log::info('Producto actualizado correctamente');

            return redirect()
                ->route('products.index')
                ->with('success', 'Producto actualizado correctamente');

        } catch (\Exception $e) {

            Log::error('Error en ProductController@update: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function destroy(Product $product)
    {
        try {

            foreach ($product->images as $image) {

                Storage::disk('s3')->delete($image->path);

                $image->delete();

                Log::info('Imagen eliminada: ' . $image->path);
            }

            $product->delete();

            return redirect()
                ->back()
                ->with('success', 'Producto e imágenes eliminados exitosamente.');

        } catch (\Exception $e) {

            Log::error('Error al eliminar producto: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Hubo un error al eliminar el producto.');
        }
    }

    public function showHome($id)
    {
        $product = Product::with('images')->findOrFail($id);

        $product->images->each(function ($image) {
            $image->url = Storage::disk('s3')->url($image->path);
        });

        return Inertia::render('Product/Show', [
            'product' => $product,
        ]);
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', '%' . $query . '%')->get();

        return Inertia::render('Product/SearchResults', [
            'products' => $products,
            'query' => $query,
        ]);
    }
    public function filterByCategory(Request $request, $categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();

        return Inertia::render('Inicio/NavBarCategories', [
            'products' => $products,
            'categoryId' => $categoryId,
        ]);
    }
    public function filterByPrice(Request $request, $minPrice, $maxPrice)
    {
        $products = Product::whereBetween('price', [$minPrice, $maxPrice])->get();

        return Inertia::render('Product/PriceProducts', [
            'products' => $products,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ]);
    }
    public function filterByStock(Request $request, $minStock, $maxStock)
    {
        $products = Product::whereBetween('stock', [$minStock, $maxStock])->get();

        return Inertia::render('Product/StockProducts', [
            'products' => $products,
            'minStock' => $minStock,
            'maxStock' => $maxStock,
        ]);
    }
    public function filterByDate(Request $request, $startDate, $endDate)
    {
        $products = Product::whereBetween('created_at', [$startDate, $endDate])->get();

        return Inertia::render('Product/DateProducts', [
            'products' => $products,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
    public function filterByRating(Request $request, $minRating, $maxRating)
    {
        $products = Product::whereBetween('rating', [$minRating, $maxRating])->get();

        return Inertia::render('Product/RatingProducts', [
            'products' => $products,
            'minRating' => $minRating,
            'maxRating' => $maxRating,
        ]);
    }
}
