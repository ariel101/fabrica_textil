<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    function index()
    {
        $products = Product::all();
        return Inertia::render('Product/Index', [
            'products' => $products
        ]);
    }

    function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id', // Validar que la categoría exista
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Guardar la imagen en el disco
        $imagePath = $request->file('image')->store('images', 'public');

        // Crear el producto en la base de datos
        Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'category_id' => $request->input('category_id'), // Asociar con la categoría seleccionada
            'image_path' => 'storage/' . $imagePath,
        ]);

        return redirect()->back()->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
        ]);
    }
    public function update(Request $request, Product $product)
    {
        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id', // Validar que la categoría exista
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Actualizar el producto en la base de datos
        $product->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'category_id' => $request->input('category_id'), // Asociar con la categoría seleccionada
        ]);

        // Si se subió una nueva imagen, actualizarla
        if ($request->hasFile('image')) {
            // Guardar la nueva imagen en el disco
            $imagePath = $request->file('image')->store('images', 'public');
            $product->update(['image_path' => 'storage/' . $imagePath]);
        }

        return redirect()->back()->with('success', 'Producto actualizado exitosamente.');
    }
    public function destroy(Product $product)
    {
        // Eliminar el producto de la base de datos
        $product->delete();

        return redirect()->back()->with('success', 'Producto eliminado exitosamente.');
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);

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

        return Inertia::render('Product/CategoryProducts', [
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
