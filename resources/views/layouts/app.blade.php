<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel Absensi') }}</title>

    <!-- Bootstrap 5 via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Optional: Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
      body {
        background-color: #f5f6fa;
      }
      .navbar {
        background-color: #0d6efd;
      }
      .navbar-brand, .nav-link, .nav-item a {
        color: white !important;
      }
      footer {
        background-color: #0d6efd;
        color: white;
        text-align: center;
        padding: 10px 0;
        margin-top: 40px;
      }
    </style>
  </head>

  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand fw-bold" href="#">Absensi Karyawan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            @auth
              <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('absensi.index') }}">Absensi</a></li>
              <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="btn btn-link nav-link" type="submit">Logout</button>
                </form>
              </li>
            @endauth

            @guest
              <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>

    <!-- Content -->
    <main class="py-4 container">
      @yield('content')
    </main>

    <!-- Footer -->
    <footer>
      <div class="container">
        <p class="mb-0">&copy; {{ date('Y') }} Sistem Absensi Karyawan - Laravel</p>
      </div>
    </footer>
  </body>
</html>
