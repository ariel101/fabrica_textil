<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|regex:/^[\pL\s]+$/u|max:255',
            'username' => 'required|string|alpha_dash|max:50|unique:users,username',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cellphone' => 'required|string|regex:/^[0-9]{8,20}$/|unique:users,cellphone',
            'identity_card' => 'required|string|regex:/^[0-9]{7,20}$/|unique:users,identity_card',
            'city' => 'required|string|in:La Paz,El Alto,Cochabamba,Santa Cruz,Sucre,Oruro,Potosi,Tarija,Beni,Pando,',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cellphone' => $request->cellphone,
            'identity_card' => $request->identity_card,
            'city' => $request->city,
        ]);

        // Asignar automáticamente el rol "client" al nuevo usuario
        $user->assignRole('client');

        event(new Registered($user));

        Auth::login($user);

        // Redirigir basado en el rol
        if ($user->hasRole('admin')) {
            return redirect(route('dashboard', absolute: false));
        } else {
            return redirect()->intended('/');
        }

        //return redirect(route('dashboard', absolute: false));
    }
}
