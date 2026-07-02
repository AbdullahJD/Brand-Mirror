@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.add_categories') }}
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post"> 
    <div class="container-xxl">

        <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="card card-flush py-4">

                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('messages.add_category') }}</h2>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Names --}}
                    <div class="mb-5">
                        <label class="required form-label">
                            {{ __('messages.arabic_category_name') }}
                        </label>

                        <input
                            type="text"
                            name="name_ar"
                            class="form-control"
                            placeholder="{{ __('messages.arabic_category_name') }}"
                            value="{{ old('name_ar') }}"
                        >
                    </div>

                    <div class="mb-5">
                        <label class="required form-label">
                            {{ __('messages.english_category_name') }}
                        </label>

                        <input
                            type="text"
                            name="name_en"
                            class="form-control"
                            placeholder="{{ __('messages.english_category_name') }}"
                            value="{{ old('name_en') }}"
                        >
                    </div>

                    <div class="mb-5">
                        <label class="form-label">{{ __('messages.image') }}</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    {{-- Descriptions --}}
                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.arabic_description') }}
                        </label>

                        <textarea
                            name="description_ar"
                            class="form-control"
                            rows="4"
                        >{{ old('description_ar') }}</textarea>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.english_description') }}
                        </label>

                        <textarea
                            name="description_en"
                            class="form-control"
                            rows="4"
                        >{{ old('description_en') }}</textarea>
                    </div>

                    {{-- Parent Category --}}
                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.parent_category') }}
                        </label>

                        <select name="parent_id" class="form-select">
                            <option value="">{{ __('messages.main_category') }}</option>

                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ old('parent_id') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.status') }}
                        </label>

                        <select name="status" class="form-select">
                            <option value="1">{{ __('messages.active') }}</option>
                            <option value="0">{{ __('messages.inactive') }}</option>
                        </select>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        {{ __('messages.save_category') }}
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

@endsection
