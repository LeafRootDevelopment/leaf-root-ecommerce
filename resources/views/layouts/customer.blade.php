<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Leaf & Root - Indoor Plants & Botanical Goods')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100 bg-light-subtle">

    {{-- Accessibility Skip Link --}}
    <a href="#main-content" class="visually-hidden-focusable p-3 bg-white text-success fw-bold border border-success position-absolute z-3 m-2 rounded">
        Skip to main content
    </a>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-2">
            <div class="container">

                {{-- Brand Logo / Name --}}
                <a href="{{ Route::has('products.index') ? route('products.index') : url('/') }}" class="navbar-brand d-flex align-items-center gap-2">
                    <img src="{{ asset('images/Leaf&Root LOGO.png') }}" alt="Leaf & Root" style="height: 50px; width: auto;">
                    <strong class="text-success fs-4 fw-bold">Leaf &amp; Root</strong>
                </a>

                {{-- Responsive Toggler --}}
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#customerNavbar" aria-controls="customerNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Navbar Links --}}
                <div class="collapse navbar-collapse" id="customerNavbar">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2 my-2 my-lg-0">

                        @if (Route::has('products.index'))
                            <li class="nav-item">
                                <a href="{{ route('products.index') }}" class="nav-link px-2 {{ request()->routeIs('products.*') ? 'active fw-bold text-success' : '' }}">
                                    <i class="bi bi-grid-fill me-1"></i>
                                    Catalogue
                                </a>
                            </li>
                        @endif

                        @if (Route::has('basket.index'))
                            <li class="nav-item">
                                <a href="{{ route('basket.index') }}" class="nav-link px-2 d-inline-flex align-items-center {{ request()->routeIs('basket.*') ? 'active fw-bold text-success' : '' }}">
                                    <i class="bi bi-bag-fill me-1"></i>
                                    Basket
                                    
                                    {{-- Live Basket Count Badge composed globally in AppServiceProvider --}}
                                    @if (($basketCount ?? 0) > 0)
                                        <span class="badge bg-success rounded-pill ms-1 fs-6 px-2 py-1">
                                            {{ $basketCount }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                        @endif

                        {{-- Guest Navigation --}}
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="nav-link px-2 {{ request()->routeIs('login') ? 'active fw-bold text-success' : '' }}">
                                        <i class="bi bi-box-arrow-in-right me-1"></i>
                                        Login
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register') || Route::has('register.show'))
                                <li class="nav-item">
                                    <a href="{{ Route::has('register') ? route('register') : route('register.show') }}" class="btn btn-outline-success btn-sm px-3 ms-lg-2">
                                        Register
                                    </a>
                                </li>
                            @endif
                        @endguest

                        {{-- Authenticated Navigation --}}
                        @auth
                            <li class="nav-item">
                                <span class="nav-link text-dark fw-medium px-2">
                                    <i class="bi bi-person-circle text-secondary me-1"></i>
                                    Welcome, <strong>{{ Auth::user()->first_name ?? Auth::user()->email }}</strong>
                                </span>
                            </li>

                            <li class="nav-item ms-lg-2">
                                @php
                                    $logoutRoute = Route::has('logout') ? route('logout') : url('/logout');
                                @endphp
                                <form action="{{ $logoutRoute }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                                        <i class="bi bi-power me-1"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @endauth

                    </ul>
                </div>

            </div>
        </nav>
    </header>

    <main class="container my-4 flex-grow-1" id="main-content">

        {{-- Success Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 border-start border-4 border-success" role="alert">
                <i class="bi bi-check-circle-fill me-2 text-success"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Status Flash Message --}}
        @if (session('status'))
            <div class="alert alert-info alert-dismissible fade show shadow-sm border-0 border-start border-4 border-info" role="alert">
                <i class="bi bi-info-circle-fill me-2 text-info"></i>
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Error Flash Message --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 border-start border-4 border-danger" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 border-start border-4 border-danger" role="alert">
                <div class="fw-bold mb-1 d-flex align-items-center">
                    <i class="bi bi-x-circle-fill me-2 text-danger"></i>
                    Please correct the following errors:
                </div>
                <ul class="mb-0 ps-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Main Page Content --}}
        @yield('content')

    </main>

    {{-- Footer --}}
    <footer class="border-top py-4 bg-white mt-auto">
        <div class="container text-center text-muted">
            <p class="mb-1 small">
                &copy; {{ date('Y') }} <strong>Leaf &amp; Root</strong>. All rights reserved.
            </p>
            <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                Quality houseplants &amp; botanical care direct to your home.
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JavaScript Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    @stack('scripts')

</body>
</html>