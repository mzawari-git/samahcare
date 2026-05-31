@php if(!isset($headerServices)){$headerServices=\App\Models\Service::active()->ordered()->get();} @endphp

<div class="w-full py-2.5 px-4 text-center" style="background: var(--gradient-primary);">
    <p class="text-xs sm:text-sm font-medium text-white">
        <i class="ph ph-sparkle ml-1"></i>
        تخفيضات الصيف — خصم يصل إلى 40% على جميع الخدمات
        <i class="ph ph-sparkle mr-1"></i>
    </p>
</div>

<header class="sticky top-0 w-full z-50 transition-all duration-300" id="mainHeader" style="background: var(--header-bg); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: var(--border-subtle);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0 group">
                @if(!empty($siteSettings['site_logo_url']))
                    <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name'] ?? 'سماح كير' }}" class="h-9 lg:h-11 w-auto object-contain transition-transform group-hover:scale-105">
                @else
                    <span class="text-xl lg:text-2xl font-black tracking-tight" style="color: var(--ink);">
                        سماح <span class="gradient-text">كير</span>
                    </span>
                @endif
            </a>

            <nav class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="ph ph-house"></i>
                    <span>الرئيسية</span>
                </a>
                <a href="{{ route('booking') }}" class="nav-link {{ request()->routeIs('booking') ? 'active' : '' }}">
                    <i class="ph ph-shopping-bag"></i>
                    <span>المتجر</span>
                </a>
                <a href="{{ route('blog.index') }}" class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                    <i class="ph ph-article"></i>
                    <span>المدونة</span>
                </a>
                <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <i class="ph ph-envelope"></i>
                    <span>تواصلي</span>
                </a>
                <a href="{{ route('faq') }}" class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}">
                    <i class="ph ph-question"></i>
                    <span>الأسئلة</span>
                </a>
            </nav>

            <div class="flex items-center gap-2 lg:gap-3">
                <button class="relative w-10 h-10 lg:w-11 lg:h-11 rounded-xl flex items-center justify-center transition-all hover:scale-105" style="background: var(--neutral-100); color: var(--ink);">
                    <i class="ph ph-shopping-bag text-lg"></i>
                    <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold text-white" style="background: var(--brand-500);">3</span>
                </button>

                @auth
                    <a href="{{ route('booking') }}" class="hidden sm:flex w-10 h-10 lg:w-11 lg:h-11 rounded-xl items-center justify-center transition-all hover:scale-105" style="background: var(--neutral-100); color: var(--ink);">
                        <i class="ph ph-user-circle text-lg"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:flex w-10 h-10 lg:w-11 lg:h-11 rounded-xl items-center justify-center transition-all hover:scale-105" style="background: var(--neutral-100); color: var(--ink);">
                        <i class="ph ph-sign-in text-lg"></i>
                    </a>
                @endauth

                <a href="{{ route('booking') }}" class="hidden lg:inline-flex btn btn-primary py-2.5 px-5 text-sm">
                    <i class="ph ph-calendar-plus"></i>
                    <span>احجزي الآن</span>
                </a>

                <button onclick="toggleMobileMenu()" class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:scale-105" style="background: var(--neutral-100); color: var(--ink);">
                    <i class="ph ph-list text-lg" id="mobileMenuIcon"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<div id="mobileMenu" class="fixed inset-0 z-[60] hidden" style="direction: rtl;">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="toggleMobileMenu()"></div>
    
    <div class="absolute top-0 right-0 w-[320px] sm:w-[380px] h-full shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col" id="mobilePanel" style="background: var(--surface);">
        
        <div class="px-6 py-5 flex items-center justify-between" style="border-bottom: var(--border-subtle);">
            @if(!empty($siteSettings['site_logo_url']))
                <img src="{{ $siteSettings['site_logo_url'] }}" alt="سماح كير" class="h-8 w-auto object-contain">
            @else
                <span class="text-lg font-black" style="color: var(--ink);">سماح <span class="gradient-text">كير</span></span>
            @endif
            <button onclick="toggleMobileMenu()" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:scale-105" style="background: var(--neutral-100); color: var(--ink);">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>

        <div class="px-5 pt-5">
            <a href="{{ route('booking') }}" class="btn btn-primary w-full justify-center">
                <i class="ph ph-calendar-plus text-lg"></i>
                <span>احجزي موعدكِ الآن</span>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-5 space-y-1">
            <a href="{{ route('home') }}" class="mobile-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="ph ph-house"></i>
                <span>الرئيسية</span>
            </a>
            <a href="{{ route('booking') }}" class="mobile-link {{ request()->routeIs('booking') ? 'active' : '' }}">
                <i class="ph ph-shopping-bag"></i>
                <span>المتجر</span>
            </a>
            <a href="{{ route('blog.index') }}" class="mobile-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                <i class="ph ph-article"></i>
                <span>المدونة</span>
            </a>
            <a href="{{ route('contact') }}" class="mobile-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                <i class="ph ph-envelope"></i>
                <span>تواصلي معنا</span>
            </a>
            <a href="{{ route('faq') }}" class="mobile-link {{ request()->routeIs('faq') ? 'active' : '' }}">
                <i class="ph ph-question"></i>
                <span>الأسئلة الشائعة</span>
            </a>

            <div class="my-4" style="border-top: var(--border-subtle);"></div>

            @auth
                <form method="POST" action="{{ route('logout') }}" style="display: contents;">
                    @csrf
                    <button type="submit" class="mobile-link w-full text-right">
                        <i class="ph ph-sign-out"></i>
                        <span>تسجيل خروج</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mobile-link">
                    <i class="ph ph-sign-in"></i>
                    <span>تسجيل الدخول</span>
                </a>
                <a href="{{ route('register') }}" class="mobile-link">
                    <i class="ph ph-user-plus"></i>
                    <span>إنشاء حساب</span>
                </a>
            @endauth
        </div>

        <div class="px-6 py-5" style="border-top: var(--border-subtle);">
            <p class="text-xs font-semibold mb-3" style="color: var(--ink-dim);">تابعينا على</p>
            <div class="flex items-center gap-2">
                @if(!empty($siteSettings['whatsapp_number']))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-10 h-10 rounded-xl flex items-center justify-center text-white transition-all hover:scale-105" style="background: #25D366;">
                    <i class="ph-fill ph-whatsapp-logo text-lg"></i>
                </a>
                @endif
                @if(!empty($siteSettings['instagram_url']))
                <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 rounded-xl flex items-center justify-center text-white transition-all hover:scale-105" style="background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);">
                    <i class="ph-fill ph-instagram-logo text-lg"></i>
                </a>
                @endif
                @if(!empty($siteSettings['facebook_url']))
                <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-10 h-10 rounded-xl flex items-center justify-center text-white transition-all hover:scale-105" style="background: #1877F2;">
                    <i class="ph-fill ph-facebook-logo text-lg"></i>
                </a>
                @endif
                @if(!empty($siteSettings['tiktok_url']))
                <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="w-10 h-10 rounded-xl flex items-center justify-center text-white transition-all hover:scale-105" style="background: #000000;">
                    <i class="ph-fill ph-tiktok-logo text-lg"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.nav-link {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 10px 16px;
    font-size: 0.9375rem;
    font-weight: 500;
    color: var(--ink-muted);
    text-decoration: none !important;
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
}

.nav-link:hover {
    color: var(--ink);
    background: var(--neutral-100);
}

.nav-link.active {
    color: var(--brand-600);
    background: var(--brand-50);
    font-weight: 600;
}

.mobile-link {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    font-size: 1rem;
    font-weight: 500;
    color: var(--ink-muted);
    text-decoration: none !important;
    border-radius: var(--radius-lg);
    transition: all var(--transition-fast);
}

.mobile-link:hover {
    background: var(--neutral-100);
    color: var(--ink);
}

.mobile-link.active {
    background: var(--brand-50);
    color: var(--brand-600);
    font-weight: 600;
}

.mobile-link i {
    width: 24px;
    text-align: center;
    font-size: 1.25rem;
}
</style>

<script>
function toggleMobileMenu() {
    var menu = document.getElementById('mobileMenu');
    var panel = document.getElementById('mobilePanel');
    var icon = document.getElementById('mobileMenuIcon');
    
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(function() {
            panel.style.transform = 'translateX(0)';
        }, 10);
        icon.className = 'ph ph-x text-lg';
    } else {
        panel.style.transform = 'translateX(100%)';
        document.body.style.overflow = '';
        setTimeout(function() {
            menu.classList.add('hidden');
        }, 300);
        icon.className = 'ph ph-list text-lg';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        var menu = document.getElementById('mobileMenu');
        if (menu && !menu.classList.contains('hidden')) {
            toggleMobileMenu();
        }
    }
});

window.addEventListener('scroll', function() {
    var header = document.getElementById('mainHeader');
    if (!header) return;
    header.style.boxShadow = window.scrollY > 20 ? 'var(--shadow-sm)' : 'none';
});
</script>
