@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4">Edit Karyawan</h3>

    <form action="{{ route('karyawan.update', $karyawan->id_karyawan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" name="nama_karyawan" value="{{ $karyawan->nama_karyawan }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">User</label>
            <select name="id_user" class="form-select" required>
                <option value="">-- Pilih Pengguna --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $karyawan->id_user == $user->id ? 'selected' : '' }}>
                        {{ $user->nama_pengguna }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <select name="id_jabatan" class="form-select" required>
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatan as $item)
                    <option value="{{ $item->id_jabatan }}" {{ $karyawan->id_jabatan == $item->id_jabatan ? 'selected' : '' }}>
                        {{ $item->nama_jabatan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">No Telepon</label>
            <input type="text" name="no_telepon" value="{{ $karyawan->no_telepon }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control">{{ $karyawan->alamat }}</textarea>
        </div>

        <button class="btn btn-primary">Perbarui</button>
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection