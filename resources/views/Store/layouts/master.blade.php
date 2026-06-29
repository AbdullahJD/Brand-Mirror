<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    @include('Store.layouts.head')
</head>

<body class="{{ app()->getLocale() === 'ar' ? 'text-right rtl-layout' : '' }}">

    <!-- Topbar Start and Navbar Start -->

        @include('Store.layouts.header')    

    <!-- Topbar End and Navbar End -->

    @yield('content')

    
    <div id="toast" style="
        position: fixed;
        bottom: 30px;
        {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 30px;
        background: #28a745;
        color: white;
        padding: 12px 18px;
        border-radius: 8px;
        display: none;
        z-index: 999999;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        font-size: 14px;
        max-width: 300px;">
    </div>

    <!-- Footer Start -->
        @include('Store.layouts.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    @include('Store.layouts.scripts')
</body>

</html>
