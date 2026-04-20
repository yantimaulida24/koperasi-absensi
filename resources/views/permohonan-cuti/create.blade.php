@extends('layouts.app')

@section('content')
<div class="container">

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ALERT ERROR GLOBAL --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('permohonan-cuti.store') }}" method="POST">
        @csrf

        {{-- 🔥 NAMA KARYAWAN (OTOMATIS) --}}
        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control"
                value="{{ auth()->user()->karyawan->nama_karyawan ?? '-' }}" readonly>
        </div>

        {{-- TANGGAL MULAI --}}
        <div class="mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai"
                   class="form-control @error('tanggal_mulai') is-invalid @enderror"
                   min="{{ date('Y-m-d') }}"
                   value="{{ old('tanggal_mulai') }}"
                   required>

            @error('tanggal_mulai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- TANGGAL SELESAI --}}
        <div class="mb-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai"
                   class="form-control @error('tanggal_selesai') is-invalid @enderror"
                   min="{{ date('Y-m-d') }}"
                   value="{{ old('tanggal_selesai') }}"
                   required>

            @error('tanggal_selesai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- ALASAN --}}
        <div class="mb-3">
            <label class="form-label">Alasan Cuti</label>
            <textarea name="alasan_cuti"
                class="form-control @error('alasan_cuti') is-invalid @enderror"
                rows="4" required>{{ old('alasan_cuti') }}</textarea>

            @error('alasan_cuti')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-jabatan">Simpan</button>
        <a href="{{ route('permohonan-cuti.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

{{-- SCRIPT VALIDASI TANGGAL --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const mulai = document.querySelector('input[name="tanggal_mulai"]');
    const selesai = document.querySelector('input[name="tanggal_selesai"]');

    mulai.addEventListener('change', function () {
        selesai.min = this.value;

        if (selesai.value < this.value) {
            selesai.value = "";
        }
    });
});
</script>

{{-- STYLE --}}
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