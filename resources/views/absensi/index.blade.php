@extends('layouts.app')

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table custom-table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama Karyawan</th>
                    <th>Tanggal</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Total Jam Kerja</th>
                    <th>Status</th>
                    <th>Foto Selfie</th> {{-- TAMBAHAN --}}
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $item)
                    <tr>
                        <td>{{ $item->karyawan->nama_karyawan ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->waktu_masuk ?? '-' }}</td>
                        <td>{{ $item->waktu_keluar ?? '-' }}</td>

                        {{-- TOTAL JAM KERJA --}}
                        <td>
                            @if($item->total_jam_kerja !== null && $item->waktu_keluar)
                                @php
                                    $jam = floor($item->total_jam_kerja);
                                    $menit = round(($item->total_jam_kerja - $jam) * 60);
                                @endphp
                                {{ $jam }} jam {{ $menit }} menit
                            @else
                                -
                            @endif
                        </td>

                        <td>{{ $item->status }}</td>

                        {{-- FOTO SELFIE --}}
                        <td>
                            @if($item->foto_absen)
                                <img 
                                    src="data:image/png;base64,{{ $item->foto_absen }}" 
                                    width="70"
                                    style="border-radius:8px;">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Belum ada data absensi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection