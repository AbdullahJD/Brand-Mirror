<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">{{ __('messages.featured_products') }}</span>
    </h2>

    <div class="row px-xl-5">

        @foreach($featuredProducts as $product)

        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <div class="product-item bg-light mb-4">

                <!-- Image -->
                <div class="product-img position-relative overflow-hidden">

                    <img class="img-fluid w-100" style="height:250px; object-fit:contain;background:#f8f8f8;"
                         src="{{ asset('storage/'.$product->main_image) }}"
                         alt="{{ $product->name }}">

                    <!-- Actions -->
                    <div class="product-action">
                        <a href="javascript:void(0)"
                            class="btn btn-outline-dark btn-square add-to-cart"
                            data-id="{{ $product->id }}">
                            <i class="fa fa-shopping-cart"></i>
                        </a>

                        <a href="javascript:void(0)"
                            class="btn btn-outline-dark btn-square toggle-favorite"
                            data-id="{{ $product->id }}">
                            <i class="favorite-icon {{ in_array($product->id, $favoriteIds ?? []) ? 'fas text-danger' : 'far' }} fa-heart"></i>
                        </a>

                        <a class="btn btn-outline-dark btn-square"
                           href="{{ route('store.product', $product->id) }}">
                            <i class="fa fa-search"></i>
                        </a>
                    </div>
                </div>

                <!-- Content -->
                <div class="text-center py-4">

                    <a class="h6 text-decoration-none text-truncate"
                       href="{{ route('store.product', $product->id) }}">
                        {{ $product->name }}
                    </a>

                    <div class="d-flex align-items-center justify-content-center mt-2">
                        <h5>${{ $product->price }}</h5>

                        @if($product->old_price)
                            <h6 class="text-muted ml-2">
                                <del>${{ $product->old_price }}</del>
                            </h6>
                        @endif
                    </div>

                    <!-- Stars (ثابتة الآن لاحقًا نخليها ديناميكية) -->
                    <div class="d-flex align-items-center justify-content-center mb-1">
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small>{{ __('messages.reviews_zero') }}</small>
                    </div>

                </div>

            </div>
        </div>

        @endforeach

    </div>
</div>