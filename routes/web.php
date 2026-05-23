<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/owner/dashboard', function () {
    return view('owner.dashboard');
});

// kasir
Route::get('/kasir/dashboard', function () {
    return view('kasir.dashboard');
})->middleware('auth')->name('dashboard-kasir');

Route::get('/kasir/transaksi', function () {
    return view('kasir.transaksi');
})->middleware('auth')->name('kasir.transaksi');

Route::get('/kasir/pembayaran', function () {
    return view('kasir.pembayaran');
})->middleware('auth')->name('kasir.pembayaran');

Route::get('/kasir/shiftkasir', function () {
    return view('kasir.shiftkasir');
})->middleware('auth')->name('kasir.shiftkasir');

Route::get('/kasir/riwayattransaksi', function () {
    return view('kasir.riwayattransaksi');
})->middleware('auth')->name('kasir.riwayattransaksi');

Route::get('/kasir/laporantransaksi', function () {
    return view('kasir.laporantransaksi');
})->middleware('auth')->name('kasir.laporantransaksi');

// karyawan
Route::get('/karyawan/dashboard', function () {
    return view('karyawan.dashboard');
})->name('dashboard-karyawan');

Route::get('/karyawan/absensi', function () {
    return view('karyawan.absensi');
})->name('absensi');

Route::get('/karyawan/historyabsensi', function () {
    return view('karyawan.historyabsensi');
})->name('historyabsensi');

Route::get('/karyawan/stok-produk', function () {
    return view('karyawan.stok-produk');
})->middleware('auth')->name('karyawan.stok');

Route::get('/karyawan/profile', function () {
    return view('karyawan.profile');
})->middleware('auth')->name('karyawan.profile');

Route::get('/karyawan/pusatbantuan', function () {
    return view('karyawan.pusatbantuan'); 
})->middleware('auth')->name('pusatbantuan');

Route::get('/shift/history', [ShiftController::class, 'getHistory'])->name('shift.history');

Route::get('/katalog', function () {
    return view('pelanggan.katalog');
})->name('katalog');

Route::get('/daftarproduk', function () {
    return view('pelanggan.daftarproduk');
})->name('daftar-produk');

Route::get('/detail-produk/{id}', function ($id) {
    return view('pelanggan.detailproduk', ['id' => $id]);
})->name('detail-produk');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/karyawan/stok-produk', function () {
    return view('karyawan.stok-produk');
})->middleware('auth')->name('stok-produk');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk shift/absensi karyawan
Route::middleware(['auth'])->group(function () {
    Route::post('/shift/aktifkan', [ShiftController::class, 'aktifkanShift'])->name('shift.aktifkan');
    Route::post('/shift/handle', [ShiftController::class, 'handleAbsensi'])->name('shift.handle');
    Route::get('/shift/status', [ShiftController::class, 'cekStatus'])->name('shift.status');
});

require __DIR__.'/auth.php';