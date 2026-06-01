<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') - {{ $siteSettings['site_name'] ?? config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --pink-50: #FDF2F8; --pink-100: #FCE7F3; --pink-200: #FBCFE8;
            --pink-500: #EC4899; --pink-600: #DB2777; --pink-700: #BE185D;
            --gray-50: #F8FAFC; --gray-100: #F1F5F9; --gray-200: #E2E8F0;
            --gray-300: #CBD5E1; --gray-400: #94A3B8; --gray-500: #64748B;
            --gray-600: #475569; --gray-700: #334155; --gray-800: #1E293B; --gray-900: #0F172A;
            --sidebar-width: 270px;
            --header-height: 60px;
        }
        * { font-family: 'Tajawal', sans-serif; }
        body { background: #F0F2F5; min-height: 100vh; }

        /* Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1E293B 0%, #0F172A 100%);
            position: fixed; top: 0; right: 0; bottom: 0; z-index: 1040;
            overflow-y: auto; overflow-x: hidden;
            transition: transform .3s cubic-bezier(0.4, 0, 0.2, 1), width .3s ease;
            display: flex; flex-direction: column;
            will-change: transform;
        }
        .admin-sidebar::-webkit-scrollbar { width: 4px; }
        .admin-sidebar::-webkit-scrollbar-thumb { background: rgba(236,72,153,0.4); border-radius: 4px; }
        .admin-sidebar .brand {
            padding: 1.2rem 1.5rem; font-size: 1.15rem; font-weight: 800;
            border-bottom: 1px solid rgba(255,255,255,0.08); color: #fff;
            display: flex; align-items: center; gap: .75rem; flex-shrink: 0;
        }
        .admin-sidebar .brand .brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #EC4899, #BE185D);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .admin-sidebar .nav-section { padding: .25rem 0; }
        .admin-sidebar .nav-section .section-title {
            padding: .85rem 1.5rem .4rem;
            font-size: .65rem; font-weight: 700;
            color: rgba(255,255,255,0.25);
            text-transform: uppercase;
            letter-spacing: .08em;
            display: flex; align-items: center; justify-content: space-between;
            cursor: pointer; user-select: none;
        }
        .admin-sidebar .nav-section .section-title:hover { color: rgba(255,255,255,0.45); }
        .admin-sidebar .nav-section .section-title .collapse-icon {
            font-size: .55rem; transition: transform .25s ease;
            color: rgba(255,255,255,0.15);
        }
        .admin-sidebar .nav-section .section-title .collapse-icon.collapsed {
            transform: rotate(-90deg);
        }
        .admin-sidebar .nav-section .nav-items { overflow: hidden; transition: max-height .3s ease; }
        .admin-sidebar .nav-item {
            display: flex; align-items: center; gap: 14px;
            padding: .7rem 1.5rem; color: rgba(255,255,255,0.75);
            font-size: .9rem; font-weight: 500; transition: all .2s ease;
            text-decoration: none; border-right: 3px solid transparent;
            margin: 1px 0; border-radius: 0 8px 8px 0;
        }
        .admin-sidebar .nav-item:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .admin-sidebar .nav-item.active {
            background: rgba(236,72,153,0.08); color: #f9a8d4;
            border-right-color: #EC4899;
        }
        .admin-sidebar .nav-item i { 
            width: 22px; height: 22px; 
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .95rem; flex-shrink: 0;
        }
        .admin-sidebar .nav-item span { line-height: 1.3; }
        .admin-sidebar .nav-sub-label {
            font-size: .7rem;
            font-weight: 700;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: .6rem 1.5rem .25rem;
            margin-top: .25rem;
        }
        .admin-sidebar .sidebar-footer {
            border-top: 1px solid rgba(255,255,255,0.06);
            padding: .75rem 1.5rem; margin-top: auto; flex-shrink: 0;
        }

        /* Main */
        .admin-main {
            flex: 1; min-height: 100vh;
            display: flex; flex-direction: column;
            transition: margin-right .3s ease;
        }

        /* Header */
        .admin-header {
            background: #fff; position: sticky; top: 0; z-index: 1035;
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
        }
        .admin-header .header-inner {
            display: flex; align-items: center;
            padding: .65rem 1.5rem; gap: 1rem;
        }
        .admin-header .page-title {
            font-size: 1rem; font-weight: 700; color: var(--gray-800); margin: 0;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .admin-header .page-title .breadcrumb-sep {
            color: var(--gray-300); margin: 0 .5rem; font-weight: 400;
        }
        .admin-header .header-actions {
            display: flex; align-items: center; gap: .5rem; margin-right: auto;
        }
        .admin-header .header-actions .action-btn {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--gray-500); background: var(--gray-50);
            border: none; transition: all .2s; text-decoration: none;
            position: relative;
        }
        .admin-header .header-actions .action-btn:hover {
            background: var(--pink-50); color: var(--pink-600);
        }
        .admin-header .header-actions .action-btn .badge-dot {
            position: absolute; top: 4px; left: 4px;
            width: 8px; height: 8px; border-radius: 50%;
            background: #ef4444; border: 2px solid #fff;
        }
        .admin-header .header-actions .user-btn {
            display: flex; align-items: center; gap: .5rem;
            padding: .35rem .75rem .35rem .35rem;
            border-radius: 10px; border: 1px solid var(--gray-200);
            background: #fff; cursor: pointer; transition: all .2s;
            text-decoration: none; color: inherit;
        }
        .admin-header .header-actions .user-btn:hover {
            border-color: var(--pink-300); background: var(--pink-50);
        }
        .admin-header .header-actions .user-btn .avatar {
            width: 30px; height: 30px; border-radius: 8px;
            background: linear-gradient(135deg, var(--pink-500), var(--pink-600));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .75rem;
        }

        /* Notification Dropdown */
        .notif-dropdown {
            width: 360px; max-height: 420px; border: none;
            border-radius: 14px; box-shadow: 0 10px 40px rgba(0,0,0,.12);
            padding: 0; overflow: hidden;
        }
        .notif-dropdown .notif-header {
            padding: 1rem 1.25rem; border-bottom: 1px solid var(--gray-100);
            display: flex; justify-content: space-between; align-items: center;
        }
        .notif-dropdown .notif-header h6 { margin: 0; font-weight: 700; font-size: .9rem; }
        .notif-dropdown .notif-header a { font-size: .75rem; }
        .notif-dropdown .notif-body { overflow-y: auto; max-height: 340px; }
        .notif-dropdown .notif-item {
            padding: .85rem 1.25rem; display: flex; gap: .75rem;
            border-bottom: 1px solid var(--gray-50);
            transition: background .15s; text-decoration: none; color: inherit;
        }
        .notif-dropdown .notif-item:hover { background: var(--pink-50); }
        .notif-dropdown .notif-item .notif-icon {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: .85rem;
        }
        .notif-dropdown .notif-item .notif-content { flex: 1; min-width: 0; }
        .notif-dropdown .notif-item .notif-title {
            font-size: .8rem; font-weight: 600; color: var(--gray-800);
            margin-bottom: 2px;
        }
        .notif-dropdown .notif-item .notif-body-text {
            font-size: .75rem; color: var(--gray-500);
            overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }
        .notif-dropdown .notif-item .notif-time {
            font-size: .65rem; color: var(--gray-400); white-space: nowrap;
        }

        /* Content */
        .admin-content { flex: 1; padding: 1.5rem; }

        /* Cards */
        .card {
            border: none; border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 1px 2px rgba(0,0,0,.02);
            transition: box-shadow .2s;
        }
        .card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.06); }
        .card-header {
            background: #fff; border-bottom: 1px solid var(--gray-100);
            font-weight: 700; padding: 1rem 1.25rem;
            border-radius: 1rem 1rem 0 0 !important;
        }

        /* Stat Card */
        .stat-card-new {
            background: #fff; border-radius: 16px; padding: 20px;
            border: 1px solid #e2e8f0; transition: all .3s;
        }
        .stat-card-new:hover {
            box-shadow: 0 10px 40px rgba(0,0,0,.08); transform: translateY(-2px);
        }
        .stat-icon-new {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.25rem;
        }
        .stat-value-new { font-size: 1.75rem; font-weight: 800; color: var(--gray-800); margin-top: 12px; }
        .stat-label-new { font-size: .875rem; color: var(--gray-500); font-weight: 500; }
        .progress-thin { height: 6px; border-radius: 3px; background: #e2e8f0; overflow: hidden; }
        .progress-thin .progress-bar { border-radius: 3px; transition: width 1s ease; }

        /* Table */
        .table th {
            font-weight: 600; color: var(--gray-500); font-size: .8125rem;
            border-top: none; padding: .75rem .75rem;
        }
        .table td { vertical-align: middle; padding: .75rem; }
        .table-hover tbody tr:hover { background: var(--pink-50); }

        /* Buttons */
        .btn-pink {
            background: linear-gradient(135deg, var(--pink-600), var(--pink-500));
            color: #fff; border: none;
        }
        .btn-pink:hover {
            background: linear-gradient(135deg, var(--pink-700), var(--pink-600));
            color: #fff; transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(219,39,119,0.25);
        }
        .btn-outline-pink {
            color: var(--pink-600); border-color: var(--pink-600);
        }
        .btn-outline-pink:hover { background: var(--pink-600); color: #fff; }

        /* Form */
        .form-control:focus, .form-select:focus {
            border-color: var(--pink-400);
            box-shadow: 0 0 0 3px rgba(219,39,119,0.12);
        }

        /* Pagination */
        .pagination { margin-bottom: 0; }
        .page-link { color: var(--gray-600); border-radius: 8px !important; margin: 0 2px; }
        .page-item.active .page-link { background: var(--pink-600); border-color: var(--pink-600); }

        /* Footer */
        .admin-footer {
            text-align: center; padding: 1rem 1.5rem;
            font-size: .75rem; color: var(--gray-400);
            border-top: 1px solid var(--gray-100);
            margin-top: auto;
        }

        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0; z-index: 1039;
            background: rgba(0,0,0,.4);
        }
        .sidebar-overlay.show { display: block; }

        /* Toast */
        .toast-container { position: fixed; bottom: 1.5rem; left: 1.5rem; z-index: 9999; }

        .sidebar-collapse-btn {
            width: 32px; height: 32px; border-radius: 8px;
            background: rgba(255,255,255,0.08); border: none;
            color: rgba(255,255,255,0.4); cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all .2s; flex-shrink: 0;
        }
        .sidebar-collapse-btn:hover { background: rgba(255,255,255,0.15); color: #fff; }
        .sidebar-collapse-btn i { transition: transform .3s; font-size: .7rem; }

        /* Responsive */
        @media (max-width: 991px) {
            .admin-sidebar { transform: translateX(100%); }
            .admin-sidebar.open { transform: translateX(0); box-shadow: -8px 0 30px rgba(0,0,0,0.3); }
            .admin-main { width: 100%; }
            .admin-content { padding: 1rem; }
            .notif-dropdown { width: 300px; left: .5rem !important; right: auto !important; }
            .sidebar-toggle-btn {
                width: 40px; height: 40px;
                border-radius: 12px; border: 1px solid var(--gray-200);
                background: #fff; display: flex; align-items: center; justify-content: center;
                cursor: pointer; transition: all .2s; color: var(--gray-600);
            }
            .sidebar-toggle-btn:hover { background: var(--pink-50); color: var(--pink-600); border-color: var(--pink-200); }
            .sidebar-toggle-btn .icon-bar {
                display: block; width: 20px; height: 2px; background: currentColor;
                border-radius: 2px; transition: all .3s; position: relative;
            }
            .sidebar-toggle-btn .icon-bar::before,
            .sidebar-toggle-btn .icon-bar::after {
                content: ''; position: absolute; width: 20px; height: 2px;
                background: currentColor; border-radius: 2px; transition: all .3s;
            }
            .sidebar-toggle-btn .icon-bar::before { top: -6px; }
            .sidebar-toggle-btn .icon-bar::after { top: 6px; }
            .sidebar-toggle-btn.open .icon-bar { background: transparent; }
            .sidebar-toggle-btn.open .icon-bar::before { top: 0; transform: rotate(45deg); }
            .sidebar-toggle-btn.open .icon-bar::after { top: 0; transform: rotate(-45deg); }
        }
        @media (min-width: 992px) {
            .admin-main { margin-right: var(--sidebar-width); transition: margin-right .3s ease; }
            .admin-sidebar.collapsed { width: 70px; overflow: hidden; }
            .admin-sidebar.collapsed ~ .admin-main { margin-right: 70px; }
            .admin-sidebar.collapsed .brand { padding: 1rem .5rem; justify-content: center; }
            .admin-sidebar.collapsed .brand-text { display: none !important; }
            .admin-sidebar.collapsed .brand .brand-icon { flex-shrink: 0; }
            .admin-sidebar.collapsed .section-title { display: none !important; }
            .admin-sidebar.collapsed .nav-item { justify-content: center; padding: .75rem 0; }
            .admin-sidebar.collapsed .nav-item span { display: none !important; }
            .admin-sidebar.collapsed .nav-item i { font-size: 1.2rem; }
            .admin-sidebar.collapsed .sidebar-footer { padding: .5rem 0; }
            .admin-sidebar.collapsed .sidebar-footer .nav-item { justify-content: center; padding: .5rem; }
            .admin-sidebar.collapsed .sidebar-footer .nav-item span { display: none !important; }
            .admin-sidebar.collapsed .sidebar-collapse-btn { position: absolute; top: .5rem; left: 50%; transform: translateX(-50%); }
            .admin-sidebar.collapsed .sidebar-collapse-btn i { transform: rotate(180deg); }

        html, body { height: 100%; overflow-x: hidden; }
        .admin-wrapper { width: 100%; min-height: 100vh; display: flex; }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fadeInUp .3s ease; }

        @stack('extra-styles')
    </style>
    @stack('styles')
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '2073558763203111');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=2073558763203111&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
</head>
<body>
    <div class="admin-wrapper">
        {{-- Sidebar Overlay (mobile) --}}
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        {{-- Sidebar --}}
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="brand">
                <div class="brand-icon">
                    @if(!empty($siteSettings['site_logo_url']))
                        <img src="{{ $siteSettings['site_logo_url'] }}" alt="logo" style="width:100%;height:100%;object-fit:contain;border-radius:10px;">
                    @else
                        <i class="fas fa-spa"></i>
                    @endif
                </div>
                <div class="brand-text">
                    <div style="font-size:.95rem;font-weight:800;line-height:1.2;color:#fff;">{{ $siteSettings['site_name_ar'] ?? $siteSettings['site_name'] ?? 'JeninCare' }}</div>
                    <div style="font-size:.65rem;color:rgba(255,255,255,0.4);font-weight:400;">لوحة التحكم</div>
                </div>
                <button class="sidebar-collapse-btn d-none d-lg-flex" onclick="toggleDesktopSidebar()" title="طي القائمة">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <nav class="nav-section">
                <div class="section-title" onclick="toggleSection(this)">
                    الرئيسية <i class="fas fa-chevron-down collapse-icon"></i>
                </div>
                <div class="nav-items">
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i> <span>لوحة التحكم</span>
                    </a>
                    <a href="{{ route('admin.analytics.index') }}" class="nav-item {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> <span>تحليلات متقدمة</span>
                    </a>
                </div>
            </nav>

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- ═══ META / FACEBOOK HUB — كل أدوات فيسبوك في مكان واحد ═══ --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            <nav class="nav-section">
                <div class="section-title" onclick="toggleSection(this)">
                    <i class="fab fa-facebook" style="color:#1877F2;margin-left:4px;"></i>
                    منصة Meta <i class="fas fa-chevron-down collapse-icon"></i>
                </div>
                <div class="nav-items">
                    {{-- ── Meta Hub - الصفحة الرئيسية ── --}}
                    <a href="{{ route('admin.meta-hub.index') }}" class="nav-item {{ request()->routeIs('admin.meta-hub.*') ? 'active' : '' }}" style="background:rgba(24,119,242,0.1);border-right-color:#1877F2;">
                        <i class="fab fa-facebook" style="color:#1877F2;"></i> <span><b>منصة Meta المتكاملة</b></span>
                    </a>

                    {{-- ── لوحة التحكم الرئيسية ── --}}
                    <div class="nav-sub-label">لوحة التحكم</div>
                    <a href="{{ route('admin.meta-marketing.index') }}" class="nav-item {{ request()->routeIs('admin.meta-marketing.*') && !request()->routeIs('admin.diagnostics.*') ? 'active' : '' }}">
                        <i class="fas fa-rocket"></i> <span>التسويق عبر ميتا</span>
                    </a>
                    <a href="{{ route('admin.roas.index') }}" class="nav-item {{ request()->routeIs('admin.roas.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i> <span>True ROAS</span>
                    </a>

                    {{-- ── إدارة الإعلانات ── --}}
                    <div class="nav-sub-label">إدارة الإعلانات</div>
                    <a href="{{ route('admin.ads.dashboard') }}" class="nav-item {{ request()->routeIs('admin.ads.*') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn"></i> <span>إنشاء وإدارة الإعلانات</span>
                    </a>
                    <a href="{{ route('admin.ai-creative.index') }}" class="nav-item {{ request()->routeIs('admin.ai-creative.*') ? 'active' : '' }}">
                        <i class="fas fa-magic"></i> <span>AI Creative</span>
                    </a>
                    <a href="{{ route('admin.ab-tests.index') }}" class="nav-item {{ request()->routeIs('admin.ab-tests.*') ? 'active' : '' }}">
                        <i class="fas fa-flask"></i> <span>A/B Testing</span>
                    </a>

                    {{-- ── العملاء المحتملين ── --}}
                    <div class="nav-sub-label">العملاء المحتملين</div>
                    <a href="{{ route('admin.leads-hub.index') }}" class="nav-item {{ request()->routeIs('admin.leads-hub.*') ? 'active' : '' }}">
                        <i class="fas fa-user-friends"></i> <span>مركز العملاء المحتملين</span>
                    </a>

                    {{-- ── التواصل ── --}}
                    <div class="nav-sub-label">التواصل</div>
                    <a href="{{ route('admin.meta-tools.conversations') }}" class="nav-item {{ request()->routeIs('admin.meta-tools.conversations*') ? 'active' : '' }}">
                        <i class="fab fa-facebook-messenger"></i> <span>Messenger المحادثات</span>
                    </a>
                    <a href="{{ route('admin.meta-tools.whatsapp') }}" class="nav-item {{ request()->routeIs('admin.meta-tools.whatsapp*') ? 'active' : '' }}">
                        <i class="fab fa-whatsapp"></i> <span>WhatsApp</span>
                    </a>
                    <a href="{{ route('admin.meta-tools.instagram') }}" class="nav-item {{ request()->routeIs('admin.meta-tools.instagram*') ? 'active' : '' }}">
                        <i class="fab fa-instagram"></i> <span>Instagram</span>
                    </a>

                    {{-- ── الجماهير ── --}}
                    <div class="nav-sub-label">الجماهير والاستهداف</div>
                    <a href="{{ route('admin.audiences.index') }}" class="nav-item {{ request()->routeIs('admin.audiences.*') ? 'active' : '' }}">
                        <i class="fas fa-bullseye"></i> <span>بناء الجماهير</span>
                    </a>
                    <a href="{{ route('admin.meta-tools.audience-upload') }}" class="nav-item {{ request()->routeIs('admin.meta-tools.audience-upload*') ? 'active' : '' }}">
                        <i class="fas fa-upload"></i> <span>رفع بيانات الجمهور</span>
                    </a>

                    {{-- ── أدوات متقدمة ── --}}
                    <div class="nav-sub-label">أدوات متقدمة</div>
                    <a href="{{ route('admin.meta-advanced.dashboard') }}" class="nav-item {{ request()->routeIs('admin.meta-advanced.*') ? 'active' : '' }}">
                        <i class="fas fa-cogs"></i> <span>الأدوات المتقدمة</span>
                    </a>
                    <a href="{{ route('admin.meta-advanced.analytics') }}" class="nav-item {{ request()->routeIs('admin.meta-advanced.analytics') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> <span>التحليلات المتقدمة</span>
                    </a>
                    <a href="{{ route('admin.meta-advanced.automation') }}" class="nav-item {{ request()->routeIs('admin.meta-advanced.automation') ? 'active' : '' }}">
                        <i class="fas fa-robot"></i> <span>الأتمتة</span>
                    </a>
                    <a href="{{ route('admin.meta-advanced.creative') }}" class="nav-item {{ request()->routeIs('admin.meta-advanced.creative') ? 'active' : '' }}">
                        <i class="fas fa-palette"></i> <span>تحسين التصميمات</span>
                    </a>
                    <a href="{{ route('admin.meta-advanced.compliance') }}" class="nav-item {{ request()->routeIs('admin.meta-advanced.compliance') ? 'active' : '' }}">
                        <i class="fas fa-shield-alt"></i> <span>الامتثال والمراقبة</span>
                    </a>
                    <a href="{{ route('admin.meta-advanced.leads') }}" class="nav-item {{ request()->routeIs('admin.meta-advanced.leads') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i> <span>إدارة العملاء</span>
                    </a>
                    <a href="{{ route('admin.meta-advanced.targeting') }}" class="nav-item {{ request()->routeIs('admin.meta-advanced.targeting') ? 'active' : '' }}">
                        <i class="fas fa-crosshairs"></i> <span>الاستهداف المتقدم</span>
                    </a>
                    <a href="{{ route('admin.meta-advanced.reports') }}" class="nav-item {{ request()->routeIs('admin.meta-advanced.reports') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i> <span>التقارير الآلية</span>
                    </a>

                    {{-- ── المراقبة والإعدادات ── --}}
                    <div class="nav-sub-label">المراقبة والإعدادات</div>
                    <a href="{{ route('admin.meta-tools.pixel-helper') }}" class="nav-item {{ request()->routeIs('admin.meta-tools.pixel-helper*') ? 'active' : '' }}">
                        <i class="fas fa-plug"></i> <span>Pixel Helper</span>
                    </a>
                    <a href="{{ route('admin.diagnostics.index') }}" class="nav-item {{ request()->routeIs('admin.diagnostics.*') ? 'active' : '' }}">
                        <i class="fas fa-stethoscope"></i> <span>تشخيص CAPI</span>
                    </a>
                    <a href="{{ route('admin.ad-alerts.index') }}" class="nav-item {{ request()->routeIs('admin.ad-alerts.*') ? 'active' : '' }}">
                        <i class="fas fa-bell"></i> <span>تنبيهات الإعلانات</span>
                        @php $alertCount = \App\Models\AdAlert::unresolved()->unacknowledged()->count(); @endphp
                        @if($alertCount > 0)
                            <span class="badge bg-danger ms-auto">{{ $alertCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.ad-alerts.pause-log') }}" class="nav-item {{ request()->routeIs('admin.ad-alerts.pause-log') ? 'active' : '' }}">
                        <i class="fas fa-pause-circle"></i> <span>سجل الإيقاف التلقائي</span>
                    </a>
                    <a href="{{ route('admin.ai-compliance.index') }}" class="nav-item {{ request()->routeIs('admin.ai-compliance.*') ? 'active' : '' }}">
                        <i class="fas fa-shield-alt"></i> <span>الامتثال AI</span>
                    </a>
                    <a href="{{ route('admin.trigger-words.index') }}" class="nav-item {{ request()->routeIs('admin.trigger-words.*') ? 'active' : '' }}">
                        <i class="fas fa-ban"></i> <span>الكلمات الممنوعة</span>
                    </a>
                    <a href="{{ route('admin.account-configuration.index') }}" class="nav-item {{ request()->routeIs('admin.account-configuration.*') ? 'active' : '' }}">
                        <i class="fas fa-cogs"></i> <span>إعدادات الحساب</span>
                    </a>
                </div>
            </nav>

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- ═══ إعلانات Google ═══ --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            <nav class="nav-section">
                <div class="section-title" onclick="toggleSection(this)">
                    <i class="fab fa-google" style="color:#EA4335;margin-left:4px;"></i>
                    إعلانات Google <i class="fas fa-chevron-down collapse-icon"></i>
                </div>
                <div class="nav-items">
                    <a href="{{ route('admin.google-ads.index') }}" class="nav-item {{ request()->routeIs('admin.google-ads.*') ? 'active' : '' }}">
                        <i class="fab fa-google"></i> <span>إدارة إعلانات Google</span>
                    </a>
                </div>
            </nav>

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- ═══ أدوات التسويق العامة ═══ --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            <nav class="nav-section">
                <div class="section-title" onclick="toggleSection(this)">
                    التسويق العام <i class="fas fa-chevron-down collapse-icon"></i>
                </div>
                <div class="nav-items">
                    <a href="{{ route('admin.seo.index') }}" class="nav-item {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}">
                        <i class="fas fa-search"></i> <span>SEO Management</span>
                    </a>
                    <a href="{{ route('admin.predictive.index') }}" class="nav-item {{ request()->routeIs('admin.predictive.*') ? 'active' : '' }}">
                        <i class="fas fa-brain"></i> <span>التوقع AI</span>
                    </a>
                    <a href="{{ route('admin.reviewer-ips.index') }}" class="nav-item {{ request()->routeIs('admin.reviewer-ips.*') ? 'active' : '' }}">
                        <i class="fas fa-user-secret"></i> <span>IP المراجعين</span>
                    </a>
                </div>
            </nav>

            <nav class="nav-section">
                <div class="section-title" onclick="toggleSection(this)">
                    الحجوزات والخدمات <i class="fas fa-chevron-down collapse-icon"></i>
                </div>
                <div class="nav-items">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i> <span>الحجوزات</span>
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <i class="fas fa-spa"></i> <span>الخدمات</span>
                    </a>
                    <a href="{{ route('admin.coupons.index') }}" class="nav-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                        <i class="fas fa-ticket-alt"></i> <span>كوبونات الخصم</span>
                    </a>
                    <a href="{{ route('admin.reviews.index') }}" class="nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <i class="fas fa-star"></i> <span>تقييمات المنتجات</span>
                    </a>
                </div>
            </nav>

            <nav class="nav-section">
                <div class="section-title" onclick="toggleSection(this)">
                    الإدارة <i class="fas fa-chevron-down collapse-icon"></i>
                </div>
                <div class="nav-items">
                    <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> <span>المستخدمون</span>
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i> <span>رسائل التواصل</span>
                    </a>
                    <a href="{{ route('admin.hero-slides.index') }}" class="nav-item {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                        <i class="fas fa-images"></i> <span>السلايدشو</span>
                    </a>
                    <a href="{{ route('admin.blog.index') }}" class="nav-item {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i> <span>المدونة والمقالات</span>
                    </a>
                    <a href="{{ route('admin.affiliates.index') }}" class="nav-item {{ request()->routeIs('admin.affiliates.*') ? 'active' : '' }}">
                        <i class="fas fa-hand-holding-usd"></i> <span>التسويق بالعمولة</span>
                    </a>
                    <a href="{{ route('admin.activity-logs.index') }}" class="nav-item {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i> <span>سجل النشاطات</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> <span>الإعدادات</span>
                    </a>
                    <a href="{{ url('/pulse') }}" class="nav-item">
                        <i class="fas fa-heartbeat"></i> <span>المراقبة Pulse</span>
                    </a>
                </div>
            </nav>

            <div class="sidebar-footer">
                <a href="{{ route('home') }}" class="nav-item" target="_blank" style="padding:.5rem 0;">
                    <i class="fas fa-external-link-alt"></i> عرض الموقع
                </a>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="admin-main">
            {{-- Header --}}
            <header class="admin-header">
                <div class="header-inner">
                    <button class="btn d-lg-none sidebar-toggle-btn" id="sidebarToggle" onclick="toggleSidebar()">
                        <span class="icon-bar"></span>
                    </button>

                    <h1 class="page-title">
                        <span>@yield('title', 'لوحة التحكم')</span>
                    </h1>

                    <div class="header-actions">
                        {{-- Notifications --}}
                        <div class="dropdown">
                            <button class="action-btn" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                                <span class="badge-dot" id="notifBadge" style="display:none;"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-start notif-dropdown" aria-labelledby="notifDropdown">
                                <div class="notif-header">
                                    <h6><i class="fas fa-bell" style="color:var(--pink-600);margin-left:6px;"></i> الإشعارات</h6>
                                    <a href="#" id="markAllRead" style="display:none;" onclick="event.preventDefault(); markAllNotificationsRead();">قراءة الكل</a>
                                </div>
                                <div class="notif-body" id="notifList">
                                    <div class="text-center py-4 text-muted small">جارٍ التحميل...</div>
                                </div>
                            </div>
                        </div>

                        {{-- Quick Actions --}}
                        <div class="dropdown">
                            <button class="action-btn" data-bs-toggle="dropdown">
                                <i class="fas fa-plus"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius:12px;border:none;padding:.5rem;">
                                <li><a class="dropdown-item py-2" href="{{ route('admin.services.create') }}"><i class="fas fa-spa" style="color:var(--pink-600);width:24px;"></i> خدمة جديدة</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('admin.coupons.create') }}"><i class="fas fa-ticket" style="color:var(--pink-600);width:24px;"></i> كوبون جديد</a></li>
                            </ul>
                        </div>

                        {{-- User --}}
                        <a href="{{ route('logout') }}" class="user-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
                            <span class="d-none d-sm-inline small fw-medium">{{ Auth::user()->name ?? '' }}</span>
                            <i class="fas fa-sign-out-alt text-muted" style="font-size:.7rem;"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <div class="admin-content fade-in-up">
                @if(session('success'))
                    <div class="alert alert-success rounded-3 mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger rounded-3 mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </div>

            {{-- Footer --}}
            <div class="admin-footer">
                &copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'JeninCare' }} — جميع الحقوق محفوظة
                <span class="mx-2">|</span>
                الإصدار 1.0.1
            </div>
        </main>
    </div>

    {{-- Toast Container --}}
    <div class="toast-container"></div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            var sidebar = document.getElementById('adminSidebar');
            var overlay = document.getElementById('sidebarOverlay');
            var toggle = document.getElementById('sidebarToggle');
            var isOpen = sidebar.classList.contains('open');
            
            if (isOpen) {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
                if (toggle) toggle.classList.remove('open');
            } else {
                sidebar.classList.add('open');
                overlay.classList.add('show');
                if (toggle) toggle.classList.add('open');
            }
        }

        // Desktop sidebar collapse
        function toggleDesktopSidebar() {
            var sidebar = document.getElementById('adminSidebar');
            sidebar.classList.toggle('collapsed');
            var state = sidebar.classList.contains('collapsed') ? '1' : '0';
            localStorage.setItem('adminSidebarCollapsed', state);
        }

        // Restore desktop sidebar state
        if (window.innerWidth >= 992 && localStorage.getItem('adminSidebarCollapsed') === '1') {
            document.getElementById('adminSidebar').classList.add('collapsed');
        }

        // Close sidebar on overlay click (mobile)
        document.getElementById('sidebarOverlay').addEventListener('click', toggleSidebar);

        // Escape key closes mobile sidebar
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                var sidebar = document.getElementById('adminSidebar');
                if (sidebar.classList.contains('open')) toggleSidebar();
            }
        });

        // Swipe gesture on mobile sidebar
        var touchStartX = 0;
        var sidebar = document.getElementById('adminSidebar');
        sidebar.addEventListener('touchstart', function(e) { touchStartX = e.touches[0].clientX; });
        sidebar.addEventListener('touchend', function(e) {
            if (touchStartX - e.changedTouches[0].clientX > 50 && sidebar.classList.contains('open')) {
                toggleSidebar();
            }
        });

        // Collapsible nav sections - auto-open active section
        document.querySelectorAll('.nav-section').forEach(function(section) {
            var items = section.querySelector('.nav-items');
            var icon = section.querySelector('.collapse-icon');
            var hasActive = items.querySelector('.nav-item.active');
            
            if (hasActive) {
                items.style.maxHeight = items.scrollHeight + 'px';
                if (icon) icon.classList.remove('collapsed');
            } else {
                items.style.maxHeight = '0px';
                if (icon) icon.classList.add('collapsed');
            }
        });

        function toggleSection(titleEl) {
            var section = titleEl.closest('.nav-section');
            var items = section.querySelector('.nav-items');
            var icon = section.querySelector('.collapse-icon');
            var isOpen = items.style.maxHeight !== '0px' && items.style.maxHeight !== '';
            
            if (isOpen) {
                items.style.maxHeight = '0px';
                if (icon) icon.classList.add('collapsed');
            } else {
                items.style.maxHeight = items.scrollHeight + 'px';
                if (icon) icon.classList.remove('collapsed');
            }
        }

        // Notifications
        function loadNotifications() {
            fetch('{{ route("admin.notifications.unread") }}')
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    var badge = document.getElementById('notifBadge');
                    var list = document.getElementById('notifList');
                    var markAll = document.getElementById('markAllRead');

                    if (data.count > 0) {
                        badge.style.display = '';
                        markAll.style.display = '';
                    } else {
                        badge.style.display = 'none';
                        markAll.style.display = 'none';
                    }

                    if (data.notifications && data.notifications.length > 0) {
                        list.innerHTML = data.notifications.map(function(n) {
                            var iconMap = { 'order': 'fa-shopping-bag', 'stock': 'fa-box', 'system': 'fa-cog' };
                            var colorMap = { 'order': '#DB2777', 'stock': '#D97706', 'system': '#64748B' };
                            var icon = iconMap[n.type] || 'fa-bell';
                            var color = colorMap[n.type] || '#64748B';
                            return '<a href="{{ route("admin.notifications.index") }}" class="notif-item">' +
                                '<div class="notif-icon" style="background:' + color + '15;color:' + color + ';"><i class="fas ' + icon + '"></i></div>' +
                                '<div class="notif-content">' +
                                '<div class="notif-title">' + (n.title || '') + '</div>' +
                                '<div class="notif-body-text">' + (n.body || '') + '</div>' +
                                '</div>' +
                                '<span class="notif-time">' + (n.created_at || '') + '</span>' +
                                '</a>';
                        }).join('');
                    } else {
                        list.innerHTML = '<div class="text-center py-4 text-muted small"><i class="fas fa-check-circle mb-2" style="font-size:1.5rem;display:block;opacity:.4;"></i> لا توجد إشعارات جديدة</div>';
                    }
                })
                .catch(function() {});
        }

        function markAllNotificationsRead() {
            fetch('{{ route("admin.notifications.read-all") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                .then(function() { loadNotifications(); });
        }

        loadNotifications();
        setInterval(loadNotifications, 60000);

        // Auto-dismiss alerts
        document.querySelectorAll('.alert').forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity .5s';
                alert.style.opacity = '0';
                setTimeout(function() { alert.remove(); }, 500);
            }, 5000);
        });
    </script>
</body>
</html>
