@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-8">❤️ Menu Favorit Kamu</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if($favorites->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($favorites as $menu)
                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                    <div class="h-40 bg-gradient-to-br from-amber-200 to-amber-400 relative">
                        <div class="absolute inset-0 flex items-center justify-center text-5xl">
                            ☕
                        </div>
                        <div class="absolute top-3 right-3 bg-amber-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                            ⭐ {{ $menu->rating }}
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-lg text-gray-800 dark:text-white">{{ $menu->name }}</h3>
                            <form action="{{ route('favorites.toggle', $menu) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-2xl hover:scale-110 transition">
                                    ❤️
                                </button>
                            </form>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">{{ Str::limit($menu->description, 80) }}</p>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-amber-600 dark:text-amber-400 font-bold text-xl">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                            <form action="{{ route('cart.add', $menu) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition">
                                    + Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 text-center">
                <div class="text-6xl mb-4">🤍</div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Belum Ada Favorit</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Klik ikon hati pada menu yang kamu sukai untuk menyimpannya di sini</p>
                <a href="{{ route('home') }}" class="inline-block bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition">
                    Lihat Menu Kopi
                </a>
            </div>
        @endif
    </div>
</div>
@endsection