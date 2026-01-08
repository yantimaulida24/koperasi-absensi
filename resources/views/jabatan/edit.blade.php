@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-bold">Edit Jabatan</h3>

    <form action="{{ route('jabatan.update', $jabatan->id_jabatan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
            <input type="text" id="nama_jabatan" name="nama_jabatan" class="form-control"
                   value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}" required>
            @error('nama_jabatan')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection