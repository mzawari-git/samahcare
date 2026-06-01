<header class="fixed w-full top-0 z-50 t1-glass-header" id="t1Navbar">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <div class="w-12 h-12 rounded-full flex items-center justify-center border-2 transition-all duration-300" style="background: var(--brand-50); border-color: var(--brand-500);">
                @if(!empty($siteSettings['site_logo_url']))
                    <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name'] ?? 'سماح كير' }}" class="h-8 w-8 object-contain rounded-full">
                @else
                    <span class="text-2xl font-bold" style="color: var(--brand-500); font-family: var(--font-en);">S</span>
                @endif
            </div>
            <div class="flex flex-col leading-tight">
                <span class="text-2xl font-bold t1-text-gradient tracking-wide">{{ $siteSettings['site_name'] ?? 'سماح' }}</span>
                <span class="text-xs text-gray-500 uppercase tracking-widest" style="font-family: var(--font-en);">Beauty Clinic</span>
            </div>
        </a>

        <nav class="hidden md:flex items-center gap-8 font-medium" style="color: var(--ink);">
            <a href="{{ route('home') }}" class="t1-nav-link hover:text-[var(--brand-500)] transition-colors">الرئيسية</a>
            <a href="{{ route('booking') }}" class="t1-nav-link hover:text-[var(--brand-500)] transition-colors">المتجر</a>
            <a href="{{ route('blog.index') }}" class="t1-nav-link hover:text-[var(--brand-500)] transition-colors">المدونة</a>
            <a href="{{ route('contact') }}" class="t1-nav-link hover:text-[var(--brand-500)] transition-colors">تواصلي</a>
            <a href="{{ route('booking') }}" class="t1-btn-primary px-6 py-2.5 rounded-full font-bold">احجزي موعدك</a>
        </nav>

        <button class="md:hidden text-2xl focus:outline-none" style="color: var(--brand-500);" onclick="document.getElementById('t1MobileMenu').classList.toggle('hidden')">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="md:hidden hidden absolute w-full bg-white border-b shadow-lg" id="t1MobileMenu" style="border-color: rgba(183, 110, 121, 0.2);">
        <div class="flex flex-col px-6 py-4 gap-4 text-center">
            <a href="{{ route('home') }}" class="block py-2 hover:text-[var(--brand-500)]" style="color: var(--ink);">الرئيسية</a>
            <a href="{{ route('booking') }}" class="block py-2 hover:text-[var(--brand-500)]" style="color: var(--ink);">المتجر</a>
            <a href="{{ route('blog.index') }}" class="block py-2 hover:text-[var(--brand-500)]" style="color: var(--ink);">المدونة</a>
            <a href="{{ route('contact') }}" class="block py-2 hover:text-[var(--brand-500)]" style="color: var(--ink);">تواصلي</a>
            <a href="{{ route('booking') }}" class="block py-3 mt-2 t1-btn-primary rounded-full font-bold">احجزي موعدك</a>
        </div>
    </div>
</header>

<script>
window.addEventListener('scroll', function() {
    var navbar = document.getElementById('t1Navbar');
    if (!navbar) return;
    if (window.scrollY > 50) {
        navbar.style.boxShadow = '0 4px 20px rgba(183, 110, 121, 0.1)';
        navbar.style.background = 'rgba(255, 255, 255, 0.95)';
    } else {
        navbar.style.boxShadow = 'none';
        navbar.style.background = 'rgba(255, 255, 255, 0.85)';
    }
});
</script>
