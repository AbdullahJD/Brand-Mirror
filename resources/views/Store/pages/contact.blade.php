@extends('Store.layouts.master')

@section('title')
{{ __('messages.contact') }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('store.home') }}">{{ __('messages.home') }}</a>
                <span class="breadcrumb-item active">{{ __('messages.contact') }}</span>
            </nav>
        </div>
    </div>
</div>

<div class="container-fluid">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">{{ __('messages.contact_us') }}</span>
    </h2>

    <div class="row px-xl-5">

        <div class="col-lg-7 mb-5">
            <div class="contact-form bg-light p-30">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('store.contact.send') }}">
                    @csrf

                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="{{ __('messages.your_name') }}">
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="{{ __('messages.your_email') }}">
                    </div>

                    <div class="form-group">
                        <input type="text" name="subject" class="form-control" placeholder="{{ __('messages.subject') }}">
                    </div>

                    <div class="form-group">
                        <textarea name="message" class="form-control" rows="6" placeholder="{{ __('messages.message') }}"></textarea>
                    </div>

                    <button class="btn btn-primary px-4">{{ __('messages.send_message') }}</button>

                </form>

            </div>
        </div>

        <div class="col-lg-5 mb-5">

            <div class="bg-light p-30 mb-30">
                <iframe style="width: 100%; height: 250px;"
                        src="https://www.google.com/maps/embed?pb=..."
                        frameborder="0"></iframe>
            </div>

            <div class="bg-light p-30">
                <p><i class="fa fa-map-marker-alt text-primary mr-2"></i>{{ __('messages.contact_address') }}</p>
                <p><i class="fa fa-envelope text-primary mr-2"></i>info@example.com</p>
                <p><i class="fa fa-phone text-primary mr-2"></i>+012 345 67890</p>
            </div>

        </div>

    </div>
</div>

@endsection
