<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/user.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <title>Keranjang Belanja</title>
</head>

<body>
    <header>
        @include('user.component.navbar') <!-- Navbar -->
    </header>
    <main class="container my-5">
        <h2>Keranjang Belanja</h2>

        @if (count($cart) > 0)
            <!-- Menampilkan jika ada produk dalam keranjang -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Kuantitas</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $id => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Menampilkan total harga dan tombol menuju pembayaran -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h4>Total: Rp
                    {{ number_format(
                        array_reduce(
                            $cart,
                            function ($carry, $item) {
                                return $carry + $item['price'] * $item['quantity'];
                            },
                            0,
                        ),
                        0,
                        ',',
                        '.',
                    ) }}
                </h4>
                <a href="{{ route('payment') }}" class="btn btn-primary btn-lg">Pembayaran</a>
            </div>
        @else
            <p>Keranjang Anda kosong.</p>
        @endif
    </main>
    @include('user.component.footer') <!-- Footer -->
</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script>

</html>
