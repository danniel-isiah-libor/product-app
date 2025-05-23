<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'index'])
        ->name('dashboard');

    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->name('products.show');

    Route::resource('/carts', CartController::class)->except(['show']);
    Route::get('/carts/{product}', [CartController::class, 'show'])
        ->name('carts.show');

    Route::resource('/transactions', TransactionController::class)->except(['create', 'destroy', 'edit', 'update']);
    Route::get('/checkout', [TransactionController::class, 'create'])
        ->name('checkout.create');
});

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
