<div class="container-fluid pt-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">{{ __('messages.categories') }}</span>
    </h2>

    <div class="row px-xl-5 pb-3">

        @foreach($categories as $category)

            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">

                <a class="text-decoration-none" href="{{ route('store.category', $category->id) }}">

                    <div class="cat-item d-flex align-items-center mb-4">

                        {{-- Image --}}
                        <div class="overflow-hidden" style="width: 100px; height: 100px;">
                            <img class="img-fluid w-100 h-100"
                                 style="object-fit: contain;"
                                 src="{{ $category->image ? asset('storage/' . $category->image) : asset('website/img/cat-1.jpg') }}"
                                 alt="{{ $category->name }}">
                        </div>

                        {{-- Info --}}
                        <div class="flex-fill pl-3">
                            <h6>{{ $category->name }}</h6>

                            <small class="text-body">
                                {{ __('messages.products_count', ['count' => $category->products_count]) }}
                            </small>
                        </div>

                    </div>

                </a>

            </div>

        @endforeach

    </div>
</div>