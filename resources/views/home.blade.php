@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- =======================
         STATISTIK CARDS
    ======================== -->
    <div class="row g-3">
        <!-- Total Pengguna -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-3" style="background-color:#1b5e20; color:#fff;">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Total Pengguna</h6>
                    <h2 class="fw-bold mt-2">{{ $totalPengguna }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Karyawan -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-3" style="background-color:#2e7d32; color:#fff;">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Total Karyawan</h6>
                    <h2 class="fw-bold mt-2">{{ $totalKaryawan }}</h2>
                </div>
            </div>
        </div>

        <!-- Hadir Hari Ini -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-3" style="background-color:#81c784; color:#000;">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Hadir Hari Ini ✅</h6>
                    <h2 class="fw-bold mt-2">{{ $totalHadir }}</h2>
                </div>
            </div>
        </div>

        <!-- Permohonan Cuti -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-3" style="background-color:#ffb300; color:#000;">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Permohonan Cuti 📄</h6>
                    <h2 class="fw-bold mt-2">{{ $totalPermohonan }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- =======================
         GRAFIK MINGGUAN
    ======================== -->
    <div class="card shadow-sm border-0 mt-5">
        <div class="card-header bg-white fw-bold text-primary">
            <i class="fas fa-chart-bar me-2"></i> Grafik Mingguan 📊
        </div>
        <div class="card-body">
            <canvas id="chartAbsensi" height="100"></canvas>
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensiTerbaru as $absen)
                        <tr class="text-center">
                            <td>{{ $absen->karyawan->nama_karyawan ?? '-' }}</td>
                            <td>{{ $absen->tanggal }}</td>
                            <td>
                                @if($absen->status == 'Hadir')
                                    <span class="badge" style="background-color:#2e7d32; color:#fff;">{{ $absen->status }}</span>
                                @elseif($absen->status == 'Izin')
                                    <span class="badge" style="background-color:#ffb300; color:#000;">{{ $absen->status }}</span>
                                @elseif($absen->status == 'Sakit')
                                    <span class="badge" style="background-color:#d32f2f; color:#fff;">{{ $absen->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $absen->status }}</span>
                                @endif
                            </td>
                            <td>{{ $absen->waktu_masuk ?? '-' }}</td>
                            <td>{{ $absen->waktu_keluar ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data absensi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- =======================
     CHART.JS
======================== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartAbsensi');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($labelMinggu),
        datasets: [
            {
                label: 'Hadir',
                data: @json($dataHadir),
                backgroundColor: 'rgba(33, 150, 83, 0.9)', // hijau sawit
                borderRadius: 6
            },
            {
                label: 'Permohonan Cuti',
                data: @json($dataPermohonan),
                backgroundColor: 'rgba(255, 179, 0, 1)', // oranye sawit
                borderRadius: 6
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            x: { ticks: { color: '#000', font: { weight: 'bold' } } },
            y: { ticks: { color: '#000', precision: 0, font: { weight: 'bold' } } }
        }
    }
});
</script>
@endsection
