<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\PermohonanCuti;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Total pengguna
        $totalPengguna = User::count();
        $totalKaryawan = User::where('role', 'karyawan')->count();

        // Data absensi hari ini
        $totalMasuk = Absensi::whereDate('created_at', now())
                                ->where('status', 'Masuk')
                                ->count();

        $totalTidakMasuk = Absensi::whereDate('created_at', now())
                                ->where('status', 'Tidak Masuk')
                                ->count();

        // Data grafik mingguan
        $labelMinggu = [];
        $dataMasuk = [];
        $dataTidakMasuk = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i)->format('Y-m-d');
            $labelMinggu[] = Carbon::now()->subDays($i)->format('d M');

            $dataMasuk[] = Absensi::whereDate('created_at', $tanggal)
                ->where('status', 'Masuk')
                ->count();

            $dataTidakMasuk[] = Absensi::whereDate('created_at', $tanggal)
                ->where('status', 'Tidak Masuk')
                ->count();
        }

        // Absensi terbaru
        $absensiTerbaru = Absensi::latest()->take(7)->get();

        // Permohonan cuti terbaru
        if (Auth::user()->role == 'karyawan') {
            $permohonanCuti = PermohonanCuti::where('id_karyawan', Auth::id())
                                ->latest()
                                ->take(5)
                                ->get();
        } else {
            // Admin bisa lihat semua
            $permohonanCuti = PermohonanCuti::latest()->take(5)->get();
        }

        return view('home', compact(
            'totalPengguna',
            'totalKaryawan',
            'totalMasuk',
            'totalTidakMasuk',
            'labelMinggu',
            'dataMasuk',
            'dataTidakMasuk',
            'absensiTerbaru',
            'permohonanCuti'
        ));
    }
}