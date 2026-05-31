@php if(!isset($headerServices)){$headerServices=\App\Models\Service::active()->ordered()->get();} @endphp

<div class="w-full text-center py-2.5 px-4 text-xs font-semibold tracking-wide" style="background:var(--gradient-primary);color:#fff;">
    <span>✨ تخفيضات الصيف — خصم يصل إلى 40% على جميع الخدمات</span>
</div>

<header class="sticky top-0 w-full z-50 transition-all duration-300" id="mainHeader" style="background:var(--header-bg);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid var(--glass-border);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0 group">
                @if(!empty($siteSettings['site_logo_url']))
                    <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name']??'سماح كير' }}" class="h-9 md:h-11 w-auto object-contain transition-transform group-hover:scale-105">
                @else
                    <span class="text-xl md:text-2xl font-black tracking-tight font-display" style="color:var(--ink);">سماح <span class="gradient-text">كير</span></span>
                @endif
            </a>

            <nav class="hidden lg:flex items-center gap-1 text-sm font-medium font-body">
                <a href="{{ route('home') }}" class="nav-link-clean px-4 py-2 rounded-full {{ request()->routeIs('home')?'active':'' }}">الرئيسية</a>
                <a href="{{ route('booking') }}" class="nav-link-clean px-4 py-2 rounded-full {{ request()->routeIs('booking')?'active':'' }}">المتجر</a>
                <a href="{{ route('blog.index') }}" class="nav-link-clean px-4 py-2 rounded-full {{ request()->routeIs('blog.*')?'active':'' }}">الفئات</a>
                <a href="{{ route('contact') }}" class="nav-link-clean px-4 py-2 rounded-full {{ request()->routeIs('contact')?'active':'' }}">المدونة</a>
                <a href="{{ route('faq') }}" class="nav-link-clean px-4 py-2 rounded-full {{ request()->routeIs('faq')?'active':'' }}">من نحن</a>
            </nav>

            <div class="flex items-center gap-2">
                <button class="relative w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110" style="background:var(--brand-50);color:var(--brand-500);">
                    <i class="ph ph-shopping-bag text-xl"></i>
                    <span class="absolute -top-0.5 -right-0.5 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold text-white" style="background:var(--brand-500);">3</span>
                </button>

                @auth
                    <a href="{{ route('booking') }}" class="hidden sm:inline-flex items-center gap-1.5 w-10 h-10 rounded-full justify-center transition-all hover:scale-110" style="background:var(--brand-50);color:var(--brand-500);">
                        <i class="ph ph-user-circle text-xl"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-1.5 w-10 h-10 rounded-full justify-center transition-all hover:scale-110" style="background:var(--brand-50);color:var(--brand-500);">
                        <i class="ph ph-sign-in text-xl"></i>
                    </a>
                @endauth

                <a href="{{ route('booking') }}" class="hidden sm:inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-sm font-bold text-white transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 font-body" style="background:var(--brand-500);">
                    <i class="ph ph-calendar-plus text-base"></i>
                    احجزي الآن
                </a>

                <button onclick="toggleMobileMenu()" class="lg:hidden w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110" style="background:var(--brand-50);color:var(--brand-500);">
                    <i class="ph ph-list text-xl" id="mobileMenuIcon"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<div id="mobileMenu" class="fixed inset-0 z-[60] hidden" style="direction:rtl;">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="toggleMobileMenu()"></div>
    <div class="absolute top-0 right-0 w-[320px] sm:w-96 h-full shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col" id="mobilePanel" style="background:white;">
        <div class="px-6 py-5" style="border-bottom:1px solid var(--brand-50);">
            <div class="flex items-center justify-between">
                @if(!empty($siteSettings['site_logo_url']))
                    <img src="{{ $siteSettings['site_logo_url'] }}" alt="سماح كير" class="h-8 w-auto object-contain">
                @else
                    <span class="text-lg font-black font-display" style="color:var(--ink);">سماح <span class="gradient-text">كير</span></span>
                @endif
                <button onclick="toggleMobileMenu()" class="w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110" style="background:var(--brand-50);color:var(--brand-500);">
                    <i class="ph ph-x text-lg"></i>
                </button>
            </div>
        </div>

        <div class="px-4 pt-4">
            <a href="{{ route('booking') }}" class="flex items-center justify-center gap-2 py-3.5 rounded-xl font-bold text-sm text-white font-body transition-all hover:shadow-lg" style="background:var(--brand-500);">
                <i class="ph ph-calendar-plus text-lg"></i>
                <span>احجزي الآن</span>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-4 space-y-1">
            <a href="{{ route('home') }}" class="mobile-link-clean {{ request()->routeIs('home')?'active':'' }}">
                <i class="ph ph-house text-lg"></i>
                <span>الرئيسية</span>
            </a>
            <a href="{{ route('booking') }}" class="mobile-link-clean {{ request()->routeIs('booking')?'active':'' }}">
                <i class="ph ph-shopping-bag text-lg"></i>
                <span>المتجر</span>
            </a>
            <a href="{{ route('blog.index') }}" class="mobile-link-clean {{ request()->routeIs('blog.*')?'active':'' }}">
                <i class="ph ph-article text-lg"></i>
                <span>الفئات</span>
            </a>
            <a href="{{ route('contact') }}" class="mobile-link-clean {{ request()->routeIs('contact')?'active':'' }}">
                <i class="ph ph-envelope text-lg"></i>
                <span>المدونة</span>
            </a>
            <a href="{{ route('faq') }}" class="mobile-link-clean {{ request()->routeIs('faq')?'active':'' }}">
                <i class="ph ph-question text-lg"></i>
                <span>من نحن</span>
            </a>

            <div class="pt-4 mt-4" style="border-top:1px solid var(--brand-50);">
                @auth
                <form method="POST" action="{{ route('logout') }}" style="display:contents;">
                    @csrf
                    <button type="submit" class="mobile-link-clean w-full text-right">
                        <i class="ph ph-sign-out text-lg"></i>
                        <span>تسجيل خروج</span>
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="mobile-link-clean">
                    <i class="ph ph-sign-in text-lg"></i>
                    <span>تسجيل الدخول</span>
                </a>
                <a href="{{ route('register') }}" class="mobile-link-clean">
                    <i class="ph ph-user-plus text-lg"></i>
                    <span>إنشاء حساب</span>
                </a>
                @endauth
            </div>
        </div>

        <div class="px-6 py-4" style="border-top:1px solid var(--brand-50);">
            <p class="text-xs font-bold mb-3" style="color:var(--ink-dim);">تابعينا</p>
            <div class="flex items-center gap-2.5">
                @if(!empty($siteSettings['whatsapp_number']))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110" style="background:#25D366;"><i class="ph-fill ph-whatsapp-logo text-lg"></i></a>
                @endif
                @if(!empty($siteSettings['instagram_url']))
                <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110" style="background:linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);"><i class="ph-fill ph-instagram-logo text-lg"></i></a>
                @endif
                @if(!empty($siteSettings['facebook_url']))
                <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110" style="background:#1877F2;"><i class="ph-fill ph-facebook-logo text-lg"></i></a>
                @endif
                @if(!empty($siteSettings['tiktok_url']))
                <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110" style="background:#000000;"><i class="ph-fill ph-tiktok-logo text-lg"></i></a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.nav-link-clean { 
    color: var(--ink-muted); 
    text-decoration: none !important; 
    transition: all 0.2s ease; 
    font-weight: 500;
}
.nav-link-clean:hover { 
    color: var(--ink) !important; 
    background: var(--brand-50);
}
.nav-link-clean.active { 
    color: var(--brand-500) !important; 
    background: var(--brand-50);
    font-weight: 600;
}
.mobile-link-clean { 
    display: flex; 
    align-items: center; 
    gap: 14px; 
    padding: 14px 16px; 
    border-radius: 14px; 
    font-size: 0.95rem; 
    font-weight: 600; 
    color: var(--ink-muted); 
    text-decoration: none !important; 
    transition: all 0.2s ease; 
}
.mobile-link-clean:hover { 
    background: var(--brand-50); 
    color: var(--ink); 
}
.mobile-link-clean.active { 
    background: var(--brand-50); 
    color: var(--brand-500) !important; 
}
.mobile-link-clean i {
    width: 24px;
    text-align: center;
}
</style>

<script>
function toggleMobileMenu(){
    var m=document.getElementById('mobileMenu'),
        p=document.getElementById('mobilePanel'),
        i=document.getElementById('mobileMenuIcon');
    if(m.classList.contains('hidden')){
        m.classList.remove('hidden');
        document.body.style.overflow='hidden';
        setTimeout(function(){p.style.transform='translateX(0)'},10);
        i.className='ph ph-x text-xl';
    } else {
        p.style.transform='translateX(100%)';
        document.body.style.overflow='';
        setTimeout(function(){m.classList.add('hidden')},300);
        i.className='ph ph-list text-xl';
    }
}
document.addEventListener('keydown',function(e){
    if(e.key==='Escape'){
        var m=document.getElementById('mobileMenu');
        if(m&&!m.classList.contains('hidden'))toggleMobileMenu();
    }
});
window.addEventListener('scroll',function(){
    var h=document.getElementById('mainHeader');
    if(!h)return;
    h.style.boxShadow=window.scrollY>20?'0 4px 20px rgba(0,0,0,0.06)':'none';
});
</script>
