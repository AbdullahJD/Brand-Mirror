@extends('Dashboard.layouts.master')

@section('title')
Edit Banner
@endsection

@section('content')

    <div class="post d-flex flex-column-fluid">
        <div class="container-xxl">

            <form method="POST"
                action="{{ route('banners.update',$banner->id) }}"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="card card-flush py-4">

                    <div class="card-header">
                        <div class="card-title">
                            <h2>Edit Banner</h2>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="mb-5">
                            <label class="form-label">
                                Arabic Title
                            </label>

                            <input type="text"
                                name="title_ar"
                                value="{{ old('title_ar', $banner->title_ar) }}"
                                class="form-control">
                        </div>

                        <div class="mb-5">
                            <label class="form-label">
                                English Title
                            </label>

                            <input type="text"
                                name="title_en"
                                value="{{ old('title_en', $banner->title_en) }}"
                                class="form-control">
                        </div>

                        <div class="mb-5">

                            <img src="{{ asset('storage/'.$banner->image) }}"
                                width="250"
                                class="rounded mb-3">

                            <label class="form-label">
                                Change Image
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
                                value="{{ old('link',$banner->link) }}"
                                class="form-control">
                        </div>

                        <!-- POSITION -->
                        <div class="mb-3">
                            <label>Position</label>

                            <select name="position" class="form-control">

                                @foreach([
                                    'home_slider',
                                    'offer_left',
                                    'offer_right',
                                    'offer_top',
                                    'offer_bottom'
                                ] as $pos)

                                    <option value="{{ $pos }}"
                                        {{ $banner->position == $pos ? 'selected' : '' }}>
                                        {{ $pos }}
                                    </option>

                                @endforeach

                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="form-label">
                                Status
                            </label>

                            <select name="status"
                                    class="form-select">

                                <option value="1"
                                    {{ $banner->status ? 'selected' : '' }}>
                                    {{ __('messages.active') }}
                                </option>

                                <option value="0"
                                    {{ !$banner->status ? 'selected' : '' }}>
                                    {{ __('messages.inactive') }}
                                </option>

                            </select>
                        </div>

                    </div>

                    <div class="card-footer text-end">

                        <button class="btn btn-primary">
                            Update Banner
                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>

@endsection
