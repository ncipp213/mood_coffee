@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 py-8 text-center">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6">
        <div class="text-red-500 text-sm mb-2">Selesaikan Waktu Pembayaran</div>
        <div id="timer" class="text-3xl font-mono font-bold text-amber-700 mb-6">10:00</div>

        <div class="bg-amber-100 dark:bg-amber-900 p-4 rounded-2xl mb-4">
            <div class="font-bold text-xl">MOODCOFFEE</div>
            <div class="text-sm">NMDI : {{ $order->order_number }}</div>
        </div>

        @if($order->payment_method == 'cash')
            {{-- Barcode untuk bayar di kasir --}}
            <div class="border-2 border-dashed border-amber-400 p-4 rounded-2xl mb-4">
                <div class="text-sm font-semibold mb-2">BARCODE UNTUK BAYAR DI KASIR</div>
                <div class="flex justify-center my-3">
                    <img src="https://barcode.tec-it.com/barcode.ashx?data={{ $order->order_number }}&code=Code128&dpi=96" alt="Barcode" class="h-24">
                </div>
                <div class="text-xs text-gray-500">{{ $order->order_number }}</div>
                <p class="text-sm mt-2">Tunjukkan barcode ini ke kasir untuk melakukan pembayaran.</p>
            </div>
        @else
            {{-- QRIS --}}
            <div class="border-2 border-dashed border-green-400 p-4 rounded-2xl mb-4">
                <div class="text-sm font-semibold mb-2">SCAN QRIS UNTUK MEMBAYAR</div>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ $order->order_number }}" class="mx-auto my-2" alt="QRIS Code">
                <p class="text-sm mt-2">Gunakan aplikasi pembayaran (GoPay, OVO, DANA, dll) untuk scan QRIS.</p>
            </div>
        @endif

        <div class="text-left mt-4 border-t pt-4">
            <div class="flex justify-between">
                <span>Total Pembayaran</span>
                <span class="font-bold text-xl">Rp {{ number_format($order->total,0,',','.') }}</span>
            </div>
        </div>

        <a href="{{ route('payment.status', $order) }}" class="block mt-6 py-3 bg-amber-600 text-white rounded-full hover:bg-amber-700 transition">
            Cek Status Pembayaran
        </a>
    </div>
</div>

<script>
    // Countdown 10 menit (600 detik)
    let timeLeft = 600;
    const timerDisplay = document.getElementById('timer');
    const interval = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(interval);
            timerDisplay.innerText = '00:00';
            alert('Waktu pembayaran habis! Pesanan dibatalkan.');
            window.location.href = "{{ route('home') }}";
        } else {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.innerText = `${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
        }
    }, 1000);
</script>
@endsection