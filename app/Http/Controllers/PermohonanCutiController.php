<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanCuti;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PermohonanCutiController extends Controller
{
    public function index()
    {
        // Tampilkan semua cuti jika admin, atau milik sendiri jika karyawan
        if (Auth::user()->role === 'admin') {
            $cutis = PermohonanCuti::latest()->get();
        } else {
            $cutis = PermohonanCuti::where('id_karyawan', Auth::id())->latest()->get();
        }

        return view('permohonan-cuti.index', compact('cutis'));
    }

    public function create()
    {
        return view('permohonan-cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:500',
        ]);

        PermohonanCuti::create([
            'id_karyawan' => Auth::id(),
            'tanggal_pengajuan' => Carbon::now(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'Pending',
        ]);

        return redirect()->route('permohonan-cuti.index')->with('success', 'Permohonan cuti berhasil diajukan!');
    }

    public function edit($id)
    {
        $cuti = PermohonanCuti::findOrFail($id);
        return view('permohonan-cuti.edit', compact('cuti'));
    }

    public function update(Request $request, $id)
    {
        $cuti = PermohonanCuti::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Pending,Disetujui,Ditolak',
        ]);

        $cuti->update([
            'status' => $request->status
        ]);

        return redirect()->route('permohonan-cuti.index')->with('success', 'Status cuti berhasil diubah!');
    }

    public function destroy($id)
    {
        $cuti = PermohonanCuti::findOrFail($id);
        $cuti->delete();

        return redirect()->route('permohonan-cuti.index')->with('success', 'Permohonan cuti berhasil dihapus!');
    }
}
