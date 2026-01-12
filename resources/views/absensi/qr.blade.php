<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>QR Code Karyawan</title>
</head>
<body>

    <h3>QR Code untuk {{ $karyawan->nama_karyawan }}</h3>

    <img
        src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode('KRY-' . $karyawan->id_karyawan) }}"
        alt="QR Absensi"
    >

    <p><strong>Isi QR:</strong> KRY-{{ $karyawan->id_karyawan }}</p>

    <a href="{{ route('absensi.index') }}">Kembali</a>

</body>
</html>
