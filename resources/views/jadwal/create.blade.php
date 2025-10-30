@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4">Tambah Jadwal Kerja</h3>

    <!-- Menampilkan pesan sukses atau error jika ada -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('jadwal.store') }}" method="POST">
        @csrf
        <!-- Input Hari Kerja -->
        <div class="mb-3">
            <label class="form-label">Hari Kerja</label>
            <input type="text" name="hari_kerja" class="form-control" value="{{ old('hari_kerja') }}" required>
            @error('hari_kerja')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Jam Masuk -->
        <div class="mb-3">
            <label class="form-label">Jam Masuk</label>
            <input type="time" name="jam_masuk" class="form-control" value="{{ old('jam_masuk') }}" required>
            @error('jam_masuk')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Jam Keluar -->
        <div class="mb-3">
            <label class="form-label">Jam Keluar</label>
            <input type="time" name="jam_keluar" class="form-control" value="{{ old('jam_keluar') }}" required>
            @error('jam_keluar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Button Submit -->
        <div class="mb-3">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection