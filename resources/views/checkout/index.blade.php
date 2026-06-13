@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-extrabold text-amber-950 dark:text-amber-400 mb-6 flex items-center gap-2">
        Checkout ☕
    </h1>

    <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
        @csrf

        {{-- 1. TIPE PEMESANAN (PASTI BERSEBELAHAN & INTERAKTIF) --}}
        <div class="space-y-2">
            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipe Pemesanan</label>
            <div class="flex flex-row gap-3 w-full">
                <label onclick="selectOrderType('dine_in')" id="btn-dine_in" class="flex-1 cursor-pointer border rounded-xl py-3 px-4 flex items-center justify-center gap-2 font-bold text-sm transition-all duration-200 bg-amber-600 text-white border-amber-600 shadow-sm">
                    <input type="radio" name="order_type" id="radio-dine_in" value="dine_in" class="hidden" checked>
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-.11-8.203-.318m16.393 0a7.5 7.5 0 11-15.696 0" />
                    </svg>
                    <span>Dine In</span>
                </label>

                <label onclick="selectOrderType('take_away')" id="btn-take_away" class="flex-1 cursor-pointer border rounded-xl py-3 px-4 flex items-center justify-center gap-2 font-bold text-sm transition-all duration-200 bg-white/40 dark:bg-gray-900/40 text-gray-700 dark:text-gray-300 border-white/60 dark:border-gray-700/60 hover:bg-white/60">
                    <input type="radio" name="order_type" id="radio-take_away" value="take_away" class="hidden">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span>Take Away</span>
                </label>
            </div>
        </div>

        {{-- 2. METODE PEMBAYARAN (PASTI BERSEBELAHAN & INTERAKTIF) --}}
        <div class="space-y-2">
            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Metode Pembayaran</label>
            <div class="flex flex-row gap-3 w-full">
                <label onclick="selectPaymentMethod('cash')" id="btn-cash" class="flex-1 cursor-pointer border rounded-xl py-3 px-4 flex items-center justify-center gap-2 font-bold text-sm transition-all duration-200 bg-amber-600 text-white border-amber-600 shadow-sm">
                    <input type="radio" name="payment_method" id="radio-cash" value="cash" class="hidden" checked>
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5M4.5 19.25h15M5.25 4.5v15m13.5-15v15M3 6.75h18M3.75 9h16.5M4.5 11.25h15M5.25 13.5h13.5M6 15.75h12M6.75 18h10.5" />
                    </svg>
                    <span>Bayar Di Kasir</span>
                </label>

                <label onclick="selectPaymentMethod('qris')" id="btn-qris" class="flex-1 cursor-pointer border rounded-xl py-3 px-4 flex items-center justify-center gap-2 font-bold text-sm transition-all duration-200 bg-white/40 dark:bg-gray-900/40 text-gray-700 dark:text-gray-300 border-white/60 dark:border-gray-700/60 hover:bg-white/60">
                    <input type="radio" name="payment_method" id="radio-qris" value="qris" class="hidden">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                    </svg>
                    <span>QRIS</span>
                </label>
            </div>
        </div>

        {{-- 3. RINGKASAN PESANAN (PERBAIKAN SPASI & ANTRI-TABRAKAN) --}}
        <div class="space-y-2">
            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pesanan Anda</label>
            <div class="bg-white/40 dark:bg-gray-900/40 backdrop-blur-md border border-white/60 dark:border-gray-700/40 rounded-2xl overflow-hidden shadow-sm">
                
                {{-- Daftar Item Belanja --}}
                <div class="divide-y divide-white/30 dark:divide-gray-800/30">
                    @foreach($carts as $item)
                    <div class="p-4 flex justify-between items-center gap-4">
                        <div>
                            <span class="font-bold text-gray-800 dark:text-white text-sm block">{{ $item->menu->name }}</span>
                            <span class="text-xs text-gray-400 dark:text-gray-500 block mt-1">
                                {{ $item->size }} • {{ $item->milk }} <span class="ml-2 text-amber-700 dark:text-amber-500 font-extrabold">x{{ $item->quantity }}</span>
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-bold text-gray-800 dark:text-gray-200 block">
                                Rp {{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Bagian Total Rincian (Diberi Spasi Longgar & Padding yang Aman) --}}
                <div class="p-4 bg-white/20 dark:bg-gray-900/20 border-t border-white/40 dark:border-gray-800/40 space-y-3 text-sm">
                    <div class="flex justify-between text-gray-500 dark:text-gray-400 font-medium">
                        <span>Subtotal</span>
                        <span class="font-bold text-gray-700 dark:text-gray-300">Rp {{ number_format($carts->sum(fn($c) => $c->quantity * $c->unit_price), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500 dark:text-gray-400 font-medium">
                        <span>Biaya Layanan</span>
                        <span class="text-green-600 dark:text-green-400 font-bold">Free</span>
                    </div>
                    
                    {{-- Batas Garis Putus-Putus dengan Jarak Padding Aman (`pt-4 mt-2`) --}}
                    <div class="pt-4 mt-2 border-t border-dashed border-gray-300 dark:border-gray-700 flex justify-between items-center text-gray-800 dark:text-white">
                        <span class="font-extrabold text-sm uppercase tracking-wide">Total Payment</span>
                        <span class="text-xl text-amber-800 dark:text-amber-400 font-black">
                            Rp {{ number_format($carts->sum(fn($c) => $c->quantity * $c->unit_price), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOMBOL SUBMIT UTAMA --}}
        <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white py-3.5 rounded-xl font-bold transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 tracking-wide text-sm uppercase">
            Konfirmasi &amp; Bayar
        </button>
    </form>
</div>

{{-- JAVASCRIPT ENGINE (MENJAMIN WARNA AKTIF BERFUNGSI 100% SECARA INSTAN) --}}
<script>
    function selectOrderType(type) {
        const btnDineIn = document.getElementById('btn-dine_in');
        const btnTakeAway = document.getElementById('btn-take_away');
        const radioDineIn = document.getElementById('radio-dine_in');
        const radioTakeAway = document.getElementById('radio-take_away');

        const activeClass = "flex-1 cursor-pointer border rounded-xl py-3 px-4 flex items-center justify-center gap-2 font-bold text-sm transition-all duration-200 bg-amber-600 text-white border-amber-600 shadow-sm";
        const inactiveClass = "flex-1 cursor-pointer border rounded-xl py-3 px-4 flex items-center justify-center gap-2 font-bold text-sm transition-all duration-200 bg-white/40 dark:bg-gray-900/40 text-gray-700 dark:text-gray-300 border-white/60 dark:border-gray-700/60 hover:bg-white/60";

        if (type === 'dine_in') {
            btnDineIn.className = activeClass;
            btnTakeAway.className = inactiveClass;
            radioDineIn.checked = true;
        } else {
            btnDineIn.className = inactiveClass;
            btnTakeAway.className = activeClass;
            radioTakeAway.checked = true;
        }
    }

    function selectPaymentMethod(method) {
        const btnCash = document.getElementById('btn-cash');
        const btnQris = document.getElementById('btn-qris');
        const radioCash = document.getElementById('radio-cash');
        const radioQris = document.getElementById('radio-qris');

        const activeClass = "flex-1 cursor-pointer border rounded-xl py-3 px-4 flex items-center justify-center gap-2 font-bold text-sm transition-all duration-200 bg-amber-600 text-white border-amber-600 shadow-sm";
        const inactiveClass = "flex-1 cursor-pointer border rounded-xl py-3 px-4 flex items-center justify-center gap-2 font-bold text-sm transition-all duration-200 bg-white/40 dark:bg-gray-900/40 text-gray-700 dark:text-gray-300 border-white/60 dark:border-gray-700/60 hover:bg-white/60";

        if (method === 'cash') {
            btnCash.className = activeClass;
            btnQris.className = inactiveClass;
            radioCash.checked = true;
        } else {
            btnCash.className = inactiveClass;
            btnQris.className = activeClass;
            radioQris.checked = true;
        }
    }
</script>
@endsection