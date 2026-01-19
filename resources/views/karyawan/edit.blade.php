@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <form action="{{ route('data-karyawan.update', $karyawan->id_karyawan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Karyawan</label>
            <input type="text" name="nama_karyawan" class="form-control"
                value="{{ old('nama_karyawan', $karyawan->nama_karyawan) }}" required>
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <select name="id_jabatan" class="form-control" required>
                @foreach ($jabatan as $j)
                    <option value="{{ $j->id_jabatan }}" {{ old('id_jabatan', $karyawan->id_jabatan)==$j->id_jabatan?'selected':'' }}>
                        {{ $j->nama_jabatan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>No Telepon</label>
            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $karyawan->no_telepon) }}">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control">{{ old('alamat', $karyawan->alamat) }}</textarea>
        </div>

        <button class="btn btn-jabatan">Simpan</button>
        <a href="{{ route('data-karyawan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
