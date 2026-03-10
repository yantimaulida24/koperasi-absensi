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
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Total Jam Kerja</th>
                    <th>Status</th>
                    <th>Foto Selfie</th> {{-- TAMBAHAN --}}
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->karyawan->nama_karyawan ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $a->waktu_masuk ?? '-' }}</td>
                    <td>{{ $a->waktu_keluar ?? '-' }}</td>

                    {{-- TOTAL JAM KERJA --}}
                    <td>
                        @if($a->total_jam_kerja !== null && $a->waktu_keluar)
                            @php
                                $jam = floor($a->total_jam_kerja);
                                $menit = round(($a->total_jam_kerja - $jam) * 60);
                            @endphp
                            {{ $jam }} jam {{ $menit }} menit
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $a->status }}</td>

                    {{-- FOTO SELFIE --}}
                    <td>
                        @if($a->foto_absen)
                            <img 
                                src="data:image/png;base64,{{ $a->foto_absen }}" 
                                width="70"
                                style="border-radius:8px;">
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection