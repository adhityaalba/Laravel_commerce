<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/user.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <title>Riwayat Transaksi</title>
</head>

<body>
    <header>
        @include('user.component.navbar') <!-- Navbar -->
    </header>
    <main>
        <div class="container my-5">
            <h2>Daftar Transaksi Anda</h2>

            @if ($transactions->isEmpty())
                <p>Belum ada transaksi.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No_Invoice</th>
                            <th>Produk</th>
                            <th>Kuantitas</th>
                            <th>Total Harga</th>
                            <th>Status Pembayaran</th>
                            <th>Tanggal Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions->groupBy('payment_id') as $paymentId => $groupedTransactions)
                            <tr>
                                <!-- Nomor Invoice -->
                                <td>INV-{{ $paymentId }}</td>

                                <!-- Produk yang Dibeli -->
                                <td>
                                    @foreach ($groupedTransactions as $transaction)
                                        {{ $transaction->product->nama }}<br>
                                    @endforeach
                                </td>

                                <!-- Kuantitas -->
                                <td>
                                    @foreach ($groupedTransactions as $transaction)
                                        {{ $transaction->quantity }}<br>
                                    @endforeach
                                </td>

                                <!-- Total Harga -->
                                <td>
                                    @php
                                        $totalPrice = 0;
                                        foreach ($groupedTransactions as $transaction) {
                                            $totalPrice += $transaction->total_price;
                                        }
                                    @endphp
                                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                </td>

                                <!-- Status Pembayaran -->
                                <td>
                                    @if ($groupedTransactions[0]->payment->status == 'paid')
                                        <span class="badge bg-success">Sudah Dibayar</span>
                                    @elseif ($groupedTransactions[0]->payment->status == 'pending')
                                        <span class="badge bg-warning">Menunggu Pembayaran</span>
                                    @elseif ($groupedTransactions[0]->payment->status == 'approved')
                                        <span class="badge bg-info">Disetujui</span>
                                    @elseif ($groupedTransactions[0]->payment->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>

                                <!-- Tanggal Pembayaran -->
                                <td>{{ $groupedTransactions[0]->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
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
