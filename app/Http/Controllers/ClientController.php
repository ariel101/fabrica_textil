<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::role('client')->paginate(10);

        return Inertia::render('Clients/Index', [
            'clients' => $clients,
        ]);
    }

    public function create()
    {
        return Inertia::render('Clients/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|regex:/^[\pL\s]+$/u|max:255',
            'username' => 'required|string|alpha_dash|max:50|unique:users,username',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'cellphone' => 'required|string|regex:/^[0-9]{8,20}$/|unique:users,cellphone',
            'identity_card' => 'required|string|regex:/^[0-9]{7,20}$/|unique:users,identity_card',
            'city' => 'required|string|in:La Paz,El Alto,Cochabamba,Santa Cruz,Sucre,Oruro,Potosi,Tarija,Beni,Pando',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'cellphone' => $data['cellphone'],
            'identity_card' => $data['identity_card'],
            'city' => $data['city'],
        ]);

        $user->assignRole('client');

        return redirect()->route('clients.index')->with('success', 'Cliente creado correctamente.');
    }

    public function edit($id)
    {
        $client = User::role('client')->findOrFail($id);

        return Inertia::render('Clients/Edit', [
            'client' => $client,
        ]);
    }

    public function update(Request $request, $id)
    {
        $client = User::role('client')->findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|regex:/^[\pL\s]+$/u|max:255',
            'username' => 'required|string|alpha_dash|max:50|unique:users,username,' . $client->id,
            'email' => 'required|string|lowercase|email|max:255|unique:users,email,' . $client->id,
            'cellphone' => 'required|string|regex:/^[0-9]{8,20}$/|unique:users,cellphone,' . $client->id,
            'identity_card' => 'required|string|regex:/^[0-9]{7,20}$/|unique:users,identity_card,' . $client->id,
            'city' => 'required|string|in:La Paz,El Alto,Cochabamba,Santa Cruz,Sucre,Oruro,Potosi,Tarija,Beni,Pando',
        ]);

        $client->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'cellphone' => $data['cellphone'],
            'identity_card' => $data['identity_card'],
            'city' => $data['city'],
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $client = User::role('client')->findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente eliminado correctamente.');
    }
}
