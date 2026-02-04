@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Akun</h1>

    <form action="{{ route('akun.update', $akun->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control"
                   value="{{ $akun->name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ $akun->email }}" required>
        </div>

        <div class="mb-3">
            <label>Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ $akun->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="karyawan" {{ $akun->role == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('akun.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
