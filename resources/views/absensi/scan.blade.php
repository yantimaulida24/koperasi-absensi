@extends('layouts.scan')

@section('content')

@if(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
@endif

<h4 class="text-center mb-3">📸 Scan QR Code Absensi</h4>
<p class="text-center text-muted">Arahkan kamera ke QR Code</p>

<div id="reader" style="width:100%; max-width:400px; margin:auto;"></div>

<form method="POST" action="{{ route('absen.proses') }}" id="formScan">
    @csrf
    <input type="hidden" name="kode_qr" id="kode_qr">
</form>

<p class="mt-3 text-center" id="status"></p>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
let sudahScan = false;
const statusEl = document.getElementById('status');
const html5QrCode = new Html5Qrcode("reader");

// 🚀 PAKSA KAMERA BELAKANG
html5QrCode.start(
    { facingMode: { exact: "environment" } }, // 👈 FIX UTAMA
    {
        fps: 10,
        qrbox: 250
    },
    (decodedText) => {
        if (sudahScan) return;
        sudahScan = true;

        statusEl.innerText = "⏳ Memproses absensi...";
        statusEl.style.color = "blue";

        document.getElementById('kode_qr').value = decodedText.trim();
        document.getElementById('formScan').submit();

        html5QrCode.stop(); // stop kamera setelah scan
    },
    (error) => {
        // abaikan error scan kecil
    }
).catch(err => {
    statusEl.innerText = "❌ Kamera tidak bisa diakses. Pastikan izin kamera aktif.";
    statusEl.style.color = "red";
    console.error(err);
});
</script>

@endsection
