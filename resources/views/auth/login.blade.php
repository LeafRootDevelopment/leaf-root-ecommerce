@extends('layouts.customer')

@section('title', 'Log In - Leaf & Root')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="h3 fw-bold mb-1 text-center">Log In</h1>
                    <p class="text-muted text-center mb-4">Welcome back to Leaf &amp; Root</p>

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                required
                                autofocus
                            >
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Remember Me</label>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Log In
                        </button>

                        @if (Route::has('register.show'))
                            <p class="text-center text-muted small mt-3 mb-0">
                                Don't have an account?
                                <a href="{{ route('register.show') }}" class="text-success text-decoration-none">Register here</a>
                            </p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection