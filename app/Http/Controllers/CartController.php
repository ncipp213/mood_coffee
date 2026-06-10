<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CartController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    // Menampilkan halaman keranjang
    public function index()
    {
        $carts = Auth::user()->carts()->with('menu')->get();
        $total = $carts->sum(fn($cart) => $cart->quantity * $cart->unit_price);
        return view('cart.index', compact('carts', 'total'));
    }

    // Menambahkan item ke keranjang (dengan milk, size, unit_price)
    public function store(Request $request)
    {
        $request->validate([
            'menu_id'    => 'required|exists:menus,id',
            'milk'       => 'required|string',
            'size'       => 'required|string',
            'unit_price' => 'required|numeric',
            'quantity'   => 'sometimes|integer|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())
                    ->where('menu_id', $request->menu_id)
                    ->where('milk', $request->milk)
                    ->where('size', $request->size)
                    ->first();

        if ($cart) {
            $cart->increment('quantity', $request->quantity ?? 1);
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'menu_id'    => $request->menu_id,
                'milk'       => $request->milk,
                'size'       => $request->size,
                'unit_price' => $request->unit_price,
                'quantity'   => $request->quantity ?? 1
            ]);
        }

        return redirect()->back()->with('success', 'Menu ditambahkan ke keranjang!');
    }

    // Mengupdate jumlah item di keranjang
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) abort(403);

        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui!');
    }

    // Menghapus item dari keranjang
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) abort(403);
        $cart->delete();
        return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang!');
    }

    // Menampilkan form checkout
    public function checkoutForm()
    {
        $carts = Auth::user()->carts()->with('menu')->get();
        return view('checkout.index', compact('carts'));
    }

    // Memproses checkout dan membuat order
    public function processCheckout(Request $request)
    {
        $request->validate([
            'order_type'     => 'required|in:dine_in,take_away',
            'payment_method' => 'required|in:cash,qris'
        ]);

        $carts = Auth::user()->carts()->with('menu')->get();
        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        $subtotal = $carts->sum(fn($c) => $c->quantity * $c->unit_price);
        $shipping = 2000;
        $total    = $subtotal + $shipping;

        $order = Order::create([
            'user_id'        => Auth::id(),
            'order_number'   => 'ORD-' . strtoupper(uniqid()),
            'order_type'     => $request->order_type,
            'payment_method' => $request->payment_method,
            'subtotal'       => $subtotal,
            'shipping_cost'  => $shipping,
            'total'          => $total,
            'status'         => 'pending',
            'expires_at'     => now()->addMinutes(10)
        ]);

        foreach ($carts as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'menu_id'    => $item->menu_id,
                'menu_name'  => $item->menu->name,
                'milk'       => $item->milk,
                'size'       => $item->size,
                'quantity'   => $item->quantity,
                'price'      => $item->unit_price
            ]);
        }

        // Kosongkan keranjang setelah checkout
        Auth::user()->carts()->delete();

        return redirect()->route('payment.show', $order);
    }
}