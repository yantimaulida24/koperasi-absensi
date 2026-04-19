@extends('layouts.app')

@section('content')
<div class="container">

    {{-- TOMBOL TAMBAH (KARYAWAN) --}}
    @if(auth()->user()->role === 'karyawan')
        <a href="{{ route('permohonan-cuti.create') }}"
           class="btn btn-primary mb-3"
           title="Tambah Permohonan">
            <i class="fas fa-plus"></i> Tambah Permohonan
        </a>
    @endif

    <table class="table custom-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Pengajuan</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Status</th>
                <th>Alasan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cuti as $c)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $c->karyawan->nama_karyawan }}</td>

                {{-- FORMAT TANGGAL --}}
                <td>{{ \Carbon\Carbon::parse($c->tanggal_pengajuan)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($c->tanggal_mulai)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($c->tanggal_selesai)->format('d-m-Y') }}</td>

                {{-- STATUS --}}
                <td>
                    @if($c->status_cuti == 'disetujui')
                        <span class="badge bg-success">Disetujui</span>
                    @elseif($c->status_cuti == 'ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @else
                        <span class="badge bg-warning text-dark">Belum</span>
                    @endif
                </td>

                <td>{{ $c->alasan_cuti }}</td>

                {{-- AKSI --}}
                <td>

                    {{-- EDIT (ADMIN) --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('permohonan-cuti.edit', $c->id_cuti) }}"
                           class="btn btn-warning btn-sm"
                           title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    @endif

                    {{-- HAPUS --}}
                    <form action="{{ route('permohonan-cuti.destroy', $c->id_cuti) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus data cuti ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted">
                    Belum ada data permohonan cuti
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection