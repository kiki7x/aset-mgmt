<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <h1 class="sitename">SAPA PPL</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
              <li><a href="/" class="{{ Request::is('/') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="/profil" class="{{ Request::is('profil') ? 'active' : '' }}">Profil</a></li>
                <li><a href="/layanan" class="{{ Request::is('layanan') ? 'active' : '' }}">Layanan</a></li>
                <li><a href="/statistik" class="{{ Request::is('statistik') ? 'active' : '' }}">Statistik</a></li>
                <li><a href="/team" class="{{ Request::is('team') ? 'active' : '' }}">Team</a></li>
                <li><a href="/faq" class="{{ Request::is('faq') ? 'active' : '' }}">FAQ</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-getstarted" href="{{ route('login') }}">Mulai</a>

    </div>
</header>
