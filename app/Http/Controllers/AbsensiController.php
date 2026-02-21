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
        $raw = trim($request->kode_qr);

        if (empty($raw)) {
            return back()->with('error', 'QR kosong');
        }

        // Ambil format KRY-<angka>
        preg_match('/KRY-\d+/i', $raw, $match);

        if (!$match) {
            return back()->with('error', 'QR Code tidak valid');
        }

        $kodeQR     = strtoupper($match[0]);
        $idKaryawan = (int) str_replace('KRY-', '', $kodeQR);

        // Cek karyawan
        $karyawan = Karyawan::where('id_karyawan', $idKaryawan)->first();
        if (!$karyawan) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }

        // WITA
        $tanggal = Carbon::today()->toDateString();
        $waktu   = Carbon::now()->format('H:i:s');

        $absen = Absensi::where('id_karyawan', $idKaryawan)
            ->where('tanggal', $tanggal)
            ->first();

        // =====================
        // ABSEN MASUK
        // =====================
        if (!$absen) {
            Absensi::create([
                'id_karyawan' => $idKaryawan,
                'tanggal'     => $tanggal,
                'waktu_masuk' => $waktu,
                'status'      => 'Hadir',
            ]);

            return back()->with('success', 'Absensi masuk berhasil');
        }

        // =====================
        // ABSEN PULANG + HITUNG TOTAL JAM KERJA
        // =====================
        if (is_null($absen->waktu_keluar)) {

            $masuk  = Carbon::createFromFormat('H:i:s', $absen->waktu_masuk);
            $keluar = Carbon::createFromFormat('H:i:s', $waktu);

            // total menit kerja
            $totalMenit = $masuk->diffInMinutes($keluar);

            // konversi ke jam desimal (misal 1.50)
            $totalJamKerja = round($totalMenit / 60, 2);

            $absen->update([
                'waktu_keluar'    => $waktu,
                'total_jam_kerja' => $totalJamKerja, // ✅ DISIMPAN KE DB
            ]);

            return back()->with('success', 'Absensi pulang berhasil');
        }

        return back()->with('error', 'Anda sudah absen hari ini');
    }

    // =====================
    // HALAMAN DATA ABSENSI
    // =====================
    public function index()
    {
        $absensi = Absensi::with('karyawan')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('absensi.index', compact('absensi'));
    }

    // =====================
    // QR CODE KARYAWAN
    // =====================
    public function barcode($id)
    {
        $karyawan = Karyawan::where('id_karyawan', $id)->firstOrFail();

        if (!$karyawan->kode_qr) {
            $karyawan->update([
                'kode_qr' => 'KRY-' . $karyawan->id_karyawan
            ]);
        }

        return view('absensi.qr', compact('karyawan'));
    }
}