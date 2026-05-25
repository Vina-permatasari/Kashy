<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // Get laporan untuk kasir (hari ini) - API JSON
    public function getLaporanHariIni()
    {
        try {
            $user = Auth::user();
            $today = today();
            
            // Total Penjualan & Total Transaksi
            $totalPenjualan = Transaction::where('kasir_id', $user->id)
                ->whereDate('created_at', $today)
                ->sum('grand_total');
            
            $totalTransaksi = Transaction::where('kasir_id', $user->id)
                ->whereDate('created_at', $today)
                ->count();
            
            // Penjualan per Kategori
            $penjualanPerKategori = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
                ->join('products', 'transaction_details.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('transactions.kasir_id', $user->id)
                ->whereDate('transactions.created_at', $today)
                ->select('categories.nama_kategori as category_name', DB::raw('SUM(transaction_details.subtotal) as total'))
                ->groupBy('categories.id', 'categories.nama_kategori')
                ->orderBy('total', 'desc')
                ->get();
            
            // Produk Terlaris
            $produkTerlaris = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
                ->join('products', 'transaction_details.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('transactions.kasir_id', $user->id)
                ->whereDate('transactions.created_at', $today)
                ->select('categories.nama_kategori as category_name', DB::raw('SUM(transaction_details.qty) as total_terjual'))
                ->groupBy('categories.id', 'categories.nama_kategori')
                ->orderBy('total_terjual', 'desc')
                ->limit(5)
                ->get();
            
            // Metode Pembayaran (persentase)
            $metodePembayaran = Transaction::where('kasir_id', $user->id)
                ->whereDate('created_at', $today)
                ->select('metode_pembayaran', DB::raw('COUNT(*) as total'))
                ->groupBy('metode_pembayaran')
                ->get();
            
            $totalMetode = $metodePembayaran->sum('total');
            $metodePersentase = [];
            foreach ($metodePembayaran as $metode) {
                $persen = $totalMetode > 0 ? round(($metode->total / $totalMetode) * 100) : 0;
                $namaMetode = $metode->metode_pembayaran;
                if ($namaMetode == 'cash') $namaMetode = 'Tunai';
                if ($namaMetode == 'qris') $namaMetode = 'QRIS';
                if ($namaMetode == 'transfer') $namaMetode = 'Transfer';
                $metodePersentase[] = [
                    'name' => $namaMetode,
                    'total' => $metode->total,
                    'percentage' => $persen
                ];
            }
            
            // Hitung max untuk bar width
            $maxKategori = $penjualanPerKategori->isNotEmpty() ? $penjualanPerKategori->first()->total : 1;
            
            return response()->json([
                'success' => true,
                'data' => [
                    'total_penjualan' => (int) $totalPenjualan,
                    'total_transaksi' => (int) $totalTransaksi,
                    'penjualan_per_kategori' => $penjualanPerKategori->map(function($item) use ($maxKategori) {
                        return [
                            'name' => $item->category_name,
                            'total' => (int) $item->total,
                            'percentage' => $maxKategori > 0 ? round(($item->total / $maxKategori) * 100) : 0
                        ];
                    }),
                    'produk_terlaris' => $produkTerlaris->map(function($item, $index) {
                        return [
                            'rank' => $index + 1,
                            'name' => $item->category_name,
                            'terjual' => (int) $item->total_terjual
                        ];
                    }),
                    'metode_pembayaran' => $metodePersentase
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    // Export ke PDF
    public function exportPDF()
    {
        $user = Auth::user();
        $today = today();
        
        // Total Penjualan & Total Transaksi
        $totalPenjualan = Transaction::where('kasir_id', $user->id)
            ->whereDate('created_at', $today)
            ->sum('grand_total');
        
        $totalTransaksi = Transaction::where('kasir_id', $user->id)
            ->whereDate('created_at', $today)
            ->count();
        
        // Penjualan per Kategori
        $penjualanPerKategori = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('transactions.kasir_id', $user->id)
            ->whereDate('transactions.created_at', $today)
            ->select('categories.nama_kategori as category_name', DB::raw('SUM(transaction_details.subtotal) as total'))
            ->groupBy('categories.id', 'categories.nama_kategori')
            ->orderBy('total', 'desc')
            ->get();
        
        // Produk Terlaris
        $produkTerlaris = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('transactions.kasir_id', $user->id)
            ->whereDate('transactions.created_at', $today)
            ->select('categories.nama_kategori as category_name', DB::raw('SUM(transaction_details.qty) as total_terjual'))
            ->groupBy('categories.id', 'categories.nama_kategori')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->get();
        
        // Metode Pembayaran
        $metodePembayaran = Transaction::where('kasir_id', $user->id)
            ->whereDate('created_at', $today)
            ->select('metode_pembayaran', DB::raw('COUNT(*) as total'))
            ->groupBy('metode_pembayaran')
            ->get();
        
        $totalMetode = $metodePembayaran->sum('total');
        $metodePersentase = [];
        foreach ($metodePembayaran as $metode) {
            $persen = $totalMetode > 0 ? round(($metode->total / $totalMetode) * 100) : 0;
            $namaMetode = $metode->metode_pembayaran;
            if ($namaMetode == 'cash') $namaMetode = 'Tunai';
            if ($namaMetode == 'qris') $namaMetode = 'QRIS';
            if ($namaMetode == 'transfer') $namaMetode = 'Transfer';
            $metodePersentase[] = [
                'name' => $namaMetode,
                'total' => $metode->total,
                'percentage' => $persen
            ];
        }
        
        $data = [
            'user' => $user,
            'date' => $today,
            'date_formatted' => $today->format('d F Y'),
            'total_penjualan' => $totalPenjualan,
            'total_transaksi' => $totalTransaksi,
            'penjualan_per_kategori' => $penjualanPerKategori,
            'produk_terlaris' => $produkTerlaris,
            'metode_pembayaran' => $metodePersentase
        ];
        
        $pdf = Pdf::loadView('kasir.laporan-pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('laporan-penjualan-' . $today->format('Y-m-d') . '.pdf');
    }
}