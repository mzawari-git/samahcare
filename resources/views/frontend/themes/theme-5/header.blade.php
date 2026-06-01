<header class="fixed w-full top-0 z-50 t5-panel" id="t5Navbar" style="border-bottom: 1px solid rgba(226, 232, 240, 0.8);">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <div class="w-11 h-11 flex items-center justify-center" style="background: var(--neutral-900); clip-path: polygon(0 0, 100% 0, 100% calc(100% - 8px), calc(100% - 8px) 100%, 0 100%);">
                @if(!empty($siteSettings['site_logo_url']))
                    <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name'] ?? 'سماح كير' }}" class="h-7 w-7 object-contain">
                @else
                    <i class="fas fa-microchip text-lg" style="color: var(--accent-400);"></i>
                @endif
            </div>
            <div class="flex flex-col leading-tight">
                <span class="text-xl font-bold" style="color: var(--ink);">{{ $siteSettings['site_name'] ?? 'سماح' }}</span>
                <span class="t5-tech-label" style="font-size: 0.6rem;">Clinic Sys_</span>
            </div>
        </a>

        <nav class="hidden md:flex items-center gap-1 px-6 py-2 t5-panel" style="border-radius: var(--radius-lg);">
            <a href="{{ route('home') }}" class="t5-nav-link px-4 py-2 font-medium text-sm">الرئيسية</a>
            <a href="{{ route('booking') }}" class="t5-nav-link px-4 py-2 font-medium text-sm">المتجر</a>
            <a href="{{ route('blog.index') }}" class="t5-nav-link px-4 py-2 font-medium text-sm">المدونة</a>
            <a href="{{ route('contact') }}" class="t5-nav-link px-4 py-2 font-medium text-sm">تواصلي</a>
            <a href="{{ route('faq') }}" class="t5-nav-link px-4 py-2 font-medium text-sm">الأسئلة</a>
        </nav>

        <div class="hidden md:flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-sm font-medium" style="color: var(--ink-muted);">
                <i class="fas fa-user-lock ml-1"></i> دخول
            </a>
            <a href="{{ route('booking') }}" class="t5-btn-tech text-sm" style="padding: 10px 24px;">
                <i class="fas fa-calendar-check"></i> احجزي موعدك
            </a>
        </div>

        <button class="md:hidden text-xl focus:outline-none" style="color: var(--ink);" onclick="document.getElementById('t5MobileMenu').classList.toggle('hidden')">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="md:hidden hidden absolute w-full t5-bg-grid" id="t5MobileMenu" style="background-color: var(--surface-elevated); border-bottom: 1px solid var(--neutral-100);">
        <div class="flex flex-col px-6 py-6 gap-1">
            <a href="{{ route('home') }}" class="block py-3 px-4 font-medium hover:bg-[rgba(0,229,255,0.05)] transition-colors" style="color: var(--ink); border-right: 2px solid transparent;" onmouseover="this.style.borderRightColor='var(--accent-400)'" onmouseout="this.style.borderRightColor='transparent'">الرئيسية</a>
            <a href="{{ route('booking') }}" class="block py-3 px-4 font-medium hover:bg-[rgba(0,229,255,0.05)] transition-colors" style="color: var(--ink); border-right: 2px solid transparent;" onmouseover="this.style.borderRightColor='var(--accent-400)'" onmouseout="this.style.borderRightColor='transparent'">المتجر</a>
            <a href="{{ route('blog.index') }}" class="block py-3 px-4 font-medium hover:bg-[rgba(0,229,255,0.05)] transition-colors" style="color: var(--ink); border-right: 2px solid transparent;" onmouseover="this.style.borderRightColor='var(--accent-400)'" onmouseout="this.style.borderRightColor='transparent'">المدونة</a>
            <a href="{{ route('contact') }}" class="block py-3 px-4 font-medium hover:bg-[rgba(0,229,255,0.05)] transition-colors" style="color: var(--ink); border-right: 2px solid transparent;" onmouseover="this.style.borderRightColor='var(--accent-400)'" onmouseout="this.style.borderRightColor='transparent'">تواصلي</a>
            <a href="{{ route('faq') }}" class="block py-3 px-4 font-medium hover:bg-[rgba(0,229,255,0.05)] transition-colors" style="color: var(--ink); border-right: 2px solid transparent;" onmouseover="this.style.borderRightColor='var(--accent-400)'" onmouseout="this.style.borderRightColor='transparent'">الأسئلة</a>
            <div class="t5-divider-gradient my-3"></div>
            <a href="{{ route('login') }}" class="block py-3 px-4 font-medium" style="color: var(--ink-muted);"><i class="fas fa-user-lock ml-2"></i> دخول</a>
            <a href="{{ route('booking') }}" class="t5-btn-tech mt-3 text-center" style="padding: 12px 24px;">
                <i class="fas fa-calendar-check"></i> احجزي موعدك
            </a>
        </div>
    </div>
</header>

<script>
window.addEventListener('scroll', function() {
    var navbar = document.getElementById('t5Navbar');
    if (!navbar) return;
    if (window.scrollY > 50) {
        navbar.style.boxShadow = '0 4px 20px rgba(0, 85, 255, 0.08)';
        navbar.style.background = 'rgba(255, 255, 255, 0.97)';
    } else {
        navbar.style.boxShadow = 'none';
        navbar.style.background = 'rgba(255, 255, 255, 0.9)';
    }
});
</script>
