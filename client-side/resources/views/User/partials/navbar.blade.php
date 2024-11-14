<header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="" />
                <h1 class="sitename">UIN Malang EventHub</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul class="menu d-flex mb-0">
                    <li><a href="{{ route('landing-page', ['#hero']) }}" class="active text-dark hover:text-white">Home</a></li>
                    <li><a href="{{ route('landing-page', ['#about']) }}" class="text-dark hover:text-white">Tentang</a></li>
                    <li><a href="{{ route('landing-page', ['#eventList']) }}" class="me-3 text-dark hover:text-white">Daftar Acara</a></li>
                    @if (Cookie::get('api_token') && Cookie::get('user_role') == 'User')
                        <div class="dropdown text-end">
                            <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32"
                                    class="rounded-circle">
                            </a>
                            <ul class="dropdown-menu text-small">
                                <li><a class="dropdown-item" href="{{ route('my-event') }}">Acara Saya</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">Keluar</a></li>
                            </ul>
                        </div>
                    @else
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <form action="{{ route('login') }}" method="get" class="me-md-2">
                                <button type="submit" class="btn btn-primary">Masuk</button>
                            </form>
                            <form action="{{ route('register') }}" method="get">
                                <button type="submit" class="btn btn-outline-primary">Daftar</button>
                            </form>
                        </div>
                    @endif
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </div>
</header>
