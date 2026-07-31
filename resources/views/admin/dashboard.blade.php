<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

    <h1>Admin Dashboard</h1>

    {{-- User Greeting --}}
    <p>
        Logged in as: 
        <strong>{{ Auth::user()->name ?? Auth::user()->email }}</strong>
    </p>

    <h2>System Overview</h2>

    <p>
        Total Products:
        {{ $productCount }}
    </p>

    <p>
        Total Categories:
        {{ $categoryCount }}
    </p>

    {{-- Logout Form --}}
    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>

</body>
</html>