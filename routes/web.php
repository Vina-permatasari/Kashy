<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\KasirShiftController;
use App\Http\Controllers\KasirTransactionController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
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

    Route::view('/owner/pengaturantransaksi', 'owner.pengaturantransaksi')
    ->middleware('auth')
    ->name('pengaturan.transaksi');

    Route::view('/owner/kustomisasitemplatstruk','owner.kustomisasitemplatstruk')
    ->name('kustomisasi.template.struk');

    Route::view('/owner/konfigurasi-printer', 'owner.konfigurasiprinter')
    ->name('konfigurasi.printer');

    Route::view('/owner/pusat-keamanan-data','owner.pusatkeamanandata')
    ->name('pusat.keamanan.data');

    Route::delete('/owner/products/{product}', [ProductController::class, 'destroy'])
    ->name('owner.products.destroy');

    Route::view('/owner/manajemenkategori', 'owner.manajemenkategori')
    ->middleware('auth')
    ->name('manajemen.kategori');

    Route::view('/owner/manajementoko', 'owner.manajementoko')
    ->middleware('auth')
    ->name('manajemen.toko');


    /*
    |--------------------------------------------------------------------------
    | PROFILE OWNER
    |--------------------------------------------------------------------------
    */

    Route::get('/owner/profile', [ProfileController::class, 'ownerProfile'])
        ->middleware('auth')
        ->name('owner.profile');
    
    
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

Route::put('/kasir/profil/update', [ProfileController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('kasir.profile.update');

Route::put('/kasir/profil/password', [ProfileController::class, 'updatePassword'])
    ->middleware('auth')
    ->name('kasir.password.update');

Route::get('/kasir/riwayattransaksi', function () {
    $transactions = Transaction::with('details')
        ->where('kasir_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(function($transaction) {
            return $transaction->created_at->translatedFormat('d F Y');
        });
    
    return view('kasir.riwayattransaksi', compact('transactions'));
})->middleware('auth')->name('kasir.riwayattransaksi');
    
Route::get('/kasir/laporantransaksi', function () {
    return view('kasir.laporantransaksi');
})->name('kasir.laporantransaksi');

Route::get('/kasir/transaksi', [KasirTransactionController::class, 'create'])
    ->middleware('auth')
    ->name('kasir.transaksi');

Route::get('/kasir/pembayaran', [KasirTransactionController::class, 'pembayaran'])
    ->middleware('auth')
    ->name('kasir.pembayaran');

Route::post('/kasir/finalize-payment', [KasirTransactionController::class, 'finalizePayment'])
    ->middleware('auth')
    ->name('kasir.finalize-payment');

Route::middleware(['auth'])->group(function () {

    // Route::get('/kasir/transaksi-baru', [KasirTransactionController::class, 'create'])
    //     ->name('kasir.transaksi');

    Route::post('/kasir/member/store', [KasirTransactionController::class, 'storeMember'])
        ->name('kasir.member.store');

    Route::post('/kasir/transaksi/session', [KasirTransactionController::class, 'saveTransactionSession'])
        ->name('kasir.transaksi.session');

});


/*
|--------------------------------------------------------------------------
| SHIFT KASIR API (TAMBAHAN)
|--------------------------------------------------------------------------
*/

// Recent transactions untuk dashboard kasir
Route::get('/kasir/transaksi/recent', function() {
    $user = Auth::user();
    $transactions = App\Models\Transaction::with('details')
        ->where('kasir_id', $user->id)
        ->whereDate('created_at', today())
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($trx) {
            // Hitung total item terjual dari detail transaksi
            $totalItems = $trx->details->sum('qty');
            
            return [
                'invoice_number' => $trx->invoice_number,
                'grand_total' => $trx->grand_total,
                'metode_pembayaran' => $trx->metode_pembayaran == 'cash' ? 'Tunai' : ($trx->metode_pembayaran == 'qris' ? 'QRIS' : 'Transfer'),
                'time' => $trx->created_at->format('H:i'),
                'total_items' => $totalItems  // <-- INI YANG DITAMBAH
            ];
        });
    return response()->json($transactions);
})->middleware('auth')->name('kasir.transaksi.recent');

// ========== SHIFT KASIR API ==========
Route::middleware(['auth'])->group(function () {
    Route::get('/kasir/shift/status', [KasirShiftController::class, 'cekStatus'])->name('kasir.shift.status');
    Route::get('/kasir/shift/min-saldo', [KasirShiftController::class, 'getMinSaldo'])->name('kasir.shift.minSaldo');
    Route::post('/kasir/shift/buka', [KasirShiftController::class, 'bukaShift'])->name('kasir.shift.buka');
    Route::post('/kasir/shift/tutup', [KasirShiftController::class, 'tutupShift'])->name('kasir.shift.tutup');
});
/*
|--------------------------------------------------------------------------
| LAPORAN KASIR API
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/kasir/laporan/hari-ini', [App\Http\Controllers\LaporanController::class, 'getLaporanHariIni'])->name('kasir.laporan.hari-ini');
});
Route::get('/kasir/laporan/hari-ini', [App\Http\Controllers\LaporanController::class, 'getLaporanHariIni'])->name('kasir.laporan.hari-ini');
Route::get('/kasir/laporan/export-pdf', [App\Http\Controllers\LaporanController::class, 'exportPDF'])->name('kasir.laporan.export-pdf');
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


    /*
    |--------------------------------------------------------------------------
    | PROFILE UNIVERSAL UPDATE
    |--------------------------------------------------------------------------
    */

    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])
        ->name('profile.updateProfile');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.updatePassword');

    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('profile.updatePhoto');
});


/*
|--------------------------------------------------------------------------
| SHIFT / ABSENSI (UPDATED)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Handle absensi (satu tombol untuk mulai & selesai)
    Route::post('/shift/handle', [ShiftController::class, 'handleAbsensi'])
        ->name('shift.handle');

    // Cek status shift untuk dashboard & absensi
    Route::get('/shift/status', [ShiftController::class, 'cekStatus'])
        ->name('shift.status');

    // Recent history (5 data) untuk halaman absensi
    Route::get('/shift/recent-history', [ShiftController::class, 'getRecentHistory'])
        ->name('shift.recent-history');

    // FULL history + filter + statistik untuk halaman historyabsensi
    Route::get('/shift/full-history', [ShiftController::class, 'getFullHistory'])
        ->name('shift.full-history');
});


/*
|--------------------------------------------------------------------------
| SERVER TIME
|--------------------------------------------------------------------------
*/

Route::get('/server-time', function() {
    return response()->json([
        'server_time' => now()->toIso8601String(),
        'timezone' => config('app.timezone')
    ]);
})->name('server.time');

Route::get('/test-time', function() {
    return [
        'server_time' => now()->format('Y-m-d H:i:s'),
        'timezone' => config('app.timezone'),
        'php_timezone' => date_default_timezone_get()
    ];
});


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