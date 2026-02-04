@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark fw-bold">
            Edit Data Karyawan
        </div>

        <div class="card-body">
            <form action="{{ route('data-karyawan.update', $karyawan->id_karyawan) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label">Nama Karyawan</label>
                    <input type="text"
                           name="nama_karyawan"
                           class="form-control"
                           value="{{ old('nama_karyawan', $karyawan->nama_karyawan) }}"
                           required>
                </div>

                {{-- TEMPAT LAHIR --}}
                <div class="mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text"
                           name="tempat_lahir"
                           class="form-control"
                           value="{{ old('tempat_lahir', $karyawan->tempat_lahir) }}"
                           required>
                </div>

                {{-- TANGGAL LAHIR --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date"
                           name="tanggal_lahir"
                           class="form-control"
                           value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir) }}"
                           required>
                </div>

                {{-- JABATAN --}}
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <select name="id_jabatan" class="form-control" required>
                        @foreach ($jabatan as $j)
                            <option value="{{ $j->id_jabatan }}"
                                {{ old('id_jabatan', $karyawan->id_jabatan) == $j->id_jabatan ? 'selected' : '' }}>
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- NO TELEPON --}}
                <div class="mb-3">
                    <label class="form-label">No Telepon</label>
                    <input type="text"
                           name="no_telepon"
                           class="form-control"
                           value="{{ old('no_telepon', $karyawan->no_telepon) }}">
                </div>

                {{-- ALAMAT --}}
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $karyawan->alamat) }}</textarea>
                </div>

                {{-- BUTTON --}}
                <div class="mt-4">
                    <button class="btn btn-success">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('data-karyawan.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
