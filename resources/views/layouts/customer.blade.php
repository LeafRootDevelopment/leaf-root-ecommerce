<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Dynamic Page Title with Default Fallback --}}
    <title>@yield('title', 'Leaf & Root')</title>
</head>
<body>

    {{-- Customer Navigation Header --}}
    <header>
        <nav>
            <a href="{{ route('products.index') }}">
                <strong>Leaf &amp; Root</strong>
            </a>

            <ul>
                <li>
                    <a href="{{ route('products.index') }}">Catalogue</a>
                </li>
                <li>
                    {{-- Ready for Sprint 2 Basket Route --}}
                    @if (Route::has('basket.index'))
                        <a href="{{ route('basket.index') }}">Basket</a>
                    @else
                        <a href="#">Basket</a>
                    @endif
                </li>
            </ul>
        </nav>
    </header>

    <hr>

    {{-- Primary Content Area --}}
    <main>
        {{-- Success Flash Alert --}}
        @if (session('success'))
            <div style="color: green; margin-bottom: 10px;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Flash Alert --}}
        @if (session('error'))
            <div style="color: red; margin-bottom: 10px;">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <hr>

    {{-- Customer Footer --}}
    <footer>
        <p>&copy; {{ date('Y') }} Leaf &amp; Root. All rights reserved.</p>
    </footer>

</body>
</html>