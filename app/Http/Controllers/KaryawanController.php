<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    // Menampilkan daftar karyawan
    public function index()
    {
        $karyawan = Karyawan::with(['jabatan'])->get();  // Mengambil data karyawan dengan relasi jabatan
        return view('karyawan.index', compact('karyawan'));
    }

    // Menampilkan form tambah karyawan
    public function create()
    {
        $jabatan = Jabatan::all();  // Ambil semua data jabatan
        return view('karyawan.create', compact('jabatan'));  // Kirim data jabatan ke tampilan
    }

    // Menyimpan data karyawan baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_jabatan' => 'required|exists:jabatans,id_jabatan',  // Pastikan id_jabatan valid
            'nama_karyawan' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        // Menyimpan data karyawan, id_user diisi dengan ID pengguna yang sedang login
        Karyawan::create([
            'id_user' => Auth::id(),  // Ambil ID pengguna yang sedang login
            'id_jabatan' => $request->id_jabatan,
            'nama_karyawan' => $request->nama_karyawan,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    // Menampilkan form edit karyawan
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $jabatan = Jabatan::all();  // Ambil data jabatan
        return view('karyawan.edit', compact('karyawan', 'jabatan'));
    }

    // Update data karyawan
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_jabatan' => 'required|exists:jabatans,id_jabatan',  // Pastikan id_jabatan valid
            'nama_karyawan' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update([
            'id_jabatan' => $request->id_jabatan,
            'nama_karyawan' => $request->nama_karyawan,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    // Hapus data karyawan
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus!');
    }
}