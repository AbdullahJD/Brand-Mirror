@extends('Store.layouts.master')

@section('title')
Check Out Success
@endsection

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">

    <div class="text-center bg-white p-5 shadow-sm rounded" style="max-width: 500px; width: 100%;">

        <!-- ICON -->
        <div class="mb-4">
            <div style="width:80px;height:80px;margin:auto;border-radius:50%;background:#e6f9ee;display:flex;align-items:center;justify-content:center;">
                <span style="font-size:40px;color:#28a745;">✔</span>
            </div>
        </div>

        <!-- TITLE -->
        <h2 class="mb-2 text-success">Order Placed Successfully!</h2>

        <p class="text-muted mb-4">
            Thank you for your purchase. Your order has been received and is being processed.
        </p>

        <!-- ORDER INFO -->
        <div class="bg-light p-3 rounded mb-4 text-start">

            <div class="d-flex justify-content-between mb-2">
                <span>Order Number:</span>
                <strong>{{ $order->order_number ?? '-' }}</strong>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span>Total Paid:</span>
                <strong>${{ $order->final_total ?? 0 }}</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Status:</span>
                <span class="badge bg-warning text-dark">
                    {{ ucfirst($order->status ?? 'pending') }}
                </span>
            </div>

        </div>

        <!-- BUTTONS -->
        <div class="d-grid gap-2">

            <a href="{{ route('store.home') }}"
               class="btn btn-dark">
                Continue Shopping
            </a>

            <a href="{{ route('store.orders.show', $order) }}"
               class="btn btn-outline-primary">
                View Order Details
            </a>

        </div>

    </div>

</div>

@endsection