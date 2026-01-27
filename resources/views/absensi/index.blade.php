@extends('layouts.app')

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table custom-table">
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
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->waktu_masuk ?? '-' }}</td>
                    <td>{{ $item->waktu_keluar ?? '-' }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Belum ada data absensi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection