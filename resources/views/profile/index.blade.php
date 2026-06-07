@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6 text-coffee dark:text-yellow-400">Profil Pengguna</h1>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4 flex justify-center">
            <div class="relative">
                @if(Auth::user()->photo_path)
                    <img src="{{ asset('storage/' . Auth::user()->photo_path) }}" class="w-24 h-24 rounded-full object-cover">
                @else
                    <div class="w-24 h-24 rounded-full bg-coffee text-white flex items-center justify-center text-4xl">
                        {{ substr(Auth::user()->username, 0, 1) }}
                    </div>
                @endif
                <label class="absolute bottom-0 right-0 bg-coffee rounded-full p-1 cursor-pointer">
                    <i class="fas fa-camera text-white text-sm"></i>
                    <input type="file" name="photo" class="hidden" accept="image/*">
                </label>
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Username</label>
            <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">No. Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Alamat</label>
            <textarea name="address" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('address', Auth::user()->address) }}</textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-coffee text-white px-6 py-2 rounded-full hover:bg-coffee-dark">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection