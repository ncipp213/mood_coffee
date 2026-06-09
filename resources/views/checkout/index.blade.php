@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Payment</h1>
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="grid md:grid-cols-2 gap-8">
            {{-- Kiri: Tipe & Metode --}}
            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                    <h2 class="text-xl font-semibold mb-3">Tipe Pemesanan</h2>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2"><input type="radio" name="order_type" value="dine_in" checked> <span>🍽️ DINE IN</span></label>
                        <label class="flex items-center gap-2"><input type="radio" name="order_type" value="take_away"> <span>🥡 TAKE AWAY</span></label>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                    <h2 class="text-xl font-semibold mb-3">Metode Pembayaran</h2>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2"><input type="radio" name="payment_method" value="cash" checked> <span>💰 BAYAR DI KASIR</span></label>
                        <label class="flex items-center gap-2"><input type="radio" name="payment_method" value="qris"> <span>📱 QRIS</span></label>
                    </div>
                </div>
            </div>

            {{-- Kanan: Ringkasan Pesanan --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                <h2 class="text-xl font-semibold mb-4">Pesanan Anda</h2>
                @php $subtotal = 0; @endphp
                @foreach($carts as $item)
                    @php $itemTotal = $item->quantity * $item->unit_price; $subtotal += $itemTotal; @endphp
                    <div class="border-b pb-3 mb-3">
                        <div class="flex justify-between">
                            <span>{{ $item->menu->name }} ({{ $item->size }}, {{ $item->milk }})</span>
                            <span>Rp {{ number_format($itemTotal,0,',','.') }}</span>
                        </div>
                        <div class="text-sm text-gray-500">Jumlah: {{ $item->quantity }}</div>
                    </div>
                @endforeach
                <div class="flex justify-between mt-2">
                    <span>Shipping cost</span>
                    <span>Rp 2.000</span>
                </div>
                <div class="flex justify-between mt-2 font-bold">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($subtotal,0,',','.') }}</span>
                </div>
                <div class="flex justify-between mt-4 text-xl font-extrabold text-amber-700">
                    <span>Total</span>
                    <span>Rp {{ number_format($subtotal + 2000,0,',','.') }}</span>
                </div>
                <button type="submit" class="w-full mt-6 py-3 bg-amber-600 text-white rounded-full hover:bg-amber-700">Konfirmasi & Bayar</button>
            </div>
        </div>
    </form>
</div>
@endsection