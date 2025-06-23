<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Category;
use Spatie\Permission\Models\Role;

class AdminCategoriasTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Asegurar que exista el rol admin para todas las pruebas
        Role::firstOrCreate(['name' => 'admin']);
    }

    protected function crearAdmin()
    {
        $admin = User::factory()->create([
            'username' => 'admin_user',
            'email' => 'admin@example.com',
            'password' => bcrypt('adminpass'),
            'cellphone' => '1234567890',
            'identity_card' => '123456789',
            'city' => 'sucre',
        ]);
        $admin->assignRole('admin');

        return $admin;
    }

    /** @test */
    public function admin_puede_crear_una_categoria()
    {
        $admin = $this->crearAdmin();
        $this->actingAs($admin);

        $response = $this->post('/categories', [
            'nombre' => 'Decoración',
            'descripcion' => 'Categoría para productos de decoración',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', ['nombre' => 'Decoración', 'descripcion' => 'Categoría para productos de decoración']);
    }

    /** @test */
    // public function admin_puede_ver_lista_de_categorias()
    // {
    //     $admin = $this->crearAdmin();
    //     $this->actingAs($admin);

    //     Category::factory()->count(3)->create();

    //     $response = $this->get('/categories');

    //     $response->assertStatus(200);
    //     $response->assertSee(Category::first()->nombre);
    // }

    /** @test */
    public function admin_puede_editar_una_categoria()
    {
        $admin = $this->crearAdmin();
        $this->actingAs($admin);

        $categoria = Category::factory()->create(['nombre' => 'Original']);

        $response = $this->put("/categories/{$categoria->id}", [
            'nombre' => 'Actualizada',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', [
            'id' => $categoria->id,
            'nombre' => 'Actualizada',
        ]);
    }
}
