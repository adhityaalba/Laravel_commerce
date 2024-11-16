<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\TransactionsUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Menampilkan transaksi pengguna
    public function showTransactions()
    {
        // Ambil data transaksi user yang sedang login
        $transactions = TransactionsUser::with('product', 'payment')
            ->where('user_id', auth()->id())
            ->get();

        return view('transactions.index', compact('transactions'));
    }
}
