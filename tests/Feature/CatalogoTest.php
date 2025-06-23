<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Category;

class CatalogoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    

public function cliente_puede_ver_el_catalogo_de_productos()
{
    $categoria = Category::factory()->create();

    Product::factory()->count(3)->create([
        'category_id' => $categoria->id,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee(Product::first()->nombre);
}

public function cliente_puede_ver_detalles_de_un_producto()
{
    $categoria = Category::factory()->create();

    $producto = Product::factory()->create([
        'name' => 'Cinta Decorativa',
        'description' => 'Ideal para envolver regalos.',
        'price' => 15.99,
        'category_id' => $categoria->id,
        'stock' => 100,
    ]);

    $response = $this->get("/{$producto->id}");

    $response->assertStatus(200);
    $response->assertSee('Cinta Decorativa');
    $response->assertSee('Ideal para envolver regalos.');
}

}
