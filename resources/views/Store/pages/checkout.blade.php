@extends('Store.layouts.master')

@section('title')
Check Out
@endsection

@section('content')

<div class="container py-5">

    <div class="row g-5">

        <!-- LEFT SIDE: FORM -->
        <div class="col-lg-7">

            <div class="bg-white p-4 shadow-sm rounded">

                <h4 class="mb-4">Checkout Details</h4>

                <form id="checkout-form">
                    @csrf

                    <!-- NAME -->
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Enter your name"
                               required>
                    </div>

                    <!-- PHONE -->
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text"
                               name="phone"
                               class="form-control"
                               placeholder="059xxxxxxx"
                               required>
                    </div>

                    <!-- ADDRESS -->
                    <div class="mb-3">
                        <label class="form-label">Delivery Address</label>
                        <textarea name="address"
                                  class="form-control"
                                  rows="3"
                                  placeholder="City, Street, House number"
                                  required></textarea>
                    </div>

                    <!-- COUPON -->
                    <div class="mb-3">
                        <label class="form-label">Coupon Code (optional)</label>

                        <div class="input-group">
                            <input type="text"
                                id="coupon-code"
                                name="coupon_code"
                                class="form-control"
                                placeholder="SAVE10">

                            <button type="button"
                                    class="btn btn-success"
                                    onclick="applyCouponCheckout()">
                                Apply
                            </button>
                        </div>

                        <small id="coupon-message" class="text-muted"></small>
                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                            class="btn btn-dark w-100 py-3 mt-3">
                        Confirm Order
                    </button>

                </form>

            </div>

        </div>

        <!-- RIGHT SIDE: ORDER SUMMARY -->
        <div class="col-lg-5">

            <div class="bg-light p-4 rounded shadow-sm">

                <h5 class="mb-4">Order Summary</h5>

                <!-- ITEMS -->
                @foreach($cart->items as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>
                            {{ $item->product->name }} × {{ $item->quantity }}
                        </span>
                        <strong>${{ $item->subtotal }}</strong>
                    </div>
                @endforeach

                <hr>

                <!-- SUBTOTAL -->
                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <strong>${{ $cart->items->sum('subtotal') }}</strong>
                </div>

                <!-- SHIPPING -->
                <div class="d-flex justify-content-between">
                    <span>Shipping</span>
                    <strong>$5.00</strong>
                </div>

                <!-- DISCOUNT -->
                <div class="d-flex justify-content-between text-success">
                    <span>Discount</span>
                    <strong id="discount-value">
                        - ${{ $cart->discount ?? 0 }}
                    </strong>
                </div>

                <hr>

                <!-- TOTAL -->
                <div class="d-flex justify-content-between fs-5">
                    <span><strong>Total</strong></span>
                    <strong id="final-total">
                        ${{ $cart->items->sum('subtotal') + 5 - ($cart->discount ?? 0) }}
                    </strong>
                </div>

                <div class="text-muted small mt-3">
                    🚚 Cash on delivery — Pay when you receive your order
                </div>

            </div>

        </div>

    </div>
</div>

@endsection


@section('js')
<script>
    document.getElementById('checkout-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerText = 'Processing...';

        try {
            const response = await fetch("{{ route('store.checkout') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name: this.name.value,
                    phone: this.phone.value,
                    address: this.address.value,
                    coupon_code: this.coupon_code.value
                })
            });

            const data = await response.json();
            console.log(data);
            if (data.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Order Created 🎉',
                    text: 'Order #' + data.order_number,
                }).then(() => {
                    window.location.href = "/checkout/success/" + data.order_id;
                });

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Something went wrong'
                });
            }

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Please try again later'
            });
        }

        btn.disabled = false;
        btn.innerText = 'Confirm Order';
    });
</script>
@endsection
