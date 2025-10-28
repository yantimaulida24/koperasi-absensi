@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4 fw-bold">Dashboard</h3>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow p-3">
                <h6>Total Pengguna</h6>
                <h2>{{ $totalPengguna }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success shadow p-3">
                <h6>Total Karyawan</h6>
                <h2>{{ $totalKaryawan }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-info shadow p-3">
                <h6>Masuk Hari Ini ✅</h6>
                <h2>{{ $totalMasuk }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-danger shadow p-3">
                <h6>Tidak Masuk ❌</h6>
                <h2>{{ $totalTidakMasuk }}</h2>
            </div>
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header fw-bold">
            Grafik Absensi Mingguan 📊
        </div>
        <div class="card-body">
            <canvas id="chartAbsensi"></canvas>
        </div>
    </div>

    <div class="card shadow mt-4 mb-5">
        <div class="card-header fw-bold">
            Absensi Terbaru 📝
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensiTerbaru as $absen)
                    <tr>
                        <td>{{ $absen->user->name }}</td>
                        <td>{{ $absen->status }}</td>
                        <td>{{ $absen->created_at->format('H:i d-m-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartAbsensi');
    const chartAbsensi = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labelMinggu),
            datasets: [
                {
                    label: 'Masuk',
                    data: @json($dataMasuk),
                },
                {
                    label: 'Tidak Masuk',
                    data: @json($dataTidakMasuk),
                }
            ]
        },
    });
</script>

@endsection
