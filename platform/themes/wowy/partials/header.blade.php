<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        @php
            $isUtilityNoindexPage = request()->is('cart')
                || request()->is('compare')
                || request()->is('wishlist')
                || request()->is('login')
                || request()->is('register')
                || request()->is('checkout*')
                || request()->is('customer*')
                || request()->is('orders/tracking*')
                || request()->is('currency/switch/*');
        @endphp
        @if ($isUtilityNoindexPage)
            <meta name="robots" content="noindex,follow">
        @endif
        
        <!-- Resource Hints for Performance -->
        <link rel="preconnect" href="https://cdn.jsdelivr.net">
        <link rel="preconnect" href="https://cdnjs.cloudflare.com">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        @php
            $isHomePage = request()->path() === '/' || request()->routeIs('public.index');
            $isBlogPage = request()->is('blog') || request()->is('blog/*');
            $isCategoryPage = request()->is('product-categories*')
                || request()->is('categories')
                || request()->is('allproducts/category/*')
                || request()->is('sub/*');
            $isContactPage = request()->is('contact*');
            $isAuthPage = request()->is('login')
                || request()->is('register')
                || request()->is('password/reset*')
                || request()->is('customer/login*')
                || request()->is('customer/register*')
                || request()->is('th/login*')
                || request()->is('th/register*');
            $useTailwindCss = $isBlogPage || $isAuthPage;
            $useTailwindCdn = $isHomePage || $isCategoryPage || $isContactPage;
            $cssVersion = '20260424-3';
        @endphp
        @if ($isHomePage)
            <link rel="preload" as="image" href="{{ asset('storage/ads01/30l/m30l-hero.jpg') }}" fetchpriority="high" media="(max-width: 767px)">
            <link rel="preload" as="image" href="{{ asset('storage/ads01/30l/m30l-hero.jpg') }}" fetchpriority="high" media="(min-width: 768px)">
        @endif
        @if ($useTailwindCss)
            <link rel="preload" href="{{ asset('css/tailwind.css') }}?v=20260424-3" as="style">
            <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}?v=20260424-3">
        @endif
        @if ($useTailwindCdn)
            <script>
                window.tailwind = window.tailwind || {};
                window.tailwind.config = window.tailwind.config || {};
                window.tailwind.config.corePlugins = Object.assign(
                    {},
                    window.tailwind.config.corePlugins || {},
                    { preflight: false }
                );
            </script>
            <script src="https://cdn.tailwindcss.com"></script>
        @endif
        @if (BaseHelper::isRtlEnabled())
            <link rel="stylesheet" href="{{ Theme::asset()->url('plugins/bootstrap/css/bootstrap.rtl.min.css') }}?v={{ $cssVersion }}">
        @else
            <link rel="stylesheet" href="{{ Theme::asset()->url('plugins/bootstrap/css/bootstrap.min.css') }}?v={{ $cssVersion }}">
        @endif
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/vendors/normalize.css') }}?v={{ $cssVersion }}">
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/vendors/fontawesome-all.min.css') }}?v={{ $cssVersion }}">
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/vendors/wowy-font.css') }}?v={{ $cssVersion }}">
        <link rel="preload" href="{{ Theme::asset()->url('css/plugins/animate.css') }}?v={{ $cssVersion }}" as="style">
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/plugins/animate.css') }}?v={{ $cssVersion }}" media="print" onload="this.media='all'">
        <noscript>
            <link rel="stylesheet" href="{{ Theme::asset()->url('css/plugins/animate.css') }}?v={{ $cssVersion }}">
        </noscript>
        <link rel="preload" href="{{ Theme::asset()->url('css/plugins/slick.css') }}?v={{ $cssVersion }}" as="style">
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/plugins/slick.css') }}?v={{ $cssVersion }}" media="print" onload="this.media='all'">
        <noscript>
            <link rel="stylesheet" href="{{ Theme::asset()->url('css/plugins/slick.css') }}?v={{ $cssVersion }}">
        </noscript>
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/style.css') }}?v={{ $cssVersion }}">
        @if (is_plugin_active('ecommerce'))
            <link rel="stylesheet" href="{{ asset('vendor/core/plugins/ecommerce/css/front-ecommerce.css') }}?v={{ $cssVersion }}">
        @endif
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @php
            $fallbackSeoTitle = trim(strip_tags(SeoHelper::getTitle() ?: theme_option('seo_title', theme_option('site_title', 'RUBYSHOP'))));
            $fallbackSeoDescription = trim(strip_tags(SeoHelper::getDescription() ?: theme_option('seo_description', '')));
            $fallbackSeoImage = trim(SeoHelper::openGraph()->getProperty('image') ?: theme_option('seo_og_image', asset('storage/ads/rubyshop-catalog2.jpg')));
            $fallbackSeoUrl = url()->current();
            $fallbackOgTitle = mb_strlen($fallbackSeoTitle) > 60 ? rtrim(mb_substr($fallbackSeoTitle, 0, 57)) . '...' : $fallbackSeoTitle;
            $fallbackTwitterTitle = mb_strlen($fallbackSeoTitle) > 70 ? rtrim(mb_substr($fallbackSeoTitle, 0, 67)) . '...' : $fallbackSeoTitle;
        @endphp
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $fallbackTwitterTitle }}">
        <meta name="twitter:description" content="{{ $fallbackSeoDescription }}">
        <meta name="twitter:image" content="{{ $fallbackSeoImage }}">
        <meta name="twitter:url" content="{{ $fallbackSeoUrl }}">
        <meta name="twitter:site" content="@RUBYSHOP168">
        <meta property="og:title" content="{{ $fallbackOgTitle }}">

        <!-- Non-critical CSS loaded in footer to keep initial render path lean -->
            
                <!-- Force LocalBusiness Schema on Homepage -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "RUBYSHOP",
            "alternateName": "รูบี้ช๊อป",
            "description": "ศูนย์รวมเครื่องมือช่าง อุปกรณ์ก่อสร้าง และเทคโนโลยีงานช่างครบวงจร - พ่นปูน, พ่นสีแรงดันสูง, กรีดผนังเซาะร่อง, ฉีดโพม, กันซึม",
            "image": "https://www.rubyshop.co.th/logo.png",
            "@id": "https://www.rubyshop.co.th/",
            "url": "https://www.rubyshop.co.th/",
            "telephone": "+66-89-666-7802",
            "email": "info@rubyshop.co.th",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "9 ถนนประชาอุทิศ แขวงสีกัน เขตดอนเมือง",
                "addressLocality": "เขตดอนเมือง",
                "addressRegion": "กรุงเทพมหานคร",
                "postalCode": "10210",
                "addressCountry": "TH"
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": 14.0273154,
                "longitude": 100.1725207
            },
            "openingHoursSpecification": [{
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                "opens": "08:30",
                "closes": "17:30"
            }],
            "sameAs": [
                "https://www.facebook.com/photo/?fbid=707251024751513&set=a.432474452229173",
                "https://maps.app.goo.gl/8QtWpT29vT1Rspgq8",
                "https://www.instagram.com/rubyshop_thailand",
                "https://www.youtube.com/@rubyshop-thailand",
                "https://x.com/RUBYSHOP168",
                "https://www.linkedin.com/company/rubyshop-thailand"
            ],
            "priceRange": "฿฿",
            "paymentAccepted": ["Cash", "Credit Card", "Bank Transfer"],
            "currenciesAccepted": "THB"
        }
        </script>




        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap">

        <style>
            :root {
                --font-text: Prompt;
                --color-brand: {{ theme_option('color_brand', '#5897fb') }};
                --primary-color: {{ theme_option('color_brand', '#5897fb') }};
                --color-brand-2: {{ theme_option('color_brand_2', '#3256e0') }};
                --color-primary: {{ theme_option('color_primary', '#3f81eb') }};
                --color-secondary: {{ theme_option('color_secondary', '#41506b') }};
                --color-warning: {{ theme_option('color_warning', '#ffb300') }};
                --color-danger: {{ theme_option('color_danger', '#ff3551') }};
                --color-success: {{ theme_option('color_success', '#3ed092') }};
                --color-info: {{ theme_option('color_info', '#18a1b7') }};
                --color-text: {{ theme_option('color_text', '#4f5d77') }};
                --color-heading: {{ theme_option('color_heading', '#222222') }};
                --color-grey-1: {{ theme_option('color_grey_1', '#111111') }};
                --color-grey-2: {{ theme_option('color_grey_2', '#242424') }};
                --color-grey-4: {{ theme_option('color_grey_4', '#90908e') }};
                --color-grey-9: {{ theme_option('color_grey_9', '#f4f5f9') }};
                --color-muted: {{ theme_option('color_muted', '#8e8e90') }};
                --color-body: {{ theme_option('color_body', '#4f5d77') }};
            }

            /* Mobile Menu Styles */
            .mobile-header-active {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: white;
                z-index: 9999;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                overflow-y: auto;
                visibility: hidden;
                opacity: 0;
                display: none;
            }

            .mobile-header-active.sidebar-visible {
                transform: translateX(0);
                visibility: visible;
                opacity: 1;
                display: block !important;
            }

            .body-overlay-1 {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: rgba(0, 0, 0, 0.5);
                z-index: 9998;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            body.mobile-menu-active .body-overlay-1 {
                opacity: 1;
                visibility: visible;
            }

            /* Hamburger Menu */
            .burger-icon {
                cursor: pointer;
                position: relative !important;
                z-index: 10000;
                display: flex !important;
                flex-direction: column !important;
                justify-content: space-between !important;
                align-items: center !important;
                width: 38px !important;
                height: 38px !important;
                padding: 9px 7px !important;
                box-sizing: border-box !important;
                background: rgba(0,0,0,0.15);
                border-radius: 4px;
                transition: background 0.2s ease;
            }

            .burger-icon:hover {
                background: rgba(0,0,0,0.25);
            }

            /* Force spans out of absolute positioning from theme CSS */
            .burger-icon span,
            .burger-icon .burger-icon-top,
            .burger-icon .burger-icon-mid,
            .burger-icon .burger-icon-bottom {
                display: block !important;
                position: relative !important;
                top: auto !important;
                bottom: auto !important;
                left: auto !important;
                width: 100% !important;
                height: 2px !important;
                background: #fff !important;
                margin: 0 !important;
                flex-shrink: 0;
                transition: all 0.3s ease;
                transform-origin: center;
            }

            /* Hide theme pseudo-elements — we use background directly */
            .burger-icon span::before,
            .burger-icon span::after {
                display: none !important;
            }

            /* Additional Mobile Menu Styles */
            .mobile-header-wrapper-inner {
                padding: 20px;
                height: 100%;
                overflow-y: auto;
            }

            .mobile-menu-close {
                position: absolute;
                top: 15px;
                right: 15px;
                z-index: 10001;
            }

            /* Reverse menu order in mobile */
            @media (max-width: 991px) {
                .mobile-header-content-area {
                    display: flex;
                    flex-direction: column;
                }
                
                .mobile-menu-wrap {
                    order: 1;
                }
                
                .mobile-search {
                    order: 2;
                }
                
                .mobile-social-icon {
                    order: 3;
                    margin: 20px 0;
                }
                
                .mobile-header-info-wrap {
                    order: 4 !important;
                    margin-bottom: 20px;
                }
                
                /* Make sure info section goes to bottom */
                .mobile-header-wrapper-inner {
                    display: flex;
                    flex-direction: column;
                    min-height: calc(100vh - 40px);
                }
                
                .mobile-header-content-area {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                }
                
                /* Push user info to bottom with margin-top auto */
                .mobile-header-info-wrap {
                    margin-top: auto !important;
                }
                
                /* Reverse the navigation menu items order */
                .mobile-menu-wrap nav ul.mobile-menu {
                    display: flex !important;
                    flex-direction: column-reverse;
                }
                
                .mobile-menu-wrap .mobile-menu li {
                    order: initial;
                }
            }

             .imgMixBlendMode {
    mix-blend-mode: multiply;
}




            /* Ensure mobile menu is hidden on desktop */
            @media (min-width: 992px) {
                .mobile-header-active {
                    display: none !important;
                }
                .body-overlay-1 {
                    display: none !important;
                }
            }

            /* Force mobile menu to work properly */
            @media (max-width: 991px) {
                .mobile-header-active {
                    display: block;
                }
                
                .burger-icon {
                    display: flex !important;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                }
                
                /* Hide Browse Categories in mobile */
                .mobile-header-active .main-categories-wrap {
                    display: none !important;
                }
            }
            .header-bottom p,
            .header-top p,
            .header-middle p {
                margin-bottom: -24px !important;
            }

            @media (max-width: 991px) {
                html { overflow-x: hidden; }
            }
            .header-bottom .header-wrap {
                display: flex;
                align-items: center;
                gap: 24px;
            }

            .header-bottom .main-menu {
                flex: 1 1 auto;
                min-width: 0;
            }

            .header-bottom .main-categories-wrap,
            .header-bottom .hotline {
                flex-shrink: 0;
            }

            .header-bottom .main-menu > nav > ul {
                display: flex;
                align-items: center;
                gap: 28px;
                justify-content: center;
                margin: 0;
                padding: 0;
                list-style: none;
            }

            .header-bottom .main-menu > nav > ul > li > a {
                white-space: nowrap;
            }

            @media (min-width: 992px) and (max-width: 1250px) {
                .header-bottom .header-wrap {
                    gap: 12px;
                }

                .header-bottom .main-menu > nav > ul {
                    gap: 16px;
                }

                .header-bottom .main-menu > nav > ul > li > a {
                    font-size: 14px;
                    padding: 6px 0;
                }

                .header-bottom .hotline p span {
                    display: none;
                }

                .header-bottom .hotline p {
                    font-size: 0.95rem;
                }
            }

            @media (min-width: 992px) and (max-width: 1380px) {
                .header-bottom .main-categories-wrap,
                .header-bottom .hotline {
                    display: none !important;
                }
            }

            .header-bottom .hotline {
                display: flex;
                align-items: center;
                height: 100%;
            }

            .header-bottom .hotline p {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                margin: 0;
                line-height: 1.4;
            }

            /* ======================================================
               MAIN NAV DROPDOWN — redesign
               ====================================================== */

            /* Dropdown container */
            .main-menu > nav > ul > li ul.sub-menu {
                border-radius: 14px !important;
                box-shadow: 0 12px 40px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06) !important;
                border: 1px solid #f0f0f0 !important;
                padding: 8px 0 !important;
                margin-top: 12px !important;
                width: 240px !important;
            }

            /* Each item */
            .main-menu > nav > ul > li ul.sub-menu li {
                margin-bottom: 0 !important;
                border-bottom: 1px solid #f5f5f5 !important;
            }
            .main-menu > nav > ul > li ul.sub-menu li:last-child {
                border-bottom: none !important;
            }

            /* Item link */
            .main-menu > nav > ul > li ul.sub-menu li a {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 10px 18px !important;
                font-size: 13.5px !important;
                font-weight: 500 !important;
                color: #1f2937 !important;
                border-left: 3px solid transparent !important;
                transition: background 0.15s, color 0.15s, border-color 0.15s, padding-left 0.15s !important;
                line-height: 1.4 !important;
            }

            /* Hover */
            .main-menu > nav > ul > li ul.sub-menu li:hover > a {
                color: #dc2626 !important;
                background: #fef2f2 !important;
                border-left-color: #dc2626 !important;
                padding-left: 22px !important;
            }

            /* Active link */
            .main-menu > nav > ul > li ul.sub-menu li a.active {
                color: #dc2626 !important;
                font-weight: 600 !important;
            }

            /* Chevron icon */
            .main-menu > nav > ul > li ul.sub-menu li a i {
                font-size: 10px !important;
                color: #9ca3af !important;
                float: none !important;
                top: 0 !important;
                transition: color 0.15s !important;
            }
            .main-menu > nav > ul > li ul.sub-menu li:hover > a i {
                color: #dc2626 !important;
            }

            /* Nested level-menu */
            .main-menu > nav > ul > li ul.sub-menu li ul.level-menu {
                border-radius: 14px !important;
                box-shadow: 0 12px 40px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06) !important;
                border: 1px solid #f0f0f0 !important;
                padding: 8px 0 !important;
                width: 220px !important;
            }

            /* ======================================================
               CATEGORY DROPDOWN — redesign
               ====================================================== */

            /* Trigger button */
            .categories-button-active {
                display: inline-flex !important;
                align-items: center !important;
                gap: 8px !important;
                background: rgba(255,255,255,0.13) !important;
                border-radius: 8px !important;
                padding: 9px 15px !important;
                font-size: 14px !important;
                font-weight: 700 !important;
                color: #fff !important;
                letter-spacing: 0.01em !important;
                transition: background 0.2s !important;
                white-space: nowrap !important;
            }
            .categories-button-active:hover,
            .categories-button-active.open {
                background: rgba(255,255,255,0.24) !important;
                color: #fff !important;
            }

            /* Dropdown container */
            .categories-dropdown-wrap {
                border-radius: 14px !important;
                border: 1px solid #f0f0f0 !important;
                box-shadow: 0 12px 48px rgba(0,0,0,0.13), 0 2px 8px rgba(0,0,0,0.06) !important;
                overflow: visible !important;
                margin-top: 10px !important;
            }
            .categories-dropdown-wrap > ul {
                overflow-y: auto !important;
                overflow-x: visible !important;
                max-height: calc(100vh - 100px) !important;
                border-radius: 14px !important;
            }

            /* Every list item row */
            .categories-dropdown-wrap > ul > li > a,
            .categories-dropdown-wrap ul li a {
                display: flex !important;
                align-items: center !important;
                gap: 10px !important;
                padding: 10px 18px !important;
                font-size: 13.5px !important;
                font-weight: 500 !important;
                color: #1f2937 !important;
                line-height: 1.4 !important;
                border-left: 3px solid transparent !important;
                transition: background 0.15s, color 0.15s, border-color 0.15s, padding-left 0.15s !important;
            }

            /* Hover state */
            .categories-dropdown-wrap ul li a:hover {
                background-color: #fef2f2 !important;
                color: #dc2626 !important;
                border-left-color: #dc2626 !important;
                padding-left: 22px !important;
            }

            /* Active / current category */
            .categories-dropdown-wrap ul li.active > a {
                color: #dc2626 !important;
                background-color: #fef2f2 !important;
                border-left-color: #dc2626 !important;
                font-weight: 700 !important;
            }

            /* Arrow for items with sub-menu */
            .categories-dropdown-wrap ul li.has-children > a::after {
                content: '›' !important;
                margin-left: auto !important;
                font-size: 18px !important;
                line-height: 1 !important;
                color: #9ca3af !important;
                font-weight: 400 !important;
            }
            .categories-dropdown-wrap ul li.has-children > a:hover::after {
                color: #dc2626 !important;
            }

            /* Thin divider between rows */
            .categories-dropdown-wrap > ul > li + li {
                border-top: 1px solid #f9fafb !important;
            }

            /* Category icon / image */
            .categories-dropdown-wrap ul li a img {
                width: 22px !important;
                height: 22px !important;
                object-fit: contain !important;
                border-radius: 5px !important;
                flex-shrink: 0 !important;
                opacity: 0.8 !important;
                transition: opacity 0.15s !important;
            }
            .categories-dropdown-wrap ul li a:hover img { opacity: 1 !important; }

            /* ── Flyout panel (right side) ── */

            /* Hidden by default — JS controls show/hide via .is-active class */
            .categories-dropdown-wrap ul li.has-children > .dropdown-menu {
                display: none;
                position: fixed !important;
                z-index: 99999 !important;
                min-width: 220px !important;
                max-width: 320px !important;
                width: 260px !important;
                max-height: calc(100vh - 80px) !important;
                overflow-y: auto !important;
            }
            .categories-dropdown-wrap ul li.has-children.is-active > .dropdown-menu {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                pointer-events: auto !important;
            }

            /* Panel styling */
            .categories-dropdown-wrap .dropdown-menu {
                border: 1px solid #f0f0f0 !important;
                border-radius: 0 12px 12px 0 !important;
                box-shadow: 4px 8px 24px rgba(0,0,0,0.10) !important;
                padding: 6px 0 !important;
                background: #fff !important;
            }

            /* Divider between sub-items */
            .categories-dropdown-wrap .dropdown-menu ul li {
                border-top: 1px solid #f9fafb !important;
            }
            .categories-dropdown-wrap .dropdown-menu ul li:first-child {
                border-top: none !important;
            }

            /* Sub-item links */
            .categories-dropdown-wrap .dropdown-menu ul li a {
                display: flex !important;
                align-items: center !important;
                gap: 8px !important;
                font-size: 13px !important;
                font-weight: 500 !important;
                color: #374151 !important;
                padding: 10px 20px !important;
                border-left: 3px solid transparent !important;
                white-space: nowrap !important;
                transition: background 0.15s, color 0.15s, border-color 0.15s, padding-left 0.15s !important;
            }
            .categories-dropdown-wrap .dropdown-menu ul li a:hover {
                color: #dc2626 !important;
                background: #fef2f2 !important;
                border-left-color: #dc2626 !important;
                padding-left: 24px !important;
            }

            /* "Show more" button */
            .more_categories {
                background: #f8fafc !important;
                border-top: 1px solid #f0f0f0 !important;
                color: #dc2626 !important;
                font-weight: 600 !important;
                font-size: 13px !important;
                padding: 11px 20px !important;
                transition: background 0.15s !important;
                text-align: center !important;
            }
            .more_categories:hover {
                background: #fef2f2 !important;
            }
        </style>

        {!! Theme::header() !!}

        @php
            $headerStyle = theme_option('header_style') ?: '';
            $page = Theme::get('page');
            if ($page) {
                $headerStyle = $page->getMetaData('header_style', true) ?: $headerStyle;
            }
            $headerStyle = ($headerStyle && in_array($headerStyle, array_keys(get_layout_header_styles()))) ? $headerStyle : '';
        
        
            
        
        
            @endphp
    </head>
    <body {!! Theme::bodyAttributes() !!} class="@if (BaseHelper::isRtlEnabled()) rtl @endif header_full_true wowy-template css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-index wowy_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true header_sticky_true hide_scrolld_true des_header_3 h_banner_true top_bar_true prs_bordered_grid_1 search_pos_canvas lazyload @if (Theme::get('bodyClass')) {{ Theme::get('bodyClass') }} @endif">
        {!! apply_filters(THEME_FRONT_BODY, null) !!}
        <div id="alert-container"></div>

        {!! Theme::partial('preloader') !!}

        <header class="header-area header-height-2 {{ $headerStyle }}" id="header-main">
            <div class="header-top header-top-ptb-1 d-none d-lg-block">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-4">
                            <div class="header-info">
                                <ul>
                                    @if (theme_option('hotline'))
                                        <li><i class="fa fa-phone-alt mr-5"></i><a href="tel:{{ theme_option('hotline') }}">{{ theme_option('hotline') }}</a></li>
                                    @endif

                                    @if (is_plugin_active('ecommerce') && EcommerceHelper::isOrderTrackingEnabled())
                                        <li><i class="far fa-anchor mr-5"></i><a href="{{ route('public.orders.tracking') }}">{{ __('Track Your Order') }}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="col-xl-5 col-lg-4">
                            <div class="text-center">
                                @if (theme_option('header_messages') && $headerMessages = json_decode(theme_option('header_messages'), true))
                                    <div id="news-flash" class="d-inline-block">
                                        <ul>
                                            @foreach($headerMessages as $headerMessage)
                                                @if (count($headerMessage) == 4)
                                                    <li>
                                                        @if ($headerMessage[0]['value'])
                                                            {!! BaseHelper::renderIcon($headerMessage[0]['value'], null, ['class' => 'd-inline-block mr-5']) !!}
                                                        @endif

                                                        @if ($headerMessage[1]['value'])
                                                            <span class="d-inline-block">
                                                                {!! BaseHelper::clean($headerMessage[1]['value']) !!}
                                                            </span>
                                                        @endif
                                                        @if ($headerMessage[2]['value'] && $headerMessage[3]['value'])
                                                            &nbsp;<a class="active d-inline-block" href="{{ url($headerMessage[2]['value']) }}">{!! BaseHelper::clean($headerMessage[3]['value']) !!}</a>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @php $currencies = is_plugin_active('ecommerce') ? get_all_currencies() : []; @endphp

                        @if (is_plugin_active('ecommerce') || is_plugin_active('language'))
                            <div class="col-xl-4 col-lg-4">
                                <div class="header-info header-info-right">
                                        <ul>
                                            @if (is_plugin_active('language'))
                                                {!! Theme::partial('language-switcher') !!}
                                            @endif

                                            @if (is_plugin_active('ecommerce'))
                                                @if (count($currencies) > 1)
                                                    <li>
                                                        <a class="language-dropdown-active" href="#"> <i class="fa fa-coins"></i> {{ get_application_currency()->title }} <i class="fa fa-chevron-down"></i></a>
                                                        <ul class="language-dropdown">
                                                            @foreach ($currencies as $currency)
                                                                @if ($currency->id !== get_application_currency_id())
                                                                    <li><a href="{{ route('public.change-currency', $currency->title) }}">{{ $currency->title }}</a></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                                @if (auth('customer')->check())
                                                    <li><a href="{{ route('customer.overview') }}">{{ auth('customer')->user()->name }}</a></li>
                                                @else
                                                    <li><a href="{{ route('customer.login') }}">{{ __('Log In / Sign Up') }}</a></li>
                                                @endif
                                            @endif
                                        </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
                <div class="container">
                    <div class="header-wrap header-space-between">
                        <div class="logo logo-width-1">
                            @if (theme_option('logo'))
                                <a href="{{ BaseHelper::getHomepageUrl() }}"><img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" width="150" height="45"></a>
                            @endif
                        </div>
                        @if (is_plugin_active('ecommerce'))
                            <div class="search-style-2">
                                <form action="{{ route('public.products') }}" class="form--quick-search" data-ajax-url="{{ route('public.ajax.search-products') }}" method="get">
                                    <div class="form-group--icon">
                                        <div class="product-cat-label">{{ __('All Categories') }}</div>
                                        <select class="product-category-select" id="product-category-select" name="categories[]">
                                            <option value="">{{ __('All Categories') }}</option>
                                            {!! ProductCategoryHelper::renderProductCategoriesSelect() !!}
                                        </select>
                                    </div>
                                    <input type="text" name="q" class="input-search-product"  placeholder="{{ __('Search for items…') }}" autocomplete="off">
                                    <button type="submit" title="search"> <i class="far fa-search"></i> </button>
                                    <div class="panel--search-result"></div>
                                </form>
                            </div>
                            <div class="header-action-right">
                                <div class="header-action-2">
                                    @if (EcommerceHelper::isCompareEnabled())
                                        <div class="header-action-icon-2">
                                            <a href="{{ route('public.compare') }}" class="compare-count">
                                                <img class="svgInject" alt="{{ __('Compare') }}" src="{{ Theme::asset()->url('images/icons/icon-compare.svg') }}">
                                                <span class="visually-hidden">{{ __('Compare products') }}</span>
                                                <span class="pro-count blue"><span>{{ Cart::instance('compare')->count() }}</span></span>
                                            </a>
                                        </div>
                                    @endif
                                    @if (EcommerceHelper::isWishlistEnabled())
                                        <div class="header-action-icon-2">
                                            <a href="{{ route('public.wishlist') }}" class="wishlist-count">
                                                <img class="svgInject" alt="{{ __('Wishlist') }}" src="{{ Theme::asset()->url('images/icons/icon-heart.svg') }}">
                                                <span class="visually-hidden">{{ __('Wishlist') }}</span>
                                                <span class="pro-count blue">@if (auth('customer')->check())<span>{{ auth('customer')->user()->wishlist()->count() }}</span> @else <span>{{ Cart::instance('wishlist')->count() }}</span>@endif</span>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="header-action-icon-2">
                                        <a class="mini-cart-icon" href="{{ route('public.cart') }}">
                                            <img alt="{{ __('Cart') }}" src="{{ Theme::asset()->url('images/icons/icon-cart.svg') }}">
                                            <span class="visually-hidden">{{ __('Shopping cart') }}</span>
                                            <span class="pro-count blue">{{ Cart::instance('cart')->count() }}</span>
                                        </a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                            {!! Theme::partial('cart-panel') !!}
                                        </div>
                                    </div>
                                    <div class="header-action-icon-2">
                                        <a href="{{ route('customer.login') }}">
                                            <img alt="{{ __('Sign In') }}" src="{{ Theme::asset()->url('images/icons/icon-user.svg') }}">
                                            <span class="visually-hidden">{{ __('Sign in') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="header-bottom header-bottom-bg-color sticky-bar gray-bg sticky-blue-bg">
                <div class="container">
                    <div class="header-wrap header-space-between position-relative main-nav">
                        <div class="logo logo-width-1 d-block d-lg-none">
                            @if ($logo = theme_option('logo_light') ?: theme_option('logo'))
                                <a href="{{ BaseHelper::getHomepageUrl() }}"><img src="{{ RvMedia::getImageUrl($logo) }}" alt="{{ theme_option('site_title') }}"></a>
                            @endif
                        </div>

                        @if (is_plugin_active('ecommerce') && theme_option('enabled_browse_categories_on_header', 'yes') == 'yes')
                            @php
                                $openBrowse = $page && $page->template == 'homepage' && $page->getMetaData('expanding_product_categories_on_the_homepage', true) == 'yes';
                                $cantCloseBrowse = $openBrowse && $headerStyle == 'header-style-2';
                            @endphp
                            <div class="main-categories-wrap d-none d-lg-block">
                            <a class="categories-button-active @if ($openBrowse) open @endif @if ($cantCloseBrowse) cant-close @endif" href="#">
                                <span class="fa fa-list"></span> {{ __('Browse Categories') }} <i class="down far fa-chevron-down"></i> <i class="up far fa-chevron-up"></i>
                            </a>
                            @php
                                $categories = ProductCategoryHelper::getProductCategoriesWithUrl();
                            @endphp
                            <div class="categories-dropdown-wrap categories-dropdown-active-large @if ($openBrowse) default-open open @endif">
                                <ul>
                                    {!! Theme::partial('product-categories-dropdown', ['categories' => $categories, 'more' => false]) !!}
                                    @if (count($categories) > 10)
                                        <li>
                                            <ul class="more_slide_open">
                                                {!! Theme::partial('product-categories-dropdown', ['categories' => $categories, 'more' => true]) !!}
                                            </ul>
                                        </li>
                                    @endif
                                </ul>

                                @if (count($categories) > 10)
                                    <div class="more_categories">{{ __('Show more...') }}</div>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block main-menu-light-white hover-boder hover-boder-white">
                            <nav>
                                {!!
                                    Menu::renderMenuLocation('main-menu', [
                                        'view' => 'main-menu',
                                    ])
                                !!}
                            </nav>
                        </div>

                        @if (theme_option('hotline'))
                            <div class="hotline d-none d-lg-block">
                                <p><i class="fa fa-phone-alt"></i><span>{{ __('Hotline') }}</span> {{ theme_option('hotline') }}</p>
                            </div>
                        @endif

                        @if (is_plugin_active('ecommerce'))
                            <div class="header-action-right d-block d-lg-none">
                                <div class="header-action-2">
                                    @if (EcommerceHelper::isCompareEnabled())
                                        <div class="header-action-icon-2">
                                            <a href="{{ route('public.compare') }}" class="compare-count">
                                                <img class="svgInject" alt="{{ __('Compare') }}" src="{{ Theme::asset()->url('images/icons/icon-compare-white.svg') }}">
                                                <span class="visually-hidden">{{ __('Compare products') }}</span>
                                                <span class="pro-count white"><span>{{ Cart::instance('compare')->count() }}</span></span>
                                            </a>
                                        </div>
                                    @endif
                                    @if (EcommerceHelper::isWishlistEnabled())
                                        <div class="header-action-icon-2">
                                            <a href="{{ route('public.wishlist') }}" class="wishlist-count">
                                                <img alt="wowy" src="{{ Theme::asset()->url('images/icons/icon-heart-white.svg') }}">
                                                <span class="visually-hidden">{{ __('Wishlist') }}</span>
                                                <span class="pro-count white">@if (auth('customer')->check())<span>{{ auth('customer')->user()->wishlist()->count() }}</span> @else <span>{{ Cart::instance('wishlist')->count() }}</span>@endif</span>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="header-action-icon-2">
                                        <a class="mini-cart-icon" href="{{ route('public.cart') }}">
                                            <img alt="cart" src="{{ Theme::asset()->url('images/icons/icon-cart-white.svg') }}">
                                            <span class="visually-hidden">{{ __('Shopping cart') }}</span>
                                            <span class="pro-count white">{{ Cart::instance('cart')->count() }}</span>
                                        </a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                            {!! Theme::partial('cart-panel') !!}
                                        </div>
                                    </div>
                                    <div class="header-action-icon-2">
                                        <a href="{{ route('customer.login') }}">
                                            <img alt="wowy" src="{{ Theme::asset()->url('images/icons/icon-user-white.svg') }}">
                                            <span class="visually-hidden">{{ __('Sign in') }}</span>
                                        </a>
                                    </div>
                                    <div class="header-action-icon-2 d-block d-lg-none">
                                        <div class="burger-icon burger-icon-white">
                                            <span class="burger-icon-top"></span>
                                            <span class="burger-icon-mid"></span>
                                            <span class="burger-icon-bottom"></span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="mobile-header-active mobile-header-wrapper-style">
            <div class="mobile-header-wrapper-inner">
                <div class="mobile-header-top">
                    @if (theme_option('logo'))
                        <div class="mobile-header-logo">
                            <a href="{{ BaseHelper::getHomepageUrl() }}"><img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" width="150" height="45"></a>
                        </div>
                    @endif
                    <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                        <button class="close-style search-close">
                            <i class="icon-top"></i>
                            <i class="icon-bottom"></i>
                        </button>
                    </div>
                </div>
                @if (is_plugin_active('ecommerce'))
                    <div class="mobile-header-content-area">
                    <div class="mobile-search search-style-3 mobile-header-border">
                        <form action="{{ route('public.products') }}" class="form--quick-search" data-ajax-url="{{ route('public.ajax.search-products') }}" method="get">
                            <input type="text" name="q" class="input-search-product" placeholder="{{ __('Search...') }}">
                            <button type="submit" title="search"> <i class="far fa-search"></i> </button>
                            <div class="panel--search-result"></div>
                        </form>
                    </div>
                    <div class="mobile-menu-wrap mobile-header-border">
                        <div class="main-categories-wrap mobile-header-border">
                            <a class="categories-button-active-2" href="#">
                                <span class="far fa-bars"></span> {{ __('Browse Categories') }} <i class="down far fa-chevron-down"></i>
                            </a>
                            <div class="categories-dropdown-wrap categories-dropdown-active-small">
                                <ul>
                                    @php
                                        if (! isset($categories)) {
                                            $categories = ProductCategoryHelper::getProductCategoriesWithUrl();
                                        }

                                        $groupedCategories = $categories->groupBy('parent_id');

                                        $currentCategories = $groupedCategories->get(0);
                                    @endphp

                                    @if($currentCategories)
                                        @foreach ($currentCategories as $category)
                                            @php
                                                $hasChildren = $groupedCategories->has($category->id);
                                            @endphp

                                            <li>
                                                <a href="{{ route('public.single', $category->url) }}">
                                                    @if ($category->icon_image)
                                                        <img src="{{ RvMedia::getImageUrl($category->icon_image) }}" alt="{{ $category->name }}" width="18" height="18">
                                                    @elseif ($icon = $category->icon)
                                                        {!! BaseHelper::renderIcon($icon) !!}
                                                    @endif {{ $category->name }}

                                                    @if ($hasChildren)
                                                        <span class="menu-expand"><i class="down far fa-chevron-down"></i></span>
                                                    @endif
                                                </a>
                                                @if ($hasChildren)
                                                    <ul class="dropdown" style="display: none">
                                                        @php
                                                            $currentCategories = $groupedCategories->get($category->id);
                                                        @endphp
                                                        @if($currentCategories)
                                                            @foreach ($currentCategories as $childCategory)
                                                                <li><a href="{{ route('public.single', $childCategory->url ) }}">{{ $childCategory->name }}</a></li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <nav>
                            {!!
                                Menu::renderMenuLocation('main-menu', [
                                    'options' => ['class' => 'mobile-menu'],
                                    'view'    => 'mobile-menu',
                                ])
                            !!}
                        </nav>
                    </div>
                    <div class="mobile-header-info-wrap mobile-header-border">
                        @if (is_plugin_active('language'))
                            <div class="single-mobile-header-info">
                                <a class="mobile-language-active" href="#">{{ __('Language') }} <span><i class="far fa-angle-down"></i></span></a>
                                <div class="lang-curr-dropdown lang-dropdown-active">
                                    <ul>
                                        @php
                                            $showRelated = setting('language_show_default_item_if_current_version_not_existed', true);
                                        @endphp

                                        @foreach (Language::getSupportedLocales() as $localeCode => $properties)
                                            <li><a rel="alternate" hreflang="{{ $localeCode }}" href="{{ $showRelated ? Language::getLocalizedURL($localeCode) : url($localeCode) }}">{!! language_flag($properties['lang_flag'], $properties['lang_name']) !!} {{ $properties['lang_name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if (count($currencies) > 1)
                            <div class="single-mobile-header-info">
                                <a class="mobile-language-active" href="#">{{ __('Currency') }} <span><i class="far fa-angle-down"></i></span></a>
                                <div class="lang-curr-dropdown lang-dropdown-active">
                                    <ul>
                                        @foreach ($currencies as $currency)
                                            <li><a href="{{ route('public.change-currency', $currency->title) }}" rel="nofollow">{{ $currency->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if (is_plugin_active('ecommerce'))
                            <div class="single-mobile-header-info">
                                @if (auth('customer')->check())
                                    <a href="{{ route('customer.overview') }}">{{ auth('customer')->user()->name }}</a>
                                @else
                                    <a href="{{ route('customer.login') }}">{{ __('Log In / Sign Up') }}</a>
                                @endif
                            </div>
                        @endif

                        @if ($hotline = theme_option('hotline'))
                            <div class="single-mobile-header-info">
                                <a href="tel:{{ $hotline }}">{{ $hotline }}</a>
                            </div>
                        @endif
                    </div>

                    @if (($socialLinks = theme_option('social_links')) && $socialLinks = json_decode($socialLinks, true))
                        <div class="mobile-social-icon">
                            @foreach($socialLinks as $socialLink)
                                @if (count($socialLink) == 4 && isset($socialLink[0]['value']) && isset($socialLink[1]['value']) && isset($socialLink[2]['value']) && isset($socialLink[3]['value']))
                                    @php
                                        $socialUrl = (string) $socialLink[2]['value'];
                                        $socialUrlLower = Str::lower($socialUrl);
                                        if (Str::contains($socialUrl, 'x.com/i/flow/login')) {
                                            $socialUrl = 'https://x.com/RUBYSHOP168';
                                        }
                                        $skipSocialLink = Str::contains($socialUrl, 'x.com/');
                                    @endphp
                                    @if (! $skipSocialLink)
                                    <a href="{{ $socialUrl }}"
                                       title="{{ $socialLink[0]['value'] }}">
                                        @if (Str::contains($socialUrlLower, 'facebook.com'))
                                            <svg width="16" height="16" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path fill="currentColor" d="M13.5 9H16V6h-2.5C11.6 6 10 7.6 10 9.5V12H8v3h2v6h3v-6h2.3l.7-3H13v-2.5c0-.3.2-.5.5-.5z"/>
                                            </svg>
                                        @elseif (Str::contains($socialUrlLower, 'instagram.com'))
                                            <svg width="16" height="16" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path fill="currentColor" d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7zm11.5 1.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                                            </svg>
                                        @elseif (Str::contains($socialUrlLower, 'line.me'))
                                            <svg width="16" height="16" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path fill="currentColor" d="M12 2C6.5 2 2 5.9 2 10.8c0 4.4 3.6 8 8.3 8.6l-.6 2.8c-.1.4.4.8.8.5l3.2-2.4h.3c5.5 0 10-3.9 10-8.8S17.5 2 12 2zm-4 6.2h1.6v5H8V8.2zm4.9 5.1H10.7V8.2h1.6v3.7h1.3v1.4zm3.8-3.7h-1.8v.7h1.8v1.4h-1.8v.7h1.8v1.4h-3.4V8.2h3.4v1.4zm3.3 3.7h-1.4l-1.7-2.3v2.3h-1.6V8.2h1.4l1.7 2.3V8.2H20v5.1z"/>
                                            </svg>
                                        @elseif (Str::contains($socialUrlLower, 'youtube.com'))
                                            <svg width="16" height="16" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path fill="currentColor" d="M23 12s0-3.2-.4-4.7c-.2-.8-.8-1.4-1.6-1.6C19.5 5.3 12 5.3 12 5.3s-7.5 0-9 .4c-.8.2-1.4.8-1.6 1.6C1 8.8 1 12 1 12s0 3.2.4 4.7c.2.8.8 1.4 1.6 1.6 1.5.4 9 .4 9 .4s7.5 0 9-.4c.8-.2 1.4-.8 1.6-1.6.4-1.5.4-4.7.4-4.7zM10 15.5v-7l6 3.5-6 3.5z"/>
                                            </svg>
                                        @else
                                            {!! BaseHelper::renderIcon($socialLink[1]['value']) !!}
                                        @endif
                                        <span class="visually-hidden">{{ $socialLink[0]['value'] }}</span>
                                    </a>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
