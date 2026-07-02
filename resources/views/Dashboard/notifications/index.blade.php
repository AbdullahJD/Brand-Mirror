@extends('Dashboard.layouts.master')

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">

    <div id="kt_content_container" class="container-xxl">

        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <h3>{{ __('messages.all_notifications') }}</h3>
        </div>

        <div class="card-body pt-0">

            @forelse($notifications as $notification)

                <div class="border-bottom py-4">

                    <h5 class="{{ !$notification->is_read ? 'fw-bolder' : 'text-muted' }}">
                        {{ $notification->title }}
                    </h5>

                    <p class="mb-1">
                        {{ $notification->message }}
                    </p>

                    <small class="text-muted">
                        {{ $notification->created_at->diffForHumans() }}
                    </small>

                </div>

            @empty

                <div class="text-center py-5">
                    {{ __('messages.no_notifications_found') }}
                </div>

            @endforelse

        </div>

        <div class="card-footer">
            {{ $notifications->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

@endsection
