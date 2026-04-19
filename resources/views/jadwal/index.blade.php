@extends('layouts.app')

@section('content')
<div class="container">

    <a href="{{ route('jadwal.create') }}"
    class="btn btn-primary mb-3"
    title="Tambah Jadwal">
        <i class="fas fa-plus me-1"></i>
        <span class="fw-bold">Tambah Jadwal</span>
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

                    {{-- FORMAT JAM --}}
                    <td>{{ \Carbon\Carbon::parse($j->jam_masuk)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($j->jam_keluar)->format('H:i') }}</td>

                    <td>
                        {{-- EDIT --}}
                        <a href="{{ route('jadwal.edit', $j->id_jadwal) }}"
                           class="btn btn-warning btn-sm"
                           title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- HAPUS --}}
                        <form action="{{ route('jadwal.destroy', $j->id_jadwal) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    title="Hapus">
                                <i class="fas fa-trash"></i>
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