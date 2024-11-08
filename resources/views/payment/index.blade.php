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
    <title>Halaman Pembayaran</title>
</head>

<body>
    <header>
        @include('user.component.navbar')
    </header>

    <main class="container my-5">
        <h2>Invoice Pembayaran</h2>

        <div class="row">
            <div class="col-md-8">
                <h4>Daftar Produk</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $id => $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-between">
                    <h4>Total Pembayaran: Rp {{ number_format($total, 0, ',', '.') }}</h4>
                </div>
            </div>

            <div class="col-md-4">
                <h4>Upload Bukti Pembayaran</h4>
                <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Bukti Pembayaran (gambar)</label>
                        <input type="file" class="form-control" name="payment_proof" id="payment_proof" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Bukti Pembayaran</button>
                </form>

                <div class="my-4">
                    <h5>Detail Lokasi dan Ongkir</h5>
                    <p>Lokasi Pengiriman: <span id="user-location">Semarang</span></p>
                    <p>Dikirim dari: Kediri</p>
                    <p>Ongkir: Rp <span id="ongkir"></span></p>
                    <h4>Total Pembayaran Akhir: Rp <span id="totalPembayaran"></span></h4>
                </div>

            </div>
        </div>
    </main>

    @include('user.component.footer')

    <script>
        // Fungsi untuk menghasilkan ongkir random dalam range 15.000 hingga 25.000
        function getRandomOngkir(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        document.addEventListener('DOMContentLoaded', () => {
            let ongkir;

            // Cek apakah ongkir sudah disimpan di localStorage
            if (localStorage.getItem('ongkir')) {
                ongkir = parseInt(localStorage.getItem('ongkir'));
            } else {
                // Jika belum ada, buat ongkir baru dan simpan di localStorage
                ongkir = getRandomOngkir(15000, 25000);
                localStorage.setItem('ongkir', ongkir);
            }

            const totalPembayaran = {{ $total }}; // Total dari server
            const totalAkhir = totalPembayaran + ongkir;

            // Menampilkan ongkir dan total akhir di halaman
            document.getElementById('ongkir').innerText = new Intl.NumberFormat('id-ID').format(ongkir);
            document.getElementById('totalPembayaran').innerText = new Intl.NumberFormat('id-ID').format(
                totalAkhir);

            // Gimmick permintaan izin lokasi
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        console.log('Location permission granted, but using static location.');
                    },
                    error => {
                        console.log('Location access denied.');
                    }
                );
            } else {
                console.log('Geolocation is not supported by this browser.');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
</body>

</html>
