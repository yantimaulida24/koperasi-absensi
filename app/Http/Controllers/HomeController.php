<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Karyawan;
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

        // Total karyawan berdasarkan tabel karyawan
        $totalKaryawan = Karyawan::count();

        // Absensi hari ini
        $totalMasuk = Absensi::where('status', 'Masuk')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $totalTidakMasuk = Absensi::where('status', 'Tidak Masuk')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Grafik mingguan
        $labelMinggu = [];
        $dataMasuk = [];
        $dataTidakMasuk = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i)->format('Y-m-d');
            $labelMinggu[] = Carbon::now()->subDays($i)->format('d M');

            $dataMasuk[] = Absensi::where('status', 'Masuk')
                ->whereDate('created_at', $tanggal)
                ->count();

            $dataTidakMasuk[] = Absensi::where('status', 'Tidak Masuk')
                ->whereDate('created_at', $tanggal)
                ->count();
        }

        // Absensi terbaru (5 terakhir)
        $absensiTerbaru = Absensi::with('user')->latest()->take(5)->get();

        // Permohonan cuti terbaru
        if (Auth::user()->role == 'karyawan') {
            $permohonanCuti = PermohonanCuti::where('id_karyawan', Auth::id())
                                ->latest()
                                ->take(5)
                                ->get();
        } else {
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