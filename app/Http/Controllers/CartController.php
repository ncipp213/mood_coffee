<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Coffee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->carts()->get(); // Tambah tanda kurung dan ->get()
        $total = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        return view('cart.index', compact('cartItems', 'total'));
        }
    
    public function add(int $coffeeId, Request $request)
    {
        $request->validate(['milk' => 'required', 'size' => 'required']);
        $coffee = Coffee::findOrFail($coffeeId);
        $price = (int) filter_var($coffee->price, FILTER_SANITIZE_NUMBER_INT);
        // tambahkan biaya ukuran
        $sizeExtra = ['Small'=>0, 'Medium'=>5000, 'Large'=>10000][$request->size];
        Cart::create([
            'cart_id' => (string) Str::uuid(),
            'user_id' => Auth::id(),
            'name' => $coffee->name,
            'image_url' => $coffee->image_url,
            'milk' => $request->milk,
            'size' => $request->size,
            'price' => $price + $sizeExtra,
            'quantity' => 1
        ]);
        return response()->json(['success' => true]);
    }
    
    public function update(int $cartId, Request $request)
    {
        $cart = Cart::findOrFail($cartId);
        Gate::authorize('update', $cart);
        $cart->update(['quantity' => $request->quantity]);
        return response()->json(['success' => true]);
    }
    
    public function remove(int $cartId)
    {
        $cart = Cart::findOrFail($cartId);
        Gate::authorize('delete', $cart);
        $cart->delete();
        return response()->json(['success' => true]);
    }

    public function getTotals()
    {
        $cartItems = Auth::user()->carts;
        $totalQuantity = Auth::user()->carts()->sum('quantity');
        $totalPrice = Auth::user()->carts()->sum(DB::raw('price * quantity'));
        return response()->json([
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice
        ]);
    }
}