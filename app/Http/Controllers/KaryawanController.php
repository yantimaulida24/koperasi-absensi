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

        // Generate kode QR unik
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

    public function show(Karyawan $data_karyawan)
{
    $karyawan = $data_karyawan->load('jabatan');

    // ✅ IP laptop kamu (sesuai ipconfig)
    $ipLaptop = '192.168.43.66';
    $port = '8000'; // port Laravel kamu

    // URL tujuan absensi (misal: route absensi.scan)
    $urlQr = "http://{$ipLaptop}:{$port}/absensi/scan/" . $karyawan->kode_qr;

    // Jika belum ada kode QR, buat baru
    if (empty($karyawan->kode_qr)) {
        $this->generateQrCode($karyawan);
        $karyawan->update(['kode_qr' => $karyawan->kode_qr]);
    }

    // Generate QR code dari URL
    try {
        $qrCode = QrCode::size(200)->generate($urlQr);
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
