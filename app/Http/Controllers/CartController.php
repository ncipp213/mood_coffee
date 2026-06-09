<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CartController extends Controller implements HasMiddleware
{
    /**
     * Daftarkan middleware untuk controller ini.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index()
    {
        $carts = Auth::user()->carts()->with('menu')->get();
        $total = $carts->sum(fn($cart) => $cart->quantity * $cart->menu->price);
        return view('cart.index', compact('carts', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate(['menu_id' => 'required|exists:menus,id']);

        $cart = Cart::where('user_id', Auth::id())
                    ->where('menu_id', $request->menu_id)
                    ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'menu_id' => $request->menu_id,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Menu ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui!');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();
        return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang!');
    }

    public function checkout()
    {
        $carts = Auth::user()->carts()->with('menu')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        // Hapus semua item setelah checkout
        Auth::user()->carts()->delete();

        return redirect()->route('home')->with('success', 'Pesanan berhasil! Terima kasih sudah berbelanja.');
    }
    public function checkoutForm() {
        $carts = Auth::user()->carts()->with('menu')->get();
        return view('checkout.index', compact('carts'));
    }

    public function processCheckout(Request $request) {
        $request->validate([
            'order_type' => 'required|in:dine_in,take_away',
            'payment_method' => 'required|in:cash,qris'
        ]);

        $carts = Auth::user()->carts()->with('menu')->get();
        if($carts->isEmpty()) return back()->with('error', 'Keranjang kosong');

        $subtotal = $carts->sum(fn($c) => $c->quantity * $c->unit_price);
        $shipping = 2000;
        $total = $subtotal + $shipping;

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-'.strtoupper(uniqid()),
            'order_type' => $request->order_type,
            'payment_method' => $request->payment_method,
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'total' => $total,
            'status' => 'pending',
            'expires_at' => now()->addMinutes(10)
        ]);

        foreach($carts as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item->menu_id,
                'menu_name' => $item->menu->name,
                'milk' => $item->milk,
                'size' => $item->size,
                'quantity' => $item->quantity,
                'price' => $item->unit_price
            ]);
        }

        // Kosongkan keranjang
        Auth::user()->carts()->delete();

        return redirect()->route('payment.show', $order);
    }
}