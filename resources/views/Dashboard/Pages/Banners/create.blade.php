@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.add_banner_heading') }}
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
                        <h2>{{ __('messages.add_banner_heading') }}</h2>
                    </div>
                </div>

                <div class="card-body">

                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.arabic_title') }}
                        </label>

                        <input type="text"
                            name="title_ar"
                            value="{{ old('title_ar') }}"
                            class="form-control">
                    </div>

                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.english_title') }}
                        </label>

                        <input type="text"
                            name="title_en"
                            value="{{ old('title_en') }}"
                            class="form-control">
                    </div>

                    <div class="mb-5">
                        <label class="required form-label">
                            {{ __('messages.banner_image') }}
                        </label>

                        <input type="file"
                            name="image"
                            class="form-control">
                    </div>

                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.link') }}
                        </label>

                        <input type="url"
                            name="link"
                            value="{{ old('link') }}"
                            class="form-control">
                    </div>

                    <!--  POSITION IMPORTANT -->
                    <div class="mb-3">
                        <label>{{ __('messages.position') }}</label>

                        <select name="position" class="form-control">
                            <option value="home_slider">{{ __('messages.position_home_slider') }}</option>
                            <option value="offer_left">{{ __('messages.position_offer_left') }}</option>
                            <option value="offer_right">{{ __('messages.position_offer_right') }}</option>
                            <option value="offer_top">{{ __('messages.position_offer_top') }}</option>
                            <option value="offer_bottom">{{ __('messages.position_offer_bottom') }}</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">
                            {{ __('messages.status') }}
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
                        {{ __('messages.save_banner') }}
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>

@endsection
