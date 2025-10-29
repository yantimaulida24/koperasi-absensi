@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-bold">Ubah Status Cuti</h3>

    <form action="{{ route('permohonan-cuti.update', $cuti->id_cuti) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Pending" {{ $cuti->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Disetujui" {{ $cuti->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Ditolak" {{ $cuti->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection