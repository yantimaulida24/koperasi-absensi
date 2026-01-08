@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Permohonan Cuti</h3>

    <form action="{{ route('permohonan-cuti.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <select name="id_karyawan" class="form-control" required>
                <option value="">-- Pilih Karyawan --</option>
                @foreach($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}">{{ $k->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" min="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" min="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alasan Cuti</label>
            <textarea name="alasan_cuti" class="form-control" rows="4" required></textarea>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('permohonan-cuti.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection