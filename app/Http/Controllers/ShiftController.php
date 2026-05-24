<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    /**
     * Handle absensi (satu tombol untuk mulai & selesai)
     */
    public function handleAbsensi(Request $request)
    {
        $user = Auth::user();
        $today = date('Y-m-d');
        
        $attendance = Attendance::where('user_id', $user->id)
                                ->whereDate('created_at', $today)
                                ->first();
        
        // KASUS 1: BELUM ADA DATA ATAU BELUM CHECK_IN
        if (!$attendance || !$attendance->check_in) {
            $checkInTime = now();
            $shiftInfo = $this->getShiftFromTime($checkInTime);
            
            if (!$attendance) {
                $attendance = Attendance::create([
                    'user_id' => $user->id,
                    'check_in' => $checkInTime,
                    'check_out' => null,
                    'shift_status' => 'aktif'
                ]);
            } else {
                $attendance->update([
                    'check_in' => $checkInTime,
                    'shift_status' => 'aktif'
                ]);
            }
            
            $message = $shiftInfo['terlambat'] 
                ? "⚠️ Shift {$shiftInfo['type_nama']} dimulai! Anda terlambat {$shiftInfo['terlambat_menit']} menit."
                : "✅ Shift {$shiftInfo['type_nama']} dimulai! Tepat waktu.";
            
            return response()->json([
                'success' => true,
                'action' => 'mulai',
                'message' => $message,
                'check_in' => $checkInTime->format('H:i:s'),
                'shift_type' => $shiftInfo['type'],
                'shift_type_nama' => $shiftInfo['type_nama'],
                'shift_start' => $shiftInfo['start'],
                'shift_end' => $shiftInfo['end'],
                'terlambat' => $shiftInfo['terlambat'],
                'terlambat_menit' => $shiftInfo['terlambat_menit']
            ]);
        }
        
        // KASUS 2: SUDAH CHECK_IN, BELUM CHECK_OUT
        if ($attendance->check_in && !$attendance->check_out) {
            $attendance->update([
                'check_out' => now(),
                'shift_status' => 'selesai'
            ]);
            
            return response()->json([
                'success' => true,
                'action' => 'selesai',
                'message' => '✅ Shift selesai! Terima kasih.',
                'check_out' => $attendance->check_out->format('H:i:s'),
                'check_in' => $attendance->check_in->format('H:i:s')
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Shift hari ini sudah selesai'
        ], 400);
    }
    
    /**
     * Cek status shift untuk tampilan
     */
    public function cekStatus()
    {
        $user = Auth::user();
        $today = date('Y-m-d');
        
        $attendance = Attendance::where('user_id', $user->id)
                                ->whereDate('created_at', $today)
                                ->first();
        
        if (!$attendance || !$attendance->check_in) {
            return response()->json([
                'shift_status' => 'tidak_aktif',
                'check_in' => null,
                'check_out' => null,
                'shift_type' => null,
                'shift_type_nama' => null,
                'shift_start' => null,
                'shift_end' => null,
                'terlambat' => false
            ]);
        }
        
        $shiftInfo = $this->getShiftFromTime($attendance->check_in);
        
        return response()->json([
            'shift_status' => $attendance->shift_status,
            'check_in' => $attendance->check_in->format('H:i:s'),
            'check_out' => $attendance->check_out ? $attendance->check_out->format('H:i:s') : null,
            'shift_type' => $shiftInfo['type'],
            'shift_type_nama' => $shiftInfo['type_nama'],
            'shift_start' => $shiftInfo['start'],
            'shift_end' => $shiftInfo['end'],
            'terlambat' => $shiftInfo['terlambat'],
            'terlambat_menit' => $shiftInfo['terlambat_menit']
        ]);
    }
    
    /**
     * Ambil riwayat absensi lengkap dengan filter
     */
    public function getFullHistory(Request $request)
    {
        $user = Auth::user();
        
        $query = Attendance::where('user_id', $user->id)
                           ->whereNotNull('check_in');
        
        // Filter tanggal spesifik
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        // Filter bulan & tahun
        elseif ($request->filled('year') && $request->filled('month')) {
            $query->whereYear('created_at', $request->year)
                  ->whereMonth('created_at', $request->month);
        }
        
        $histories = $query->orderBy('created_at', 'desc')->get();
        
        $result = [];
        foreach ($histories as $history) {
            $shiftInfo = $this->getShiftFromTime($history->check_in);
            
            $result[] = [
                'id' => $history->id,
                'date' => $history->created_at->translatedFormat('l, d F Y'),
                'date_raw' => $history->created_at->format('Y-m-d'),
                'check_in' => $history->check_in->format('H:i'),
                'check_out' => $history->check_out ? $history->check_out->format('H:i') : '-',
                'status' => $shiftInfo['terlambat'] ? 'Terlambat' : 'Hadir',
                'shift_type' => $shiftInfo['type'],
                'shift_type_nama' => $shiftInfo['type_nama'],
                'shift_start' => $shiftInfo['start'],
                'shift_end' => $shiftInfo['end']
            ];
        }
        
        // Filter status
        if ($request->filled('status') && $request->status != 'semua') {
            $result = array_values(array_filter($result, function($item) use ($request) {
                $statusMap = ['hadir' => 'Hadir', 'terlambat' => 'Terlambat', 'tidak_hadir' => 'Tidak Hadir'];
                return $item['status'] === ($statusMap[$request->status] ?? '');
            }));
        }
        
        // Statistik
        $stats = ['hadir' => 0, 'terlambat' => 0, 'tidak_hadir' => 0];
        $allHistories = Attendance::where('user_id', $user->id)->get();
        
        foreach ($allHistories as $history) {
            if (!$history->check_in) {
                $stats['tidak_hadir']++;
            } else {
                $shiftInfo = $this->getShiftFromTime($history->check_in);
                if ($shiftInfo['terlambat']) {
                    $stats['terlambat']++;
                } else {
                    $stats['hadir']++;
                }
            }
        }
        
        return response()->json([
            'histories' => $result,
            'stats' => $stats
        ]);
    }
    
    /**
     * Ambil 5 history terbaru
     */
    public function getRecentHistory()
    {
        $user = Auth::user();
        
        $histories = Attendance::where('user_id', $user->id)
            ->whereNotNull('check_in')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $result = [];
        foreach ($histories as $history) {
            $shiftInfo = $this->getShiftFromTime($history->check_in);
            
            $result[] = [
                'date' => $history->created_at->translatedFormat('d M Y'),
                'check_in' => $history->check_in->format('H:i'),
                'check_out' => $history->check_out ? $history->check_out->format('H:i') : '--',
                'status' => $shiftInfo['terlambat'] ? 'Terlambat' : 'Hadir'
            ];
        }
        
        return response()->json($result);
    }
    
    /**
     * Helper: Tentukan shift berdasarkan jam check_in
     */
    private function getShiftFromTime($checkInTime)
    {
        $hour = (int) $checkInTime->format('H');
        $checkInHourMin = $checkInTime->format('H:i:s');
        
        if ($hour >= 6 && $hour < 14) {
            // Shift Pagi
            $shiftStart = '09:00:00';
            $shiftEnd = '17:00:00';
            $shiftType = 'pagi';
            $shiftTypeNama = 'Pagi';
        } else {
            // Shift Malam
            $shiftStart = '15:00:00';
            $shiftEnd = '23:00:00';
            $shiftType = 'malam';
            $shiftTypeNama = 'Malam';
        }
        
        $terlambatMenit = (strtotime($checkInHourMin) - strtotime($shiftStart)) / 60;
        $terlambat = $terlambatMenit > 30;
        
        return [
            'type' => $shiftType,
            'type_nama' => $shiftTypeNama,
            'start' => substr($shiftStart, 0, 5),
            'end' => substr($shiftEnd, 0, 5),
            'terlambat' => $terlambat,
            'terlambat_menit' => $terlambat ? round($terlambatMenit) : 0
        ];
    }
}