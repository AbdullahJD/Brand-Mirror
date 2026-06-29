@extends('Dashboard.layouts.master')

@section('title')
Edit Product Variants
@endsection

@section('content')

<div class="post d-flex flex-column-fluid">

    <div id="kt_content_container" class="container-xxl">

        <form method="POST"
              action="{{ route('product-variants.update',$productVariant->id) }}">

            @csrf
            @method('PUT')

            <div class="card card-flush">

                <div class="card-header">

                    <div class="card-title">
                        <h2>Edit Product Variant</h2>
                    </div>

                </div>

                <div class="card-body">

                    @if ($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach ($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    {{-- Product --}}
                    <div class="mb-7">

                        <label class="required form-label">
                            Product
                        </label>

                        <select name="product_id"
                                class="form-select"
                                data-control="select2">

                            <option value="">
                                Select Product
                            </option>

                            @foreach($products as $product)

                                <option value="{{ $product->id }}"
                                    {{ old('product_id',$productVariant->product_id) == $product->id ? 'selected' : '' }}>

                                    {{ $product->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- SKU --}}
                    <div class="mb-7">

                        <label class="form-label">
                            SKU
                        </label>

                        <input type="text"
                               name="sku"
                               class="form-control"
                               value="{{ old('sku',$productVariant->sku) }}">

                    </div>

                    <div class="row">

                        {{-- Price --}}
                        <div class="col-md-6">

                            <div class="mb-7">

                                <label class="form-label">
                                    Price
                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="price"
                                       class="form-control"
                                       value="{{ old('price',$productVariant->price) }}">

                            </div>

                        </div>

                        {{-- Quantity --}}
                        <div class="col-md-6">

                            <div class="mb-7">

                                <label class="required form-label">
                                    Quantity
                                </label>

                                <input type="number"
                                       name="quantity"
                                       class="form-control"
                                       value="{{ old('quantity',$productVariant->quantity) }}">

                            </div>

                        </div>

                    </div>

                    {{-- Attributes --}}
                    <div class="mb-7">

                        <label class="form-label fs-5 fw-bold">
                            {{ __('messages.attributes') }}
                        </label>

                        @php

                            $selectedAttributes =
                                old(
                                    'attribute_values',
                                    $productVariant
                                        ->attributeValues
                                        ->pluck('id')
                                        ->toArray()
                                );

                            $groupedAttributes =
                                $attributeValues->groupBy(
                                    fn($item) => $item->attribute->name
                                );

                        @endphp

                        <div class="row">

                            @foreach($groupedAttributes as $attributeName => $values)

                                <div class="col-md-4 mb-5">

                                    <div class="card border">

                                        <div class="card-header min-h-50px">

                                            <h5 class="mb-0">
                                                {{ $attributeName }}
                                            </h5>

                                        </div>

                                        <div class="card-body">

                                            @foreach($values as $value)

                                                <div class="form-check mb-3">

                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        name="attribute_values[]"
                                                        value="{{ $value->id }}"
                                                        id="attr_{{ $value->id }}"
                                                        {{ in_array($value->id,$selectedAttributes) ? 'checked' : '' }}
                                                    >

                                                    <label
                                                        class="form-check-label"
                                                        for="attr_{{ $value->id }}"
                                                    >
                                                        {{ $value->value }}
                                                    </label>

                                                </div>

                                            @endforeach

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                    {{-- Status --}}
                    <div class="mb-7">

                        <label class="required form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="1"
                                {{ old('status',$productVariant->status) == 1 ? 'selected' : '' }}>

                                {{ __('messages.active') }}

                            </option>

                            <option value="0"
                                {{ old('status',$productVariant->status) == 0 ? 'selected' : '' }}>

                                {{ __('messages.inactive') }}

                            </option>

                        </select>

                    </div>

                </div>

                <div class="card-footer d-flex justify-content-end">

                    <a href="{{ route('product-variants.index') }}"
                       class="btn btn-light me-3">

                        {{ __('messages.cancel') }}

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        Update Variant

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection