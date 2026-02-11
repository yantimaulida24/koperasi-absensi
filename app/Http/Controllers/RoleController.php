<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function pilih($menu)
    {
        $userRole = Auth::user()->role;

        // ADMIN
        if ($menu === 'database' && $userRole === 'admin') {
            session(['role' => 'admin']);
            return redirect()->route('database.dashboard');
        }

        // KARYAWAN
        if ($menu === 'absensi' && $userRole === 'karyawan') {
            session(['role' => 'karyawan']);
            return redirect()->route('absensi.dashboard');
        }

        // JIKA TIDAK SESUAI
        return redirect()->route('pilih.menu')
            ->with('error', 'Anda tidak memiliki akses ke menu ini');
    }
}
