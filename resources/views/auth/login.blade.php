<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | SIABSAR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
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

        .login-left h2 {
            font-size: 34px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-left p {
            font-size: 15px;
            opacity: .9;
        }

        .login-right {
            padding: 45px;
        }

        .role-btn .btn {
            width: 50%;
            border-radius: 0;
        }

        .role-btn .btn-primary {
            background-color: #1b5e20;
            border-color: #1b5e20;
        }

        .role-btn .btn-outline-primary {
            color: #1b5e20;
            border-color: #1b5e20;
        }

        .role-btn .btn-outline-primary:hover {
            background-color: #e8f5e9;
        }

        .btn-login {
            background: linear-gradient(135deg, #2e7d32, #1b5e20);
            border: none;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1b5e20, #0d3d14);
        }

        @media (max-width: 768px) {
            .login-left {
                display: none;
            }
            .login-card {
                width: 100%;
                margin: 20px;
            }
        }
    </style>
</head>
<body>

<div class="login-card row g-0">
    <!-- KIRI -->
    <div class="col-md-6 login-left d-flex flex-column justify-content-center">
        <h2>SIABSAR</h2>
        <p>
            Sistem Informasi Absensi Berbasis QR Code
        </p>
        <small>© {{ date('Y') }} SIABSAR</small>
    </div>

    <!-- KANAN -->
    <div class="col-md-6 login-right">
        <h4 class="text-center mb-4">Selamat Datang Kembali</h4>

        <!-- PILIH ROLE -->
        <div class="btn-group role-btn w-100 mb-4">
            <button type="button" class="btn btn-primary" onclick="setRole('admin', this)">Admin</button>
            <button type="button" class="btn btn-outline-primary" onclick="setRole('karyawan', this)">Karyawan</button>
        </div>

        <!-- FORM LOGIN -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Input role hidden -->
            <input type="hidden" name="role" id="login-role" value="admin">

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="email@example.com"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="••••••••"
                    required
                >
            </div>

            <button class="btn btn-login text-white w-100 py-2 mt-2">
                Login
            </button>
        </form>
    </div>
</div>

<!-- Script untuk toggle role -->
<script>
function setRole(role, btn) {
    // Update hidden input
    document.getElementById('login-role').value = role;

    // Update tampilan tombol
    let buttons = btn.parentElement.querySelectorAll('button');
    buttons.forEach(b => {
        b.classList.remove('btn-primary');
        b.classList.add('btn-outline-primary');
    });

    btn.classList.remove('btn-outline-primary');
    btn.classList.add('btn-primary');
}
</script>

</body>
</html>
