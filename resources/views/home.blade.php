@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Statistik Cards -->
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm border-0 rounded-3">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Total Pengguna</h6>
                    <h2 class="fw-bold mt-2">{{ $totalPengguna }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm border-0 rounded-3">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Total Karyawan</h6>
                    <h2 class="fw-bold mt-2">{{ $totalKaryawan }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm border-0 rounded-3">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Masuk Hari Ini ✅</h6>
                    <h2 class="fw-bold mt-2">{{ $totalMasuk }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white shadow-sm border-0 rounded-3">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Tidak Masuk ❌</h6>
                    <h2 class="fw-bold mt-2">{{ $totalTidakMasuk }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Absensi -->
    <div class="card shadow-sm border-0 mt-5">
        <div class="card-header bg-white fw-bold text-primary">
            <i class="fas fa-chart-bar me-2"></i> Grafik Absensi Mingguan 📊
        </div>
        <div class="card-body">
            <canvas id="chartAbsensi" height="100"></canvas>
        </div>
    </div>

    <!-- Absensi Terbaru -->
    <div class="card shadow-sm border-0 mt-4 mb-5">
        <div class="card-header bg-white fw-bold text-primary">
            <i class="fas fa-clipboard-list me-2"></i> Absensi Terbaru 📝
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>Status</th>
                            <th>Waktu Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensiTerbaru as $absen)
                        <tr class="text-center">
                            <td>{{ $absen->karyawan->nama_karyawan ?? 'Tidak Diketahui' }}</td>
                            <td>
                                @if($absen->status == 'Masuk')
                                    <span class="badge bg-success">Masuk</span>
                                @else
                                    <span class="badge bg-danger">Tidak Masuk</span>
                                @endif
                            </td>
                            <td>
                                {{ $absen->waktu_masuk ? \Carbon\Carbon::parse($absen->waktu_masuk)->format('H:i - d M Y') : '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada data absensi terbaru</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartAbsensi');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labelMinggu),
            datasets: [
                {
                    label: 'Masuk',
                    data: @json($dataMasuk),
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderRadius: 5
                },
                {
                    label: 'Tidak Masuk',
                    data: @json($dataTidakMasuk),
                    backgroundColor: 'rgba(255, 99, 132, 0.8)',
                    borderRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
