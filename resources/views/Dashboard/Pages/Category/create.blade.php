@extends('Dashboard.layouts.master')

@section('title')
Add Categories
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post"> 
    <div class="container-xxl">

        <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="card card-flush py-4">

                <div class="card-header">
                    <div class="card-title">
                        <h2>Add Category</h2>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Name --}}
                    <div class="mb-5">
                        <label class="required form-label">
                            Category Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Category Name"
                            value="{{ old('name') }}"
                        >
                    </div>

                    <div class="mb-5">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    {{-- Description --}}
                    <div class="mb-5">
                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="4"
                        >{{ old('description') }}</textarea>
                    </div>

                    {{-- Parent Category --}}
                    <div class="mb-5">
                        <label class="form-label">
                            Parent Category
                        </label>

                        <select name="parent_id" class="form-select">
                            <option value="">Main Category</option>

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
                            Status
                        </label>

                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        Save Category
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

@endsection