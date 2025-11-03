@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Laporan Absensi</h4>

    <form method="GET" action="{{ route('laporan.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <label>Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggal_mulai }}">
            </div>
            <div class="col-md-4">
                <label>Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" value="{{ $tanggal_selesai }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Tampilkan</button>
                <a href="{{ route('laporan.cetak', request()->all()) }}" class="btn btn-danger" target="_blank">Cetak PDF</a>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Waktu Masuk</th>
                <th>Waktu Keluar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensi as $a)
            <tr>
                <td>{{ $loop->iteration }}</td>
                {{-- sesuai relasi model: id_karyawan --}}
                <td>{{ $a->karyawan->nama_karyawan ?? '-' }}</td>
                <td>{{ $a->tanggal }}</td>
                <td>{{ $a->waktu_masuk ?? '-' }}</td>
                <td>{{ $a->waktu_keluar ?? '-' }}</td>
                <td>{{ $a->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Tidak ada data absensi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
