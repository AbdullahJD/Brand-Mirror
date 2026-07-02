@extends('Dashboard.layouts.master')

@section('title')
Edit Attribute
@endsection

@section('content')

<div class="container-xxl">

    <div class="card">

        <div class="card-header">
            <h2>Edit Attribute</h2>
        </div>

        <form method="POST"
              action="{{ route('attributes.update',$attribute->id) }}">

            @csrf
            @method('PUT')

            <div class="card-body">

                <label class="required form-label">
                    Arabic Attribute Name
                </label>

                <input type="text"
                       name="name_ar"
                       class="form-control"
                       value="{{ old('name_ar', $attribute->name_ar) }}">

                <label class="required form-label mt-5">
                    English Attribute Name
                </label>

                <input type="text"
                       name="name_en"
                       class="form-control"
                       value="{{ old('name_en', $attribute->name_en) }}">

            </div>

            <div class="card-footer text-end">

                <button type="submit"
                        class="btn btn-primary">
                    {{ __('messages.update') }}
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
