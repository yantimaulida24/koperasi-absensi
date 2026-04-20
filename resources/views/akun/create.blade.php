@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Akun</h1>

    <form action="{{ route('akun.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="karyawan">Karyawan</option>
            </select>
        </div>

        {{-- 🔥 TAMBAHAN: PILIH KARYAWAN --}}
        <div class="mb-3">
            <label>Pilih Karyawan</label>
            <select name="id_karyawan" class="form-control">
                <option value="">-- Pilih Karyawan --</option>
                @foreach($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}">
                        {{ $k->nama_karyawan }} ({{ $k->nik_karyawan }})
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('akun.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection