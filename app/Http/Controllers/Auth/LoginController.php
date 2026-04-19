<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect setelah login sesuai role
     */
    protected function authenticated(Request $request, $user)
    {
        // ADMIN → ke dashboard
        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }

        // KARYAWAN → ke halaman absensi
        if ($user->role === 'karyawan') {
            return redirect()->route('absensi.index');
        }

        // Default
        return redirect('/');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}