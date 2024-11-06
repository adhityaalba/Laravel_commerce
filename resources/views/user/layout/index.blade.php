<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="{{ asset('css/user.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />

    <title>Griya Bibit | {{ $title }}</title>
</head>

<body>
    <main>
        <header>
            @include('user.component.navbar')
        </header>
        @include('products.index')
        @include('user.component.footer')
    </main>

    <!-- Skrip untuk Add to Cart -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            const cartCountElement = document.querySelector(
            '.notif .circle'); // Elemen yang menampilkan jumlah keranjang

            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Cek apakah pengguna sudah login
                    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

                    if (!isLoggedIn) {
                        // Tampilkan SweetAlert
                        Swal.fire({
                            icon: 'warning',
                            title: 'HARAP LOGIN TERLEBIH DAHULU!',
                            text: 'Anda perlu login untuk menambahkan produk ke keranjang.',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Jika sudah login, lakukan aksi untuk menambahkan ke keranjang
                        const productId = this.getAttribute('data-id');
                        const url = `/cart/add/${productId}`;

                        // Kirim permintaan POST ke server untuk menambahkan ke keranjang
                        fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                            })
                            .then(response => {
                                if (response.ok) {
                                    return response.json();
                                }
                                throw new Error('Network response was not ok.');
                            })
                            .then(data => {
                                // Update jumlah kuantitas di keranjang
                                cartCountElement.textContent = data
                                .totalItems; // Update tampilan kuantitas

                                // Tampilkan SweetAlert sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses!',
                                    text: 'Produk berhasil ditambahkan ke keranjang.',
                                    confirmButtonText: 'OK'
                                });
                            })
                            .catch(error => {
                                console.error('Ada masalah dengan fetch operation:', error);
                            });
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>
