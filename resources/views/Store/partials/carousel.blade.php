<div class="container-fluid mb-3">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div id="header-carousel" class="carousel slide carousel-fade" data-ride="carousel">

                <div class="carousel-inner">

                    @foreach($banners as $key => $banner)

                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }} position-relative"
                        style="height: 430px; overflow: hidden;">
                        <img class="w-100 h-100"
                            src="{{ asset('storage/'.$banner->image) }}"
                            style="object-fit: cover; object-position: center;">

                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3">
                                <h1 class="display-4 text-white">{{ $banner->title }}</h1>

                                @if($banner->link)
                                    <a href="{{ $banner->link }}" class="btn btn-outline-light mt-3">
                                        Shop Now
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>

                    @endforeach

                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="product-offer mb-30" style="height: 200px;">
                @if($offerTop)
                    <img class="img-fluid" src="{{ asset('storage/'.$offerTop->image) }}" alt="">
                @endif
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Save 20%</h6>
                    <h3 class="text-white mb-3">Special Offer</h3>
                    <a href="{{ route("store.shop") }}" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
            <div class="product-offer mb-30" style="height: 200px;">
                @if($offerBottom)
                    <img class="img-fluid" src="{{ asset('storage/'.$offerBottom->image) }}" alt="">
                @endif
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Save 20%</h6>
                    <h3 class="text-white mb-3">Special Offer</h3>
                    <a href="{{ route("store.shop") }}" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>