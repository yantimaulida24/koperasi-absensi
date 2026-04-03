<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // =====================
    // HALAMAN SCAN
    // =====================
    public function scanPage()
    {
        return view('absensi.scan');
    }

    // =====================
    // PROSES SCAN
    // =====================
    public function prosesScan(Request $request)
    {
        // =====================
        // AMBIL FOTO SELFIE
        // =====================
        $fotoBase64 = null;

        if ($request->has('foto_absen')) {
            $fotoBase64 = $request->foto_absen;
            $fotoBase64 = str_replace('data:image/png;base64,', '', $fotoBase64);
            $fotoBase64 = str_replace(' ', '+', $fotoBase64);
        }

        $raw = trim($request->kode_qr);

        if (empty($raw)) {
            return back()->with('error', 'QR kosong');
        }

        // =====================
        // VALIDASI QR
        // =====================
        preg_match('/KRY-\d+/i', $raw, $match);

        if (!$match) {
            return back()->with('error', 'QR Code tidak valid');
        }

        $kodeQR     = strtoupper($match[0]);
        $idKaryawan = (int) str_replace('KRY-', '', $kodeQR);

        // =====================
        // CEK KARYAWAN
        // =====================
        $karyawan = Karyawan::where('id_karyawan', $idKaryawan)->first();

        if (!$karyawan) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }

        // =====================
        // WAKTU SEKARANG (WITA)
        // =====================
        $now     = Carbon::now('Asia/Makassar');
        $tanggal = $now->toDateString();
        $waktu   = $now->format('H:i:s');

        // =====================
        // CEK ABSEN HARI INI
        // =====================
        $absen = Absensi::where('id_karyawan', $idKaryawan)
            ->where('tanggal', $tanggal)
            ->first();

        // =====================
        // CEGAH DOUBLE SCAN
        // =====================
        if ($absen) {
            $lastUpdate = Carbon::parse($absen->updated_at);

            if ($lastUpdate->diffInSeconds($now) < 30) {
                return back()->with('error', 'Tunggu 30 detik sebelum scan lagi');
            }
        }

        // =====================
        // ABSEN MASUK
        // =====================
        if (!$absen) {

            Absensi::create([
                'id_karyawan' => $idKaryawan,
                'tanggal'     => $tanggal,
                'waktu_masuk' => $waktu,
                'status'      => 'Hadir',
                'foto_absen'  => $fotoBase64
            ]);

            return back()->with('success', 'Absensi masuk berhasil');
        }

        // =====================
        // ABSEN PULANG
        // =====================
        if (is_null($absen->waktu_keluar)) {

            $masuk  = Carbon::createFromFormat('H:i:s', $absen->waktu_masuk);
            $keluar = Carbon::createFromFormat('H:i:s', $waktu);

            $totalMenit = $masuk->diffInMinutes($keluar);
            $totalJamKerja = round($totalMenit / 60, 2);

            $absen->update([
                'waktu_keluar'    => $waktu,
                'total_jam_kerja' => $totalJamKerja,
                'foto_absen'      => $fotoBase64
            ]);

            return back()->with('success', 'Absensi pulang berhasil');
        }

        // =====================
        // SUDAH ABSEN
        // =====================
        return back()->with('error', 'Anda sudah absen hari ini');
    }

    // =====================
    // HALAMAN ABSENSI (FIX)
    // =====================
    public function index()
    {
        $today = Carbon::now('Asia/Makassar')->toDateString();

        // 🔥 Ambil semua karyawan
        $karyawan = Karyawan::all();

        // 🔥 Ambil absensi hari ini saja
        $absensi = Absensi::where('tanggal', $today)->get();

        return view('absensi.index', compact('karyawan', 'absensi'));
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