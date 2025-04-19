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
            ['nombre' => 'Cintas_e_Hilados', 'descripcion' => 'Variedad de cintas e hilados para confección.'],
            ['nombre' => 'Cordoneria', 'descripcion' => 'Cordones y soguillas decorativas.'],
            ['nombre' => 'Elasticos', 'descripcion' => 'Elásticos de diferentes anchos y grosores.'],
            ['nombre' => 'Flecaduras_y_Decorativos', 'descripcion' => 'Accesorios y acabados decorativos.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
