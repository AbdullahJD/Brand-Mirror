@extends('Store.layouts.master')

@section('title')
Category
@endsection

@section('content')

<div class="container-fluid pt-5 pb-3">

    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">{{ $category->name }}</span>
    </h2>

    <div class="row px-xl-5">

        {{-- ===================== --}}
        {{-- 🔵 CASE 1: CHILD CATEGORIES --}}
        {{-- ===================== --}}
        @if($category->children->count())

            @foreach($category->children as $child)

                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">

                    <a href="{{ route('store.category', $child->id) }}"
                       class="text-decoration-none">

                        <div class="product-item bg-light mb-4">

                            <div class="product-img position-relative overflow-hidden">

                                <img class="img-fluid w-100"
                                     style="width:100%; height:250px; object-fit:contain; background:#f8f8f8; background:#f8f8f8;"
                                     src="{{ $child->image ? asset('storage/'.$child->image) : asset('website/img/cat-1.jpg') }}"
                                     alt="{{ $child->name }}">

                            </div>

                            <div class="text-center py-4">

                                <h6 class="text-truncate">{{ $child->name }}</h6>

                                <small class="text-body">
                                    {{ $child->products->count() }} Products
                                </small>

                            </div>

                        </div>

                    </a>

                </div>

            @endforeach

        {{-- ===================== --}}
        {{-- 🟢 CASE 2: PRODUCTS --}}
        {{-- ===================== --}}
        @else

            @forelse($category->products as $product)

                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">

                    <div class="product-item bg-light mb-4">

                        <div class="product-img position-relative overflow-hidden">

                            <img class="img-fluid w-100"
                                 style="height:250px; object-fit:contain; background:#f8f8f8;"
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
                                    <i class="favorite-icon {{ in_array($product->id, $favoriteIds ?? []) ? 'fas text-danger' : 'far' }} fa-heart"></i>
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

                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>${{ $product->price }}</h5>
                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        لا يوجد منتجات في هذا القسم
                    </div>
                </div>

            @endforelse

        @endif

    </div>
</div>

@endsection