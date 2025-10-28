<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Logo Aplikasi -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-text mx-3">Absensi</div>
    </a>

    <hr class="sidebar-divider">

    <!-- Menu Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Menu Absensi (bisa diakses semua yang login) -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/absensi') }}">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Absensi</span>
        </a>
    </li>

    <!-- Menu Data Karyawan khusus role admin -->
    @if(Auth::check() && Auth::user()->role === 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('karyawan.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Karyawan</span>
        </a>
    </li>
    @endif

    <hr class="sidebar-divider">
</ul>
