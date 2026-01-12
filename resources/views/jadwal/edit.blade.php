@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4">Edit Jadwal Kerja</h3>

    <form action="{{ route('jadwal.update', $jadwal->id_jadwal) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Hari Kerja</label>
            <input type="text" name="hari_kerja" class="form-control"
                   value="{{ old('hari_kerja', $jadwal->hari_kerja) }}" required>
            @error('hari_kerja')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Masuk</label>
            <input type="time" name="jam_masuk" class="form-control"
                   value="{{ old('jam_masuk', $jadwal->jam_masuk) }}" required>
            @error('jam_masuk')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Keluar</label>
            <input type="time" name="jam_keluar" class="form-control"
                   value="{{ old('jam_keluar', $jadwal->jam_keluar) }}" required>
            @error('jam_keluar')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection