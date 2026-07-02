@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.orders_page_title') }}
@endsection
@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">

    <div id="kt_content_container" class="container-xxl">

        {{-- Stats Cards --}}
        <div class="row g-5 g-xl-8 mb-5">

            <div class="col-md-4">
                <div class="card card-flush h-100">
                    <div class="card-body">
                        <span class="text-gray-400 fw-bold fs-7">{{ __('messages.total_orders') }}</span>
                        <div class="fs-2hx fw-bolder text-dark">{{ $stats['total_orders'] }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flush h-100">
                    <div class="card-body">
                        <span class="text-gray-400 fw-bold fs-7">{{ __('messages.status_pending') }}</span>
                        <div class="fs-2hx fw-bolder text-warning">{{ $stats['pending'] }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flush h-100">
                    <div class="card-body">
                        <span class="text-gray-400 fw-bold fs-7">{{ __('messages.revenue_delivered') }}</span>
                        <div class="fs-2hx fw-bolder text-success">{{ number_format($stats['revenue'], 2) }}</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Orders Table --}}
        <div class="card card-flush">

            <div class="card-header align-items-center py-5 gap-2 gap-md-5">

                <div class="card-title">
                    <h2 class="mb-0">{{ __('messages.all_orders') }}</h2>
                </div>

                <div class="card-toolbar">
                    <span class="badge badge-light-primary fs-7">
                        {{ __('messages.live_panel_ready') }}
                    </span>
                </div>

            </div>

            <div class="card-body pt-0">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('updated'))
                    <div class="alert alert-primary">{{ session('updated') }}</div>
                @endif

                <table class="table align-middle table-row-dashed fs-6 gy-5" id="orders-table">

                    <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th>#</th>
                            <th>{{ __('messages.order_number_col') }}</th>
                            <th>{{ __('messages.customer') }}</th>
                            <th>{{ __('messages.phone') }}</th>
                            <th>{{ __('messages.total') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.type') }}</th>
                            <th>{{ __('messages.date') }}</th>
                            <th class="text-end">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody class="fw-bold text-gray-600" id="orders-table-body">

                        @forelse($orders as $order)

                            <tr id="order-row-{{ $order->id }}">

                                <td>{{ $orders->firstItem() + $loop->index }}</td>

                                <td>
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="text-gray-800 text-hover-primary fw-bolder">
                                        {{ $order->order_number }}
                                    </a>
                                </td>

                                <td>{{ $order->customer_name }}</td>

                                <td>{{ $order->phone }}</td>

                                <td>{{ number_format($order->final_total, 2) }}</td>

                                <td>
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
                                </td>
                                <td>
                                    @if($order->customer_id)
                                        <span class="badge badge-light-primary">{{ __('messages.user') }}</span>
                                    @else
                                        <span class="badge badge-light-secondary">{{ __('messages.guest') }}</span>
                                    @endif
                                </td>

                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>

                                <td class="text-end">

                                    <a href="{{ route('orders.show', $order) }}"
                                       class="btn btn-sm btn-light btn-active-light-primary">
                                        {{ __('messages.view') }}
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center">
                                    {{ __('messages.no_orders_found') }}
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

                <div class="mt-5">
                    {{ $orders->links() }}
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
