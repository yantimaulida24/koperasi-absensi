@extends('layouts.app')

@section('content')
<div class="container">

    <a href="{{ route('jadwal.create') }}" class="btn btn-primary mb-3">
        + Tambah Jadwal
    </a>

    <div class="table-responsive">
        <table class="table custom-table text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Hari Kerja</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $i => $j)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $j->hari_kerja }}</td>
                    <td>{{ $j->jam_masuk }}</td>
                    <td>{{ $j->jam_keluar }}</td>
                    <td>
                        <a href="{{ route('jadwal.edit', $j->id_jadwal) }}"
                           class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('jadwal.destroy', $j->id_jadwal) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus jadwal?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Belum ada jadwal
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection