<!DOCTYPE html>
<html>
<head>
    <title>QR Code Karyawan</title>
</head>
<body>
    <h3>QR Code untuk {{ $karyawan->nama }}</h3>
    {!! $qrCode !!}
    <p>Gunakan QR ini untuk absen.</p>
    <a href="{{ route('absensi.index') }}">Kembali</a>
</body>
</html>
