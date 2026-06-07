@extends('Dashboard.layouts.master')

@section('content')
    <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Products-->
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
                                <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Product" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            <div class="w-100 mw-150px">
                                <!--begin::Select2-->
                                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-product-filter="status">
                                    <option></option>
                                    <option value="all">All</option>
                                    <option value="published">Published</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="Draft">Draft</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <!--end::Select2-->
                            </div>
                            <!--begin::Add product-->
                            <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
                            <!--end::Add product-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Discount Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @forelse($products as $product)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            @if($product->main_image)
                                                <img src="{{ asset('storage/' . $product->main_image) }}"
                                                    width="50"
                                                    class="rounded">
                                            @else
                                                <img src="{{ asset('assets/media/avatars/blank.png') }}"
                                                    width="50"
                                                    class="rounded">
                                            @endif
                                        </td>

                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">
                                                    {{ $product->name }}
                                                </span>

                                                <small class="text-muted">
                                                    {{ Str::limit($product->description, 50) }}
                                                </small>
                                            </div>
                                        </td>

                                        <td>
                                            {{ $product->category->name }}
                                        </td>

                                        <td>
                                            ${{ $product->price }}
                                        </td>

                                        <td>
                                            @if($product->discount_price)
                                                ${{ $product->discount_price }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            {{ $product->stock }}
                                        </td>

                                        <td>
                                            
                                             @if($product->status == 'published')
                                                <span class="badge badge-light-success">
                                                    Published
                                                </span>

                                            @elseif($product->status == 'draft')
                                                <span class="badge badge-light-warning">
                                                    Draft
                                                </span>

                                            @elseif($product->status == 'scheduled')
                                                <span class="badge badge-light-info">
                                                    Scheduled
                                                </span>
                                            @else
                                                <span class="badge badge-light-danger">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>

										<td class="text-end">
											<a href="#" class="btn btn-sm btn-light btn-active-light-primary"
											data-kt-menu-trigger="click"
											data-kt-menu-placement="bottom-end">
												Actions
											</a>

											<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded
														menu-gray-600 menu-state-bg-light-primary fw-bold fs-7
														w-125px py-4"
												data-kt-menu="true">

												<div class="menu-item px-3">
													<a href="{{ route('products.edit', $product->id) }}"
													class="menu-link px-3">
														Edit
													</a>
												</div>

												<div class="menu-item px-3">
													<a href="#" class="menu-link px-3 text-danger"
													data-bs-toggle="modal"
													data-bs-target="#deleteModal-{{ $product->id }}">
														Delete
													</a>
												</div>

											</div>
										</td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No Products Found
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
                <!--end::Products-->
            </div>
            <!--end::Container-->
        </div>
    <!--end::Post-->
@endsection

	@foreach($products as $product)

		<div class="modal fade" id="deleteModal-{{ $product->id }}" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">

					<form method="POST" action="{{ route('products.destroy', $product->id) }}">
						@csrf
						@method('DELETE')

						<div class="modal-header">
							<h5 class="modal-title">تأكيد الحذف</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>

						<div class="modal-body">
							<p>هل أنت متأكد أنك تريد حذف هذا القسم؟</p>
							<p class="fw-bold text-danger">
								{{ $product->name }}
							</p>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
								إلغاء
							</button>

							<button type="submit" class="btn btn-danger">
								حذف
							</button>
						</div>

					</form>

				</div>
			</div>
		</div>

	@endforeach

@section('js')
    <script src="{{ URL::asset('assets/js/custom/apps/ecommerce/catalog/products.js') }}"></script>
@endsection