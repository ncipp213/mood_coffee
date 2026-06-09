<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p>Selamat datang di Mood Coffee!</p>
        </div>
    </div>
</x-app-layout>

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-amber-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Hero Section dengan background gambar kopi yang menarik -->
        <div class="relative rounded-2xl overflow-hidden mb-12 shadow-xl">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=1600');">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/40"></div>
            </div>
            <div class="relative z-10 py-20 px-6 text-center md:text-left md:py-24 md:px-12">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 animate-fade-in-down">
                    MOODCOFFEE
                </h1>
                <p class="text-xl md:text-2xl text-amber-200 mb-6 animate-fade-in-up">
                    we already met
                </p>
                <p class="text-lg text-white/80 max-w-2xl mx-auto md:mx-0">
                    Experience the perfect blend of artisanal coffee and cozy atmosphere
                </p>
                <div class="mt-8">
                    @auth
                        <span class="text-white bg-amber-600 px-6 py-3 rounded-full text-lg">
                            Welcome back, {{ Auth::user()->name }}! ☕
                        </span>
                    @else
                        <a href="{{ route('register') }}" class="inline-block bg-amber-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-amber-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Get In Now
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Pilih Seduhan Favoritmu Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">
                        Pilih seduhan favoritmu
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        Temukan kopi yang sesuai dengan moodmu hari ini
                    </p>
                </div>
                <!-- Search Bar -->
                <div class="relative">
                    <input 
                        type="text" 
                        id="search-coffee" 
                        placeholder="Search for coffee..." 
                        class="pl-10 pr-4 py-2 rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent w-full md:w-64"
                    >
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Recommended for you Section -->
        <div class="mb-16">
            <h3 class="text-xl font-semibold text-amber-700 dark:text-amber-400 mb-4 flex items-center">
                <span class="bg-amber-100 dark:bg-amber-900/30 p-1 rounded-full mr-2">⭐</span>
                Recommended for you
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recommended as $menu)
                    <div class="menu-card bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="h-48 bg-gradient-to-br from-amber-200 to-amber-400 relative">
                            <div class="absolute inset-0 flex items-center justify-center text-6xl">
                                ☕
                            </div>
                            <!-- Badge rating -->
                            <div class="absolute top-3 right-3 bg-amber-500 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                                <span>⭐</span> {{ number_format($menu->rating, 1) }}
                            </div>
                            <!-- Favorite button (only for logged in users) -->
                            @auth
                                <form action="{{ route('favorites.toggle', $menu) }}" method="POST" class="absolute top-3 left-3">
                                    @csrf
                                    <button type="submit" class="text-2xl hover:scale-110 transition-transform">
                                        @if(Auth::user()->hasFavorited($menu->id))
                                            ❤️
                                        @else
                                            🤍
                                        @endif
                                    </button>
                                </form>
                            @endauth
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-lg text-gray-800 dark:text-white">{{ $menu->name }}</h4>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1 line-clamp-2">{{ $menu->description }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-amber-600 dark:text-amber-400 font-bold text-xl">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                <div class="flex items-center gap-2">
                                    <!-- Add to Cart button -->
                                    <form action="{{ route('cart.add', $menu) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition duration-300 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 18v3"></path>
                                            </svg>
                                            Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Menu Kopi Section -->
        <div>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 border-l-4 border-amber-500 pl-3">
                Menu Kopi
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($menus as $menu)
                    <div class="menu-card bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-scale-[1.01]">
                        <div class="flex p-4">
                            <div class="w-24 h-24 bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-800 dark:to-amber-700 rounded-xl flex items-center justify-center text-3xl">
                                ☕
                            </div>
                            <div class="flex-1 ml-4">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-semibold text-gray-800 dark:text-white">{{ $menu->name }}</h4>
                                    @auth
                                        <form action="{{ route('favorites.toggle', $menu) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xl hover:scale-110 transition">
                                                @if(Auth::user()->hasFavorited($menu->id))
                                                    ❤️
                                                @else
                                                    🤍
                                                @endif
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ Str::limit($menu->description, 50) }}</p>
                                <div class="flex items-center gap-1 mt-2">
                                    <span class="text-yellow-500">⭐</span>
                                    <span class="text-gray-700 dark:text-gray-300 text-sm">{{ number_format($menu->rating, 1) }}</span>
                                </div>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-amber-600 dark:text-amber-400 font-bold">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                    <form action="{{ route('cart.add', $menu) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm bg-amber-600 text-white px-3 py-1 rounded-lg hover:bg-amber-700 transition">
                                            + Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Live search functionality
    const searchInput = document.getElementById('search-coffee');
    const menuCards = document.querySelectorAll('.menu-card');
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        
        menuCards.forEach(card => {
            const menuName = card.querySelector('h4')?.innerText.toLowerCase() || '';
            const menuDesc = card.querySelector('p')?.innerText.toLowerCase() || '';
            
            if (menuName.includes(searchTerm) || menuDesc.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endsection