@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden max-w-md w-full mx-4">
        <div class="bg-coffee p-6 text-center">
            <i class="fas fa-coffee text-white text-5xl mb-2"></i>
            <h2 class="text-2xl font-bold text-white">Welcome Back</h2>
            <p class="text-white/80">Login to your account</p>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coffee dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coffee dark:bg-gray-700 dark:border-gray-600">
                </div>
                <button type="submit" class="w-full bg-coffee text-white py-2 rounded-lg hover:bg-coffee-dark transition">Login</button>
            </form>
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-coffee hover:underline">Don't have an account? Register</a>
            </div>
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white dark:bg-gray-800 text-gray-500">Or</span>
                </div>
            </div>
            <form method="POST" action="{{ route('guest.login') }}">
                @csrf
                <button type="submit" class="w-full border border-coffee text-coffee py-2 rounded-lg hover:bg-coffee/10 transition">Continue as Guest</button>
            </form>
        </div>
    </div>
</div>
@endsection