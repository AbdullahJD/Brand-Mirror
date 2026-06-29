<style>
.dropdown-menu {
    margin-top: 0;
}
.dropdown.dropright:hover > .dropdown-menu {
    display: block;
}
.dropdown-menu {
    pointer-events: auto;
}
</style>

<div class="container-fluid bg-light py-3 px-xl-5">
    <div class="row align-items-center">

        <!-- Logo -->
        <div class="col-lg-4">
            <a href="{{ route('store.home') }}" class="text-decoration-none">
                <span class="h1 text-uppercase text-primary bg-dark px-2">Brand</span>
                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Mirror</span>
            </a>
        </div>

        <!-- Search -->
        <div class="col-lg-4 col-6 text-left position-relative">
            <form id="search-form" onsubmit="return false;">
                <div class="input-group">
                    <input type="text"
                        id="search-input"
                        class="form-control"
                        placeholder="{{ __('messages.search_products_categories') }}">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-primary">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </form>

            <div id="search-results"
                class="bg-white shadow position-absolute w-100"
                style="z-index:999; display:none; max-height:300px; overflow:auto;">
            </div>
        </div>

        <!-- Customer Service + Account + Language -->
        <div class="col-lg-4 d-flex align-items-center justify-content-end gap-3">

            <div class="mr-3">
                @include('components.language-switcher', ['btnClass' => 'btn-outline-dark'])
            </div>

            <div class="mr-4 text-right">
                <p class="m-0">{{ __('messages.customer_service') }}</p>

                <h6 class="m-0" dir="ltr" style="unicode-bidi: plaintext;">
                    +012 345 6789
                </h6>
            </div>

            <div class="dropdown">

                @auth('customer')
                    <button class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                        {{ __('messages.my_account') }}
                    </button>

                    <div class="dropdown-menu dropdown-menu-right">
                        <form method="POST" action="{{ route('store.logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                {{ __('messages.logout') }}
                            </button>
                        </form>
                    </div>

                @else

                    <button class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown">
                        {{ __('messages.my_account') }}
                    </button>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('store.login') }}">
                            {{ __('messages.sign_in') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('store.register') }}">
                            {{ __('messages.sign_up') }}
                        </a>
                    </div>

                @endauth

            </div>

        </div>
    </div>
</div>




<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>{{ __('messages.categories') }}</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    @foreach($categories->whereNull('parent_id') as $category)

                        @if($category->children->where('status', 1)->count())

                            <div class="nav-item dropdown {{ app()->getLocale() === 'ar' ? 'dropleft' : 'dropright' }}">

                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                    {{ $category->name }}
                                    <i class="fa fa-angle-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} float-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} mt-1"></i>
                                </a>

                                <div class="dropdown-menu position-absolute">

                                    @foreach($category->children->where('status', 1) as $child)

                                        <a href="{{ route('store.category', $child->id) }}"
                                        class="dropdown-item">
                                            {{ $child->name }}
                                        </a>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                    @endforeach
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <span class="h1 text-uppercase text-dark bg-light px-2">Brand</span>
                    <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Mirror</span>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{ route('store.home') }}" class="nav-item nav-link active">{{ __('messages.home') }}</a>
                        <a href="{{ route("store.shop") }}" class="nav-item nav-link">{{ __('messages.shop') }}</a>
                        <a href="{{ route('carts.index') }}" class="nav-item nav-link">{{ __('messages.shopping_cart') }}</a>
                        <a href="{{ route('store.orders.index') }}" class="nav-item nav-link">{{ __('messages.my_orders') }}</a>
                        @guest('customer')
                            <a href="{{ route('store.track.form') }}" class="nav-item nav-link">
                                {{ __('messages.track_order') }}
                            </a>
                        @endguest
                        <a href="{{ route('store.contact') }}" class="nav-item nav-link">{{ __('messages.contact') }}</a>
                    </div>
                    <div class="navbar-nav py-0 d-none d-lg-block ml-auto rtl-actions">
                        <a href="{{ route('store.favorites.page') }}" class="btn px-0 ml-3" id="favorites-btn">
                            <i id="header-heart-icon" class="far fa-heart text-primary"></i>
                            <span id="header-fav-count"
                                class="badge text-secondary border border-secondary rounded-circle"
                                style="padding-bottom: 2px;">0
                            </span>                         
                        </a>


                        <a href="{{ route('carts.index') }}" class="btn px-0 ml-3">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            <span id="header-cart-count" class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">{{ $cartCount ?? 0 }}</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
