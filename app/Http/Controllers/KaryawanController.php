<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pengguna;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Tampilkan daftar karyawan.
     */
    public function index()
    {
        // Eager load relasi pengguna dan jabatan
        $karyawan = Karyawan::with(['pengguna', 'jabatan'])->get();
        return view('karyawan.index', compact('karyawan'));
    }

    /**
     * Tampilkan form tambah karyawan.
     */
    public function create()
    {
        $pengguna = Pengguna::where('role', 'karyawan')->get();
        $jabatan = Jabatan::all();
        return view('karyawan.create', compact('pengguna', 'jabatan'));
    }

    /**
     * Simpan data karyawan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|unique:karyawan,id_pengguna',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'nama_karyawan' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        Karyawan::create($request->all());

        return redirect()->route('karyawan.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Tampilkan form edit karyawan.
     */
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $pengguna = Pengguna::where('role', 'karyawan')->get();
        $jabatan = Jabatan::all();

        return view('karyawan.edit', compact('karyawan', 'pengguna', 'jabatan'));
    }

    /**
     * Update data karyawan.
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'id_pengguna' => 'required|exists:pengguna,id_pengguna|unique:karyawan,id_pengguna,' . $karyawan->id_karyawan . ',id_karyawan',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'nama_karyawan' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        $karyawan->update($request->only([
            'id_pengguna',
            'id_jabatan',
            'nama_karyawan',
            'no_telepon',
            'alamat'
        ]));

        return redirect()->route('karyawan.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Hapus data karyawan.
     */
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Data berhasil dihapus');
    }
}