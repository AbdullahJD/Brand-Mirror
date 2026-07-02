@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.add_product_heading') }}
@endsection

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
                        <h2>{{ __('messages.add_product_heading') }}</h2>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Product Names --}}
                    <div class="mb-5">
                        <label class="required form-label">
                            {{ __('messages.arabic_product_name') }}
                        </label>

                        <input type="text"
                               name="name_ar"
                               class="form-control"
                               value="{{ old('name_ar') }}">
                    </div>

                    <div class="mb-5">
                        <label class="required form-label">
                            {{ __('messages.english_product_name') }}
                        </label>

                        <input type="text"
                               name="name_en"
                               class="form-control"
                               value="{{ old('name_en') }}">
                    </div>

                    {{-- Category --}}
                    <div class="mb-5">
                        <label class="required form-label">
                            {{ __('messages.category') }}
                        </label>

                        <select name="category_id"
                                class="form-select"
                                data-control="select2">

                            <option value="">
                                {{ __('messages.select_category') }}
                            </option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Descriptions --}}
                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.arabic_description') }}
                        </label>

                        <textarea name="description_ar"
                                  rows="5"
                                  class="form-control">{{ old('description_ar') }}</textarea>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.english_description') }}
                        </label>

                        <textarea name="description_en"
                                  rows="5"
                                  class="form-control">{{ old('description_en') }}</textarea>
                    </div>

                    {{-- Price --}}
                    <div class="mb-5">
                        <label class="required form-label">
                            {{ __('messages.price') }}
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
                            {{ __('messages.discount_price') }}
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
                            {{ __('messages.stock') }}
                        </label>

                        <input type="number"
                               name="stock"
                               class="form-control"
                               value="{{ old('stock',0) }}">
                    </div>

                    {{-- Main Image --}}
                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.main_image') }}
                        </label>

                        <input type="file"
                               name="main_image"
                               class="form-control">
                    </div>

                    {{-- Gallery Images --}}
                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.product_gallery') }}
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
                                {{ __('messages.featured_product') }}
                            </label>

                        </div>

                    </div>

                    {{-- Arabic Additional Information --}}
                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.arabic_additional_information') }}
                        </label>

                        <div id="info-wrapper-ar">

                            <div class="row mb-2">
                                <div class="col-md-5">
                                    <input type="text"
                                        name="info_keys_ar[]"
                                        class="form-control"
                                        placeholder="{{ __('messages.info_key_placeholder') }}">
                                </div>

                                <div class="col-md-5">
                                    <input type="text"
                                        name="info_values_ar[]"
                                        class="form-control"
                                        placeholder="{{ __('messages.info_value_placeholder') }}">
                                </div>

                                <div class="col-md-2">
                                    <button type="button"
                                            class="btn btn-danger remove-info">
                                        {{ __('messages.remove_short') }}
                                    </button>
                                </div>
                            </div>

                        </div>

                        <button type="button"
                                class="btn btn-light-primary mt-2"
                                data-add-info="info-wrapper-ar"
                                data-info-key-name="info_keys_ar[]"
                                data-info-value-name="info_values_ar[]">
                            {{ __('messages.add_arabic_information') }}
                        </button>
                    </div>

                    {{-- English Additional Information --}}
                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.english_additional_information') }}
                        </label>

                        <div id="info-wrapper-en">

                            <div class="row mb-2">
                                <div class="col-md-5">
                                    <input type="text"
                                        name="info_keys_en[]"
                                        class="form-control"
                                        placeholder="{{ __('messages.info_key_placeholder') }}">
                                </div>

                                <div class="col-md-5">
                                    <input type="text"
                                        name="info_values_en[]"
                                        class="form-control"
                                        placeholder="{{ __('messages.info_value_placeholder') }}">
                                </div>

                                <div class="col-md-2">
                                    <button type="button"
                                            class="btn btn-danger remove-info">
                                        {{ __('messages.remove_short') }}
                                    </button>
                                </div>
                            </div>

                        </div>

                        <button type="button"
                                class="btn btn-light-primary mt-2"
                                data-add-info="info-wrapper-en"
                                data-info-key-name="info_keys_en[]"
                                data-info-value-name="info_values_en[]">
                            {{ __('messages.add_english_information') }}
                        </button>
                    </div>

                    {{-- Status --}}
                    <div class="mb-5">

                        <label class="required form-label">
                            {{ __('messages.status') }}
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="published">
                                {{ __('messages.published') }}
                            </option>

                            <option value="Scheduled">
                                {{ __('messages.scheduled') }}
                            </option>

                            <option value="draft" selected>
                                {{ __('messages.draft') }}
                            </option>

                            <option value="inactive">
                                {{ __('messages.inactive') }}
                            </option>

                        </select>

                    </div>

                </div>

                <div class="card-footer text-end">

                    <a href="{{ route('products.index') }}"
                       class="btn btn-light me-3">
                        {{ __('messages.cancel') }}
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        {{ __('messages.save_product') }}
                    </button>

                </div>

            </div>

        </form>

    </div>
</div>

@endsection
