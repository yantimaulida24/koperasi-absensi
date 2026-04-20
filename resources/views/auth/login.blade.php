<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | SIABSAR</title>
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
    <div class="col-md-6 login-left d-flex flex-column justify-content-center">
        <h2>SIABSARKBAS</h2>
        <p>Sistem Informasi Absensi Berbasis QR Code</p>
        <small>© {{ date('Y') }} SIABSARKBAS</small>
    </div>

    <div class="col-md-6 login-right">
        <h4 class="text-center mb-4">Selamat Datang Kembali</h4>

        {{-- 🔥 ALERT ERROR --}}
        @if ($errors->has('email'))
            <div class="alert alert-danger text-center">
                Email atau password salah
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- EMAIL --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    required>
            </div>

            {{-- PASSWORD --}}
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password"
                    class="form-control @error('email') is-invalid @enderror"
                    required>
            </div>

            <button class="btn btn-success w-100 py-2 mt-2">
                Login
            </button>
        </form>
    </div>
</div>

</body>
</html>