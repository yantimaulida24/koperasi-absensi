<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Scan QR Absensi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Library QR Scanner -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 15px;
        }
        #reader {
            width: 100%;
            max-width: 350px;
            margin: auto;
        }
    </style>
</head>
<body>

<h3>📷 Scan QR Code Absensi</h3>
<p>Arahkan kamera ke QR Code</p>

<div id="reader"></div>
<p id="status"></p>

<script>
    function onScanSuccess(decodedText) {
        document.getElementById('status').innerHTML = "⏳ Memproses absensi...";

        fetch("{{ url('/absen/proses') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                kode_qr: decodedText
            })
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            document.getElementById('status').innerHTML = data.message;
        })
        .catch(err => {
            alert("Gagal scan");
            console.error(err);
        });
    }

    const html5QrCode = new Html5Qrcode("reader");

    html5QrCode.start(
        { facingMode: "environment" }, // kamera belakang
        {
            fps: 10,
            qrbox: 250
        },
        onScanSuccess
    ).catch(err => {
        document.getElementById('status').innerHTML =
            "❌ Kamera tidak bisa diakses: " + err;
    });
</script>

</body>
</html>
