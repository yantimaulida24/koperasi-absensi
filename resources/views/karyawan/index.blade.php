@extends('layouts.app')

@section('content')
<div class="container">

    {{-- TOMBOL TAMBAH (ADMIN) --}}
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('data-karyawan.create') }}" class="btn btn-primary mb-3">
            + Tambah Karyawan
        </a>
    @endif

    {{-- SEARCH --}}
    <form method="GET" action="{{ route('data-karyawan.index') }}" class="mb-3 d-flex">
        <input
            type="text"
            name="search"
            class="form-control me-2"
            placeholder="Cari nama karyawan..."
            value="{{ request('search') }}"
        >
        <button class="btn btn-primary">Cari</button>

        @if(request('search'))
            <a href="{{ route('data-karyawan.index') }}" class="btn btn-secondary ms-2">
                Reset
            </a>
        @endif
    </form>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th width="5%">No</th>
                    <th>Nama Karyawan</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Jabatan</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th width="22%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($karyawan as $index => $data)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $data->nama_karyawan }}</td>
                    <td>{{ $data->tempat_lahir }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($data->tanggal_lahir)->format('d-m-Y') }}
                    </td>
                    <td>{{ $data->jabatan->nama_jabatan ?? '-' }}</td>
                    <td>{{ $data->no_telepon ?? '-' }}</td>
                    <td>{{ $data->alamat ?? '-' }}</td>
                    <td class="text-center">

                        {{-- DETAIL --}}
                        <a href="{{ route('data-karyawan.show', $data->id_karyawan) }}"
                           class="btn btn-info btn-sm">
                            Lihat
                        </a>

                        @if(auth()->user()->role === 'admin')
                            {{-- EDIT --}}
                            <a href="{{ route('data-karyawan.edit', $data->id_karyawan) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            {{-- HAPUS --}}
                            <form action="{{ route('data-karyawan.destroy', $data->id_karyawan) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        Tidak ada data karyawan
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
