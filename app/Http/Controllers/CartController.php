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
        //$cart = session()->get('cart', []); // obtenemos el carrito de la sesión
        $cart = array_values(session()->get('cart', []));

        // Calculamos el total general
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return Inertia::render('Cart/Index', [
            'carts' => $cart,
            'total' => $total,
        ]);
    }

    /**
     * Agregar un producto al carrito
     */
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');

        $cart = session()->get('cart', []);

        $product = Product::findOrFail($productId);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += 1;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                //'price' => $product->price,
                'price' => (float) $product->price,
                'quantity' => 1,
                'image' => $product->images[0]->path ?? null,
            ];
        }

        session()->put('cart', $cart);
        //dd(session()->get('cart'));
        //Log::info('Contenido actual del carrito:', session()->get('cart'));

        return response()->json(['success' => true, 'message' => 'Producto agregado al carrito']);
    }

    public function handle(Request $request, Closure $next)
    {
        $cart = session('cart', []);

        // Verificar el contenido del carrito
        Log::info('Contenido del carrito:', $cart);

        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        // Verificar el total de productos en el carrito
        Log::info('Total de productos en el carrito:', $totalQuantity);

        Inertia::share('cartCount', $totalQuantity); // 👈 Esto hace que cartCount esté disponible en TODO

        return $next($request);
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
