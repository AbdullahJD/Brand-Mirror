@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.add_attribute') }}
@endsection

@section('content')

<div class="container-xxl">

    <div class="card">

        <div class="card-header">
            <h2>{{ __('messages.add_attribute') }}</h2>
        </div>

        <form method="POST"
              action="{{ route('attributes.store') }}">

            @csrf

            <div class="card-body">

                <label class="required form-label">
                    {{ __('messages.arabic_attribute_name') }}
                </label>

                <input type="text"
                       name="name_ar"
                       class="form-control"
                       value="{{ old('name_ar') }}"
                       placeholder="{{ __('messages.arabic_attribute_name') }}">

                <label class="required form-label mt-5">
                    {{ __('messages.english_attribute_name') }}
                </label>

                <input type="text"
                       name="name_en"
                       class="form-control"
                       value="{{ old('name_en') }}"
                       placeholder="{{ __('messages.name_placeholder_size') }}">

            </div>

            <div class="card-footer text-end">

                <button type="submit"
                        class="btn btn-primary">
                    {{ __('messages.save') }}
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
