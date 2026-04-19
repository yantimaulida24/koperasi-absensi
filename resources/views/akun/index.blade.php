@extends('layouts.app')

@section('content')
<div class="container">

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- TOMBOL TAMBAH --}}
    <a href="{{ route('akun.create') }}" class="btn btn-primary mb-3" title="Tambah Akun">
        <i class="fas fa-plus"></i> Tambah Akun
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th width="120">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($akun as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>

                {{-- ROLE TANPA WARNA --}}
                <td>{{ ucfirst($item->role) }}</td>

                <td>
                    {{-- EDIT --}}
                    <a href="{{ route('akun.edit', $item->id) }}"
                       class="btn btn-warning btn-sm"
                       title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>

                    {{-- HAPUS --}}
                    <form action="{{ route('akun.destroy', $item->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                                title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection