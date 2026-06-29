@extends('Store.layouts.master')

@section('content')

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('store.home') }}">{{ __('messages.home') }}</a>
                <span class="breadcrumb-item active">{{ __('messages.login') }}</span>
            </nav>
        </div>
    </div>
</div>

<div class="container-fluid pb-5">
    <div class="row px-xl-5 justify-content-center">
        <div class="col-lg-6">

            <div class="bg-light p-5">

                <h3 class="text-center mb-4">{{ __('messages.customer_login') }}</h3>

                <form action="{{ route('store.login.post') }}" method="POST" id="loginForm">
                    @csrf

                    <div class="form-group mb-3">
                        <label>{{ __('messages.email') }}</label>
                        <input type="email" name="email" class="form-control" placeholder="{{ __('messages.enter_email') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>{{ __('messages.password') }}</label>
                        <input type="password" name="password" class="form-control" placeholder="{{ __('messages.enter_password') }}">
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <input type="checkbox"> {{ __('messages.remember_me') }}
                        </div>
                        <a href="#">{{ __('messages.forgot_password') }}</a>
                    </div>

                    <button class="btn btn-primary btn-block py-2">
                        {{ __('messages.login') }}
                    </button>

                    <p class="text-center mt-3 mb-0">
                        {{ __('messages.dont_have_account') }}
                        <a href="{{ route('store.register') }}">{{ __('messages.register') }}</a>
                    </p>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection
