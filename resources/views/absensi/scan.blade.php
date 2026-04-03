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

{{-- AREA KAMERA QR --}}
<div id="reader" class="qr-reader"></div>

{{-- KAMERA SELFIE --}}
<video id="selfieCamera" autoplay playsinline style="display:none;"></video>
<canvas id="canvasSelfie" style="display:none;"></canvas>

<form method="POST" action="{{ route('absen.proses') }}" id="formScan">
    @csrf
    <input type="hidden" name="kode_qr" id="kode_qr">
    <input type="hidden" name="foto_absen" id="foto_absen">
</form>

<p class="mt-2 text-center" id="status">📷 Menyiapkan kamera...</p>

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

#reader video {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}
</style>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>

let sudahScan = false;
const statusEl = document.getElementById('status');
const html5QrCode = new Html5Qrcode("reader");

const selfieVideo = document.getElementById('selfieCamera');
const canvas = document.getElementById('canvasSelfie');


// ======================
// AKTIFKAN KAMERA SELFIE
// ======================
navigator.mediaDevices.getUserMedia({
    video: { facingMode: "user" }
}).then(stream => {
    selfieVideo.srcObject = stream;
}).catch(err => {
    console.log("Selfie camera error", err);
});


// ======================
// SELFIE KAMERA DEPAN (FIX)
// ======================
async function ambilSelfieDepan(){

    try {

        const streamSelfie = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: "user" }
        });

        selfieVideo.srcObject = streamSelfie;

        await new Promise(resolve => {
            selfieVideo.onloadedmetadata = () => {
                resolve();
            };
        });

        const context = canvas.getContext('2d');

        canvas.width = selfieVideo.videoWidth;
        canvas.height = selfieVideo.videoHeight;

        context.drawImage(selfieVideo, 0, 0, canvas.width, canvas.height);

        const imageData = canvas.toDataURL('image/png');

        document.getElementById('foto_absen').value = imageData;

        // matikan kamera setelah foto
        streamSelfie.getTracks().forEach(track => track.stop());

        return imageData; // 🔥 tambahan penting

    } catch (err) {

        console.log("Gagal mengambil selfie:", err);
        return null;

    }

}


// CONFIG SCAN RESPONSIVE
const config = {
    fps: 10,
    qrbox: (vw, vh) => {
        let size = Math.min(vw, vh) * 0.65;
        return { width: size, height: size };
    },
    aspectRatio: 1.0
};


// ======================
// START SCAN
// ======================
html5QrCode.start(
    { facingMode: "environment" },
    config,
    (decodedText) => {

        if (sudahScan) return;
        sudahScan = true;

        let kode = decodedText
            .replace(/\s+/g, '')
            .toUpperCase();

        // 🔥 PERBAIKAN DI SINI
        (async () => {

            await ambilSelfieDepan(); // tunggu foto selesai

            document.getElementById('kode_qr').value = kode;

            statusEl.innerText = "📸 Mengambil foto & memproses absensi...";
            statusEl.style.color = "blue";

            setTimeout(() => {
                document.getElementById('formScan').submit();
            }, 500);

        })();

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