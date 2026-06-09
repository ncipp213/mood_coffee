@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Sapaan di sebelah kiri --}}
    <div class="mb-10">
        <h1 class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-amber-600 to-amber-800 bg-clip-text text-transparent">
            Hey, {{ Auth::user()->name ?? 'Coffee Lover' }} ☕
        </h1>
        <p class="text-gray-600 dark:text-gray-300 text-lg mt-2">Pilih seduhan favoritmu</p>
    </div>

    {{-- Search Bar --}}
    <div class="mb-12 max-w-md">
        <div class="relative">
            <input type="text" id="searchInput" placeholder="Cari kopi..." 
                   class="w-full pl-12 pr-4 py-3 rounded-full border border-amber-200 dark:border-gray-600 bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm focus:ring-2 focus:ring-amber-400 focus:outline-none">
            <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    {{-- Grid Menu --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="menuGrid">
        @php
            // Dummy data untuk 20 menu kopi
            $dummyMenus = [
                ['name' => 'Espresso', 'price' => 18000, 'rating' => 4.5, 'description' => 'Kopi hitam pekat dengan crema kental', 'image' => 'https://picsum.photos/id/1/400/300'],
                ['name' => 'Americano', 'price' => 22000, 'rating' => 4.3, 'description' => 'Espresso dengan air panas, ringan dan bold', 'image' => 'https://picsum.photos/id/2/400/300'],
                ['name' => 'Latte', 'price' => 30000, 'rating' => 4.7, 'description' => 'Smooth and creamy latte with rich espresso', 'image' => 'https://picsum.photos/id/3/400/300'],
                ['name' => 'Cappuccino', 'price' => 28000, 'rating' => 4.8, 'description' => 'Rich espresso with creamy steamed milk and foam', 'image' => 'https://picsum.photos/id/4/400/300'],
                ['name' => 'Mocha', 'price' => 32000, 'rating' => 4.6, 'description' => 'Perpaduan espresso, cokelat, dan susu', 'image' => 'https://picsum.photos/id/5/400/300'],
                ['name' => 'Caramel Macchiato', 'price' => 35000, 'rating' => 4.9, 'description' => 'Vanilla dan caramel dengan lapisan busa', 'image' => 'https://picsum.photos/id/6/400/300'],
                ['name' => 'Affogato', 'price' => 38000, 'rating' => 4.4, 'description' => 'Espresso dituang di atas es krim vanila', 'image' => 'https://picsum.photos/id/7/400/300'],
                ['name' => 'Flat White', 'price' => 29000, 'rating' => 4.5, 'description' => 'Microfoam lembut dengan espresso', 'image' => 'https://picsum.photos/id/8/400/300'],
                ['name' => 'Irish Coffee', 'price' => 45000, 'rating' => 4.2, 'description' => 'Kopi dengan whiskey Irlandia dan krim', 'image' => 'https://picsum.photos/id/9/400/300'],
                ['name' => 'Vienna Coffee', 'price' => 33000, 'rating' => 4.3, 'description' => 'Krim kental di atas kopi hitam', 'image' => 'https://picsum.photos/id/10/400/300'],
                ['name' => 'Kopi Tubruk', 'price' => 15000, 'rating' => 4.0, 'description' => 'Kopi tradisional Indonesia', 'image' => 'https://picsum.photos/id/11/400/300'],
                ['name' => 'Kopi Luwak', 'price' => 85000, 'rating' => 4.9, 'description' => 'Premium civet coffee', 'image' => 'https://picsum.photos/id/12/400/300'],
                ['name' => 'Coconut Latte', 'price' => 34000, 'rating' => 4.8, 'description' => 'Latte dengan sentuhan santan', 'image' => 'https://picsum.photos/id/13/400/300'],
                ['name' => 'Hazelnut Latte', 'price' => 36000, 'rating' => 4.7, 'description' => 'Sirup hazelnut dan latte', 'image' => 'https://picsum.photos/id/14/400/300'],
                ['name' => 'Pumpkin Spice Latte', 'price' => 40000, 'rating' => 4.6, 'description' => 'Musiman dengan bumbu labu', 'image' => 'https://picsum.photos/id/15/400/300'],
                ['name' => 'Iced Americano', 'price' => 22000, 'rating' => 4.4, 'description' => 'Refreshing cold brew', 'image' => 'https://picsum.photos/id/16/400/300'],
                ['name' => 'Iced Caramel Latte', 'price' => 35000, 'rating' => 4.7, 'description' => 'Caramel latte dingin', 'image' => 'https://picsum.photos/id/17/400/300'],
                ['name' => 'Iced Matcha Latte', 'price' => 38000, 'rating' => 4.5, 'description' => 'Matcha dengan susu dingin', 'image' => 'https://picsum.photos/id/18/400/300'],
                ['name' => 'Iced Vietnamese Coffee', 'price' => 32000, 'rating' => 4.3, 'description' => 'Kopi robusta dengan susu kental manis', 'image' => 'https://picsum.photos/id/19/400/300'],
                ['name' => 'Butter Coffee', 'price' => 42000, 'rating' => 4.1, 'description' => 'Kopi dengan mentega dan MCT oil', 'image' => 'https://picsum.photos/id/20/400/300'],
            ];
            // Gabungkan dengan menu dari database jika ada
            $menus = \App\Models\Menu::all();
            if($menus->count() > 0) {
                $displayMenus = $menus;
            } else {
                $displayMenus = collect($dummyMenus);
            }
        @endphp

        @foreach($displayMenus as $menu)
        <div class="menu-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:bg-gradient-to-br hover:from-amber-50 hover:to-white dark:hover:from-gray-700 dark:hover:to-gray-800">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ $menu->image_url ?? $menu['image'] ?? 'https://picsum.photos/id/225/400/300' }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                <div class="absolute top-3 right-3 bg-white/80 dark:bg-gray-800/80 rounded-full px-2 py-1 flex items-center">
                    <svg class="w-4 h-4 text-amber-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <span class="text-sm font-bold">{{ $menu->rating ?? $menu['rating'] }}</span>
                </div>
            </div>
            <div class="p-5">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">{{ $menu->name ?? $menu['name'] }}</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 line-clamp-2">{{ $menu->description ?? $menu['description'] }}</p>
                <div class="mt-4 flex justify-between items-center">
                    <span class="text-2xl font-extrabold text-amber-700 dark:text-amber-400">Rp {{ number_format($menu->price ?? $menu['price'],0,',','.') }}</span>
                    <a href="{{ route('menus.show', isset($menu->id) ? $menu->id : $loop->index) }}" 
                       class="px-5 py-2 bg-amber-600 text-white rounded-full hover:bg-amber-700 transition shadow-md text-sm font-semibold">
                        Beli Sekarang
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    // Live search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        document.querySelectorAll('.menu-card').forEach(card => {
            let name = card.querySelector('h3').innerText.toLowerCase();
            card.style.display = name.includes(value) ? '' : 'none';
        });
    });
</script>
@endsection