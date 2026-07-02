@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.edit_user') }}
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">

    <div class="container-xxl">

        <form method="POST"
            action="{{ route('users.update',$user->id) }}">

            @csrf
            @method('PUT')

            <div class="card card-flush py-4">

                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('messages.edit_user') }}</h2>
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
                            value="{{ old('name',$user->name) }}"
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
                            value="{{ old('email',$user->email) }}"
                        >

                    </div>

                    <div class="mb-5">

                        <label class="form-label">
                            {{ __('messages.new_password') }}
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                        >

                        <small class="text-muted">
                            {{ __('messages.password_optional_hint') }}
                        </small>

                    </div>

                    <div class="mb-5">

                        <label class="required form-label">
                            {{ __('messages.role') }}
                        </label>

                        <select
                            name="role"
                            class="form-select">

                            <option
                                value="employee"
                                {{ $user->role == 'employee' ? 'selected' : '' }}>
                                {{ __('messages.employee') }}
                            </option>

                            <option
                                value="admin"
                                {{ $user->role == 'admin' ? 'selected' : '' }}>
                                {{ __('messages.role_admin') }}
                            </option>

                        </select>

                    </div>

                </div>

                <div class="card-footer text-end">

                    <button
                        type="submit"
                        class="btn btn-primary">
                        {{ __('messages.update_user') }}
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection
