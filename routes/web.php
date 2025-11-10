<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PermohonanCutiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JadwalKerjaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KritikSaranController;
use Illuminate\Support\Facades\Auth;

// 🔐 Route bawaan Laravel (login, register, logout, dll)
Auth::routes();

// 🔹 Redirect root (/) ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 🔒 Semua route di bawah hanya bisa diakses oleh user yang sudah login
Route::middleware('auth')->group(function () {

    // 🏠 Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // 👥 Data Karyawan (CRUD)
    Route::resource('data-karyawan', KaryawanController::class)->names([
        'index'   => 'karyawan.index',
        'create'  => 'karyawan.create',
        'store'   => 'karyawan.store',
        'show'    => 'karyawan.show',
        'edit'    => 'karyawan.edit',
        'update'  => 'karyawan.update',
        'destroy' => 'karyawan.destroy',
    ]);

    // 🕒 Data Absensi (CRUD)
    Route::resource('absensi', AbsensiController::class)->names([
        'index'   => 'absensi.index',
        'create'  => 'absensi.create',
        'store'   => 'absensi.store',
        'show'    => 'absensi.show',
        'edit'    => 'absensi.edit',
        'update'  => 'absensi.update',
        'destroy' => 'absensi.destroy',
    ]);

    // 📲 Fitur Scan QR Absensi
    Route::get('/absensi/scan/{kode_qr}', [AbsensiController::class, 'scan'])->name('absensi.scan');
    Route::post('/absensi/scan/{kode_qr}', [AbsensiController::class, 'prosesScan'])->name('absensi.prosesScan');

    // 📄 Permohonan Cuti (CRUD)
    Route::resource('permohonan-cuti', PermohonanCutiController::class)->names([
        'index'   => 'permohonan-cuti.index',
        'create'  => 'permohonan-cuti.create',
        'store'   => 'permohonan-cuti.store',
        'show'    => 'permohonan-cuti.show',
        'edit'    => 'permohonan-cuti.edit',
        'update'  => 'permohonan-cuti.update',
        'destroy' => 'permohonan-cuti.destroy',
    ]);

    // 💼 Data Jabatan (CRUD)
    Route::resource('jabatan', JabatanController::class)->names([
        'index'   => 'jabatan.index',
        'create'  => 'jabatan.create',
        'store'   => 'jabatan.store',
        'show'    => 'jabatan.show',
        'edit'    => 'jabatan.edit',
        'update'  => 'jabatan.update',
        'destroy' => 'jabatan.destroy',
    ]);

    // 📅 Jadwal Kerja (CRUD)
    Route::resource('jadwal-kerja', JadwalKerjaController::class)
        ->parameters(['jadwal-kerja' => 'jadwal_kerja'])
        ->names([
            'index'   => 'jadwal.index',
            'create'  => 'jadwal.create',
            'store'   => 'jadwal.store',
            'show'    => 'jadwal.show',
            'edit'    => 'jadwal.edit',
            'update'  => 'jadwal.update',
            'destroy' => 'jadwal.destroy',
        ]);

    // 📊 Laporan Absensi
    Route::get('/laporan-absensi', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan-absensi/cetak-pdf', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    // 💬 Kritik & Saran (CRUD sederhana, tanpa Auth)
Route::get('/kritik-saran', [KritikSaranController::class, 'index'])->name('kritik_saran.index');
Route::get('/kritik-saran/tambah', [KritikSaranController::class, 'create'])->name('kritik_saran.create');
Route::post('/kritik-saran/store', [KritikSaranController::class, 'store'])->name('kritik_saran.store');
Route::post('/kritik-saran/komentar/{id}', [KritikSaranController::class, 'komentar'])->name('kritik_saran.komentar');
Route::delete('/kritik-saran/{id}', [KritikSaranController::class, 'destroy'])->name('kritik_saran.destroy');
});