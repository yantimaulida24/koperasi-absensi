<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Absensi Karyawan</title>

    <!-- Font & Style -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Layout penuh layar */
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
            background-color: #f8f9fc;
        }

        /* Struktur utama */
        #wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar tetap di kiri dan tidak ikut scroll */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 230px;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
        }

        /* Konten utama di kanan */
        #content-wrapper {
            margin-left: 230px;
            width: calc(100% - 230px);
            overflow-y: auto;
            height: 100vh;
            background-color: #f8f9fc;
            display: flex;
            flex-direction: column;
        }

        /* Hapus jarak putih di atas konten */
        #content {
            flex: 1;
            margin: 0;
            padding: 0;
        }

        /* Navbar agar menempel di atas */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 999;
            margin: 0;
            border-bottom: 1px solid #e3e6f0;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* Konten isi halaman */
        .container-fluid {
            padding: 25px 30px;
        }
    </style>
</head>

<body id="page-top">

<div id="wrapper">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Konten utama --}}
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            {{-- Navbar --}}
            @include('layouts.navbar')

            {{-- Isi halaman --}}
            <div class="container-fluid">
                @yield('content')
            </div>

        </div>

    </div>
</div>

<!-- Script -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>
</html>