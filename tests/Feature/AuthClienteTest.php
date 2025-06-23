<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AuthClienteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    // public function cliente_puede_registrarse()
    // {
    //     $response = $this->post('/register', [
    //         'name' => 'ana',
    //         'username' => 'Ana123',
    //         'email' => 'ana@example.com',
    //         'password' => 'secret123',
    //         'password_confirmation' => 'secret123',
    //         'cellphone' => '12567890',
    //         'identity_card' => '765096789',
    //         'city' => 'Sucre',
    //     ]);

    //     $response->assertRedirect('/');
    //     $this->assertDatabaseHas('users', [
    //         'email' => 'ana@example.com',
    //         'name' => 'ana',
    //         'username' => 'Ana123',]);
    // }

    /** @test */
    public function cliente_puede_iniciar_sesion()
    {
        $user = User::factory()->create(['password' => bcrypt('12345678')]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '12345678',
        ]);

        $this->assertAuthenticatedAs($user);
    }
}
