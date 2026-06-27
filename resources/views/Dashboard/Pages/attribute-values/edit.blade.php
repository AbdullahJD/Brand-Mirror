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
                    Value
                </label>

                <input type="text"
                       name="value"
                       class="form-control"
                       value="{{ $attributeValue->value }}">

            </div>

            <div class="card-footer text-end">

                <button class="btn btn-primary">
                    Update
                </button>

            </div>

        </form>

    </div>

</div>

@endsection