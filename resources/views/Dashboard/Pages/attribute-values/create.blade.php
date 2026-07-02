@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.add_attribute_value') }}
@endsection

@section('content')

<div class="container-xxl">

    <div class="card">

        <div class="card-header">
            <h2>{{ __('messages.add_attribute_value') }}</h2>
        </div>

        <form method="POST"
              action="{{ route('attribute-values.store') }}">

            @csrf

            <div class="card-body">

                <label class="form-label">
                    {{ __('messages.attribute') }}
                </label>

                <select name="attribute_id"
                        class="form-select">

                    @foreach($attributes as $attribute)

                        <option value="{{ $attribute->id }}">
                            {{ $attribute->name }}
                        </option>

                    @endforeach

                </select>

                <br>

                <label class="form-label">
                    {{ __('messages.arabic_value') }}
                </label>

                <input type="text"
                       name="value_ar"
                       class="form-control"
                       value="{{ old('value_ar') }}"
                       placeholder="{{ __('messages.arabic_value') }}">

                <label class="form-label mt-5">
                    {{ __('messages.english_value') }}
                </label>

                <input type="text"
                       name="value_en"
                       class="form-control"
                       value="{{ old('value_en') }}"
                       placeholder="{{ __('messages.value_placeholder_xl') }}">

            </div>

            <div class="card-footer text-end">

                <button class="btn btn-primary">
                    {{ __('messages.save') }}
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
