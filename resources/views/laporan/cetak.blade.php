<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
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
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $a)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $a->karyawan->nama_karyawan ?? '-' }}</td>
                <td>{{ $a->tanggal }}</td>
                <td>{{ $a->waktu_masuk }}</td>
                <td>{{ $a->waktu_keluar }}</td>
                <td>{{ $a->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
