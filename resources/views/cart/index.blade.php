@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">My Cart 🛍️</h1>

    @if($carts->isEmpty())
        <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-2xl shadow">
            <p class="text-gray-500">Keranjang kosong, yuk pesan kopi!</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block px-6 py-2 bg-amber-600 text-white rounded-full">Pesan Sekarang</a>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
            @foreach($carts as $item)
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex flex-wrap md:flex-nowrap justify-between items-center gap-4">
                <div class="flex-1">
                    <h3 class="text-xl font-bold">{{ $item->menu->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $item->size }}, {{ $item->milk }}</p>
                    <div class="flex items-center gap-3 mt-2">
                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                            @csrf @method('PUT')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 px-2 py-1 border rounded-lg">
                            <button type="submit" class="ml-2 text-blue-600 text-sm">Update</button>
                        </form>
                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-semibold">Rp {{ number_format($item->quantity * $item->unit_price,0,',','.') }}</p>
                    <p class="text-xs text-gray-400">{{ $item->unit_price }} x {{ $item->quantity }}</p>
                </div>
            </div>
            @endforeach

            <div class="p-5 bg-gray-50 dark:bg-gray-700 flex justify-between items-center">
                <span class="text-xl font-bold">Total Payment</span>
                <span class="text-2xl font-extrabold text-amber-700">Rp {{ number_format($total,0,',','.') }}</span>
            </div>
            <div class="p-5 text-right">
                <a href="{{ route('checkout.form') }}" class="inline-block px-8 py-3 bg-amber-600 text-white rounded-full hover:bg-amber-700 transition shadow-lg">Payment →</a>
            </div>
        </div>
    @endif
</div>
@endsection