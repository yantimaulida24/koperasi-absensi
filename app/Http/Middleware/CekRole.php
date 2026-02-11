<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Sistem belum dipilih
        if (!session()->has('role')) {
            return redirect()->route('pilih.sistem');
        }

        // Cek akses
        if (in_array(session('role'), $roles)) {
            return $next($request);
        }

        // Redirect aman
        return redirect()->route('pilih.sistem')
            ->with('error', 'Anda tidak memiliki akses ke sistem ini.');
    }
}