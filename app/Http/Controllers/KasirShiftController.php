<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class KasirShiftController extends Controller
{
    private $minSaldoAwal = 50000; // Minimal Rp 50.000
    
    // Cek status shift kasir saat ini
    public function cekStatus()
    {
        $user = Auth::user();
        
        $shiftAktif = Shift::where('kasir_id', $user->id)
                           ->where('status', 'open')
                           ->first();
        
        if (!$shiftAktif) {
            return response()->json([
                'shift_active' => false,
                'shift' => null
            ]);
        }
        
        // Hitung total penjualan hari ini
        $totalPenjualan = Transaction::where('kasir_id', $user->id)
                                     ->whereDate('created_at', today())
                                     ->sum('grand_total');
        
        // Hitung penjualan per metode
        $penjualanTunai = Transaction::where('kasir_id', $user->id)
                                     ->whereDate('created_at', today())
                                     ->where('metode_pembayaran', 'cash')
                                     ->sum('grand_total');
        
        $penjualanQris = Transaction::where('kasir_id', $user->id)
                                    ->whereDate('created_at', today())
                                    ->where('metode_pembayaran', 'qris')
                                    ->sum('grand_total');
        
        $penjualanDebit = Transaction::where('kasir_id', $user->id)
                                     ->whereDate('created_at', today())
                                     ->where('metode_pembayaran', 'transfer')
                                     ->sum('grand_total');
        
        return response()->json([
            'shift_active' => true,
            'shift' => [
                'id' => $shiftAktif->id,
                'saldo_awal' => $shiftAktif->saldo_awal,
                'saldo_akhir' => $shiftAktif->saldo_akhir,
                'total_penjualan' => $totalPenjualan,
                'penjualan_tunai' => $penjualanTunai,
                'penjualan_qris' => $penjualanQris,
                'penjualan_debit' => $penjualanDebit,
                'waktu_buka' => $shiftAktif->waktu_buka->format('H:i'),
                'waktu_buka_full' => $shiftAktif->waktu_buka->toIso8601String()
            ]
        ]);
    }
    
    // Buka shift
    public function bukaShift(Request $request)
    {
        $request->validate([
            'saldo_awal' => 'required|integer|min:' . $this->minSaldoAwal
        ]);
        
        $user = Auth::user();
        
        // Cek apakah sudah buka shift hari ini (1 hari hanya 1 shift)
        $shiftHariIni = Shift::where('kasir_id', $user->id)
                             ->whereDate('waktu_buka', today())
                             ->first();
        
        if ($shiftHariIni) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan shift hari ini. Shift hanya bisa dilakukan 1 kali per hari.'
            ], 400);
        }
        
        // Cek apakah sudah ada shift aktif
        $shiftAktif = Shift::where('kasir_id', $user->id)
                           ->where('status', 'open')
                           ->first();
        
        if ($shiftAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Masih ada shift yang aktif. Tutup shift terlebih dahulu.'
            ], 400);
        }
        
        $shift = Shift::create([
            'kasir_id' => $user->id,
            'saldo_awal' => $request->saldo_awal,
            'saldo_akhir' => null,
            'total_penjualan' => 0,
            'status' => 'open',
            'waktu_buka' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Shift berhasil dibuka',
            'shift' => [
                'id' => $shift->id,
                'saldo_awal' => $shift->saldo_awal,
                'waktu_buka' => $shift->waktu_buka->format('H:i')
            ]
        ]);
    }
    
    // Tutup shift
    public function tutupShift(Request $request)
    {
        $request->validate([
            'uang_tunai_aktual' => 'required|integer|min:0'
        ]);
        
        $user = Auth::user();
        
        $shift = Shift::where('kasir_id', $user->id)
                      ->where('status', 'open')
                      ->first();
        
        if (!$shift) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada shift aktif'
            ], 400);
        }
        
        // Hitung total penjualan
        $totalPenjualan = Transaction::where('kasir_id', $user->id)
                                     ->whereDate('created_at', today())
                                     ->sum('grand_total');
        
        // Hitung penjualan tunai
        $penjualanTunai = Transaction::where('kasir_id', $user->id)
                                     ->whereDate('created_at', today())
                                     ->where('metode_pembayaran', 'cash')
                                     ->sum('grand_total');
        
        // Hitung penjualan non-tunai
        $penjualanNonTunai = Transaction::where('kasir_id', $user->id)
                                        ->whereDate('created_at', today())
                                        ->whereIn('metode_pembayaran', ['qris', 'transfer'])
                                        ->sum('grand_total');
        
        $ekspektasiTunai = $shift->saldo_awal + $penjualanTunai;
        $selisih = $request->uang_tunai_aktual - $ekspektasiTunai;
        
        $shift->update([
            'saldo_akhir' => $request->uang_tunai_aktual,
            'total_penjualan' => $totalPenjualan,
            'status' => 'closed',
            'waktu_tutup' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Shift berhasil ditutup',
            'selisih' => $selisih,
            'ekspektasi_tunai' => $ekspektasiTunai,
            'penjualan_tunai' => $penjualanTunai,
            'penjualan_non_tunai' => $penjualanNonTunai,
            'total_penjualan' => $totalPenjualan
        ]);
    }
    
    // Dapatkan minimal saldo awal
    public function getMinSaldo()
    {
        return response()->json([
            'min_saldo' => $this->minSaldoAwal
        ]);
    }
}