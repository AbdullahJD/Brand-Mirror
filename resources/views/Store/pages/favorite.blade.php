@extends('Store.layouts.master')

@section('title')
{{ __('messages.favorite') }}
@endsection

@section('content')

<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">{{ __('messages.my_favorites') }}</span>
    </h2>

    <div class="row px-xl-5" id="favorites-container">

        @forelse($favorites as $fav)

            <div class="col-lg-3 col-md-4 col-sm-6 pb-1 favorite-item"
                 data-id="{{ $fav->product->id }}">

                <div class="product-item bg-light mb-4">

                    <div class="product-img position-relative overflow-hidden">

                        <img class="img-fluid w-100"
                             style="height:250px; object-fit:contain;background:#f8f8f8;"
                             src="{{ asset('storage/'.$fav->product->main_image) }}"
                             alt="{{ $fav->product->name }}">

                        <div class="product-action">

                            <a href="javascript:void(0)"
                                class="btn btn-outline-dark btn-square add-to-cart"
                                data-id="{{ $fav->product->id }}">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                            <a href="{{ route('store.product', $fav->product->id) }}"
                               class="btn btn-outline-dark btn-square">
                                <i class="fa fa-search"></i>
                            </a>

                            <a href="javascript:void(0)"
                               class="btn btn-outline-danger btn-square remove-favorite"
                               data-id="{{ $fav->product->id }}">
                                <i class="fa fa-trash"></i>
                            </a>

                        </div>
                    </div>

                    <div class="text-center py-4">

                        <a class="h6 text-decoration-none text-truncate"
                           href="{{ route('store.product', $fav->product->id) }}">
                            {{ $fav->product->name }}
                        </a>

                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>${{ $fav->product->price }}</h5>
                        </div>

                    </div>

                </div>
            </div>

        @empty
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    {{ __('messages.no_favorites') }}
                </div>
            </div>
        @endforelse

    </div>
</div>

@endsection
