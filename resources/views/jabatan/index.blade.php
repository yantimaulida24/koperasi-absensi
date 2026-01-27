@extends('layouts.app')

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('jabatan.create') }}" class="btn btn-primary mb-3">
        + Tambah Jabatan
    </a>

    <div class="table-responsive">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Jabatan</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jabatans as $i => $jabatan)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $jabatan->nama_jabatan }}</td>
                    <td>
                        <a href="{{ route('jabatan.edit', $jabatan->id_jabatan) }}"
                           class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('jabatan.destroy', $jabatan->id_jabatan) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus data?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        Belum ada data jabatan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection