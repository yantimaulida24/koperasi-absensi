@extends('layouts.app')

{{-- judul dihapus --}}
@section('title', '')

@section('content')
<div class="container">

    <form action="{{ route('jabatan.update', $jabatan->id_jabatan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_jabatan" class="form-label fw-semibold">
                Nama Jabatan
            </label>
            <input type="text"
                   id="nama_jabatan"
                   name="nama_jabatan"
                   class="form-control"
                   value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}"
                   required>

            @error('nama_jabatan')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-success">Simpan Perubahan</button>

        <a href="{{ route('jabatan.index') }}" class="btn btn-secondary ml-2">
            Batal
        </a>
    </form>

</div>

{{-- STYLE BUTTON (KONSISTEN) --}}
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
