{{-- resources/views/home.blade.php --}}
@extends('layouts.app') {{-- menggunakan layout master --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center mb-8 text-coffee">Menu Kopi Kami</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($coffees as $coffee)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <img src="{{ $coffee->image_url }}" alt="{{ $coffee->name }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <div class="flex justify-between items-start mb-2">
                    <h2 class="text-xl font-semibold">{{ $coffee->name }}</h2>
                    <span class="text-yellow-500">★ {{ number_format($coffee->rating, 1) }}</span>
                </div>
                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($coffee->description, 80) }}</p>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-lg font-bold text-coffee">{{ $coffee->price }}</span>
                    <button class="bg-coffee hover:bg-coffee-dark text-white px-4 py-2 rounded-full text-sm transition-colors">
                        + Keranjang
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection