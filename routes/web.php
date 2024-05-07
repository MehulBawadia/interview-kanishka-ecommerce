<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\UserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('products', [PagesController::class, 'allProducts'])->name('pages.products');

    Route::name('cart')->prefix('cart')->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('.index');
        Route::post('/add/{productId}', 'add')->name('.add');
        Route::put('/{cartId}', 'update')->name('.update');
        Route::delete('/{cartId}', 'destroy')->name('.destroy');
    });

    Route::name('checkout')->prefix('checkout')->controller(CheckoutController::class)->group(function () {
        Route::get('/', 'index')->name('.index');
        Route::post('/place-order', 'placeOrder')->name('.placeOrder');
    });
});

require __DIR__ . '/auth.php';

Route::name('admin')->prefix('admin')->middleware(UserIsAdmin::class)->group(function () {
    Route::name('.products')->prefix('products')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('.index');
        Route::get('/create', 'create')->name('.create');
        Route::post('/store', 'store')->name('.store');
        Route::get('/{product}/edit', 'edit')->name('.edit');
        Route::put('/{product}', 'update')->name('.update');
        Route::delete('/{product}', 'destroy')->name('.destroy');
    });
});
