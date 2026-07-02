@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.users_page_title') }}
@endsection

@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">

        <div class="card card-flush">

            <div class="card-header align-items-center py-5">

                <div class="card-title">
                    <h2>{{ __('messages.users_management') }}</h2>
                </div>

                <div class="card-toolbar">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        {{ __('messages.add_user') }}
                    </a>
                </div>

            </div>

            <div class="card-body pt-0">

                <table class="table align-middle table-row-dashed fs-6 gy-5">

                    <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th>#</th>
                            <th>{{ __('messages.name') }}</th>
                            <th>{{ __('messages.email') }}</th>
                            <th>{{ __('messages.role') }}</th>
                            <th>{{ __('messages.created_at') }}</th>
                            <th class="text-end">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($users as $user)

                            <tr>

                                <td>{{ $user->id }}</td>

                                <td>{{ $user->name }}</td>

                                <td>{{ $user->email }}</td>

                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge badge-light-danger">
                                            {{ __('messages.role_admin') }}
                                        </span>
                                    @else
                                        <span class="badge badge-light-primary">
                                            {{ __('messages.employee') }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $user->created_at->format('Y-m-d') }}
                                </td>

                                <td class="text-end">

                                    <a href="#"
                                        class="btn btn-sm btn-light btn-active-light-primary"
                                        data-kt-menu-trigger="click">
                                        {{ __('messages.actions') }}
                                    </a>

                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded
                                                menu-gray-600 menu-state-bg-light-primary fw-bold fs-7
                                                w-125px py-4"
                                        data-kt-menu="true">

                                        <div class="menu-item px-3">
                                            <a href="{{ route('users.edit',$user->id) }}"
                                                class="menu-link px-3">
                                                {{ __('messages.edit') }}
                                            </a>
                                        </div>

                                        <div class="menu-item px-3">
                                            <a href="#"
                                                class="menu-link px-3 text-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal-{{ $user->id }}">
                                                {{ __('messages.delete') }}
                                            </a>
                                        </div>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center">
                                    {{ __('messages.no_users_found') }}
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

                <div class="mt-5">
                    {{ $users->links() }}
                </div>

            </div>

        </div>

    </div>
</div>

@foreach($users as $user)

<div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form action="{{ route('users.destroy',$user->id) }}"
                method="POST">

                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('messages.delete_user') }}
                    </h5>
                </div>

                <div class="modal-body">

                    {{ __('messages.confirm_delete_named') }}

                    <strong>{{ $user->name }}</strong>

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
