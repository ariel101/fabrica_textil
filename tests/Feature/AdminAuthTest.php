<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_puede_iniciar_sesion()
    {
        // Crear el rol 'admin' si aún no existe
        Role::firstOrCreate(['name' => 'admin']);

        // Crear usuario y asignar rol
        $admin = User::factory()->create([
            'username' => 'admin_user',
            'email' => 'administrator@example.com',
            'password' => bcrypt('adminpass'),
            'cellphone' => '1234567890',
            'identity_card' => '123456789',
            'city' => 'sucre',
        ]);
        $admin->assignRole('admin');

        // Simular intento de login
        $response = $this->post('/login', [
            'email' => 'administrator@example.com',
            'password' => 'adminpass',
        ]);

        // Verificar resultados
        $response->assertRedirect('/admin/dashboard'); // Ajusta según tu ruta de redirección
        $this->assertAuthenticatedAs($admin);
        $this->assertTrue($admin->hasRole('admin'));
    }
}
