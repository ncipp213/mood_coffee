@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-8">🛒 Keranjang Belanja</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if($cartItems->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                @foreach($cartItems as $item)
                <div class="border-b border-gray-200 dark:border-gray-700 p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-800 dark:to-amber-700 rounded-xl flex items-center justify-center text-2xl">
                                ☕
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">{{ $item->menu_name }}</h3>
                                <p class="text-amber-600 dark:text-amber-400 font-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <button type="button" onclick="updateQuantity(this, -1)" class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition">-</button>
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="0" class="w-16 text-center border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800" onchange="this.form.submit()">
                                <button type="button" onclick="updateQuantity(this, 1)" class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition">+</button>
                            </form>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                    <span class="text-xl font-bold text-gray-800 dark:text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 flex justify-end">
                    <form action="{{ route('cart.clear') }}" method="POST" class="inline mr-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 border border-red-500 text-red-500 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                            Kosongkan
                        </button>
                    </form>
                    <a href="{{ route('home') }}" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                        Lanjutkan Pesanan →
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 text-center">
                <div class="text-6xl mb-4">🛒</div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Keranjang Kosong</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Belum ada menu yang ditambahkan ke keranjang</p>
                <a href="{{ route('home') }}" class="inline-block bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function updateQuantity(btn, delta) {
    const form = btn.closest('form');
    const input = form.querySelector('input[name="quantity"]');
    let newVal = parseInt(input.value) + delta;
    if (newVal < 0) newVal = 0;
    input.value = newVal;
    form.submit();
}
</script>
@endpush
@endsection