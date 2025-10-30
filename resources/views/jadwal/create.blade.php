@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Jadwal Kerja</h2>

    <form action="{{ route('jadwal.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="hari_kerja" class="form-label">Hari Kerja</label>
            <input type="text" name="hari_kerja" class="form-control" id="hari_kerja" required>
        </div>

        <div class="mb-3">
            <label for="jam_masuk" class="form-label">Jam Masuk</label>
            <input type="time" name="jam_masuk" class="form-control" id="jam_masuk" required>
        </div>

        <div class="mb-3">
            <label for="jam_keluar" class="form-label">Jam Keluar</label>
            <input type="time" name="jam_keluar" class="form-control" id="jam_keluar" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
