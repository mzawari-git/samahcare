@php
    // تحميل الأقسام للهيدر (لو لم تكن متوفرة من الكنترولر)
    if (!isset($headerCategories)) {
        $headerCategories = \App\Models\Category::active()
            ->withCount(['products' => fn($q) => $q->where('is_active', true)])
            ->having('products_count', '>', 0)
            ->orderBy('sort_order')
            ->get()
            ->map(function($cat) {
                // استخراج الاسم العربي فقط من name_ar
                $arName = preg_replace('/[a-zA-Z&\-\(\)]+/', '', $cat->name_ar);
                $arName = preg_replace('/\s{2,}/', ' ', trim($arName));
                $cat->ar_label = !empty($arName) ? $arName : $cat->name_ar;
                return $cat;
            });
    }
@endphp

{{-- شريط الإعلانات الصغير --}}
<div class="bg-ink text-white text-xs py-2.5 text-center tracking-wide font-light" id="announcementBar">
    <div class="flex justify-center items-center gap-3">
        <i class="ph-fill ph-sparkle text-brand-400 text-sm"></i>
        <span>شحن مجاني للطلبات فوق {{ $siteSettings['free_shipping_min'] ?? '200' }} شيكل</span>
        <span class="text-gray-600">|</span>
        <span>خصم 10% على أول طلب</span>
        <i class="ph-fill ph-sparkle text-brand-400 text-sm"></i>
    </div>
</div>

{{-- الرأس العائم (Sticky Glass Header) --}}
<header class="fixed top-[36px] w-full z-50 transition-all duration-300 glass" id="mainHeaderV2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- الصف العلوي: بحث - شعار - أيقونات --}}
        <div class="flex justify-between items-center h-16">
            
            {{-- اليمين: البحث + قائمة الموبايل --}}
            <div class="flex items-center gap-2 w-1/3">
                <button onclick="toggleSearchV2()" class="text-ink/70 hover:text-brand-500 transition-colors p-2 rounded-full hover:bg-brand-50" title="بحث">
                    <i class="ph ph-magnifying-glass text-xl"></i>
                </button>
                <button onclick="toggleMobileMenuV2()" class="md:hidden text-ink/70 p-2 rounded-full hover:bg-gray-100">
                    <i class="ph ph-list text-xl" id="mobileMenuIconV2"></i>
                </button>
            </div>

            {{-- المنتصف: الشعار --}}
            <div class="flex-shrink-0 w-1/3 text-center">
                <a href="{{ route('home') }}" class="group inline-flex items-center gap-3">
                    @if(!empty($siteSettings['site_logo_url']))
                        <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name'] ?? 'JeniCare' }}" class="h-12 w-auto object-contain">
                    @endif
                    <span class="text-2xl font-extrabold tracking-tight text-ink group-hover:text-brand-500 transition-colors">{{ $siteSettings['site_name_ar'] ?? $siteSettings['site_name'] ?? 'JeniCare' }}<span class="text-brand-500">.</span></span>
                </a>
            </div>

            {{-- اليسار: الحساب + السلة --}}
            <div class="flex items-center justify-end gap-2 w-1/3">
                @auth
                <div class="hidden md:flex items-center gap-2 text-sm font-medium text-ink/70 hover:text-brand-500 transition-colors px-3 py-1.5 rounded-full hover:bg-brand-50 relative group cursor-pointer">
                    <i class="ph ph-user-circle text-lg"></i>
                    <span class="text-xs">{{ Str::limit(Auth::user()->name, 10) }}</span>
                    {{-- User dropdown --}}
                    <div class="absolute top-full left-0 mt-2 w-52 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-[100]">
                        @if(Auth::user()->isAdmin())
                        <a href="{{ url('/admin') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-brand-600 font-semibold hover:bg-brand-50 transition-colors">
                            <i class="ph ph-gear-six text-base"></i> لوحة التحكم
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        @endif
                        <a href="{{ route('account') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-ink hover:bg-brand-50 transition-colors">
                            <i class="ph ph-user-circle text-base"></i> حسابي
                        </a>
                        <a href="{{ route('orders') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-ink hover:bg-brand-50 transition-colors">
                            <i class="ph ph-package text-base"></i> طلباتي
                        </a>
                        <a href="{{ route('wishlist') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-ink hover:bg-brand-50 transition-colors">
                            <i class="ph ph-heart text-base"></i> المفضلة
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors w-full">
                                <i class="ph ph-sign-out text-base"></i> خروج
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="hidden md:flex items-center gap-1.5 text-xs font-medium text-ink/70 hover:text-brand-500 transition-colors px-3 py-1.5 rounded-full hover:bg-brand-50">
                    <i class="ph ph-user text-lg"></i>
                    <span>حسابي</span>
                </a>
                @endauth
                <a href="{{ route('cart') }}" class="relative p-2 text-ink/70 hover:text-brand-500 transition-colors" title="السلة">
                    <i class="ph ph-shopping-bag text-xl"></i>
                    <span class="absolute -top-0.5 -right-0.5 bg-brand-500 text-white text-[9px] font-bold h-4 w-4 rounded-full flex items-center justify-center" id="cart-count">{{ $cartCount ?? 0 }}</span>
                </a>
            </div>
        </div>

        {{-- القائمة السفلية - أسماء الأقسام بالعربي --}}
        <nav class="hidden md:block border-t border-gray-100/60 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center items-center py-2.5 overflow-x-auto hide-scroll">
                <ul class="flex items-center gap-1">
                    <li>
                        <a href="{{ route('home') }}" class="px-4 py-1.5 rounded-full text-[13px] font-semibold transition-all duration-200 {{ request()->routeIs('home') ? 'bg-ink text-white' : 'text-gray-600 hover:bg-brand-50 hover:text-brand-600' }}">
                            الرئيسية
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shop') }}" class="px-4 py-1.5 rounded-full text-[13px] font-semibold transition-all duration-200 {{ request()->routeIs('shop') ? 'bg-ink text-white' : 'text-gray-600 hover:bg-brand-50 hover:text-brand-600' }}">
                            المتجر
                        </a>
                    </li>
                    @foreach($headerCategories->take(5) as $cat)
                    <li>
                        <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="px-4 py-1.5 rounded-full text-[13px] font-medium transition-all duration-200 text-gray-500 hover:bg-brand-50 hover:text-brand-600 whitespace-nowrap">
                            {{ $cat->ar_label }}
                        </a>
                    </li>
                    @endforeach
                    <li>
                        <a href="{{ route('b2b') }}" class="px-4 py-1.5 rounded-full text-[13px] font-semibold transition-all duration-200 flex items-center gap-1 {{ request()->routeIs('b2b') ? 'bg-ink text-white' : 'text-gray-600 hover:bg-brand-50 hover:text-brand-600' }}">
                            <i class="ph-fill ph-crown text-brand-500 text-xs"></i> للأعمال
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="px-4 py-1.5 rounded-full text-[13px] font-semibold transition-all duration-200 {{ request()->routeIs('contact') ? 'bg-ink text-white' : 'text-gray-600 hover:bg-brand-50 hover:text-brand-600' }}">
                            تواصل معنا
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

{{-- شريط البحث المنبثق --}}
<div id="searchOverlayV2" class="fixed inset-0 bg-black/50 z-[60] hidden items-start justify-center pt-32">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl mx-4 p-6 relative">
        <button onclick="toggleSearchV2()" class="absolute top-4 left-4 text-gray-400 hover:text-ink transition-colors">
            <i class="ph ph-x text-xl"></i>
        </button>
        <form action="{{ route('shop') }}" method="GET" class="flex items-center gap-3">
            <div class="flex-1 relative">
                <i class="ph ph-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
                <input type="text" name="search" placeholder="ابحثي عن منتجات العناية..." value="{{ request('search') }}" class="w-full bg-surface border border-gray-200 text-ink py-4 pr-12 pl-4 rounded-xl focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all text-sm" autofocus>
            </div>
            <button type="submit" class="bg-ink text-white py-4 px-6 rounded-xl font-medium hover:bg-brand-600 transition-colors">
                بحث
            </button>
        </form>
    </div>
</div>

{{-- قائمة الموبايل --}}
<div id="mobileMenuV2" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black/50" onclick="toggleMobileMenuV2()"></div>
    <div class="absolute top-0 right-0 w-[300px] h-full bg-white shadow-2xl transform translate-x-full transition-transform duration-300" id="mobileMenuPanelV2">
        <div class="p-6">
            {{-- Close button --}}
            <div class="flex justify-between items-center mb-8">
                <span class="text-2xl font-extrabold text-ink">{{ $siteSettings['site_name'] ?? 'JeniCare' }}<span class="text-brand-500">.</span></span>
                <button onclick="toggleMobileMenuV2()" class="text-gray-400 hover:text-ink transition-colors">
                    <i class="ph ph-x text-2xl"></i>
                </button>
            </div>

            {{-- Search --}}
            <form action="{{ route('shop') }}" method="GET" class="mb-6">
                <div class="relative">
                    <i class="ph ph-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" placeholder="ابحثي..." class="w-full bg-surface border border-gray-200 py-3 pr-10 pl-4 rounded-xl text-sm focus:outline-none focus:border-brand-500">
                </div>
            </form>

            {{-- Navigation links --}}
            <nav class="space-y-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-ink font-medium {{ request()->routeIs('home') ? 'bg-brand-50 text-brand-600' : 'hover:bg-gray-50' }} transition-colors">
                    <i class="ph ph-house text-xl"></i> الرئيسية
                </a>
                <a href="{{ route('shop') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-ink font-medium {{ request()->routeIs('shop') ? 'bg-brand-50 text-brand-600' : 'hover:bg-gray-50' }} transition-colors">
                    <i class="ph ph-storefront text-xl"></i> المتجر
                </a>
                @foreach($headerCategories->take(6) as $cat)
                <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 font-medium hover:bg-gray-50 transition-colors">
                    <i class="ph ph-tag text-xl"></i> {{ $cat->ar_label }}
                </a>
                @endforeach
                <a href="{{ route('b2b') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-ink font-medium {{ request()->routeIs('b2b') ? 'bg-brand-50 text-brand-600' : 'hover:bg-gray-50' }} transition-colors">
                    <i class="ph ph-buildings text-xl"></i> للأعمال
                </a>
                <a href="{{ route('contact') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-ink font-medium {{ request()->routeIs('contact') ? 'bg-brand-50 text-brand-600' : 'hover:bg-gray-50' }} transition-colors">
                    <i class="ph ph-envelope text-xl"></i> تواصل معنا
                </a>
            </nav>

            {{-- Divider --}}
            <div class="border-t border-gray-100 my-6"></div>

            {{-- Account section --}}
            @auth
            <div class="space-y-1">
                <a href="{{ route('account') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-ink font-medium hover:bg-gray-50 transition-colors">
                    <i class="ph ph-user-circle text-xl"></i> حسابي
                </a>
                <a href="{{ route('orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-ink font-medium hover:bg-gray-50 transition-colors">
                    <i class="ph ph-package text-xl"></i> طلباتي
                </a>
                <a href="{{ route('wishlist') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-ink font-medium hover:bg-gray-50 transition-colors">
                    <i class="ph ph-heart text-xl"></i> المفضلة
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 font-medium hover:bg-red-50 transition-colors w-full">
                        <i class="ph ph-sign-out text-xl"></i> تسجيل الخروج
                    </button>
                </form>
            </div>
            @else
            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 bg-ink text-white py-3 rounded-xl font-medium hover:bg-brand-600 transition-colors">
                <i class="ph ph-user text-xl"></i> تسجيل الدخول
            </a>
            @endauth
        </div>
    </div>
</div>

<script>
// Search overlay toggle
function toggleSearchV2() {
    const overlay = document.getElementById('searchOverlayV2');
    if (overlay.classList.contains('hidden')) {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        overlay.querySelector('input')?.focus();
    } else {
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
    }
}
document.getElementById('searchOverlayV2')?.addEventListener('click', function(e) {
    if (e.target === this) toggleSearchV2();
});

// Mobile menu toggle
function toggleMobileMenuV2() {
    const menu = document.getElementById('mobileMenuV2');
    const panel = document.getElementById('mobileMenuPanelV2');
    const icon = document.getElementById('mobileMenuIconV2');
    
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        setTimeout(() => {
            panel.style.transform = 'translateX(0)';
        }, 10);
        icon.className = 'ph ph-x text-2xl';
    } else {
        panel.style.transform = 'translateX(100%)';
        setTimeout(() => {
            menu.classList.add('hidden');
        }, 300);
        icon.className = 'ph ph-list text-2xl';
    }
}

// Header scroll behavior
window.addEventListener('scroll', function() {
    const header = document.getElementById('mainHeaderV2');
    const bar = document.getElementById('announcementBar');
    if (!header) return;
    
    if (window.scrollY > 60) {
        header.style.top = '0';
        header.classList.add('shadow-lg');
    } else {
        header.style.top = bar ? bar.offsetHeight + 'px' : '32px';
        header.classList.remove('shadow-lg');
    }
});

// User dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
    const userDropdown = document.querySelector('.group.cursor-pointer');
    const dropdownMenu = userDropdown?.querySelector('.absolute');
    
    if (userDropdown && dropdownMenu) {
        // Toggle dropdown on click
        userDropdown.addEventListener('click', function(e) {
            if (e.target.closest('form')) return; // Don't interfere with logout form
            
            const isVisible = dropdownMenu.classList.contains('opacity-100');
            if (isVisible) {
                dropdownMenu.classList.remove('opacity-100', 'visible');
                dropdownMenu.classList.add('opacity-0', 'invisible');
            } else {
                dropdownMenu.classList.remove('opacity-0', 'invisible');
                dropdownMenu.classList.add('opacity-100', 'visible');
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdown.contains(e.target)) {
                dropdownMenu.classList.remove('opacity-100', 'visible');
                dropdownMenu.classList.add('opacity-0', 'invisible');
            }
        });
        
        // Prevent dropdown from closing when clicking inside
        dropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});

// Escape key closes overlays
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const search = document.getElementById('searchOverlayV2');
        if (!search.classList.contains('hidden')) toggleSearchV2();
        const menu = document.getElementById('mobileMenuV2');
        if (!menu.classList.contains('hidden')) toggleMobileMenuV2();
        
        // Close dropdown on escape
        const dropdownMenu = document.querySelector('.group.cursor-pointer .absolute');
        if (dropdownMenu && dropdownMenu.classList.contains('opacity-100')) {
            dropdownMenu.classList.remove('opacity-100', 'visible');
            dropdownMenu.classList.add('opacity-0', 'invisible');
        }
    }
});
</script>
