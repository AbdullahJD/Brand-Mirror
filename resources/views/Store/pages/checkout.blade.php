@extends('Store.layouts.master')

@section('title')
{{ __('messages.checkout') }}
@endsection

@section('content')

<div class="container py-5">

    <div class="row g-5">

        <div class="col-lg-7">

            <div class="bg-white p-4 shadow-sm rounded">

                <h4 class="mb-4">{{ __('messages.checkout_details') }}</h4>

                <form id="checkout-form">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.full_name') }}</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="{{ __('messages.enter_your_name') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.phone_number') }}</label>
                        <input type="text"
                               name="phone"
                               class="form-control"
                               placeholder="{{ __('messages.phone_placeholder') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.delivery_address') }}</label>
                        <textarea name="address"
                                  class="form-control"
                                  rows="3"
                                  placeholder="{{ __('messages.address_placeholder') }}"
                                  required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.coupon_code_optional') }}</label>

                        <div class="input-group">
                            <input type="text"
                                id="coupon-code"
                                name="coupon_code"
                                class="form-control"
                                placeholder="{{ __('messages.coupon_placeholder') }}">

                            <button type="button"
                                    class="btn btn-success"
                                    onclick="applyCouponCheckout()">
                                {{ __('messages.apply') }}
                            </button>
                        </div>

                        <small id="coupon-message" class="text-muted"></small>
                    </div>

                    <button type="submit"
                            class="btn btn-dark w-100 py-3 mt-3">
                        {{ __('messages.confirm_order') }}
                    </button>

                </form>

            </div>

        </div>

        <div class="col-lg-5">

            <div class="bg-light p-4 rounded shadow-sm">

                <h5 class="mb-4">{{ __('messages.order_summary') }}</h5>

                @foreach($cart->items as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>
                            {{ $item->product->name }} × {{ $item->quantity }}
                        </span>
                        <strong>${{ $item->subtotal }}</strong>
                    </div>
                @endforeach

                <hr>

                <div class="d-flex justify-content-between">
                    <span>{{ __('messages.subtotal') }}</span>
                    <strong>${{ $cart->items->sum('subtotal') }}</strong>
                </div>

                <div class="d-flex justify-content-between">
                    <span>{{ __('messages.shipping') }}</span>
                    <strong>$5.00</strong>
                </div>

                <div class="d-flex justify-content-between text-success">
                    <span>{{ __('messages.discount') }}</span>
                    <strong id="discount-value">
                        - ${{ $cart->discount ?? 0 }}
                    </strong>
                </div>

                <hr>

                <div class="d-flex justify-content-between fs-5">
                    <span><strong>{{ __('messages.total') }}</strong></span>
                    <strong id="final-total">
                        ${{ $cart->items->sum('subtotal') + 5 - ($cart->discount ?? 0) }}
                    </strong>
                </div>

                <div class="text-muted small mt-3">
                    {{ __('messages.cash_on_delivery_note') }}
                </div>

            </div>

        </div>

    </div>
</div>

@endsection


@section('js')
<script>
    const checkoutI18n = {
        processing: @json(__('messages.processing')),
        orderCreated: @json(__('messages.order_created')),
        orderNumber: @json(__('messages.order_number_label')),
        error: @json(__('messages.error')),
        somethingWrong: @json(__('messages.something_went_wrong')),
        serverError: @json(__('messages.server_error')),
        tryAgainLater: @json(__('messages.try_again_later')),
        confirmOrder: @json(__('messages.confirm_order')),
    };

    document.getElementById('checkout-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerText = checkoutI18n.processing;

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

            if (data.status) {
                Swal.fire({
                    icon: 'success',
                    title: checkoutI18n.orderCreated,
                    text: checkoutI18n.orderNumber.replace(':number', data.order_number),
                }).then(() => {
                    window.location.href = "/checkout/success/" + data.order_id;
                });

            } else {
                Swal.fire({
                    icon: 'error',
                    title: checkoutI18n.error,
                    text: data.message || checkoutI18n.somethingWrong
                });
            }

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: checkoutI18n.serverError,
                text: checkoutI18n.tryAgainLater
            });
        }

        btn.disabled = false;
        btn.innerText = checkoutI18n.confirmOrder;
    });
</script>
@endsection
