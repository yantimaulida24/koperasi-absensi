@extends('layouts.app')

@section('content')
<div class="container">

    @if(auth()->user()->role === 'karyawan')
        <a href="{{ route('permohonan-cuti.create') }}" class="btn btn-primary mb-3">
            + Tambah Permohonan
        </a>
    @endif

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
                class="btn btn-warning btn-sm">
                    Edit
                </a>

                @if(auth()->user()->role === 'admin')
                    <form action="{{ route('permohonan-cuti.destroy', $c->id_cuti) }}"
                        method="POST"
                        class="d-inline"
                        onsubmit="return confirm('Yakin ingin menghapus data cuti ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection