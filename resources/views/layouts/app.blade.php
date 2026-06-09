<!DOCTYPE html>
<html lang="id" class="transition-colors duration-300">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MOODCOFFEE') - Mood Coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-amber-50 via-white to-amber-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 font-poppins transition-colors duration-300">
    <div class="min-h-screen">
        <!-- Navbar akan ditempatkan di sini -->
        @include('layouts.navbar')

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            @yield('content')
        </main>

        <!-- Footer sederhana -->
        <footer class="text-center py-6 text-gray-500 dark:text-gray-400 text-sm border-t border-amber-200 dark:border-gray-700 mt-auto">
            &copy; {{ date('Y') }} MOODCOFFEE. Nikmati setiap tegukan dengan suasana hati.
        </footer>
    </div>
    @stack('scripts')
</body>
</html>