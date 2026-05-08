<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/owner/dashboard', function () {
    return view('owner.dashboard');
})->middleware('auth');

Route::get('/kasir/dashboard', function () {
    return view('kasir.dashboard');
})->middleware('auth');

Route::get('/karyawan/dashboard', function () {
    return view('karyawan.dashboard');
})->middleware('auth');

Route::get('/katalog', function () {
    return view('pelanggan.katalog');
})->name('katalog');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
