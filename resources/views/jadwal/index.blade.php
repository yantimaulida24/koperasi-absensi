@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4">Data Jadwal Kerja</h3>

    <div class="mb-3">
        <a href="{{ route('jadwal.create') }}" class="btn btn-primary">+ Tambah Jadwal</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Hari Kerja</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwal as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data->hari_kerja }}</td>
                <td>{{ \Carbon\Carbon::parse($data->jam_masuk)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($data->jam_keluar)->format('H:i') }}</td>
                <td>
                    <a href="{{ route('jadwal.edit', $data->id_jadwal) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('jadwal.destroy', $data->id_jadwal) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus jadwal ini?')" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection