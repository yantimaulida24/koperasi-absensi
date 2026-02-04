<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PermohonanCutiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JadwalKerjaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KritikSaranController;
use App\Http\Controllers\AkunController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| SCAN QR (TANPA LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/absen/scan', [AbsensiController::class, 'scanPage'])->name('absen.scan');
Route::post('/absen/proses', [AbsensiController::class, 'prosesScan'])->name('absen.proses');

/*
|--------------------------------------------------------------------------
| SETELAH LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| DATA KARYAWAN
|--------------------------------------------------------------------------
*/
// ================================
// ADMIN: create, store, edit, update, delete, download QR
// ================================
Route::middleware(['auth','cekrole:admin'])->group(function () {
    Route::get('data-karyawan/create', [KaryawanController::class, 'create'])
        ->name('data-karyawan.create');

    Route::post('data-karyawan', [KaryawanController::class, 'store'])
        ->name('data-karyawan.store');

    Route::get('data-karyawan/{data_karyawan}/edit', [KaryawanController::class, 'edit'])
        ->name('data-karyawan.edit');

    Route::put('data-karyawan/{data_karyawan}', [KaryawanController::class, 'update'])
        ->name('data-karyawan.update');

    Route::delete('data-karyawan/{data_karyawan}', [KaryawanController::class, 'destroy'])
        ->name('data-karyawan.destroy');

    Route::get('data-karyawan/{data_karyawan}/download-qr',
        [KaryawanController::class,'downloadQr'])
        ->name('data-karyawan.downloadQr');
});

// ================================
// ADMIN & KARYAWAN: index & show
// ================================
Route::middleware(['auth','cekrole:admin,karyawan'])->group(function () {
    Route::get('data-karyawan', [KaryawanController::class, 'index'])
        ->name('data-karyawan.index');

    Route::get('data-karyawan/{data_karyawan}', [KaryawanController::class, 'show'])
        ->name('data-karyawan.show');
});

/*
|--------------------------------------------------------------------------
| ABSENSI
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','cekrole:admin,karyawan'])->group(function () {
    Route::resource('absensi', AbsensiController::class);
    Route::get('/absen/barcode/{id}', [AbsensiController::class,'barcode'])
        ->name('absen.barcode');
});

/*
|--------------------------------------------------------------------------
| PERMOHONAN CUTI
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','cekrole:admin,karyawan'])->group(function () {
    Route::resource('permohonan-cuti', PermohonanCutiController::class);
});

/*
|--------------------------------------------------------------------------
| MASTER DATA (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','cekrole:admin'])->group(function () {
    Route::resource('jabatan', JabatanController::class);
    Route::resource('jadwal', JadwalKerjaController::class);

    Route::get('/laporan-absensi', [LaporanController::class,'index'])
        ->name('laporan.index');

    Route::get('/laporan-absensi/cetak-pdf', [LaporanController::class,'cetak'])
        ->name('laporan.cetak');
});

/*
|--------------------------------------------------------------------------
| MANAJEMEN AKUN (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','cekrole:admin'])->group(function () {
    Route::resource('akun', AkunController::class);
});

/*
|--------------------------------------------------------------------------
| KRITIK & SARAN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','cekrole:admin,karyawan'])->group(function () {
    Route::get('/kritik-saran', [KritikSaranController::class,'index'])
        ->name('kritik_saran.index');

    Route::get('/kritik-saran/create', [KritikSaranController::class,'create'])
        ->name('kritik_saran.create');

    Route::post('/kritik-saran', [KritikSaranController::class,'store'])
        ->name('kritik_saran.store');

    Route::delete('/kritik-saran/{id}', [KritikSaranController::class,'destroy'])
        ->name('kritik_saran.destroy');

    Route::post('/kritik-saran/{id}/komentar', [KritikSaranController::class,'komentar'])
        ->name('kritik_saran.komentar');
});
