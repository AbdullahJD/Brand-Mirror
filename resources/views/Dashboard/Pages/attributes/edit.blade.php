@extends('Dashboard.layouts.master')

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
                    Attribute Name
                </label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ $attribute->name }}">

            </div>

            <div class="card-footer text-end">

                <button type="submit"
                        class="btn btn-primary">
                    Update
                </button>

            </div>

        </form>

    </div>

</div>

@endsection