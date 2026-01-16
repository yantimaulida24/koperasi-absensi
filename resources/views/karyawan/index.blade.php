@extends('layouts.app')

@section('content')
<div class="container">

    {{-- TOMBOL TAMBAH KARYAWAN (HANYA ADMIN) --}}
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('karyawan.create') }}" class="btn btn-jabatan mb-3">
            + Tambah Karyawan
        </a>
    @endif

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr class="text-center">
                <th width="5%">No</th>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th>No Telepon</th>
                <th>Alamat</th>
                <th width="20%">Aksi</th>
            </tr>
        </thead>
        <tbody>

        @forelse($karyawan as $index => $data)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $data->nama_karyawan }}</td>
                <td>{{ $data->jabatan->nama_jabatan ?? '-' }}</td>
                <td>{{ $data->no_telepon ?? '-' }}</td>
                <td>{{ $data->alamat ?? '-' }}</td>

                <td class="text-center">

                    {{-- LIHAT (ADMIN & KARYAWAN) --}}
                    <a href="{{ route('karyawan.show', $data->id_karyawan) }}"
                       class="btn btn-info btn-sm">
                        Lihat
                    </a>

                    {{-- EDIT & HAPUS (ADMIN SAJA) --}}
                    @if(auth()->user()->role === 'admin')

                        <a href="{{ route('karyawan.edit', $data->id_karyawan) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('karyawan.destroy', $data->id_karyawan) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus data ini?')">
                                Hapus
                            </button>
                        </form>

                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">
                    Tidak ada data karyawan
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>
</div>

{{-- STYLE TOMBOL HIJAU (KONSISTEN SEMUA HALAMAN) --}}
<style>
    .btn-jabatan {
        background-color: #1b5e20;
        color: #ffffff;
        font-weight: 500;
        border-radius: 6px;
        padding: 8px 18px;
        border: none;
    }

    .btn-jabatan:hover {
        background-color: #154a19;
        color: #ffffff;
    }
</style>
@endsection
