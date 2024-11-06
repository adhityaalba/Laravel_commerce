<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tampil daftar produk
    public function index()
    {
        $products = Product::all(); // Mengambil semua produk
        return view('products.index', compact('products')); // Kembali ke view
    }

    // Menampilkan form untuk menambah produk baru
    public function create()
    {
        return view('products.create'); // Mengembalikan view untuk form tambah produk
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $data = $request->all(); // Mengambil semua data dari request

        // Mengunggah gambar jika ada
        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/products'), $imageName);
            $data['gambar'] = 'images/products/' . $imageName; // Menyimpan path ke database
        }

        Product::create($data); // Menyimpan produk ke database

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Menampilkan detail produk
    public function show($id)
    {
        $product = Product::findOrFail($id); // Mengambil produk berdasarkan ID
        return view('products.show', compact('product')); // Kembali ke view detail produk
    }

    // Menampilkan form untuk mengedit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id); // Mengambil produk berdasarkan ID
        return view('products.edit', compact('product')); // Kembali ke view edit produk
    }

    // Mengupdate produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $product = Product::findOrFail($id); // Mengambil produk berdasarkan ID
        $data = $request->all(); // Mengambil semua data dari request

        // Mengunggah gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika perlu
            if ($product->gambar) {
                unlink(public_path($product->gambar)); // Menghapus gambar dari server
            }

            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/products'), $imageName);
            $data['gambar'] = 'images/products/' . $imageName; // Menyimpan path ke database
        }

        $product->update($data); // Mengupdate produk

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id); // Mengambil produk berdasarkan ID

        // Hapus gambar dari server jika ada
        if ($product->gambar) {
            unlink(public_path($product->gambar)); // Menghapus gambar dari server
        }

        $product->delete(); // Menghapus produk

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
