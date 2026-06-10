@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-amber-800 dark:text-amber-400 mb-6">❤️ Menu Favoritku</h1>

    @if($favorites->isEmpty())
        <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-2xl shadow">
            <p class="text-gray-500">Kamu belum punya favorit. Tambahkan dari detail menu!</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block px-6 py-2 bg-amber-600 text-white rounded-full">Lihat Menu</a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($favorites as $favorite)
            <div class="bg-amber-100 dark:bg-stone-700 rounded-xl shadow-md overflow-hidden relative">
                <button onclick="removeFavorite({{ $favorite->menu->id }})" class="absolute top-2 right-2 bg-white/80 rounded-full p-1 text-red-500 hover:bg-red-100">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div class="h-36 overflow-hidden">
                    <img src="{{ $favorite->menu->image_url ?? 'https://picsum.photos/id/225/300/200' }}" class="w-full h-full object-cover">
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-gray-800 dark:text-white">{{ $favorite->menu->name }}</h3>
                    <p class="text-xs text-gray-500 line-clamp-2">{{ Str::limit($favorite->menu->description, 50) }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="font-bold text-amber-700">Rp {{ number_format($favorite->menu->price,0,',','.') }}</span>
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $favorite->menu->id }}">
                            <input type="hidden" name="milk" value="Classic">
                            <input type="hidden" name="size" value="370ml">
                            <input type="hidden" name="unit_price" value="{{ $favorite->menu->price }}">
                            <button type="submit" class="px-3 py-1 bg-amber-600 text-white rounded-full text-xs">Pesan</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

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