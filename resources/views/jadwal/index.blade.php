@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4">Data Jadwal Kerja</h3>

    <div class="mb-3">
        <a href="{{ route('jadwal.create') }}" class="btn btn-primary">
            + Tambah Jadwal
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th width="5%">No</th>
                <th>Hari Kerja</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th width="20%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwal as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data->hari_kerja }}</td>
                <td>{{ $data->jam_masuk }}</td>
                <td>{{ $data->jam_keluar }}</td>
                <td>
                    <a href="{{ route('jadwal.edit', $data->id_jadwal) }}" 
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('jadwal.destroy', $data->id_jadwal) }}" 
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus jadwal ini?')" 
                                class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-muted">
                    Belum ada data jadwal kerja
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection