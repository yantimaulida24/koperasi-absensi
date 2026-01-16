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

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| 📲 SCAN QR ABSENSI (HP) - TANPA LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/absen/scan', [AbsensiController::class, 'scanPage'])
    ->name('absen.scan');

Route::post('/absen/proses', [AbsensiController::class, 'prosesScan'])
    ->name('absen.proses');

/*
|--------------------------------------------------------------------------
| 🔒 ROUTE SETELAH LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/', fn () => redirect()->route('dashboard'));

    Route::get('/dashboard', [HomeController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | 👨‍💼 DATA KARYAWAN
    |--------------------------------------------------------------------------
    */
    Route::resource('data-karyawan', KaryawanController::class)->names([
        'index'   => 'karyawan.index',
        'create'  => 'karyawan.create',
        'store'   => 'karyawan.store',
        'show'    => 'karyawan.show',
        'edit'    => 'karyawan.edit',
        'update'  => 'karyawan.update',
        'destroy' => 'karyawan.destroy',
    ]);

    /*
    |--------------------------------------------------------------------------
    | ⬇️ DOWNLOAD QR KARYAWAN (INI YANG DITAMBAHKAN)
    |--------------------------------------------------------------------------
    */
    Route::get(
        '/data-karyawan/{data_karyawan}/download-qr',
        [KaryawanController::class, 'downloadQr']
    )->name('karyawan.downloadQr');

    /*
    |--------------------------------------------------------------------------
    | 📊 ABSENSI
    |--------------------------------------------------------------------------
    */
    Route::resource('absensi', AbsensiController::class);

    Route::get('/absen/barcode/{id}', [AbsensiController::class, 'barcode'])
        ->name('absen.barcode');

    /*
    |--------------------------------------------------------------------------
    | 📝 CUTI, JABATAN, JADWAL
    |--------------------------------------------------------------------------
    */
    Route::resource('permohonan-cuti', PermohonanCutiController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('jadwal', JadwalKerjaController::class);

    /*
    |--------------------------------------------------------------------------
    | 📄 LAPORAN
    |--------------------------------------------------------------------------
    */
    Route::get('/laporan-absensi', [LaporanController::class, 'index'])
        ->name('laporan.index');

    Route::get('/laporan-absensi/cetak-pdf', [LaporanController::class, 'cetak'])
        ->name('laporan.cetak');

    /*
    |--------------------------------------------------------------------------
    | 💬 KRITIK & SARAN
    |--------------------------------------------------------------------------
    */
    Route::resource('kritik-saran', KritikSaranController::class)->only([
        'index', 'create', 'store', 'destroy'
    ]);
});
