@extends('Store.layouts.master')

@section('title')
{{ __('messages.checkout_success') }}
@endsection

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">

    <div class="text-center bg-white p-5 shadow-sm rounded" style="max-width: 500px; width: 100%;">

        <div class="mb-4">
            <div style="width:80px;height:80px;margin:auto;border-radius:50%;background:#e6f9ee;display:flex;align-items:center;justify-content:center;">
                <span style="font-size:40px;color:#28a745;">✔</span>
            </div>
        </div>

        <h2 class="mb-2 text-success">{{ __('messages.order_placed_successfully') }}</h2>

        <p class="text-muted mb-4">
            {{ __('messages.order_thank_you') }}
        </p>

        <div class="bg-light p-3 rounded mb-4 text-start">

            <div class="d-flex justify-content-between mb-2">
                <span>{{ __('messages.order_number') }}</span>
                <strong>{{ $order->order_number ?? '-' }}</strong>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span>{{ __('messages.total_paid') }}</span>
                <strong>${{ $order->final_total ?? 0 }}</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>{{ __('messages.status') }}:</span>
                <span class="badge bg-warning text-dark">
                    {{ __('messages.status_' . ($order->status ?? 'pending')) }}
                </span>
            </div>

        </div>

        <div class="d-grid gap-2">

            <a href="{{ route('store.home') }}"
               class="btn btn-dark">
                {{ __('messages.continue_shopping') }}
            </a>

            <a href="{{ route('store.orders.show', $order) }}"
               class="btn btn-outline-primary">
                {{ __('messages.view_order_details') }}
            </a>

        </div>

    </div>

</div>

@endsection
