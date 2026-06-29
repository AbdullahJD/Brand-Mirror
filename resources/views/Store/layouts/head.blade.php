<meta charset="utf-8">
    <title>@yield("title")</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ URL::asset('assets/media/logos/favicon.ico') }}" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="{{ __('messages.meta_keywords') }}" name="keywords">
    <meta content="{{ __('messages.meta_description') }}" name="description">

    <!-- Favicon -->
    <link href="{{ URL::asset('website/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    @if(app()->getLocale() === 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap" rel="stylesheet">
    @else
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    @endif

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap الأساسي (للجميع) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
{{-- 
    @if(app()->getLocale() === 'ar')
        <!-- RTL فقط -->
        <link href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css" rel="stylesheet">
    @endif --}}

    <!-- Libraries Stylesheet -->
    <link href="{{ URL::asset('website/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('website/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ URL::asset('website/css/style.css') }}" rel="stylesheet">

    @if(app()->getLocale() === 'ar')
    <style>
        body.rtl { font-family: 'Cairo', sans-serif; direction: rtl; text-align: right; }
        body.rtl .text-left { text-align: right !important; }
        body.rtl .text-right { text-align: left !important; }
        body.rtl .mr-2, body.rtl .mr-3, body.rtl .mr-4 { margin-right: 0 !important; margin-left: 0.5rem !important; }
        body.rtl .ml-3, body.rtl .ml-n1 { margin-left: 0 !important; margin-right: 0.25rem !important; }
        body.rtl .dropdown-menu-right { right: auto; left: 0; }
        body.rtl .fa-angle-right { transform: rotate(180deg); }
        body.rtl {
            direction: rtl;
            text-align: right;
        }
        .rtl-actions {
            display: flex;
            align-items: center;
            gap: 12px; /* هذا أهم سطر */
        }

        html[dir="rtl"] .rtl-actions {
            margin-right: auto;
            margin-left: 0;
        }
    </style>
    @endif
