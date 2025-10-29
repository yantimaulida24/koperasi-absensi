@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-bold">Data Karyawan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('karyawan.create') }}" class="btn btn-primary mb-3">Tambah Karyawan</a>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nama Karyawan</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawan as $index => $k)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $k->nama_karyawan }}</td>
                            <td>{{ $k->pengguna->email ?? '-' }}</td>
                            <td>{{ $k->jabatan->nama_jabatan ?? '-' }}</td>
                            <td>{{ $k->no_telepon ?? '-' }}</td>
                            <td>{{ $k->alamat ?? '-' }}</td>
                            <td>
                                <a href="{{ route('karyawan.edit', $k->id_karyawan) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('karyawan.destroy', $k->id_karyawan) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data karyawan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection