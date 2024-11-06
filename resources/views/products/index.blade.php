<section class="container my-5">
    <h2 class="text-center mb-4">Daftar Produk</h2>
    <div class="row">
        @forelse ($products as $product)
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-img-wrapper">
                        <img src="{{ asset($product->gambar) }}" class="card-img-top" alt="{{ $product->nama }}">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center">{{ $product->nama }}</h5>
                        <p class="card-text text-center">Harga: Rp{{ number_format($product->harga, 0, ',', '.') }}</p>
                        <p class="card-text text-center">Stok: {{ $product->stok }}</p>
                        <div class="mt-auto d-flex justify-content-between">
                            <button type="button" class="btn btn-primary btn-sm add-to-cart"
                                data-id="{{ $product->id }}">
                                Add to Cart
                            </button>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary btn-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada produk tersedia.</p>
        @endforelse
    </div>
</section>

<style>
    .card-img-wrapper {
        width: 100%;
        height: 200px;
        /* Membuat ukuran gambar seragam */
        overflow: hidden;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Agar gambar memenuhi area dengan proporsi */
    }

    .card {
        border-radius: 8px;
    }
</style>
