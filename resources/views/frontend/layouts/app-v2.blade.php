<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'JeniCare - المنصة الرائدة لتقنيات العناية بالبشرة المتقدمة وحلول الجمال الاحترافية')">
    <meta name="keywords" content="@yield('meta_keywords', 'JeniCare, تجميل, عناية, بشرة, منتجات تجميل, العناية بالبشرة, مكياج')">

    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', ($siteSettings['site_name'] ?? 'JeninCare') . ' | ' . ($siteSettings['site_description'] ?? ''))">
    <meta property="og:description" content="@yield('meta_description', $siteSettings['site_description'] ?? 'المنصة الرائدة لتقنيات العناية بالبشرة المتقدمة وحلول الجمال الاحترافية')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/og-image.webp'))">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', ($siteSettings['site_name'] ?? 'JeninCare') . ' | ' . ($siteSettings['site_description'] ?? ''))">
    <meta name="twitter:description" content="@yield('meta_description', 'المنصة الرائدة لتقنيات العناية بالبشرة المتقدمة وحلول الجمال الاحترافية')">
    <meta name="twitter:image" content="@yield('og_image', asset('assets/images/og-image.webp'))">

    <title>@yield('title', ($siteSettings['site_name'] ?? 'JeninCare'))</title>

    {{-- Favicon --}}
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

    {{-- Google Fonts: Tajawal --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">

    {{-- Phosphor Icons --}}
    <script src="https://unpkg.com/@phosphor-icons/web" defer></script>

    {{-- Tailwind CSS (built locally - 42KB vs 300KB CDN JS) --}}
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">

    {{-- Bootstrap RTL (للتوافق مع باقي المكونات كالـ modal والـ dropdown) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    {{-- FontAwesome (للتوافق مع المكونات القديمة كـ product-card) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    {{-- PWA Manifest --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    
    {{-- PWA Meta Tags --}}
    <meta name="theme-color" content="#d97a8c">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="JeniCare">
    <meta name="application-name" content="JeniCare">
    <meta name="msapplication-TileColor" content="#faf9f8">
    <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">

    {{-- Theme CSS --}}
    @php $activeTheme = $siteSettings['site_theme'] ?? 'rose'; @endphp
    <link rel="stylesheet" href="{{ asset('css/themes/' . $activeTheme . '.css') }}">
    
    {{-- Main CSS (للتوافق مع المكونات القديمة) --}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    @php $tracking = app(\App\Services\AdvertisingTrackingService::class); @endphp

    <style>
        /* V2 overrides not covered by built tailwind.css */

        /* Floating Social Sidebar */
        .floating-social-v2 {
            position: fixed;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .floating-social-v2 a {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            text-decoration: none;
        }
        .floating-social-v2 a:hover {
            transform: scale(1.1) translateX(5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }

        @media (max-width: 768px) {
            .floating-social-v2 {
                left: 10px;
                bottom: 100px;
                top: auto;
                transform: none;
            }
            .floating-social-v2 a {
                width: 38px;
                height: 38px;
                font-size: 1rem;
            }
        }
    </style>

    @stack('styles')

    {{-- Service Worker Registration (skip on localhost due to SSL) --}}
    <script>
        if ('serviceWorker' in navigator && window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1') {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('{{ asset('sw.js') }}')
                    .then((registration) => {
                        console.log('✅ Service Worker registered:', registration);
                        
                        // Check for updates
                        registration.addEventListener('updatefound', () => {
                            const newWorker = registration.installing;
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    // Show update notification
                                    showUpdateNotification();
                                }
                            });
                        });
                    })
                    .catch((error) => {
                        console.error('❌ Service Worker registration failed:', error);
                    });
            });
        }

        // Show update notification
        function showUpdateNotification() {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-brand-500 text-white px-6 py-3 rounded-full shadow-lg z-50 flex items-center gap-3';
            notification.innerHTML = `
                <i class="ph ph-sparkle animate-spin-slow"></i>
                <span>تحديث جديد متاح!</span>
                <button onclick="updateApp()" class="bg-white text-brand-500 px-3 py-1 rounded-full text-sm font-bold hover:bg-brand-100 transition-colors">
                    تحديث
                </button>
            `;
            document.body.appendChild(notification);

            // Auto-hide after 10 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 10000);
        }

        // Update app
        function updateApp() {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.controller.postMessage({ type: 'SKIP_WAITING' });
                window.location.reload();
            }
        }

        // PWA Install Prompt
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Show install button after 3 seconds
            setTimeout(() => {
                showInstallButton();
            }, 3000);
        });

        function showInstallButton() {
            const installBtn = document.createElement('button');
            installBtn.className = 'fixed bottom-24 right-6 bg-brand-500 text-white w-14 h-14 rounded-full shadow-lg hover:bg-brand-600 transition-all z-40 flex items-center justify-center group';
            installBtn.innerHTML = `
                <i class="ph ph-download-simple text-xl group-hover:animate-bounce"></i>
            `;
            installBtn.onclick = installApp;
            document.body.appendChild(installBtn);
        }

        function installApp() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('✅ App installed');
                    }
                    deferredPrompt = null;
                });
            }
        }

        // Hide install button after successful installation
        window.addEventListener('appinstalled', () => {
            console.log('✅ Jenin Care PWA installed successfully');
            const installBtn = document.querySelector('[onclick="installApp()"]');
            if (installBtn) {
                installBtn.remove();
            }
        });
    </script>

    {{-- Meta Pixel Code --}}
    @if(!empty($siteSettings['facebook_pixel_id']) && ($siteSettings['facebook_pixel_enabled'] ?? '1') == '1')
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $siteSettings['facebook_pixel_id'] }}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{ $siteSettings['facebook_pixel_id'] }}&ev=PageView&noscript=1"
    /></noscript>
    @endif
    {{-- End Meta Pixel Code --}}
