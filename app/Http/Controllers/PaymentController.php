<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\TransactionsUser;

class PaymentController extends Controller
{
    public function index()
    {
        // Ambil cart dari session
        $cart = Session::get('cart', []);
        // Cek apakah cart kosong
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }
        // Hitung total harga dari semua item di cart
        $totalPrice = 0;
        foreach ($cart as $productId => $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        // Hitung ongkir
        $ongkir = rand(10000, 30000);  // Ongkir acak antara 10.000 dan 30.000
        // Total pembayaran akhir
        $totalPembayaranAkhir = $totalPrice + $ongkir;
        // Kirim data cart, totalPrice, ongkir, dan totalPembayaranAkhir ke view
        return view('payment.index', compact('cart', 'totalPrice', 'ongkir', 'totalPembayaranAkhir'));
    }




    public function uploadPaymentProof(Request $request)
    {
        // Validasi file bukti pembayaran
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil data keranjang dari session
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Hitung total harga dari semua item di cart
        $totalPrice = 0;
        foreach ($cart as $productId => $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Hitung ongkir
        $ongkir = rand(10000, 30000);  // Ongkir acak antara 10.000 dan 30.000

        // Total pembayaran akhir
        $totalPembayaranAkhir = $totalPrice + $ongkir;

        // Menyimpan gambar bukti pembayaran
        if ($request->hasFile('payment_proof') && $request->file('payment_proof')->isValid()) {
            $paymentProof = $request->file('payment_proof');
            $fileName = time() . '.' . $paymentProof->getClientOriginalExtension();
            $paymentProof->move(public_path('storage/payment_proofs'), $fileName);
            $path = 'payment_proofs/' . $fileName;
        } else {
            return redirect()->back()->with('error', 'File yang diupload tidak valid.');
        }

        // Menyimpan data pembayaran ke database
        $payment = new Payment();
        $payment->user_id = auth()->id();
        $payment->payment_proof = $path;
        $payment->status = 'pending';
        $payment->ongkir = $ongkir;  // Menyimpan ongkir
        $payment->total_amount = $totalPembayaranAkhir;  // Menyimpan total pembayaran akhir (harga produk + ongkir)
        $payment->save();

        // Proses transaksi untuk setiap produk dalam keranjang
        foreach ($cart as $productId => $item) {
            TransactionsUser::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'payment_id' => $payment->id,
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity'],
            ]);

            // Kurangi stok produk
            $product = Product::findOrFail($productId);
            $product->decrement('stok', $item['quantity']);
        }

        // Kosongkan keranjang setelah transaksi selesai
        Session::forget('cart');

        // Redirect ke halaman pembayaran dengan pesan sukses
        return redirect()->route('payment')->with('success', 'Bukti pembayaran berhasil diunggah dan keranjang telah dikosongkan.');
    }
}
