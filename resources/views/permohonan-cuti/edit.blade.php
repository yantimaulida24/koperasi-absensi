@extends('layouts.app')

@section('content')
<div class="container">
    
    <form action="{{ route('permohonan-cuti.update', $cuti->id_cuti) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Karyawan --}}
        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <select class="form-control" disabled>
                @foreach($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}"
                        {{ $k->id_karyawan == $cuti->id_karyawan ? 'selected' : '' }}>
                        {{ $k->nama_karyawan }}
                    </option>
                @endforeach
            </select>

            <input type="hidden" name="id_karyawan" value="{{ $cuti->id_karyawan }}">
        </div>

        {{-- Tanggal Mulai --}}
        <div class="mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control"
                   value="{{ $cuti->tanggal_mulai }}" readonly>

            <input type="hidden" name="tanggal_mulai" value="{{ $cuti->tanggal_mulai }}">
        </div>

        {{-- Tanggal Selesai --}}
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

        {{-- Alasan --}}
        <div class="mb-3">
            <label class="form-label">Alasan Cuti</label>
            <textarea class="form-control" rows="4" readonly>{{ $cuti->alasan_cuti }}</textarea>

            <input type="hidden" name="alasan_cuti" value="{{ $cuti->alasan_cuti }}">
        </div>

        {{-- Tombol --}}
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