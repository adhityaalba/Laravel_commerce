<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="{{ asset('css/user.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <title>Detail Produk | {{ $product->nama }}</title>
</head>

<body>
    <main>
        <header>
            @include('user.component.navbar')
        </header>
        <section class="container mt-5">
            <h1>{{ $product->nama }}</h1>
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="img-fluid" />
                </div>
                <div class="col-md-6">
                    <h3>Detail Produk</h3>
                    <p><strong>Harga:</strong> Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                    <p><strong>Stok:</strong> {{ $product->stok }}</p>
                    <p><strong>Deskripsi:</strong> {{ $product->deskripsi }}</p>
                    <p><strong>Kategori:</strong> {{ $product->kategori }}</p>
                    <a href="{{ route('Home') }}" class="btn btn-primary">Kembali ke Halaman Utama</a>
                </div>
            </div>
        </section>
        @include('user.component.footer')
    </main>
</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script>

</html>
