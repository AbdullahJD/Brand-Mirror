@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.coupons_page_title') }}
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">

        <div class="card card-flush">

            <!-- Header -->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">

                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                                <path d="M11 19C6.5 19 3 15.4 3 11C3 6.5 6.5 3 11 3C15.5 3 19 6.5 19 11C19 15.5 15.5 19 11 19Z" fill="black"/>
                            </svg>
                        </span>

                        <input type="text"
                               class="form-control form-control-solid w-250px ps-14"
                               placeholder="{{ __('messages.search_coupons') }}">
                    </div>
                </div>
                @if(auth()->user()->role === 'admin')
                    <div class="card-toolbar">
                        <a href="{{ route('coupons.create') }}" class="btn btn-primary">
                            {{ __('messages.add_coupon') }}
                        </a>
                    </div>
                @endif

            </div>

            <!-- Table -->
            <div class="card-body pt-0">

                <table class="table align-middle table-row-dashed fs-6 gy-5">

                    <thead>
                        <tr class="text-gray-400 fw-bolder fs-7 text-uppercase">
                            <th>#</th>
                            <th>{{ __('messages.code') }}</th>
                            <th>{{ __('messages.coupon_type') }}</th>
                            <th>{{ __('messages.coupon_value') }}</th>
                            <th>{{ __('messages.usage') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th class="text-end">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody class="fw-bold text-gray-600">

                        @forelse($coupons as $coupon)
                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <span class="badge badge-light-primary">
                                        {{ $coupon->code }}
                                    </span>
                                </td>

                                <td>
                                    {{ __('messages.type_' . $coupon->type) }}
                                </td>

                                <td>
                                    {{ $coupon->value }}
                                </td>

                                <td>
                                    <span class="badge badge-light-primary">
                                        {{ $coupon->used_count }} / {{ $coupon->usage_limit ?? __('messages.unlimited') }}
                                    </span>
                                </td>

                                <td>
                                    @if($coupon->is_active)
                                        <span class="badge badge-light-success">{{ __('messages.active') }}</span>
                                    @else
                                        <span class="badge badge-light-danger">{{ __('messages.inactive') }}</span>
                                    @endif
                                </td>
                                <td class="text-end">

                                    <a href="#"
                                       class="btn btn-sm btn-light btn-active-light-primary"
                                       data-kt-menu-trigger="click">
                                        {{ __('messages.actions') }}
                                    </a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded w-125px py-4"
                                         data-kt-menu="true">
                                        @if(auth()->user()->role === 'admin')
                                            <div class="menu-item px-3">
                                                <a href="{{ route('coupons.edit', $coupon->id) }}"
                                                class="menu-link px-3">
                                                    {{ __('messages.edit') }}
                                                </a>
                                            </div>

                                            <div class="menu-item px-3">
                                                <a href="#"
                                                class="menu-link px-3 text-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal-{{ $coupon->id }}">
                                                    {{ __('messages.delete') }}
                                                </a>
                                            </div>
                                        @endif
                                        @if(auth()->user()->role === 'employee')
                                            <div class="menu-item px-3">
                                                <form action="{{ route('employee.coupons.toggle', $coupon->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="menu-link px-3 border-0 bg-transparent w-100 text-start">
                                                        {{ $coupon->is_active ? __('messages.deactivate') : __('messages.activate') }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    {{ __('messages.no_coupons_found') }}
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>

{{-- Delete Modals --}}
@foreach($coupons as $coupon)

<div class="modal fade" id="deleteModal-{{ $coupon->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="{{ route('coupons.destroy', $coupon->id) }}">
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.delete_coupon') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>{{ __('messages.confirm_delete_coupon') }}</p>
                    <p class="fw-bold text-danger">{{ $coupon->code }}</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('messages.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-danger">
                        {{ __('messages.delete') }}
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endforeach

@endsection
