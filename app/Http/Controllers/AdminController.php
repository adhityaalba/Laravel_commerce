<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Payment;
use App\Models\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }





    public function products()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }


    public function createProduct()
    {
        return view('admin.products.create');
    }

    // public function storeProduct(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'harga' => 'required|numeric',
    //         'stok' => 'required|integer',
    //         'deskripsi' => 'nullable|string',
    //         'kategori' => 'required|string|max:255',
    //     ]);

    //     Product::create($request->all());

    //     return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan.');
    // }
    public function editProduct($id)
    {
        // Mengambil produk berdasarkan ID
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    // public function updateProduct(Request $request, $id)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'harga' => 'required|numeric',
    //         'stok' => 'required|integer',
    //         'deskripsi' => 'nullable|string',
    //         'kategori' => 'required|string|max:255',
    //     ]);

    //     // Mengambil produk berdasarkan ID
    //     $product = Product::findOrFail($id);
    //     $product->update($request->all());

    //     return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui.');
    // }

    public function destroyProduct($id)
    {
        // Mengambil produk berdasarkan ID
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus.');
    }






    public function transactions()
    {
        $transactions = Payment::with('user')->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function updateTransactionStatus(Request $request, $id)
    {
        $transaction = Payment::findOrFail($id);
        $transaction->update(['status' => $request->status]);

        return back()->with('success', 'Status transaksi berhasil diperbarui');
    }




    public function customers()
    {
        $users = User::where('role', 'user')->get(); // Hanya ambil user dengan role "user"
        return view('admin.customers.index', compact('users'));
    }
    public function deleteCustomer($id)
    {
        $user = User::findOrFail($id); // Cari user berdasarkan ID
        $user->delete(); // Hapus user

        return redirect()->route('admin.customers')->with('success', 'Pelanggan berhasil dihapus.');
    }



    public function transactionDetails()
    {
        // Menampilkan detail transaksi (buat view untuk ini)
        return view('admin.transactions.details');
    }
}
