@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-extrabold text-amber-950 dark:text-amber-400 mb-6 flex items-center gap-2">
        My Cart 🛒
    </h1>

    @if($carts->isEmpty())
        {{-- Tampilan Kosong Glassmorphism --}}
        <div class="text-center py-12 bg-white/40 dark:bg-gray-900/40 backdrop-blur-md border border-white/60 dark:border-gray-700/40 rounded-2xl shadow-md">
            <p class="text-gray-500 dark:text-gray-400 text-lg">Keranjang kosong, yuk pesan kopi! ☕</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-full transition shadow-md">Pesan Sekarang</a>
        </div>
    @else
        {{-- List Produk Dibuat Per-Card yang Padat --}}
        <div class="space-y-3">
            @foreach($carts as $item)
            <div class="bg-white/40 dark:bg-gray-900/40 backdrop-blur-md border border-white/60 dark:border-gray-700/40 rounded-2xl p-4 flex items-center justify-between gap-4 shadow-sm hover:shadow-md transition-all duration-200">
                
                {{-- SISI KIRI: Gambar & Detail Info --}}
                <div class="flex items-center gap-4 flex-1">
                    <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm shrink-0 border border-white/40">
                        <img src="{{ $item->menu->image_url ?? 'https://picsum.photos/id/225/300/200' }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-800 dark:text-white leading-tight">{{ $item->menu->name }}</h3>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-0.5">{{ $item->size }} • {{ $item->milk }}</p>
                        <p class="text-sm font-bold text-amber-800 dark:text-amber-400 mt-1">
                            Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- SISI KANAN: Kontrol Qty yang Lebih Lebar & Tombol Hapus --}}
                <div class="flex items-center gap-4 shrink-0">
                    
                    {{-- Form Update Qty (Lebih Lebar & Proporsional dengan w-32) --}}
                    <form id="update-form-{{ $item->id }}" action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center justify-between bg-white/80 dark:bg-gray-800/80 rounded-full border border-gray-200 dark:border-gray-700 p-1 shadow-sm w-32">
                        @csrf 
                        @method('PUT')
                        
                        {{-- Tombol Minus --}}
                        <button type="button" onclick="changeQty('{{ $item->id }}', -1)" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-amber-100 dark:hover:bg-amber-950/40 hover:text-amber-700 transition focus:outline-none font-bold">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                            </svg>
                        </button>
                        
                        {{-- Angka Qty --}}
                        <input type="number" id="qty-{{ $item->id }}" name="quantity" value="{{ $item->quantity }}" min="1" class="hidden">
                        <span class="text-center font-extrabold text-gray-800 dark:text-white text-base flex-1">{{ $item->quantity }}</span>
                        
                        {{-- Tombol Plus --}}
                        <button type="button" onclick="changeQty('{{ $item->id }}', 1)" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-amber-100 dark:hover:bg-amber-950/40 hover:text-amber-700 transition focus:outline-none font-bold">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    </form>

                    {{-- Tombol Hapus --}}
                    <form action="{{ route('cart.destroy', $item) }}" method="POST" class="flex items-center">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="p-2 text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-full transition duration-200" title="Hapus Item">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>

                </div>
            </div>
            @endforeach
        </div>

        {{-- CARD TERPISAH UNTUK TOTAL & PAYMENT --}}
        <div class="mt-4 bg-white/40 dark:bg-gray-900/40 backdrop-blur-md border border-white/60 dark:border-gray-700/40 rounded-2xl p-4 flex items-center justify-between gap-4 shadow-md">
            <div>
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block">Total Payment</span>
                <span class="text-2xl font-extrabold text-amber-800 dark:text-amber-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('checkout.form') }}" class="px-8 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-full transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 text-sm">
                Payment →
            </a>
        </div>
    @endif
</div>

{{-- JAVASCRIPT AUTOMATION FOR PLUS / MINUS CLICK --}}
<script>
    function changeQty(itemId, change) {
        const input = document.getElementById(`qty-${itemId}`);
        if (input) {
            let currentVal = parseInt(input.value) || 1;
            let newVal = currentVal + change;
            
            if (newVal >= 1) {
                input.value = newVal;
                document.getElementById(`update-form-${itemId}`).submit();
            }
        }
    }
</script>
@endsection