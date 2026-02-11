<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// QR (tampilan & PNG)
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeView;

// PDF
use Barryvdh\DomPDF\Facade\Pdf;

class KaryawanController extends Controller
{
    /* =========================
       INDEX
       ========================= */
    public function index(Request $request)
    {
        $karyawan = Karyawan::with('jabatan')
            ->when($request->search, function ($query) use ($request) {
                $query->where('nama_karyawan', 'like', '%' . $request->search . '%');
            })
            ->get();

        return view('karyawan.index', compact('karyawan'));
    }

    /* =========================
       CREATE
       ========================= */
    public function create()
    {
        $this->onlyAdmin();

        $jabatan = Jabatan::all();
        return view('karyawan.create', compact('jabatan'));
    }

    /* =========================
       STORE
       ========================= */
    public function store(Request $request)
    {
        $this->onlyAdmin();

        $request->validate([
            'id_jabatan'     => 'required|exists:jabatans,id_jabatan',
            'nama_karyawan'  => 'required|string|max:255|unique:karyawans,nama_karyawan',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'no_telepon'     => 'nullable|string|max:20|unique:karyawans,no_telepon',
            'alamat'         => 'nullable|string|max:255',
        ]);

        Karyawan::create($request->all());

        return redirect()
            ->route('data-karyawan.index')
            ->with('success', 'Data karyawan berhasil ditambahkan');
    }

    /* =========================
       SHOW
       ========================= */
    public function show(Karyawan $data_karyawan)
    {
        $karyawan = $data_karyawan->load('jabatan');

        $urlQr = url('/absen/scan?kode=' . $karyawan->kode_qr);

        $qrCode = QrCodeView::format('svg')
            ->size(250)
            ->generate($urlQr);

        return view('karyawan.show', compact('karyawan', 'qrCode'));
    }

    /* =========================
       EDIT
       ========================= */
    public function edit(Karyawan $data_karyawan)
    {
        $this->onlyAdmin();

        $jabatan = Jabatan::all();

        return view('karyawan.edit', [
            'karyawan' => $data_karyawan,
            'jabatan'  => $jabatan
        ]);
    }

    /* =========================
       UPDATE
       ========================= */
    public function update(Request $request, Karyawan $data_karyawan)
    {
        $this->onlyAdmin();

        $request->validate([
            'id_jabatan'     => 'required|exists:jabatans,id_jabatan',
            'nama_karyawan'  => 'required|string|max:255|unique:karyawans,nama_karyawan,' 
                                . $data_karyawan->id_karyawan . ',id_karyawan',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'no_telepon'     => 'nullable|string|max:20|unique:karyawans,no_telepon,' 
                                . $data_karyawan->id_karyawan . ',id_karyawan',
            'alamat'         => 'nullable|string|max:255',
        ]);

        $data_karyawan->update($request->all());

        return redirect()
            ->route('data-karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    /* =========================
       DESTROY
       ========================= */
    public function destroy(Karyawan $data_karyawan)
    {
        $this->onlyAdmin();

        $data_karyawan->delete();

        return redirect()
            ->route('data-karyawan.index')
            ->with('success', 'Data karyawan berhasil dihapus');
    }

    /* =========================
       DOWNLOAD QR PDF
       ========================= */
    public function downloadQr(Karyawan $data_karyawan)
    {
        $karyawan = $data_karyawan->load('jabatan');

        $urlQr = url('/absen/scan?kode=' . $karyawan->kode_qr);

        // Generate QR PNG (tanpa Endroid)
        $qrPng = base64_encode(
            QrCodeView::format('png')
                ->size(300)
                ->generate($urlQr)
        );

        $pdf = Pdf::loadView(
            'karyawan.qr-pdf',
            compact('karyawan', 'qrPng')
        )->setPaper('A4', 'portrait');

        return $pdf->download(
            'kartu-karyawan-' . $karyawan->id_karyawan . '.pdf'
        );
    }

    /* =========================
       HELPER
       ========================= */
    private function onlyAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }
    }
}