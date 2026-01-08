@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Permohonan Cuti</h3>

    <form action="{{ route('permohonan-cuti.update', $cuti->id_cuti) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <select name="id_karyawan" class="form-control" required>
                @foreach($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}" {{ $k->id_karyawan == $cuti->id_karyawan ? 'selected' : '' }}>
                        {{ $k->nama_karyawan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" value="{{ $cuti->tanggal_mulai }}" min="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" value="{{ $cuti->tanggal_selesai }}" min="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status Cuti</label>
            <select name="status_cuti" class="form-control" required>
                <option value="belum disetujui" {{ $cuti->status_cuti == 'belum disetujui' ? 'selected' : '' }}>Belum Disetujui</option>
                <option value="disetujui" {{ $cuti->status_cuti == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Alasan Cuti</label>
            <textarea name="alasan_cuti" class="form-control" rows="4" required>{{ $cuti->alasan_cuti }}</textarea>
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('permohonan-cuti.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection