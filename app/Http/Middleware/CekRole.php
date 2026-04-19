<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil role dari user login
        $userRole = Auth::user()->role;

        // Jika role sesuai dengan yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika tidak sesuai → redirect sesuai role
        if ($userRole === 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        if ($userRole === 'karyawan') {
            return redirect()->route('absensi.index')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        // Default fallback
        return redirect('/login');
    }
}