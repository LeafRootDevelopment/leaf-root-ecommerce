@extends('layouts.customer')

@section('title', 'Log In - Leaf & Root')

@section('content')

    <div class="row justify-content-center py-5">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-sm-5">

                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold mb-1">Welcome Back</h1>
                        <p class="text-muted small">Please sign in to your account</p>
                    </div>

                    {{-- Session Status Banner (e.g. Password Reset, Notice Messages) --}}
                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ Route::has('login') ? route('login') : url('/login') }}" method="POST">
                        @csrf

                        {{-- Email Address --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
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
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label mb-0">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="small text-decoration-none">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control mt-1 @error('password') is-invalid @enderror" 
                                required
                                autocomplete="current-password"
                            >
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="mb-4 form-check">
                            <input 
                                type="checkbox" 
                                class="form-check-input" 
                                id="remember" 
                                name="remember" 
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            <label class="form-check-label text-secondary small" for="remember">
                                Remember me on this device
                            </label>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                            Log In
                        </button>

                    </form>

                </div>

                {{-- Registration Link Footer (if registration route exists) --}}
                @if (Route::has('register'))
                    <div class="card-footer bg-light text-center py-3">
                        <span class="small text-muted">Don't have an account?</span>
                        <a href="{{ route('register') }}" class="small fw-bold text-decoration-none ms-1">
                            Create One
                        </a>
                    </div>
                @endif

            </div>

        </div>
    </div>

@endsection