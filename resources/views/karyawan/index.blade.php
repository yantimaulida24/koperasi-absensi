@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Data Karyawan</h4>

    <a href="{{ route('karyawan.create') }}" class="btn btn-primary mb-3">+ Tambah Karyawan</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Username</th>
                <th>Jabatan</th>
                <th>No Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawan as $i => $row)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $row->nama_karyawan }}</td>
                <td>{{ $row->pengguna->username }}</td>
                <td>{{ $row->jabatan->nama_jabatan }}</td>
                <td>{{ $row->no_telepon }}</td>
                <td>
                    <a href="{{ route('karyawan.edit',$row->id_karyawan) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('karyawan.destroy',$row->id_karyawan) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Hapus data?')" class="btn btn-danger btn-sm">
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
