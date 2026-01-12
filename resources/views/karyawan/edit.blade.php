@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Data Karyawan</h2>

    <form action="{{ route('karyawan.update', $karyawan->id_karyawan) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama Karyawan -->
        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" name="nama_karyawan" class="form-control"
                   value="{{ old('nama_karyawan', $karyawan->nama_karyawan) }}" required>
            @error('nama_karyawan')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Jabatan -->
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <select name="id_jabatan" class="form-control" required>
                @foreach ($jabatan as $j)
                    <option value="{{ $j->id_jabatan }}" {{ (old('id_jabatan', $karyawan->id_jabatan) == $j->id_jabatan) ? 'selected' : '' }}>
                        {{ $j->nama_jabatan }}
                    </option>
                @endforeach
            </select>
            @error('id_jabatan')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- No Telepon -->
        <div class="mb-3">
            <label class="form-label">No Telepon</label>
            <input type="text" name="no_telepon" class="form-control"
                   value="{{ old('no_telepon', $karyawan->no_telepon) }}">
            @error('no_telepon')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control">{{ old('alamat', $karyawan->alamat) }}</textarea>
            @error('alamat')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection