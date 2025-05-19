<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear el rol 'admin' si no existe
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crear el rol 'client' si no existe
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Crear el usuario admin
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'adminusername',
            'email' => 'admin@example.com',
            'cellphone' => '0987654321',
            'identity_card' => '123456789',
            'city' => 'City Name',
            'password' => bcrypt('adminpassword') // Cambia la contraseña por algo más seguro
        ]);
        $admin->assignRole('admin'); // Asignar el rol 'admin'

        // Crear el usuario client
        $client = User::create([
            'name' => 'Client User',
            'username' => 'clientusername',
            'email' => 'client@example.com',
            'cellphone' => '1234567890',
            'identity_card' => '987654321',
            'city' => 'City Name',
            'password' => bcrypt('clientpassword') // Cambia la contraseña por algo más seguro
        ]);
        $client->assignRole('client'); // Asignar el rol 'client'
    }
}
