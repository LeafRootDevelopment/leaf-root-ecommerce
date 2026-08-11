@extends(View::exists('layouts.admin') ? 'layouts.admin' : 'layouts.customer')

@section('title', 'Manage Orders - Leaf & Root')
@section('header', 'Order Management')

@section('content')

    {{-- Header & Search Bar Card --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                
                <div>
                    <h1 class="h3 fw-bold mb-1">Customer Orders</h1>
                    <p class="text-muted small mb-0">View, search, and manage customer order histories</p>
                </div>

                {{-- Search Form --}}
                @php
                    $indexRoute = Route::has('admin.orders.index') 
                        ? route('admin.orders.index') 
                        : (Route::has('orders.index') ? route('orders.index') : url('/admin/orders'));
                @endphp

                <form action="{{ $indexRoute }}" method="GET" class="d-flex align-items-center gap-2">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search', $search ?? '') }}" 
                            placeholder="Search ID, Name, Email..." 
                            class="form-control border-start-0"
                            aria-label="Search orders"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary fw-semibold px-3">
                        Search
                    </button>

                    @if(!empty($search) || request()->filled('search'))
                        <a href="{{ $indexRoute }}" class="btn btn-outline-secondary text-nowrap">
                            Clear
                        </a>
                    @endif
                </form>

            </div>
        </div>
    </div>

    {{-- Orders Data Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4 py-3">Order ID</th>
                            <th scope="col" class="py-3">Customer</th>
                            <th scope="col" class="py-3">Email</th>
                            <th scope="col" class="py-3">Total</th>
                            <th scope="col" class="py-3">Status</th>
                            <th scope="col" class="py-3">Date Created</th>
                            <th scope="col" class="pe-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            @php
                                // Safe status resolution for String vs Enum status properties
                                $rawStatus = is_object($order->status) && isset($order->status->value) 
                                    ? $order->status->value 
                                    : (string) ($order->status ?? 'Pending');

                                // Badge color mappings
                                $badgeClass = match (strtolower($rawStatus)) {
                                    'completed', 'delivered' => 'bg-success bg-opacity-75',
                                    'processing', 'shipped'  => 'bg-primary bg-opacity-75',
                                    'cancelled', 'refunded'  => 'bg-danger bg-opacity-75',
                                    default                   => 'bg-warning text-dark bg-opacity-75',
                                };

                                if (is_object($order->status) && method_exists($order->status, 'badgeClass')) {
                                    $badgeClass = $order->status->badgeClass();
                                }

                                $showRoute = Route::has('admin.orders.show') 
                                    ? route('admin.orders.show', $order) 
                                    : (Route::has('orders.show') ? route('orders.show', $order) : url('/admin/orders/' . $order->id));
                            @endphp
                            <tr>
                                <td class="ps-4 fw-bold text-dark">
                                    #{{ $order->id }}
                                </td>
                                <td class="fw-medium">
                                    {{ $order->full_name ?? ($order->first_name ? $order->first_name . ' ' . $order->last_name : 'Guest Customer') }}
                                </td>
                                <td class="text-secondary small">
                                    {{ $order->email }}
                                </td>
                                <td class="fw-bold text-success">
                                    £{{ number_format($order->total, 2) }}
                                </td>
                                <td>
                                    <span class="badge {{ $badgeClass }} text-uppercase fs-7 px-2 py-1">
                                        {{ $rawStatus }}
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    {{ $order->created_at ? $order->created_at->format('d M Y, H:i') : 'N/A' }}
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ $showRoute }}" class="btn btn-sm btn-outline-primary fw-semibold px-3">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div class="py-3">
                                        <i class="bi bi-inbox text-muted opacity-50 display-6 d-block mb-2"></i>
                                        <p class="mb-0 fw-medium">No orders found matching your criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination Footer --}}
        @if (method_exists($orders, 'hasPages') && $orders->hasPages())
            <div class="card-footer bg-white py-3 border-top d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

@endsection