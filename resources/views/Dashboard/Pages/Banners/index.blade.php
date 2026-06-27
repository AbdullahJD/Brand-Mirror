@extends('Dashboard.layouts.master')

@section('title')
Banners
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">

        <div class="card card-flush">

            <div class="card-header align-items-center py-5 gap-2 gap-md-5">

                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <input type="text"
                            class="form-control form-control-solid w-250px"
                            placeholder="Search Banner" />
                    </div>
                </div>

                <div class="card-toolbar">
                    <a href="{{ route('banners.create') }}"
                    class="btn btn-primary">
                        Add Banner
                    </a>
                </div>

            </div>

            <div class="card-body pt-0">

                <table class="table align-middle table-row-dashed fs-6 gy-5">

                    <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Link</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($banners as $banner)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <img src="{{ asset('storage/'.$banner->image) }}"
                                        width="120"
                                        class="rounded">
                                </td>

                                <td>
                                    {{ $banner->title ?? '-' }}
                                </td>

                                <td>
                                    {{ $banner->link ?? '-' }}
                                </td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ $banner->position }}
                                    </span>
                                </td>

                                <td>
                                    @if($banner->status)
                                        <span class="badge badge-light-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge badge-light-danger">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end">

                                    <a href="#"
                                    class="btn btn-sm btn-light btn-active-light-primary"
                                    data-kt-menu-trigger="click">
                                        Actions
                                    </a>

                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded
                                                menu-gray-600 menu-state-bg-light-primary fw-bold fs-7
                                                w-125px py-4"
                                        data-kt-menu="true">

                                        <div class="menu-item px-3">
                                            <a href="{{ route('banners.edit',$banner->id) }}"
                                            class="menu-link px-3">
                                                Edit
                                            </a>
                                        </div>

                                        <div class="menu-item px-3">
                                            <a href="#"
                                            class="menu-link px-3 text-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal-{{ $banner->id }}">
                                                Delete
                                            </a>
                                        </div>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center">
                                    No Banners Found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

                {{ $banners->links() }}

            </div>

        </div>

    </div>

</div>

@foreach($banners as $banner)

    <div class="modal fade" id="deleteModal-{{ $banner->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form method="POST"
                    action="{{ route('banners.destroy',$banner->id) }}">

                    @csrf
                    @method('DELETE')

                    <div class="modal-header">
                        <h5 class="modal-title">Delete Banner</h5>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete:
                        <strong>{{ $banner->title }}</strong> ?
                    </div>

                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit"
                                class="btn btn-danger">
                            Delete
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endforeach

@endsection
