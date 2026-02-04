<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return view('akun.create');
    }

    /**
     * Simpan akun baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,karyawan',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            // otomatis di-hash karena cast "hashed"
            'password' => $request->password,
            'role'     => $request->role,
        ]);

        return redirect()->route('akun.index')
            ->with('success', 'Akun berhasil ditambahkan');
    }

    /**
     * Form edit akun
     */
    public function edit(User $akun)
    {
        return view('akun.edit', compact('akun'));
    }

    /**
     * Update akun
     */
    public function update(Request $request, User $akun)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $akun->id,
            'role'  => 'required|in:admin,karyawan',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
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
