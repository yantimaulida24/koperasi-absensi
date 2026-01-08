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
        $request->validate([
            'kode_qr' => 'required'
        ]);

        $karyawan = Karyawan::where('kode_qr', $request->kode_qr)->first();

        if (!$karyawan) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code tidak valid'
            ]);
        }

        $tanggal = Carbon::today()->toDateString();

        $absensi = Absensi::where('id_karyawan', $karyawan->id_karyawan)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if (!$absensi) {
            Absensi::create([
                'id_karyawan' => $karyawan->id_karyawan,
                'tanggal' => $tanggal,
                'waktu_masuk' => Carbon::now()->format('H:i:s'),
                'status' => 'Masuk'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => $karyawan->nama_karyawan . ' berhasil absen masuk'
            ]);
        }

        if ($absensi->waktu_keluar == null) {
            $absensi->update([
                'waktu_keluar' => Carbon::now()->format('H:i:s'),
                'status' => 'Pulang'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => $karyawan->nama_karyawan . ' berhasil absen pulang'
            ]);
        }

        return response()->json([
            'status' => 'info',
            'message' => 'Anda sudah absen hari ini'
        ]);
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
        return view('absensi.qr', compact('karyawan'));
    }
}
