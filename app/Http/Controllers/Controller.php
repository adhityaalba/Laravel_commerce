<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $products = Product::all(); // Mengambil semua produk
        return view('user.layout.index', [
            'title' => 'Home',
            'products' => $products // Mengirim data produk ke view
        ]);
    }
    public function product()
    {
        return view('products.index', [
            'title' => 'List',
        ]);
    }
}