</head>
<body class="antialiased">
    @if($tracking->isEnabled()) {!! $tracking->getBrowserPixelNoscript() !!} @endif

    @include('frontend.layouts.header-v2')

    <div class="header-spacer"></div>

    <main class="main-content-v2">
        @yield('content')
    </main>

    @include('frontend.layouts.footer-v2')

    {{-- Bootstrap JS (للـ modal والـ dropdown) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    {{-- Performance Optimizations (production only) --}}
    {{-- <script src="{{ asset('js/performance-optimizations.js') }}" defer></script> --}}
    
    <script src="{{ asset('js/app.js') }}"></script>

    @if($tracking->isEnabled()) {!! $tracking->getBrowserPixelScript() !!} @endif

    @stack('scripts')

    {{-- Quick View Modal --}}
    <div class="modal fade" id="quickViewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius:16px;border:none;overflow:hidden;">
                <div class="modal-header" style="border:none;padding:16px 20px;">
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="quickViewBody" style="padding:0 20px 24px;">
                    <div class="text-center py-4"><div class="spinner-border text-pink"></div></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Autocomplete Dropdown --}}
    <div id="searchDropdown" style="display:none;position:absolute;top:100%;right:0;left:0;background:#fff;border-radius:12px;box-shadow:0 12px 40px rgba(0,0,0,.15);z-index:9999;max-height:420px;overflow-y:auto;margin-top:4px;"></div>

    <script>
    // ============ SEARCH AUTOCOMPLETE ============
    let searchTimer;
    const searchInputs = document.querySelectorAll('#searchOverlayV2 input[name="search"], #mobileMenuV2 input[name="search"]');
    const searchDropdown = document.getElementById('searchDropdown');

    if (searchInputs.length && searchDropdown) {
        searchInputs.forEach(function(searchInput) {
            searchInput.setAttribute('autocomplete', 'off');
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimer);
                const q = this.value.trim();
                if (q.length < 2) { searchDropdown.style.display = 'none'; return; }
                searchTimer = setTimeout(() => {
                    const basePath = window.basePath || '';
                    fetch(basePath + '/api/search?q=' + encodeURIComponent(q))
                        .then(r => r.json())
                        .then(data => {
                            if (!data.length) { searchDropdown.style.display = 'none'; return; }
                            searchDropdown.innerHTML = data.map(p => `
                                <a href="${p.url}" style="display:flex;align-items:center;gap:12px;padding:10px 14px;text-decoration:none;color:#1c1917;transition:background .15s;border-bottom:1px solid #f5f5f5;"
                                   onmouseover="this.style.background='#fdf8f9'" onmouseout="this.style.background=''">
                                    ${p.image ? `<img src="${p.image}" style="width:44px;height:44px;border-radius:10px;object-fit:cover;">` : '<div style="width:44px;height:44px;border-radius:10px;background:#f5f5f5;"></div>'}
                                    <div style="flex:1;min-width:0;">
                                        <div style="font-weight:600;font-size:.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${p.name}</div>
                                        <div style="font-size:.8rem;color:#d97a8c;font-weight:700;">${p.price}</div>
                                    </div>
                                </a>
                            `).join('');
                            searchDropdown.style.display = 'block';
                            const rect = this.getBoundingClientRect();
                            searchDropdown.style.top = (rect.bottom + window.scrollY) + 'px';
                            searchDropdown.style.left = rect.left + 'px';
                            searchDropdown.style.right = 'auto';
                            searchDropdown.style.width = rect.width + 'px';
                        });
                }, 300);
            });
        });
        document.addEventListener('click', e => {
            let insideAnyInput = false;
            searchInputs.forEach(inp => { if (inp.contains(e.target)) insideAnyInput = true; });
            if (!insideAnyInput && !searchDropdown.contains(e.target)) searchDropdown.style.display = 'none';
        });
    }

    // ============ QUICK VIEW ============
    async function quickView(productId) {
        const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
        const body = document.getElementById('quickViewBody');
        body.innerHTML = '<div class="text-center py-4"><div class="spinner-border" style="color:#d97a8c;"></div></div>';
        modal.show();
        const basePath = window.basePath || '';
        try {
            const r = await fetch(basePath + '/api/product/' + productId + '/quickview');
            const p = await r.json();
            body.innerHTML = `
                <div class="row g-4">
                    <div class="col-md-5">
                        ${p.image ? `<img src="${p.image}" style="width:100%;aspect-ratio:1/1;object-fit:cover;border-radius:12px;">` : '<div style="width:100%;aspect-ratio:1/1;background:#f5f5f5;border-radius:12px;display:flex;align-items:center;justify-content:center;"><i class="ph ph-package" style="font-size:3rem;color:#d4d4d4;"></i></div>'}
                    </div>
                    <div class="col-md-7">
                        ${p.category ? `<div style="font-size:.75rem;color:#d97a8c;font-weight:600;margin-bottom:4px;">${p.category}</div>` : ''}
                        <h4 style="font-weight:800;margin-bottom:8px;">${p.name}</h4>
                        <div style="font-size:1.3rem;font-weight:800;color:#d97a8c;margin-bottom:8px;">${p.price} ₪</div>
                        <div style="background:${p.stock.includes('نفذ')?'#FEE2E2':p.stock.includes('تبقى')?'#FEF3C7':'#DCFCE7'};color:${p.stock.includes('نفذ')?'#DC2626':p.stock.includes('تبقى')?'#D97706':'#16A34A'};padding:4px 12px;border-radius:50px;display:inline-block;font-size:.8rem;font-weight:600;margin-bottom:12px;">${p.stock}</div>
                        ${p.description ? `<p style="color:#737373;font-size:.9rem;line-height:1.7;margin-bottom:16px;">${p.description}</p>` : ''}
                        <div class="d-flex gap-2 flex-wrap">
                            <button onclick="addToCart(${p.id})" class="btn" style="background:#1c1917;color:#fff;border-radius:12px;font-weight:700;"><i class="ph ph-shopping-cart-simple"></i> أضف للسلة</button>
                            <a href="https://wa.me/{{ $siteSettings['whatsapp_number'] ?? '970591234567' }}?text=${encodeURIComponent('السلام عليكم، مهتمة بـ: ' + p.name + ' - ' + p.price)}" target="_blank" class="btn" style="border:2px solid #10B981;color:#10B981;border-radius:12px;font-weight:700;"><i class="ph ph-whatsapp-logo"></i> واتساب</a>
                            <a href="${p.url}" class="btn" style="border:2px solid #e5e5e5;border-radius:12px;font-weight:700;">تفاصيل المنتج</a>
                        </div>
                    </div>
                </div>
            `;
        } catch(e) { body.innerHTML = '<div class="text-center py-4 text-danger">تعذر تحميل المنتج</div>'; }
    }

    // ============ WISHLIST TOGGLE ============
    async function toggleWishlist(productId, btn) {
        const basePath = window.basePath || '';
        try {
            const r = await fetch(basePath + '/wishlist/toggle', {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},
                body: JSON.stringify({product_id: productId})
            });
            const d = await r.json();
            if (d.success) {
                const icon = btn.querySelector('i');
                if (d.action === 'added') {
                    icon.className = 'fas fa-heart';
                    btn.style.color = '#EF4444';
                } else {
                    icon.className = 'far fa-heart';
                    btn.style.color = '#a3a3a3';
                }
                showNotification('success', d.message);
            } else if (r.status === 401) {
                window.location = '/login';
            }
        } catch(e) {}
    }

    // ============ RECENTLY VIEWED ============
    (function() {
        const productLink = document.querySelector('a[href*="/product/"]');
        if (!productLink) return;
        const slug = productLink.getAttribute('href').split('/product/')[1];
        if (!slug) return;
        let viewed = JSON.parse(localStorage.getItem('recentlyViewed') || '[]');
        viewed = viewed.filter(p => p.slug !== slug);
        const name = document.querySelector('h1')?.textContent?.trim() || document.title;
        const imgEl = document.querySelector('.product-detail img[src], .product-gallery img[src], img.object-cover, img[alt][src*="files"], img[alt][src*="product"]');
        const img = imgEl?.src || '';
        const priceEl = document.querySelector('[style*="pink-600"], .price-value, .product-price, [class*="price"]');
        const price = priceEl?.textContent?.trim() || '';
        viewed.unshift({slug, name, img, price});
        if (viewed.length > 8) viewed = viewed.slice(0, 8);
        localStorage.setItem('recentlyViewed', JSON.stringify(viewed));
    })();
    </script>

    {{-- Floating Social Media Sidebar --}}
    <div class="floating-social-v2">
        @if(!empty($siteSettings['facebook_url']))
            <a href="{{ $siteSettings['facebook_url'] }}" style="background:#1877F2;" target="_blank" title="فيسبوك"><i class="ph-fill ph-facebook-logo"></i></a>
        @endif
        @if(!empty($siteSettings['instagram_url']))
            <a href="{{ $siteSettings['instagram_url'] }}" style="background:linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);" target="_blank" title="إنستغرام"><i class="ph-fill ph-instagram-logo"></i></a>
        @endif
        @if(!empty($siteSettings['twitter_url']))
            <a href="{{ $siteSettings['twitter_url'] }}" style="background:#1DA1F2;" target="_blank" title="تويتر"><i class="ph-fill ph-twitter-logo"></i></a>
        @endif
        @if(!empty($siteSettings['tiktok_url']))
            <a href="{{ $siteSettings['tiktok_url'] }}" style="background:#000;" target="_blank" title="تيك توك"><i class="ph-fill ph-tiktok-logo"></i></a>
        @endif
        @if(!empty($siteSettings['whatsapp_number']))
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" style="background:#25D366;" target="_blank" title="واتساب"><i class="ph-fill ph-whatsapp-logo"></i></a>
        @endif
    </div>

    {{-- Floating WhatsApp Button --}}
    @if(!empty($siteSettings['whatsapp_number']))
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" class="floating-whatsapp-v2" target="_blank" title="تواصل عبر واتساب">
        <i class="ph-fill ph-whatsapp-logo"></i>
    </a>
    @endif

    {{-- Scroll to Top Button --}}
    <button class="scroll-to-top-v2" id="scrollToTopV2" title="العودة للأعلى" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <i class="ph ph-caret-up"></i>
    </button>

    <script>
        @if(session('success'))
        showNotification('success', '{{ session('success') }}');
        @endif
        @if(session('error'))
        showNotification('error', '{{ session('error') }}');
        @endif
        @if(session('warning'))
        showNotification('warning', '{{ session('warning') }}');
        @endif

        const scrollBtnV2 = document.getElementById('scrollToTopV2');
        if (scrollBtnV2) {
            window.addEventListener('scroll', function() {
                scrollBtnV2.style.opacity = window.scrollY > 400 ? '1' : '0';
                scrollBtnV2.style.pointerEvents = window.scrollY > 400 ? 'auto' : 'none';
            });
        }
    </script>

    <style>
    .floating-whatsapp-v2 {
        position:fixed;bottom:24px;right:24px;z-index:9998;
        width:56px;height:56px;border-radius:50%;
        background:#25D366;color:#fff;
        display:flex;align-items:center;justify-content:center;
        font-size:1.6rem;text-decoration:none;
        box-shadow:0 4px 20px rgba(37,211,102,.4);
        transition:all .3s;animation:whatsappPulseV2 2s infinite;
    }
    .floating-whatsapp-v2:hover {transform:scale(1.1);box-shadow:0 6px 28px rgba(37,211,102,.5);color:#fff;}
    @keyframes whatsappPulseV2 {
        0%,100%{box-shadow:0 4px 20px rgba(37,211,102,.4)}
        50%{box-shadow:0 4px 30px rgba(37,211,102,.7)}
    }
    .scroll-to-top-v2 {
        position:fixed;bottom:92px;right:24px;z-index:9998;
        width:44px;height:44px;border-radius:50%;
        background:#fff;color:#525252;border:1px solid #e5e5e5;
        display:flex;align-items:center;justify-content:center;
        font-size:1.1rem;cursor:pointer;
        box-shadow:0 2px 12px rgba(0,0,0,.1);
        transition:all .3s;opacity:0;pointer-events:none;
    }
    .scroll-to-top-v2:hover {background:#1c1917;color:#fff;border-color:#1c1917;}
    @media (max-width:768px) {
        .floating-whatsapp-v2 {bottom:16px;right:16px;width:50px;height:50px;font-size:1.4rem;}
        .scroll-to-top-v2 {bottom:76px;right:16px;width:40px;height:40px;}
    }
    </style>
</body>
</html>
