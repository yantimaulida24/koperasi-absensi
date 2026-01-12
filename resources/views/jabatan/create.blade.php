@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-bold">Tambah Jabatan</h3>

    <form action="{{ route('jabatan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
            <input type="text" id="nama_jabatan" name="nama_jabatan" class="form-control" value="{{ old('nama_jabatan') }}" required>
            @error('nama_jabatan')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection