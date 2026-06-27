<div class="container-fluid bg-dark text-secondary mt-5 pt-5">
    <div class="row px-xl-5 pt-5">

        <!-- ABOUT STORE -->
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <h5 class="text-secondary text-uppercase mb-4">About Our Store</h5>

            <p class="mb-4">
                We provide high quality products with fast delivery and secure payment.
                Shop your favorite items easily and safely.
            </p>

            <p class="mb-2">
                <i class="fa fa-map-marker-alt text-primary mr-3"></i>
                Palestine
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

        <!-- QUICK LINKS -->
        <div class="col-lg-8 col-md-12">
            <div class="row">

                <!-- Shop Links -->
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">Shop</h5>

                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-secondary mb-2" href="{{ route('store.home') }}">
                            <i class="fa fa-angle-right mr-2"></i>Home
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('store.shop') }}">
                            <i class="fa fa-angle-right mr-2"></i>All Products
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('carts.index') }}">
                            <i class="fa fa-angle-right mr-2"></i>Cart
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('store.checkout') }}">
                            <i class="fa fa-angle-right mr-2"></i>Checkout
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('store.contact') }}">
                            <i class="fa fa-angle-right mr-2"></i>Contact
                        </a>
                    </div>
                </div>

                <!-- Account -->
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">My Account</h5>

                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-secondary mb-2" href="{{ route("store.shop") }}">
                            <i class="fa fa-angle-right mr-2"></i>Shop
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('store.orders.index') }}">
                            <i class="fa fa-angle-right mr-2"></i>My Orders
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('store.favorites.page') }}">
                            <i class="fa fa-angle-right mr-2"></i>Favorite
                        </a>

                        <a class="text-secondary mb-2" href="{{ route('carts.index') }}">
                            <i class="fa fa-angle-right mr-2"></i>Shopping Cart
                        </a>
                        @auth('customer')
                            <form action="{{ route('store.logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="text-secondary mb-2 border-0 bg-transparent">
                                    <i class="fa fa-angle-right mr-2"></i>Logout
                                </button>
                            </form>
                        @else
                            <a class="text-secondary mb-2" href="{{ route('store.login') }}">
                                <i class="fa fa-angle-right mr-2"></i>Login
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>

                    <p>Subscribe to get latest offers and updates.</p>

                    <form action="#" method="POST">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your Email Address">

                            <div class="input-group-append">
                                <button class="btn btn-primary">Subscribe</button>
                            </div>
                        </div>
                    </form>

                    <h6 class="text-secondary text-uppercase mt-4 mb-3">Follow Us</h6>

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

    <!-- COPYRIGHT -->
    <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(255,255,255,.1) !important;">

        <div class="col-md-6 text-center text-md-left">
            <p class="mb-0 text-secondary">
                © {{ date('Y') }} Your Store. All Rights Reserved.
            </p>
        </div>

        <div class="col-md-6 text-center text-md-right">
            <span class="text-secondary">
                Secure Checkout • Fast Delivery • Quality Products
            </span>
        </div>

    </div>
</div>