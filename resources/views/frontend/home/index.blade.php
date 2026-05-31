@extends($layoutPath)

@section('title', ($siteSettings['site_name'] ?? 'سماح كير') . ' | منصة الحجز والخدمات الجمالية')
@section('meta_description', 'سماح كير - وجهتك الأولى لحجز خدمات العناية بالبشرة والشعر والتجميل. احجزي موعدك الآن بسهولة.')
@section('meta_keywords', 'سماح كير, حجز موعد, عناية بالبشرة, عناية بالشعر, خدمات تجميل, فلسطين, صالون, جمال')

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "{{ $siteSettings['site_name'] ?? 'سماح كير' }}",
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

<section class="relative overflow-hidden" style="background:linear-gradient(135deg, #FBEAF0 0%, #f8dce6 50%, #fbe9ec 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center min-h-[85vh] py-20 lg:py-0">
            <div class="order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold tracking-wide mb-8" style="background:rgba(212,83,126,0.12);color:var(--brand-500);">
                    <span class="w-1.5 h-1.5 rounded-full" style="background:var(--brand-500);"></span>
                    Summer sale — up to 40% off
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-[1.1] tracking-tight mb-6 font-display" style="color:var(--ink);">
                    Your beauty,
                    <br>
                    <span class="gradient-text">elevated</span>
                </h1>

                <p class="text-lg leading-relaxed mb-10 max-w-lg font-body" style="color:var(--ink-muted);">
                    Premium skincare & beauty products delivered to your door. Authentic brands, expert advice.
                </p>

                <div class="flex flex-col sm:flex-row items-start gap-4">
                    <a href="{{ route('booking') }}" class="inline-flex items-center gap-2.5 px-8 py-4 rounded-full font-bold text-sm text-white transition-all duration-200 hover:opacity-90 hover:-translate-y-0.5 font-body" style="background:var(--brand-500);box-shadow:0 4px 16px rgba(212,83,126,0.3);">
                        Shop now
                        <i class="ph ph-arrow-left"></i>
                    </a>
                    <a href="#services" class="inline-flex items-center gap-2 px-8 py-4 rounded-full font-bold text-sm transition-all duration-200 hover:-translate-y-0.5 font-body" style="background:white;color:var(--ink);border:1px solid rgba(212,83,126,0.15);">
                        Browse categories
                        <i class="ph ph-caret-down"></i>
                    </a>
                </div>

                <div class="flex items-center gap-8 mt-12 pt-8" style="border-top:1px solid rgba(212,83,126,0.1);">
                    <div>
                        <span class="text-2xl font-black block font-display" style="color:var(--ink);">+{{ \App\Models\Service::count() }}</span>
                        <span class="text-xs font-body" style="color:var(--ink-dim);">خدمة احترافية</span>
                    </div>
                    <div class="w-px h-10" style="background:rgba(212,83,126,0.1);"></div>
                    <div>
                        <span class="text-2xl font-black block font-display" style="color:var(--ink);">5,000+</span>
                        <span class="text-xs font-body" style="color:var(--ink-dim);">عميلة سعيدة</span>
                    </div>
                    <div class="w-px h-10" style="background:rgba(212,83,126,0.1);"></div>
                    <div>
                        <span class="text-2xl font-black block font-display" style="color:var(--ink);">4.9</span>
                        <span class="text-xs font-body" style="color:var(--ink-dim);">تقييم العملاء</span>
                    </div>
                </div>
            </div>

            <div class="order-1 lg:order-2 relative">
                <div class="relative aspect-[4/5] rounded-3xl overflow-hidden" style="background:linear-gradient(135deg, var(--brand-100), var(--brand-50));">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4" style="background:white;box-shadow:0 8px 32px rgba(212,83,126,0.15);">
                                <i class="ph ph-sparkle text-4xl" style="color:var(--brand-500);"></i>
                            </div>
                            <p class="text-sm font-semibold font-body" style="color:var(--brand-700);">سماح كير</p>
                        </div>
                    </div>
                </div>

                <div class="absolute -bottom-6 -right-6 lg:-right-12 p-5 rounded-2xl shadow-lg" style="background:white;max-width:220px;">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background:#dcfce7;">
                            <i class="ph-fill ph-check-circle text-lg" style="color:#16a34a;"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold font-body" style="color:var(--ink);">حجز مؤكد</p>
                            <p class="text-[10px] font-body" style="color:var(--ink-dim);">قبل دقائق</p>
                        </div>
                    </div>
                    <p class="text-xs font-body" style="color:var(--ink-muted);">تم حجز خدمة العناية بالبشرة بنجاح</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="py-6 lg:py-8" style="background:white;border-bottom:1px solid rgba(212,83,126,0.06);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0" style="background:var(--brand-50);">
                    <i class="ph ph-truck text-xl" style="color:var(--brand-500);"></i>
                </div>
                <div>
                    <p class="text-sm font-bold font-body" style="color:var(--ink);">Free shipping</p>
                    <p class="text-xs font-body" style="color:var(--ink-dim);">Over ₪150</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0" style="background:var(--brand-50);">
                    <i class="ph ph-arrow-counter-clockwise text-xl" style="color:var(--brand-500);"></i>
                </div>
                <div>
                    <p class="text-sm font-bold font-body" style="color:var(--ink);">Easy returns</p>
                    <p class="text-xs font-body" style="color:var(--ink-dim);">30-day policy</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0" style="background:var(--brand-50);">
                    <i class="ph ph-lock-simple text-xl" style="color:var(--brand-500);"></i>
                </div>
                <div>
                    <p class="text-sm font-bold font-body" style="color:var(--ink);">Secure checkout</p>
                    <p class="text-xs font-body" style="color:var(--ink-dim);">SSL encrypted</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0" style="background:var(--brand-50);">
                    <i class="ph ph-certificate text-xl" style="color:var(--brand-500);"></i>
                </div>
                <div>
                    <p class="text-sm font-bold font-body" style="color:var(--ink);">100% authentic</p>
                    <p class="text-xs font-body" style="color:var(--ink-dim);">Guaranteed</p>
                </div>
            </div>
        </div>
    </div>
</div>

@if($featuredServices->isNotEmpty())
@php
$serviceIcons = [
    1 => ['icon' => 'ph ph-hand-heart', 'bg' => '#fce7f3'],
    2 => ['icon' => 'ph ph-sparkle', 'bg' => '#ede9fe'],
    3 => ['icon' => 'ph ph-drop', 'bg' => '#d1fae5'],
    4 => ['icon' => 'ph ph-flower-lotus', 'bg' => '#fef3c7'],
    5 => ['icon' => 'ph ph-fire', 'bg' => '#fee2e2'],
    6 => ['icon' => 'ph ph-leaf', 'bg' => '#dbeafe'],
];
@endphp
<section id="services" class="py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold tracking-wide mb-4 font-body" style="background:var(--brand-50);color:var(--brand-500);">
                Featured products
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4 font-display" style="color:var(--ink);">
                خدمات مختارة <span class="gradient-text">بعناية</span>
            </h2>
            <p class="text-base max-w-2xl mx-auto font-body" style="color:var(--ink-muted);">
                كل خدمة مصممة بعناية لتكون جزءاً من روتين جمالكِ الشخصي
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($featuredServices as $service)
            @php $meta = $serviceIcons[$service->id] ?? ['icon' => 'ph ph-spa', 'bg' => 'var(--brand-50)']; @endphp
            <div class="group relative rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="background:white;border:1px solid rgba(212,83,126,0.06);">
                <div class="relative aspect-square overflow-hidden" style="background:{{ $meta['bg'] }};">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="{{ $meta['icon'] }} text-5xl sm:text-6xl transition-transform duration-300 group-hover:scale-110" style="color:var(--brand-500);"></i>
                    </div>

                    @if($service->is_on_sale)
                    <div class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold text-white" style="background:var(--brand-500);">
                        Sale
                    </div>
                    @elseif($service->id <= 3)
                    <div class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold text-white" style="background:#10b981;">
                        New
                    </div>
                    @endif

                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <a href="{{ route('booking') }}?service={{ $service->id }}" class="px-6 py-2.5 rounded-full text-sm font-bold text-white transition-all duration-200 hover:scale-105" style="background:var(--brand-500);">
                            Add to cart
                        </a>
                    </div>
                </div>

                <div class="p-4 sm:p-5">
                    <div class="flex items-center gap-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="ph-fill ph-star text-xs" style="color:{{ $i <= 4 ? '#fbbf24' : '#e5e7eb' }};"></i>
                        @endfor
                        <span class="text-[10px] ml-1 font-body" style="color:var(--ink-dim);">(24)</span>
                    </div>

                    <h3 class="text-sm sm:text-base font-bold mb-2 line-clamp-1 font-body" style="color:var(--ink);">{{ $service->name }}</h3>

                    <div class="flex items-center gap-2">
                        @if($service->is_on_sale)
                        <span class="text-sm font-bold font-body" style="color:var(--brand-500);">{{ number_format($service->final_price, 0) }} ₪</span>
                        <span class="text-xs line-through font-body" style="color:var(--ink-dim);">{{ number_format($service->price, 0) }} ₪</span>
                        @else
                        <span class="text-sm font-bold font-body" style="color:var(--ink);">{{ number_format($service->price, 0) }} ₪</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-24 lg:py-32" style="background:var(--surface-alt);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold tracking-wide mb-4 font-body" style="background:var(--brand-50);color:var(--brand-500);">
                لماذا نحن
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4 font-display" style="color:var(--ink);">
                لماذا <span class="gradient-text">سماح كير</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $features = [
                    ['icon' => 'ph ph-certificate', 'title' => 'خدمات احترافية مضمونة', 'desc' => 'جميع خدماتنا تُقدم بأعلى معايير الجودة على يد خبيرات معتمدات. نضمن لكِ نتائج مبهرة في كل زيارة.'],
                    ['icon' => 'ph ph-calendar-check', 'title' => 'حجز سريع ومريح', 'desc' => 'احجزي موعدكِ أونلاين بخطوات بسيطة. اختاري الخدمة والوقت المناسب واستمتعي بتجربة خالية من الانتظار.'],
                    ['icon' => 'ph ph-headset', 'title' => 'دعم متواصل', 'desc' => 'فريق خدمة عملاء جاهز لمساعدتك يومياً من 9 صباحاً حتى 10 مساءً عبر الواتساب. استفسري وسنرد فوراً.'],
                ];
            @endphp
            @foreach($features as $i => $card)
            <div class="text-center p-8">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6" style="background:var(--brand-50);">
                    <i class="{{ $card['icon'] }} text-3xl" style="color:var(--brand-500);"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 font-display" style="color:var(--ink);">{{ $card['title'] }}</h3>
                <p class="text-sm leading-relaxed font-body" style="color:var(--ink-muted);">{{ $card['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-24 lg:py-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-6 font-display" style="color:var(--ink);">
            مستعدة لتجربة
            <span class="gradient-text">جمال استثنائية؟</span>
        </h2>
        <p class="text-lg mb-10 max-w-xl mx-auto font-body" style="color:var(--ink-muted);">
            انضمي إلى آلاف العميلات السعيدات واحجزي موعدكِ الآن
        </p>
        <a href="{{ route('booking') }}" class="inline-flex items-center gap-2.5 px-10 py-4 rounded-full font-bold text-sm text-white transition-all duration-200 hover:opacity-90 hover:-translate-y-0.5 font-body" style="background:var(--brand-500);box-shadow:0 4px 16px rgba(212,83,126,0.3);">
            احجزي موعدك الآن
            <i class="ph ph-arrow-left"></i>
        </a>
    </div>
</section>

@endsection
