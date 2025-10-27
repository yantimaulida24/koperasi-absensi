<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Absensi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Halaman daftar QR Code
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('absensi.index', compact('karyawans'));
    }

    // Simpan absensi manual (opsional)
    public function store(Request $request)
    {
        $kode_qr = $request->input('kode_qr');
        $karyawan = Karyawan::where('kode_qr', $kode_qr)->first();

        if ($karyawan) {
            Absensi::create([
                'karyawan_id' => $karyawan->id,
                'waktu_masuk' => Carbon::now(),
            ]);

            return redirect()->back()->with('success', 'Absensi berhasil untuk: ' . $karyawan->nama);
        } else {
            return redirect()->back()->with('error', 'Kode QR tidak ditemukan');
        }
    }

    // Tambah karyawan + generate QR unik
    public function createKaryawan(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'nullable|email',
            'jabatan' => 'nullable|string'
        ]);

        $kode_qr = uniqid('QR_');
        $karyawan = Karyawan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'kode_qr' => $kode_qr,
        ]);

        // Ganti IP sesuai IP laptop kamu agar bisa diakses lewat HP
        $ipLaptop = '192.168.1.10'; // 👉 ganti dengan IP lokal kamu
        $url = "http://{$ipLaptop}:8000/absensi/scan/{$kode_qr}";

        // Generate QR Code yang bisa di-scan HP
        $qrCode = QrCode::size(200)->generate($url);

        return view('absensi.qr', compact('karyawan', 'qrCode'))
            ->with('success', 'Karyawan berhasil ditambahkan dengan QR Code.');
    }

    // Fungsi otomatis saat QR di-scan lewat HP
    public function scan($kode_qr)
    {
        $karyawan = Karyawan::where('kode_qr', $kode_qr)->first();

        if (!$karyawan) {
            return view('absensi.gagal', ['pesan' => 'Kode QR tidak ditemukan']);
        }

        // Simpan absensi otomatis
        Absensi::create([
            'karyawan_id' => $karyawan->id,
            'waktu_masuk' => Carbon::now(),
        ]);

        // Tampilkan halaman sukses
        return view('absensi.sukses', compact('karyawan'));
    }
}
