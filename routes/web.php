<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoffeeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;

// Guest routes (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/guest-login', [AuthController::class, 'guestLogin'])->name('guest.login');
});

// Auth routes (sudah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/theme', [AuthController::class, 'storeTheme'])->name('theme.store');

    Route::get('/', [CoffeeController::class, 'index'])->name('home');

    // Favorites
    Route::prefix('favorites')->group(function () {
        Route::get('/', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/toggle/{coffeeId}', [FavoriteController::class, 'toggle']);
        Route::delete('/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    });

    // Cart
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add/{coffeeId}', [CartController::class, 'add']);
        Route::put('/update/{cartId}', [CartController::class, 'update']);
        Route::delete('/remove/{cartId}', [CartController::class, 'remove']);
        Route::get('/totals', [CartController::class, 'getTotals']); // tambahan untuk update total via AJAX
    });

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
    });
});