@extends('Store.layouts.master')

@section('title')
{{ __('messages.shopping_cart') }}
@endsection

@section('content')

<div class="container-fluid py-5">
    <div class="row px-xl-5">

        <div class="col-lg-8 table-responsive mb-5">

            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>{{ __('messages.product') }}</th>
                        <th>{{ __('messages.price') }}</th>
                        <th>{{ __('messages.quantity') }}</th>
                        <th>{{ __('messages.total') }}</th>
                        <th>{{ __('messages.remove') }}</th>
                    </tr>
                </thead>

                <tbody id="cart-tbody" class="align-middle">

                @foreach($cart->items as $item)
                    <tr>
                        <td class="align-middle">
                            {{ $item->product->name }}
                        </td>

                        <td class="align-middle">
                            @if($item->product->discount_price)
                                <span class="text-muted text-decoration-line-through">
                                    ${{ $item->product->price }}
                                </span>
                                <br>
                                <strong class="text-success">
                                    ${{ $item->product->discount_price }}
                                </strong>
                            @else
                                <strong>
                                    ${{ $item->product->price }}
                                </strong>
                            @endif
                        </td>

                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <input type="number"
                                       class="form-control form-control-sm bg-secondary border-0 text-center"
                                       value="{{ $item->quantity }}"
                                       onchange="updateQuantity({{ $item->id }}, this.value)">
                            </div>
                        </td>

                        <td class="align-middle">
                            ${{ $item->subtotal }}
                        </td>

                        <td class="align-middle">
                            <button class="btn btn-sm btn-danger"
                                    onclick="removeItem({{ $item->id }})">
                                {{ __('messages.remove_short') }}
                            </button>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>

        <div class="col-lg-4">

            <div class="bg-light p-30 mb-5">

                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="bg-secondary pr-3">{{ __('messages.cart_summary') }}</span>
                </h5>

                <div class="d-flex justify-content-between mb-2">
                    <h6>{{ __('messages.items') }}</h6>
                    <h6 id="page-cart-count">{{ $cart->items->sum('quantity') }}</h6>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <h6>{{ __('messages.subtotal') }}</h6>
                    <h6 id="cart-subtotal">
                        ${{ $cart->items->sum('subtotal') }}
                    </h6>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <h6>{{ __('messages.shipping') }}</h6>
                    <h6 id="shipping-cost">$5.00</h6>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <h6>{{ __('messages.total') }}</h6>
                    <h6 id="total-before-coupon">
                        ${{ $cart->items->sum('subtotal') + 5 }}
                    </h6>
                </div>

                <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                    <h5>{{ __('messages.total_to_pay') }}</h5>
                    <h5 id="final-total">
                        ${{ $cart->items->sum('subtotal') + 5 }}
                    </h5>
                </div>

                <div class="text-muted small mt-2">
                    {{ __('messages.estimated_delivery') }}
                </div>

                <a href="{{ route('store.checkout') }}"
                class="btn btn-block btn-primary font-weight-bold py-3">
                    {{ __('messages.proceed_to_checkout') }}
                </a>

                <button class="btn btn-outline-danger btn-block mt-2"
                        onclick="clearCart()">
                    {{ __('messages.clear_cart') }}
                </button>

            </div>
        </div>

    </div>
</div>

@endsection
