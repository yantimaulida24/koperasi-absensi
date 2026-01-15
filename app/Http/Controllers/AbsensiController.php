<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function scanPage()
    {
        return view('absensi.scan');
    }

    public function prosesScan(Request $request)
    {
        // =====================
        // AMBIL & NORMALISASI QR
        // =====================
        $kodeQR = trim($request->kode_qr);

        if (str_contains($kodeQR, '/')) {
            $kodeQR = basename($kodeQR);
        }

        $kodeQR = strtoupper($kodeQR);

        if (!preg_match('/^KRY-\d+$/', $kodeQR)) {
            return back()->with('error', 'QR Code tidak valid');
        }

        // =====================
        // AMBIL ID KARYAWAN
        // =====================
        $idKaryawan = (int) str_replace('KRY-', '', $kodeQR);

        $karyawan = Karyawan::where('id_karyawan', $idKaryawan)->first();
        if (!$karyawan) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }

        $hariIni = Carbon::today()->toDateString();
        $waktu   = Carbon::now()->format('H:i:s');

        // =====================
        // CEK ABSENSI HARI INI (PAKAI TANGGAL)
        // =====================
        $absen = Absensi::where('karyawan_id', $idKaryawan)
            ->where('tanggal', $hariIni)
            ->first();

        // =====================
        // ABSEN MASUK
        // =====================
        if (!$absen) {
            Absensi::create([
                'karyawan_id' => $idKaryawan,
                'tanggal'     => $hariIni,
                'waktu_masuk' => $waktu,
                'status'      => 'Hadir',
            ]);

            return back()->with('success', 'Absensi masuk berhasil');
        }

        // =====================
        // ABSEN PULANG
        // =====================
        if (!$absen->waktu_keluar) {
            $absen->update([
                'waktu_keluar' => $waktu,
            ]);

            return back()->with('success', 'Absensi pulang berhasil');
        }

        return back()->with('error', 'Anda sudah absen hari ini');
    }

    public function index()
    {
        $absensi = Absensi::with('karyawan')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('absensi.index', compact('absensi'));
    }

    public function barcode($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        if (!$karyawan->kode_qr) {
            $karyawan->update([
                'kode_qr' => 'KRY-' . $karyawan->id_karyawan
            ]);
        }

        return view('absensi.qr', compact('karyawan'));
    }
}