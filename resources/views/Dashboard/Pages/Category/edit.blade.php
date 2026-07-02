@extends('Dashboard.layouts.master')

@section('title')
Edit Categories
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
                        <h2>Edit Category</h2>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Names --}}
                    <div class="mb-5">
                        <label class="form-label">Arabic Category Name</label>
                        <input type="text" name="name_ar"
                               value="{{ old('name_ar', $category->name_ar) }}"
                               class="form-control">
                    </div>

                    <div class="mb-5">
                        <label class="form-label">English Category Name</label>
                        <input type="text" name="name_en"
                               value="{{ old('name_en', $category->name_en) }}"
                               class="form-control">
                    </div>
                    
                    <div class="mb-5">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    
                    {{-- Descriptions --}}
                    <div class="mb-5">
                        <label class="form-label">Arabic Description</label>
                        <textarea name="description_ar" class="form-control">{{ old('description_ar', $category->description_ar) }}</textarea>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">English Description</label>
                        <textarea name="description_en" class="form-control">{{ old('description_en', $category->description_en) }}</textarea>
                    </div>

                    {{-- Parent --}}
                    <div class="mb-5">
                        <label class="form-label">Parent Category</label>

                        <select name="parent_id" class="form-select">
                            <option value="">Main Category</option>

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
                        <label class="form-label">Status</label>

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
                        Update Category
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

@endsection
