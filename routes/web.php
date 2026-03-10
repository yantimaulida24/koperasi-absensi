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
| SCAN QR ABSENSI (TANPA LOGIN)
|--------------------------------------------------------------------------
*/

Route::get('/absen/scan', [AbsensiController::class, 'scanPage'])
    ->name('absen.scan');

Route::post('/absen/proses', [AbsensiController::class, 'prosesScan'])
    ->name('absen.proses');


/*
|--------------------------------------------------------------------------
| SETELAH LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/', fn () => redirect()->route('pilih.sistem'));

    Route::get('/pilih-sistem', function () {
        return view('auth.pilih-sistem');
    })->name('pilih.sistem');


    Route::get('/masuk-database', function () {

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('pilih.sistem')
                ->with('error', 'Hanya ADMIN yang dapat mengakses Database');
        }

        session(['role' => 'admin']);
        return redirect()->route('dashboard');

    })->name('masuk.database');


    Route::get('/masuk-absensi', function () {

        if (Auth::user()->role !== 'karyawan') {
            return redirect()->route('pilih.sistem')
                ->with('error', 'Hanya KARYAWAN yang dapat mengakses Absensi');
        }

        session(['role' => 'karyawan']);
        return redirect()->route('dashboard');

    })->name('masuk.absensi');


    Route::get('/dashboard', [HomeController::class, 'index'])
        ->name('dashboard');
});


/*
|--------------------------------------------------------------------------
| DATA KARYAWAN
|--------------------------------------------------------------------------
*/

/*
| ADMIN → TAMBAH, EDIT, HAPUS
*/
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
});


/*
| ADMIN & KARYAWAN → LIHAT + DOWNLOAD QR
*/
Route::middleware(['auth','cekrole:admin,karyawan'])->group(function () {

    Route::get('data-karyawan', [KaryawanController::class, 'index'])
        ->name('data-karyawan.index');

    Route::get('data-karyawan/{data_karyawan}', [KaryawanController::class, 'show'])
        ->name('data-karyawan.show');

    Route::get('data-karyawan/{data_karyawan}/download-qr',
        [KaryawanController::class,'downloadQr'])
        ->name('data-karyawan.downloadQr');
});


/*
|--------------------------------------------------------------------------
| ABSENSI
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','cekrole:admin,karyawan'])->group(function () {

    Route::get('absensi', [AbsensiController::class, 'index'])
        ->name('absensi.index');

    Route::get('absensi/{id}', [AbsensiController::class, 'show'])
        ->name('absensi.show');

    Route::post('absensi', [AbsensiController::class, 'store'])
        ->name('absensi.store');

    Route::put('absensi/{id}', [AbsensiController::class, 'update'])
        ->name('absensi.update');

    Route::delete('absensi/{id}', [AbsensiController::class, 'destroy'])
        ->name('absensi.destroy');

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
| AKUN (ADMIN)
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

    Route::get('kritik_saran', [KritikSaranController::class, 'index'])
        ->name('kritik_saran.index');

    Route::get('kritik_saran/create', [KritikSaranController::class, 'create'])
        ->name('kritik_saran.create');

    Route::post('kritik_saran', [KritikSaranController::class, 'store'])
        ->name('kritik_saran.store');

    Route::delete('kritik_saran/{id}', [KritikSaranController::class, 'destroy'])
        ->name('kritik_saran.destroy');

    Route::post('kritik_saran/{id}/komentar',
        [KritikSaranController::class,'komentar'])
        ->name('kritik_saran.komentar');

});