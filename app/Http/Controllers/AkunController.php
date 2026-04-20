<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan; // ✅ TAMBAHAN
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    /**
     * Tampilkan daftar akun
     */
    public function index()
    {
        $akun = User::all();
        return view('akun.index', compact('akun'));
    }

    /**
     * Form tambah akun
     */
    public function create()
    {
        $karyawan = Karyawan::all(); // ✅ TAMBAHAN
        return view('akun.create', compact('karyawan'));
    }

    /**
     * Simpan akun baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users',
            'password'     => 'required|min:6',
            'role'         => 'required|in:admin,karyawan',
            'id_karyawan'  => 'nullable|exists:karyawans,id_karyawan', // ✅ TAMBAHAN
        ]);

        User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => $request->password,
            'role'         => $request->role,
            'id_karyawan'  => $request->id_karyawan, // 🔥 PENTING
        ]);

        return redirect()->route('akun.index')
            ->with('success', 'Akun berhasil ditambahkan');
    }

    /**
     * Form edit akun
     */
    public function edit(User $akun)
    {
        $karyawan = Karyawan::all(); // ✅ TAMBAHAN
        return view('akun.edit', compact('akun', 'karyawan'));
    }

    /**
     * Update akun
     */
    public function update(Request $request, User $akun)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $akun->id,
            'role'         => 'required|in:admin,karyawan',
            'id_karyawan'  => 'nullable|exists:karyawans,id_karyawan', // ✅ TAMBAHAN
        ]);

        $data = [
            'name'         => $request->name,
            'email'        => $request->email,
            'role'         => $request->role,
            'id_karyawan'  => $request->id_karyawan, // 🔥 TAMBAHAN
        ];

        // jika password diisi
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $akun->update($data);

        return redirect()->route('akun.index')
            ->with('success', 'Akun berhasil diperbarui');
    }

    /**
     * Hapus akun
     */
    public function destroy(User $akun)
    {
        // ❌ admin tidak boleh hapus akun sendiri
        if (Auth::id() === $akun->id) {
            return redirect()->route('akun.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $akun->delete();

        return redirect()->route('akun.index')
            ->with('success', 'Akun berhasil dihapus');
    }
}