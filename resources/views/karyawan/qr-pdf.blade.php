<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Identitas Karyawan</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f2f2f2;
        }

        .wrapper {
            width: 100%;
            text-align: center;
            margin-top: 20mm;
        }

        .card {
            width: 90mm;
            height: 130mm;
            margin: auto;
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #ccc;
            padding: 10mm;
            box-sizing: border-box;
        }

        .title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 8mm;
            text-align: center;
        }

        .qr {
            margin-bottom: 10mm;
        }

        .qr svg {
            width: 40mm;
            height: 40mm;
        }

        table {
            width: 100%;
            font-size: 10px;
            border-collapse: collapse;
        }

        td {
            padding: 4px 0;
            vertical-align: top;
        }

        .label {
            width: 35%;
            font-weight: bold;
        }

        .separator {
            width: 5%;
        }

        .value {
            width: 60%;
        }

        .footer {
            margin-top: 12mm;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="card">

        <div class="title">
            IDENTITAS KARYAWAN
        </div>

        <div class="qr">
            {!! $qrSvg !!}
        </div>

        <table>
            <tr>
                <td class="label">Nama</td>
                <td class="separator">:</td>
                <td class="value">{{ $karyawan->nama_karyawan }}</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="separator">:</td>
                <td class="value">
                    {{ $karyawan->jabatan->nama_jabatan ?? '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Tempat, Tgl Lahir</td>
                <td class="separator">:</td>
                <td class="value">
                    {{ $karyawan->tempat_lahir ?? '-' }},
                    {{ $karyawan->tanggal_lahir 
                        ? \Carbon\Carbon::parse($karyawan->tanggal_lahir)->format('d-m-Y') 
                        : '-' 
                    }}
                </td>
            </tr>
            <tr>
                <td class="label">No. Telepon</td>
                <td class="separator">:</td>
                <td class="value">{{ $karyawan->no_telepon ?? '-' }}</td>
            </tr>
        </table>

        <div class="footer">
            KOPERASI AGROSINDO SENTOSA
        </div>

    </div>
</div>

</body>
</html>