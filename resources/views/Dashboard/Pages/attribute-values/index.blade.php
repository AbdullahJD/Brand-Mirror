@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.attribute_values_page_title') }}
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">

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
                            placeholder="{{ __('messages.search_attribute_value') }}" />

                    </div>

                </div>

                <div class="card-toolbar">

                    <a href="{{ route('attribute-values.create') }}"
                        class="btn btn-primary">

                        {{ __('messages.add_attribute_value') }}

                    </a>

                </div>

            </div>

            <div class="card-body pt-0">

                <table class="table align-middle table-row-dashed fs-6 gy-5">

                    <thead>

                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">

                            <th>#</th>

                            <th>{{ __('messages.attribute') }}</th>

                            <th>{{ __('messages.value') }}</th>

                            <th class="text-end">
                                {{ __('messages.actions') }}
                            </th>

                        </tr>

                    </thead>

                    <tbody class="fw-bold text-gray-600">

                        @forelse($attributeValues as $attributeValue)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $attributeValue->attribute->name }}
                                </td>

                                <td>
                                    {{ $attributeValue->value }}
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

                                            <a href="{{ route('attribute-values.edit', $attributeValue->id) }}"
                                                class="menu-link px-3">

                                                {{ __('messages.edit') }}

                                            </a>

                                        </div>

                                        <div class="menu-item px-3">

                                            <a href="#"
                                                class="menu-link px-3 text-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal-{{ $attributeValue->id }}">

                                                {{ __('messages.delete') }}

                                            </a>

                                        </div>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center">
                                    {{ __('messages.no_attribute_values_found') }}
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@foreach($attributeValues as $attributeValue)

<div class="modal fade"
    id="deleteModal-{{ $attributeValue->id }}"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form method="POST"
                action="{{ route('attribute-values.destroy', $attributeValue->id) }}">

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
                        {{ __('messages.confirm_delete_attribute_value') }}
                    </p>

                    <p class="fw-bold text-danger">
                        {{ $attributeValue->value }}
                    </p>

                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
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
