<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PermohonanCutiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JadwalKerjaController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

// 🔹 Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 🔹 Semua route ini hanya bisa diakses jika sudah login
Route::middleware('auth')->group(function () {

    // 🏠 Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // 👥 Data Karyawan
    Route::resource('data-karyawan', KaryawanController::class)->names([
        'index'   => 'karyawan.index',
        'create'  => 'karyawan.create',
        'store'   => 'karyawan.store',
        'show'    => 'karyawan.show',
        'edit'    => 'karyawan.edit',
        'update'  => 'karyawan.update',
        'destroy' => 'karyawan.destroy',
    ]);

    // 🕒 Data Absensi
    Route::resource('absensi', AbsensiController::class)->names([
        'index'   => 'absensi.index',
        'create'  => 'absensi.create',
        'store'   => 'absensi.store',
        'show'    => 'absensi.show',
        'edit'    => 'absensi.edit',
        'update'  => 'absensi.update',
        'destroy' => 'absensi.destroy',
    ]);

    // 📲 Fitur Scan QR
    Route::get('/absensi/scan/{kode_qr}', [AbsensiController::class, 'scan'])->name('absensi.scan');
    Route::post('/absensi/scan/{kode_qr}', [AbsensiController::class, 'prosesScan'])->name('absensi.prosesScan');

    // 📄 Permohonan Cuti
    Route::resource('permohonan-cuti', PermohonanCutiController::class)->names([
        'index'   => 'permohonan-cuti.index',
        'create'  => 'permohonan-cuti.create',
        'store'   => 'permohonan-cuti.store',
        'edit'    => 'permohonan-cuti.edit',
        'update'  => 'permohonan-cuti.update',
        'destroy' => 'permohonan-cuti.destroy',
    ]);

    // 💼 Data Jabatan
    Route::resource('jabatan', JabatanController::class)->names([
        'index'   => 'jabatan.index',
        'create'  => 'jabatan.create',
        'store'   => 'jabatan.store',
        'edit'    => 'jabatan.edit',
        'update'  => 'jabatan.update',
        'destroy' => 'jabatan.destroy',
    ]);

    // 📅 Jadwal Kerja
    Route::resource('jadwal-kerja', JadwalKerjaController::class)
        ->parameters(['jadwal-kerja' => 'jadwal_kerja']) // ✅ gunakan parameter konsisten
        ->names([
            'index'   => 'jadwal.index',
            'create'  => 'jadwal.create',
            'store'   => 'jadwal.store',
            'show'    => 'jadwal.show',
            'edit'    => 'jadwal.edit',
            'update'  => 'jadwal.update',
            'destroy' => 'jadwal.destroy',
        ]);
});