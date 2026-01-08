<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /* ==============================
     * 📱 HALAMAN SCAN QR
     * ============================== */
    public function scanPage()
    {
        return view('absensi.scan');
    }

    /* ==============================
     * 🔄 PROSES HASIL SCAN QR
     * ============================== */
    public function prosesScan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required'
        ]);

        $karyawan = Karyawan::where('kode_qr', $request->qr_code)->first();

        if (!$karyawan) {
            return back()->with('error', 'QR Code tidak valid');
        }

        $absensi = Absensi::where('karyawan_id', $karyawan->id_karyawan)
            ->whereDate('created_at', now()->toDateString())
            ->first();

        // ABSEN MASUK
        if (!$absensi) {
            Absensi::create([
                'karyawan_id' => $karyawan->id_karyawan,
                'waktu_masuk' => now()->format('H:i:s'),
            ]);

            return redirect()->route('absensi.index')
                ->with('success', $karyawan->nama_karyawan . ' absen masuk');
        }

        // ABSEN PULANG
        if ($absensi->waktu_keluar === null) {
            $absensi->update([
                'waktu_keluar' => now()->format('H:i:s'),
            ]);

            return redirect()->route('absensi.index')
                ->with('success', $karyawan->nama_karyawan . ' absen pulang');
        }

        return redirect()->route('absensi.index')
            ->with('error', 'Sudah absen hari ini');
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
     * 🖥️ QR CODE KARYAWAN
     * ============================== */
    public function barcode($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('absensi.qr', compact('karyawan'));
    }
}