@extends(View::exists('layouts.admin') ? 'layouts.admin' : 'layouts.customer')

@section('title', "Order #{$order->id} Details - Leaf & Root")
@section('header', "Order #{$order->id}")

@section('content')

    {{-- Header & Navigation Bar --}}
    @php
        $indexRoute = Route::has('admin.orders.index') 
            ? route('admin.orders.index') 
            : (Route::has('orders.index') ? route('orders.index') : url('/admin/orders'));
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Order #{{ $order->id }}</h1>
            <p class="text-muted small mb-0">
                Placed on {{ $order->created_at ? $order->created_at->format('d M Y \a\t H:i') : 'N/A' }}
            </p>
        </div>
        <a href="{{ $indexRoute }}" class="btn btn-outline-secondary btn-sm">
            &larr; Back to Orders
        </a>
    </div>

    {{-- Details Grid --}}
    <div class="row g-4 mb-4">

        {{-- Customer Details --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h2 class="h5 card-title mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-person me-2 text-primary"></i> Customer Details
                    </h2>
                </div>
                <div class="card-body p-4">
                    @php
                        $customerName = $order->user 
                            ? trim($order->user->first_name . ' ' . $order->user->last_name) 
                            : ($order->full_name ?? 'Guest Customer');
                    @endphp
                    <p class="mb-2">
                        <strong class="text-secondary">Name:</strong>
                        <span class="fw-semibold">{{ $customerName ?: 'Guest Customer' }}</span>
                    </p>
                    <p class="mb-2">
                        <strong class="text-secondary">Email:</strong>
                        @if ($order->user?->email)
                            <a href="mailto:{{ $order->user->email }}" class="text-decoration-none">{{ $order->user->email }}</a>
                        @else
                            <span class="text-muted">N/A (Guest Checkout)</span>
                        @endif
                    </p>
                    <p class="mb-0">
                        <strong class="text-secondary">Phone:</strong>
                        {{ $order->user?->phone ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Delivery Details --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h2 class="h5 card-title mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-geo-alt me-2 text-primary"></i> Delivery Details
                    </h2>
                </div>
                <div class="card-body p-4">
                    @if ($order->address)
                        <p class="mb-2">
                            <strong class="text-secondary">Address:</strong><br>
                            <span class="fw-medium">
                                {{ $order->address->address_line1 }}
                                @if ($order->address->address_line2)
                                    <br>{{ $order->address->address_line2 }}
                                @endif
                            </span>
                        </p>
                        <p class="mb-2">
                            <strong class="text-secondary">City / Region:</strong>
                            {{ $order->address->city }}
                            @if ($order->address->state_province)
                                , {{ $order->address->state_province }}
                            @endif
                        </p>
                        <p class="mb-2">
                            <strong class="text-secondary">Country:</strong>
                            {{ $order->address->country ?? 'N/A' }}
                        </p>
                        <p class="mb-0">
                            <strong class="text-secondary">Postal Code:</strong>
                            <span class="badge bg-light text-dark border">{{ $order->address->postal_code ?? 'N/A' }}</span>
                        </p>
                    @else
                        <p class="text-muted mb-0">No delivery address associated with this order.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- Order Items Card --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h2 class="h5 card-title mb-0 fw-bold">Order Items</h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4 py-3">Product Name</th>
                            <th scope="col" class="py-3 text-center">Quantity</th>
                            <th scope="col" class="py-3 text-end">Unit Price</th>
                            <th scope="col" class="pe-4 py-3 text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="ps-4 py-3 fw-medium">
                                    {{ $item->product->name ?? $item->product_name ?? 'Product Unavailable' }}
                                </td>
                                <td class="text-center py-3">
                                    <span class="badge bg-secondary-subtle text-secondary border fs-6 px-3 py-1">
                                        {{ $item->quantity }}
                                    </span>
                                </td>
                                <td class="text-end py-3 text-muted">
                                    £{{ number_format($item->price, 2) }}
                                </td>
                                <td class="pe-4 text-end py-3 fw-bold text-dark">
                                    £{{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold fs-5 py-3">Grand Total:</td>
                            <td class="pe-4 text-end fw-bold fs-4 text-success py-3">
                                £{{ number_format($order->total, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Order Status Management Card --}}
    @php
        $rawStatus = is_object($order->status) && isset($order->status->value) 
            ? $order->status->value 
            : (string) ($order->status ?? 'Pending');

        $badgeClass = match (strtolower($rawStatus)) {
            'completed', 'delivered' => 'bg-success bg-opacity-75',
            'processing', 'shipped'  => 'bg-primary bg-opacity-75',
            'cancelled', 'refunded'  => 'bg-danger bg-opacity-75',
            default                   => 'bg-warning text-dark bg-opacity-75',
        };

        if (is_object($order->status) && method_exists($order->status, 'badgeClass')) {
            $badgeClass = $order->status->badgeClass();
        }

        $updateRoute = Route::has('admin.orders.update-status') 
            ? route('admin.orders.update-status', $order) 
            : (Route::has('admin.orders.update') 
                ? route('admin.orders.update', $order) 
                : (Route::has('orders.update') 
                    ? route('orders.update', $order) 
                    : url('/admin/orders/' . $order->id)));

        $statusOptions = class_exists('\App\Enums\OrderStatus') 
            ? array_map(fn($case) => $case->value, \App\Enums\OrderStatus::cases()) 
            : ['Pending', 'Processing', 'Shipped', 'Completed', 'Cancelled'];
    @endphp

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h2 class="h5 card-title mb-0 fw-bold">Order Status Management</h2>
        </div>
        <div class="card-body p-4">
            
            <div class="mb-4 d-flex align-items-center gap-2">
                <span class="fw-semibold text-secondary">Current Status:</span>
                <span class="badge {{ $badgeClass }} text-uppercase fs-6 px-3 py-2">
                    {{ $rawStatus }}
                </span>
            </div>

            <form action="{{ $updateRoute }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="row g-3 align-items-center">
                    <div class="col-sm-6 col-md-4">
                        <label for="status" class="form-label fw-bold small text-muted text-uppercase mb-1">
                            Update Status
                        </label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            @foreach ($statusOptions as $statusValue)
                                <option value="{{ $statusValue }}" {{ strtolower($rawStatus) === strtolower($statusValue) ? 'selected' : '' }}>
                                    {{ $statusValue }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-3 pt-sm-4">
                        <button type="submit" class="btn btn-primary fw-bold w-100">
                            Update Status
                        </button>
                    </div>
                </div>

                @error('status')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </form>

        </div>
    </div>

@endsection