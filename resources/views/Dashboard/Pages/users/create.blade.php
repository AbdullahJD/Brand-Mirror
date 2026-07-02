@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.add_user') }}
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">

    <div class="container-xxl">

        <form method="POST"
            action="{{ route('users.store') }}">

            @csrf

            <div class="card card-flush py-4">

                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('messages.add_user') }}</h2>
                    </div>
                </div>

                <div class="card-body">

                    <div class="mb-5">

                        <label class="required form-label">
                            {{ __('messages.name') }}
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name') }}"
                        >

                    </div>

                    <div class="mb-5">

                        <label class="required form-label">
                            {{ __('messages.email') }}
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}"
                        >

                    </div>

                    <div class="mb-5">

                        <label class="required form-label">
                            {{ __('messages.password') }}
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                        >

                    </div>

                    <div class="mb-5">

                        <label class="required form-label">
                            {{ __('messages.role') }}
                        </label>

                        <select
                            name="role"
                            class="form-select">

                            <option value="employee">
                                {{ __('messages.employee') }}
                            </option>

                            <option value="admin">
                                {{ __('messages.role_admin') }}
                            </option>

                        </select>

                    </div>

                </div>

                <div class="card-footer text-end">

                    <button type="submit"
                        class="btn btn-primary">
                        {{ __('messages.save_user') }}
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection
