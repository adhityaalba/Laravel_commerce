<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Menampilkan transaksi pengguna
    public function showTransactions()
    {
        // Mengambil semua transaksi pengguna yang sedang login
        $transactions = Payment::where('user_id', auth()->id())->get();
        return view('transactions.index', compact('transactions'));
    }
}
