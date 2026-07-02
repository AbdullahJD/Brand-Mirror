	<!--begin::Head-->
	<head><base href="">
		<title>@yield("title")</title>		
		<meta charset="utf-8" />
		<meta name="description" content="{{ __('messages.admin_meta_description') }}" />
		<meta name="keywords" content="{{ __('messages.admin_meta_keywords') }}" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="{{ app()->getLocale() === 'ar' ? 'ar_AR' : 'en_US' }}" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="{{ __('messages.admin_og_title') }}" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="{{ __('messages.admin_site_name') }}" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="{{ URL::asset('assets/media/logos/favicon.ico') }}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="{{ URL::asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ URL::asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		@if(app()->getLocale() === 'ar')
			<link href="{{ asset('assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
		@else
			<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		@endif

		@if(app()->getLocale() === 'ar')
		<link href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap" rel="stylesheet">
		<style>
			body.rtl { font-family: 'Cairo', Poppins, sans-serif; direction: rtl; }
		</style>
		@endif

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
