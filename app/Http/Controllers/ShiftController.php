<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    // Aktifkan shift dari dashboard
    public function aktifkanShift(Request $request)
    {
        $user = Auth::user();
        $today = date('Y-m-d');
        
        // Cari attendance hari ini
        $attendance = Attendance::where('user_id', $user->id)
                                ->whereDate('created_at', $today)
                                ->first();
        
        if (!$attendance) {
            // Buat baru dengan shift_status = aktif, status = 'hadir'
            Attendance::create([
                'user_id' => $user->id,
                'check_in' => null,
                'check_out' => null,
                'status' => 'hadir',     // WAJIB DIISI karena enum tidak boleh NULL
                'shift_status' => 'aktif'
            ]);
        } else {
            // Update shift_status jadi aktif
            $attendance->update([
                'shift_status' => 'aktif'
            ]);
        }
        
        // Langsung redirect ke halaman absensi
        return redirect()->route('absensi')->with('success', 'Shift berhasil diaktifkan');
    }
    
    // Handle tombol sidik jari (TEKAN untuk absensi)
    public function handleAbsensi(Request $request)
    {
        $user = Auth::user();
        $today = date('Y-m-d');
        
        $attendance = Attendance::where('user_id', $user->id)
                                ->whereDate('created_at', $today)
                                ->first();
        
        // Cek apakah shift aktif
        if (!$attendance || $attendance->shift_status !== 'aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Shift belum diaktifkan'
            ], 400);
        }
        
        // Jika sudah selesai
        if ($attendance->shift_status === 'selesai') {
            return response()->json([
                'success' => false,
                'message' => 'Shift sudah selesai'
            ], 400);
        }
        
        // Jika belum check_in
        if (!$attendance->check_in) {
            // MULAI BEKERJA
            $attendance->update([
                'check_in' => now(),
                'status' => 'hadir'
            ]);
            
            return response()->json([
                'success' => true,
                'action' => 'mulai',
                'message' => 'Selamat bekerja!',
                'check_in' => date('H:i:s', strtotime($attendance->check_in))
            ]);
        }
        
        // Jika sudah check_in tapi belum check_out
        if ($attendance->check_in && !$attendance->check_out) {
            // SELESAI BEKERJA
            $attendance->update([
                'check_out' => now(),
                'shift_status' => 'selesai'
            ]);
            
            return response()->json([
                'success' => true,
                'action' => 'selesai',
                'message' => 'Shift selesai!',
                'check_out' => date('H:i:s', strtotime($attendance->check_out))
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Status tidak diketahui'
        ], 400);
    }
    
    // Cek status shift untuk tampilan
    public function cekStatus()
    {
        $user = Auth::user();
        $today = date('Y-m-d');
        
        $attendance = Attendance::where('user_id', $user->id)
                                ->whereDate('created_at', $today)
                                ->first();
        
        if (!$attendance) {
            return response()->json([
                'shift_status' => 'tidak_aktif',
                'check_in' => null,
                'check_out' => null
            ]);
        }
        
        return response()->json([
            'shift_status' => $attendance->shift_status,
            'check_in' => $attendance->check_in ? date('H:i:s', strtotime($attendance->check_in)) : null,
            'check_out' => $attendance->check_out ? date('H:i:s', strtotime($attendance->check_out)) : null
        ]);
    }
    
    // Ambil history absensi karyawan (TAMBAHKAN METHOD INI)
    public function getHistory()
    {
        $user = Auth::user();
        
        // Ambil 5 history terakhir (selain hari ini, urut dari terbaru)
        $histories = Attendance::where('user_id', $user->id)
            ->whereNotNull('check_in')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $result = [];
        foreach ($histories as $history) {
            $result[] = [
                'date' => $history->created_at->translatedFormat('d M Y'),
                'check_in' => $history->check_in ? date('H:i', strtotime($history->check_in)) : '--',
                'check_out' => $history->check_out ? date('H:i', strtotime($history->check_out)) : '--',
                'status' => $history->status ?? 'hadir'
            ];
        }
        
        return response()->json($result);
    }
}