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
        // Ambil hasil scan
        $kodeQR = trim($request->kode_qr);

        // Jika QR berupa URL → ambil bagian terakhir
        if (str_contains($kodeQR, '/')) {
            $kodeQR = basename($kodeQR);
        }

        $kodeQR = strtoupper($kodeQR);

        // Validasi format
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

        // ABSEN MASUK
        if (!$absen) {
            Absensi::create([
                'id_karyawan' => $idKaryawan,
                'tanggal'     => $tanggal,
                'waktu_masuk' => $waktu,
                'status'      => 'Hadir'
            ]);

            return back()->with('success', 'Absensi masuk berhasil');
        }

        // ABSEN PULANG
        if (!$absen->waktu_keluar) {
            $absen->update([
                'waktu_keluar' => $waktu,
                'status'       => 'Hadir'
            ]);

            return back()->with('success', 'Absensi pulang berhasil');
        }

        return back()->with('error', 'Anda sudah absen hari ini');
    }

    public function index()
    {
        $absensi = Absensi::with('karyawan')->latest()->get();
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
