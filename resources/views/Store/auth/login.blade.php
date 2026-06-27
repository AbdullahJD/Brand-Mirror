@extends('Store.layouts.master')

@section('content')

<!-- Breadcrumb -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('store.home') }}">Home</a>
                <span class="breadcrumb-item active">Login</span>
            </nav>
        </div>
    </div>
</div>

<!-- Login Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5 justify-content-center">
        <div class="col-lg-6">

            <div class="bg-light p-5">

                <h3 class="text-center mb-4">Customer Login</h3>

                <form action="{{ route('store.login.post') }}" method="POST" id="loginForm">
                    @csrf

                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                    </div>

                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <input type="checkbox"> Remember me
                        </div>
                        <a href="#">Forgot password?</a>
                    </div>

                    <button class="btn btn-primary btn-block py-2">
                        Login
                    </button>

                    <p class="text-center mt-3 mb-0">
                        Don't have an account?
                        <a href="{{ route('store.register') }}">Register</a>
                    </p>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection