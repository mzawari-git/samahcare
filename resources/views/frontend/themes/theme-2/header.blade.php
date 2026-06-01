<header class="fixed w-full top-0 z-50 t2-header" id="t2Header">
    <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            @if(!empty($siteSettings['site_logo_url']))
                <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name'] ?? 'سماح كير' }}" class="h-10 w-10 object-contain">
            @endif
            <div class="flex flex-col leading-tight">
                <span class="text-3xl font-bold tracking-wider" style="font-family: var(--font-en); color: var(--brand-500);">SAMAH</span>
                <span class="text-xs tracking-widest" style="color: var(--ink-muted);">{{ $siteSettings['site_name'] ?? 'سماح كير' }}</span>
            </div>
        </a>

        <nav class="hidden lg:flex items-center gap-10">
            <a href="{{ route('home') }}" class="t2-nav-link">الرئيسية</a>
            <a href="{{ route('booking') }}" class="t2-nav-link">المتجر</a>
            <a href="{{ route('blog.index') }}" class="t2-nav-link">المدونة</a>
            <a href="{{ route('faq') }}" class="t2-nav-link">الأسئلة الشائعة</a>
            <a href="{{ route('contact') }}" class="t2-nav-link">تواصلي</a>
            <a href="{{ route('booking') }}" class="t2-btn-luxury">احجزي موعدك</a>
        </nav>

        <button class="lg:hidden text-2xl focus:outline-none" style="color: var(--brand-500);" id="t2MenuOpen" aria-label="فتح القائمة">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

<div class="t2-fullscreen-menu" id="t2FullscreenMenu">
    <button class="absolute top-6 left-6 text-3xl text-white focus:outline-none" id="t2MenuClose" aria-label="إغلاق القائمة">
        <i class="fas fa-times"></i>
    </button>
    <a href="{{ route('home') }}" onclick="closeT2Menu()">الرئيسية</a>
    <a href="{{ route('booking') }}" onclick="closeT2Menu()">المتجر</a>
    <a href="{{ route('blog.index') }}" onclick="closeT2Menu()">المدونة</a>
    <a href="{{ route('faq') }}" onclick="closeT2Menu()">الأسئلة الشائعة</a>
    <a href="{{ route('contact') }}" onclick="closeT2Menu()">تواصلي</a>
    <div class="mt-8">
        <a href="{{ route('booking') }}" class="t2-btn-luxury" onclick="closeT2Menu()">احجزي موعدك</a>
    </div>
    <div class="flex gap-6 mt-8">
        @if(!empty($siteSettings['instagram_url']))
        <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="text-white hover:text-[var(--accent-400)] transition-colors"><i class="fab fa-instagram text-xl"></i></a>
        @endif
        @if(!empty($siteSettings['facebook_url']))
        <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="text-white hover:text-[var(--accent-400)] transition-colors"><i class="fab fa-facebook-f text-xl"></i></a>
        @endif
        @if(!empty($siteSettings['tiktok_url']))
        <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="text-white hover:text-[var(--accent-400)] transition-colors"><i class="fab fa-tiktok text-xl"></i></a>
        @endif
    </div>
</div>

<script>
(function() {
    var header = document.getElementById('t2Header');
    var menuOpen = document.getElementById('t2MenuOpen');
    var menuClose = document.getElementById('t2MenuClose');
    var fullscreenMenu = document.getElementById('t2FullscreenMenu');

    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    menuOpen.addEventListener('click', function() {
        fullscreenMenu.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    menuClose.addEventListener('click', function() {
        closeT2Menu();
    });
})();

function closeT2Menu() {
    var fullscreenMenu = document.getElementById('t2FullscreenMenu');
    fullscreenMenu.classList.remove('active');
    document.body.style.overflow = '';
}
</script>
