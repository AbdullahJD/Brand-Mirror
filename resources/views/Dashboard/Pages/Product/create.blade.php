@extends('Dashboard.layouts.master')

@section('content')

<div class="post d-flex flex-column-fluid">
    <div id="kt_content_container" class="container-xxl">

        <form method="POST"
              action="{{ route('products.store') }}"
              enctype="multipart/form-data">

            @csrf

            <div class="card card-flush">

                <div class="card-header">
                    <div class="card-title">
                        <h2>Add Product</h2>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Product Name --}}
                    <div class="mb-5">
                        <label class="required form-label">
                            Product Name
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name') }}">
                    </div>

                    {{-- Category --}}
                    <div class="mb-5">
                        <label class="required form-label">
                            Category
                        </label>

                        <select name="category_id"
                                class="form-select"
                                data-control="select2">

                            <option value="">
                                Select Category
                            </option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Description --}}
                    <div class="mb-5">
                        <label class="form-label">
                            Description
                        </label>

                        <textarea name="description"
                                  rows="5"
                                  class="form-control">{{ old('description') }}</textarea>
                    </div>

                    {{-- Price --}}
                    <div class="mb-5">
                        <label class="required form-label">
                            Price
                        </label>

                        <input type="number"
                               step="0.01"
                               name="price"
                               class="form-control"
                               value="{{ old('price') }}">
                    </div>

                    {{-- Discount Price --}}
                    <div class="mb-5">
                        <label class="form-label">
                            Discount Price
                        </label>

                        <input type="number"
                               step="0.01"
                               name="discount_price"
                               class="form-control"
                               value="{{ old('discount_price') }}">
                    </div>

                    {{-- Stock --}}
                    <div class="mb-5">
                        <label class="required form-label">
                            Stock
                        </label>

                        <input type="number"
                               name="stock"
                               class="form-control"
                               value="{{ old('stock',0) }}">
                    </div>

                    {{-- Main Image --}}
                    <div class="mb-5">
                        <label class="form-label">
                            Main Image
                        </label>

                        <input type="file"
                               name="main_image"
                               class="form-control">
                    </div>

                    {{-- Gallery Images --}}
                    <div class="mb-5">
                        <label class="form-label">
                            Product Gallery
                        </label>

                        <input type="file"
                               name="images[]"
                               multiple
                               class="form-control">
                    </div>

                    {{-- Featured --}}
                    <div class="mb-5">

                        <div class="form-check form-switch">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_featured"
                                   value="1">

                            <label class="form-check-label">
                                Featured Product
                            </label>

                        </div>

                    </div>

                    {{-- Status --}}
                    <div class="mb-5">

                        <label class="required form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="published">
                                Published
                            </option>

                            <option value="Scheduled">
                                Scheduled
                            </option>

                            <option value="draft" selected>
                                Draft
                            </option>

                            <option value="inactive">
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

                <div class="card-footer text-end">

                    <a href="{{ route('products.index') }}"
                       class="btn btn-light me-3">
                        Cancel
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        Save Product
                    </button>

                </div>

            </div>

        </form>

    </div>
</div>

@endsection