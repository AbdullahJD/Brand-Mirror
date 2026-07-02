@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.edit_coupon') }}
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div class="container-xxl">

        <form method="POST" action="{{ route('coupons.update', $coupon->id) }}">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-flush py-4">

                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('messages.edit_coupon') }}</h2>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Code --}}
                    <div class="mb-5">
                        <label class="form-label required">{{ __('messages.coupon_code') }}</label>
                        <input type="text"
                               name="code"
                               class="form-control"
                               value="{{ old('code', $coupon->code) }}">
                    </div>

                    {{-- Type --}}
                    <div class="mb-5">
                        <label class="form-label required">{{ __('messages.coupon_type') }}</label>

                        <select name="type" class="form-select">
                            <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>
                                {{ __('messages.type_percentage') }}
                            </option>

                            <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>
                                {{ __('messages.type_fixed') }}
                            </option>
                        </select>
                    </div>

                    {{-- Value --}}
                    <div class="mb-5">
                        <label class="form-label required">{{ __('messages.coupon_value') }}</label>
                        <input type="number"
                               name="value"
                               class="form-control"
                               value="{{ old('value', $coupon->value) }}">
                    </div>

                    {{-- Min Order --}}
                    <div class="mb-5">
                        <label class="form-label">{{ __('messages.min_order_amount') }}</label>
                        <input type="number"
                               name="min_order_amount"
                               class="form-control"
                               value="{{ old('min_order_amount', $coupon->min_order_amount) }}">
                    </div>

                    {{-- Max Discount --}}
                    <div class="mb-5">
                        <label class="form-label">{{ __('messages.max_discount') }}</label>
                        <input type="number"
                               name="max_discount"
                               class="form-control"
                               value="{{ old('max_discount', $coupon->max_discount) }}">
                    </div>

                    {{-- Usage Limit --}}
                    <div class="mb-5">
                        <label class="form-label">{{ __('messages.usage_limit') }}</label>
                        <input type="number"
                               name="usage_limit"
                               class="form-control"
                               value="{{ old('usage_limit', $coupon->usage_limit) }}">
                    </div>

                    {{-- Start / End --}}
                    <div class="row mb-5">

                        <div class="col">
                            <label class="form-label">{{ __('messages.start_at') }}</label>
                            <input type="date"
                                   name="start_at"
                                   class="form-control"
                                   value="{{ optional($coupon->start_at)->format('Y-m-d') }}">
                        </div>

                        <div class="col">
                            <label class="form-label">{{ __('messages.end_at') }}</label>
                            <input type="date"
                                   name="end_at"
                                   class="form-control"
                                   value="{{ optional($coupon->end_at)->format('Y-m-d') }}">
                        </div>

                    </div>

                    {{-- Active --}}
                    <div class="mb-5 form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               name="is_active"
                               {{ $coupon->is_active ? 'checked' : '' }}>

                        <label class="form-check-label">
                            {{ __('messages.active') }}
                        </label>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        {{ __('messages.update_coupon') }}
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

@endsection
