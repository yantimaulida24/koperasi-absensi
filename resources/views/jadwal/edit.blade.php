@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Jadwal Kerja</h4>

    <form action="{{ route('jadwal-kerja.update', $jadwal_kerja->id_jadwal) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Hari Kerja</label>
            <input type="text" name="hari_kerja"
                   value="{{ $jadwal_kerja->hari_kerja }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jam Masuk</label>
            <input type="time" name="jam_masuk"
                   value="{{ \Carbon\Carbon::parse($jadwal_kerja->jam_masuk)->format('H:i') }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jam Keluar</label>
            <input type="time" name="jam_keluar"
                   value="{{ \Carbon\Carbon::parse($jadwal_kerja->jam_keluar)->format('H:i') }}"
                   class="form-control" required>
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('jadwal-kerja.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection