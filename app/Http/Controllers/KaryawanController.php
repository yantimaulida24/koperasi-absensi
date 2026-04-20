<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// QR
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeView;

// PDF
use Barryvdh\DomPDF\Facade\Pdf;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role === 'admin') {

            // 👑 ADMIN: semua data karyawan
            $karyawan = Karyawan::with('jabatan')
                ->when($request->search, function ($query) use ($request) {
                    $query->where('nama_karyawan', 'like', '%' . $request->search . '%');
                })
                ->get();

        } else {

            // 👷 KARYAWAN: hanya data dirinya sendiri
            $karyawan = Karyawan::with('jabatan')
                ->where('id_karyawan', Auth::user()->id_karyawan)
                ->get();
        }

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
            'id_jabatan'     => 'required|exists:jabatans,id_jabatan',
            'nik_karyawan'   => 'required|string|max:50|unique:karyawans,nik_karyawan',
            'nama_karyawan'  => 'required|string|max:255',
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

    public function show(Karyawan $data_karyawan)
    {
        $karyawan = $data_karyawan->load('jabatan');

        // 🔐 Karyawan hanya boleh lihat dirinya sendiri
        if (Auth::user()->role !== 'admin' &&
            Auth::user()->id_karyawan != $karyawan->id_karyawan) {
            abort(403, 'Akses ditolak');
        }

        $urlQr = url('/absen/scan?kode=' . $karyawan->kode_qr);

        $qrCode = QrCodeView::format('svg')
            ->size(250)
            ->generate($urlQr);

        return view('karyawan.show', compact('karyawan', 'qrCode'));
    }

    public function edit(Karyawan $data_karyawan)
    {
        $this->onlyAdmin();

        $jabatan = Jabatan::all();

        return view('karyawan.edit', [
            'karyawan' => $data_karyawan,
            'jabatan'  => $jabatan
        ]);
    }

    public function update(Request $request, Karyawan $data_karyawan)
    {
        $this->onlyAdmin();

        $request->validate([
            'id_jabatan'     => 'required|exists:jabatans,id_jabatan',
            'nik_karyawan'   => 'required|string|max:50|unique:karyawans,nik_karyawan,' 
                                . $data_karyawan->id_karyawan . ',id_karyawan',
            'nama_karyawan'  => 'required|string|max:255',
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

        // 🔐 hanya admin atau pemilik data
        if (Auth::user()->role !== 'admin' &&
            Auth::user()->id_karyawan != $karyawan->id_karyawan) {
            abort(403, 'Akses ditolak');
        }

        $urlQr = url('/absen/scan?kode=' . $karyawan->kode_qr);

        $qrSvg = QrCodeView::format('svg')
            ->size(300)
            ->generate($urlQr);

        $pdf = Pdf::loadView(
            'karyawan.qr-pdf',
            compact('karyawan', 'qrSvg')
        )->setPaper('A4', 'portrait');

        return $pdf->download(
            'kartu-karyawan-' . $karyawan->id_karyawan . '.pdf'
        );
    }

    private function onlyAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }
    }
}