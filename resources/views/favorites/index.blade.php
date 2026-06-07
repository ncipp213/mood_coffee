@extends('layouts.app')

@section('title', 'Favorit Saya')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-coffee dark:text-yellow-400">Kopi Favoritmu</h1>
@if($favorites->isEmpty())
    <div class="text-center py-12">
        <i class="fas fa-heart-broken text-6xl text-gray-400 mb-4"></i>
        <p class="text-gray-600 dark:text-gray-300">Kamu belum punya favorit. Yuk tambahkan dari halaman Home!</p>
        <a href="{{ route('home') }}" class="inline-block mt-4 bg-coffee text-white px-6 py-2 rounded-full">Lihat Menu</a>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($favorites as $fav)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <img src="{{ $fav->coffee->image_url }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h2 class="text-xl font-semibold dark:text-white">{{ $fav->coffee->name }}</h2>
                <p class="text-gray-600 dark:text-gray-300 mt-1">{{ $fav->coffee->price }}</p>
                <div class="flex justify-between mt-4">
                    <button class="remove-fav bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded-full text-sm" data-favorite-id="{{ $fav->id }}">
                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                    </button>
                    <button class="add-to-cart-from-fav bg-coffee hover:bg-coffee-dark text-white px-3 py-1 rounded-full text-sm"
                            data-coffee-id="{{ $fav->coffee->id }}"
                            data-name="{{ $fav->coffee->name }}"
                            data-image="{{ $fav->coffee->image_url }}"
                            data-price="{{ $fav->coffee->price }}">
                        <i class="fas fa-cart-plus mr-1"></i> Keranjang
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- Modal yang sama seperti home, bisa di-copy atau dibuat partial -->
@endif
@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    // Hapus favorit
    document.querySelectorAll('.remove-fav').forEach(btn => {
        btn.addEventListener('click', async function() {
            const favId = this.dataset.favoriteId;
            if(confirm('Hapus dari favorit?')) {
                const res = await fetch(`/favorites/${favId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                if(res.ok) location.reload();
            }
        });
    });
    // (Tambahkan modal untuk add to cart sama seperti home)
</script>
@endpush