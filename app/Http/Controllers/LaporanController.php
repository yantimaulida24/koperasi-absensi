<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal_mulai = $request->get('tanggal_mulai', date('Y-m-01'));
        $tanggal_selesai = $request->get('tanggal_selesai', date('Y-m-t'));

        $hariLibur = [
            '2026-01-01',
            '2026-08-17',
            '2026-12-25',
        ];

        $karyawan = Karyawan::all();
        $data = [];

        $periode = Carbon::parse($tanggal_mulai)->daysUntil($tanggal_selesai);

        $totalHariKerja = 0;
        foreach ($periode as $tgl) {
            if ($tgl->dayOfWeek != Carbon::SUNDAY && !in_array($tgl->toDateString(), $hariLibur)) {
                $totalHariKerja++;
            }
        }

        foreach ($karyawan as $k) {

            // ambil semua absensi dalam range
            $absensi = Absensi::where('id_karyawan', $k->id_karyawan)
                ->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai])
                ->whereRaw('DAYOFWEEK(tanggal) != 1')
                ->whereNotIn('tanggal', $hariLibur)
                ->get();

            // 🔥 HADIR
            $hadir = $absensi->whereNotNull('waktu_masuk')->count();

            // 🔥 TOTAL JAM KERJA
            $totalJamKerja = $absensi->sum('total_jam_kerja');

            // 🔥 TIDAK HADIR
            $tidakHadir = $totalHariKerja - $hadir;

            // 🔥 AMBIL FOTO TERBARU
            $foto = $absensi->last()->foto_absen ?? null;

            $data[] = [
                'nama' => $k->nama_karyawan,
                'hadir' => $hadir,
                'tidak_hadir' => $tidakHadir,
                'total_jam_kerja' => $totalJamKerja,
                'foto' => $foto // ✅ TAMBAHAN
            ];
        }

        return view('laporan.index', compact('data', 'tanggal_mulai', 'tanggal_selesai'));
    }

    public function cetak(Request $request)
    {
        $tanggal_mulai = $request->get('tanggal_mulai', date('Y-m-01'));
        $tanggal_selesai = $request->get('tanggal_selesai', date('Y-m-t'));

        $hariLibur = [
            '2026-01-01',
            '2026-08-17',
            '2026-12-25',
        ];

        $karyawan = Karyawan::all();
        $data = [];

        $periode = Carbon::parse($tanggal_mulai)->daysUntil($tanggal_selesai);

        $totalHariKerja = 0;
        foreach ($periode as $tgl) {
            if ($tgl->dayOfWeek != Carbon::SUNDAY && !in_array($tgl->toDateString(), $hariLibur)) {
                $totalHariKerja++;
            }
        }

        foreach ($karyawan as $k) {

            $absensi = Absensi::where('id_karyawan', $k->id_karyawan)
                ->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai])
                ->whereRaw('DAYOFWEEK(tanggal) != 1')
                ->whereNotIn('tanggal', $hariLibur)
                ->get();

            $hadir = $absensi->whereNotNull('waktu_masuk')->count();
            $totalJamKerja = $absensi->sum('total_jam_kerja');
            $tidakHadir = $totalHariKerja - $hadir;

            // 🔥 FOTO JUGA UNTUK PDF
            $foto = $absensi->last()->foto_absen ?? null;

            $data[] = [
                'nama' => $k->nama_karyawan,
                'hadir' => $hadir,
                'tidak_hadir' => $tidakHadir,
                'total_jam_kerja' => $totalJamKerja,
                'foto' => $foto
            ];
        }

        $pdf = Pdf::loadView('laporan.cetak', compact('data', 'tanggal_mulai', 'tanggal_selesai'));
        return $pdf->stream('Laporan_Absensi.pdf');
    }
}