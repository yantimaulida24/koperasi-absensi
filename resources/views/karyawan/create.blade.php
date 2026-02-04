@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white fw-bold">
            Tambah Data Karyawan
        </div>

        <div class="card-body">
            <form action="{{ route('data-karyawan.store') }}" method="POST">
                @csrf

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label">Nama Karyawan</label>
                    <input type="text"
                           name="nama_karyawan"
                           class="form-control"
                           value="{{ old('nama_karyawan') }}"
                           required>
                    @error('nama_karyawan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TEMPAT LAHIR --}}
                <div class="mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text"
                           name="tempat_lahir"
                           class="form-control"
                           value="{{ old('tempat_lahir') }}"
                           required>
                    @error('tempat_lahir')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TANGGAL LAHIR --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date"
                           name="tanggal_lahir"
                           class="form-control"
                           value="{{ old('tanggal_lahir') }}"
                           required>
                    @error('tanggal_lahir')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- JABATAN --}}
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
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- NO TELEPON --}}
                <div class="mb-3">
                    <label class="form-label">No Telepon</label>
                    <input type="text"
                           name="no_telepon"
                           class="form-control"
                           value="{{ old('no_telepon') }}">
                    @error('no_telepon')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ALAMAT --}}
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- BUTTON --}}
                <div class="mt-4">
                    <button class="btn btn-jabatan">
                        Simpan
                    </button>
                    <a href="{{ route('data-karyawan.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

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
