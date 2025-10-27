@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-primary text-white fw-bold">Dashboard</div>
  <div class="card-body">
    <h5>Selamat datang, {{ Auth::user()->name }} 👋</h5>
    <p>Anda berhasil login ke sistem absensi karyawan.</p>
  </div>
</div>
@endsection
