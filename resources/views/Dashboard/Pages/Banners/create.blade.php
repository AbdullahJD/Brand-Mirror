@extends('Dashboard.layouts.master')

@section('content')

<div class="post d-flex flex-column-fluid">
    <div class="container-xxl">

        <form method="POST"
            action="{{ route('banners.store') }}"
            enctype="multipart/form-data">

            @csrf

            <div class="card card-flush py-4">

                <div class="card-header">
                    <div class="card-title">
                        <h2>Add Banner</h2>
                    </div>
                </div>

                <div class="card-body">

                    <div class="mb-5">
                        <label class="form-label">
                            Title
                        </label>

                        <input type="text"
                            name="title"
                            value="{{ old('title') }}"
                            class="form-control">
                    </div>

                    <div class="mb-5">
                        <label class="required form-label">
                            Banner Image
                        </label>

                        <input type="file"
                            name="image"
                            class="form-control">
                    </div>

                    <div class="mb-5">
                        <label class="form-label">
                            Link
                        </label>

                        <input type="url"
                            name="link"
                            value="{{ old('link') }}"
                            class="form-control">
                    </div>

                    <div class="mb-5">
                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="1">
                                Active
                            </option>

                            <option value="0">
                                Inactive
                            </option>

                        </select>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <button class="btn btn-primary">
                        Save Banner
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>

@endsection
