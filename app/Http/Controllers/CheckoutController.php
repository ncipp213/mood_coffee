<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function direct(Request $request)
    {
        // Validasi input
        $request->validate([
            'menu_id'     => 'required|exists:menus,id',
            'quantity'    => 'required|integer|min:1',
            'milk'        => 'nullable|string',
            'size'        => 'nullable|string',
            'unit_price'  => 'required|numeric',
        ]);

        // Ambil data menu
        $menu = Menu::findOrFail($request->menu_id);

        // Siapkan data item untuk checkout langsung
        $item = [
            'menu_id'     => $menu->id,
            'name'        => $menu->name,
            'quantity'    => $request->quantity,
            'unit_price'  => $request->unit_price,
            'milk'        => $request->milk,
            'size'        => $request->size,
            'subtotal'    => $request->quantity * $request->unit_price,
        ];

        // Simpan ke session sebagai "direct_checkout_item"
        // (bisa juga disimpan ke temporary table, tapi session cukup)
        Session::put('direct_checkout_item', $item);

        // Redirect ke halaman checkout (misal route 'checkout.index')
        return redirect()->route('checkout.index');
    }
}
