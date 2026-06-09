@extends('layouts.app')

@section('title', 'Favorit Saya - MOODCOFFEE')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-amber-800 dark:text-amber-400">Menu Favoritku ❤️</h1>
    <p class="text-gray-600 dark:text-gray-300 mt-2">Koleksi kopi yang paling kamu sukai</p>
</div>

@if($favorites->isEmpty())
<div class="text-center py-12 bg-white dark:bg-gray-800 rounded-2xl shadow">
    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
    </svg>
    <p class="text-gray-500 dark:text-gray-400">Kamu belum punya menu favorit</p>
    <a href="{{ route('home') }}" class="inline-block mt-4 px-6 py-2 bg-amber-600 text-white rounded-full hover:bg-amber-700 transition">Lihat Menu</a>
</div>
@else
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($favorites as $favorite)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition">
        <div class="relative h-40 overflow-hidden rounded-t-2xl">
            <img src="{{ $favorite->menu->image_url ?? asset('images/coffee-placeholder.jpg') }}" class="w-full h-full object-cover">
        </div>
        <div class="p-5">
            <div class="flex justify-between">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">{{ $favorite->menu->name }}</h3>
                <button onclick="removeFavorite({{ $favorite->menu->id }})" class="text-red-500 hover:text-red-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">{{ Str::limit($favorite->menu->description, 80) }}</p>
            <div class="mt-3 flex justify-between items-center">
                <span class="text-xl font-bold text-amber-700 dark:text-amber-400">Rp {{ number_format($favorite->menu->price, 0, ',', '.') }}</span>
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $favorite->menu->id }}">
                    <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-full hover:bg-amber-700 transition text-sm">Pesan Sekarang</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<script>
function removeFavorite(menuId) {
    fetch(`/favorites/${menuId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ menu_id: menuId })
    }).then(() => location.reload());
}
</script>
@endsection