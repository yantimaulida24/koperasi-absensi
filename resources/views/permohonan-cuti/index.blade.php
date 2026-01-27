@extends('layouts.app')

@section('content')
<div class="container">

    <a href="{{ route('permohonan-cuti.create') }}"
       class="btn btn-primary mb-3">
        + Tambah Permohonan
    </a>

    <table class="table custom-table">
        <thead>
            <tr>
                <th>ID</th>
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
                    <a href="{{ route('permohonan-cuti.edit', $c->id_cuti) }}"
                       class="btn btn-warning btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection