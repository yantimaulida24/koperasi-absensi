<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /* ==============================
     * 📱 HALAMAN SCAN (HP)
     * ============================== */
    public function scanPage()
    {
        return view('absensi.scan');
    }

    /* ==============================
     * 🔄 PROSES HASIL SCAN
     * ============================== */
    public function prosesScan(Request $request)
{
    $kodeQR = trim($request->kode_qr);

    if (!preg_match('/^KRY-\d+$/', $kodeQR)) {
        return back()->with('error', 'QR Code tidak valid');
    }

    $idKaryawan = (int) str_replace('KRY-', '', $kodeQR);

    $karyawan = Karyawan::where('id_karyawan', $idKaryawan)->first();
    if (!$karyawan) {
        return back()->with('error', 'Karyawan tidak ditemukan');
    }

    $tanggal = Carbon::today()->toDateString();
    $waktu   = Carbon::now()->format('H:i:s');

    $absen = Absensi::where('id_karyawan', $idKaryawan)
        ->whereDate('tanggal', $tanggal)
        ->first();

    if (!$absen) {
        Absensi::create([
            'id_karyawan' => $idKaryawan,
            'tanggal'     => $tanggal,
            'waktu_masuk' => $waktu,
            'status'      => 'Masuk'
        ]);

        return back()->with('success', 'Absensi masuk berhasil');
    }

    if (!$absen->waktu_keluar) {
        $absen->update([
            'waktu_keluar' => $waktu,
            'status'       => 'Pulang'
        ]);

        return back()->with('success', 'Absensi pulang berhasil');
    }

    return back()->with('error', 'Anda sudah absen hari ini');
}



    /* ==============================
     * 🖥️ ADMIN: LIST ABSENSI
     * ============================== */
    public function index()
    {
        $absensi = Absensi::with('karyawan')->latest()->get();
        return view('absensi.index', compact('absensi'));
    }

    /* ==============================
     * 🖥️ ADMIN: TAMPILKAN BARCODE
     * ============================== */
    public function barcode($id)
{
    $karyawan = Karyawan::findOrFail($id);

    // pastikan kode_qr konsisten
    if (!$karyawan->kode_qr) {
        $karyawan->update([
            'kode_qr' => 'KRY-' . $karyawan->id_karyawan
        ]);
    }

    return view('absensi.qr', compact('karyawan'));
}

}
