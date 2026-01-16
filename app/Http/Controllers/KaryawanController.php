<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; // tambahkan ini

class KaryawanController extends Controller
{
    /* =========================
       INDEX
       ========================= */
    public function index()
    {
        $karyawan = Karyawan::with('jabatan')->get();
        return view('karyawan.index', compact('karyawan'));
    }

    /* =========================
       CREATE (ADMIN ONLY)
       ========================= */
    public function create()
    {
        $this->onlyAdmin();

        $jabatan = Jabatan::all();
        return view('karyawan.create', compact('jabatan'));
    }

    /* =========================
       STORE (ADMIN ONLY)
       ========================= */
    public function store(Request $request)
    {
        $this->onlyAdmin();

        $request->validate([
            'id_jabatan'     => 'required|exists:jabatans,id_jabatan',
            'nama_karyawan'  => 'required|string|max:255|unique:karyawans,nama_karyawan',
            'no_telepon'     => 'nullable|string|max:20|unique:karyawans,no_telepon',
            'alamat'         => 'nullable|string|max:255',
        ]);

        $karyawan = new Karyawan();
        $karyawan->id_jabatan    = $request->id_jabatan;
        $karyawan->nama_karyawan = $request->nama_karyawan;
        $karyawan->no_telepon    = $request->no_telepon;
        $karyawan->alamat        = $request->alamat;

        $this->generateQrCode($karyawan);
        $karyawan->save();

        return redirect()->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil ditambahkan');
    }

    /* =========================
       SHOW
       ========================= */
    public function show(Karyawan $data_karyawan)
    {
        $karyawan = $data_karyawan->load('jabatan');

        if (empty($karyawan->kode_qr)) {
            $this->generateQrCode($karyawan);
            $karyawan->save();
        }

        $urlQr = url('/absen/scan?kode=' . $karyawan->kode_qr);

        $qrCode = QrCode::format('svg')
            ->size(250)
            ->generate($urlQr);

        return view('karyawan.show', compact('karyawan', 'qrCode'));
    }

    /* =========================
       DOWNLOAD QR (SVG)
       ========================= */
    public function downloadQr($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        if (empty($karyawan->kode_qr)) {
            $this->generateQrCode($karyawan);
            $karyawan->save();
        }

        $urlQr = url('/absen/scan?kode=' . $karyawan->kode_qr);

        $qrSvg = QrCode::format('svg')
            ->size(300)
            ->generate($urlQr);

        $filename = 'QR_' . str_replace(' ', '_', $karyawan->nama_karyawan) . '.svg';

        return response($qrSvg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /* =========================
       EDIT (ADMIN ONLY)
       ========================= */
    public function edit($id)
    {
        $this->onlyAdmin();

        $karyawan = Karyawan::findOrFail($id);
        $jabatan  = Jabatan::all();

        return view('karyawan.edit', compact('karyawan', 'jabatan'));
    }

    /* =========================
       UPDATE (ADMIN ONLY)
       ========================= */
    public function update(Request $request, $id)
    {
        $this->onlyAdmin();

        $request->validate([
            'id_jabatan'     => 'required|exists:jabatans,id_jabatan',
            'nama_karyawan'  => 'required|string|max:255|unique:karyawans,nama_karyawan,' . (int)$id . ',id_karyawan',
            'no_telepon'     => 'nullable|string|max:20|unique:karyawans,no_telepon,' . (int)$id . ',id_karyawan',
            'alamat'         => 'nullable|string|max:255',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($request->only([
            'id_jabatan',
            'nama_karyawan',
            'no_telepon',
            'alamat'
        ]));

        return redirect()->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    /* =========================
       DELETE (ADMIN ONLY)
       ========================= */
    public function destroy($id)
    {
        $this->onlyAdmin();

        Karyawan::findOrFail($id)->delete();

        return redirect()->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil dihapus');
    }

    /* =========================
       HELPER
       ========================= */
    private function onlyAdmin()
    {
        // Perbaikan baris merah di IDE
        if (!Auth::check() || Auth::user()?->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }
    }

    private function generateQrCode(Karyawan $karyawan)
    {
        if (empty($karyawan->kode_qr)) {
            do {
                $kode = Str::random(20);
            } while (Karyawan::where('kode_qr', $kode)->exists());

            $karyawan->kode_qr = $kode;
        }
    }
}
