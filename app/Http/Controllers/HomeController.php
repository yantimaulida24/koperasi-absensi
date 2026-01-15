<?php

namespace App\Http\Controllers;

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
        // =========================
        // TANGGAL HARI INI
        // =========================
        $hariIni = Carbon::today()->toDateString();

        // =========================
        // TOTAL DATA
        // =========================
        $totalPengguna = User::count();
        $totalKaryawan = Karyawan::count();

        // =========================
        // TOTAL HADIR HARI INI
        // =========================
        $totalHadir = Absensi::where('tanggal', $hariIni)
            ->count();

        // =========================
        // TOTAL PERMOHONAN CUTI HARI INI
        // =========================
        $totalPermohonan = PermohonanCuti::whereDate(
            'tanggal_mulai',
            '<=',
            $hariIni
        )->whereDate(
            'tanggal_selesai',
            '>=',
            $hariIni
        )->count();

        // =========================
        // GRAFIK MINGGUAN
        // =========================
        $labelMinggu = [];
        $dataHadir = [];
        $dataPermohonan = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i)->toDateString();

            $hadirHarian = Absensi::where('tanggal', $tanggal)
                ->count();

            $permohonanHarian = PermohonanCuti::whereDate(
                'tanggal_mulai',
                '<=',
                $tanggal
            )->whereDate(
                'tanggal_selesai',
                '>=',
                $tanggal
            )->count();

            $labelMinggu[]        = Carbon::parse($tanggal)->format('d M');
            $dataHadir[]          = $hadirHarian;
            $dataPermohonan[]     = $permohonanHarian;
        }

        // =========================
        // ABSENSI TERBARU
        // =========================
        $absensiTerbaru = Absensi::with('karyawan')
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_masuk', 'desc')
            ->limit(5)
            ->get();

        // =========================
        // PERMOHONAN CUTI TERBARU
        // =========================
        if (Auth::user()->role === 'karyawan') {
            $permohonanCuti = PermohonanCuti::where(
                    'id_karyawan',
                    Auth::user()->id_karyawan
                )
                ->latest()
                ->limit(5)
                ->get();
        } else {
            $permohonanCuti = PermohonanCuti::latest()
                ->limit(5)
                ->get();
        }

        // =========================
        // VIEW
        // =========================
        return view('home', compact(
            'totalPengguna',
            'totalKaryawan',
            'totalHadir',
            'totalPermohonan',
            'labelMinggu',
            'dataHadir',
            'dataPermohonan',
            'absensiTerbaru',
            'permohonanCuti'
        ));
    }
}