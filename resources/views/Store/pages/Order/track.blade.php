@extends('Store.layouts.master')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-sm">

                <div class="card-header">
                    <h4>{{ __('messages.track_your_order') }}</h4>
                </div>

                <div class="card-body">

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('store.track.search') }}">
                        @csrf

                        <div class="mb-3">
                            <label>{{ __('messages.order_number') }}</label>
                            <input type="text" name="order_number" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>{{ __('messages.phone_number') }}</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">
                            {{ __('messages.track_order') }}
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
