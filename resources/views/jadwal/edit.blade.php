@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4">Edit Jadwal Kerja</h3>

    <form action="{{ route('jadwal.update', $jadwal_kerja->id_jadwal) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="hari_kerja" class="form-label">Hari Kerja</label>
            <input type="text" name="hari_kerja" id="hari_kerja" class="form-control" value="{{ old('hari_kerja', $jadwal_kerja->hari_kerja) }}" required>
        </div>

        <div class="mb-3">
            <label for="jam_masuk" class="form-label">Jam Masuk</label>
            <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" value="{{ old('jam_masuk', \Carbon\Carbon::parse($jadwal_kerja->jam_masuk)->format('H:i')) }}" required>
        </div>

        <div class="mb-3">
            <label for="jam_keluar" class="form-label">Jam Keluar</label>
            <input type="time" name="jam_keluar" id="jam_keluar" class="form-control" value="{{ old('jam_keluar', \Carbon\Carbon::parse($jadwal_kerja->jam_keluar)->format('H:i')) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection