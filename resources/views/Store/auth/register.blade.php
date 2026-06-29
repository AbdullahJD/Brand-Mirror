@extends('Store.layouts.master')

@section('content')

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('store.home') }}">{{ __('messages.home') }}</a>
                <span class="breadcrumb-item active">{{ __('messages.register') }}</span>
            </nav>
        </div>
    </div>
</div>

<div class="container-fluid pb-5">
    <div class="row px-xl-5 justify-content-center">
        <div class="col-lg-7">

            <div class="bg-light p-5">

                <h3 class="text-center mb-4">{{ __('messages.create_account') }}</h3>

                <form action="{{ route('store.register.post') }}" method="POST" id="registerForm">
                    @csrf

                    <div class="form-group mb-3">
                        <label>{{ __('messages.full_name') }}</label>
                        <input type="text" name="name" class="form-control" placeholder="{{ __('messages.enter_name') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>{{ __('messages.email') }}</label>
                        <input type="email" name="email" class="form-control" placeholder="{{ __('messages.enter_email') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>{{ __('messages.password') }}</label>
                        <input type="password" name="password" class="form-control" placeholder="{{ __('messages.enter_password') }}">
                    </div>

                    <div class="form-group mb-4">
                        <label>{{ __('messages.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('messages.confirm_password_placeholder') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>{{ __('messages.phone') }}</label>
                        <input type="text" name="phone" class="form-control" placeholder="{{ __('messages.enter_phone') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>{{ __('messages.address') }}</label>
                        <input type="text" name="address" class="form-control" placeholder="{{ __('messages.enter_address') }}">
                    </div>

                    <button class="btn btn-primary btn-block py-2">
                        {{ __('messages.create_account') }}
                    </button>

                    <p class="text-center mt-3 mb-0">
                        {{ __('messages.already_have_account') }}
                        <a href="{{ route('store.login') }}">{{ __('messages.login') }}</a>
                    </p>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection
