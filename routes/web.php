<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoffeeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;

// Route untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route untuk pengguna yang sudah login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [CoffeeController::class, 'index'])->name('home');
    // routes lainnya akan kita tambahkan nanti
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{coffeeId}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{cartId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cartId}', [CartController::class, 'remove'])->name('cart.remove');