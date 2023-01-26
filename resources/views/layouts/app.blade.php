<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FreedomWall.me') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/js.cookie.min.js') }}"></script>

    @yield('head')
</head>

<body>
    <div id="app">
        <div class="alert alert-warning alert-dismissible fade show mb-0 rounded-0 d-none" role="alert"
            id="beta-alert">
            <div>
                <span class="site-brand">freedomwall.me</span> is still in <strong>beta</strong>.
                You will lose your account at the time of release.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                id="beta-alert-btn"></button>
        </div>
        <nav class="navbar sticky-top navbar-expand-lg bg-primary">
            <div class="container">
                <a href="{{ route('home') }}" class="navbar-brand">
                    <svg width="40" height="40" class="me-2">
                        <image href="{{ asset('svg/logo.svg') }}" width="40" height="40"></image>
                    </svg>
                    <span class="site-brand">
                        freedomwall.me
                    </span>
                </a>


                <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav me-auto">
                        <a class="nav-item nav-link active" href="{{ route('contact') }}">Feedback</a>
                        <a class="nav-item nav-link active" href="{{ route('privacy') }}">Privacy Notice</a>
                    </div>
                    <div class="navbar-nav ms-auto">
                        @auth
                            <a class="nav-item nav-link active" href="{{ route('profile') }}">Profile</a>
                            <a class="nav-item nav-link active" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="nav-item nav-link active">Log in</a>
                            <a href="{{ route('register') }}" class="nav-item nav-link active">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <div class="my-5 container">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                        @yield('additional-success')
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                        @yield('additional-error')
                    </div>
                @endif

                @if (session()->has('warning'))
                    <div class="alert alert-warning">
                        {{ session()->get('warning') }}
                        @yield('additional-warning')
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript">
        // style tables
        $('table').addClass('table table-striped table-bordered table-hover table-sm');

        // beta alert
        $('#beta-alert').click(e => {
            e.preventDefault();
            Cookies.set('alert-close', 'true', {
                expires: 365
            });
        });

        if (Cookies.get('alert-close') != 'true')
            $('#beta-alert').removeClass('d-none');
    </script>

    @yield('dload')
</body>

</html>
