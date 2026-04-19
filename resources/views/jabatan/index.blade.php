@extends('layouts.app')

@section('content')
<div class="container">

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- TOMBOL TAMBAH --}}
    <a href="{{ route('jabatan.create') }}" class="btn btn-primary mb-3" title="Tambah Jabatan">
        <i class="fas fa-plus"></i> Tambah Jabatan
    </a>

    <div class="table-responsive">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Jabatan</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jabatans as $i => $jabatan)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $jabatan->nama_jabatan }}</td>
                    <td>

                        {{-- EDIT --}}
                        <a href="{{ route('jabatan.edit', $jabatan->id_jabatan) }}"
                           class="btn btn-warning btn-sm"
                           title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- HAPUS --}}
                        <form action="{{ route('jabatan.destroy', $jabatan->id_jabatan) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus data jabatan ini?')">
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