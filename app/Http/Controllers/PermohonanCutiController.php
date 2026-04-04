<?php

namespace App\Http\Controllers;

use App\Models\PermohonanCuti;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PermohonanCutiController extends Controller
{
    // Menampilkan daftar permohonan cuti
    public function index()
    {
        $cuti = PermohonanCuti::with('karyawan')->get();
        return view('permohonan-cuti.index', compact('cuti'));
    }

    // Menampilkan form tambah permohonan cuti
    public function create()
    {
        $karyawan = Karyawan::all();
        return view('permohonan-cuti.create', compact('karyawan'));
    }

    // Menyimpan permohonan cuti baru
    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id_karyawan',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan_cuti' => 'required|string',
        ]);

        // Saat tambah permohonan cuti, status otomatis "belum disetujui"
        PermohonanCuti::create([
            'id_karyawan' => $request->id_karyawan,
            'tanggal_pengajuan' => Carbon::today(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_cuti' => 'belum disetujui',
            'alasan_cuti' => $request->alasan_cuti,
        ]);

        return redirect()->route('permohonan-cuti.index')->with('success', 'Permohonan cuti berhasil dibuat!');
    }

    // Menampilkan form edit permohonan cuti
    public function edit($id)
    {
        $cuti = PermohonanCuti::findOrFail($id);
        $karyawan = Karyawan::all();
        return view('permohonan-cuti.edit', compact('cuti', 'karyawan'));
    }

    // Update permohonan cuti (hanya status bisa diubah admin)
    public function update(Request $request, $id)
    {
    $cuti = PermohonanCuti::findOrFail($id);

    $request->validate([
        'id_karyawan'      => 'required|exists:karyawans,id_karyawan',
        'tanggal_mulai'    => 'required|date',
        'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
        'alasan_cuti'      => 'required|string',
        'status_cuti' => 'required|in:disetujui,belum disetujui,ditolak',
    ]);

    $cuti->update([
        'id_karyawan'      => $request->id_karyawan,
        'tanggal_mulai'    => $request->tanggal_mulai,
        'tanggal_selesai'  => $request->tanggal_selesai,
        'status_cuti'      => $request->status_cuti,
        'alasan_cuti'      => $request->alasan_cuti,
    ]);

    return redirect()
        ->route('permohonan-cuti.index')
        ->with('success', 'Permohonan cuti berhasil diperbarui!');
    }

    // Hapus permohonan cuti
    public function destroy($id)
    {
        $cuti = PermohonanCuti::findOrFail($id);
        $cuti->delete();

        return redirect()->route('permohonan-cuti.index')->with('success', 'Permohonan cuti berhasil dihapus!');
    }
}