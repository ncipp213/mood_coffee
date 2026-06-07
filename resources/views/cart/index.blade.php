@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-coffee dark:text-yellow-400">Keranjang Saya</h1>
@if($cartItems->isEmpty())
    <div class="text-center py-12">
        <i class="fas fa-shopping-cart text-6xl text-gray-400 mb-4"></i>
        <p class="text-gray-600 dark:text-gray-300">Keranjang masih kosong. Yuk beli kopi!</p>
        <a href="{{ route('home') }}" class="inline-block mt-4 bg-coffee text-white px-6 py-2 rounded-full">Belanja Sekarang</a>
    </div>
@else
    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-2/3">
            @foreach($cartItems as $item)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 mb-4 flex flex-col sm:flex-row justify-between items-center">
                <div class="flex items-center space-x-4 w-full sm:w-auto">
                    <img src="{{ $item->image_url }}" class="w-16 h-16 rounded object-cover">
                    <div>
                        <h3 class="font-semibold dark:text-white">{{ $item->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item->milk }}, {{ $item->size }}</p>
                        <p class="text-coffee font-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 mt-3 sm:mt-0">
                    <div class="flex items-center border rounded">
                        <button class="decr-qty px-3 py-1 border-r" data-cart-id="{{ $item->id }}">-</button>
                        <span class="px-4 py-1" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                        <button class="incr-qty px-3 py-1 border-l" data-cart-id="{{ $item->id }}">+</button>
                    </div>
                    <button class="remove-item text-red-500 hover:text-red-700" data-cart-id="{{ $item->id }}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        <div class="lg:w-1/3">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-20">
                <h2 class="text-xl font-bold mb-4 dark:text-white">Ringkasan Belanja</h2>
                <div class="flex justify-between mb-2">
                    <span>Total Item:</span>
                    <span id="totalItems">{{ $cartItems->sum('quantity') }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold mt-4 pt-4 border-t dark:border-gray-700">
                    <span>Total Harga:</span>
                    <span id="totalPrice">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <button class="w-full mt-6 bg-coffee text-white py-2 rounded-full hover:bg-coffee-dark transition">Checkout (coming soon)</button>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    async function updateCart(cartId, quantity) {
        const res = await fetch(`/cart/update/${cartId}`, {
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
            body: JSON.stringify({ quantity })
        });
        if(res.ok) location.reload();
    }
    
    document.querySelectorAll('.incr-qty').forEach(btn => {
        btn.addEventListener('click', () => updateCart(btn.dataset.cartId, parseInt(document.getElementById(`qty-${btn.dataset.cartId}`).innerText) + 1));
    });
    document.querySelectorAll('.decr-qty').forEach(btn => {
        btn.addEventListener('click', () => {
            let qty = parseInt(document.getElementById(`qty-${btn.dataset.cartId}`).innerText);
            if(qty > 1) updateCart(btn.dataset.cartId, qty-1);
        });
    });
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', async () => {
            if(confirm('Hapus item ini?')) {
                await fetch(`/cart/remove/${btn.dataset.cartId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                location.reload();
            }
        });
    });
</script>
@endpush