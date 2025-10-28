<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsKaryawan
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'karyawan') {
            return $next($request);
        }

        return redirect('/home')->with('error', 'Tidak memiliki akses');
    }
}
