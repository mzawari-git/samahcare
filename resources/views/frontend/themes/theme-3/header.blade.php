<div class="t3-marquee">
    <div class="t3-marquee-inner">
        <span>Pure Beauty</span>
        <span>·</span>
        <span>Advanced Laser Technology</span>
        <span>·</span>
        <span>Expert Care</span>
        <span>·</span>
        <span>Natural Results</span>
        <span>·</span>
        <span>FDA Approved</span>
        <span>·</span>
        <span>Book Your Session Today</span>
        <span>·</span>
        <span>Pure Beauty</span>
        <span>·</span>
        <span>Advanced Laser Technology</span>
        <span>·</span>
        <span>Expert Care</span>
        <span>·</span>
        <span>Natural Results</span>
        <span>·</span>
        <span>FDA Approved</span>
        <span>·</span>
        <span>Book Your Session Today</span>
        <span>·</span>
    </div>
</div>

<header class="t3-header fixed w-full z-50" id="t3Header" style="top: 37px;">
    <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
        <button class="text-xl focus:outline-none" style="color: var(--ink);" onclick="document.getElementById('t3MenuOverlay').classList.add('active'); document.body.style.overflow='hidden';">
            <i class="fas fa-bars"></i>
        </button>

        <a href="{{ route('home') }}" class="absolute left-1/2 transform -translate-x-1/2" style="font-family: var(--font-en); font-size: 1.5rem; font-weight: 300; letter-spacing: 6px; color: var(--ink);">
            SAMAH
        </a>

        <a href="{{ route('booking') }}" class="text-sm font-light" style="color: var(--ink); letter-spacing: 0.5px;">احجز موعداً</a>
    </div>
</header>

<div class="t3-menu-overlay" id="t3MenuOverlay">
    <button class="absolute top-6 right-6 text-3xl text-white focus:outline-none" onclick="document.getElementById('t3MenuOverlay').classList.remove('active'); document.body.style.overflow='';">
        <i class="fas fa-times"></i>
    </button>
    <nav class="text-center">
        <a href="{{ route('home') }}" onclick="document.getElementById('t3MenuOverlay').classList.remove('active'); document.body.style.overflow='';">الرئيسية</a>
        <a href="{{ route('booking') }}" onclick="document.getElementById('t3MenuOverlay').classList.remove('active'); document.body.style.overflow='';">المتجر</a>
        <a href="{{ route('blog.index') }}" onclick="document.getElementById('t3MenuOverlay').classList.remove('active'); document.body.style.overflow='';">المدونة</a>
        <a href="{{ route('contact') }}" onclick="document.getElementById('t3MenuOverlay').classList.remove('active'); document.body.style.overflow='';">تواصلي</a>
        <a href="{{ route('faq') }}" onclick="document.getElementById('t3MenuOverlay').classList.remove('active'); document.body.style.overflow='';">الأسئلة الشائعة</a>
        <a href="{{ route('login') }}" onclick="document.getElementById('t3MenuOverlay').classList.remove('active'); document.body.style.overflow='';">تسجيل الدخول</a>
    </nav>
</div>

<script>
window.addEventListener('scroll', function() {
    var header = document.getElementById('t3Header');
    if (!header) return;
    if (window.scrollY > 80) {
        header.style.top = '0';
        header.style.boxShadow = 'var(--shadow-sm)';
    } else {
        header.style.top = '37px';
        header.style.boxShadow = 'none';
    }
});
</script>
