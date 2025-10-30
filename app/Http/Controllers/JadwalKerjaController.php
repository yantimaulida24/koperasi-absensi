<?php

namespace App\Http\Controllers;

use App\Models\JadwalKerja;
use Illuminate\Http\Request;

class JadwalKerjaController extends Controller
{
    public function index()
    {
        // Urutan hari kerja agar selalu Senin → Minggu
        $hariUrutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Ambil semua data dan urutkan sesuai array
        $jadwal = JadwalKerja::orderByRaw("FIELD(hari_kerja, '".implode("','", $hariUrutan)."')")->get();

        return view('jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        // Tampilkan form tambah jadwal
        return view('jadwal.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'hari_kerja' => 'required|string|max:20',
            'jam_masuk'  => 'required|date_format:H:i',  
            'jam_keluar' => 'required|date_format:H:i|after:jam_masuk',  
        ]);

        // Cek hari kerja sudah ada
        if (JadwalKerja::where('hari_kerja', $request->hari_kerja)->exists()) {
            return redirect()->back()->withInput()->with('error', 'Hari kerja tersebut sudah terdaftar!');
        }

        // Simpan data
        JadwalKerja::create($request->only(['hari_kerja', 'jam_masuk', 'jam_keluar']));

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(JadwalKerja $jadwal_kerja)
    {
        // Tampilkan form edit
        return view('jadwal.edit', compact('jadwal_kerja'));
    }

    public function update(Request $request, JadwalKerja $jadwal_kerja)
    {
        // Validasi input
        $request->validate([
            'hari_kerja' => 'required|string|max:20',
            'jam_masuk'  => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i|after:jam_masuk',
        ]);

        // Cek duplikat hari
        if (JadwalKerja::where('hari_kerja', $request->hari_kerja)
                       ->where('id_jadwal', '!=', $jadwal_kerja->id_jadwal)
                       ->exists()) {
            return redirect()->back()->withInput()->with('error', 'Hari kerja tersebut sudah digunakan!');
        }

        // Update data
        $jadwal_kerja->update($request->only(['hari_kerja', 'jam_masuk', 'jam_keluar']));

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(JadwalKerja $jadwal_kerja)
    {
        try {
            $jadwal_kerja->delete();
            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('jadwal.index')->with('error', 'Terjadi kesalahan saat menghapus jadwal.');
        }
    }
}