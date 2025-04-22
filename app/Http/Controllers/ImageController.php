<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImageController extends Controller
{
    //
    public function index(){
        $index = Image::all();
        return Inertia::render('Images/Index', [
            'images' => $index,
        ]);
    }

    public function create(){
        return Inertia::render('Images/Create');
    }
    public function store(Request $request){
        // Validar los datos
        $request->validate([
            'path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'product_id' => 'required|exists:products,id', // Validar que el producto exista
        ]);

        // Guardar la imagen en el disco
        $imagePath = $request->file('path')->store('images', 'public');

        // Crear la imagen en la base de datos
        Image::create([
            'path' => 'storage/' . $imagePath,
            'product_id' => $request->input('product_id'), // Asociar con el producto seleccionado
        ]);

        return redirect()->back()->with('success', 'Imagen creada exitosamente.');
    }
    public function destroy($id){
        $image = Image::findOrFail($id);
        $image->delete();
        return redirect()->back()->with('success', 'Imagen eliminada exitosamente.');
    }
    public function show($id){
        $image = Image::findOrFail($id);
        return Inertia::render('Images/Show', [
            'image' => $image,
        ]);
    }
    public function edit($id){
        $image = Image::findOrFail($id);
        return Inertia::render('Images/Edit', [
            'image' => $image,
        ]);
    }
    public function update(Request $request, $id){
        // Validar los datos
        $request->validate([
            'path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'product_id' => 'required|exists:products,id', // Validar que el producto exista
        ]);

        // Guardar la imagen en el disco
        $imagePath = $request->file('path')->store('images', 'public');

        // Actualizar la imagen en la base de datos
        $image = Image::findOrFail($id);
        $image->update([
            'path' => 'storage/' . $imagePath,
            'product_id' => $request->input('product_id'), // Asociar con el producto seleccionado
        ]);

        return redirect()->back()->with('success', 'Imagen actualizada exitosamente.');
    }
}
