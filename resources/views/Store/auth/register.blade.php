@extends('Store.layouts.master')

@section('content')

<!-- Breadcrumb -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('store.home') }}">Home</a>
                <span class="breadcrumb-item active">Register</span>
            </nav>
        </div>
    </div>
</div>

<!-- Register Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5 justify-content-center">
        <div class="col-lg-7">

            <div class="bg-light p-5">

                <h3 class="text-center mb-4">Create Account</h3>

                <form action="{{ route('store.register.post') }}" method="POST" id="registerForm">
                    @csrf

                    <div class="form-group mb-3">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name">
                    </div>

                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                    </div>

                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                    </div>

                    <div class="form-group mb-4">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                    </div>

                    <div class="form-group mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter phone">
                    </div>

                    <div class="form-group mb-3">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Enter address">
                    </div>

                    <button class="btn btn-primary btn-block py-2">
                        Create Account
                    </button>

                    <p class="text-center mt-3 mb-0">
                        Already have an account?
                        <a href="{{ route('store.login') }}">Login</a>
                    </p>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection