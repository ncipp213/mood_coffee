@extends('layouts.app')

@section('content')
{{-- Container Utama --}}
<div class="max-w-4xl mx-auto px-4 py-12 flex items-center min-h-[80vh]">
    
    {{-- Card Utama - flex-col di mobile, md:flex-row di desktop. Tinggi dikunci h-[480px] di desktop --}}
    <div class="bg-white/80 dark:bg-black/20 rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-white/5 flex flex-col md:flex-row w-full md:h-[480px] transition-all duration-300 backdrop-blur-xl">
        
        {{-- Sisi Kiri: Bagian Gambar --}}
        <div class="w-full md:w-1/2 h-64 md:h-full relative flex-shrink-0 bg-gray-100 dark:bg-neutral-800">
            <img src="{{ $menu->image_url ?? 'https://picsum.photos/id/225/600/600' }}" class="w-full h-full object-cover absolute inset-0">
            
            {{-- Tombol Favorite di pojok kanan atas gambar --}}
            @auth
            <button id="favoriteBtn" data-menu-id="{{ $menu->id }}" class="absolute top-5 left-5 z-10 bg-white/80 dark:bg-black/60 backdrop-blur-sm rounded-full p-2.5 shadow-md hover:bg-amber-100/50 dark:hover:bg-amber-100/30 transition">
                <svg id="favoriteIcon" class="w-5 h-5 text-red-500" fill="{{ auth()->user()->favorites->contains('menu_id', $menu->id) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
            @endauth
        </div>

        {{-- Sisi Kanan: Detail Konten (Keterangan Menu) --}}
        <div class="w-full md:w-1/2 p-8 md:p-10 bg-transparent flex flex-col justify-between transition-all duration-300 text-gray-800 dark:text-white font-poppins">
            <div>
                {{-- Judul & Deskripsi - Warna dinamis menyesuaikan mode --}}
                <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">{{ $menu->name }}</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-2 leading-relaxed">{{ Str::limit($menu->description, 100) }}</p>

                {{-- Pilihan Milk --}}
                <div class="mt-6">
                    <label class="block text-xs font-bold tracking-wider uppercase text-amber-700 dark:text-amber-300">🥛 Milk</label>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach(['Classic', 'Coconut', 'Almond'] as $milkOption)
                        <button type="button" data-milk="{{ $milkOption }}" 
                                class="milk-option px-4 py-1.5 text-xs rounded-full border transition-all duration-200 {{ $loop->first ? 'bg-amber-600 text-white border-amber-600 font-semibold' : 'border-gray-300 text-gray-600 hover:bg-gray-100 dark:border-white/20 dark:text-white/70 dark:hover:bg-white/5' }}">
                            {{ $milkOption }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Pilihan Size --}}
                <div class="mt-4">
                    <label class="block text-xs font-bold tracking-wider uppercase text-amber-700 dark:text-amber-300">📏 Size</label>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach(['280ml', '370ml', '450ml'] as $sizeOption)
                        <button type="button" data-size="{{ $sizeOption }}" 
                                class="size-option px-4 py-1.5 text-xs rounded-full border transition-all duration-200 {{ $loop->first ? 'bg-amber-600 text-white border-amber-600 font-semibold' : 'border-gray-300 text-gray-600 hover:bg-gray-100 dark:border-white/20 dark:text-white/70 dark:hover:bg-white/5' }}">
                            {{ $sizeOption }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Bagian Bawah: Harga & Tombol --}}
            <div class="mt-6">
                <div class="flex items-baseline mb-4">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Harga:</span>
                    <span id="dynamicPrice" class="text-2xl font-extrabold text-amber-600 dark:text-amber-500 ml-2">Rp {{ number_format($menu->price,0,',','.') }}</span>
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('cart.store') }}" method="POST" id="addToCartForm" class="flex-1">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <input type="hidden" name="milk" id="selectedMilk" value="Classic">
                        <input type="hidden" name="size" id="selectedSize" value="280ml">
                        <input type="hidden" name="unit_price" id="selectedPrice" value="{{ $menu->price }}">
                        <input type="hidden" name="quantity" value="1">
                        
                        {{-- Tombol Add to Cart adaptif dengan gaya kaca terang/gelap --}}
                        <button type="submit" class="w-full px-4 py-3 text-xs bg-transparent dark:bg-black/30 border border-amber-600 text-amber-600 dark:border-amber-500/50 dark:text-amber-400 rounded-full transition-all duration-200 font-bold flex items-center justify-center gap-2 hover:bg-amber-50 dark:hover:bg-white/5">
                            🛒 Add to Cart
                        </button>
                    </form>
                    
                    {{-- Tombol Order Now solid orange --}}
                    <button id="orderNowBtn" class="flex-1 px-4 py-3 text-xs bg-amber-600 text-white rounded-full hover:bg-amber-700 transition-all duration-200 font-bold shadow-md shadow-amber-600/10">
                        Order Now
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const basePrice = {{ $menu->price }};
    const priceMap = {
        '280ml': basePrice - 3000,
        '370ml': basePrice,
        '450ml': basePrice + 5000
    };
    let selectedMilk = 'Classic';
    let selectedSize = '280ml';

    {{-- Pembaruan class aktif & pasif agar mendukung warna teks terang/gelap --}}
    const activeClasses = ['bg-amber-600', 'text-white', 'border-amber-600', 'font-semibold'];
    const inactiveClasses = ['border-gray-300', 'text-gray-600', 'hover:bg-gray-100', 'dark:border-white/20', 'dark:text-white/70', 'dark:hover:bg-white/5'];

    document.querySelectorAll('.milk-option').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.milk-option').forEach(b => {
                b.classList.remove(...activeClasses);
                b.classList.add(...inactiveClasses);
            });
            btn.classList.remove(...inactiveClasses);
            btn.classList.add(...activeClasses);
            selectedMilk = btn.dataset.milk;
            document.getElementById('selectedMilk').value = selectedMilk;
        });
    });

    document.querySelectorAll('.size-option').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.size-option').forEach(b => {
                b.classList.remove(...activeClasses);
                b.classList.add(...inactiveClasses);
            });
            btn.classList.remove(...inactiveClasses);
            btn.classList.add(...activeClasses);
            selectedSize = btn.dataset.size;
            document.getElementById('selectedSize').value = selectedSize;
            
            let newPrice = priceMap[selectedSize];
            document.getElementById('selectedPrice').value = newPrice;
            document.getElementById('dynamicPrice').innerText = 'Rp ' + newPrice.toLocaleString('id-ID');
        });
    });

    document.getElementById('orderNowBtn').addEventListener('click', function() {
        document.getElementById('addToCartForm').submit();
    });

    // Favorite toggle AJAX
    const favoriteBtn = document.getElementById('favoriteBtn');
    if(favoriteBtn) {
        favoriteBtn.addEventListener('click', function() {
            const menuId = this.dataset.menuId;
            fetch(`/favorites/${menuId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ menu_id: menuId })
            })
            .then(response => response.json())
            .then(data => {
                const icon = document.getElementById('favoriteIcon');
                if(data.status === 'added') {
                    icon.setAttribute('fill', 'currentColor');
                } else {
                    icon.setAttribute('fill', 'none');
                }
            });
        });
    }
</script>
@endsection