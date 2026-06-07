<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Coffee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{

    public function index()
    {
        // Ambil semua cart item milik user yang sedang login
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $cartItems = $user->carts;

        $total = 0;
        foreach ($cartItems as $item) {
            $price = (int) filter_var($item->price, FILTER_SANITIZE_NUMBER_INT);
            $total += $price * $item->quantity;
        }

        return view('cart.index', compact('cartItems', 'total'));
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(int $coffeeId, Request $request)
    {
        // Validasi opsi dari form
        $request->validate([
            'milk' => 'required|string',
            'size' => 'required|string',
        ]);

        $coffee = Coffee::findOrFail($coffeeId);
        
        // Buat ID unik untuk item keranjang
        $cartId = (string) Str::uuid();
        
        // Harga dalam bentuk integer untuk perhitungan
        $priceInt = (int) filter_var($coffee->price, FILTER_SANITIZE_NUMBER_INT);
        
        Cart::create([
            'cart_id' => $cartId,
            'user_id' => Auth::id(),
            'name' => $coffee->name,
            'image_url' => $coffee->image_url,
            'milk' => $request->milk,
            'size' => $request->size,
            'price' => $priceInt,
            'quantity' => 1,
        ]);
        
        return redirect()->route('cart.index')->with('success', 'Item berhasil ditambahkan ke keranjang!');
    }


}
