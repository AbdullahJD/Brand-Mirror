@extends('Dashboard.layouts.master')

@section('title')
Add Product Variants
@endsection

@section('content')

<div class="post d-flex flex-column-fluid">

    <div id="kt_content_container" class="container-xxl">

        <form method="POST"
              action="{{ route('product-variants.store') }}">

            @csrf

            <div class="card card-flush">

                <div class="card-header">

                    <div class="card-title">
                        <h2>Add Product Variant</h2>
                    </div>

                </div>

                <div class="card-body">

                    {{-- Validation Errors --}}
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
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>

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
                               placeholder="Example: TS-RED-XL"
                               value="{{ old('sku') }}">

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
                                       value="{{ old('price') }}">

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
                                       value="{{ old('quantity', 0) }}">

                            </div>

                        </div>

                    </div>

                    {{-- Attributes --}}
                    <div class="mb-7">

                        <label class="form-label fs-5 fw-bold">
                            Attributes
                        </label>

                        <div class="row">

                            @php
                                $groupedAttributes = $attributeValues->groupBy(function ($item) {
                                    return $item->attribute->name;
                                });
                            @endphp

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
                                                        {{ in_array($value->id, old('attribute_values', [])) ? 'checked' : '' }}
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
                                {{ old('status', 1) == 1 ? 'selected' : '' }}>

                                Active

                            </option>

                            <option value="0"
                                {{ old('status') === "0" ? 'selected' : '' }}>

                                Inactive

                            </option>

                        </select>

                    </div>

                </div>

                <div class="card-footer d-flex justify-content-end">

                    <a href="{{ route('product-variants.index') }}"
                       class="btn btn-light me-3">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        Save Variant

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection