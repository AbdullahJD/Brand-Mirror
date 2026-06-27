@extends('Store.layouts.master')

@section('title')
My Order
@endsection

@section('content')

<div class="container py-5">

    <h2 class="mb-4">
        <i class="fa fa-shopping-bag text-primary"></i>
        My Orders
    </h2>

    @if($orders->count())

    <div class="table-responsive">

        <table class="table table-bordered table-hover text-center">

            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
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
                                <span class="badge badge-warning">Pending</span>
                                @break

                            @case('processing')
                                <span class="badge badge-info">Processing</span>
                                @break

                            @case('completed')
                                <span class="badge badge-success">Completed</span>
                                @break

                            @case('cancelled')
                                <span class="badge badge-danger">Cancelled</span>
                                @break

                            @default
                                <span class="badge badge-secondary">
                                    {{ ucfirst($order->status) }}
                                </span>

                        @endswitch

                    </td>

                    <td>

                        <a href="{{ route('store.orders.show',$order) }}"
                           class="btn btn-sm btn-primary">

                            View Details

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

            <h4>No Orders Yet</h4>

            <a href="{{ route('store.shop') }}" class="btn btn-primary mt-3">
                Start Shopping
            </a>

        </div>

    @endif

</div>

@endsection