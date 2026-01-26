<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

// QR tampil di halaman
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeView;

// QR untuk PDF
use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\Writer\PngWriter;

// PDF
use Barryvdh\DomPDF\Facade\Pdf;

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

        $karyawan = Karyawan::create(
            $request->only(['id_jabatan','nama_karyawan','no_telepon','alamat'])
        );

        $this->generateQrCode($karyawan);
        $karyawan->save();

        return redirect()
            ->route('data-karyawan.index')
            ->with('success', 'Data karyawan berhasil ditambahkan');
    }

    public function show(Karyawan $data_karyawan)
    {
        $karyawan = $data_karyawan->load('jabatan');

        if (empty($karyawan->kode_qr)) {
            $this->generateQrCode($karyawan);
            $karyawan->save();
        }

        $urlQr = url('/absen/scan?kode=' . $karyawan->kode_qr);

        // QR UNTUK TAMPILAN HALAMAN
        $qrCode = QrCodeView::format('svg')->size(250)->generate($urlQr);

        return view('karyawan.show', compact('karyawan', 'qrCode'));
    }

    public function edit(Karyawan $data_karyawan)
    {
        $this->onlyAdmin();
        $jabatan = Jabatan::all();

        return view('karyawan.edit', [
            'karyawan' => $data_karyawan,
            'jabatan' => $jabatan
        ]);
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

        $data_karyawan->update(
            $request->only(['id_jabatan','nama_karyawan','no_telepon','alamat'])
        );

        return redirect()
            ->route('data-karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy(Karyawan $data_karyawan)
    {
        $this->onlyAdmin();
        $data_karyawan->delete();

        return redirect()
            ->route('data-karyawan.index')
            ->with('success', 'Data karyawan berhasil dihapus');
    }

   public function downloadQr(Karyawan $data_karyawan)
    {
    $karyawan = $data_karyawan->load('jabatan');

    $urlQr = url('/absen/scan?kode=' . $karyawan->kode_qr);

    // Generate QR PNG
    $qrCode = new \Endroid\QrCode\QrCode($urlQr);
    $qrCode->setSize(300);
    $qrCode->setMargin(10);

    $writer = new \Endroid\QrCode\Writer\PngWriter();
    $result = $writer->write($qrCode);

    $qrPng = base64_encode($result->getString());

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'karyawan.qr-pdf',
        compact('karyawan', 'qrPng')
    )->setPaper('A4', 'portrait');

    return $pdf->download('kartu-karyawan-'.$karyawan->id_karyawan.'.pdf');
}

    // =========================
    // HELPER
    // =========================
    private function onlyAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
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