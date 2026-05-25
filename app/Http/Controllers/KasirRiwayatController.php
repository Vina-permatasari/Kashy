<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirRiwayatController extends Controller
{
    public function index()
    {
        // Ambil transaksi berdasarkan kasir yang login
        $transactions = Transaction::with('details')
            ->where('kasir_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($transaction) {
                // Grouping berdasarkan tanggal (format: 26 Mei 2026)
                return $transaction->created_at->translatedFormat('d F Y');
            });
        
        return view('kasir.riwayat-transaksi', compact('transactions'));
    }
}