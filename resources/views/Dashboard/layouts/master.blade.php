<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
		@include('Dashboard.layouts.head')
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Aside-->
					@include('Dashboard.layouts.sidebar')
				<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
						@include('Dashboard.layouts.header')
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<div class="toolbar" id="kt_toolbar">
							<!--begin::Container-->
								@include('Dashboard.layouts.toolbar')
							<!--end::Container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Post-->
            				@yield('content')
						<!--end::Post-->
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
						@include('Dashboard.layouts.footer')
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!--end::Modals-->
			@include('Dashboard.layouts.script')
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>