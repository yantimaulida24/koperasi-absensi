@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Jadwal Kerja</h2>

    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
    @csrf
    @method('PUT')
        <div class="mb-3">
            <label class="form-label">Hari Kerja</label>
            <input type="text" name="hari_kerja" class="form-control" value="{{ $jadwal->hari_kerja }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Masuk</label>
            <input type="time" name="jam_masuk" class="form-control" value="{{ $jadwal->jam_masuk }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Keluar</label>
            <input type="time" name="jam_keluar" class="form-control" value="{{ $jadwal->jam_keluar }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
