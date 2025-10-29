<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:100',
        ]);

        Jabatan::create($request->only('nama_jabatan'));

        return redirect()->route('jabatan.index')
                         ->with('success', 'Data jabatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:100',
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($request->only('nama_jabatan'));

        return redirect()->route('jabatan.index')
                         ->with('success', 'Data jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatan.index')
                         ->with('success', 'Data jabatan berhasil dihapus.');
    }
}