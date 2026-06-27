
@extends('Store.layouts.master')

@section('title')
Products
@endsection

@section('content')

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shop Detail</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        {{-- الصورة الرئيسية --}}
                        <div class="carousel-item active">
                            <img class="img-fluid"
                                style="height:500px; width:100%; object-fit:contain;"
                                src="{{ asset('storage/'.$product->main_image) }}"
                                alt="{{ $product->name }}">
                        </div>

                        {{-- صور المعرض --}}
                        @foreach($product->images as $image)
                        <div class="carousel-item">
                            <img class="img-fluid"
                                style="height:500px; width:100%; object-fit:contain;"
                                src="{{ asset('storage/'.$image->image) }}"
                                alt="{{ $product->name }}">
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $product->name }}</h3>
                    <p class="text-muted mb-2">
                        Rating:
                        <strong>{{ $averageRating }}/5</strong>
                    </p>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($averageRating >= $i)
                                    <small class="fas fa-star"></small>
                                @elseif($averageRating >= ($i - 0.5))
                                    <small class="fas fa-star-half-alt"></small>
                                @else
                                    <small class="far fa-star"></small>
                                @endif
                            @endfor
                        </div>
                        <small class="pt-1">
                            ({{ $reviewsCount }} Reviews)
                        </small>
                    </div>

                    @if($product->discount_price)
                        <h3 class="font-weight-semi-bold mb-4">
                            ${{ $product->discount_price }}
                            <small class="text-muted">
                                <del>${{ $product->price }}</del>
                            </small>
                        </h3>
                    @else
                        <h3 class="font-weight-semi-bold mb-4">
                            ${{ $product->price }}
                        </h3>
                    @endif
                    <p class="mb-4">
                        {{ $product->description }}
                    </p>
                    {{-- <div class="d-flex mb-3">
                        <strong class="text-dark mr-3">Sizes:</strong>
                        <form>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-1" name="size">
                                <label class="custom-control-label" for="size-1">XS</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-2" name="size">
                                <label class="custom-control-label" for="size-2">S</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-3" name="size">
                                <label class="custom-control-label" for="size-3">M</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-4" name="size">
                                <label class="custom-control-label" for="size-4">L</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-5" name="size">
                                <label class="custom-control-label" for="size-5">XL</label>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex mb-4">
                        <strong class="text-dark mr-3">Colors:</strong>
                        <form>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-1" name="color">
                                <label class="custom-control-label" for="color-1">Black</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-2" name="color">
                                <label class="custom-control-label" for="color-2">White</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-3" name="color">
                                <label class="custom-control-label" for="color-3">Red</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-4" name="color">
                                <label class="custom-control-label" for="color-4">Blue</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-5" name="color">
                                <label class="custom-control-label" for="color-5">Green</label>
                            </div>
                        </form>
                    </div> --}}
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center quantity-input" value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button 
                            class="btn btn-primary px-3 add-to-cart"
                            data-id="{{ $product->id }}">
                            <i class="fa fa-shopping-cart mr-1"></i>Add ToCart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Information</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">
                            Reviews ({{ $product->reviews()->where('is_approved', true)->count() }})
                        </a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Additional Information</h4>

                            <ul class="list-group list-group-flush">
                                @foreach($product->additional_information ?? [] as $key => $value)
                                    <li class="list-group-item px-0">
                                        <strong>{{ $key }}:</strong> {{ $value }}
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                        <div class="tab-pane fade" id="tab-pane-2">
                            <div class="row">
                                {{-- عرض المراجعات --}}
                                <div class="col-md-6">
                                    <h4 class="mb-4">
                                        {{ $product->reviews()->where('is_approved', true)->count() }}
                                        Reviews
                                    </h4>
                                    @forelse($product->reviews()->where('is_approved', true)->latest()->get() as $review)
                                        <div class="media mb-4">
                                            <div class="media-body">
                                                <h6>
                                                    {{ $review->name }}
                                                    <small>
                                                        <i>
                                                            {{ $review->created_at->format('d M Y') }}
                                                        </i>
                                                    </small>
                                                </h6>
                                                <div class="text-primary mb-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif

                                                    @endfor
                                                </div>
                                                <p>
                                                    {{ $review->comment }}
                                                </p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info">
                                            No reviews yet.
                                        </div>
                                    @endforelse
                                </div>
                                {{-- نموذج إضافة مراجعة --}}
                                <div class="col-md-6">
                                    <h4 class="mb-4">Leave a Review</h4>
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <form action="{{ route('reviews.store', $product) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Your Rating *</label>
                                            <select name="rating" class="form-control" required>
                                                <option value="">Select Rating</option>
                                                <option value="5">★★★★★ (5)</option>
                                                <option value="4">★★★★☆ (4)</option>
                                                <option value="3">★★★☆☆ (3)</option>
                                                <option value="2">★★☆☆☆ (2)</option>
                                                <option value="1">★☆☆☆☆ (1)</option>
                                            </select>
                                            @error('rating')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Your Review *</label>
                                            <textarea
                                                name="comment"
                                                rows="5"
                                                class="form-control"
                                                required>{{ old('comment') }}</textarea>

                                            @error('comment')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Your Name *</label>
                                            <input
                                                type="text"
                                                name="name"
                                                value="{{ old('name') }}"
                                                class="form-control"
                                                required>

                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Your Email *</label>
                                            <input
                                                type="email"
                                                name="email"
                                                value="{{ old('email') }}"
                                                class="form-control"
                                                required>

                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button
                                            type="submit"
                                            class="btn btn-primary px-4">
                                            Submit Review
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


<!-- Products Start -->
    @if($relatedProducts->count())
        <div class="container-fluid py-5">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                <span class="bg-secondary pr-3">You May Also Like</span>
            </h2>

            <div class="row px-xl-5">
                <div class="col">
                    <div class="owl-carousel related-carousel">

                        @foreach($relatedProducts as $item)
                            <div class="product-item bg-light">
                                <div class="product-img position-relative overflow-hidden"
                                    style="width:100%; height:250px; display:flex; align-items:center; justify-content:center; background:#fff;">

                                    <img class="img-fluid"
                                        src="{{ asset('storage/'.$item->main_image) }}"
                                        alt="{{ $item->name }}"
                                        style="max-width:100%; max-height:100%; object-fit:contain;">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square add-to-cart"
                                        data-id="{{ $item->id }}">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate"
                                    href="{{ route('store.product', $item->id) }}">
                                        {{ $item->name }}
                                    </a>

                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>
                                            ${{ $item->discount_price ?? $item->price }}
                                        </h5>

                                        @if($item->discount_price)
                                            <h6 class="text-muted ml-2">
                                                <del>${{ $item->price }}</del>
                                            </h6>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    @endif
<!-- Products End -->

@endsection
