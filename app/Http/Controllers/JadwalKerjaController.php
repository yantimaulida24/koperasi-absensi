<?php

namespace App\Http\Controllers;

use App\Models\JadwalKerja;
use Illuminate\Http\Request;

class JadwalKerjaController extends Controller
{
    public function index()
    {
        $urutanHari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];

        $jadwal = JadwalKerja::orderByRaw(
            "FIELD(hari_kerja, '".implode("','", $urutanHari)."')"
        )->get();

        return view('jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        return view('jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari_kerja' => 'required|string|max:20',
            'jam_masuk'  => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i|after:jam_masuk',
        ]);

        if (JadwalKerja::where('hari_kerja', $request->hari_kerja)->exists()) {
            return back()->withInput()->with('error', 'Hari kerja sudah ada');
        }

        JadwalKerja::create($request->only([
            'hari_kerja','jam_masuk','jam_keluar'
        ]));

        return redirect()->route('jadwal-kerja.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(JadwalKerja $jadwal_kerja)
    {
        return view('jadwal.edit', compact('jadwal_kerja'));
    }

    public function update(Request $request, JadwalKerja $jadwal_kerja)
    {
        $request->validate([
            'hari_kerja' => 'required|string|max:20',
            'jam_masuk'  => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i|after:jam_masuk',
        ]);

        if (
            JadwalKerja::where('hari_kerja', $request->hari_kerja)
                ->where('id_jadwal', '!=', $jadwal_kerja->id_jadwal)
                ->exists()
        ) {
            return back()->withInput()->with('error', 'Hari kerja sudah digunakan');
        }

        $jadwal_kerja->update($request->only([
            'hari_kerja','jam_masuk','jam_keluar'
        ]));

        return redirect()->route('jadwal-kerja.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(JadwalKerja $jadwal_kerja)
    {
        $jadwal_kerja->delete();

        return redirect()->route('jadwal-kerja.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }
}