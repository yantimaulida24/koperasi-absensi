@extends('layouts.app')

@section('content')
<div class="container">

    {{-- FILTER TANGGAL --}}
    <form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
        <div class="row g-3 align-items-end">

            <div class="col-md-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggal_mulai }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" value="{{ $tanggal_selesai }}">
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

    {{-- TABLE REKAP --}}
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Hadir</th>
                    <th>Tidak Hadir</th>
                    <th>Foto Selfie</th> {{-- TAMBAHAN --}}
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['nama'] }}</td>

                    <td class="text-center">
                        {{ $item['hadir'] }}
                    </td>

                    <td class="text-center">
                        {{ $item['tidak_hadir'] }}
                    </td>

                    {{-- FOTO SELFIE --}}
                    <td class="text-center">
                        @if(!empty($item['foto']))
                            <img src="data:image/png;base64,{{ $item['foto'] }}"
                                 width="80"
                                 height="80"
                                 style="object-fit: cover; border-radius: 8px;">
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection