<!DOCTYPE html>
<html>
<head>
    <title>QR Code Karyawan</title>
</head>
<body>

    <h3>QR Code untuk {{ $karyawan->nama_karyawan }}</h3>

    <img
        src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ $karyawan->kode_qr }}"
        alt="QR Absensi"
    >

    <p>Gunakan QR ini untuk absen.</p>

    <a href="{{ route('absensi.index') }}">Kembali</a>

</body>
</html>
