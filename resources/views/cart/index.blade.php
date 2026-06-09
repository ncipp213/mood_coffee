@extends('layouts.app')

@section('title', 'Keranjang Belanja - MOODCOFFEE')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-amber-800 dark:text-amber-400">Keranjang Belanja 🛒</h1>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
@endif

@if($carts->isEmpty())
<div class="text-center py-12 bg-white dark:bg-gray-800 rounded-2xl shadow">
    <svg class="w-32 h-32 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 1.5M17 13l1.5 1.5M9 21h6M9 21a2 2 0 11-4 0m4 0a2 2 0 104 0m-4 0h4m-4 0a2 2 0 114 0"></path>
    </svg>
    <p class="text-gray-500 dark:text-gray-400 mb-4">Keranjang belanja masih kosong</p>
    <a href="{{ route('home') }}" class="px-6 py-3 bg-amber-600 text-white rounded-full hover:bg-amber-700 transition">Mulai Belanja</a>
</div>
@else
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Menu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($carts as $item)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <img src="{{ $item->menu->image_url ?? asset('images/coffee-placeholder.jpg') }}" class="w-12 h-12 rounded-full object-cover mr-3">
                            <span class="font-medium text-gray-800 dark:text-white">{{ $item->menu->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">Rp {{ number_format($item->menu->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                            @csrf @method('PUT')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-20 px-2 py-1 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                            <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm">Update</button>
                        </form>
                    </td>
                    <td class="px-6 py-4 font-semibold">Rp {{ number_format($item->quantity * $item->menu->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-800 dark:text-white">Total:</td>
                    <td class="px-6 py-4 text-2xl font-bold text-amber-700 dark:text-amber-400">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="p-6 bg-gray-50 dark:bg-gray-700 flex justify-end space-x-4">
        <a href="{{ route('home') }}" class="px-6 py-3 border border-amber-600 text-amber-600 rounded-full hover:bg-amber-50 transition">Tambah Lagi</a>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="px-6 py-3 bg-amber-600 text-white rounded-full hover:bg-amber-700 transition shadow-md">Checkout Sekarang</button>
        </form>
    </div>
</div>
@endif
@endsection