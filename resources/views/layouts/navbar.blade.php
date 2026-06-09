<nav class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-amber-200 dark:border-gray-700">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo MOODCOFFEE -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-amber-800 bg-clip-text text-transparent dark:from-amber-400 dark:to-amber-300">
                    moodcoffee
                </a>
            </div>

            <!-- Menu Tengah: Home, Favorites, Cart, Profile -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-200 hover:text-amber-600 dark:hover:text-amber-400 transition {{ request()->routeIs('home') ? 'text-amber-600 dark:text-amber-400 font-semibold' : '' }}">
                    Home
                </a>
                <a href="{{ route('favorites.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-amber-600 dark:hover:text-amber-400 transition {{ request()->routeIs('favorites.*') ? 'text-amber-600 dark:text-amber-400 font-semibold' : '' }}">
                    Favorites
                </a>
                <a href="{{ route('cart.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-amber-600 dark:hover:text-amber-400 transition {{ request()->routeIs('cart.*') ? 'text-amber-600 dark:text-amber-400 font-semibold' : '' }}">
                    Cart
                </a>
                @auth
                <a href="{{ route('profile.edit') }}" class="text-gray-700 dark:text-gray-200 hover:text-amber-600 dark:hover:text-amber-400 transition">
                    Profile
                </a>
                @endauth
            </div>

            <!-- Bagian Kanan: Dark Mode + Regist/Login -->
            <div class="flex items-center space-x-4">
                <!-- Dark Mode Toggle Button -->
                <button id="theme-toggle" type="button" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-amber-100 dark:hover:bg-amber-900 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden dark:block">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 block dark:hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </button>

                @guest
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-amber-600 dark:hover:text-amber-400 transition">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium bg-amber-600 text-white rounded-full hover:bg-amber-700 transition shadow-md">Register</a>
                @else
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 dark:text-gray-200 hover:text-amber-600">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-1 z-50" x-cloak>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</button>
                        </form>
                    </div>
                </div>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 dark:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>