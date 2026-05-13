<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/owner/dashboard', function () {
    return view('owner.dashboard');
});

Route::get('/kasir/dashboard', function () {
    return view('kasir.dashboard');
})->middleware('auth');

Route::get('/karyawan/dashboard', function () {
    return view('karyawan.dashboard');
})->name('dashboard-karyawan');

Route::get('/absensi', function () {
    return view('karyawan.absensi');
})->name('absensi');

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
