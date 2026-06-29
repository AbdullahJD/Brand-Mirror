<div class="container-fluid bg-dark text-secondary mt-5 pt-5">
    <div class="row px-xl-5 pt-5">

        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <h5 class="text-secondary text-uppercase mb-4">{{ __('messages.about_our_store') }}</h5>

            <p class="mb-4">
                {{ __('messages.about_store_description') }}
            </p>

            <p class="mb-2">
                <i class="fa fa-map-marker-alt text-primary mr-3"></i>
                {{ __('messages.store_location') }}
            </p>

            <p class="mb-2">
                <i class="fa fa-envelope text-primary mr-3"></i>
                support@store.com
            </p>

            <p class="mb-0">
                <i class="fa fa-phone-alt text-primary mr-3"></i>
                +970 59 000 0000
            </p>
        </div>

        <div class="col-lg-8 col-md-12">
            <div class="row">

                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">{{ __('messages.shop') }}</h5>

                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-secondary mb-2" href="{{ route('store.home') }}">
                            <i class="fa fa-angle-right mr-2"></i>{{ __('messages.home') }}
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('store.shop') }}">
                            <i class="fa fa-angle-right mr-2"></i>{{ __('messages.all_products') }}
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('carts.index') }}">
                            <i class="fa fa-angle-right mr-2"></i>{{ __('messages.cart') }}
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('store.checkout') }}">
                            <i class="fa fa-angle-right mr-2"></i>{{ __('messages.checkout') }}
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('store.contact') }}">
                            <i class="fa fa-angle-right mr-2"></i>{{ __('messages.contact') }}
                        </a>
                    </div>
                </div>

                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">{{ __('messages.my_account') }}</h5>

                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-secondary mb-2" href="{{ route("store.shop") }}">
                            <i class="fa fa-angle-right mr-2"></i>{{ __('messages.shop') }}
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('store.orders.index') }}">
                            <i class="fa fa-angle-right mr-2"></i>{{ __('messages.my_orders') }}
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('store.favorites.page') }}">
                            <i class="fa fa-angle-right mr-2"></i>{{ __('messages.favorite') }}
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('carts.index') }}">
                            <i class="fa fa-angle-right mr-2"></i>{{ __('messages.shopping_cart') }}
                        </a>
                        @auth('customer')
                            <form action="{{ route('store.logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="text-secondary mb-2 border-0 bg-transparent">
                                    <i class="fa fa-angle-right mr-2"></i>{{ __('messages.logout') }}
                                </button>
                            </form>
                        @else
                            <a class="text-secondary mb-2" href="{{ route('store.login') }}">
                                <i class="fa fa-angle-right mr-2"></i>{{ __('messages.login') }}
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">{{ __('messages.newsletter') }}</h5>

                    <p>{{ __('messages.newsletter_description') }}</p>

                    <form action="#" method="POST">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="{{ __('messages.your_email_address') }}">

                            <div class="input-group-append">
                                <button class="btn btn-primary">{{ __('messages.subscribe') }}</button>
                            </div>
                        </div>
                    </form>

                    <h6 class="text-secondary text-uppercase mt-4 mb-3">{{ __('messages.follow_us') }}</h6>

                    <div class="d-flex">
                        <a class="btn btn-primary btn-square mr-2" href="#">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a class="btn btn-primary btn-square mr-2" href="#">
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a class="btn btn-primary btn-square mr-2" href="#">
                            <i class="fab fa-twitter"></i>
                        </a>

                        <a class="btn btn-primary btn-square" href="#">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(255,255,255,.1) !important;">

        <div class="col-md-6 text-center text-md-left">
            <p class="mb-0 text-secondary">
                {{ __('messages.copyright', ['year' => date('Y')]) }}
            </p>
        </div>

        <div class="col-md-6 text-center text-md-right">
            <span class="text-secondary">
                {{ __('messages.footer_tagline') }}
            </span>
        </div>

    </div>
</div>
