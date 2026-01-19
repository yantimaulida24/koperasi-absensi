<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with('jabatan')->get();
        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        $this->onlyAdmin();
        $jabatan = Jabatan::all();
        return view('karyawan.create', compact('jabatan'));
    }

    public function store(Request $request)
    {
        $this->onlyAdmin();

        $request->validate([
            'id_jabatan' => 'required|exists:jabatans,id_jabatan',
            'nama_karyawan' => 'required|string|max:255|unique:karyawans,nama_karyawan',
            'no_telepon' => 'nullable|string|max:20|unique:karyawans,no_telepon',
            'alamat' => 'nullable|string|max:255',
        ]);

        $karyawan = Karyawan::create($request->only(['id_jabatan','nama_karyawan','no_telepon','alamat']));
        $this->generateQrCode($karyawan);
        $karyawan->save();

        return redirect()->route('data-karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan');
    }

    public function show(Karyawan $data_karyawan)
    {
        $karyawan = $data_karyawan->load('jabatan');

        if(empty($karyawan->kode_qr)){
            $this->generateQrCode($karyawan);
            $karyawan->save();
        }

        $urlQr = url('/absen/scan?kode=' . $karyawan->kode_qr);
        $qrCode = QrCode::format('svg')->size(250)->generate($urlQr);

        return view('karyawan.show', compact('karyawan', 'qrCode'));
    }

    public function edit(Karyawan $data_karyawan)
    {
        $this->onlyAdmin();
        $jabatan = Jabatan::all();
        return view('karyawan.edit', ['karyawan' => $data_karyawan, 'jabatan' => $jabatan]);
    }

    public function update(Request $request, Karyawan $data_karyawan)
    {
        $this->onlyAdmin();

        $request->validate([
            'id_jabatan' => 'required|exists:jabatans,id_jabatan',
            'nama_karyawan' => 'required|string|max:255|unique:karyawans,nama_karyawan,' . $data_karyawan->id_karyawan . ',id_karyawan',
            'no_telepon' => 'nullable|string|max:20|unique:karyawans,no_telepon,' . $data_karyawan->id_karyawan . ',id_karyawan',
            'alamat' => 'nullable|string|max:255',
        ]);

        $data_karyawan->update($request->only(['id_jabatan','nama_karyawan','no_telepon','alamat']));
        return redirect()->route('data-karyawan.index')->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy(Karyawan $data_karyawan)
    {
        $this->onlyAdmin();
        $data_karyawan->delete();
        return redirect()->route('data-karyawan.index')->with('success', 'Data karyawan berhasil dihapus');
    }

    public function downloadQr(Karyawan $data_karyawan)
    {
        if(empty($data_karyawan->kode_qr)){
            $this->generateQrCode($data_karyawan);
            $data_karyawan->save();
        }

        $urlQr = url('/absen/scan?kode=' . $data_karyawan->kode_qr);
        $qrSvg = QrCode::format('svg')->size(300)->generate($urlQr);
        $filename = 'QR_' . str_replace(' ', '_', $data_karyawan->nama_karyawan) . '.svg';

        return response($qrSvg)
            ->header('Content-Type','image/svg+xml')
            ->header('Content-Disposition','attachment; filename="'.$filename.'"');
    }

    // Helper
    private function onlyAdmin()
    {
        if(!Auth::check() || Auth::user()->role !== 'admin'){
            abort(403, 'Akses ditolak');
        }
    }

    private function generateQrCode(Karyawan $karyawan)
    {
        if(empty($karyawan->kode_qr)){
            do {
                $kode = Str::random(20);
            } while(Karyawan::where('kode_qr', $kode)->exists());
            $karyawan->kode_qr = $kode;
        }
    }
}
