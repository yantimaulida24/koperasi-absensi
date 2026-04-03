<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<h3 style="text-align:center;">Laporan Rekap Absensi Karyawan</h3>
<p>Periode: {{ $tanggal_mulai }} s/d {{ $tanggal_selesai }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Hadir</th>
            <th>Tidak Hadir</th>
            <th>Total Jam Kerja</th> {{-- ✅ DIHAPUS TOTAL HARI --}}
        </tr>
    </thead>

    <tbody>
        @php
            $totalHadir = 0;
            $totalTidakHadir = 0;
            $grandTotalJam = 0;
        @endphp

        @foreach($data as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d['nama'] }}</td>
            <td>{{ $d['hadir'] }}</td>
            <td>{{ $d['tidak_hadir'] }}</td>

            <td>
                @php
                    $jam = floor($d['total_jam_kerja']);
                    $menit = round(($d['total_jam_kerja'] - $jam) * 60);
                @endphp
                {{ $jam }} jam {{ $menit }} menit
            </td>
        </tr>

        @php
            $totalHadir += $d['hadir'];
            $totalTidakHadir += $d['tidak_hadir'];
            $grandTotalJam += $d['total_jam_kerja'];
        @endphp

        @endforeach
    </tbody>

    <tfoot>
        @php
            $jam = floor($grandTotalJam);
            $menit = round(($grandTotalJam - $jam) * 60);
        @endphp
        <tr>
            <th colspan="2">TOTAL</th>
            <th>{{ $totalHadir }}</th>
            <th>{{ $totalTidakHadir }}</th>
            <th>{{ $jam }} jam {{ $menit }} menit</th>
        </tr>
    </tfoot>
</table>

</body>
</html>