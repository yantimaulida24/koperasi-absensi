@extends('layouts.app')

@section('content')
<div class="container">
    

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('akun.create') }}" class="btn btn-primary mb-3">
        + Tambah Akun
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($akun as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ ucfirst($item->role) }}</td>
                <td>
                    <a href="{{ route('akun.edit', $item->id) }}" class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('akun.destroy', $item->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Yakin hapus akun ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
