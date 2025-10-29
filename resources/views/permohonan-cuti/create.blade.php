@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-bold">Ajukan Permohonan Cuti</h3>

    <form action="{{ route('permohonan-cuti.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Alasan</label>
            <textarea name="alasan" class="form-control" rows="3" required></textarea>
        </div>
        <button class="btn btn-primary">Ajukan</button>
    </form>
</div>
@endsection
