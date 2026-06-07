<!DOCTYPE html>
<html lang="id" class="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mood Coffee - @yield('title', 'Home')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS untuk dark mode dan animasi -->
    <style>
        /* Warna khas kopi */
        .bg-coffee { background-color: #6F4E37; }
        .hover\:bg-coffee-dark:hover { background-color: #5A3A2A; }
        .text-coffee { color: #6F4E37; }
        .border-coffee { border-color: #6F4E37; }
        
        /* Dark mode styles */
        .dark body {
            background-color: #1a202c;
            color: #f7fafc;
        }
        .dark .bg-white { background-color: #2d3748; }
        .dark .bg-gray-100 { background-color: #1a202c; }
        .dark .text-gray-800 { color: #edf2f7; }
        .dark .text-gray-600 { color: #cbd5e0; }
        .dark .border-gray-200 { border-color: #4a5568; }
        .dark .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3); }
        
        /* Animasi transisi halus */
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }
        
        /* Efek hover pada card */
        .coffee-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .coffee-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Loader animasi */
        .loader {
            border-top-color: #6F4E37;
            animation: spinner 0.6s linear infinite;
        }
        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased dark:bg-gray-900">
    <!-- Navbar -->
    <nav class="bg-white shadow-md dark:bg-gray-800 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo / Brand -->
            <a href="{{ route('home') }}" class="text-2xl font-bold text-coffee dark:text-yellow-400">Mood Coffee</a>

            <!-- Menu Tengah (Desktop) -->
            <div class="hidden md:flex space-x-6 items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-coffee dark:text-gray-300 dark:hover:text-yellow-400 transition">Home</a>
                @auth
                    <a href="{{ route('favorites.index') }}" class="text-gray-700 hover:text-coffee dark:text-gray-300 dark:hover:text-yellow-400 transition">Favorites</a>
                    <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-coffee dark:text-gray-300 dark:hover:text-yellow-400 transition">Cart</a>
                    <a href="{{ route('profile.index') }}" class="text-gray-700 hover:text-coffee dark:text-gray-300 dark:hover:text-yellow-400 transition">Profile</a>
                @endauth
            </div>

            <!-- Dark/Light Mode Toggle -->
            <button id="darkModeToggle" class="text-gray-600 dark:text-gray-300 focus:outline-none">
                <i class="fas fa-moon text-xl dark:hidden"></i>
                <i class="fas fa-sun text-xl hidden dark:inline"></i>
            </button>

            <!-- Right Side (Auth) -->
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-coffee dark:text-gray-300">Login</a>
                    <a href="{{ route('register') }}" class="bg-coffee text-white px-4 py-2 rounded-full hover:bg-coffee-dark transition">Register</a>
                @else
                    <div class="relative group">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            @if(Auth::user()->photo_path)
                                <img src="{{ asset('storage/' . Auth::user()->photo_path) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 rounded-full bg-coffee text-white flex items-center justify-center">
                                    {{ substr(Auth::user()->username, 0, 1) }}
                                </div>
                            @endif
                            <span class="text-gray-700 dark:text-gray-300">{{ Auth::user()->username }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg hidden group-hover:block z-10">
                            <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 shadow-inner py-4 mt-8 text-center text-gray-500 dark:text-gray-400">
        &copy; {{ date('Y') }} Mood Coffee. All rights reserved.
    </footer>

    <!-- JavaScript untuk Dark Mode -->
    <script>
        const toggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;
        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }
        toggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            const theme = html.classList.contains('dark') ? 'dark' : 'light';
            localStorage.setItem('theme', theme);
            fetch('{{ route("theme.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ theme: theme })
            }).catch(e => console.log(e));
        });
    </script>
    @stack('scripts')
</body>
</html>