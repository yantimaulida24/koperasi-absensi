@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-bold">Edit Karyawan</h3>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('karyawan.update', $karyawan->id_karyawan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_pengguna" class="form-label">Pengguna</label>
                    <select name="id_pengguna" class="form-select" required>
                        <option value="">-- Pilih Pengguna --</option>
                        @foreach($pengguna as $p)
                            <option value="{{ $p->id_pengguna }}" {{ $karyawan->id_pengguna == $p->id_pengguna ? 'selected' : '' }}>
                                {{ $p->email }} - {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_jabatan" class="form-label">Jabatan</label>
                    <select name="id_jabatan" class="form-select" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatan as $j)
                            <option value="{{ $j->id_jabatan }}" {{ $karyawan->id_jabatan == $j->id_jabatan ? 'selected' : '' }}>
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                    <input type="text" name="nama_karyawan" class="form-control" value="{{ $karyawan->nama_karyawan }}" required>
                </div>

                <div class="mb-3">
                    <label for="no_telepon" class="form-label">No. Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" value="{{ $karyawan->no_telepon }}">
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ $karyawan->alamat }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection