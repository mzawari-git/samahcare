@php if(!isset($headerServices)){$headerServices=\App\Models\Service::active()->ordered()->get();} @endphp

<header class="fixed top-0 w-full z-50 transition-all duration-300" id="mainHeader" style="background:rgba(255,255,255,0.95);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border-bottom:1px solid rgba(0,0,0,0.04);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0">
                @if(!empty($siteSettings['site_logo_url']))
                    <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name']??'سماح كير' }}" class="h-8 md:h-10 w-auto object-contain">
                @else
                    <span class="text-xl md:text-2xl font-black tracking-tight" style="color:var(--ink);">سماح كير<span style="color:var(--brand-500);">.</span></span>
                @endif
            </a>

            <nav class="hidden lg:flex items-center gap-8 text-sm font-medium">
                <a href="{{ route('home') }}" class="nav-link-clean {{ request()->routeIs('home')?'active':'' }}">الرئيسية</a>
                <a href="{{ route('booking') }}" class="nav-link-clean {{ request()->routeIs('booking')?'active':'' }}">الخدمات</a>
                <a href="{{ route('blog.index') }}" class="nav-link-clean {{ request()->routeIs('blog.*')?'active':'' }}">المدونة</a>
                <a href="{{ route('contact') }}" class="nav-link-clean {{ request()->routeIs('contact')?'active':'' }}">تواصل معنا</a>
                <a href="{{ route('faq') }}" class="nav-link-clean {{ request()->routeIs('faq')?'active':'' }}">الأسئلة الشائعة</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ route('booking') }}" class="hidden sm:inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-sm font-bold text-white transition-all duration-200 hover:opacity-90 hover:-translate-y-px" style="background:var(--gradient-primary);">
                    <i class="ph ph-calendar-plus text-base"></i>
                    احجزي موعدك
                </a>
                @auth
                    <a href="{{ route('booking') }}" class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium transition-colors" style="color:var(--ink-muted);">
                        <i class="ph ph-user-circle text-lg"></i>
                        حسابي
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium transition-colors" style="color:var(--ink-muted);">
                        <i class="ph ph-sign-in text-lg"></i>
                        دخول
                    </a>
                @endauth
                <button onclick="toggleMobileMenu()" class="lg:hidden w-10 h-10 rounded-full flex items-center justify-center transition-colors" style="color:var(--ink);">
                    <i class="ph ph-list text-xl" id="mobileMenuIcon"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<div id="mobileMenu" class="fixed inset-0 z-[60] hidden" style="direction:rtl;">
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="toggleMobileMenu()"></div>
    <div class="absolute top-0 right-0 w-[300px] sm:w-80 h-full bg-white shadow-xl transform translate-x-full transition-transform duration-300 flex flex-col" id="mobilePanel">
        <div class="px-6 py-5 border-b border-gray-100">
            <div class="flex items-center justify-between">
                @if(!empty($siteSettings['site_logo_url']))
                    <img src="{{ $siteSettings['site_logo_url'] }}" alt="سماح كير" class="h-8 w-auto object-contain">
                @else
                    <span class="text-lg font-black" style="color:var(--ink);">سماح كير<span style="color:var(--brand-500);">.</span></span>
                @endif
                <button onclick="toggleMobileMenu()" class="w-9 h-9 rounded-full flex items-center justify-center bg-gray-50 text-gray-400 hover:bg-gray-100 transition-colors">
                    <i class="ph ph-x text-lg"></i>
                </button>
            </div>
        </div>

        <div class="px-4 pt-4">
            <a href="{{ route('booking') }}" class="flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm text-white" style="background:var(--gradient-primary);">
                <i class="ph ph-calendar-plus text-lg"></i>
                <span>احجزي موعدك الآن</span>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-4 space-y-1">
            <a href="{{ route('home') }}" class="mobile-link-clean {{ request()->routeIs('home')?'active':'' }}">
                <i class="ph ph-house text-lg"></i>
                <span>الرئيسية</span>
            </a>
            <a href="{{ route('booking') }}" class="mobile-link-clean {{ request()->routeIs('booking')?'active':'' }}">
                <i class="ph ph-calendar-plus text-lg"></i>
                <span>احجزي موعد</span>
            </a>
            <a href="{{ route('blog.index') }}" class="mobile-link-clean {{ request()->routeIs('blog.*')?'active':'' }}">
                <i class="ph ph-article text-lg"></i>
                <span>المدونة</span>
            </a>
            <a href="{{ route('contact') }}" class="mobile-link-clean {{ request()->routeIs('contact')?'active':'' }}">
                <i class="ph ph-envelope text-lg"></i>
                <span>تواصل معنا</span>
            </a>
            <a href="{{ route('faq') }}" class="mobile-link-clean {{ request()->routeIs('faq')?'active':'' }}">
                <i class="ph ph-question text-lg"></i>
                <span>الأسئلة الشائعة</span>
            </a>

            <div class="border-t border-gray-100 mt-4 pt-4">
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
                    <span>تسجيل دخول</span>
                </a>
                <a href="{{ route('register') }}" class="mobile-link-clean">
                    <i class="ph ph-user-plus text-lg"></i>
                    <span>إنشاء حساب</span>
                </a>
                @endauth
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            <div class="flex items-center gap-3">
                @if(!empty($siteSettings['whatsapp_number']))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-9 h-9 rounded-full flex items-center justify-center text-white" style="background:#25D366;"><i class="ph-fill ph-whatsapp-logo text-lg"></i></a>
                @endif
                @if(!empty($siteSettings['instagram_url']))
                <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-9 h-9 rounded-full flex items-center justify-center text-white" style="background:#E4405F;"><i class="ph-fill ph-instagram-logo text-lg"></i></a>
                @endif
                @if(!empty($siteSettings['facebook_url']))
                <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-9 h-9 rounded-full flex items-center justify-center text-white" style="background:#1877F2;"><i class="ph-fill ph-facebook-logo text-lg"></i></a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.nav-link-clean { color: var(--ink-muted); text-decoration: none !important; transition: color 0.2s; position: relative; padding: 4px 0; }
.nav-link-clean:hover, .nav-link-clean.active { color: var(--ink) !important; }
.nav-link-clean.active::after { content: ''; position: absolute; bottom: -2px; right: 0; left: 0; height: 2px; background: var(--brand-500); border-radius: 1px; }
.mobile-link-clean { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; font-size: 0.9rem; font-weight: 600; color: var(--ink-muted); text-decoration: none !important; transition: all 0.15s; }
.mobile-link-clean:hover { background: var(--surface-alt); color: var(--ink); }
.mobile-link-clean.active { background: var(--brand-50); color: var(--brand-600) !important; }
</style>

<script>
function toggleMobileMenu(){var m=document.getElementById('mobileMenu'),p=document.getElementById('mobilePanel'),i=document.getElementById('mobileMenuIcon');m.classList.contains('hidden')?(m.classList.remove('hidden'),setTimeout(function(){p.style.transform='translateX(0)'},10),i.className='ph ph-x text-xl'):(p.style.transform='translateX(100%)',setTimeout(function(){m.classList.add('hidden')},300),i.className='ph ph-list text-xl');}
document.addEventListener('keydown',function(e){if(e.key==='Escape'){var m=document.getElementById('mobileMenu');if(m&&!m.classList.contains('hidden'))toggleMobileMenu();}});
window.addEventListener('scroll',function(){var h=document.getElementById('mainHeader');if(!h)return;h.style.boxShadow=window.scrollY>20?'0 1px 8px rgba(0,0,0,0.04)':'none';});
</script>
