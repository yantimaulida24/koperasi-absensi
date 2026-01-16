@extends('layouts.app')

@section('content')
<div class="card dashboard-card">
    <div class="card-header dashboard-header">
        Dashboard
    </div>

    <div class="card-body">
        <h5 class="fw-bold text-dark">
            Selamat datang, <span class="text-primary">{{ Auth::user()->name }}</span> 👋
        </h5>
        <p class="text-muted mb-0">
            Anda berhasil login ke sistem absensi karyawan.
        </p>
    </div>
</div>
@endsection
