<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Logo / Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIABSAR</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- ADMIN MENU -->
    @if(auth()->check() && auth()->user()->role === 'admin')
        <div class="sidebar-heading">Menu Admin</div>

                <!-- 💼 Data Jabatan -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('jabatan.index') }}">
                <i class="fas fa-fw fa-briefcase"></i>
                <span>Data Jabatan</span>
            </a>
        </li>

        <!-- 👥 Data Karyawan -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Data Karyawan</span>
            </a>
        </li>

        <!-- 🕒 Data Absensi -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('absensi.index') }}">
                <i class="fas fa-fw fa-calendar-check"></i>
                <span>Data Absensi</span>
            </a>
        </li>

        <!-- 🕓 Jadwal Kerja -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('jadwal-kerja.index') }}">
                <i class="fas fa-fw fa-clock"></i>
                <span>Jadwal Kerja</span>
            </a>
        </li>

        <!-- 📨 Permohonan Cuti -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('permohonan-cuti.index') }}">
                <i class="fas fa-fw fa-envelope-open"></i>
                <span>Permohonan Cuti</span>
            </a>
        </li>

        <!-- 📄 Laporan Absensi -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('laporan.index') }}">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Laporan Absensi</span>
            </a>
        </li>

        <!-- 💬 Kritik & Saran -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kritik-saran.index') }}">
                <i class="fas fa-fw fa-comments"></i>
                <span>Kritik & Saran</span>
            </a>
        </li>
    @endif

    <!-- KARYAWAN MENU -->
    @if(auth()->check() && auth()->user()->role === 'karyawan')
        <div class="sidebar-heading">Menu Karyawan</div>

        <!-- 📅 Absensi -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('absensi.index') }}">
                <i class="fas fa-fw fa-calendar-check"></i>
                <span>Absensi</span>
            </a>
        </li>

        <!-- 📨 Permohonan Cuti -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('permohonan-cuti.index') }}">
                <i class="fas fa-fw fa-envelope-open"></i>
                <span>Permohonan Cuti</span>
            </a>
        </li>

        <!-- 💬 Kritik & Saran -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kritik_saran.index') }}">
                <i class="fas fa-fw fa-comments"></i>
                <span>Kritik & Saran</span>
            </a>
        </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">

    <!-- 🚪 Logout -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>

</ul>
<!-- End of Sidebar -->