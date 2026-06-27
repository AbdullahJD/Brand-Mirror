@extends('Store.layouts.master')

@section('title')
Order Details
@endsection

@section('content')

<div class="container py-5">

    <div class="row">

        <div class="col-lg-8">

            <div class="card shadow-sm mb-4">

                <div class="card-header">
                    <h4 class="mb-0">
                        Order #{{ $order->order_number }}
                    </h4>
                </div>

                <div class="card-body">

                    <table class="table align-middle">

                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($order->items as $item)

                            <tr>

                                <td class="d-flex align-items-center">

                                    <img src="{{ asset('storage/'.$item->product->main_image) }}"
                                         width="70"
                                         class="rounded me-3">

                                    {{ $item->product_name }}

                                </td>

                                <td>
                                    ${{ number_format($item->price,2) }}
                                </td>

                                <td>
                                    {{ $item->quantity }}
                                </td>

                                <td>
                                    ${{ number_format($item->subtotal,2) }}
                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow-sm">

                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong>${{ number_format($order->subtotal,2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount</span>
                        <strong>
                            -${{ number_format($order->discount,2) }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <strong>${{ number_format($order->shipping_cost,2) }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">

                        <h5>Total</h5>

                        <h5 class="text-success">
                            ${{ number_format($order->final_total,2) }}
                        </h5>

                    </div>

                    <hr>

                    <p>
                        <strong>Status:</strong>

                        <span class="badge bg-warning">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>

                    <p>
                        <strong>Payment:</strong>

                        {{ ucfirst($order->payment_method) }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection