@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Tambah Karyawan</h4>

    <form action="{{ route('karyawan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Pengguna</label>
            <select name="id_pengguna" class="form-control" required>
                <option value="">Pilih</option>
                @foreach($pengguna as $p)
                <option value="{{ $p->id_pengguna }}">{{ $p->username }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <select name="id_jabatan" class="form-control" required>
                <option value="">Pilih</option>
                @foreach($jabatan as $j)
                <option value="{{ $j->id_jabatan }}">{{ $j->nama_jabatan }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nama Karyawan</label>
            <input type="text" name="nama_karyawan" required class="form-control">
        </div>

        <div class="mb-3">
            <label>No Telepon</label>
            <input type="text" name="no_telepon" class="form-control">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
