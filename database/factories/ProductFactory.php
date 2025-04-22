<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtener las imágenes desde la carpeta storage/app/public/images
        //$path = storage_path('app/public/images'); // Ruta a las imágenes
        // $files = File::files($path); // Obtener los archivos de imágenes
        // $filenames = array_map(fn($file) => $file->getFilename(), $files); // Extraer los nombres de los archivos

        return [
            'name' => $this->faker->words(3, true), // Genera un nombre ficticio
            'description' => $this->faker->sentence(), // Genera una descripción aleatoria
            'price' => $this->faker->randomFloat(2, 1, 1000), // Precio entre 1 y 1000 con 2 decimales
            'stock' => $this->faker->numberBetween(0, 500), // Stock entre 0 y 500
            // 'image_path' => !empty($filenames) 
            //     ? 'storage/images/' . $this->faker->randomElement($filenames) 
            //     : null, // Seleccionar una imagen aleatoria o dejar null si no hay imágenes
            'category_id' => Category::inRandomOrder()->first()->id // Seleccionar un ID aleatorio de categorías
        ];
        
    }
}
