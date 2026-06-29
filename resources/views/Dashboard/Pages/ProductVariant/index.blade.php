@extends('Dashboard.layouts.master')

@section('title')
Product Variants
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">

```
<div id="kt_content_container" class="container-xxl">

    <div class="card card-flush">

        <div class="card-header align-items-center py-5 gap-2 gap-md-5">

            <div class="card-title">

                <div class="d-flex align-items-center position-relative my-1">

                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none">

                            <rect opacity="0.5"
                                x="17.0365"
                                y="15.1223"
                                width="8.15546"
                                height="2"
                                rx="1"
                                transform="rotate(45 17.0365 15.1223)"
                                fill="black" />

                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556
                                6.55556 3 11 3C15.4444 3 19 6.55556
                                19 11C19 15.4444 15.4444 19 11 19ZM11
                                5C7.53333 5 5 7.53333 5 11C5 14.4667
                                7.53333 17 11 17C14.4667 17 17
                                14.4667 17 11C17 7.53333 14.4667
                                5 11 5Z"
                                fill="black" />

                        </svg>
                    </span>

                    <input type="text"
                        class="form-control form-control-solid w-250px ps-14"
                        placeholder="Search Variant" />

                </div>

            </div>

            <div class="card-toolbar">

                <a href="{{ route('product-variants.create') }}"
                    class="btn btn-primary">

                    Add Variant

                </a>

            </div>

        </div>

        <div class="card-body pt-0">

            <table class="table align-middle table-row-dashed fs-6 gy-5">

                <thead>

                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">

                        <th>#</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>{{ __('messages.attributes') }}</th>
                        <th>Status</th>
                        <th class="text-end">{{ __('messages.actions') }}</th>

                    </tr>

                </thead>

                <tbody class="fw-bold text-gray-600">

                    @forelse($variants as $variant)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $variant->product->name }}</td>

                            <td>{{ $variant->sku }}</td>

                            <td>{{ $variant->price }}</td>

                            <td>{{ $variant->quantity }}</td>

                            <td>

                                @forelse($variant->attributeValues as $value)

                                    <span class="badge badge-light-primary me-1 mb-1">

                                        {{ $value->attribute->name }}
                                        :
                                        {{ $value->value }}

                                    </span>

                                @empty

                                    <span class="text-muted">
                                        No Values
                                    </span>

                                @endforelse

                            </td>

                            <td>

                                @if($variant->status)

                                    <span class="badge badge-light-success">
                                        {{ __('messages.active') }}
                                    </span>

                                @else

                                    <span class="badge badge-light-danger">
                                        {{ __('messages.inactive') }}
                                    </span>

                                @endif

                            </td>

                            <td class="text-end">

                                <a href="#"
                                    class="btn btn-sm btn-light btn-active-light-primary"
                                    data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">

                                    {{ __('messages.actions') }}

                                </a>

                                <div class="menu menu-sub menu-sub-dropdown
                                    menu-column menu-rounded
                                    menu-gray-600 menu-state-bg-light-primary
                                    fw-bold fs-7 w-125px py-4"
                                    data-kt-menu="true">

                                    <div class="menu-item px-3">

                                        <a href="{{ route('product-variants.edit',$variant->id) }}"
                                            class="menu-link px-3">

                                            {{ __('messages.edit') }}

                                        </a>

                                    </div>

                                    <div class="menu-item px-3">

                                        <a href="#"
                                            class="menu-link px-3 text-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal-{{ $variant->id }}">

                                            {{ __('messages.delete') }}

                                        </a>

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center">
                                No Variants Found
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
```

</div>


@foreach($variants as $variant)

    <div class="modal fade"
         id="deleteModal-{{ $variant->id }}"
         tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <form method="POST"
                      action="{{ route('product-variants.destroy', $variant->id) }}">

                    @csrf
                    @method('DELETE')

                    <div class="modal-header">

                        <h5 class="modal-title">
                            {{ __('messages.confirm_delete') }}
                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <p>
                            Are you sure you want to delete this variant?
                        </p>

                        <div class="alert alert-warning mb-0">

                            <strong>Product:</strong>
                            {{ $variant->product->name }}

                            <br>

                            <strong>SKU:</strong>
                            {{ $variant->sku ?: 'N/A' }}

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal">

                            {{ __('messages.cancel') }}

                        </button>

                        <button type="submit"
                                class="btn btn-danger">

                            {{ __('messages.delete') }}

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endforeach

@endsection
