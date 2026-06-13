@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 py-8 text-center">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 text-gray-900 dark:text-white">
        <div class="mb-4">
            @if($order->status == 'paid')
                <div class="text-green-600 text-6xl mb-2">✅</div>
                <h2 class="text-2xl font-bold text-green-700 dark:text-green-400">Pembayaran Berhasil!</h2>
                <p class="text-gray-600 dark:text-gray-300 mt-2">Terima kasih, pesanan Anda sedang diproses.</p>
            @else
                <div class="text-amber-600 text-6xl mb-2">⏳</div>
                <h2 class="text-2xl font-bold text-amber-700 dark:text-amber-400">Menunggu Pembayaran</h2>
                <p class="text-gray-600 dark:text-gray-300 mt-2">Silakan selesaikan pembayaran Anda.</p>
            @endif
        </div>

        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl text-left text-gray-800 dark:text-white">
            <div class="flex justify-between border-b dark:border-gray-600 pb-2">
                <span>Order Number</span>
                <span class="font-mono">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between border-b dark:border-gray-600 pb-2 mt-2">
                <span>Total</span>
                <span>Rp {{ number_format($order->total,0,',','.') }}</span>
            </div>
            <div class="flex justify-between pt-2">
                <span>Status</span>
                <span class="capitalize font-semibold {{ $order->status == 'paid' ? 'text-green-600 dark:text-green-400' : 'text-amber-600 dark:text-amber-400' }}">{{ $order->status }}</span>
            </div>
        </div>

        @if($order->status != 'paid')
            <form action="{{ route('payment.markPaid', $order) }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="w-full py-3 bg-amber-600 text-white rounded-full hover:bg-amber-700 transition">
                    Simulasi Pembayaran (Demo)
                </button>
            </form>
        @endif

        <a href="{{ route('home') }}" class="block mt-4 text-amber-600 dark:text-amber-400 underline">Kembali ke Beranda</a>
    </div>
</div>
@endsection