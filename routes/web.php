<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

// Login & Logout Laravel
Auth::routes();

// Ketika user akses root → langsung dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Semua route wajib login
Route::middleware('auth')->group(function () {

    // Dashboard bisa dari / atau /home
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    });

    // CRUD Data Karyawan khusus Admin
    Route::middleware('isAdmin')->group(function () {
        Route::resource('karyawan', KaryawanController::class);
    });

    // Absensi (semua role yang login bisa)
    Route::prefix('absensi')->group(function () {
        Route::get('/', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::post('/', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::get('/scan/{kode_qr}', [AbsensiController::class, 'scan'])->name('absensi.scan');
        Route::get('/konfirmasi', [AbsensiController::class, 'konfirmasi'])->name('absensi.konfirmasi');
    });
});
