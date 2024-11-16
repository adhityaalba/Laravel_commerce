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
        $cart = Session::get('cart', []);  // Menyediakan default array kosong jika tidak ada data di session

        // Cek apakah cart kosong
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Hitung total harga dari semua item di cart
        $totalPrice = 0;
        foreach ($cart as $productId => $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Kirim data cart dan totalPrice ke view
        return view('payment.index', compact('cart', 'totalPrice'));
    }

    public function uploadPaymentProof(Request $request)
    {
        // Validasi file bukti pembayaran
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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
        $payment->user_id = auth()->id();  // Mengambil id user yang sedang login
        $payment->payment_proof = $path;
        $payment->status = 'pending';
        $payment->save();

        // Ambil data keranjang dari session
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Proses transaksi untuk setiap produk dalam keranjang
        foreach ($cart as $productId => $item) {
            // Cek apakah transaksi untuk produk ini sudah ada
            $existingTransaction = TransactionsUser::where('payment_id', $payment->id)
                ->where('product_id', $productId)
                ->first();

            if ($existingTransaction) {
                // Jika sudah ada, update transaksi dengan menambah kuantitas dan total harga
                $existingTransaction->quantity += $item['quantity'];
                $existingTransaction->total_price += $item['price'] * $item['quantity'];
                $existingTransaction->save();
            } else {
                // Jika belum ada, buat transaksi baru
                TransactionsUser::create([
                    'user_id' => auth()->id(),
                    'product_id' => $productId,
                    'payment_id' => $payment->id,
                    'quantity' => $item['quantity'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);
            }

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
