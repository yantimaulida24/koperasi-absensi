@extends('layouts.app')

@section('content')

<style>
.card-link {
    text-decoration: none;
}

.card-link .card {
    transition: transform .2s ease, box-shadow .2s ease;
}

.card-link .card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,.15);
}
</style>

<div class="container-fluid py-4">

    <!-- =======================
         STATISTIK CARDS
    ======================== -->
    <div class="row g-3">

        {{-- 👑 ADMIN ONLY --}}
        @if(auth()->user()->role === 'admin')

        <div class="col-md-3">
            <a href="{{ route('akun.index') }}" class="card-link">
                <div class="card shadow-sm border-0 rounded-3" style="background-color:#1b5e20; color:#fff;">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Total Pengguna</h6>
                        <h2 class="fw-bold mt-2">{{ $totalPengguna }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('data-karyawan.index') }}" class="card-link">
                <div class="card shadow-sm border-0 rounded-3" style="background-color:#2e7d32; color:#fff;">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Total Karyawan</h6>
                        <h2 class="fw-bold mt-2">{{ $totalKaryawan }}</h2>
                    </div>
                </div>
            </a>
        </div>

        @endif

    </div>

    <!-- =======================
         CENTER CARD (HADIR + CUTI)
    ======================== -->
    <div class="row g-3 justify-content-center mt-2">

        <div class="col-md-3">
            <a href="{{ route('absensi.index') }}" class="card-link">
                <div class="card shadow-sm border-0 rounded-3" style="background-color:#81c784; color:#000;">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Hadir Hari Ini ✅</h6>
                        <h2 class="fw-bold mt-2">{{ $totalHadir }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('permohonan-cuti.index') }}" class="card-link">
                <div class="card shadow-sm border-0 rounded-3" style="background-color:#ffb300; color:#000;">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Permohonan Cuti 📄</h6>
                        <h2 class="fw-bold mt-2">{{ $totalPermohonan }}</h2>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- =======================
         ABSENSI TERBARU
    ======================== -->
    <div class="card shadow-sm border-0 mt-4 mb-5">
        <div class="card-header bg-white fw-bold text-primary">
            <i class="fas fa-clipboard-list me-2"></i> Absensi Terbaru 📝
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-success text-center">
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Total Jam Kerja</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($absensiTerbaru as $absen)
                        <tr class="text-center">
                            <td>{{ $absen->karyawan->nama_karyawan ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>

                            <td>
                                @if($absen->status == 'Hadir')
                                    <span class="badge bg-success">{{ $absen->status }}</span>
                                @elseif($absen->status == 'Izin')
                                    <span class="badge bg-warning text-dark">{{ $absen->status }}</span>
                                @elseif($absen->status == 'Sakit')
                                    <span class="badge bg-danger">{{ $absen->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $absen->status }}</span>
                                @endif
                            </td>

                            <td>{{ $absen->waktu_masuk ?? '-' }}</td>
                            <td>{{ $absen->waktu_keluar ?? '-' }}</td>

                            <td>
                                @if($absen->total_jam_kerja !== null && $absen->waktu_keluar)
                                    @php
                                        $jam = floor($absen->total_jam_kerja);
                                        $menit = round(($absen->total_jam_kerja - $jam) * 60);
                                    @endphp
                                    {{ $jam }} jam {{ $menit }} menit
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada data absensi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection