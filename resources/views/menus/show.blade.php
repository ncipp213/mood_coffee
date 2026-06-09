@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">
        <div class="md:flex">
            {{-- Gambar --}}
            <div class="md:w-1/2 h-64 md:h-auto bg-amber-100">
                <img src="{{ $menu->image_url ?? 'https://picsum.photos/id/225/600/600' }}" class="w-full h-full object-cover">
            </div>

            {{-- Detail --}}
            <div class="md:w-1/2 p-6 md:p-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $menu->name }}</h1>
                <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $menu->description }}</p>

                {{-- Pilihan Milk --}}
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">🥛 Milk</label>
                    <div class="flex gap-3 mt-2">
                        @foreach(['Classic', 'Coconut', 'Almond'] as $milkOption)
                        <button type="button" data-milk="{{ $milkOption }}" 
                                class="milk-option px-4 py-2 rounded-full border {{ $loop->first ? 'bg-amber-600 text-white border-amber-600' : 'border-amber-300 dark:border-gray-600' }}">
                            {{ $milkOption }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Pilihan Size --}}
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">📏 Size</label>
                    <div class="flex gap-3 mt-2">
                        @foreach(['280ml', '370ml', '450ml'] as $sizeOption)
                        <button type="button" data-size="{{ $sizeOption }}" 
                                class="size-option px-4 py-2 rounded-full border {{ $loop->first ? 'bg-amber-600 text-white border-amber-600' : 'border-amber-300 dark:border-gray-600' }}">
                            {{ $sizeOption }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Harga Dinamis --}}
                <div class="mt-6">
                    <span class="text-gray-500">Harga:</span>
                    <span id="dynamicPrice" class="text-3xl font-bold text-amber-700 dark:text-amber-400 ml-2">Rp {{ number_format($menu->price,0,',','.') }}</span>
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-8 flex gap-4">
                    <form action="{{ route('cart.store') }}" method="POST" id="addToCartForm">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <input type="hidden" name="milk" id="selectedMilk" value="Classic">
                        <input type="hidden" name="size" id="selectedSize" value="370ml">
                        <input type="hidden" name="unit_price" id="selectedPrice" value="{{ $menu->price }}">
                        <button type="submit" class="px-6 py-3 border-2 border-amber-600 text-amber-600 rounded-full hover:bg-amber-50 transition font-semibold">
                            🛒 Add to Cart
                        </button>
                    </form>
                    <button id="orderNowBtn" class="px-6 py-3 bg-amber-600 text-white rounded-full hover:bg-amber-700 transition shadow-md font-semibold">
                        ⚡ Order Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const priceMap = {
        '280ml': {{ $menu->price - 3000 }},
        '370ml': {{ $menu->price }},
        '450ml': {{ $menu->price + 5000 }}
    };
    let selectedMilk = 'Classic';
    let selectedSize = '370ml';

    document.querySelectorAll('.milk-option').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.milk-option').forEach(b => b.classList.remove('bg-amber-600', 'text-white', 'border-amber-600'));
            btn.classList.add('bg-amber-600', 'text-white', 'border-amber-600');
            selectedMilk = btn.dataset.milk;
            document.getElementById('selectedMilk').value = selectedMilk;
        });
    });

    document.querySelectorAll('.size-option').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.size-option').forEach(b => b.classList.remove('bg-amber-600', 'text-white', 'border-amber-600'));
            btn.classList.add('bg-amber-600', 'text-white', 'border-amber-600');
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
</script>
@endsection