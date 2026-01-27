@extends('layouts.app')

@section('content')
<div class="container">

    {{-- ================= SEARCH KARYAWAN ================= --}}
    <form method="GET" action="{{ route('data-karyawan.index') }}" class="mb-3 d-flex">
        <input 
            type="text" 
            name="search" 
            class="form-control me-2"
            placeholder="Cari nama karyawan..."
            value="{{ request('search') }}"
        >
        <button class="btn btn-success">Cari</button>
        @if(request('search'))
            <a href="{{ route('data-karyawan.index') }}" class="btn btn-secondary ms-2">Reset</a>
        @endif
    </form>
    {{-- =================================================== --}}

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('data-karyawan.create') }}" class="btn btn-jabatan mb-3">+ Tambah Karyawan</a>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr class="text-center">
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th>No Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
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
                    <a href="{{ route('data-karyawan.show', $data->id_karyawan) }}" class="btn btn-info btn-sm">Lihat</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('data-karyawan.edit', $data->id_karyawan) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('data-karyawan.destroy', $data->id_karyawan) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
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

<style>
.btn-jabatan {
    background-color: #1b5e20; color: #fff; font-weight: 500;
    border-radius: 6px; padding: 8px 18px; border: none;
}
.btn-jabatan:hover { background-color: #154a19; }
</style>
@endsection