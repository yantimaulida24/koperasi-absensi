<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

// 🔹 Redirect halaman utama ke halaman login
Route::get('/', function () {
    return redirect('/login');
});

// 🔹 Route bawaan Laravel untuk login/logout
Auth::routes();

// 🔹 Semua route di bawah hanya bisa diakses oleh user yang sudah login
Route::middleware(['auth'])->group(function () {

    // ✅ Halaman dashboard setelah login (untuk admin & karyawan)
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ✅ Resource CRUD untuk data karyawan (khusus admin)
    Route::middleware(['isAdmin'])->group(function () {
        Route::resource('karyawan', KaryawanController::class);
    });

    // ✅ Halaman daftar absensi (menampilkan semua QR karyawan)
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');

    // ✅ Simpan absensi secara manual (opsional)
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');

    // ✅ Tambah karyawan dan buat QR unik
    Route::post('/karyawan', [AbsensiController::class, 'createKaryawan'])->name('karyawan.store');

    // ✅ Scan QR Code lewat HP (otomatis absen dan redirect ke konfirmasi)
    Route::get('/absensi/scan/{kode_qr}', [AbsensiController::class, 'scan'])->name('absensi.scan');

    // ✅ Halaman konfirmasi setelah absensi berhasil
    Route::get('/absensi/konfirmasi', [AbsensiController::class, 'konfirmasi'])->name('absensi.konfirmasi');
});
