<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #f2f2f2; }
        img { width: 60px; }
    </style>
</head>
<body>

<h3 style="text-align:center;">Laporan Absensi</h3>
<p>Periode: {{ $tanggal_mulai }} s/d {{ $tanggal_selesai }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Tanggal</th>
            <th>Waktu Masuk</th>
            <th>Waktu Keluar</th>
            <th>Total Jam Kerja</th>
            <th>Status</th>
            <th>Foto</th> {{-- TAMBAHAN --}}
        </tr>
    </thead>
    <tbody>
        @php
            $totalJamDecimal = 0;
        @endphp

        @foreach($absensi as $a)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $a->karyawan->nama_karyawan ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</td>
            <td>{{ $a->waktu_masuk ?? '-' }}</td>
            <td>{{ $a->waktu_keluar ?? '-' }}</td>

            {{-- TOTAL JAM --}}
            <td>
                @if($a->total_jam_kerja !== null && $a->waktu_keluar)
                    @php
                        $jam = floor($a->total_jam_kerja);
                        $menit = round(($a->total_jam_kerja - $jam) * 60);
                        $totalJamDecimal += $a->total_jam_kerja;
                    @endphp
                    {{ $jam }} jam {{ $menit }} menit
                @else
                    -
                @endif
            </td>

            <td>{{ $a->status }}</td>

            {{-- FOTO SELFIE --}}
            <td>
                @if($a->foto_absen)
                    <img src="data:image/png;base64,{{ $a->foto_absen }}">
                @else
                    -
                @endif
            </td>

        </tr>
        @endforeach
    </tbody>

    {{-- TOTAL JAM --}}
    <tfoot>
        @php
            $totalJam = floor($totalJamDecimal);
            $totalMenit = round(($totalJamDecimal - $totalJam) * 60);
        @endphp
        <tr>
            <th colspan="6" style="text-align:right;">Total Jam Kerja</th>
            <th colspan="2">
                {{ $totalJam }} jam {{ $totalMenit }} menit
            </th>
        </tr>
    </tfoot>
</table>

</body>
</html>