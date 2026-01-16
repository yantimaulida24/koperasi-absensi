@extends('layouts.app')

@section('content')
<div class="container">
    

    <form action="{{ route('karyawan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" name="nama_karyawan" class="form-control"
                   value="{{ old('nama_karyawan') }}" required>
            @error('nama_karyawan')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <select name="id_jabatan" class="form-control" required>
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatan as $item)
                    <option value="{{ $item->id_jabatan }}"
                        {{ old('id_jabatan') == $item->id_jabatan ? 'selected' : '' }}>
                        {{ $item->nama_jabatan }}
                    </option>
                @endforeach
            </select>
            @error('id_jabatan')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">No Telepon</label>
            <input type="text" name="no_telepon" class="form-control"
                   value="{{ old('no_telepon') }}">
            @error('no_telepon')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="4">{{ old('alamat') }}</textarea>
            @error('alamat')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <button class="btn btn-jabatan">Simpan</button>
            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

{{-- STYLE TOMBOL (SAMA SEMUA HALAMAN) --}}
<style>
    .btn-jabatan {
        background-color: #1b5e20;
        color: #ffffff;
        font-weight: 500;
        border-radius: 6px;
        padding: 8px 18px;
    }

    .btn-jabatan:hover {
        background-color: #154a19;
        color: #ffffff;
    }
</style>
@endsection
