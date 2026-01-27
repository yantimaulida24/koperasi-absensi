<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Sistem Absensi Karyawan
        @if (trim($__env->yieldContent('title')))
            | @yield('title')
        @endif
    </title>

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- SB ADMIN 2 -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* ================= BASIC LAYOUT ================= */
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        #wrapper {
            display: flex;
            height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            position: fixed;
            height: 100vh;
            background: linear-gradient(180deg, #0f2a24, #164a41, #1f6f63);
            box-shadow: 3px 0 15px rgba(0,0,0,.25);
        }

        /* CONTENT */
        #content-wrapper {
            margin-left: 230px;
            width: calc(100% - 230px);
            display: flex;
            flex-direction: column;
            background-color: #f4f6f9;
        }

        #content {
            flex: 1;
            overflow-y: auto;
        }

        /* NAVBAR */
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e3e6f0;
            box-shadow: 0 4px 10px rgba(0,0,0,.06);
        }

        .container-fluid {
            padding: 30px;
        }

        /* ================= TABLE GLOBAL STYLE ================= */
        .table,
        .custom-table,
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            font-size: 14px;
            color: #212529;
        }

        .table th,
        .table td,
        .custom-table th,
        .custom-table td,
        .table-custom th,
        .table-custom td {
            border: 1px solid #dee2e6;
            padding: 10px 12px;
            vertical-align: middle;
        }

        .table thead th,
        .custom-table thead th,
        .table-custom thead th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            text-align: center;
            border-bottom: 2px solid #ced4da;
        }

        .table tbody tr:hover,
        .custom-table tbody tr:hover,
        .table-custom tbody tr:hover {
            background-color: #f1f3f5;
        }

        /* Kolom aksi */
        .table td:last-child,
        .custom-table td:last-child,
        .table-custom td:last-child {
            text-align: center;
            white-space: nowrap;
        }

        /* ================= BUTTON ================= */
        .btn {
            border-radius: 6px;
            font-size: 13px;
            padding: 6px 12px;
        }

        .btn-jabatan {
            background-color: #1b5e20;
            color: #ffffff;
            font-weight: 500;
            border: none;
        }

        .btn-jabatan:hover {
            background-color: #154a19;
            color: #ffffff;
        }

        /* ================= SWITCH / TOGGLE ================= */
        .form-switch .form-check-input {
            width: 42px;
            height: 20px;
            cursor: pointer;
        }

        .form-switch .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</head>

<body id="page-top">

<div id="wrapper">

    {{-- SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- CONTENT --}}
    <div id="content-wrapper">

        <div id="content">

            {{-- NAVBAR --}}
            @include('layouts.navbar')

            {{-- PAGE TITLE --}}
            @if (trim($__env->yieldContent('title')))
                <div class="container-fluid pb-0">
                    <h1 class="h3 mb-4 text-gray-800">
                        @yield('title')
                    </h1>
                </div>
            @endif

            {{-- PAGE CONTENT --}}
            <div class="container-fluid pt-0">
                @yield('content')
            </div>

        </div>

    </div>

</div>

<!-- SCRIPT -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></cript>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>
</html>