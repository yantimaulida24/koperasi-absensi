@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4">Tambah Karyawan</h3>

    <form action="{{ route('karyawan.store') }}" method="POST">
        @csrf
        <!-- Input Nama Karyawan -->
        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" name="nama_karyawan" class="form-control" required>
        </div>

        <!-- Dropdown Jabatan -->
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <select name="id_jabatan" class="form-select" required>
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatan as $item)
                    <option value="{{ $item->id_jabatan }}">{{ $item->nama_jabatan }}</option>
                @endforeach
            </select>
        </div>

        <!-- Input No Telepon -->
        <div class="mb-3">
            <label class="form-label">No Telepon</label>
            <input type="text" name="no_telepon" class="form-control">
        </div>

        <!-- Input Alamat -->
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="4"></textarea>
        </div>

        <!-- Button Submit -->
        <div class="mb-3">
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection