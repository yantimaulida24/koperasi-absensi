@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Absensi</h2>

    <div class="card p-4">
        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf

            <!-- Pilih Karyawan -->
            <div class="mb-3">
                <label for="user_id" class="form-label">Karyawan</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal & Jam Masuk otomatis -->
            <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="jam_masuk" value="{{ date('H:i:s') }}">
            <input type="hidden" name="status" value="Hadir">

            <button type="submit" class="btn btn-success">Simpan Absensi</button>
        </form>
    </div>
</div>
@endsection
