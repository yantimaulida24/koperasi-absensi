<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with('jabatan')->get();
        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        $jabatan = Jabatan::all();
        return view('karyawan.create', compact('jabatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jabatan'     => 'required|exists:jabatans,id_jabatan',
            'nama_karyawan'  => 'required|string|max:255|unique:karyawans,nama_karyawan',
            'no_telepon'     => 'nullable|string|max:20|unique:karyawans,no_telepon',
            'alamat'         => 'nullable|string|max:255',
        ], [
            'nama_karyawan.unique' => 'Nama Karyawan sudah dimasukkan',
            'no_telepon.unique'   => 'No Telepon sudah digunakan',
        ]);

        $karyawan = new Karyawan();
        $karyawan->id_jabatan = $request->id_jabatan;
        $karyawan->nama_karyawan = $request->nama_karyawan;
        $karyawan->no_telepon = $request->no_telepon;
        $karyawan->alamat = $request->alamat;

        $this->generateQrCode($karyawan);

        $karyawan->save();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $jabatan = Jabatan::all();
        return view('karyawan.edit', compact('karyawan', 'jabatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_jabatan'     => 'required|exists:jabatans,id_jabatan',
            'nama_karyawan'  => 'required|string|max:255|unique:karyawans,nama_karyawan,' . $id . ',id_karyawan',
            'no_telepon'     => 'nullable|string|max:20|unique:karyawans,no_telepon,' . $id . ',id_karyawan',
            'alamat'         => 'nullable|string|max:255',
        ], [
            'nama_karyawan.unique' => 'Nama Karyawan sudah dimasukkan',
            'no_telepon.unique'   => 'No Telepon sudah digunakan',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->id_jabatan = $request->id_jabatan;
        $karyawan->nama_karyawan = $request->nama_karyawan;
        $karyawan->no_telepon = $request->no_telepon;
        $karyawan->alamat = $request->alamat;

        $karyawan->save();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus!');
    }

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