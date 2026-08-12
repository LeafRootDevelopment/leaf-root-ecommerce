@extends('layouts.customer')

@section('title', 'Contact Us - Leaf & Root')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 mb-3 fw-bold text-success">Contact Us</h1>
                    <p class="text-muted mb-4">Have a question or feedback about Leaf & Root? Send us a message and our team will get back to you shortly.</p>

                    {{-- Flash Success Alert --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Contact Form Submission Wrapper --}}
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf

                        {{-- Name Field --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">Your Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name') }}" 
                                placeholder="Jane Doe"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email Field --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">Email Address</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                value="{{ old('email') }}" 
                                placeholder="jane@example.com"
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Subject Field --}}
                        <div class="mb-3">
                            <label for="subject" class="form-label fw-medium">Subject</label>
                            <input 
                                type="text" 
                                name="subject" 
                                id="subject" 
                                class="form-control @error('subject') is-invalid @enderror" 
                                value="{{ old('subject') }}" 
                                placeholder="Order Inquiry, Plant Care, etc."
                                required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Message Field --}}
                        <div class="mb-4">
                            <label for="message" class="form-label fw-medium">Message</label>
                            <textarea 
                                name="message" 
                                id="message" 
                                rows="5" 
                                class="form-control @error('message') is-invalid @enderror" 
                                placeholder="How can we help you?"
                                required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection