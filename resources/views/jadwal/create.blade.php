@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('jadwal.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Hari Kerja</label>
            <input type="text" name="hari_kerja" class="form-control"
                   value="{{ old('hari_kerja') }}" required>
            @error('hari_kerja')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Masuk</label>
            <input type="text" name="jam_masuk" class="form-control timepicker"
                   value="{{ old('jam_masuk') }}" required>
            @error('jam_masuk')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Keluar</label>
            <input type="text" name="jam_keluar" class="form-control timepicker"
                   value="{{ old('jam_keluar') }}" required>
            @error('jam_keluar')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-jabatan">Simpan</button>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

{{-- FLATPICKR --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
flatpickr(".timepicker", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});
</script>

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