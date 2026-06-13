@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Sapaan --}}
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-amber-950 dark:text-amber-400">
            Hey, {{ Auth::user()->username ?? 'Coffee Lover' }} ☕
        </h1>
        <p class="text-gray-600 dark:text-gray-300">Pilih seduhan favoritmu</p>
    </div>

    <div class="mb-10 max-w-md">
        <div class="flex items-center w-full pl-4 pr-2 py-3.5 rounded-full border border-amber-200 dark:border-gray-600 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm focus-within:ring-2 focus-within:ring-amber-400 transition-all">
            
            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            
            <input type="text" id="searchInput" placeholder="Cari kopi..." 
                class="w-full bg-transparent border-0 pl-3 pr-2 py-1 focus:outline-none focus:ring-0 text-gray-700 dark:text-gray-200 placeholder-gray-400 text-base">
        </div>
    </div>

    @php
        // Ambil dari database, jika kosong gunakan dummy
        $allMenus = \App\Models\Menu::all();
        if($allMenus->isEmpty()) {
            $dummyMenus = [
                (object)['id'=>0,'name'=>'Espresso','price'=>18000,'rating'=>4.5,'description'=>'Kopi hitam pekat dengan crema kental','image_url'=>'https://picsum.photos/id/1/300/200'],
                (object)['id'=>1,'name'=>'Americano','price'=>22000,'rating'=>4.3,'description'=>'Espresso dengan air panas, ringan dan bold','image_url'=>'https://picsum.photos/id/2/300/200'],
                (object)['id'=>2,'name'=>'Latte','price'=>30000,'rating'=>4.7,'description'=>'Smooth and creamy latte with rich espresso','image_url'=>'https://picsum.photos/id/3/300/200'],
                (object)['id'=>3,'name'=>'Cappuccino','price'=>28000,'rating'=>4.8,'description'=>'Rich espresso with creamy milk foam','image_url'=>'https://picsum.photos/id/4/300/200'],
                (object)['id'=>4,'name'=>'Mocha','price'=>32000,'rating'=>4.6,'description'=>'Perpaduan espresso, cokelat, dan susu','image_url'=>'https://picsum.photos/id/5/300/200'],
                (object)['id'=>5,'name'=>'Caramel Macchiato','price'=>35000,'rating'=>4.9,'description'=>'Vanilla dan caramel dengan lapisan busa','image_url'=>'https://picsum.photos/id/6/300/200'],
                (object)['id'=>6,'name'=>'Affogato','price'=>38000,'rating'=>4.4,'description'=>'Espresso dituang di atas es krim vanila','image_url'=>'https://picsum.photos/id/7/300/200'],
                (object)['id'=>7,'name'=>'Flat White','price'=>29000,'rating'=>4.5,'description'=>'Microfoam lembut dengan espresso','image_url'=>'https://picsum.photos/id/8/300/200'],
                (object)['id'=>8,'name'=>'Irish Coffee','price'=>45000,'rating'=>4.2,'description'=>'Kopi dengan whiskey Irlandia dan krim','image_url'=>'https://picsum.photos/id/9/300/200'],
                (object)['id'=>9,'name'=>'Vienna Coffee','price'=>33000,'rating'=>4.3,'description'=>'Krim kental di atas kopi hitam','image_url'=>'https://picsum.photos/id/10/300/200'],
                (object)['id'=>10,'name'=>'Kopi Tubruk','price'=>15000,'rating'=>4.0,'description'=>'Kopi tradisional Indonesia','image_url'=>'https://picsum.photos/id/11/300/200'],
                (object)['id'=>11,'name'=>'Kopi Luwak','price'=>85000,'rating'=>4.9,'description'=>'Premium civet coffee','image_url'=>'https://picsum.photos/id/12/300/200'],
                (object)['id'=>12,'name'=>'Coconut Latte','price'=>34000,'rating'=>4.8,'description'=>'Latte dengan sentuhan santan','image_url'=>'https://picsum.photos/id/13/300/200'],
                (object)['id'=>13,'name'=>'Hazelnut Latte','price'=>36000,'rating'=>4.7,'description'=>'Sirup hazelnut dan latte','image_url'=>'https://picsum.photos/id/14/300/200'],
                (object)['id'=>14,'name'=>'Pumpkin Spice Latte','price'=>40000,'rating'=>4.6,'description'=>'Musiman dengan bumbu labu','image_url'=>'https://picsum.photos/id/15/300/200'],
                (object)['id'=>15,'name'=>'Iced Americano','price'=>22000,'rating'=>4.4,'description'=>'Refreshing cold brew','image_url'=>'https://picsum.photos/id/16/300/200'],
                (object)['id'=>16,'name'=>'Iced Caramel Latte','price'=>35000,'rating'=>4.7,'description'=>'Caramel latte dingin','image_url'=>'https://picsum.photos/id/17/300/200'],
                (object)['id'=>17,'name'=>'Iced Matcha Latte','price'=>38000,'rating'=>4.5,'description'=>'Matcha dengan susu dingin','image_url'=>'https://picsum.photos/id/18/300/200'],
                (object)['id'=>18,'name'=>'Iced Vietnamese Coffee','price'=>32000,'rating'=>4.3,'description'=>'Kopi robusta dengan susu kental manis','image_url'=>'https://picsum.photos/id/19/300/200'],
                (object)['id'=>19,'name'=>'Butter Coffee','price'=>42000,'rating'=>4.1,'description'=>'Kopi dengan mentega dan MCT oil','image_url'=>'https://picsum.photos/id/20/300/200'],
            ];
            $allMenus = collect($dummyMenus);
            $recommended = $allMenus->sortByDesc('rating')->take(4);
        } else {
            $recommended = \App\Models\Menu::orderBy('rating', 'desc')->take(4)->get();
        }
    @endphp

    {{-- Recommended for you --}}
    @if($recommended->count())
    <div class="mb-12" id="recommendedSection">
        <h2 class="text-2xl font-bold text-amber-800 dark:text-amber-400 mb-4 flex items-center">
            <span class="mr-2">⭐</span> Recommended for you
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($recommended as $menu)
            <a href="{{ route('menus.show', $menu->id) }}" class="block group">
                {{-- UBAH KELAS UTAMA CARD DI BAWAH INI JADI GLASSMORPHISM --}}
                <div class="bg-white/40 dark:bg-gray-900/40 backdrop-blur-md border border-white/60 dark:border-gray-700/40 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="h-36 overflow-hidden">
                        <img src="{{ $menu->image_url ?? 'https://picsum.photos/id/225/300/200' }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                    </div>
                    <div class="p-3">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-gray-800 dark:text-white">{{ $menu->name }}</h3>
                            <div class="flex items-center text-yellow-500">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-xs ml-1">{{ $menu->rating }}</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ Str::limit($menu->description, 50) }}</p>
                        <div class="mt-2 font-bold text-amber-700 dark:text-amber-400">Rp {{ number_format(floatval($menu->price ?? 0), 0, ',', '.') }}</div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Menu Kopi --}}
    <div>
        <h2 class="text-2xl font-bold text-amber-800 dark:text-amber-400 mb-4">☕ Menu Kopi</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="menuGrid">
            @foreach($allMenus as $menu)
            <a href="{{ route('menus.show', $menu->id) }}" class="block group" data-name="{{ strtolower($menu->name) }}">
                {{-- UBAH KELAS UTAMA CARD DI BAWAH INI JADI GLASSMORPHISM --}}
                <div class="menu-card bg-white/40 dark:bg-gray-900/40 backdrop-blur-md border border-white/60 dark:border-gray-700/40 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative h-36 overflow-hidden">
                        <img src="{{ $menu->image_url ?? 'https://picsum.photos/id/'.$loop->iteration.'/300/200' }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                    </div>
                    <div class="p-3">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-gray-800 dark:text-white">{{ $menu->name }}</h3>
                            <div class="flex items-center text-yellow-500">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-xs ml-1">{{ $menu->rating }}</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ Str::limit($menu->description, 50) }}</p>
                        <div class="mt-2 font-bold text-amber-700 dark:text-amber-400">Rp {{ number_format($menu->price,0,',','.') }}</div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

<script>
    // Live search yang berfungsi & menyembunyikan rekomendasi
    const searchInput = document.getElementById('searchInput');
    const menuItems = document.querySelectorAll('#menuGrid > a');
    const recommendedSection = document.getElementById('recommendedSection'); // Ambil elemen rekomendasi

    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            let keyword = this.value.toLowerCase();

            // Sembunyikan rekomendasi jika ada teks yang diketik, tampilkan jika kosong
            if (keyword.length > 0) {
                if (recommendedSection) recommendedSection.style.display = 'none';
            } else {
                if (recommendedSection) recommendedSection.style.display = '';
            }

            // Filter menu utama
            menuItems.forEach(item => {
                let name = item.getAttribute('data-name') || item.querySelector('h3').innerText.toLowerCase();
                if (name.includes(keyword)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
</script>
@endsection