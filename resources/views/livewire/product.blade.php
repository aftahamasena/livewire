<div>
    <h2 class="text-2xl font-bold mb-4">Daftar Produk</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse ($products as $product)
            <div class="border rounded shadow p-4">
                @if ($product->picture)
                    <img src="{{ asset('storage/' . $product->picture) }}" alt="{{ $product->name }}"
                        class="w-full h-40 object-cover mb-2">
                @endif
                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                <p class="text-gray-700 text-sm">{{ $product->description }}</p>
                <p class="mt-2 font-bold text-blue-600">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
        @empty
            <p>Tidak ada produk.</p>
        @endforelse
    </div>
</div>
