<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Spatie\Permission\Models\Role;
use PHPUnit\Framework\Attributes\Test;

class AdminProductosTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Asegurarse de que exista el rol 'admin'
        Role::firstOrCreate(['name' => 'admin']);
    }

    protected function crearAdmin(): User
    {
        $admin = User::factory()->create([
            'username' => 'admin_user',
            'email' => 'admin@example.com',
            'password' => bcrypt('adminpass'),
        ]);

        $admin->assignRole('admin');

        return $admin;
    }

    #[Test]
    public function admin_puede_crear_un_producto(): void
    {
        $admin = $this->crearAdmin();
        $this->actingAs($admin);

        $categoria = Category::factory()->create();

        $response = $this->post('/products', [
            'name' => 'Lazo Rojo',
            'description' => 'Lazo de color rojo brillante',
            'price' => 20,
            'category_id' => $categoria->id,
            'stock' => 50,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('products', [
            'name' => 'Lazo Rojo',
            'price' => 20,
            'category_id' => $categoria->id,
        ]);
    }
}
