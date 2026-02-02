@php
    $user = auth()->user();

    // ================== JUDUL HALAMAN BERDASARKAN ROUTE ==================
    if (request()->routeIs('dashboard')) {
        $pageTitle = 'Dashboard';

    } elseif (request()->routeIs('data-karyawan.*')) {
        $pageTitle = 'Data Karyawan';

    } elseif (request()->routeIs('jabatan.*')) {
        $pageTitle = 'Data Jabatan';

    } elseif (
        request()->routeIs('absensi.*') ||
        request()->routeIs('absen.*')
    ) {
        $pageTitle = 'Data Absensi';

    } elseif (request()->routeIs('jadwal.*')) {
        $pageTitle = 'Jadwal Kerja';

    } elseif (request()->routeIs('permohonan-cuti.*')) {
        $pageTitle = 'Permohonan Cuti';

    } elseif (request()->routeIs('laporan.*')) {
        $pageTitle = 'Laporan Absensi';

    } elseif (request()->routeIs('kritik_saran.*')) {
        $pageTitle = 'Kritik & Saran';

    } else {
        $pageTitle = '';
    }
@endphp

<!-- ================== NAVBAR ================== -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Toggle Sidebar (Mobile) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- JUDUL HALAMAN -->
    <h5 class="mb-0 font-weight-bold navbar-title">
        {{ $pageTitle }}
    </h5>

    <!-- Right Menu -->
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- USER DROPDOWN -->
        <li class="nav-item dropdown no-arrow">

            <a class="nav-link dropdown-toggle"
               href="#"
               id="userDropdown"
               role="button"
               data-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false">

                <!-- NAMA USER -->
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ $user->nama_pengguna ?? $user->name ?? 'User' }}
                </span>

                <!-- FOTO USER -->
                <img class="img-profile rounded-circle"
                     src="{{ $user->foto
                            ? asset('storage/' . $user->foto)
                            : 'https://cdn-icons-png.flaticon.com/512/847/847969.png' }}"
                     width="35"
                     height="35">
            </a>

            <!-- DROPDOWN MENU -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">

                <!-- ROLE USER -->
                <span class="dropdown-item-text text-gray-700">
                    <i class="fas fa-user-tag fa-sm fa-fw mr-2 text-gray-400"></i>
                    Login sebagai:
                    <strong class="text-uppercase">
                        {{ $user->role }}
                    </strong>
                </span>

                <div class="dropdown-divider"></div>

                <!-- LOGOUT -->
                <a class="dropdown-item text-danger"
                   href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    Logout
                </a>

                <form id="logout-form"
                      action="{{ route('logout') }}"
                      method="POST"
                      class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>
</nav>
<!-- ================== END NAVBAR ================== -->

<!-- STYLE KHUSUS JUDUL NAVBAR -->
<style>
    .navbar-title {
        color: #1b3a2f;
        font-size: 18px;
        letter-spacing: 0.5px;
    }
</style>