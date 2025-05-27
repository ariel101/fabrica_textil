<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Mostrar el carrito del usuario autenticado
     */
    public function index()
    {
       return Inertia::render('Cart/Index');
    }



    /**
     * Eliminar un producto del carrito
     */
    public function removeFromCart($productId)
    {
        $user = auth()->guard('web')->user();
        $cart = $user->cart;

        if ($cart) {
            $cart->products()->detach($productId);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully.');
    }

    /**
     * Vaciar el carrito completo
     */
    public function clearCart()
    {
        $user = auth()->guard('web')->user();
        $cart = $user->cart;

        if ($cart) {
            $cart->products()->detach();
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully.');
    }
}
