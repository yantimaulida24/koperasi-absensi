<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PermohonanCutiController;
use App\Http\Controllers\JabatanController;
use Illuminate\Support\Facades\Auth;

// 🔹 Auth bawaan Laravel
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
        'index' => 'karyawan.index',
        'create' => 'karyawan.create',
        'store' => 'karyawan.store',
        'edit' => 'karyawan.edit',
        'update' => 'karyawan.update',
        'destroy' => 'karyawan.destroy',
    ]);

    // 🕒 Absensi
    Route::resource('absensi', AbsensiController::class)->names([
        'index' => 'absensi.index',
        'create' => 'absensi.create',
        'store' => 'absensi.store',
        'edit' => 'absensi.edit',
        'update' => 'absensi.update',
        'destroy' => 'absensi.destroy',
    ]);

    // 📄 Permohonan Cuti
    Route::resource('permohonan-cuti', PermohonanCutiController::class)->names([
        'index' => 'permohonan-cuti.index',
        'create' => 'permohonan-cuti.create',
        'store' => 'permohonan-cuti.store',
        'edit' => 'permohonan-cuti.edit',
        'update' => 'permohonan-cuti.update',
        'destroy' => 'permohonan-cuti.destroy',
    ]);

    // 💼 Data Jabatan
    Route::resource('jabatan', JabatanController::class)->names([
        'index' => 'jabatan.index',
        'create' => 'jabatan.create',
        'store' => 'jabatan.store',
        'edit' => 'jabatan.edit',
        'update' => 'jabatan.update',
        'destroy' => 'jabatan.destroy',
    ]);
});