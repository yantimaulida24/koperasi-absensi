@extends('layouts.app')

@section('content')
<div class="container">
    
    <form action="{{ route('permohonan-cuti.update', $cuti->id_cuti) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- 🔥 NAMA KARYAWAN (OTOMATIS) --}}
        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control"
                value="{{ $cuti->karyawan->nama_karyawan }}" readonly>
        </div>

        {{-- TANGGAL MULAI --}}
        <div class="mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control"
                   value="{{ $cuti->tanggal_mulai }}" readonly>

            <input type="hidden" name="tanggal_mulai" value="{{ $cuti->tanggal_mulai }}">
        </div>

        {{-- TANGGAL SELESAI --}}
        <div class="mb-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control"
                   value="{{ $cuti->tanggal_selesai }}" readonly>

            <input type="hidden" name="tanggal_selesai" value="{{ $cuti->tanggal_selesai }}">
        </div>

        {{-- STATUS CUTI --}}
        <div class="mb-3">
            <label class="form-label">Status Cuti</label>
            <select name="status_cuti" class="form-control" required>
                <option value="belum disetujui"
                    {{ $cuti->status_cuti == 'belum disetujui' ? 'selected' : '' }}>
                    Belum Disetujui
                </option>
                <option value="disetujui"
                    {{ $cuti->status_cuti == 'disetujui' ? 'selected' : '' }}>
                    Disetujui
                </option>
                <option value="ditolak"
                    {{ $cuti->status_cuti == 'ditolak' ? 'selected' : '' }}>
                    Ditolak
                </option>
            </select>
        </div>

        {{-- ALASAN --}}
        <div class="mb-3">
            <label class="form-label">Alasan Cuti</label>
            <textarea class="form-control" rows="4" readonly>{{ $cuti->alasan_cuti }}</textarea>

            <input type="hidden" name="alasan_cuti" value="{{ $cuti->alasan_cuti }}">
        </div>

        {{-- TOMBOL --}}
        <button type="submit" class="btn btn-jabatan">Simpan Perubahan</button>
        <a href="{{ route('permohonan-cuti.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

{{-- STYLE --}}
<style>
    .btn-jabatan {
        background-color: #1b5e20;
        color: #ffffff;
        font-weight: 500;
        border-radius: 6px;
        padding: 8px 18px;
        border: none;
    }

    .btn-jabatan:hover {
        background-color: #154a19;
        color: #ffffff;
    }
</style>

@endsection