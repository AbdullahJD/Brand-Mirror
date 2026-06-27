@extends('Dashboard.layouts.master')

@section('title')
Order Details
@endsection

@section('content')

<div class="container-xxl">

    <h2>Order #{{ $order->id }}</h2>

    <div class="card p-4 mb-5">
        <p><b>Customer:</b> {{ $order->customer?->name ?? 'Guest' }}</p>
        <p><b>Status:</b> {{ $order->status }}</p>
        <p><b>Total:</b> {{ $order->final_total }}</p>
    </div>

    <h4>Activity Timeline</h4>

    <div class="card p-4">

        @forelse($order->activityLogs as $log)
            <div class="border-bottom py-3">
                <div>
                    <b>{{ $log->customer?->name ?? 'System' }}</b>
                </div>

                <div>
                    {{ $log->description }}
                </div>

                <small class="text-muted">
                    {{ $log->created_at->diffForHumans() }}
                </small>
            </div>
        @empty
            <p>No activity yet</p>
        @endforelse

    </div>

</div>

@endsection