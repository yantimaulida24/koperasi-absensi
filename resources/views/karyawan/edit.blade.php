@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Jadwal Kerja</h2>

    {{-- Form Edit Jadwal Kerja --}}
    <form action="{{ route('jadwal.update', ['jadwal_kerja' => $jadwal->id]) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Pilih Karyawan --}}
        <div class="mb-3">
            <label for="id_karyawan" class="form-label">Nama Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-select" required>
                @foreach ($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}" {{ $k->id_karyawan == $jadwal->id_karyawan ? 'selected' : '' }}>
                        {{ $k->nama_karyawan }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $jadwal->tanggal }}" required>
        </div>

        {{-- Jam Masuk --}}
        <div class="mb-3">
            <label for="jam_masuk" class="form-label">Jam Masuk</label>
            <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" value="{{ $jadwal->jam_masuk }}" required>
        </div>

        {{-- Jam Keluar --}}
        <div class="mb-3">
            <label for="jam_keluar" class="form-label">Jam Keluar</label>
            <input type="time" name="jam_keluar" id="jam_keluar" class="form-control" value="{{ $jadwal->jam_keluar }}" required>
        </div>

        {{-- Shift --}}
        <div class="mb-3">
            <label for="shift" class="form-label">Shift</label>
            <input type="text" name="shift" id="shift" class="form-control" value="{{ $jadwal->shift }}" required>
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
