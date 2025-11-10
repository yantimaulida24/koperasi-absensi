@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-center">✍️ Tambah Kritik / Saran</h3>

    {{-- Pesan sukses atau error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('kritik_saran.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="isi" class="form-label fw-bold">Isi Kritik / Saran</label>
                    <textarea 
                        name="isi" 
                        id="isi" 
                        class="form-control @error('isi') is-invalid @enderror" 
                        rows="4" 
                        placeholder="Tuliskan kritik atau saran Anda di sini..."
                        required>{{ old('isi') }}</textarea>

                    @error('isi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="text-end">
                    <a href="{{ route('kritik_saran.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection