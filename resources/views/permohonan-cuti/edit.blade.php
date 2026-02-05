@extends('layouts.app')

@section('content')
<div class="container">
    
    <form action="{{ route('permohonan-cuti.update', $cuti->id_cuti) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <select name="id_karyawan" class="form-control" disabled>
                @foreach($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}"
                        {{ $k->id_karyawan == $cuti->id_karyawan ? 'selected' : '' }}>
                        {{ $k->nama_karyawan }}
                    </option>
                @endforeach
            </select>

            {{-- hidden agar data tetap terkirim --}}
            <input type="hidden" name="id_karyawan" value="{{ $cuti->id_karyawan }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control"
                   value="{{ $cuti->tanggal_mulai }}" readonly>

            <input type="hidden" name="tanggal_mulai" value="{{ $cuti->tanggal_mulai }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control"
                   value="{{ $cuti->tanggal_selesai }}" readonly>

            <input type="hidden" name="tanggal_selesai" value="{{ $cuti->tanggal_selesai }}">
        </div>

        {{-- ======================
             STATUS CUTI (AKTIF)
        ======================= --}}
        <div class="mb-3">
            <label class="form-label">Status Cuti</label>
            <select name="status_cuti" class="form-control" required>
                <option value="belum disetujui" {{ $cuti->status_cuti == 'belum disetujui' ? 'selected' : '' }}>
                    Belum Disetujui
                </option>
                <option value="disetujui" {{ $cuti->status_cuti == 'disetujui' ? 'selected' : '' }}>
                    Disetujui
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Alasan Cuti</label>
            <textarea class="form-control" rows="4" readonly>{{ $cuti->alasan_cuti }}</textarea>

            <input type="hidden" name="alasan_cuti" value="{{ $cuti->alasan_cuti }}">
        </div>

        <button class="btn btn-jabatan">Simpan Perubahan</button>
        <a href="{{ route('permohonan-cuti.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

{{-- STYLE TOMBOL HIJAU --}}
<style>
    .btn-jabatan {
        background-color: #1b5e20;
        color: #ffffff;
        font-weight: 500;
        border-radius: 6px;
        padding: 8px 18px;
    }

    .btn-jabatan:hover {
        background-color: #154a19;
        color: #ffffff;
    }
</style>
@endsection