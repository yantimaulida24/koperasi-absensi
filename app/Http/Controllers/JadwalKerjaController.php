<?php

namespace App\Http\Controllers;

use App\Models\JadwalKerja;
use Illuminate\Http\Request;

class JadwalKerjaController extends Controller
{
    public function index()
    {
        $hariUrutan = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];

        $jadwal = JadwalKerja::orderByRaw("FIELD(hari_kerja, '".implode("','",$hariUrutan)."')")->get();

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
        ], [
            'hari_kerja.required' => 'Hari kerja wajib diisi.',
            'jam_masuk.required'  => 'Jam masuk wajib diisi.',
            'jam_masuk.date_format' => 'Format jam masuk harus 24 jam (contoh: 08:00).',
            'jam_keluar.required' => 'Jam keluar wajib diisi.',
            'jam_keluar.date_format' => 'Format jam keluar harus 24 jam (contoh: 17:00).',
            'jam_keluar.after' => 'Jam keluar harus lebih besar dari jam masuk.',
        ]);

        if (JadwalKerja::where('hari_kerja', $request->hari_kerja)->exists()) {
            return back()->withInput()->with('error', 'Hari kerja tersebut sudah terdaftar.');
        }

        JadwalKerja::create([
            'hari_kerja' => $request->hari_kerja,
            'jam_masuk'  => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Data jadwal kerja berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = JadwalKerja::findOrFail($id);
        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalKerja::findOrFail($id);

        $request->validate([
            'hari_kerja' => 'required|string|max:20',
            'jam_masuk'  => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i|after:jam_masuk',
        ], [
            'hari_kerja.required' => 'Hari kerja wajib diisi.',
            'jam_masuk.required'  => 'Jam masuk wajib diisi.',
            'jam_masuk.date_format' => 'Format jam masuk harus 24 jam (contoh: 08:00).',
            'jam_keluar.required' => 'Jam keluar wajib diisi.',
            'jam_keluar.date_format' => 'Format jam keluar harus 24 jam (contoh: 17:00).',
            'jam_keluar.after' => 'Jam keluar harus lebih besar dari jam masuk.',
        ]);

        if (JadwalKerja::where('hari_kerja', $request->hari_kerja)
            ->where('id_jadwal', '!=', $jadwal->id_jadwal)
            ->exists()) {
            return back()->withInput()->with('error', 'Hari kerja tersebut sudah digunakan.');
        }

        $jadwal->update([
            'hari_kerja' => $request->hari_kerja,
            'jam_masuk'  => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Data jadwal kerja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalKerja::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Data jadwal kerja berhasil dihapus.');
    }
}