@extends('layouts.app')

{{-- judul dihapus --}}
@section('title', '')

@section('content')
<div class="container">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- BUTTON TAMBAH JABATAN --}}
    <a href="{{ route('jabatan.create') }}" class="btn btn-jabatan mb-3">
        + Tambah Jabatan
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Jabatan</th>
                <th width="20%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jabatans as $index => $jabatan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $jabatan->nama_jabatan }}</td>
                    <td>
                        <a href="{{ route('jabatan.edit', $jabatan->id_jabatan) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('jabatan.destroy', $jabatan->id_jabatan) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus jabatan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">
                        Belum ada data jabatan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

{{-- STYLE BUTTON --}}
<style>
    .btn-jabatan {
        background-color: #1b5e20;
        color: #ffffff;
        font-weight: 500;
        border-radius: 6px;
        padding: 8px 14px;
    }

    .btn-jabatan:hover {
        background-color: #154a19;
        color: #ffffff;
    }
</style>

@endsection
