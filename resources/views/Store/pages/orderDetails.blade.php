@extends('Store.layouts.master')

@section('title')
{{ __('messages.order_details') }}
@endsection

@section('content')

<div class="container py-5">

    <div class="row">

        <div class="col-lg-8">

            <div class="card shadow-sm mb-4">

                <div class="card-header">
                    <h4 class="mb-0">
                        {{ __('messages.order_number_heading', ['number' => $order->order_number]) }}
                    </h4>
                </div>

                <div class="card-body">

                    <table class="table align-middle">

                        <thead>
                            <tr>
                                <th>{{ __('messages.product') }}</th>
                                <th>{{ __('messages.price') }}</th>
                                <th>{{ __('messages.qty') }}</th>
                                <th>{{ __('messages.total') }}</th>
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
                    <h5>{{ __('messages.order_summary') }}</h5>
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('messages.subtotal') }}</span>
                        <strong>${{ number_format($order->subtotal,2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('messages.discount') }}</span>
                        <strong>
                            -${{ number_format($order->discount,2) }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('messages.shipping') }}</span>
                        <strong>${{ number_format($order->shipping_cost,2) }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">

                        <h5>{{ __('messages.total') }}</h5>

                        <h5 class="text-success">
                            ${{ number_format($order->final_total,2) }}
                        </h5>

                    </div>

                    <hr>

                    <p>
                        <strong>{{ __('messages.status') }}:</strong>

                        <span class="badge bg-warning">
                            {{ __('messages.status_' . $order->status) }}
                        </span>
                    </p>

                    <p>
                        <strong>{{ __('messages.payment') }}:</strong>

                        {{ ucfirst($order->payment_method) }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
