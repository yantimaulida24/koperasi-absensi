<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Setelah login JANGAN ke /home
     */
    protected function redirectTo()
    {
        return route('pilih.sistem');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Dipanggil OTOMATIS setelah login sukses
     */
    protected function authenticated(Request $request, $user)
    {
        // Reset sistem setiap login
        session()->forget('role');
    }

    /**
     * Logout + hapus session role
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}