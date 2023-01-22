<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FreedomWall.me') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">

    @yield('head')
</head>
<body>
<div id="app">
    <div class="alert alert-warning mb-0 py-2 rounded-0 border-0">
        <span class="site-brand">freedomwall.me</span> {{ __('is still in') }} <strong>beta</strong>.
        {{  __('You will lose your account at the time of release.') }}
    </div>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand site-brand">
                <svg width="32" height="32" class="me-2">
                    <image href="{{ asset('svg/logo.svg') }}" width="32" height="32"></image>
                </svg>
                freedomwall.me
            </a>

            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav me-auto">
                    <a class="nav-item nav-link active" href="{{ route('contact') }}">{{ __('Feedback') }}</a>
                    <a class="nav-item nav-link active" href="{{ route('privacy') }}">{{ __('Privacy Notice') }}</a>
                </div>
            </div>

            <div class="navbar-nav ms-auto">
                @auth
                    <a class="nav-item nav-link active" href="{{ route('profile') }}">{{ __('Profile') }}</a>
                    <a class="nav-item nav-link active" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-item nav-link active">{{ __('Log in') }}</a>
                    <a href="{{ route('register') }}" class="nav-item nav-link active">{{ __('Register') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        <div class="my-5 container">
            @yield('content')
        </div>
    </main>
</div>

@yield('dload')
</body>
</html>
