<!--begin::Aside-->
<div id="kt_aside" class="aside aside-dark aside-hoverable"
    data-kt-drawer="true"
    data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}"
    data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">

    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('/management-hub-v4r9.dashboard') }}">
                <img alt="Logo" src="{{ URL::asset('assets/media/logos/logo.png') }}" class="img-fluid"
                style="max-width: 100%; height: auto;" />
            </a>
        @endif

        @if(auth()->check() && auth()->user()->role === 'employee')
            <a href="{{ route('employee.dashboard') }}">
                <img alt="Logo" src="{{ URL::asset('assets/media/logos/logo.png') }}" class="h-150px logo" />
            </a>
        @endif

        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
            data-kt-toggle="true"
            data-kt-toggle-state="active"
            data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">

            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="black"/>
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="black"/>
                </svg>
            </span>

        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->

    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <div class="hover-scroll-overlay-y my-5 my-lg-5"
            id="kt_aside_menu_wrapper"
            data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
            data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">

            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu"
                data-kt-menu="true">

                {{-- =====================================================
                    ADMIN ONLY SECTION
                ====================================================== --}}
                @if(auth()->check() && auth()->user()->role === 'admin')
                    {{-- Dashboard Admin --}}
                    <div class="menu-item here show">
                        <a href="{{ route('/management-hub-v4r9.dashboard') }}" class="menu-link">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect x="2" y="2" width="9" height="9" rx="2" fill="black"/>
                                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black"/>
                                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black"/>
                                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">{{ __('messages.dashboards') }}</span>
                        </a>
                    </div>

                    {{-- SECTION --}}
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('messages.admin_panel') }}</span>
                        </div>
                    </div>

                    {{-- Caltalog --}}
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon">📁</span>
                            <span class="menu-title">{{ __('messages.catalog') }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a href="{{ route('categories.index') }}" class="menu-link">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('messages.categories') }}</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a href="{{ route('products.index') }}" class="menu-link">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('messages.products') }}</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a href="{{ route('product-variants.index') }}" class="menu-link">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('messages.product_variants') }}</span>
                                </a>
                            </div>

                        </div>
                    </div>

                    {{-- PRODUCT CONFIGURATION --}}
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon">🛒</span>
                            <span class="menu-title">{{ __('messages.product_configuration') }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a href="{{ route('attributes.index') }}" class="menu-link">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('messages.attributes') }}</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a href="{{ route('attribute-values.index') }}" class="menu-link">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('messages.attribute_values') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Ratings --}}
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon">⭐</span>
                            <span class="menu-title">{{ __('messages.ratings') }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a href="{{ route('reviews.index') }}" class="menu-link">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('messages.review') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- SALES --}}
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon">🏷️</span>
                            <span class="menu-title">{{ __('messages.sales') }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a href="{{ route('orders.index') }}" class="menu-link">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('messages.orders') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- MARKETING --}}
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon">📢</span>
                            <span class="menu-title">{{ __('messages.marketing') }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a href="{{ route('banners.index') }}" class="menu-link">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('messages.banners') }}</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a href="{{ route('coupons.index') }}" class="menu-link">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('messages.coupons') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- User VALUE --}}
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon">👨‍💼</span>
                            <span class="menu-title">{{ __('messages.employee') }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a href="{{ route('users.index') }}" class="menu-link">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('messages.all_employees') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            

                {{-- =====================================================
                        EMPLOYEE ONLY SECTION
                ====================================================== --}}
                @if(auth()->check() && auth()->user()->role === 'employee')
                    {{-- Dashboard EMPLOYEE --}}
                    <div class="menu-item here show">
                        <a href="{{ route('/staff-x7p2.dashboard') }}" class="menu-link">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect x="2" y="2" width="9" height="9" rx="2" fill="black"/>
                                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black"/>
                                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black"/>
                                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">{{ __('messages.dashboards') }}</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8">
                                {{ __('messages.employee_panel') }}
                            </span>
                        </div>
                    </div>

                    {{-- Sales --}}
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon">🏷️</span>
                            <span class="menu-title">{{ __('messages.sales') }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a href="{{ route('/staff-x7p2.orders.index') }}" class="menu-link">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('messages.orders') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Coupon --}}
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <span class="menu-link">
                            <span class="menu-icon">🎟️</span>
                            <span class="menu-title">{{ __('messages.coupons') }}</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a href="{{ route('/staff-x7p2.coupons.index') }}" class="menu-link">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('messages.view_coupons') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!--end::Aside menu-->

</div>
<!--end::Aside-->