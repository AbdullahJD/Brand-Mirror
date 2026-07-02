@extends('Dashboard.layouts.master')

@section('title')
Add Banner
@endsection

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
                            Arabic Title
                        </label>

                        <input type="text"
                            name="title_ar"
                            value="{{ old('title_ar') }}"
                            class="form-control">
                    </div>

                    <div class="mb-5">
                        <label class="form-label">
                            English Title
                        </label>

                        <input type="text"
                            name="title_en"
                            value="{{ old('title_en') }}"
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

                    <!--  POSITION IMPORTANT -->
                    <div class="mb-3">
                        <label>Position</label>

                        <select name="position" class="form-control">
                            <option value="home_slider">Home Slider</option>
                            <option value="offer_left">Offer Left</option>
                            <option value="offer_right">Offer Right</option>
                            <option value="offer_top">Offer Top</option>
                            <option value="offer_bottom">Offer Bottom</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="1">
                                {{ __('messages.active') }}
                            </option>

                            <option value="0">
                                {{ __('messages.inactive') }}
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
