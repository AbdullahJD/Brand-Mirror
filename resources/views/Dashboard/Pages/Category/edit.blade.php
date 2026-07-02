@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.edit_categories') }}
@endsection

@section('content')

<div class="post d-flex flex-column-fluid">
    <div class="container-xxl">

        <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card card-flush py-4">

                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('messages.edit_category') }}</h2>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Names --}}
                    <div class="mb-5">
                        <label class="form-label">{{ __('messages.arabic_category_name') }}</label>
                        <input type="text" name="name_ar"
                               value="{{ old('name_ar', $category->name_ar) }}"
                               class="form-control">
                    </div>

                    <div class="mb-5">
                        <label class="form-label">{{ __('messages.english_category_name') }}</label>
                        <input type="text" name="name_en"
                               value="{{ old('name_en', $category->name_en) }}"
                               class="form-control">
                    </div>
                    
                    <div class="mb-5">
                        <label class="form-label">{{ __('messages.image') }}</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    
                    {{-- Descriptions --}}
                    <div class="mb-5">
                        <label class="form-label">{{ __('messages.arabic_description') }}</label>
                        <textarea name="description_ar" class="form-control">{{ old('description_ar', $category->description_ar) }}</textarea>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">{{ __('messages.english_description') }}</label>
                        <textarea name="description_en" class="form-control">{{ old('description_en', $category->description_en) }}</textarea>
                    </div>

                    {{-- Parent --}}
                    <div class="mb-5">
                        <label class="form-label">{{ __('messages.parent_category') }}</label>

                        <select name="parent_id" class="form-select">
                            <option value="">{{ __('messages.main_category') }}</option>

                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="mb-5">
                        <label class="form-label">{{ __('messages.status') }}</label>

                        <select name="status" class="form-select">
                            <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>
                                {{ __('messages.active') }}
                            </option>
                            <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>
                                {{ __('messages.inactive') }}
                            </option>
                        </select>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <button class="btn btn-primary">
                        {{ __('messages.update_category') }}
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

@endsection
