<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Leaf & Root')</title>
</head>
<body>

    <header>
        <h1>@yield('header', 'Admin Panel')</h1>

        {{-- Logged-in User Identity Greeting --}}
        @auth
            <p>
                Logged in as: 
                <strong>{{ Auth::user()->name ?? Auth::user()->email }}</strong>
            </p>
        @endauth

        {{-- Shared Top Navigation Bar --}}
        <nav>
            <a href="{{ route('admin.dashboard') }}">
                Dashboard
            </a>
            |
            <a href="{{ route('admin.products.index') }}">
                Manage Products
            </a>
            |
            <a href="{{ route('admin.categories.index') }}">
                Manage Categories
            </a>
        </nav>
    </header>

    <hr>

    {{-- Session Flash Messages (Success / Error Alerts) --}}
    @if (session('success'))
        <div style="color: green; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="color: red; margin-bottom: 10px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- Main View Content --}}
    <main>
        @yield('content')
    </main>

    <hr>

    {{-- Shared Secure Logout Form --}}
    <footer>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">
                Logout
            </button>
        </form>
    </footer>

</body>
</html>