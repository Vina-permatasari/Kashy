<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShiftController;

/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');


/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    
    Route::view('/owner/dashboard', 'owner.dashboard')
    ->middleware('auth')
    ->name('owner.dashboard');
    Route::view('/owner/manajemendiskon', 'owner.manajemendiskon')
    ->middleware('auth')
    ->name('manajemen.diskon');
    Route::view('/owner/laporan-keuangan', 'owner.laporankeuangan')
        ->middleware('auth')
        ->name('owner.laporan.keuangan');
    Route::view('/owner/stokopname', 'owner.stokopname')
    ->middleware('auth')
    ->name('stokopname');
    Route::view('/owner/manajemenstaff', 'owner.manajemenstaff')
    ->middleware('auth')
    ->name('manajemen.staff');
    Route::view('/owner/manajemenproduk', 'owner.manajemenproduk')
    ->middleware('auth')
    ->name('manajemen.produk');
    
        
    // Products
    Route::get('/owner/products', [ProductController::class, 'ownerIndex'])
        ->name('owner.products.index');

    Route::get('/owner/products/create', [ProductController::class, 'create'])
        ->name('owner.products.create');

    Route::post('/owner/products', [ProductController::class, 'store'])
        ->name('owner.products.store');

    Route::get('/owner/products/{product}/edit', [ProductController::class, 'edit'])
        ->name('owner.products.edit');

    Route::put('/owner/products/{product}', [ProductController::class, 'update'])
        ->name('owner.products.update');

    Route::delete('/owner/products/{product}', [ProductController::class, 'destroy'])
        ->name('owner.products.destroy');
    
    
});


/*
|--------------------------------------------------------------------------
| KASIR
|--------------------------------------------------------------------------
*/

// kasir
Route::get('/kasir/dashboard', function () {
    return view('kasir.dashboard');
})->middleware('auth')->name('dashboard-kasir');

    Route::get('/kasir/shiftkasir', function () {
        return view('kasir.shiftkasir');
    })->name('kasir.shiftkasir');

    Route::get('/kasir/profil', [ProfileController::class, 'kasirProfile'])
    ->middleware('auth')
    ->name('kasir.profil');

    Route::get('/kasir/profil', [ProfileController::class, 'kasirProfile'])
    ->middleware('auth')
    ->name('kasir.profil');

    Route::get('/kasir/riwayattransaksi', function () {
        return view('kasir.riwayattransaksi');
    })->name('kasir.riwayattransaksi');

    Route::get('/kasir/laporantransaksi', function () {
        return view('kasir.laporantransaksi');
    })->name('kasir.laporantransaksi');

    Route::get('/kasir/transaksi', function () {
        return view('kasir.transaksi');
    })->name('kasir.transaksi');

    Route::get('/kasir/pembayaran', function () {
        return view('kasir.pembayaran');
    })->name('kasir.pembayaran');


/*
|--------------------------------------------------------------------------
| KARYAWAN
|--------------------------------------------------------------------------
*/

Route::get('/karyawan/dashboard', function () {
    return view('karyawan.dashboard');
})->name('dashboard-karyawan');

Route::get('/karyawan/absensi', function () {
    return view('karyawan.absensi');
})->name('absensi');

Route::get('/karyawan/historyabsensi', function () {
    return view('karyawan.historyabsensi');
})->name('historyabsensi');

Route::middleware(['auth'])->group(function () {

    Route::get('/karyawan/stok-produk', [ProductController::class, 'index'])
        ->name('stok-produk');

    Route::get('/karyawan/pusatbantuan', function () {
        return view('karyawan.pusatbantuan');
    })->name('pusatbantuan');

    /*
    |--------------------------------------------------------------------------
    | PROFILE KARYAWAN
    |--------------------------------------------------------------------------
    */

    Route::get('/karyawan/profile', [ProfileController::class, 'index'])
        ->name('karyawan.profile');

    Route::put('/karyawan/profile/update', [ProfileController::class, 'updateProfile'])
        ->name('karyawan.profile.update');

    Route::put('/karyawan/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('karyawan.password.update');
});


/*
|--------------------------------------------------------------------------
| SHIFT / ABSENSI
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::post('/shift/aktifkan', [ShiftController::class, 'aktifkanShift'])
        ->name('shift.aktifkan');

    Route::post('/shift/handle', [ShiftController::class, 'handleAbsensi'])
        ->name('shift.handle');

    Route::get('/shift/status', [ShiftController::class, 'cekStatus'])
        ->name('shift.status');
});

Route::get('/shift/history', [ShiftController::class, 'getHistory'])
    ->name('shift.history');


/*
|--------------------------------------------------------------------------
| PELANGGAN
|--------------------------------------------------------------------------
*/

Route::get('/katalog', function () {
    return view('pelanggan.katalog');
})->name('katalog');

Route::get('/daftarproduk', function () {
    return view('pelanggan.daftarproduk');
})->name('daftar-produk');

Route::get('/detail-produk/{id}', function ($id) {
    return view('pelanggan.detailproduk', ['id' => $id]);
})->name('detail-produk');


/*
|--------------------------------------------------------------------------
| DASHBOARD DEFAULT
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| PROFILE BAWAAN BREEZE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


require __DIR__.'/auth.php';