@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-amber-800 dark:text-amber-400 mb-6">❤️ Menu Favoritku</h1>

    @if($favorites->isEmpty())
        {{-- Empty state dengan gaya glassmorphism agar senada --}}
        <div class="text-center py-12 bg-white/40 dark:bg-gray-900/40 backdrop-blur-md border border-white/60 dark:border-gray-700/40 rounded-2xl shadow">
            <p class="text-gray-500 dark:text-gray-400">Kamu belum punya favorit. Tambahkan dari detail menu!</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block px-6 py-2 bg-amber-600 text-white rounded-full">Lihat Menu</a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($favorites as $favorite)
            {{-- Dibungkus tag <a> block group agar identik dengan interaksi di halaman utama --}}
            <a href="{{ route('menus.show', $favorite->menu->id) }}" class="block group relative">
                
                {{-- STRUKTUR UTAMA KARTU (Sama persis dengan template halaman awal Anda) --}}
                <div class="bg-white/40 dark:bg-gray-900/40 backdrop-blur-md border border-white/60 dark:border-gray-700/40 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    
                    {{-- Tombol Hapus dari Favorit (Diproteksi stopPropagation agar tidak memicu link detail) --}}
                    <button onclick="event.stopPropagation(); event.preventDefault(); removeFavorite({{ $favorite->menu->id }})" class="absolute top-2 right-2 z-10 bg-white/80 dark:bg-gray-800/80 rounded-full p-1 text-red-500 hover:bg-red-100 dark:hover:bg-gray-700 transition shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    {{-- Gambar Menu --}}
                    <div class="h-36 overflow-hidden">
                        <img src="{{ $favorite->menu->image_url ?? 'https://picsum.photos/id/225/300/200' }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                    </div>
                    
                    {{-- Konten Teks --}}
                    <div class="p-3">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-gray-800 dark:text-white">{{ $favorite->menu->name }}</h3>
                            
                            {{-- Rating Bintang Kuning Sesuai Layout Awal --}}
                            <div class="flex items-center text-yellow-500">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-xs ml-1">{{ $favorite->menu->rating ?? '4.8' }}</span>
                            </div>
                        </div>
                        
                        {{-- Deskripsi Ringkas --}}
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ Str::limit($favorite->menu->description, 50) }}</p>
                        
                        {{-- Harga Menu --}}
                        <div class="mt-2 font-bold text-amber-700 dark:text-amber-400">
                            Rp {{ number_format($favorite->menu->price, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </a>
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