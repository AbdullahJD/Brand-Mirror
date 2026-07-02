@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.edit_attribute') }}
@endsection

@section('content')

<div class="container-xxl">

    <div class="card">

        <div class="card-header">
            <h2>{{ __('messages.edit_attribute') }}</h2>
        </div>

        <form method="POST"
              action="{{ route('attributes.update',$attribute->id) }}">

            @csrf
            @method('PUT')

            <div class="card-body">

                <label class="required form-label">
                    {{ __('messages.arabic_attribute_name') }}
                </label>

                <input type="text"
                       name="name_ar"
                       class="form-control"
                       value="{{ old('name_ar', $attribute->name_ar) }}">

                <label class="required form-label mt-5">
                    {{ __('messages.english_attribute_name') }}
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
