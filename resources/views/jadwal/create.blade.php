@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Jadwal Kerja</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('jadwal-kerja.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Hari Kerja</label>
            <input type="text" name="hari_kerja" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jam Masuk</label>
            <input type="time" name="jam_masuk" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jam Keluar</label>
            <input type="time" name="jam_keluar" class="form-control" required>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('jadwal-kerja.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection