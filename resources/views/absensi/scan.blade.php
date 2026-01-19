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

<h4 class="text-center mb-2">📸 Scan QR Code Absensi</h4>
<p class="text-center text-muted">Arahkan kamera ke QR Code</p>

<div
    id="reader"
    style="width:100%; max-width:400px; height:300px; margin:auto; background:#000;">
</div>

<form method="POST" action="{{ route('absen.proses') }}" id="formScan">
    @csrf
    <input type="hidden" name="kode_qr" id="kode_qr">
</form>

<p class="mt-3 text-center" id="status">📷 Menyiapkan kamera...</p>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
let sudahScan = false;
const statusEl = document.getElementById('status');

Html5Qrcode.getCameras().then(devices => {
    if (!devices || devices.length === 0) {
        statusEl.innerText = "❌ Kamera tidak ditemukan";
        statusEl.style.color = "red";
        return;
    }

    const qr = new Html5Qrcode("reader");

    qr.start(
        devices[0].id,
        {
            fps: 10,
            qrbox: { width: 230, height: 230 }
        },
        (decodedText) => {
            if (sudahScan) return;
            sudahScan = true;

            // 🔥 NORMALISASI DI CLIENT
            let kode = decodedText
                .replace(/\s+/g, '')   // hapus spasi & newline
                .toUpperCase();

            document.getElementById('kode_qr').value = kode;
            document.getElementById('formScan').submit();

            statusEl.innerText = "⏳ Memproses absensi...";
            statusEl.style.color = "blue";

            qr.stop();
        }
    ).then(() => {
        statusEl.innerText = "📸 Kamera aktif, silakan scan QR";
        statusEl.style.color = "green";
    }).catch(err => {
        statusEl.innerText = "❌ Kamera gagal dijalankan";
        statusEl.style.color = "red";
        console.error(err);
    });

}).catch(err => {
    statusEl.innerText = "❌ Izin kamera ditolak browser";
    statusEl.style.color = "red";
    console.error(err);
});
</script>

@endsection