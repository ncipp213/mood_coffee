@extends('layouts.app')

@section('title', 'Menu Kopi')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-center text-coffee dark:text-yellow-400">Menu Kopi Kami</h1>
    <p class="text-center text-gray-600 dark:text-gray-300 mt-2">Pilih kopi favoritmu dan rasakan kenikmatannya</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($coffees as $coffee)
    <div class="coffee-card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
        <img src="{{ $coffee->image_url }}" alt="{{ $coffee->name }}" class="w-full h-48 object-cover">
        <div class="p-4">
            <div class="flex justify-between items-start">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $coffee->name }}</h2>
                <button class="favorite-btn text-2xl focus:outline-none" data-coffee-id="{{ $coffee->id }}">
                    <i class="fas fa-heart {{ Auth::check() && Auth::user()->favorites->contains('coffee_id', $coffee->id) ? 'text-red-500' : 'text-gray-400' }}"></i>
                </button>
            </div>
            <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">{{ Str::limit($coffee->description, 80) }}</p>
            <div class="flex justify-between items-center mt-4">
                <span class="text-lg font-bold text-coffee dark:text-yellow-400">{{ $coffee->price }}</span>
                <button class="add-to-cart bg-coffee hover:bg-coffee-dark text-white px-4 py-2 rounded-full text-sm transition"
                        data-coffee-id="{{ $coffee->id }}"
                        data-name="{{ $coffee->name }}"
                        data-image="{{ $coffee->image_url }}"
                        data-price="{{ $coffee->price }}">
                    <i class="fas fa-cart-plus mr-1"></i> Keranjang
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal untuk memilih susu & ukuran -->
<div id="cartModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-all">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md mx-4 transform transition-all scale-95 opacity-0" id="modalContent">
        <h3 class="text-xl font-bold mb-4 dark:text-white">Pilih Opsi</h3>
        <input type="hidden" id="modalCoffeeId">
        <input type="hidden" id="modalCoffeeName">
        <input type="hidden" id="modalCoffeeImage">
        <input type="hidden" id="modalCoffeePrice">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Jenis Susu</label>
            <select id="milkSelect" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="Regular Milk">Regular Milk</option>
                <option value="Oat Milk">Oat Milk</option>
                <option value="Almond Milk">Almond Milk</option>
                <option value="Soy Milk">Soy Milk</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Ukuran</label>
            <select id="sizeSelect" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="Small">Small (+Rp 0)</option>
                <option value="Medium">Medium (+Rp 5.000)</option>
                <option value="Large">Large (+Rp 10.000)</option>
            </select>
        </div>
        <div class="flex justify-end space-x-3 mt-6">
            <button id="cancelModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
            <button id="confirmAddToCart" class="px-4 py-2 bg-coffee text-white rounded hover:bg-coffee-dark">Tambah ke Keranjang</button>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity duration-300 opacity-0 pointer-events-none z-50"></div>
@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const toast = document.getElementById('toast');
    
    function showToast(message, isError = false) {
        toast.textContent = message;
        toast.classList.remove('bg-gray-800', 'bg-red-500');
        toast.classList.add(isError ? 'bg-red-500' : 'bg-green-500');
        toast.classList.remove('opacity-0');
        toast.classList.add('opacity-100');
        setTimeout(() => {
            toast.classList.remove('opacity-100');
            toast.classList.add('opacity-0');
        }, 3000);
    }

    // Favorite toggle
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            const coffeeId = this.dataset.coffeeId;
            const icon = this.querySelector('i');
            try {
                const res = await fetch(`/favorites/toggle/${coffeeId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.status === 'added') {
                    icon.classList.remove('text-gray-400');
                    icon.classList.add('text-red-500');
                    showToast('Ditambahkan ke favorit!');
                } else if (data.status === 'removed') {
                    icon.classList.remove('text-red-500');
                    icon.classList.add('text-gray-400');
                    showToast('Dihapus dari favorit');
                }
            } catch (err) { 
                console.error(err);
                showToast('Terjadi kesalahan', true);
            }
        });
    });

    // Modal logic
    const modal = document.getElementById('cartModal');
    const modalContent = document.getElementById('modalContent');
    const addButtons = document.querySelectorAll('.add-to-cart');
    let currentCoffee = {};

    addButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            currentCoffee = {
                id: btn.dataset.coffeeId,
                name: btn.dataset.name,
                image: btn.dataset.image,
                price: btn.dataset.price
            };
            document.getElementById('modalCoffeeId').value = currentCoffee.id;
            document.getElementById('modalCoffeeName').value = currentCoffee.name;
            document.getElementById('modalCoffeeImage').value = currentCoffee.image;
            document.getElementById('modalCoffeePrice').value = currentCoffee.price;
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    });

    document.getElementById('cancelModal').addEventListener('click', () => {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    });

    document.getElementById('confirmAddToCart').addEventListener('click', async () => {
        const coffeeId = document.getElementById('modalCoffeeId').value;
        const milk = document.getElementById('milkSelect').value;
        const size = document.getElementById('sizeSelect').value;
        
        // Disable button untuk mencegah double submit
        const confirmBtn = document.getElementById('confirmAddToCart');
        const originalText = confirmBtn.innerHTML;
        confirmBtn.innerHTML = '<i class="fas fa-spinner loader inline-block w-4 h-4 mr-2"></i> Menambah...';
        confirmBtn.disabled = true;
        
        try {
            const res = await fetch(`/cart/add/${coffeeId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ milk, size })
            });
            const data = await res.json();
            if (data.success) {
                showToast('Item ditambahkan ke keranjang!');
                document.getElementById('cancelModal').click();
            } else {
                showToast('Gagal menambahkan: ' + data.message, true);
            }
        } catch (err) {
            showToast('Error: ' + err, true);
        } finally {
            confirmBtn.innerHTML = originalText;
            confirmBtn.disabled = false;
        }
    });
</script>
@endpush