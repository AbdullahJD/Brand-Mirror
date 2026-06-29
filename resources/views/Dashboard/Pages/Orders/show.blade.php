@extends('Dashboard.layouts.master')

@section('title')
Order Details
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">

    <div id="kt_content_container" class="container-xxl">

        <div class="d-flex justify-content-between align-items-center mb-5">

            <div>
                <h2 class="mb-1">{{ __('messages.order_details') }}</h2>
                <span class="text-muted">{{ $order->order_number }}</span>
            </div>

            <a href="{{ route('orders.index') }}" class="btn btn-light">
                Back to Orders
            </a>

        </div>

        @if(session('updated'))
            <div class="alert alert-primary">{{ session('updated') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="row g-5 g-xl-8 mb-5">

            {{-- Customer Info --}}
            <div class="col-md-6">
                <div class="card card-flush h-100">
                    <div class="card-header">
                        <h3 class="card-title">Customer Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="text-gray-500">Name:</span>
                            <span class="fw-bold">{{ $order->customer_name }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-gray-500">Phone:</span>
                            <span class="fw-bold">{{ $order->phone }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Address:</span>
                            <span class="fw-bold">{{ $order->address }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-md-6">
                <div class="card card-flush h-100">
                    <div class="card-header">
                        <h3 class="card-title">Order Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="text-gray-500">Status:</span>
                            @switch($order->status)
                                @case('pending')
                                    <span class="badge badge-light-warning">Pending</span>
                                    @break
                                @case('confirmed')
                                    <span class="badge badge-light-info">Confirmed</span>
                                    @break
                                @case('processing')
                                    <span class="badge badge-light-primary">Processing</span>
                                    @break
                                @case('shipped')
                                    <span class="badge badge-light-info">Shipped</span>
                                    @break
                                @case('delivered')
                                    <span class="badge badge-light-success">Delivered</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge badge-light-danger">Cancelled</span>
                                    @break
                                @default
                                    <span class="badge badge-light-secondary">{{ $order->status }}</span>
                            @endswitch
                        </div>
                        <div class="mb-3">
                            <span class="text-gray-500">Subtotal:</span>
                            <span class="fw-bold">{{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-gray-500">Discount:</span>
                            <span class="fw-bold text-danger">{{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-gray-500">Final Total:</span>
                            <span class="fw-bold text-success fs-4">{{ number_format($order->final_total, 2) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Created At:</span>
                            <span class="fw-bold">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Change Status --}}
        @php
            $nextStatuses = match($order->status) {
                'pending' => ['confirmed', 'cancelled'],
                'confirmed' => ['processing', 'cancelled'],
                'processing' => ['shipped', 'cancelled'],
                'shipped' => ['delivered', 'cancelled'],
                default => [],
            };
        @endphp

        @if(count($nextStatuses) > 0)
            <div class="card card-flush mb-5">
                <div class="card-header">
                    <h3 class="card-title">Change Order Status</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('orders.changeStatus', $order) }}">
                        @csrf

                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">New Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="">Select Status</option>
                                    @foreach($nextStatuses as $status)
                                        <option value="{{ $status }}">
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Status
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Order Items --}}
        <div class="card card-flush">
            <div class="card-header">
                <h3 class="card-title">Order Items</h3>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th>#</th>
                            <th>Product</th>
                            <th>Variant</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        @forelse($order->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product?->name ?? 'N/A' }}</td>
                                <td>{{ $item->variant?->sku ?? '-' }}</td>
                                <td>{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Items Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

@endsection