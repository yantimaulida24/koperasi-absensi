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
        $hariIni = Carbon::today()->toDateString();

        // =========================
        // ROLE CHECK
        // =========================
        $isAdmin = Auth::user()->role === 'admin';
        $idKaryawan = Auth::user()->id_karyawan;

        // =========================
        // TOTAL DATA (ADMIN ONLY)
        // =========================
        if ($isAdmin) {
            $totalPengguna = User::count();
            $totalKaryawan = Karyawan::count();
        } else {
            $totalPengguna = null;
            $totalKaryawan = null;
        }

        // =========================
        // TOTAL HADIR
        // =========================
        if ($isAdmin) {
            $totalHadir = Absensi::where('tanggal', $hariIni)->count();
        } else {
            $totalHadir = Absensi::where('tanggal', $hariIni)
                ->where('id_karyawan', $idKaryawan)
                ->count();
        }

        // =========================
        // TOTAL CUTI
        // =========================
        if ($isAdmin) {
            $totalPermohonan = PermohonanCuti::whereDate('tanggal_mulai', '<=', $hariIni)
                ->whereDate('tanggal_selesai', '>=', $hariIni)
                ->count();
        } else {
            $totalPermohonan = PermohonanCuti::where('id_karyawan', $idKaryawan)
                ->whereDate('tanggal_mulai', '<=', $hariIni)
                ->whereDate('tanggal_selesai', '>=', $hariIni)
                ->count();
        }

        // =========================
        // GRAFIK MINGGUAN
        // =========================
        $labelMinggu = [];
        $dataHadir = [];
        $dataPermohonan = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i)->toDateString();

            if ($isAdmin) {
                $hadirHarian = Absensi::where('tanggal', $tanggal)->count();

                $permohonanHarian = PermohonanCuti::whereDate('tanggal_mulai', '<=', $tanggal)
                    ->whereDate('tanggal_selesai', '>=', $tanggal)
                    ->count();
            } else {
                $hadirHarian = Absensi::where('tanggal', $tanggal)
                    ->where('id_karyawan', $idKaryawan)
                    ->count();

                $permohonanHarian = PermohonanCuti::where('id_karyawan', $idKaryawan)
                    ->whereDate('tanggal_mulai', '<=', $tanggal)
                    ->whereDate('tanggal_selesai', '>=', $tanggal)
                    ->count();
            }

            $labelMinggu[]    = Carbon::parse($tanggal)->format('d M');
            $dataHadir[]      = $hadirHarian;
            $dataPermohonan[] = $permohonanHarian;
        }

        // =========================
        // ABSENSI TERBARU
        // =========================
        if ($isAdmin) {
            $absensiTerbaru = Absensi::with('karyawan')
                ->orderBy('tanggal', 'desc')
                ->orderBy('waktu_masuk', 'desc')
                ->limit(5)
                ->get();
        } else {
            $absensiTerbaru = Absensi::with('karyawan')
                ->where('id_karyawan', $idKaryawan)
                ->orderBy('tanggal', 'desc')
                ->orderBy('waktu_masuk', 'desc')
                ->limit(5)
                ->get();
        }

        // =========================
        // PERMOHONAN CUTI TERBARU
        // =========================
        if ($isAdmin) {
            $permohonanCuti = PermohonanCuti::latest()->limit(5)->get();
        } else {
            $permohonanCuti = PermohonanCuti::where('id_karyawan', $idKaryawan)
                ->latest()
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