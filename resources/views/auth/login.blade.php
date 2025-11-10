<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIABSAR</title>

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-image: url("{{ asset('images/kebun-sawit.jpeg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Tulisan judul di luar box */
        .judul {
            text-align: center;
            color: #ffffff;
            margin-bottom: 25px;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
        }

        .judul h2 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 28px;
        }

        .judul h5 {
            font-weight: 500;
            color: #f0f0f0;
            font-size: 18px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 18px;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.2);
            width: 400px;
            padding: 30px;
            text-align: center;
        }

        .card h4 {
            color: #003366;
            font-weight: 700;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        .btn-primary {
            background-color: #003366;
            border: none;
            border-radius: 10px;
            padding: 10px 0;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #004c99;
        }
    </style>
</head>
<body>

    <!-- Tulisan di luar box -->
    <div class="judul">
        <h2>Koperasi Borneo Agrosindo Sentosa</h2>
    </div>

    <!-- Box login -->
    <div class="card shadow-lg">
        <h4>SIABSAR</h4> <!-- SIABSAR di dalam box -->

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group mb-3 text-start">
                <label for="email" class="fw-semibold">Email</label>
                <input id="email" type="email" class="form-control" name="email" placeholder="Masukkan email anda" required autofocus>
            </div>

            <div class="form-group mb-4 text-start">
                <label for="password" class="fw-semibold">Password</label>
                <input id="password" type="password" class="form-control" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <!-- SB Admin 2 JS -->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>
</html>
