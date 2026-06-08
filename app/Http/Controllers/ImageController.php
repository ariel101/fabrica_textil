<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    //
    use Illuminate\Support\Facades\Storage;

    public function index()
    {
        $images = Image::all();

        $images->each(function ($image) {
            $image->url = Storage::disk('s3')->url($image->path);
        });

        return Inertia::render('Images/Index', [
            'images' => $images,
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
        $imagePath = $request->file('path')->store('images', 's3');
        //dd($imagePath);
        $imageUrl = Storage::disk('s3')->url($imagePath);
        // Crear la imagen en la base de datos
        Image::create([
            'path' => $imagePath,
            'product_id' => $request->input('product_id'), // Asociar con el producto seleccionado
        ]);

        return redirect()->back()->with('success', 'Imagen creada exitosamente.');
    }
    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        // Eliminar archivo de S3
        if ($image->path) {
            Storage::disk('s3')->delete($image->path);
        }

        // Eliminar registro
        $image->delete();

        return redirect()
            ->back()
            ->with('success', 'Imagen eliminada exitosamente.');
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'product_id' => 'required|exists:products,id',
        ]);

        $image = Image::findOrFail($id);

        // Eliminar imagen anterior de S3
        if ($image->path && Storage::disk('s3')->exists($image->path)) {
            Storage::disk('s3')->delete($image->path);
        }

        // Subir nueva imagen
        $imagePath = $request->file('path')->store('images', 's3');

        // Actualizar registro
        $image->update([
            'path' => $imagePath,
            'product_id' => $request->input('product_id'),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Imagen actualizada exitosamente.');
    }
}
