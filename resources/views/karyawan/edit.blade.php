@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Edit Data Karyawan
        </div>

        <div class="card-body">
            <form action="{{ route('karyawan.update', $karyawan->id_karyawan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nama Karyawan</label>
                    <input type="text" name="nama_karyawan" class="form-control" value="{{ $karyawan->nama_karyawan }}" required>
                </div>

                <div class="mb-3">
                    <label>No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" value="{{ $karyawan->no_telepon }}">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control">{{ $karyawan->alamat }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Jabatan</label>
                    <select name="id_jabatan" class="form-control">
                        @foreach ($jabatan as $j)
                            <option value="{{ $j->id_jabatan }}" {{ $karyawan->id_jabatan == $j->id_jabatan ? 'selected' : '' }}>
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
