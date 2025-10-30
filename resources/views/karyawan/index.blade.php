@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4">Data Karyawan</h3>

    <a href="{{ route('karyawan.create') }}" class="btn btn-primary mb-3">+ Tambah Karyawan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
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
            @foreach($karyawan as $index => $data)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $data->nama_karyawan }}</td>
                <td>{{ $data->jabatan->nama_jabatan ?? '-' }}</td>
                <td>{{ $data->no_telepon }}</td>
                <td>{{ $data->alamat }}</td>
                <td class="text-center">
                    <!-- 🔹 Tombol Lihat Detail -->
                    <a href="{{ route('karyawan.show', $data->id_karyawan) }}" class="btn btn-info btn-sm">
                        Lihat
                    </a>

                    <!-- 🔹 Tombol Edit -->
                    <a href="{{ route('karyawan.edit', $data->id_karyawan) }}" class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <!-- 🔹 Tombol Hapus -->
                    <form action="{{ route('karyawan.destroy', $data->id_karyawan) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
