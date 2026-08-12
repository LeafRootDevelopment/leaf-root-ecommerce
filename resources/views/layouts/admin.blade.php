<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Leaf & Root')</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.5;
            color: #2d3748;
            margin: 0;
            padding: 20px;
            background-color: #f7fafc;
        }
        header {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        nav a {
            color: #2b6cb0;
            text-decoration: none;
            font-weight: 600;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            background-color: #ffffff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background-color: #edf2f7;
            color: #4a5568;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f7fafc;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            background-color: #319795;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #2c7a7b;
        }
        .btn-secondary {
            background-color: #718096;
        }
        .btn-secondary:hover {
            background-color: #4a5568;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-pending { background-color: #fefcbf; color: #744210; }
        .badge-processing { background-color: #bee3f8; color: #2b6cb0; }
        .badge-dispatched { background-color: #e9d8fd; color: #553c9a; }
        .badge-completed { background-color: #c6f6d5; color: #22543d; }
        .badge-cancelled { background-color: #fed7d7; color: #9b2c2c; }
        .alert-success {
            padding: 12px;
            background-color: #c6f6d5;
            color: #22543d;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .alert-error {
            padding: 12px;
            background-color: #fed7d7;
            color: #9b2c2c;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .form-inline {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .input-text {
            padding: 6px 10px;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .card {
            border: 1px solid #e2e8f0;
            padding: 16px;
            border-radius: 6px;
            background-color: #faf5ff;
        }
        footer {
            margin-top: 20px;
            padding: 10px 0;
        }
    </style>
</head>
<body>

    <header>
        <h1>@yield('header', 'Admin Panel')</h1>

        @auth
            <p>
                Logged in as: 
                <strong>{{ Auth::user()->name ?? Auth::user()->email }}</strong>
            </p>
        @endauth

        <nav>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            |
            <a href="{{ route('admin.products.index') }}">Manage Products</a>
            |
            <a href="{{ route('admin.categories.index') }}">Manage Categories</a>
            |
            <a href="{{ route('admin.orders.index') }}">Manage Orders</a>
        </nav>
    </header>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-secondary">
                Logout
            </button>
        </form>
    </footer>

</body>
</html>