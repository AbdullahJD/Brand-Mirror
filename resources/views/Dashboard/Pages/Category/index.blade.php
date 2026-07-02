@extends('Dashboard.layouts.master')

@section('title')
{{ __('messages.category_page_title') }}
@endsection

@section('content')
	<!--begin::Content-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<!--begin::Container-->
			<div id="kt_content_container" class="container-xxl">
				<!--begin::Category-->
				<div class="card card-flush">
					<!--begin::Card header-->
					<div class="card-header align-items-center py-5 gap-2 gap-md-5">
						<!--begin::Card title-->
						<div class="card-title">
							<!--begin::Search-->
							<div class="d-flex align-items-center position-relative my-1">
								<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
								<span class="svg-icon svg-icon-1 position-absolute ms-4">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
										<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
									</svg>
								</span>
								<!--end::Svg Icon-->
								<input type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="{{ __('messages.search_category') }}" />
							</div>
							<!--end::Search-->
						</div>
						<!--end::Card title-->
						<!--begin::Card toolbar-->
						<div class="card-toolbar">
							<!--begin::Add customer-->
							<a href="{{ route('categories.create') }}" class="btn btn-primary">{{ __('messages.add_category') }}</a>
							<!--end::Add customer-->
						</div>
						<!--end::Card toolbar-->
					</div>
					<!--end::Card header-->
					<!--begin::Card body-->
					<div class="card-body pt-0">
						<!--begin::Table-->
						<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
							<!--begin::Table head-->
							<thead>
								<!--begin::Table row-->
								<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
									<th class="w-10px pe-2">#</th>
									<th class="min-w-250px">{{ __('messages.image') }}</th>
									<th class="min-w-250px">{{ __('messages.category_name') }}</th>
									<th class="min-w-150px">{{ __('messages.parent_category') }}</th>
									<th class="min-w-100px">{{ __('messages.status') }}</th>
									<th class="text-end">{{ __('messages.actions') }}</th>
								</tr>
								<!--end::Table row-->
							</thead>
							<!--end::Table head-->
							<!--begin::Table body-->
							<tbody class="fw-bold text-gray-600">
								@forelse($categories as $category)
									<tr>

										<td>{{ $loop->iteration }}</td>

										<td>
											@if($category->image)
												<img src="{{ asset('storage/'.$category->image) }}"
													width="50" class="rounded">
											@else
												<span>{{ __('messages.no_image') }}</span>
											@endif
										</td>
										<td>
											<div class="d-flex flex-column">
												<span class="text-gray-800 fw-bolder fs-6">
													{{ $category->name }}
												</span>

												<span class="text-muted fs-7">
													{{ $category->description }}
												</span>
											</div>
										</td>

										<td>
											{{ $category->parent?->name ?? __('messages.main_category') }}
										</td>

										<td>
											@if($category->status)
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
											<a href="#" class="btn btn-sm btn-light btn-active-light-primary"
											data-kt-menu-trigger="click"
											data-kt-menu-placement="bottom-end">
												{{ __('messages.actions') }}
											</a>

											<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded
														menu-gray-600 menu-state-bg-light-primary fw-bold fs-7
														w-125px py-4"
												data-kt-menu="true">

												<div class="menu-item px-3">
													<a href="{{ route('categories.edit', $category->id) }}"
													class="menu-link px-3">
														{{ __('messages.edit') }}
													</a>
												</div>

												<div class="menu-item px-3">
													<a href="#" class="menu-link px-3 text-danger"
													data-bs-toggle="modal"
													data-bs-target="#deleteModal-{{ $category->id }}">
														{{ __('messages.delete') }}
													</a>
												</div>

											</div>
										</td>

									</tr>
								@empty
									<tr>
										<td colspan="5" class="text-center">
											{{ __('messages.no_categories_found') }}
										</td>
									</tr>
								@endforelse
							</tbody>
							<!--end::Table body-->
						</table>
						<!--end::Table-->
					</div>
					<!--end::Card body-->
				</div>
				<!--end::Category-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Post-->
	<!--end::Content-->

	@foreach($categories as $category)

		<div class="modal fade" id="deleteModal-{{ $category->id }}" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">

					<form method="POST" action="{{ route('categories.destroy', $category->id) }}">
						@csrf
						@method('DELETE')

						<div class="modal-header">
							<h5 class="modal-title">{{ __('messages.confirm_delete') }}</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>

						<div class="modal-body">
							<p>{{ __('messages.confirm_delete_category') }}</p>
							<p class="fw-bold text-danger">
								{{ $category->name }}
							</p>
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

