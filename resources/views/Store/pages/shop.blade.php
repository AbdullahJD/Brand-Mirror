@extends('Store.layouts.master')

@section('title')
{{ __('messages.shop') }}
@endsection

@section('content')

<div class="container-fluid pt-5">

    <div class="row px-xl-5">

        <div class="col-lg-3 col-md-4">

            <h5 class="mb-3">{{ __('messages.categories') }}</h5>

            <div class="list-group">
                @foreach($categories as $category)
                    <a href="{{ route('store.shop', ['category' => $category->id]) }}"
                       class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $category->name }}
                        <span class="badge badge-primary badge-pill">
                            {{ $category->products_count }}
                        </span>
                    </a>
                @endforeach
            </div>

            <hr>

            <h5>{{ __('messages.filter') }}</h5>

            <form method="GET" action="{{ route('store.shop') }}">

                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <label>{{ __('messages.min_price') }}</label>
                <input type="number" name="min" value="{{ request('min') }}" class="form-control mb-2">

                <label>{{ __('messages.max_price') }}</label>
                <input type="number" name="max" value="{{ request('max') }}" class="form-control mb-3">

                <button class="btn btn-primary btn-block">{{ __('messages.filter') }}</button>
            </form>

        </div>

        <div class="col-lg-9 col-md-8">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    {{ __('messages.products_found', ['count' => $products->count()]) }}
                </div>

                <form method="GET">
                    <select name="sort" class="form-control" onchange="this.form.submit()">
                        <option value="latest">{{ __('messages.sort_newest') }}</option>
                        <option value="price_low">{{ __('messages.sort_price_low') }}</option>
                        <option value="price_high">{{ __('messages.sort_price_high') }}</option>
                    </select>
                </form>

            </div>

            <div class="row">

                @forelse($products as $product)

                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">

                        <div class="product-item bg-light mb-4">

                            <div class="product-img position-relative overflow-hidden">

                                <img class="img-fluid w-100"
                                     style="height:250px; object-fit:contain;"
                                     src="{{ asset('storage/'.$product->main_image) }}"
                                     alt="{{ $product->name }}">
                                <div class="product-action">
                                    <a href="javascript:void(0)"
                                        class="btn btn-outline-dark btn-square add-to-cart"
                                        data-id="{{ $product->id }}">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="btn btn-outline-dark btn-square toggle-favorite"
                                        data-id="{{ $product->id }}">
                                        <i class="favorite-icon fa-heart
                                            {{ in_array($product->id, $favoriteIds ?? []) ? 'fas text-danger' : 'far' }}">
                                        </i>                                    
                                    </a>
                                    <a href="{{ route('store.product', $product->id) }}"
                                       class="btn btn-outline-dark btn-square">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </div>

                            </div>

                            <div class="text-center py-4">

                                <a class="h6 text-decoration-none text-truncate"
                                   href="{{ route('store.product', $product->id) }}">
                                    {{ $product->name }}
                                </a>

                                <h5>${{ $product->price }}</h5>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            {{ __('messages.no_products_found') }}
                        </div>
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection
