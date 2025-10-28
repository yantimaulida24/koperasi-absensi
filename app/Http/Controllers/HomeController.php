<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $totalPengguna = User::count();
        $totalKaryawan = User::where('role', 'karyawan')->count();

        $totalMasuk = Absensi::whereDate('created_at', now())
                                ->where('status', 'Masuk')
                                ->count();

        $totalTidakMasuk = Absensi::whereDate('created_at', now())
                                ->where('status', 'Tidak Masuk')
                                ->count();

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

        $absensiTerbaru = Absensi::latest()->take(7)->get();

        return view('home', compact(
            'totalPengguna',
            'totalKaryawan',
            'totalMasuk',
            'totalTidakMasuk',
            'labelMinggu',
            'dataMasuk',
            'dataTidakMasuk',
            'absensiTerbaru'
        ));
    }
}
