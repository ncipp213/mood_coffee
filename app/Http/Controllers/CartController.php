<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->get();
        } else {
            $sessionId = session()->getId();
            $cartItems = Cart::where('session_id', $sessionId)->get();
        }
        
        $total = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
        return view('cart', compact('cartItems', 'total'));
    }

    public function add(Menu $menu)
    {
        $quantity = request()->input('quantity', 1);
        
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())
                        ->where('menu_id', $menu->id)
                        ->first();
                        
            if ($cart) {
                $cart->increment('quantity', $quantity);
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'price' => $menu->price,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            $sessionId = session()->getId();
            $cart = Cart::where('session_id', $sessionId)
                        ->where('menu_id', $menu->id)
                        ->first();
                        
            if ($cart) {
                $cart->increment('quantity', $quantity);
            } else {
                Cart::create([
                    'session_id' => $sessionId,
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'price' => $menu->price,
                    'quantity' => $quantity,
                ]);
            }
        }
        
        return redirect()->route('cart.index')->with('success', "{$menu->name} ditambahkan ke keranjang!");
    }

    public function update($id)
    {
        $quantity = request()->input('quantity', 1);
        $cart = Cart::findOrFail($id);
        
        // Cek kepemilikan
        if (Auth::check() && $cart->user_id != Auth::id()) {
            abort(403);
        }
        if (!Auth::check() && $cart->session_id != session()->getId()) {
            abort(403);
        }
        
        if ($quantity <= 0) {
            $cart->delete();
        } else {
            $cart->update(['quantity' => $quantity]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui!');
    }

    public function remove($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        
        return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang!');
    }

    public function clear()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            Cart::where('session_id', session()->getId())->delete();
        }
        
        return redirect()->route('cart.index')->with('success', 'Keranjang kosong!');
    }
}