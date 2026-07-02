@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.edit_product') }}
@endsection

@section('content')

<div class="post d-flex flex-column-fluid">
    <div id="kt_content_container" class="container-xxl">

        <form method="POST"
              action="{{ route('products.update',$product->id) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="card card-flush">

                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('messages.edit_product') }}</h2>
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
                               value="{{ old('name_ar', $product->name_ar) }}">
                    </div>

                    <div class="mb-5">
                        <label class="required form-label">
                            {{ __('messages.english_product_name') }}
                        </label>

                        <input type="text"
                               name="name_en"
                               class="form-control"
                               value="{{ old('name_en', $product->name_en) }}">
                    </div>

                    {{-- Category --}}
                    <div class="mb-5">
                        <label class="required form-label">
                            {{ __('messages.category') }}
                        </label>

                        <select name="category_id"
                                class="form-select"
                                data-control="select2">

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>

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
                                  class="form-control">{{ old('description_ar', $product->description_ar) }}</textarea>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.english_description') }}
                        </label>

                        <textarea name="description_en"
                                  rows="5"
                                  class="form-control">{{ old('description_en', $product->description_en) }}</textarea>
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
                               value="{{ old('price',$product->price) }}">
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
                               value="{{ old('discount_price',$product->discount_price) }}">
                    </div>

                    {{-- Stock --}}
                    <div class="mb-5">
                        <label class="required form-label">
                            {{ __('messages.stock') }}
                        </label>

                        <input type="number"
                               name="stock"
                               class="form-control"
                               value="{{ old('stock',$product->stock) }}">
                    </div>

                    {{-- Current Main Image --}}
                    <div class="mb-5">

                        <label class="form-label">
                            {{ __('messages.current_image') }}
                        </label>

                        <br>

                        @if($product->main_image)

                            <img src="{{ asset('storage/'.$product->main_image) }}"
                                 width="120"
                                 class="rounded border">

                        @endif

                    </div>

                    {{-- New Main Image --}}
                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.change_main_image') }}
                        </label>

                        <input type="file"
                               name="main_image"
                               class="form-control">
                    </div>

                    {{-- Gallery --}}
                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.add_gallery_images') }}
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
                                   value="1"
                                   {{ $product->is_featured ? 'checked' : '' }}>

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

                            @if(!empty($product->additional_information_ar))
                                @foreach($product->additional_information_ar as $key => $value)
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <input type="text"
                                                name="info_keys_ar[]"
                                                class="form-control"
                                                value="{{ $key }}"
                                                placeholder="{{ __('messages.info_key_placeholder') }}">
                                        </div>

                                        <div class="col-md-5">
                                            <input type="text"
                                                name="info_values_ar[]"
                                                class="form-control"
                                                value="{{ $value }}"
                                                placeholder="{{ __('messages.info_value_placeholder') }}">
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button"
                                                    class="btn btn-danger remove-info">
                                                {{ __('messages.remove_short') }}
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else

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

                            @endif

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

                            @if(!empty($product->additional_information_en))
                                @foreach($product->additional_information_en as $key => $value)
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <input type="text"
                                                name="info_keys_en[]"
                                                class="form-control"
                                                value="{{ $key }}"
                                                placeholder="{{ __('messages.info_key_placeholder') }}">
                                        </div>

                                        <div class="col-md-5">
                                            <input type="text"
                                                name="info_values_en[]"
                                                class="form-control"
                                                value="{{ $value }}"
                                                placeholder="{{ __('messages.info_value_placeholder') }}">
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button"
                                                    class="btn btn-danger remove-info">
                                                {{ __('messages.remove_short') }}
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else

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

                            @endif

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

                            <option value="published"
                                {{ $product->status == 'published' ? 'selected' : '' }}>
                                {{ __('messages.published') }}
                            </option>

                            <option value="scheduled"
                                {{ $product->status == 'scheduled' ? 'selected' : '' }}>
                                {{ __('messages.scheduled') }}
                            </option>

                            <option value="draft"
                                {{ $product->status == 'draft' ? 'selected' : '' }}>
                                {{ __('messages.draft') }}
                            </option>

                            <option value="inactive"
                                {{ $product->status == 'inactive' ? 'selected' : '' }}>
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
                        {{ __('messages.update_product') }}
                    </button>

                </div>

            </div>

        </form>

    </div>
</div>

@endsection
