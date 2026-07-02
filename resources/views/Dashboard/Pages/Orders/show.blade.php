@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.order_details') }}
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
                {{ __('messages.back_to_orders') }}
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
                        <h3 class="card-title">{{ __('messages.customer_information') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="text-gray-500">{{ __('messages.name_label') }}</span>
                            <span class="fw-bold">{{ $order->customer_name }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-gray-500">{{ __('messages.phone_label') }}</span>
                            <span class="fw-bold">{{ $order->phone }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">{{ __('messages.address_label') }}</span>
                            <span class="fw-bold">{{ $order->address }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-md-6">
                <div class="card card-flush h-100">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.order_summary') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="text-gray-500">{{ __('messages.status_label') }}</span>
                            @switch($order->status)
                                @case('pending')
                                    <span class="badge badge-light-warning">{{ __('messages.status_pending') }}</span>
                                    @break
                                @case('confirmed')
                                    <span class="badge badge-light-info">{{ __('messages.status_confirmed') }}</span>
                                    @break
                                @case('processing')
                                    <span class="badge badge-light-primary">{{ __('messages.status_processing') }}</span>
                                    @break
                                @case('shipped')
                                    <span class="badge badge-light-info">{{ __('messages.status_shipped') }}</span>
                                    @break
                                @case('delivered')
                                    <span class="badge badge-light-success">{{ __('messages.status_delivered') }}</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge badge-light-danger">{{ __('messages.status_cancelled') }}</span>
                                    @break
                                @default
                                    <span class="badge badge-light-secondary">{{ $order->status }}</span>
                            @endswitch
                        </div>
                        <div class="mb-3">
                            <span class="text-gray-500">{{ __('messages.subtotal_label') }}</span>
                            <span class="fw-bold">{{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-gray-500">{{ __('messages.discount_label') }}</span>
                            <span class="fw-bold text-danger">{{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-gray-500">{{ __('messages.final_total_label') }}</span>
                            <span class="fw-bold text-success fs-4">{{ number_format($order->final_total, 2) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">{{ __('messages.created_at_label') }}</span>
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
                    <h3 class="card-title">{{ __('messages.change_order_status') }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('orders.changeStatus', $order) }}">
                        @csrf

                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('messages.new_status') }}</label>
                                <select name="status" class="form-select" required>
                                    <option value="">{{ __('messages.select_status') }}</option>
                                    @foreach($nextStatuses as $status)
                                        <option value="{{ $status }}">
                                            {{ __('messages.status_' . $status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('messages.update_status') }}
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
                <h3 class="card-title">{{ __('messages.order_items') }}</h3>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th>#</th>
                            <th>{{ __('messages.product') }}</th>
                            <th>{{ __('messages.variant') }}</th>
                            <th>{{ __('messages.price') }}</th>
                            <th>{{ __('messages.quantity') }}</th>
                            <th>{{ __('messages.subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        @forelse($order->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product?->name ?? __('messages.not_available') }}</td>
                                <td>{{ $item->variant?->sku ?? '-' }}</td>
                                <td>{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('messages.no_items_found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

@endsection
