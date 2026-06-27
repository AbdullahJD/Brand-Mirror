@extends('Store.layouts.master')

@section('title')
Shopping Cart
@endsection

@section('content')

<div class="container-fluid py-5">
    <div class="row px-xl-5">

        <div class="col-lg-8 table-responsive mb-5">

            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
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
                                X
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
                    <span class="bg-secondary pr-3">Cart Summary</span>
                </h5>

                <!-- ITEMS -->
                <div class="d-flex justify-content-between mb-2">
                    <h6>Items</h6>
                    <h6 id="page-cart-count">{{ $cart->items->sum('quantity') }}</h6>
                </div>

                <!-- SUBTOTAL -->
                <div class="d-flex justify-content-between mb-2">
                    <h6>Subtotal</h6>
                    <h6 id="cart-subtotal">
                        ${{ $cart->items->sum('subtotal') }}
                    </h6>
                </div>

                <!-- SHIPPING -->
                <div class="d-flex justify-content-between mb-2">
                    <h6>Shipping</h6>
                    <h6 id="shipping-cost">$5.00</h6>
                </div>

                <hr>

                <!-- TOTAL BEFORE COUPON -->
                <div class="d-flex justify-content-between mb-2">
                    <h6>Total</h6>
                    <h6 id="total-before-coupon">
                        ${{ $cart->items->sum('subtotal') + 5 }}
                    </h6>
                </div>

                <!-- FINAL TOTAL -->
                <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                    <h5>Total to Pay</h5>
                    <h5 id="final-total">
                        ${{ $cart->items->sum('subtotal') + 5 }}
                    </h5>
                </div>

                <!-- DELIVERY INFO -->
                <div class="text-muted small mt-2">
                    Estimated delivery: 2–5 days
                </div>

                <!-- CHECKOUT -->
                <a href="{{ route('store.checkout') }}"
                class="btn btn-block btn-primary font-weight-bold py-3">
                    Proceed To Checkout
                </a>

                <!-- CLEAR CART -->
                <button class="btn btn-outline-danger btn-block mt-2"
                        onclick="clearCart()">
                    Clear Cart
                </button>

            </div>
        </div>

    </div>
</div>

@endsection