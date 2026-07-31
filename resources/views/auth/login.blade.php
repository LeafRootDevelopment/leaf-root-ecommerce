<!DOCTYPE html>
<html>
<head>
    <title>Leaf & Root - Admin Login</title>
</head>
<body>

    <h1>Admin Login</h1>

    {{-- Validation Error Display --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Login Form --}}
    <form action="{{ url('/login') }}" method="POST">
        @csrf

        <p>
            <label for="email">Email Address:</label><br>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus
            >
        </p>

        <p>
            <label for="password">Password:</label><br>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required
            >
        </p>

        <p>
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
        </p>

        <p>
            <button type="submit">Log In</button>
        </p>

    </form>

</body>
</html>