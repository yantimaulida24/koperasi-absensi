<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pengguna;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with(['pengguna', 'jabatan'])->get();
        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        $pengguna = Pengguna::where('role', 'karyawan')->get();
        $jabatan = Jabatan::all();
        return view('karyawan.create', compact('pengguna', 'jabatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|unique:karyawan',
            'id_jabatan' => 'required',
            'nama_karyawan' => 'required',
            'no_telepon' => 'nullable',
            'alamat' => 'nullable'
        ]);

        Karyawan::create($request->all());
        return redirect()->route('karyawan.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $pengguna = Pengguna::where('role', 'karyawan')->get();
        $jabatan = Jabatan::all();
        return view('karyawan.edit', compact('karyawan', 'pengguna', 'jabatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pengguna' => 'required|exists:pengguna,id_pengguna',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'nama_karyawan' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        $karyawan = Karyawan::findOrFail($id);

        if ($karyawan->id_pengguna != $request->id_pengguna) {
            $request->validate([
                'id_pengguna' => 'unique:karyawan',
            ]);
        }

        $karyawan->update([
            'id_pengguna' => $request->id_pengguna,
            'id_jabatan' => $request->id_jabatan,
            'nama_karyawan' => $request->nama_karyawan,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Karyawan::destroy($id);
        return redirect()->route('karyawan.index')->with('success', 'Data berhasil dihapus');
    }
}
