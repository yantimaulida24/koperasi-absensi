@extends('layouts.app')

@section('content')
<div class="container">

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table custom-table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Total Jam</th>
                    <th>Status</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($karyawan as $k)
                    @php
                        $absen = $absensi->firstWhere('id_karyawan', $k->id_karyawan);
                    @endphp

                    <tr>

                        {{-- NOMOR --}}
                        <td>{{ $loop->iteration }}</td>

                        {{-- NAMA --}}
                        <td>{{ $k->nama_karyawan }}</td>

                        {{-- TANGGAL --}}
                        <td>
                            {{ $absen 
                                ? \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') 
                                : \Carbon\Carbon::now()->format('d-m-Y') 
                            }}
                        </td>

                        {{-- MASUK --}}
                        <td>
                            {{ $absen && $absen->waktu_masuk 
                                ? \Carbon\Carbon::parse($absen->waktu_masuk)->format('H:i') 
                                : '-' 
                            }}
                        </td>

                        {{-- KELUAR --}}
                        <td>
                            {{ $absen && $absen->waktu_keluar 
                                ? \Carbon\Carbon::parse($absen->waktu_keluar)->format('H:i') 
                                : '-' 
                            }}
                        </td>

                        {{-- TOTAL JAM --}}
                        <td>
                            @if($absen && $absen->total_jam_kerja && $absen->waktu_keluar)
                                @php
                                    $jam = floor($absen->total_jam_kerja);
                                    $menit = round(($absen->total_jam_kerja - $jam) * 60);
                                @endphp
                                <span class="badge bg-secondary">
                                    {{ $jam }}j {{ $menit }}m
                                </span>
                            @else
                                -
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($absen && $absen->waktu_masuk && $absen->waktu_keluar)
                                <span class="badge bg-success">Selesai</span>
                            @elseif($absen && $absen->waktu_masuk)
                                <span class="badge bg-info text-dark">Bekerja</span>
                            @else
                                <span class="badge bg-danger">Belum</span>
                            @endif
                        </td>

                        {{-- FOTO --}}
                        <td>
                            @if($absen && $absen->foto_absen)
                                <img 
                                    src="data:image/png;base64,{{ $absen->foto_absen }}" 
                                    width="60"
                                    style="border-radius:6px;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td>
                            @if(!$absen || !$absen->waktu_keluar)
                                <a href="{{ route('absen.scan', $k->id_karyawan) }}" 
                                   class="btn btn-sm btn-primary"
                                   title="Scan Absensi">
                                    <i class="fas fa-qrcode"></i> Scan
                                </a>
                            @else
                                <i class="fas fa-check-circle text-success" title="Selesai"></i>
                            @endif
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            Belum ada data karyawan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- AUTO REFRESH --}}
<script>
    setInterval(function(){
        location.reload();
    }, 10000);
</script>

@endsection