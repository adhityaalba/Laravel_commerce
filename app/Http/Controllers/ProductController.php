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
             'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
 
         // Inisialisasi data yang akan disimpan
         $data = $request->all();
 
         // Proses upload gambar jika ada
         if ($request->hasFile('gambar')) {
             $image = $request->file('gambar');
             $fileName = time() . '.' . $image->getClientOriginalExtension();
             $image->move(public_path('images/products'), $fileName); // Simpan ke public/images/products
             $data['gambar'] = 'images/products/' . $fileName;
         }
 
         // Simpan data produk ke database
         Product::create($data);
 
         return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan.');
     }
 
     // Memperbarui data produk
     public function update(Request $request, $id)
     {
         $request->validate([
             'nama' => 'required|string|max:255',
             'harga' => 'required|numeric',
             'stok' => 'required|integer',
             'deskripsi' => 'nullable|string',
             'kategori' => 'required|string|max:255',
             'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
 
         // Ambil produk berdasarkan ID
         $product = Product::findOrFail($id);
 
         // Inisialisasi data yang akan diperbarui
         $data = $request->all();
 
         // Proses upload gambar baru jika ada
         if ($request->hasFile('gambar')) {
             // Hapus gambar lama jika ada
             if ($product->gambar && file_exists(public_path($product->gambar))) {
                 unlink(public_path($product->gambar));
             }
 
             // Simpan gambar baru
             $image = $request->file('gambar');
             $fileName = time() . '.' . $image->getClientOriginalExtension();
             $image->move(public_path('images/products'), $fileName);
             $data['gambar'] = 'images/products/' . $fileName;
         }
 
         // Update data produk di database
         $product->update($data);
 
         return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui.');
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
