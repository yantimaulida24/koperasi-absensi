@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-bold">Data Jabatan</h3>

    <!-- Flash Success Message -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Flash Error Message -->
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Button Tambah Jabatan -->
    <a href="{{ route('jabatan.create') }}" class="btn btn-primary mb-3">+ Tambah Jabatan</a>

    <!-- Tabel Data Jabatan -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Jabatan</th>
                <th width="20%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jabatans as $index => $jabatan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $jabatan->nama_jabatan }}</td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="{{ route('jabatan.edit', $jabatan->id_jabatan) }}" class="btn btn-warning btn-sm">Edit</a>
                        <!-- Form Hapus -->
                        <form action="{{ route('jabatan.destroy', $jabatan->id_jabatan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jabatan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <!-- Jika tidak ada data jabatan -->
                <tr>
                    <td colspan="3" class="text-center">Belum ada data jabatan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Menampilkan Pesan jika tidak ada data jabatan -->
    @if ($jabatans->count() == 0)
        <div class="alert alert-warning">
            Tidak ada jabatan yang tersedia.
        </div>
    @endif
</div>
@endsection