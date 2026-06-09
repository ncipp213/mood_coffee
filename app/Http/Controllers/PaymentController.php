<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id != Auth::id()) abort(403);
        return view('payment.confirmation', compact('order'));
    }

    public function status(Order $order)
    {
        // Simulasi cek status pembayaran (dalam reality nanti diupdate oleh kasir atau webhook)
        // Kita hanya menampilkan status saat ini
        return view('payment.status', compact('order'));
    }

    // Untuk simulasi pembayaran manual (opsional)
    public function markAsPaid(Order $order)
    {
        if ($order->user_id != Auth::id()) abort(403);
        $order->update(['status' => 'paid']);
        return redirect()->route('payment.status', $order)->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}