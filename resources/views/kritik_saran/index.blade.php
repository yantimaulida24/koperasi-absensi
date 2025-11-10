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

    {{-- Daftar kritik & saran --}}
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">Daftar Kritik & Saran</div>
        <div class="card-body">
            @forelse($data as $item)
                <div class="border-bottom pb-3 mb-3">
                    <p>
                        <strong>{{ $item->user->name ?? 'Anonim' }}</strong><br>
                        <small class="text-muted">{{ $item->created_at->format('d M Y H:i') }}</small>
                    </p>

                    <p>{{ $item->isi }}</p>

                    {{-- Komentar admin --}}
                    @if($item->komentar_admin)
                        <div class="p-2 bg-light rounded mb-2">
                            <strong>Komentar Admin:</strong>
                            <p class="mb-0">{{ $item->komentar_admin }}</p>
                        </div>
                    @endif

                    {{-- Form komentar untuk admin --}}
                    @if(auth()->user()->role === 'admin')
                        <form action="{{ route('kritik_saran.komentar', $item->id) }}" method="POST" class="mt-2">
                            @csrf
                            <div class="input-group mb-2">
                                <input type="text" name="komentar_admin" class="form-control" placeholder="Balas kritik/saran..." required>
                                <button type="submit" class="btn btn-success">Kirim Balasan</button>
                            </div>
                        </form>
                    @endif

                    {{-- Tombol hapus untuk admin dan karyawan --}}
                    <div class="d-flex gap-2">
                        {{-- Jika karyawan yang menulis --}}
                        @if(auth()->user()->role === 'karyawan' && auth()->user()->id === $item->user_id)
                            <form action="{{ route('kritik_saran.destroy', $item->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kritik/saran ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif

                        {{-- Jika admin --}}
                        @if(auth()->user()->role === 'admin')
                            <form action="{{ route('kritik_saran.destroy', $item->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus kritik/saran ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada kritik atau saran.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection