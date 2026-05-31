@php if(!isset($headerServices)){$headerServices=\App\Models\Service::active()->ordered()->get();} @endphp

<header id="mainHeaderV3" class="fixed top-0 w-full z-50 transition-all duration-300" style="background:var(--header-bg);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid rgba(255,255,255,0.04);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 md:h-[72px] flex items-center justify-between">
        <div class="flex items-center gap-10 flex-1">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0" style="color:var(--ink);">
                @if(!empty($siteSettings['site_logo_url']))
                    <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name'] ?? 'سماح كير' }}" class="h-8 md:h-9 w-auto object-contain">
                @else
                    <span class="text-lg md:text-xl font-black tracking-tight" style="color:var(--ink);">{{ $siteSettings['site_name_ar'] ?? 'سماح كير' }}<span style="color:var(--brand-500);">.</span></span>
                @endif
            </a>
            <nav class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}" class="nav-link-main {{ request()->routeIs('home') ? 'active' : '' }}">الرئيسية</a>
                <a href="{{ route('booking') }}" class="nav-link-main {{ request()->routeIs('booking') ? 'active' : '' }}">احجزي موعد</a>
                <a href="{{ route('blog.index') }}" class="nav-link-main {{ request()->routeIs('blog.*') ? 'active' : '' }}">المدونة</a>
                <a href="{{ route('contact') }}" class="nav-link-main {{ request()->routeIs('contact') ? 'active' : '' }}">تواصل</a>
            </nav>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('booking') }}" class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-xs tracking-wide transition-all duration-300 hover:-translate-y-0.5" style="background:var(--gradient-primary);color:#fff;box-shadow:0 4px 16px rgba(236,72,153,0.25);">
                <i class="ph ph-calendar-plus"></i>
                <span>احجزي موعد</span>
            </a>
            <button onclick="toggleMobileMenuV3()" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200" style="color:var(--ink-muted);background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.06);" aria-label="القائمة">
                <i class="ph ph-list text-xl" id="mobileMenuIconV3"></i>
            </button>
        </div>
    </div>
</header>

{{-- Mobile Menu Overlay --}}
<div id="mobileMenuV3" class="fixed inset-0 z-[60] hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0" style="background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);" onclick="toggleMobileMenuV3()"></div>
    <div class="absolute top-0 left-0 h-full w-[300px] max-w-[85vw] shadow-2xl transform -translate-x-full transition-transform duration-300 ease-out flex flex-col" id="mobileMenuPanelV3" style="background:var(--surface);border-left:1px solid rgba(255,255,255,0.06);">
        <div class="flex items-center justify-between px-5 py-4 border-b" style="border-color:rgba(255,255,255,0.06);">
            <div class="flex items-center gap-2.5">
                @if(!empty($siteSettings['site_logo_url']))
                <img src="{{ $siteSettings['site_logo_url'] }}" alt="سماح كير" class="h-7 w-auto object-contain">
                @else
                <span class="text-base font-black" style="color:var(--ink);">{{ $siteSettings['site_name_ar'] ?? 'سماح كير' }}</span>
                @endif
            </div>
            <button onclick="toggleMobileMenuV3()" class="w-9 h-9 rounded-full flex items-center justify-center transition-colors" style="background:rgba(255,255,255,0.05);color:var(--ink-dim);border:none;cursor:pointer;" aria-label="إغلاق">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto px-4 py-5 space-y-1">
            <a href="{{ route('booking') }}" class="flex items-center justify-center gap-2 py-3.5 rounded-2xl font-bold text-sm mb-5 transition-all" style="background:var(--gradient-primary);color:#fff;text-decoration:none;box-shadow:0 4px 16px rgba(236,72,153,0.2);">
                <i class="ph ph-calendar-plus"></i> احجزي موعدك الآن
            </a>
            <a href="{{ route('home') }}" class="mobile-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.04);"><i class="ph ph-house text-lg" style="color:var(--ink-dim);"></i></span>
                الرئيسية
            </a>
            <a href="{{ route('booking') }}" class="mobile-link {{ request()->routeIs('booking') ? 'active' : '' }}">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.04);"><i class="ph ph-calendar-plus text-lg" style="color:var(--ink-dim);"></i></span>
                احجزي موعد
            </a>
            <a href="{{ route('blog.index') }}" class="mobile-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.04);"><i class="ph ph-article text-lg" style="color:var(--ink-dim);"></i></span>
                المدونة
            </a>
            <a href="{{ route('contact') }}" class="mobile-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.04);"><i class="ph ph-envelope text-lg" style="color:var(--ink-dim);"></i></span>
                تواصل معنا
            </a>

            @if(isset($headerServices) && $headerServices->count())
            <div class="border-t mt-6 pt-5" style="border-color:rgba(255,255,255,0.06);">
                <p class="text-[10px] font-bold tracking-widest uppercase mb-3 px-1" style="color:var(--ink-dim);">خدماتنا</p>
                <div class="space-y-1">
                    @foreach($headerServices->take(5) as $s)
                    <a href="{{ route('booking') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors" style="color:var(--ink-dim);text-decoration:none;">
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.04);"><i class="ph ph-sparkle text-base" style="color:var(--ink-dim);"></i></span>
                        <span class="flex-1">{{ $s->name_ar }}</span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full" style="background:rgba(255,255,255,0.06);color:var(--brand-500);">{{ number_format($s->final_price) }} ₪</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <div class="border-t px-4 py-4" style="border-color:rgba(255,255,255,0.06);">
            @auth
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium w-full transition-colors" style="color:#ef4444;background:none;border:none;cursor:pointer;">
                    <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(239,68,68,0.1);"><i class="ph ph-sign-out text-lg"></i></span>
                    تسجيل الخروج
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors" style="color:var(--ink);text-decoration:none;">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.04);"><i class="ph ph-sign-in text-lg" style="color:var(--ink-dim);"></i></span>
                تسجيل الدخول
            </a>
            <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 py-3 rounded-2xl font-bold text-sm mt-2 transition-all" style="background:rgba(255,255,255,0.05);color:var(--ink);text-decoration:none;border:1px solid rgba(255,255,255,0.08);">
                <i class="ph ph-user-plus"></i> إنشاء حساب جديد
            </a>
            @endauth
        </div>
    </div>
