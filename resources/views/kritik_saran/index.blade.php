@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-center">📢 Kritik & Saran</h3>

    {{-- Tombol tambah hanya muncul untuk karyawan --}}
    @if(auth()->user()->role === 'karyawan')
        <div class="mb-3 text-end">
            <a href="{{ route('kritik_saran.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Tambah Kritik / Saran
            </a>
        </div>
    @endif

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm kritik-card">
        <div class="card-header bg-secondary text-white fw-bold">
            Daftar Kritik & Saran
        </div>

        <div class="card-body">

            @forelse($data as $item)
                <div class="kritik-item">

                    {{-- Nama & waktu --}}
                    <div class="kritik-header">
                        <strong>{{ optional($item->user)->name ?? 'Anonim' }}</strong>
                        <span class="text-muted small">
                            {{ $item->created_at->format('d M Y H:i') }}
                        </span>
                    </div>

                    {{-- Isi kritik --}}
                    <p class="kritik-isi">
                        {{ $item->isi }}
                    </p>

                    {{-- Komentar admin --}}
                    @if($item->komentar_admin)
                        <div class="komentar-admin">
                            <strong>Komentar Admin:</strong>
                            <p class="mb-0">{{ $item->komentar_admin }}</p>
                        </div>
                    @endif

                    {{-- Form komentar admin --}}
                    @if(auth()->user()->role === 'admin')
                        <form action="{{ route('kritik_saran.komentar', $item->id) }}" method="POST" class="mt-2">
                            @csrf
                            <div class="input-group">
                                <input type="text"
                                       name="komentar_admin"
                                       class="form-control"
                                       placeholder="Balas kritik/saran..."
                                       required>
                                <button type="submit" class="btn btn-success">
                                    Kirim
                                </button>
                            </div>
                        </form>
                    @endif

                    {{-- Tombol hapus --}}
                    <div class="mt-3 d-flex gap-2">

                        {{-- Karyawan hanya bisa hapus miliknya --}}
                        @if(auth()->user()->role === 'karyawan' && auth()->id() === $item->user_id)
                            <form action="{{ route('kritik_saran.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif

                        {{-- Admin bisa hapus semua --}}
                        @if(auth()->user()->role === 'admin')
                            <form action="{{ route('kritik_saran.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Hapus kritik/saran ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            @empty
                <p class="text-center text-muted">
                    Belum ada kritik atau saran.
                </p>
            @endforelse

        </div>
    </div>
</div>

{{-- ================= STYLE ================= --}}
<style>
.kritik-card {
    border: 2px solid #6c757d;
}

.kritik-item {
    border: 1.5px solid #ced4da;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
    background-color: #ffffff;
}

.kritik-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.kritik-isi {
    padding: 10px;
    background-color: #f8f9fa;
    border-left: 4px solid #198754;
    border-radius: 4px;
}

.komentar-admin {
    margin-top: 10px;
    padding: 10px;
    background-color: #e9f5ff;
    border-left: 4px solid #0d6efd;
    border-radius: 4px;
}
</style>
@endsection