<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <a class="nav-link text-danger" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>

    </ul>

</nav>