</div>

<style>
.nav-link-main {
    position:relative;
    display:inline-flex;
    align-items:center;
    padding:6px 16px;
    border-radius:9999px;
    font-size:0.8125rem;
    font-weight:600;
    color:var(--ink-muted);
    text-decoration:none!important;
    transition:all 0.2s;
}
.nav-link-main:hover {
    color:var(--ink);
    background:rgba(255,255,255,0.04);
}
.nav-link-main.active {
    color:var(--ink);
    background:rgba(236,72,153,0.08);
}
.nav-link-main.active::after {
    content:'';
    position:absolute;
    bottom:2px;
    left:50%;
    transform:translateX(-50%);
    width:16px;
    height:2px;
    border-radius:2px;
    background:var(--brand-500);
}

.mobile-link {
    display:flex;
    align-items:center;
    gap:12px;
    padding:10px 12px;
    border-radius:14px;
    font-size:0.875rem;
    font-weight:600;
    color:var(--ink-dim);
    text-decoration:none!important;
    transition:all 0.15s;
}
.mobile-link:hover {
    background:rgba(255,255,255,0.04);
    color:var(--ink);
}
.mobile-link.active {
    background:rgba(236,72,153,0.06);
    color:var(--brand-500);
}

.header-spacer { height:64px; }
@media (min-width:768px) { .header-spacer { height:72px; } }
</style>

<script>
function toggleMobileMenuV3() {
    var m = document.getElementById('mobileMenuV3');
    var p = document.getElementById('mobileMenuPanelV3');
    var i = document.getElementById('mobileMenuIconV3');
    if (m.classList.contains('hidden')) {
        m.classList.remove('hidden');
        m.classList.add('flex');
        setTimeout(function() { p.style.transform = 'translateX(0)'; }, 10);
        if (i) i.className = 'ph ph-x text-xl';
    } else {
        p.style.transform = 'translateX(-100%)';
        setTimeout(function() {
            m.classList.add('hidden');
            m.classList.remove('flex');
        }, 300);
        if (i) i.className = 'ph ph-list text-xl';
    }
}

(function() {
    var h = document.getElementById('mainHeaderV3');
    if (!h) return;
    var ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(function() {
                var s = window.scrollY;
                var cs = getComputedStyle(document.documentElement);
                var headerBg = cs.getPropertyValue('--header-bg').trim() || 'rgba(9,9,11,0.92)';
                var isDark = isColorDark(headerBg);
                h.style.background = s > 50 ? headerBg : 'var(--header-bg, rgba(9,9,11,0.6))';
                h.style.boxShadow = s > 50 ? '0 4px 30px rgba(0,0,0,0.4)' : 'none';
                h.style.borderBottomColor = s > 50
                    ? (isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.08)')
                    : (isDark ? 'rgba(255,255,255,0.04)' : 'rgba(0,0,0,0.06)');
                ticking = false;
            });
            ticking = true;
        }
    });
    function isColorDark(cssColor) {
        var el = document.createElement('div');
        el.style.color = cssColor;
        document.body.appendChild(el);
        var cs2 = getComputedStyle(el).color;
        document.body.removeChild(el);
        var m = cs2.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
        if (!m) return true;
        return (Number(m[1])*299 + Number(m[2])*587 + Number(m[3])*114) / 1000 < 128;
    }
})();

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        var m = document.getElementById('mobileMenuV3');
        if (m && !m.classList.contains('hidden')) toggleMobileMenuV3();
    }
});
</script>
