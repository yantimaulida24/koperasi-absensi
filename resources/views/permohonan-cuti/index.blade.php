@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Permohonan Cuti</h3>

    <a href="{{ route('permohonan-cuti.create') }}" class="btn btn-primary mb-3">+ Tambah Permohonan Cuti</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Cuti</th>
                <th>Nama Karyawan</th>
                <th>Tanggal Pengajuan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status Cuti</th>
                <th>Alasan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuti as $c)
            <tr>
                <td>{{ $c->id_cuti }}</td>
                <td>{{ $c->karyawan->nama_karyawan }}</td>
                <td>{{ $c->tanggal_pengajuan }}</td>
                <td>{{ $c->tanggal_mulai }}</td>
                <td>{{ $c->tanggal_selesai }}</td>
                <td>{{ $c->status_cuti }}</td>
                <td>{{ $c->alasan_cuti }}</td>
                <td>
                    <a href="{{ route('permohonan-cuti.edit', $c->id_cuti) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('permohonan-cuti.destroy', $c->id_cuti) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection