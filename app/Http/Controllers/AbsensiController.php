<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Menampilkan daftar absensi
    public function index()
    {
        $absensi = Absensi::with('karyawan')->latest()->get();
        return view('absensi.index', compact('absensi'));
    }

    // Ketika QR discan
    public function scan($kode_qr)
    {
        $karyawan = Karyawan::where('kode_qr', $kode_qr)->first();

        if (!$karyawan) {
            return redirect()->back()->with('error', 'QR Code tidak valid!');
        }

        $tanggal = Carbon::today()->toDateString();

        // Cek apakah sudah absen hari ini
        $absensi = Absensi::where('id_karyawan', $karyawan->id_karyawan)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if (!$absensi) {
            // Jika belum absen, simpan jam masuk
            Absensi::create([
                'id_karyawan' => $karyawan->id_karyawan,
                'tanggal' => $tanggal,
                'jam_masuk' => Carbon::now()->format('H:i:s'),
                'status' => 'Masuk',
            ]);

            return redirect()->route('absensi.index')->with('success', $karyawan->nama_karyawan . ' berhasil absen masuk!');
        } else {
            // Jika sudah absen, update jam keluar
            $absensi->update([
                'jam_keluar' => Carbon::now()->format('H:i:s'),
                'status' => 'Pulang',
            ]);

            return redirect()->route('absensi.index')->with('success', $karyawan->nama_karyawan . ' berhasil absen pulang!');
        }
    }
}
