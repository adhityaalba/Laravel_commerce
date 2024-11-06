<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CartController extends Controller
{
    // LIST KERANJANG
    public function index()
    {
        // Mengambil cart dari sesi
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }


    public function add($id)
    {
        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);

        // Periksa apakah produk sudah ada di cart
        if (isset($cart[$id])) {
            // Jika ada, tambahkan jumlahnya
            $cart[$id]['quantity']++;
        } else {
            // Jika tidak ada, tambahkan produk baru ke cart
            $cart[$id] = [
                'name' => $product->nama,
                'price' => $product->harga,
                'quantity' => 1,
                'gambar' => $product->gambar,
            ];
        }

        // Simpan kembali cart ke session
        Session::put('cart', $cart);

        // Hitung total item di cart
        $totalQuantity = self::countItems();

        // Kembali dengan respons JSON
        return response()->json(['totalItems' => $totalQuantity]);
    }


    public function remove($id)
    {
        $cart = Session::get('cart', []);
        unset($cart[$id]);
        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public static function countItems()
    {
        $cart = Session::get('cart', []);
        $totalQuantity = 0;

        // Hitung total kuantitas dari semua item
        foreach ($cart as $item) {
            $totalQuantity += $item['quantity'];
        }

        return $totalQuantity;
    }
}
