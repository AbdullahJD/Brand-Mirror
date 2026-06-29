@extends('Dashboard.layouts.master')

@section('title')
Review
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">

        <div class="card card-flush">

            {{-- Header --}}
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">

                <div class="card-title">
                    <h3 class="fw-bold">Reviews</h3>
                </div>

            </div>

            {{-- Body --}}
            <div class="card-body pt-0">

                <table class="table align-middle table-row-dashed fs-6 gy-5">

                    <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">

                            <th>#</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th class="text-end">{{ __('messages.actions') }}</th>

                        </tr>
                    </thead>

                    <tbody class="fw-bold text-gray-600">

                        @forelse($reviews as $review)

                            <tr>

                                {{-- ID --}}
                                <td>{{ $loop->iteration }}</td>

                                {{-- Product --}}
                                <td>
                                    <span class="fw-bold text-dark">
                                        {{ $review->product->name ?? 'No Product' }}
                                    </span>
                                </td>

                                {{-- Customer --}}
                                <td>
                                    <div class="d-flex flex-column">
                                        <span>{{ $review->name }}</span>
                                        <span class="text-muted fs-7">{{ $review->email }}</span>
                                    </div>
                                </td>

                                {{-- Rating --}}
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                </td>

                                {{-- Comment --}}
                                <td>
                                    <span class="text-muted">
                                        {{ \Str::limit($review->comment, 50) }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td>
                                    @if($review->is_approved)
                                        <span class="badge badge-light-success">
                                            Approved
                                        </span>
                                    @else
                                        <span class="badge badge-light-warning">
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="text-end">
                                    {{-- Approve --}}
                                    @if(!$review->is_approved)
                                        <form method="POST"
                                              action="{{ route('reviews.approve', $review->id) }}"
                                              class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-light-success">
                                                Approve
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Delete --}}
                                    <form method="POST"
                                          action="{{ route('reviews.destroy', $review->id) }}"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-light-danger"
                                                onclick="return confirm('Delete this review?')">
                                            {{ __('messages.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    No Reviews Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection