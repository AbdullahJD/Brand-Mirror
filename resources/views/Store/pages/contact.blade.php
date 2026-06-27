@extends('Store.layouts.master')


@section('title')
Contact
@endsection

@section('content')

<!-- Breadcrumb -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('store.home') }}">Home</a>
                <span class="breadcrumb-item active">Contact</span>
            </nav>
        </div>
    </div>
</div>

<!-- Contact Start -->
<div class="container-fluid">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Contact Us</span>
    </h2>

    <div class="row px-xl-5">

        <!-- FORM -->
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
                        <input type="text" name="name" class="form-control" placeholder="Your Name">
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Your Email">
                    </div>

                    <div class="form-group">
                        <input type="text" name="subject" class="form-control" placeholder="Subject">
                    </div>

                    <div class="form-group">
                        <textarea name="message" class="form-control" rows="6" placeholder="Message"></textarea>
                    </div>

                    <button class="btn btn-primary px-4">Send Message</button>

                </form>

            </div>
        </div>

        <!-- MAP + INFO -->
        <div class="col-lg-5 mb-5">

            <div class="bg-light p-30 mb-30">
                <iframe style="width: 100%; height: 250px;"
                        src="https://www.google.com/maps/embed?pb=..."
                        frameborder="0"></iframe>
            </div>

            <div class="bg-light p-30">
                <p><i class="fa fa-map-marker-alt text-primary mr-2"></i>123 Street</p>
                <p><i class="fa fa-envelope text-primary mr-2"></i>info@example.com</p>
                <p><i class="fa fa-phone text-primary mr-2"></i>+012 345 67890</p>
            </div>

        </div>

    </div>
</div>

@endsection