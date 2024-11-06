<section class="container my-5">
    <h2>Daftar Produk</h2>
    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset($product->gambar) }}" class="card-img-top" alt="{{ $product->nama }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->nama }}</h5>
                        <p class="card-text">Harga: Rp{{ number_format($product->harga, 0, ',', '.') }}</p>
                        <p class="card-text">Stok: {{ $product->stok }}</p>
                        <button type="button" class="btn btn-primary add-to-cart" data-id="{{ $product->id }}">Add to
                            Cart</button>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada produk tersedia.</p>
        @endforelse
    </div>
</section>
