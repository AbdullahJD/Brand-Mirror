@extends('Store.layouts.master')

@section('title')
{{ __('messages.my_order') }}
@endsection

@section('content')

<div class="container py-5">

    <h2 class="mb-4">
        <i class="fa fa-shopping-bag text-primary"></i>
        {{ __('messages.my_orders') }}
    </h2>

    @if($orders->count())

    <div class="table-responsive">

        <table class="table table-bordered table-hover text-center">

            <thead class="thead-dark">
                <tr>
                    <th>{{ __('messages.table_number') }}</th>
                    <th>{{ __('messages.order_number') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th>{{ __('messages.total') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            @foreach($orders as $order)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $order->order_number }}</td>

                    <td>{{ $order->created_at->format('d M Y') }}</td>

                    <td>${{ number_format($order->total_amount,2) }}</td>

                    <td>

                        @switch($order->status)

                            @case('pending')
                                <span class="badge badge-warning">{{ __('messages.status_pending') }}</span>
                                @break

                            @case('processing')
                                <span class="badge badge-info">{{ __('messages.status_processing') }}</span>
                                @break

                            @case('completed')
                                <span class="badge badge-success">{{ __('messages.status_completed') }}</span>
                                @break

                            @case('cancelled')
                                <span class="badge badge-danger">{{ __('messages.status_cancelled') }}</span>
                                @break

                            @default
                                <span class="badge badge-secondary">
                                    {{ __('messages.status_' . $order->status) }}
                                </span>

                        @endswitch

                    </td>

                    <td>

                        <a href="{{ route('store.orders.show',$order) }}"
                           class="btn btn-sm btn-primary">

                            {{ __('messages.view_details') }}

                        </a>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

    {{ $orders->links() }}

    @else

        <div class="text-center py-5">

            <i class="fa fa-shopping-cart fa-4x text-muted mb-3"></i>

            <h4>{{ __('messages.no_orders_yet') }}</h4>

            <a href="{{ route('store.shop') }}" class="btn btn-primary mt-3">
                {{ __('messages.start_shopping') }}
            </a>

        </div>

    @endif

</div>

@endsection
