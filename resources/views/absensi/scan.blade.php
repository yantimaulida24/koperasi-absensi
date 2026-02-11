@extends('layouts.scan')

@section('content')

{{-- ALERT --}}
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

<h4 class="text-center mb-1">📸 Scan QR Code Absensi</h4>
<p class="text-center text-muted mb-2">Arahkan kamera ke QR Code</p>

{{-- AREA KAMERA --}}
<div id="reader" class="qr-reader"></div>

<form method="POST" action="{{ route('absen.proses') }}" id="formScan">
    @csrf
    <input type="hidden" name="kode_qr" id="kode_qr">
</form>

<p class="mt-2 text-center" id="status">📷 Menyiapkan kamera...</p>

{{-- CSS --}}
<style>
.qr-reader {
    width: 100%;
    height: 75vh;
    max-height: 520px;
    background: #000;
    margin: auto;
    border-radius: 12px;
    overflow: hidden;
}

/* Samakan tampilan kamera depan & belakang */
#reader video {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}
</style>

{{-- SCRIPT --}}
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
let sudahScan = false;
const statusEl = document.getElementById('status');
const html5QrCode = new Html5Qrcode("reader");

// CONFIG SCAN RESPONSIVE
const config = {
    fps: 10,
    qrbox: (vw, vh) => {
        let size = Math.min(vw, vh) * 0.65;
        return { width: size, height: size };
    },
    aspectRatio: 1.0
};

// START KAMERA BELAKANG
html5QrCode.start(
    { facingMode: "environment" },
    config,
    (decodedText) => {
        if (sudahScan) return;
        sudahScan = true;

        let kode = decodedText
            .replace(/\s+/g, '')
            .toUpperCase();

        document.getElementById('kode_qr').value = kode;
        document.getElementById('formScan').submit();

        statusEl.innerText = "⏳ Memproses absensi...";
        statusEl.style.color = "blue";

        html5QrCode.stop();
    }
).then(() => {
    statusEl.innerText = "📸 Kamera aktif, silakan scan QR";
    statusEl.style.color = "green";
}).catch(err => {
    statusEl.innerText = "❌ Kamera gagal dijalankan";
    statusEl.style.color = "red";
    console.error(err);
});
</script>

@endsection
