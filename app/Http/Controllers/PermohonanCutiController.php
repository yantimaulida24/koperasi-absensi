<?php

namespace App\Http\Controllers;

use App\Models\PermohonanCuti;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PermohonanCutiController extends Controller
{
    public function index()
    {
        $cuti = PermohonanCuti::with('karyawan')->get();
        return view('permohonan-cuti.index', compact('cuti'));
    }

    public function create()
    {
        $karyawan = Karyawan::all(); // tetap, tidak dihapus
        return view('permohonan-cuti.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // 🔥 HAPUS VALIDASI id_karyawan
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan_cuti' => 'required|string',
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai cuti wajib diisi.',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.',
            
            'tanggal_selesai.required' => 'Tanggal selesai cuti wajib diisi.',
            'tanggal_selesai.date' => 'Format tanggal selesai tidak valid.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            
            'alasan_cuti.required' => 'Alasan cuti wajib diisi.',
        ]);

        PermohonanCuti::create([
            'id_karyawan' => Auth::user()->id_karyawan, // 🔥 otomatis
            'tanggal_pengajuan' => Carbon::today(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_cuti' => 'belum disetujui',
            'alasan_cuti' => $request->alasan_cuti,
        ]);

        return redirect()->route('permohonan-cuti.index')
            ->with('success', 'Permohonan cuti berhasil diajukan.');
    }

    public function edit($id)
    {
        $cuti = PermohonanCuti::findOrFail($id);
        $karyawan = Karyawan::all(); // tetap
        return view('permohonan-cuti.edit', compact('cuti', 'karyawan'));
    }

    public function update(Request $request, $id)
    {
        $cuti = PermohonanCuti::findOrFail($id);

        $request->validate([
            // 🔥 HAPUS VALIDASI id_karyawan
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan_cuti' => 'required|string',
            'status_cuti' => 'required|in:disetujui,belum disetujui,ditolak',
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai cuti wajib diisi.',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid.',

            'tanggal_selesai.required' => 'Tanggal selesai cuti wajib diisi.',
            'tanggal_selesai.date' => 'Format tanggal selesai tidak valid.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',

            'alasan_cuti.required' => 'Alasan cuti wajib diisi.',

            'status_cuti.required' => 'Status cuti wajib dipilih.',
            'status_cuti.in' => 'Status cuti tidak valid.',
        ]);

        $cuti->update([
            // 🔥 HAPUS id_karyawan
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_cuti' => $request->status_cuti,
            'alasan_cuti' => $request->alasan_cuti,
        ]);

        return redirect()->route('permohonan-cuti.index')
            ->with('success', 'Permohonan cuti berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $cuti = PermohonanCuti::findOrFail($id);
        $cuti->delete();

        return redirect()->route('permohonan-cuti.index')
            ->with('success', 'Permohonan cuti berhasil dihapus.');
    }
}