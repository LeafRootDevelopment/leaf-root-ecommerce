@extends('layouts.customer')

@section('title', 'Checkout - Leaf & Root')

@section('content')

    <h1>Checkout</h1>

    <p>
        <a href="{{ route('basket.index') }}">
            &larr; Return to Basket
        </a>
    </p>

    {{-- Validation Error Banner --}}
    @if ($errors->any())
        <div style="color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 12px; margin-bottom: 20px; border-radius: 4px;">
            <strong>Please correct the following errors to complete your order:</strong>
            <ul style="margin-top: 8px; margin-bottom: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: flex; gap: 40px; align-items: flex-start; flex-wrap: wrap;">

        {{-- Delivery Details Form --}}
        <div style="flex: 1; min-width: 300px;">
            <h2>1. Delivery Details</h2>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                {{-- First Name --}}
                <p>
                    <label for="first_name">First Name: <span style="color: red;">*</span></label><br>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="{{ old('first_name', auth()->user()->first_name ?? auth()->user()->name ?? '') }}"
                        autocomplete="given-name"
                        style="width: 100%; max-width: 400px; padding: 8px;"
                        required
                    >
                    @error('first_name')
                        <br><span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                    @enderror
                </p>

                {{-- Last Name --}}
                <p>
                    <label for="last_name">Last Name: <span style="color: red;">*</span></label><br>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="{{ old('last_name', auth()->user()->last_name ?? '') }}"
                        autocomplete="family-name"
                        style="width: 100%; max-width: 400px; padding: 8px;"
                        required
                    >
                    @error('last_name')
                        <br><span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                    @enderror
                </p>

                {{-- Email Address --}}
                <p>
                    <label for="email">Email Address: <span style="color: red;">*</span></label><br>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email ?? '') }}"
                        autocomplete="email"
                        style="width: 100%; max-width: 400px; padding: 8px;"
                        required
                    >
                    @error('email')
                        <br><span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                    @enderror
                </p>

                {{-- Phone Number --}}
                <p>
                    <label for="phone">Phone Number (Optional):</label><br>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        autocomplete="tel"
                        style="width: 100%; max-width: 400px; padding: 8px;"
                    >
                    @error('phone')
                        <br><span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                    @enderror
                </p>

                {{-- Street Address --}}
                <p>
                    <label for="address">Street Address: <span style="color: red;">*</span></label><br>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        value="{{ old('address') }}"
                        autocomplete="street-address"
                        style="width: 100%; max-width: 400px; padding: 8px;"
                        required
                    >
                    @error('address')
                        <br><span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                    @enderror
                </p>

                {{-- City --}}
                <p>
                    <label for="city">City: <span style="color: red;">*</span></label><br>
                    <input
                        type="text"
                        id="city"
                        name="city"
                        value="{{ old('city') }}"
                        autocomplete="address-level2"
                        style="width: 100%; max-width: 400px; padding: 8px;"
                        required
                    >
                    @error('city')
                        <br><span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                    @enderror
                </p>

                {{-- Postcode --}}
                <p>
                    <label for="postcode">Postcode: <span style="color: red;">*</span></label><br>
                    <input
                        type="text"
                        id="postcode"
                        name="postcode"
                        value="{{ old('postcode') }}"
                        autocomplete="postal-code"
                        style="width: 100%; max-width: 400px; padding: 8px;"
                        required
                    >
                    @error('postcode')
                        <br><span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                    @enderror
                </p>

                {{-- Submit Button --}}
                <p style="margin-top: 25px;">
                    <button type="submit" style="padding: 12px 24px; font-size: 1.1em; cursor: pointer;">
                        Place Order &rarr;
                    </button>
                </p>
            </form>
        </div>

        {{-- Order Summary Sidebar --}}
        <div style="flex: 0 0 320px; border: 1px solid #ccc; padding: 20px; background-color: #f9f9f9; border-radius: 4px;">
            <h2 style="margin-top: 0;">Order Summary</h2>

            @if ($basket && $basket->items->isNotEmpty())
                <ul style="list-style: none; padding: 0; margin: 0 0 15px 0;">
                    @foreach ($basket->items as $item)
                        <li style="display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px dashed #ddd; padding-bottom: 8px;">
                            <div>
                                <strong>{{ $item->product->name ?? 'Product' }}</strong><br>
                                <small>Qty: {{ $item->quantity }} &times; £{{ number_format($item->product->price ?? 0, 2) }}</small>
                            </div>
                            <div>
                                £{{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }}
                            </div>
                        </li>
                    @endforeach
                </ul>

                <hr style="border: 0; border-top: 1px solid #ccc;">

                <p style="display: flex; justify-content: space-between; font-size: 1.2em; font-weight: bold; margin-bottom: 0;">
                    <span>Total:</span>
                    <span>£{{ number_format($total, 2) }}</span>
                </p>
            @endif
        </div>

    </div>

@endsection