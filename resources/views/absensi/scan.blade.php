@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h3 class="fw-bold mb-4">Scan QR Absensi</h3>

    <!-- AREA KAMERA -->
    <div id="reader" style="
        width: 320px;
        margin: auto;
        border: 2px solid #0d6efd;
        padding: 10px;
        border-radius: 8px;
    "></div>

    <p class="text-muted mt-3">
        Arahkan kamera ke QR Code karyawan
    </p>

    <!-- FORM TERSEMBUNYI -->
    <form id="form-absensi" action="{{ route('absen.proses') }}" method="POST">
        @csrf
        <input type="hidden" name="qr_code" id="qr_code">
    </form>
</div>

<!-- LIBRARY QR SCANNER -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    const qrCodeScanner = new Html5Qrcode("reader");

    qrCodeScanner.start(
        { facingMode: "environment" }, // kamera belakang
        {
            fps: 10,
            qrbox: 250
        },
        (decodedText) => {
            // isi input hidden dengan hasil scan
            document.getElementById('qr_code').value = decodedText;

            // kirim otomatis
            document.getElementById('form-absensi').submit();

            // matikan kamera
            qrCodeScanner.stop();
        },
        (errorMessage) => {
            // error diabaikan biar ga spam
        }
    );
</script>
@endsection