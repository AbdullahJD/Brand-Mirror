@extends('Dashboard.layouts.master')

@section('title')
Edit Atrribute Value
@endsection

@section('content')

<div class="container-xxl">

    <div class="card">

        <div class="card-header">
            <h2>Edit Attribute Value</h2>
        </div>

        <form method="POST"
              action="{{ route('attribute-values.update',$attributeValue->id) }}">

            @csrf
            @method('PUT')

            <div class="card-body">

                <label class="form-label">
                    Attribute
                </label>

                <select name="attribute_id"
                        class="form-select">

                    @foreach($attributes as $attribute)

                        <option value="{{ $attribute->id }}"
                            {{ $attributeValue->attribute_id == $attribute->id ? 'selected' : '' }}>

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
                       value="{{ old('value_ar', $attributeValue->value_ar) }}">

                <label class="form-label mt-5">
                    English Value
                </label>

                <input type="text"
                       name="value_en"
                       class="form-control"
                       value="{{ old('value_en', $attributeValue->value_en) }}">

            </div>

            <div class="card-footer text-end">

                <button class="btn btn-primary">
                    {{ __('messages.update') }}
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
