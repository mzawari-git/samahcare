<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', ($siteSettings['site_description'] ?? 'سماح كير - المنصة الرائدة لتقنيات العناية بالبشرة المتقدمة وحلول الجمال الاحترافية'))">
    <meta name="keywords" content="@yield('meta_keywords', 'سماح كير, تجميل, عناية, بشرة, خدمات تجميل, حجز موعد')">

    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', ($siteSettings['site_name'] ?? 'سماح كير') . ' | منصة الحجز والخدمات الجمالية')">
    <meta property="og:description" content="@yield('meta_description', $siteSettings['site_description'] ?? '')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/og-image.webp'))">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', ($siteSettings['site_name'] ?? 'سماح كير'))">
    <meta name="twitter:description" content="@yield('meta_description', '')">
    <meta name="twitter:image" content="@yield('og_image', asset('assets/images/og-image.webp'))">

    <title>@yield('title', ($siteSettings['site_name'] ?? 'سماح كير'))</title>

    @if(!empty($siteSettings['site_favicon_url']))
        <link rel="icon" type="image/png" sizes="32x32" href="{{ $siteSettings['site_favicon_url'] }}">
        <link rel="apple-touch-icon" href="{{ $siteSettings['site_favicon_url'] }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Arabic:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <script src="https://unpkg.com/@phosphor-icons/web" defer></script>
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}?v=6">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/themes/clean.css') }}?v=6">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">

    @stack('styles')

    @php $tracking = app(\App\Services\AdvertisingTrackingService::class); @endphp

    <script>window.basePath="{{ rtrim(url('/'), '/') }}";</script>

    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=2073558763203111&ev=PageView&noscript=1"/></noscript>
</head>
<body class="antialiased" style="background-color: var(--surface); color: var(--ink);">

    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:right-2 focus:z-[100] focus:px-4 focus:py-2 focus:rounded-lg focus:text-sm focus:font-bold" style="background:var(--ink);color:var(--surface);">الانتقال إلى المحتوى</a>

    @if($tracking->isEnabled()) {!! $tracking->getBrowserPixelNoscript() !!} @endif

    @include('frontend.layouts.clean-minimal.header')

    <main id="main-content" style="min-height:60vh;">
        @yield('content')
    </main>

    @include('frontend.layouts.clean-minimal.footer')

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}?v=6"></script>

    @stack('scripts')

    @if($tracking->isEnabled()) {!! $tracking->getBrowserPixelScript() !!} @endif
</body>
</html>
