@extends('layouts.customer')

@section('title', 'Register - Leaf & Root')

@section('content')

    <div class="row justify-content-center py-5">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-sm-5">

                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold mb-1">Create Account</h1>
                        <p class="text-muted small">Join Leaf & Root to track orders and checkout faster</p>
                    </div>

                    <form action="{{ Route::has('register.store') ? route('register.store') : (Route::has('register') ? route('register') : url('/register')) }}" method="POST">
                        @csrf

                        {{-- Full Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                required
                                autofocus
                                autocomplete="name"
                            >
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Email Address --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required
                                autocomplete="email"
                            >
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                                autocomplete="new-password"
                            >
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Password Confirmation --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                required
                                autocomplete="new-password"
                            >
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                            Register
                        </button>

                    </form>

                </div>

                {{-- Login Route Link Footer --}}
                <div class="card-footer bg-light text-center py-3">
                    <span class="small text-muted">Already have an account?</span>
                    <a href="{{ Route::has('login') ? route('login') : url('/login') }}" class="small fw-bold text-decoration-none ms-1">
                        Log In
                    </a>
                </div>

            </div>

        </div>
    </div>

@endsection