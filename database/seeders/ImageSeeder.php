<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('app/public/images');
        $files = File::files($path);

        foreach ($files as $file) {
            $filename = $file->getFilename();

            DB::table('images')->insert([
                'path' => 'storage/images/' . $filename,
                'product_id' => Product::inRandomOrder()->first()->id, // Asigna un producto aleatorio
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
