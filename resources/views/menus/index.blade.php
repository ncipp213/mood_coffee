@extends('layouts.app')

@section('title', 'Menu Kopi - MOODCOFFEE')

@section('content')
<div class="mb-8 text-center">
    <h1 class="text-4xl md:text-5xl font-bold text-amber-800 dark:text-amber-400 mb-4">Menu Kopi</h1>
    <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Temukan kopi favoritmu yang sesuai dengan mood hari ini</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($menus as $menu)
    <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:bg-gradient-to-br hover:from-amber-50 hover:to-white dark:hover:from-gray-700 dark:hover:to-gray-800">
        <div class="relative h-48 overflow-hidden">
            <img src="{{ $menu->image_url ?? asset('images/coffee-placeholder.jpg') }}" alt="{{ $menu->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            @auth
            <button onclick="toggleFavorite({{ $menu->id }})" class="favorite-btn-{{ $menu->id }} absolute top-3 right-3 bg-white/80 dark:bg-gray-800/80 rounded-full p-2 hover:bg-amber-100 dark:hover:bg-amber-900 transition">
                <svg class="w-5 h-5 text-red-500" fill="{{ Auth::user()->favorites->contains('menu_id', $menu->id) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
            @endauth
        </div>

        <div class="p-5">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">{{ $menu->name }}</h3>
                <div class="flex items-center bg-amber-100 dark:bg-amber-900 px-2 py-1 rounded-full">
                    <svg class="w-4 h-4 text-amber-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-amber-800 dark:text-amber-300">{{ $menu->rating }}</span>
                </div>
            </div>

            <p class="text-gray-500 dark:text-gray-400 text-sm mb-3 line-clamp-2">{{ $menu->description }}</p>

            <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-amber-700 dark:text-amber-400">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>

                @auth
                <form action="{{ route('cart.store') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-full hover:bg-amber-700 transition shadow-md hover:shadow-lg text-sm font-semibold">
                        + Keranjang
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-400 text-white rounded-full hover:bg-gray-500 transition text-sm font-semibold">
                    Login
                </a>
                @endauth
            </div>
        </div>
    </div>
    @endforeach
</div>

@auth
<!-- Admin Panel untuk CRUD Menu (hanya untuk user dengan role admin) -->
@if(auth()->user()->email === 'admin@moodcoffee.com')
<div class="mt-12 p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-4 text-amber-800 dark:text-amber-400">Admin Panel - Kelola Menu</h2>
    <a href="{{ route('menus.create') }}" class="inline-block px-6 py-3 bg-green-600 text-white rounded-full hover:bg-green-700 transition">+ Tambah Menu Baru</a>
    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $menu)
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $menu->name }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $menu->rating }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('menus.edit', $menu) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                        <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Hapus menu ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endauth

<script>
function toggleFavorite(menuId) {
    fetch(`/favorites/${menuId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ menu_id: menuId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'added') {
            document.querySelector(`.favorite-btn-${menuId} svg`).setAttribute('fill', 'currentColor');
        } else {
            document.querySelector(`.favorite-btn-${menuId} svg`).setAttribute('fill', 'none');
        }
    });
}
</script>
@endsection