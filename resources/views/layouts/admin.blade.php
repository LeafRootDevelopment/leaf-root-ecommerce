<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin - Leaf & Root')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100 bg-light-subtle">

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-2">
            <div class="container">

                <a href="{{ route('admin.dashboard') }}" class="navbar-brand d-flex align-items-center gap-2">
                    <img src="{{ asset('images/Leaf&Root LOGO.png') }}" alt="Leaf & Root" style="height: 44px; width: auto;">
                    <strong class="fs-5 text-white">Leaf &amp; Root <span class="text-success">Admin</span></strong>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="adminNavbar">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2 my-2 my-lg-0">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link px-2 {{ request()->routeIs('admin.dashboard') ? 'active fw-bold text-success' : '' }}">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link px-2 {{ request()->routeIs('admin.products.*') ? 'active fw-bold text-success' : '' }}">
                                <i class="bi bi-box-seam me-1"></i> Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}" class="nav-link px-2 {{ request()->routeIs('admin.categories.*') ? 'active fw-bold text-success' : '' }}">
                                <i class="bi bi-tags me-1"></i> Categories
                            </a>
                        </li>
                        @if (Route::has('admin.orders.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index') }}" class="nav-link px-2 {{ request()->routeIs('admin.orders.*') ? 'active fw-bold text-success' : '' }}">
                                    <i class="bi bi-receipt me-1"></i> Orders
                                </a>
                            </li>
                        @endif
                        @if (Route::has('admin.contacts.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.contacts.index') }}" class="nav-link px-2 {{ request()->routeIs('admin.contacts.*') ? 'active fw-bold text-success' : '' }}">
                                    <i class="bi bi-envelope me-1"></i> Contacts
                                </a>
                            </li>
                        @endif

                        @auth
                            <li class="nav-item">
                                <span class="nav-link text-light-emphasis px-2">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ Auth::user()->first_name ?? Auth::user()->email }}
                                </span>
                            </li>
                            <li class="nav-item ms-lg-2">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
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

    <main class="container my-4 flex-grow-1">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 border-start border-4 border-success" role="alert">
                <i class="bi bi-check-circle-fill me-2 text-success"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 border-start border-4 border-danger" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')

    </main>

    <footer class="border-top py-3 bg-white mt-auto">
        <div class="container text-center text-muted small">
            &copy; {{ date('Y') }} <strong>Leaf &amp; Root</strong> Admin Panel
        </div>
    </footer>

    <!-- Bootstrap 5 JavaScript Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    @stack('scripts')

</body>
</html>