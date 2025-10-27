<!DOCTYPE html>
<html>
<head>
    <title>Daftar Karyawan & QR</title>
</head>
<body>
    <h2>Daftar Karyawan</h2>

    <form action="{{ route('karyawan.store') }}" method="POST">
        @csrf
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="jabatan" placeholder="Jabatan">
        <button type="submit">Tambah Karyawan</button>
    </form>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Jabatan</th>
            <th>QR Code</th>
        </tr>
        @foreach ($karyawans as $data)
    <tr>
        <td>{{ $data->nama }}</td>
        <td>{{ $data->email }}</td>
        <td>{{ $data->jabatan }}</td>
        <td>
            {!! QrCode::size(150)->generate('http://192.168.1.10:8000/absensi/scan/' . $data->id) !!}
        </td>
    </tr>
@endforeach

    </table>
</body>
</html>
