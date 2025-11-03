<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal_mulai = $request->get('tanggal_mulai', date('Y-m-01'));
        $tanggal_selesai = $request->get('tanggal_selesai', date('Y-m-t'));

        $absensi = Absensi::with('karyawan')
            ->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai])
            ->get();

        return view('laporan.index', compact('absensi', 'tanggal_mulai', 'tanggal_selesai'));
    }

    public function cetak(Request $request)
    {
        $tanggal_mulai = $request->get('tanggal_mulai', date('Y-m-01'));
        $tanggal_selesai = $request->get('tanggal_selesai', date('Y-m-t'));

        $absensi = Absensi::with('karyawan')
            ->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai])
            ->get();

        $pdf = Pdf::loadView('laporan.cetak', compact('absensi', 'tanggal_mulai', 'tanggal_selesai'));
        return $pdf->stream('Laporan_Absensi.pdf');
    }
}
