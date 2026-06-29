@extends('Store.layouts.master')

@section('title')
{{ __('messages.store_title') }}
@endsection

@section('content')

@include('Store.partials.carousel')

<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">{{ __('messages.quality_product') }}</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0">{{ __('messages.free_shipping') }}</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">{{ __('messages.fourteen_day_return') }}</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">{{ __('messages.support_24_7') }}</h5>
            </div>
        </div>
    </div>
</div>

@include('Store.partials.categories')

@include('Store.partials.FeaturedProducts')

<div class="container-fluid pt-5 pb-3">
    <div class="row px-xl-5">
        <div class="col-md-6">
            <div class="product-offer mb-30" style="height: 300px;">
                @if($offerLeft)
                    <img class="img-fluid" src="{{ asset('storage/'.$offerLeft->image) }}" alt="">
                @endif
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">{{ __('messages.save_20_percent') }}</h6>
                    <h3 class="text-white mb-3">{{ __('messages.special_offer') }}</h3>
                    <a href="{{ route("store.shop") }}" class="btn btn-primary">{{ __('messages.shop_now') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="product-offer mb-30" style="height: 300px;">
                @if($offerRight)
                    <img class="img-fluid" src="{{ asset('storage/'.$offerRight->image) }}" alt="">
                @endif
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">{{ __('messages.save_20_percent') }}</h6>
                    <h3 class="text-white mb-3">{{ __('messages.special_offer') }}</h3>
                    <a href="{{ route("store.shop") }}" class="btn btn-primary">{{ __('messages.shop_now') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Store.partials.RecentProducts')

<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel vendor-carousel">
                @for ($i = 1; $i <= 8; $i++)
                <div class="bg-light p-4">
                    <img src="{{ URL::asset('website/img/vendor-'.$i.'.jpg') }}" alt="">
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection
