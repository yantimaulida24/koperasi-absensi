<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>QR Code Karyawan</title>
</head>
<body>

<h3>QR Code untuk {{ $karyawan->nama_karyawan }}</h3>

<img
    src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ $karyawan->kode_qr }}"
    alt="QR Absensi"
>

<p><strong>Isi QR:</strong> {{ $karyawan->kode_qr }}</p>

<a href="{{ route('absensi.index') }}">Kembali</a>

</body>
</html>
