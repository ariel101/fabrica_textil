<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Hilos y Materiales', 'description' => 'Materias primas como hilos y fibras.'],
            ['name' => 'Tejidos y Telas', 'description' => 'Diversos tipos de telas y tejidos.'],
            ['name' => 'Ropa Casual', 'description' => 'Prendas de vestir informales.'],
            ['name' => 'Ropa Formal', 'description' => 'Vestimenta de oficina y trajes.'],
            ['name' => 'Ropa Deportiva', 'description' => 'Productos para actividades deportivas.'],
            ['name' => 'Accesorios Textiles', 'description' => 'Complementos como bufandas y cinturones.'],
            ['name' => 'Ropa de Trabajo', 'description' => 'Uniformes especializados para trabajo.'],
            ['name' => 'Ropa Infantil', 'description' => 'Prendas diseñadas para niños y bebés.'],
            ['name' => 'Decoración Textil', 'description' => 'Productos textiles para el hogar.'],
            ['name' => 'Prototipos Especiales', 'description' => 'Diseños exclusivos en fase de prueba.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
