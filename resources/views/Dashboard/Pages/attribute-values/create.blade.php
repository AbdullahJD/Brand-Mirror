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
                    Value
                </label>

                <input type="text"
                       name="value"
                       class="form-control"
                       placeholder="XL">

            </div>

            <div class="card-footer text-end">

                <button class="btn btn-primary">
                    Save
                </button>

            </div>

        </form>

    </div>

</div>

@endsection