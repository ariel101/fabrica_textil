<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'auth' => [
            'user' => Auth::user(),
        ],
    ]);
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('clients', ClientController::class)->except(['show']);

});

Route::get('/', [ProductController::class, 'indexHome'])->name('products.indexHome');
//Route::get('/', [CategoryController::class, 'filtrarPorCategoria'])->name('products.index');
Route::get('product/{id}', [ProductController::class, 'showHome'])->name('products.showHome');
Route::get('/category/{id?}', [CategoryController::class, 'filtrarPorCategoria'])->name('products.filtrarPorCategoria');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
//Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

require __DIR__ . '/auth.php';
