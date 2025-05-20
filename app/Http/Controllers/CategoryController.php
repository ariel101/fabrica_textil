<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Categoría creada');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada');
    }


    public function filtrarPorCategoria($categoriaId = null)
    {
        $categorias = Category::all();

        $productos = $categoriaId
            ? Product::where('category_id', $categoriaId)->with('images')->get()
            : Product::with('images')->get();

        return Inertia::render('Product/Index', [
            'categories' => $categorias,
            'products' => $productos,
            'selectedCategory' => $categoriaId,
        ]);
    }
}
