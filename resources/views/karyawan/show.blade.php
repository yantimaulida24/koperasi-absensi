@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-bold">Detail Karyawan</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <p><strong>Nama Karyawan:</strong> {{ $karyawan->nama_karyawan ?? '-' }}</p>
            <p><strong>Jabatan:</strong> {{ $karyawan->jabatan->nama_jabatan ?? '-' }}</p>
            <p><strong>No Telepon:</strong> {{ $karyawan->no_telepon ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ $karyawan->alamat ?? '-' }}</p>

            <hr>

            <h5 class="fw-bold">QR Code</h5>

            @if(!empty($qrCode))
                <div class="mb-3">
                    {!! $qrCode !!}
                </div>

                {{-- TOMBOL DOWNLOAD QR --}}
                <a href="{{ route('data-karyawan.downloadQr', $karyawan) }}"
                   class="btn btn-success">
                    Download QR Code
                </a>
            @else
                <p class="text-muted">Tidak ada QR Code untuk karyawan ini.</p>
            @endif

        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('data-karyawan.index') }}" class="btn btn-secondary">
            Kembali ke Daftar Karyawan
        </a>
    </div>
</div>
@endsection
