<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Category;
use PHPUnit\Framework\Attributes\Test;

class BusquedaYFiltroTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function cliente_puede_buscar_un_producto(): void
    {
        // Se asegura que haya una categoría por detrás
        $categoria = Category::factory()->create();

        Product::factory()->create([
            'name' => 'Lazo Azul',
            'category_id' => $categoria->id,
        ]);

        Product::factory()->create([
            'name' => 'Pegatina',
            'category_id' => $categoria->id,
        ]);

        $response = $this->get('/?search=Lazo');

        $response->assertStatus(200);
        $response->assertSee('Lazo Azul');
        $response->assertDontSee('Pegatina');
    }

    #[Test]
    public function cliente_puede_filtrar_por_categoria(): void
    {
        $categoriaCintas = Category::factory()->create(['nombre' => 'Cintas']);
        $categoriaOtros = Category::factory()->create(['nombre' => 'Otros']);

        $productoCinta = Product::factory()->create([
            'name' => 'Cinta Roja',
            'category_id' => $categoriaCintas->id,
        ]);

        Product::factory()->create([
            'name' => 'Bolsa',
            'category_id' => $categoriaOtros->id,
        ]);

        $response = $this->get('/?category_id=' . $categoriaCintas->id);

        $response->assertStatus(200);
        $response->assertSee('Cinta Roja');
        $response->assertDontSee('Bolsa');
    }
}
