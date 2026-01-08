@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3 class="fw-bold">Daftar Absensi</h3>

    <a href="{{ route('absen.scan') }}" class="btn btn-primary">
        + Tambah Absensi
    </a>
</div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Waktu Masuk</th>
                <th>Waktu Keluar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensi as $item)
                <tr>
                    <td>{{ $item->karyawan->nama_karyawan ?? '-' }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>{{ $item->waktu_masuk ?? '-' }}</td>
                    <td>{{ $item->waktu_keluar ?? '-' }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data absensi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
