<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Sistem | SIABSARKBAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: radial-gradient(circle at top,
                #1b3a2f,
                #0f2a24,
                #081c1a
            );
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            width: 900px;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.45);
        }

        .login-left {
            background:
                linear-gradient(
                    rgba(10, 45, 30, 0.65),
                    rgba(10, 45, 30, 0.65)
                ),
                url('{{ asset("images/kebun-sawit.jpeg") }}');
            background-size: cover;
            background-position: center;
            color: #f1f5f3;
            padding: 45px;
        }

        .login-right {
            padding: 45px;
        }

        @media (max-width: 768px) {
            .login-left { display: none; }
            .login-card { width: 100%; margin: 20px; }
        }
    </style>
</head>
<body>

<div class="login-card row g-0">

    <!-- LEFT SIDE -->
    <div class="col-md-6 login-left d-flex flex-column justify-content-center">
        <h2>SIABSARKBAS</h2>
        <p>Sistem Informasi Absensi Berbasis QR Code</p>
        <small>© {{ date('Y') }} SIABSARKBAS</small>
    </div>

    <!-- RIGHT SIDE -->
    <div class="col-md-6 login-right">

        <h4 class="text-center mb-4">Pilih Sistem</h4>

        <p class="text-center text-muted">
            Login sebagai:
            <strong>{{ auth()->user()->role }}</strong>
        </p>

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <div class="d-grid gap-3 mt-4">

            {{-- DATABASE --}}
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('masuk.database') }}"
                   class="btn btn-success py-3">
                    🗄️ Sistem Database
                    <br><small>(Admin)</small>
                </a>
            @endif

            {{-- ABSENSI --}}
            @if(auth()->user()->role === 'karyawan')
                <a href="{{ route('masuk.absensi') }}"
                   class="btn btn-success py-3">
                    📸 Sistem Absensi
                    <br><small>(Karyawan)</small>
                </a>
            @endif

        </div>

    </div>

</div>

</body>
</html>