@extends('Dashboard.layouts.master')

@section('content')

<div class="container-xxl">

    <div class="card">

        <div class="card-header">
            <h2>Add Attribute</h2>
        </div>

        <form method="POST"
              action="{{ route('attributes.store') }}">

            @csrf

            <div class="card-body">

                <label class="required form-label">
                    Arabic Attribute Name
                </label>

                <input type="text"
                       name="name_ar"
                       class="form-control"
                       value="{{ old('name_ar') }}"
                       placeholder="Arabic Attribute Name">

                <label class="required form-label mt-5">
                    English Attribute Name
                </label>

                <input type="text"
                       name="name_en"
                       class="form-control"
                       value="{{ old('name_en') }}"
                       placeholder="Size">

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
