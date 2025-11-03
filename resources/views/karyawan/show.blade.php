@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Karyawan</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Nama Karyawan:</strong> {{ $karyawan->nama_karyawan ?? '-' }}</p>
            <p><strong>Jabatan:</strong> {{ $karyawan->jabatan->nama_jabatan ?? '-' }}</p>
            <p><strong>No Telepon:</strong> {{ $karyawan->no_telepon ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ $karyawan->alamat ?? '-' }}</p>

            <h4>QR Code</h4>
            @if(!empty($qrCode))
                {!! $qrCode !!}
            @else
                <p>Tidak ada QR Code untuk karyawan ini.</p>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('karyawan.index') }}" class="btn btn-primary">Kembali ke Daftar Karyawan</a>
    </div>
</div>
@endsection
