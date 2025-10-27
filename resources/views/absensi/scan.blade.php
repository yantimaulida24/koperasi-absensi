<!DOCTYPE html>
<html>
<head>
    <title>Scan QR Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5 text-center">
    <h3>Scan QR Karyawan untuk Absensi</h3>
    <div id="reader" style="width:300px; margin:auto;"></div>
    <h5 id="result" class="mt-3 text-success"></h5>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const scanner = new Html5Qrcode("reader");

    scanner.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        qrCodeMessage => {
            fetch(`/absensi/konfirmasi?kode=${qrCodeMessage}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        document.getElementById('result').innerText = data.message;
                    } else {
                        document.getElementById('result').innerText = "QR tidak valid!";
                    }
                });
        },
        errorMessage => {}
    );
</script>
</body>
</html>
