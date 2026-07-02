@extends('Dashboard.layouts.master')

@section('title')
Add Attribute Value
@endsection

@section('content')

<div class="container-xxl">

    <div class="card">

        <div class="card-header">
            <h2>Add Attribute Value</h2>
        </div>

        <form method="POST"
              action="{{ route('attribute-values.store') }}">

            @csrf

            <div class="card-body">

                <label class="form-label">
                    Attribute
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
                    Arabic Value
                </label>

                <input type="text"
                       name="value_ar"
                       class="form-control"
                       value="{{ old('value_ar') }}"
                       placeholder="Arabic Value">

                <label class="form-label mt-5">
                    English Value
                </label>

                <input type="text"
                       name="value_en"
                       class="form-control"
                       value="{{ old('value_en') }}"
                       placeholder="XL">

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
