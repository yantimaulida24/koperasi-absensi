<?php

namespace App\Http\Controllers;

use App\Models\JadwalKerja;
use Illuminate\Http\Request;

class JadwalKerjaController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKerja::all();
        return view('jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        return view('jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari_kerja' => 'required',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required'
        ]);

        JadwalKerja::create($request->all());

        return redirect()->route('jadwal.index')
                         ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(JadwalKerja $jadwal)
{
    return view('jadwal.edit', compact('jadwal'));
}

public function update(Request $request, JadwalKerja $jadwal)
{
    $request->validate([
        'hari_kerja' => 'required',
        'jam_masuk' => 'required',
        'jam_keluar' => 'required'
    ]);

    $jadwal->update($request->all());

    return redirect()->route('jadwal.index')
                     ->with('success', 'Jadwal berhasil diperbarui.');
}


    public function destroy($id)
    {
        JadwalKerja::destroy($id);

        return redirect()->route('jadwal.index')
                         ->with('success', 'Jadwal berhasil dihapus.');
    }
}
