@extends('layouts.app')

{{-- judul halaman tidak ditampilkan --}}
@section('title', '')

@section('content')
<div class="container">

    <form action="{{ route('jabatan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama_jabatan" class="form-label fw-semibold">
                Nama Jabatan
            </label>
            <input type="text"
                   id="nama_jabatan"
                   name="nama_jabatan"
                   class="form-control"
                   value="{{ old('nama_jabatan') }}"
                   required>

            @error('nama_jabatan')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- BUTTON --}}
        <button type="submit" class="btn btn-jabatan">
            Simpan
        </button>

        <a href="{{ route('jabatan.index') }}" class="btn btn-secondary ml-2">
            Batal
        </a>
    </form>

</div>

{{-- STYLE BUTTON (SAMA DENGAN INDEX) --}}
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
