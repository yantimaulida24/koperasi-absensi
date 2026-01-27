@extends('layouts.app')

@section('content')
<div class="container">

    {{-- FILTER TANGGAL --}}
    <form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
        <div class="row g-3 align-items-end">

            <div class="col-md-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date"
                       name="tanggal_mulai"
                       class="form-control"
                       value="{{ $tanggal_mulai }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date"
                       name="tanggal_selesai"
                       class="form-control"
                       value="{{ $tanggal_selesai }}">
            </div>

            <div class="col-md-6 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Tampilkan
                </button>

                <a href="{{ route('laporan.cetak', request()->all()) }}"
                   target="_blank"
                   class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </a>
            </div>

        </div>
    </form>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->karyawan->nama_karyawan ?? '-' }}</td>
                    <td>{{ $a->tanggal }}</td>
                    <td>{{ $a->waktu_masuk ?? '-' }}</td>
                    <td>{{ $a->waktu_keluar ?? '-' }}</td>
                    <td>{{ $a->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection