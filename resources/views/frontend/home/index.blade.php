@extends($layoutPath)

@section('title', ($siteSettings['site_name'] ?? 'سماح كير ') . ' | منصة الحجز والخدمات الجمالية')
@section('meta_description', 'سماح كير - وجهتك الأولى لحجز خدمات العناية بالبشرة والشعر والتجميل. احجزي موعدك الآن بسهولة.')
@section('meta_keywords', 'سماح كير, حجز موعد, عناية بالبشرة, عناية بالشعر, خدمات تجميل, فلسطين, صالون, جمال')

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "{{ $siteSettings['site_name'] ?? 'سماح كير ' }}",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('assets/images/logo.png') }}",
  "description": "منصة حجز خدمات التجميل والعناية بالبشرة",
  "address": { "@type": "PostalAddress", "addressLocality": "رام الله", "addressCountry": "PS" },
  "contactPoint": { "@type": "ContactPoint", "telephone": "{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}", "contactType": "customer service" },
  "sameAs": ["{{ $siteSettings['facebook_url'] ?? '#' }}", "{{ $siteSettings['instagram_url'] ?? '#' }}"]
}
</script>
@endpush

@section('content')

@php
$heroHeadlines = [
    ['line1' => 'خدمات احترافية', 'line2' => 'جمال لا يُقاوم.'],
    ['line1' => 'بشرتكِ تستحق الأفضل', 'line2' => 'اختاري من سماح كير.'],
    ['line1' => 'أحدث تقنيات التجميل', 'line2' => 'بين يديكِ الآن.'],
    ['line1' => 'تقنيات متطورة', 'line2' => 'نتائج احترافية.'],
    ['line1' => 'جودة عالمية', 'line2' => 'خدمة محلية.'],
    ['line1' => 'احجزي موعدك', 'line2' => 'بسهولة تامة.'],
];

$heroPhrases = [
    'لمسات ساحرة تبدأ باختيار الخدمة المثالية... اختاري الأفضل مع سماح كير.',
    'أحدث تقنيات التجميل بين يديكِ، لنتائج احترافية تبهركِ.',
    'كل ما يخص عالم الجمال والأناقة... تحت سقف واحد.',
    'إشراقة وردية تلفت الأنظار.. بلمسات احترافية من سماح كير.',
    'بشرة نضرة، شعر صحي، إطلالة ساحرة... كل هذا وأكثر مع سماح كير.',
    'نحنُ لسنا مجرد صالون.. نحنُ وجهتكِ الشاملة لعالم الجمال.',
];
@endphp

{{-- ═══════════════════════════════════════════════════════════════
     HERO SECTION
     ═══════════════════════════════════════════════════════════════ --}}
<section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0" style="background:var(--surface);"></div>
        <div class="absolute inset-0 opacity-20" style="background:radial-gradient(ellipse at 20% 20%, var(--brand-500) 0%, transparent 60%),radial-gradient(ellipse at 80% 80%, var(--accent-500, #c026d3) 0%, transparent 60%);"></div>
        <div class="absolute inset-0" style="background-image:radial-gradient(circle at 50% 50%, rgba(255,255,255,0.02) 0px, transparent 1px);background-size:32px 32px;"></div>
    </div>

    <div class="absolute w-96 h-96 rounded-full pointer-events-none z-0" style="background:radial-gradient(circle, rgba(236,72,153,0.06), transparent 70%);top:-10%;right:-5%;filter:blur(80px);animation:heroOrbA 12s ease-in-out infinite;"></div>
    <div class="absolute w-[30rem] h-[30rem] rounded-full pointer-events-none z-0" style="background:radial-gradient(circle, rgba(192,38,211,0.04), transparent 70%);bottom:-20%;left:-10%;filter:blur(100px);animation:heroOrbB 15s ease-in-out infinite;"></div>

    <div class="relative z-10 w-full max-w-6xl mx-auto px-4 py-12 md:py-20">
        <div class="flex flex-col items-center text-center">

            <div class="mb-10 fade-in-hero" style="animation-delay:0.05s;">
                @if(!empty($siteSettings['site_logo_url']))
                <img src="{{ $siteSettings['site_logo_url'] }}" alt="سماح كير" class="h-10 sm:h-12 md:h-16 w-auto object-contain">
                @else
                <span class="text-xl sm:text-2xl md:text-3xl font-black tracking-wide" style="color:var(--ink);">سماح كير<span style="color:var(--brand-500);">.</span></span>
                @endif
            </div>

            <div class="relative mb-6" style="min-height:120px;">
                @foreach($heroHeadlines as $i => $headline)
                <div class="hero-headline absolute w-full text-center px-4" data-index="{{ $i }}"
                     style="opacity:{{ $i === 0 ? '1' : '0' }};transform:translateY({{ $i === 0 ? '0' : '24px' }});pointer-events:{{ $i === 0 ? 'auto' : 'none' }};">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-[3.25rem] font-black leading-[1.15] tracking-tight">
                        <span class="block" style="background:linear-gradient(135deg,var(--ink) 30%,var(--brand-400) 70%,var(--ink) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $headline['line1'] }}</span>
                        <span class="block mt-1.5 text-ink-muted" style="font-weight:500;">{{ $headline['line2'] }}</span>
                    </h1>
                </div>
                @endforeach
            </div>

            <div class="relative mb-10" style="min-height:28px;">
                @foreach($heroPhrases as $i => $phrase)
                <p class="hero-phrase absolute w-full text-center px-4" data-index="{{ $i }}"
                   style="color:var(--ink-dim);font-size:1rem;font-weight:400;line-height:1.7;opacity:{{ $i === 0 ? '1' : '0' }};transform:translateY({{ $i === 0 ? '0' : '12px' }});pointer-events:{{ $i === 0 ? 'auto' : 'none' }};">
                    {{ $phrase }}
                </p>
                @endforeach
            </div>

            <div class="flex items-center justify-center gap-3 mb-10">
                @foreach($heroHeadlines as $i => $h)
                <span class="hero-dot block rounded-full transition-all duration-700" style="height:6px;width:{{ $i === 0 ? '32px' : '6px' }};background:{{ $i === 0 ? 'var(--brand-500)' : 'var(--ink-dim)' }};opacity:{{ $i === 0 ? '1' : '0.3' }};"></span>
                @endforeach
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4 fade-in-hero" style="animation-delay:0.35s;">
                <a href="{{ route('booking') }}" class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-full font-bold text-sm tracking-wide transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl" style="background:var(--gradient-primary);color:#fff;box-shadow:0 8px 32px rgba(0,0,0,0.25);">
                    احجزي موعدك الآن <i class="ph ph-arrow-left"></i>
                </a>
                <a href="#servicesSection" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full font-bold text-sm tracking-wide transition-all duration-300 hover:-translate-y-0.5 glass-panel" style="border-color:var(--glass-border);">
                    استعرضي الخدمات <i class="ph ph-grid-four"></i>
                </a>
            </div>

        </div>
    </div>
</section>

@push('styles')
<style>
.hero-headline, .hero-phrase { transition:opacity 0.65s ease, transform 0.65s cubic-bezier(0.4,0,0.2,1); }
.fade-in-hero { opacity:0; transform:translateY(20px); animation:fadeInHero 0.7s ease forwards; }
@keyframes fadeInHero { to { opacity:1; transform:translateY(0); } }
@keyframes heroOrbA { 0%,100% { transform:translate(0,0); } 50% { transform:translate(30px,-30px); } }
@keyframes heroOrbB { 0%,100% { transform:translate(0,0); } 50% { transform:translate(-20px,40px); } }

@media (max-width:1024px) {
    #themeSwitcher { display:none!important; }
    .floating-social-v3 { opacity:0.7; }
}
@media (min-width:1025px) {
    .floating-social-v3 { opacity:0.4; transition:opacity 0.3s; }
    .floating-social-v3:hover { opacity:1; }
    #themeSwitcher { opacity:0.4; transition:opacity 0.3s; }
    #themeSwitcher:hover { opacity:1; }
}
</style>
@endpush

<script>
(function(){
    var headlines = document.querySelectorAll('.hero-headline');
    var phrases = document.querySelectorAll('.hero-phrase');
    var dots = document.querySelectorAll('.hero-dot');
    var total = headlines.length;
    var idx = 0, timer;

    function show(i) {
        var pi = i % phrases.length;
        headlines.forEach(function(h, j) {
            var a = j === i;
            h.style.opacity = a ? '1' : '0';
            h.style.transform = a ? 'translateY(0)' : 'translateY(24px)';
            h.style.pointerEvents = a ? 'auto' : 'none';
        });
        phrases.forEach(function(p, j) {
            var a = j === pi;
            p.style.opacity = a ? '1' : '0';
            p.style.transform = a ? 'translateY(0)' : 'translateY(12px)';
        });
        dots.forEach(function(d, j) {
            var a = j === i;
            d.style.width = a ? '32px' : '6px';
            d.style.opacity = a ? '1' : '0.3';
            d.style.background = a ? 'var(--brand-500)' : 'var(--ink-dim)';
        });
        idx = i;
    }

    function next() { show((idx + 1) % total); }
    timer = setInterval(next, 5000);

    var card = document.getElementById('hero');
    if (card) {
        card.addEventListener('mouseenter', function() { clearInterval(timer); });
        card.addEventListener('mouseleave', function() { timer = setInterval(next, 5000); });
    }
})();
</script>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION: Featured Services
     ═══════════════════════════════════════════════════════════════ --}}
@if($featuredServices->isNotEmpty())
@php
$serviceMeta = [
    1 => ['icon' => 'fa-solid fa-hand-holding-heart', 'color' => '#f472b6', 'gradient' => 'from-pink-500/20 to-pink-600/10'],
    2 => ['icon' => 'fa-solid fa-sparkles', 'color' => '#a78bfa', 'gradient' => 'from-purple-500/20 to-purple-600/10'],
    3 => ['icon' => 'fa-solid fa-bath', 'color' => '#34d399', 'gradient' => 'from-green-500/20 to-green-600/10'],
    4 => ['icon' => 'fa-solid fa-hand-sparkles', 'color' => '#fbbf24', 'gradient' => 'from-amber-500/20 to-amber-600/10'],
    5 => ['icon' => 'fa-solid fa-fire', 'color' => '#f87171', 'gradient' => 'from-red-500/20 to-red-600/10'],
    6 => ['icon' => 'fa-solid fa-leaf', 'color' => '#60a5fa', 'gradient' => 'from-blue-500/20 to-blue-600/10'],
];
@endphp
<section id="servicesSection" class="py-24 md:py-32 relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_30%_50%,rgba(var(--brand-500-rgb,255,42,133),0.04),transparent_60%)] pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="mb-16 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase" style="background:color-mix(in srgb, var(--brand-500) 10%, transparent);color:var(--brand-500);border:1px solid color-mix(in srgb, var(--brand-500) 20%, transparent);">
                <span class="w-1.5 h-1.5 rounded-full" style="background:var(--brand-500);"></span>
                خدماتنا
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-6 mb-4" style="color:var(--ink);">خدمات مختارة <span class="gradient-text">بعناية فائقة</span></h2>
            <p class="text-ink-dim max-w-2xl mx-auto text-lg font-light leading-relaxed">كل خدمة في سماح كير تم تصميمها بعناية لتكون جزءاً من روتين جمالك الشخصي. خدمات احترافية، نتائج مضمونة.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach($featuredServices as $service)
            @php $meta = $serviceMeta[$service->id] ?? ['icon' => 'fa-solid fa-spa', 'color' => 'var(--brand-500)']; @endphp
            <div class="group relative rounded-2xl overflow-hidden transition-all duration-500 hover:-translate-y-1" style="background:var(--glass-bg);border:1px solid var(--glass-border);backdrop-filter:blur(16px);">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:linear-gradient(180deg, transparent 0%, color-mix(in srgb, {{ $meta['color'] }} 8%, transparent) 100%);"></div>

                <div class="relative z-10 p-8">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl transition-all duration-500 group-hover:scale-110" style="background:color-mix(in srgb, {{ $meta['color'] }} 15%, transparent);color:{{ $meta['color'] }};">
                            <i class="{{ $meta['icon'] }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-black" style="color:var(--ink);">{{ $service->name }}</h3>
                            <p class="text-ink-dim text-sm line-clamp-1">{{ $service->description }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1.5 text-sm" style="color:{{ $meta['color'] }};">
                                <i class="fa-regular fa-clock"></i>
                                <span class="font-bold">{{ $service->duration }} دقيقة</span>
                            </div>
                            <div class="w-px h-4" style="background:var(--glass-border);"></div>
                            <div>
                                @if($service->is_on_sale)
                                <span class="text-ink-dim text-sm line-through ml-1">{{ number_format($service->price, 0) }} ₪</span>
                                <span class="font-black text-lg" style="color:{{ $meta['color'] }};">{{ number_format($service->final_price, 0) }} ₪</span>
                                @else
                                <span class="font-black text-lg" style="color:var(--ink);">{{ number_format($service->price, 0) }} ₪</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr class="my-5 border-0" style="height:1px;background:var(--glass-border);">

                    <a href="{{ route('booking') }}?service={{ $service->id }}"
                       class="w-full py-3 rounded-xl font-bold text-sm transition-all duration-300 inline-flex items-center justify-center gap-2 group-hover:shadow-lg"
                       style="border:1px solid color-mix(in srgb, {{ $meta['color'] }} 30%, transparent);color:{{ $meta['color'] }};background:transparent;">
                        احجزي الآن <i class="fa-solid fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     SECTION: Trust Bar
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_50%_50%,rgba(var(--brand-500-rgb,255,42,133),0.03),transparent_70%)] pointer-events-none"></div>
    <div class="max-w-6xl mx-auto px-4 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <div class="rounded-2xl p-6 md:p-8 text-center transition-all duration-300 hover:-translate-y-1" style="background:var(--glass-bg);border:1px solid var(--glass-border);backdrop-filter:blur(12px);">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-4" style="background:color-mix(in srgb, var(--brand-500) 12%, transparent);">
                    <i class="fa-solid fa-spa text-xl" style="color:var(--brand-500);"></i>
                </div>
                <span class="text-3xl md:text-4xl font-black block mb-1 gradient-text">+{{ \App\Models\Service::count() }}</span>
                <span class="text-sm" style="color:var(--ink-muted);">خدمة احترافية</span>
            </div>
            <div class="rounded-2xl p-6 md:p-8 text-center transition-all duration-300 hover:-translate-y-1" style="background:var(--glass-bg);border:1px solid var(--glass-border);backdrop-filter:blur(12px);">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-4" style="background:color-mix(in srgb, var(--brand-500) 12%, transparent);">
                    <i class="fa-solid fa-heart text-xl" style="color:var(--brand-500);"></i>
                </div>
                <span class="text-3xl md:text-4xl font-black block mb-1" style="color:var(--ink);">5,000+</span>
                <span class="text-sm" style="color:var(--ink-muted);">عميلة سعيدة</span>
            </div>
            <div class="rounded-2xl p-6 md:p-8 text-center transition-all duration-300 hover:-translate-y-1" style="background:var(--glass-bg);border:1px solid var(--glass-border);backdrop-filter:blur(12px);">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-4" style="background:color-mix(in srgb, var(--brand-500) 12%, transparent);">
                    <i class="fa-solid fa-star text-xl" style="color:var(--brand-500);"></i>
                </div>
                <span class="text-3xl md:text-4xl font-black block mb-1" style="color:var(--ink);">4.9</span>
                <span class="text-sm" style="color:var(--ink-muted);">تقييم العملاء</span>
            </div>
            <div class="rounded-2xl p-6 md:p-8 text-center transition-all duration-300 hover:-translate-y-1" style="background:var(--glass-bg);border:1px solid var(--glass-border);backdrop-filter:blur(12px);">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-4" style="background:color-mix(in srgb, var(--brand-500) 12%, transparent);">
                    <i class="fa-solid fa-bolt text-xl" style="color:var(--brand-500);"></i>
                </div>
                <span class="text-3xl md:text-4xl font-black block mb-1" style="color:var(--ink);">فوري</span>
                <span class="text-sm" style="color:var(--ink-muted);">تأكيد الحجز</span>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION: Why Us
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 md:py-32 relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_70%_30%,rgba(var(--brand-500-rgb,255,42,133),0.04),transparent_60%)] pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase" style="background:color-mix(in srgb, var(--brand-500) 10%, transparent);color:var(--brand-500);border:1px solid color-mix(in srgb, var(--brand-500) 20%, transparent);">
                <span class="w-1.5 h-1.5 rounded-full" style="background:var(--brand-500);"></span>
                لماذا تختارينا
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-6 mb-4" style="color:var(--ink);">لماذا <span class="gradient-text">سماح كير</span></h2>
            <p class="text-ink-dim max-w-3xl mx-auto text-lg font-light leading-relaxed">نقدم لكِ أفضل خدمات التجميل والعناية بأسعار تنافسية، مع حجز سهل وأجواء راقية. اكتشفي تجربة جمال استثنائية.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            @php
                $features = [
                    ['icon' => 'fa-solid fa-certificate', 'title' => 'خدمات احترافية مضمونة', 'desc' => 'جميع خدماتنا تُقدم بأعلى معايير الجودة والاحترافية على يد خبراء معتمدين. نضمن لكِ نتائج مبهرة في كل زيارة.'],
                    ['icon' => 'fa-solid fa-calendar-check', 'title' => 'حجز سريع ومريح', 'desc' => 'احجبي موعدكِ أونلاين بخطوات بسيطة. اختاري الخدمة والوقت المناسب واستمتعي بتجربة خالية من الانتظار.'],
                    ['icon' => 'fa-solid fa-headset', 'title' => 'دعم احترافي متواصل', 'desc' => 'فريق خدمة عملاء محترف جاهز لمساعدتك يومياً من 9 صباحاً حتى 10 مساءً عبر الواتساب. استفسري وسنرد فوراً.'],
                ];
            @endphp
            @foreach($features as $card)
            <div class="group relative rounded-2xl overflow-hidden p-8 md:p-10 transition-all duration-500 hover:-translate-y-1" style="background:var(--glass-bg);border:1px solid var(--glass-border);backdrop-filter:blur(16px);">
                <div class="absolute top-0 inset-x-0 h-1 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:var(--gradient-primary);"></div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6 text-2xl transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg" style="background:color-mix(in srgb, var(--brand-500) 12%, transparent);color:var(--brand-500);">
                    <i class="{{ $card['icon'] }}"></i>
                </div>
                <h3 class="text-xl font-black mb-3" style="color:var(--ink);">{{ $card['title'] }}</h3>
                <p class="text-ink-dim text-sm leading-relaxed">{{ $card['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION: Marquee
     ═══════════════════════════════════════════════════════════════ --}}
<div class="py-8 overflow-hidden" style="border-top:1px solid var(--glass-border);border-bottom:1px solid var(--glass-border);">
    <div class="animate-marquee-rtl flex items-center gap-12 font-mono text-xs tracking-[0.15em] uppercase" style="color:var(--ink-muted);">
        <span><i class="fa-solid fa-asterisk" style="color:var(--brand-500);font-size:6px;margin-left:6px;"></i> خدمات احترافية</span>
        <span class="w-1 h-1 rounded-full" style="background:var(--ink-dim);"></span>
        <span>حجز سهل ومريح</span>
        <span class="w-1 h-1 rounded-full" style="background:var(--ink-dim);"></span>
        <span>أفضل خدمات التجميل</span>
        <span class="w-1 h-1 rounded-full" style="background:var(--ink-dim);"></span>
        <span>الدفع عند الحضور</span>
        <span class="w-1 h-1 rounded-full" style="background:var(--ink-dim);"></span>
        <span>دعم احترافي يومي</span>
        <span class="w-1 h-1 rounded-full" style="background:var(--ink-dim);"></span>
        <span>عروض وخصومات حصرية</span>
        <span class="w-1 h-1 rounded-full" style="background:var(--ink-dim);"></span>
        <span>أجواء فاخرة</span>
        <span class="w-1 h-1 rounded-full" style="background:var(--ink-dim);"></span>
        <span>خدمات احترافية</span>
        <span class="w-1 h-1 rounded-full" style="background:var(--ink-dim);"></span>
        <span>حجز سهل ومريح</span>
        <span class="w-1 h-1 rounded-full" style="background:var(--ink-dim);"></span>
        <span>أفضل خدمات التجميل</span>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION: CTA Banner
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 md:py-32 relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(var(--brand-500-rgb,255,42,133),0.06),transparent_70%)]"></div>
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <div class="rounded-[2rem] p-12 md:p-16 relative overflow-hidden" style="background:var(--glass-bg);border:1px solid var(--glass-border);backdrop-filter:blur(16px);">
            <div class="absolute -top-32 -right-32 w-64 h-64 rounded-full pointer-events-none opacity-10" style="background:radial-gradient(circle,var(--brand-500),transparent 70%);filter:blur(70px);"></div>
            <div class="absolute -bottom-32 -left-32 w-64 h-64 rounded-full pointer-events-none opacity-10" style="background:radial-gradient(circle,var(--accent-500),transparent 70%);filter:blur(70px);"></div>

            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-8" style="background:color-mix(in srgb, var(--brand-500) 10%, transparent);color:var(--brand-500);border:1px solid color-mix(in srgb, var(--brand-500) 20%, transparent);">
                <span class="w-1.5 h-1.5 rounded-full" style="background:var(--brand-500);"></span>
                احجبي الآن
            </span>

            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-6" style="color:var(--ink);">
                مستعدة لاكتشاف<br>
                <span class="gradient-text">تجربة جمال فريدة؟</span>
            </h2>

            <p class="text-ink-dim text-lg mb-10 max-w-xl mx-auto font-light leading-relaxed">
                انضمي إلى آلاف العميلات السعيدات واحجبي موعدكِ الآن. خدمات احترافية، أجواء فاخرة، ودعم متواصل على مدار الأسبوع.
            </p>

            <a href="{{ route('booking') }}"
               class="inline-flex items-center gap-2.5 px-10 py-4 rounded-full font-bold text-sm tracking-wide transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl"
               style="background:var(--gradient-primary);color:#fff;box-shadow:0 8px 32px rgba(0,0,0,0.25);">
                احجبي موعدك <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>
    </div>
</section>

@endsection
