@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4">Tambah Jadwal Kerja</h3>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('jadwal.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Hari Kerja</label>
            <input type="text" name="hari_kerja" class="form-control"
                   value="{{ old('hari_kerja') }}" required>
            @error('hari_kerja')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Masuk</label>
            <input type="time" name="jam_masuk" class="form-control"
                   value="{{ old('jam_masuk') }}" required>
            @error('jam_masuk')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Keluar</label>
            <input type="time" name="jam_keluar" class="form-control"
                   value="{{ old('jam_keluar') }}" required>
            @error('jam_keluar')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection