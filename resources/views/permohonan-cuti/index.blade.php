@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-bold">Permohonan Cuti</h3>

    <a href="{{ route('permohonan-cuti.create') }}" class="btn btn-primary mb-3">Ajukan Cuti</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>Nama Karyawan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Alasan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cutis as $cuti)
            <tr>
                <td>{{ $cuti->karyawan->name }}</td>
                <td>{{ $cuti->tanggal_mulai }}</td>
                <td>{{ $cuti->tanggal_selesai }}</td>
                <td>{{ $cuti->status }}</td>
                <td>{{ $cuti->alasan }}</td>
                <td>
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('permohonan-cuti.edit', $cuti->id_cuti) }}" class="btn btn-sm btn-warning">Ubah Status</a>
                    <form action="{{ route('permohonan-cuti.destroy', $cuti->id_cuti) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
