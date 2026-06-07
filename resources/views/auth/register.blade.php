@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden max-w-md w-full mx-4">
        <div class="bg-coffee p-6 text-center">
            <i class="fas fa-user-plus text-white text-5xl mb-2"></i>
            <h2 class="text-2xl font-bold text-white">Create Account</h2>
            <p class="text-white/80">Join Mood Coffee today</p>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                    <input type="text" name="username" value="{{ old('username') }}" required class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coffee dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coffee dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coffee dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Address</label>
                    <textarea name="address" rows="2" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coffee dark:bg-gray-700 dark:border-gray-600">{{ old('address') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coffee dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coffee dark:bg-gray-700 dark:border-gray-600">
                </div>
                <button type="submit" class="w-full bg-coffee text-white py-2 rounded-lg hover:bg-coffee-dark transition">Register</button>
            </form>
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-coffee hover:underline">Already have an account? Login</a>
            </div>
        </div>
    </div>
</div>
@endsection