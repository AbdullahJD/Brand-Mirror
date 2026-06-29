@extends('Dashboard.layouts.master')

@section('title')
Add Coupons
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div class="container-xxl">

        <form method="POST" action="{{ route('coupons.store') }}">
            @csrf

            
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
                        <h2>Create Coupon</h2>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Code --}}
                    <div class="mb-5">
                        <label class="form-label required">Coupon Code</label>
                        <input type="text"
                               name="code"
                               class="form-control"
                               placeholder="SAVE10"
                               value="{{ old('code') }}">
                    </div>

                    {{-- Type --}}
                    <div class="mb-5">
                        <label class="form-label required">Type</label>

                        <select name="type" class="form-select">
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed</option>
                        </select>
                    </div>

                    {{-- Value --}}
                    <div class="mb-5">
                        <label class="form-label required">Value</label>
                        <input type="number"
                               name="value"
                               class="form-control"
                               value="{{ old('value') }}">
                    </div>

                    {{-- Min Order --}}
                    <div class="mb-5">
                        <label class="form-label">Min Order Amount</label>
                        <input type="number"
                               name="min_order_amount"
                               class="form-control"
                               value="{{ old('min_order_amount') }}">
                    </div>

                    {{-- Max Discount --}}
                    <div class="mb-5">
                        <label class="form-label">Max Discount</label>
                        <input type="number"
                               name="max_discount"
                               class="form-control"
                               value="{{ old('max_discount') }}">
                    </div>

                    {{-- Usage Limit --}}
                    <div class="mb-5">
                        <label class="form-label">Usage Limit</label>
                        <input type="number"
                               name="usage_limit"
                               class="form-control"
                               value="{{ old('usage_limit') }}">
                    </div>

                    {{-- Dates --}}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="form-label">Start At</label>
                            <input type="date" name="start_at" class="form-control">
                        </div>

                        <div class="col">
                            <label class="form-label">End At</label>
                            <input type="date" name="end_at" class="form-control">
                        </div>
                    </div>

                    {{-- Active --}}
                    <div class="mb-5 form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               name="is_active"
                               checked>
                        <label class="form-check-label">{{ __('messages.active') }}</label>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        Save Coupon
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>

@endsection