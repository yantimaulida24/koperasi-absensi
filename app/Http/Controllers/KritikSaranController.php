<?php

namespace App\Http\Controllers;

use App\Models\KritikSaran;
use Illuminate\Http\Request;

class KritikSaranController extends Controller
{
    /**
     * Menampilkan semua kritik & saran.
     */
    public function index()
    {
        // Ambil semua data dari tabel kritik_sarans
        $data = KritikSaran::latest()->get();

        return view('kritik_saran.index', compact('data'));
    }

    /**
     * Menampilkan form tambah kritik/saran.
     */
    public function create()
    {
        return view('kritik_saran.create');
    }

    /**
     * Simpan data kritik/saran baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'isi' => 'required|string|max:500',
        ], [
            'isi.required' => 'Kolom kritik atau saran tidak boleh kosong.',
        ]);

        // Simpan ke database
        KritikSaran::create([
            // user_id tidak wajib, bisa kosong
            'user_id' => 0, // isi angka 0 supaya tidak null dan tidak error
            'isi' => $request->isi,
        ]);

        return redirect()->route('kritik_saran.index')
            ->with('success', 'Kritik atau saran berhasil dikirim.');
    }

    /**
     * Tambahkan komentar admin.
     */
    public function komentar(Request $request, $id)
    {
        $request->validate([
            'komentar_admin' => 'required|string|max:500',
        ], [
            'komentar_admin.required' => 'Kolom komentar admin wajib diisi.',
        ]);

        $kritik = KritikSaran::findOrFail($id);
        $kritik->update([
            'komentar_admin' => $request->komentar_admin,
        ]);

        return redirect()->route('kritik_saran.index')
            ->with('success', 'Komentar admin berhasil ditambahkan.');
    }

    /**
     * Hapus kritik/saran.
     */
    public function destroy($id)
    {
        $kritik = KritikSaran::findOrFail($id);
        $kritik->delete();

        return redirect()->route('kritik_saran.index')
            ->with('success', 'Kritik atau saran berhasil dihapus.');
    }
}