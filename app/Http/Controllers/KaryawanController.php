<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class KaryawanController extends Controller
{
    // Menampilkan daftar karyawan
    public function index()
    {
        $karyawan = Karyawan::with('jabatan')->get();
        return view('karyawan.index', compact('karyawan'));
    }

    // Menampilkan form tambah karyawan
    public function create()
    {
        $jabatan = Jabatan::all();
        return view('karyawan.create', compact('jabatan'));
    }

    // Menyimpan data karyawan baru
    public function store(Request $request)
    {
        $request->validate([
            'id_jabatan' => 'required|exists:jabatans,id_jabatan',
            'nama_karyawan' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20|unique:karyawans,no_telepon',
            'alamat' => 'nullable|string|max:255',
        ]);

        $karyawan = Karyawan::create([
            'id_jabatan' => $request->id_jabatan,
            'nama_karyawan' => $request->nama_karyawan,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        // Generate QR code otomatis
        $this->generateQrCode($karyawan);
        $karyawan->save();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    // Menampilkan form edit karyawan
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $jabatan = Jabatan::all();
        return view('karyawan.edit', compact('karyawan', 'jabatan'));
    }

    // Update data karyawan
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_jabatan' => 'required|exists:jabatans,id_jabatan',
            'nama_karyawan' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20|unique:karyawans,no_telepon,' . $id . ',id_karyawan',
            'alamat' => 'nullable|string|max:255',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update([
            'id_jabatan' => $request->id_jabatan,
            'nama_karyawan' => $request->nama_karyawan,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    // Hapus data karyawan
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus!');
    }

    // Menampilkan detail karyawan
    public function show(Karyawan $karyawan)
    {
        if (empty($karyawan->kode_qr)) {
            $this->generateQrCode($karyawan);
            $karyawan->save();
        }

        try {
            $qrCode = QrCode::size(200)->generate($karyawan->kode_qr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat QR Code: ' . $e->getMessage());
        }

        return view('karyawan.show', compact('karyawan', 'qrCode'));
    }

    // Generate kode QR unik
    private function generateQrCode(Karyawan $karyawan)
    {
        if (empty($karyawan->kode_qr)) {
            do {
                $kode_qr = Str::random(20);
            } while (Karyawan::where('kode_qr', $kode_qr)->exists());

            $karyawan->kode_qr = $kode_qr;
        }
    }
}
