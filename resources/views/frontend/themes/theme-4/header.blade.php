<header class="fixed w-full top-0 z-50 pt-4 px-4" id="t4Header">
    <div class="max-w-6xl mx-auto">
        <div class="t4-pill-header px-6 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: var(--brand-50);">
                    <i class="fas fa-leaf text-lg" style="color: var(--brand-500);"></i>
                </div>
                <div class="flex flex-col leading-tight">
                    <span class="text-xl font-bold" style="color: var(--brand-800);">{{ $siteSettings['site_name'] ?? 'وادي سلامة' }}</span>
                    <span class="text-[10px] uppercase tracking-widest" style="color: var(--ink-dim); font-family: var(--font-en);">Nature Wellness</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8 font-medium text-sm" style="color: var(--ink);">
                <a href="{{ route('home') }}" class="t4-nav-link hover:text-[var(--brand-500)]">الرئيسية</a>
                <a href="{{ route('booking') }}" class="t4-nav-link hover:text-[var(--brand-500)]">خدماتنا</a>
                <a href="{{ route('blog.index') }}" class="t4-nav-link hover:text-[var(--brand-500)]">المدونة</a>
                <a href="{{ route('faq') }}" class="t4-nav-link hover:text-[var(--brand-500)]">الأسئلة الشائعة</a>
                <a href="{{ route('contact') }}" class="t4-nav-link hover:text-[var(--brand-500)]">تواصل معنا</a>
            </nav>

            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-medium hover:text-[var(--brand-500)] transition-colors" style="color: var(--ink-muted);">
                    <i class="fas fa-user-circle ml-1"></i> دخول
                </a>
                <a href="{{ route('booking') }}" class="t4-btn-nature text-sm !py-2.5 !px-6">
                    <i class="fas fa-calendar-check"></i> احجز الآن
                </a>
            </div>

            <button class="md:hidden text-xl focus:outline-none" style="color: var(--brand-800);" onclick="document.getElementById('t4MobileMenu').classList.toggle('t4-mobile-open')" id="t4MenuBtn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <div class="fixed inset-0 z-[999] pointer-events-none t4-mobile-overlay" id="t4MobileMenu" style="opacity: 0; transition: opacity 0.3s ease;">
        <div class="absolute inset-0" style="background: rgba(30, 46, 31, 0.95);" onclick="document.getElementById('t4MobileMenu').classList.remove('t4-mobile-open'); document.getElementById('t4MobileMenu').style.opacity='0'; document.getElementById('t4MobileMenu').style.pointerEvents='none';"></div>
        <div class="relative h-full flex flex-col items-center justify-center gap-8">
            <button class="absolute top-6 left-6 text-white text-2xl" onclick="document.getElementById('t4MobileMenu').classList.remove('t4-mobile-open'); document.getElementById('t4MobileMenu').style.opacity='0'; document.getElementById('t4MobileMenu').style.pointerEvents='none';">
                <i class="fas fa-times"></i>
            </button>
            <a href="{{ route('home') }}" class="text-white text-2xl font-bold hover:text-[var(--brand-300)] transition-colors" onclick="document.getElementById('t4MobileMenu').classList.remove('t4-mobile-open'); document.getElementById('t4MobileMenu').style.opacity='0'; document.getElementById('t4MobileMenu').style.pointerEvents='none';">الرئيسية</a>
            <a href="{{ route('booking') }}" class="text-white text-2xl font-bold hover:text-[var(--brand-300)] transition-colors" onclick="document.getElementById('t4MobileMenu').classList.remove('t4-mobile-open'); document.getElementById('t4MobileMenu').style.opacity='0'; document.getElementById('t4MobileMenu').style.pointerEvents='none';">خدماتنا</a>
            <a href="{{ route('blog.index') }}" class="text-white text-2xl font-bold hover:text-[var(--brand-300)] transition-colors" onclick="document.getElementById('t4MobileMenu').classList.remove('t4-mobile-open'); document.getElementById('t4MobileMenu').style.opacity='0'; document.getElementById('t4MobileMenu').style.pointerEvents='none';">المدونة</a>
            <a href="{{ route('faq') }}" class="text-white text-2xl font-bold hover:text-[var(--brand-300)] transition-colors" onclick="document.getElementById('t4MobileMenu').classList.remove('t4-mobile-open'); document.getElementById('t4MobileMenu').style.opacity='0'; document.getElementById('t4MobileMenu').style.pointerEvents='none';">الأسئلة الشائعة</a>
            <a href="{{ route('contact') }}" class="text-white text-2xl font-bold hover:text-[var(--brand-300)] transition-colors" onclick="document.getElementById('t4MobileMenu').classList.remove('t4-mobile-open'); document.getElementById('t4MobileMenu').style.opacity='0'; document.getElementById('t4MobileMenu').style.pointerEvents='none';">تواصل معنا</a>
            <a href="{{ route('booking') }}" class="t4-btn-nature mt-4 !px-10 !py-4 text-lg" onclick="document.getElementById('t4MobileMenu').classList.remove('t4-mobile-open'); document.getElementById('t4MobileMenu').style.opacity='0'; document.getElementById('t4MobileMenu').style.pointerEvents='none';">
                <i class="fas fa-calendar-check"></i> احجز الآن
            </a>
        </div>
    </div>
</header>

<script>
(function() {
    var menu = document.getElementById('t4MobileMenu');
    var observer = new MutationObserver(function() {
        if (menu.classList.contains('t4-mobile-open')) {
            menu.style.opacity = '1';
            menu.style.pointerEvents = 'auto';
        } else {
            menu.style.opacity = '0';
            menu.style.pointerEvents = 'none';
        }
    });
    observer.observe(menu, { attributes: true, attributeFilter: ['class'] });

    window.addEventListener('scroll', function() {
        var header = document.getElementById('t4Header');
        if (!header) return;
        var pill = header.querySelector('.t4-pill-header');
        if (window.scrollY > 50) {
            pill.style.boxShadow = '0 8px 32px rgba(44, 62, 45, 0.12)';
            pill.style.background = 'rgba(244, 241, 237, 0.95)';
        } else {
            pill.style.boxShadow = 'none';
            pill.style.background = 'rgba(244, 241, 237, 0.8)';
        }
    });
})();
</script>
