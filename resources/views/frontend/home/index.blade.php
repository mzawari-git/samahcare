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

<section class="relative overflow-hidden min-h-[90vh] flex items-center" style="background:linear-gradient(135deg, var(--brand-50) 0%, var(--brand-100) 50%, var(--brand-50) 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 rounded-full opacity-30" style="background:radial-gradient(circle, var(--brand-200), transparent 70%);"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full opacity-20" style="background:radial-gradient(circle, var(--brand-300), transparent 70%);"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center py-16 lg:py-0">
            <div class="order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold tracking-wide mb-8 animate-fade-up" style="background:var(--brand-100);color:var(--brand-600);">
                    <span class="w-2 h-2 rounded-full animate-pulse" style="background:var(--brand-500);"></span>
                    تخفيضات الصيف — خصم يصل إلى 40%
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black leading-[1.05] tracking-tight mb-6 font-display animate-fade-up" style="color:var(--ink);animation-delay:0.1s;">
                    جمالكِ،
                    <br>
                    <span class="gradient-text">إلى آفاق جديدة</span>
                </h1>

                <p class="text-lg lg:text-xl leading-relaxed mb-10 max-w-lg font-body animate-fade-up" style="color:var(--ink-muted);animation-delay:0.2s;">
                    منتجات عناية بالبشرة والتجميل الفاخرة توصل إلى بابكِ. ماركات أصلية، نصائح خبراء، ونتائج مضمونة.
                </p>

                <div class="flex flex-col sm:flex-row items-start gap-4 animate-fade-up" style="animation-delay:0.3s;">
                    <a href="{{ route('booking') }}" class="group inline-flex items-center gap-2.5 px-8 py-4 rounded-full font-bold text-sm text-white transition-all duration-300 hover:shadow-xl hover:-translate-y-1 font-body" style="background:var(--brand-500);box-shadow:0 4px 20px rgba(220,38,38,0.35);">
                        تسوقي الآن
                        <i class="ph ph-arrow-left transition-transform group-hover:-translate-x-1"></i>
                    </a>
                    <a href="#services" class="group inline-flex items-center gap-2 px-8 py-4 rounded-full font-bold text-sm transition-all duration-300 hover:-translate-y-1 font-body" style="background:white;color:var(--ink);border:2px solid var(--brand-100);box-shadow:0 2px 12px rgba(0,0,0,0.06);">
                        تصفحي الفئات
                        <i class="ph ph-caret-down transition-transform group-hover:translate-y-0.5"></i>
                    </a>
                </div>

                <div class="flex items-center gap-8 mt-12 pt-8 animate-fade-up" style="border-top:1px solid var(--brand-100);animation-delay:0.4s;">
                    <div>
                        <span class="text-3xl font-black block font-display" style="color:var(--ink);">+{{ \App\Models\Service::count() }}</span>
                        <span class="text-xs font-body" style="color:var(--ink-dim);">خدمة احترافية</span>
                    </div>
                    <div class="w-px h-12" style="background:var(--brand-100);"></div>
                    <div>
                        <span class="text-3xl font-black block font-display" style="color:var(--ink);">5,000+</span>
                        <span class="text-xs font-body" style="color:var(--ink-dim);">عميلة سعيدة</span>
                    </div>
                    <div class="w-px h-12" style="background:var(--brand-100);"></div>
                    <div>
                        <span class="text-3xl font-black block font-display" style="color:var(--ink);">4.9</span>
                        <div class="flex items-center gap-0.5">
                            @for($i = 0; $i < 5; $i++)
                            <i class="ph-fill ph-star text-[10px]" style="color:#fbbf24;"></i>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-1 lg:order-2 relative animate-fade-up" style="animation-delay:0.2s;">
                <div class="relative aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl" style="background:linear-gradient(135deg, var(--brand-100), var(--brand-200));">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-28 h-28 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg" style="background:white;">
                                <i class="ph ph-sparkle text-5xl" style="color:var(--brand-500);"></i>
                            </div>
                            <p class="text-lg font-bold font-body" style="color:var(--brand-700);">سماح كير</p>
                            <p class="text-xs mt-1" style="color:var(--brand-500);">Beauty & Care</p>
                        </div>
                    </div>
                </div>

                <div class="absolute -bottom-6 -right-6 lg:-right-12 p-5 rounded-2xl shadow-xl animate-float-slow" style="background:white;max-width:240px;border:1px solid var(--brand-50);">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background:#dcfce7;">
                            <i class="ph-fill ph-check-circle text-xl" style="color:#16a34a;"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold font-body" style="color:var(--ink);">حجز مؤكد</p>
                            <p class="text-[11px] font-body" style="color:var(--ink-dim);">قبل دقائق</p>
                        </div>
                    </div>
                    <p class="text-xs font-body" style="color:var(--ink-muted);">تم حجز خدمة العناية بالبشرة بنجاح</p>
                </div>

                <div class="absolute -top-4 -left-4 lg:-left-8 p-4 rounded-2xl shadow-xl animate-float-fast" style="background:white;max-width:180px;border:1px solid var(--brand-50);">
                    <div class="flex items-center gap-2">
                        <div class="flex -space-x-2 space-x-reverse">
                            <div class="w-8 h-8 rounded-full border-2 border-white" style="background:var(--brand-100);"></div>
                            <div class="w-8 h-8 rounded-full border-2 border-white" style="background:var(--brand-200);"></div>
                            <div class="w-8 h-8 rounded-full border-2 border-white" style="background:var(--brand-300);"></div>
                        </div>
                        <div>
                            <p class="text-xs font-bold" style="color:var(--ink);">+500</p>
                            <p class="text-[10px]" style="color:var(--ink-dim);">هذا الأسبوع</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-8 lg:py-10" style="background:white;border-bottom:1px solid var(--brand-50);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8">
            <div class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 transition-transform group-hover:scale-110" style="background:var(--brand-50);">
                    <i class="ph ph-truck text-xl" style="color:var(--brand-500);"></i>
                </div>
                <div>
                    <p class="text-sm font-bold font-body" style="color:var(--ink);">شحن مجاني</p>
                    <p class="text-xs font-body" style="color:var(--ink-dim);">للطلبات فوق 150 شيكل</p>
                </div>
            </div>
            <div class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 transition-transform group-hover:scale-110" style="background:var(--brand-50);">
                    <i class="ph ph-arrow-counter-clockwise text-xl" style="color:var(--brand-500);"></i>
                </div>
                <div>
                    <p class="text-sm font-bold font-body" style="color:var(--ink);">إرجاع سهل</p>
                    <p class="text-xs font-body" style="color:var(--ink-dim);">خلال 30 يوم</p>
                </div>
            </div>
            <div class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 transition-transform group-hover:scale-110" style="background:var(--brand-50);">
                    <i class="ph ph-lock-simple text-xl" style="color:var(--brand-500);"></i>
                </div>
                <div>
                    <p class="text-sm font-bold font-body" style="color:var(--ink);">دفع آمن</p>
                    <p class="text-xs font-body" style="color:var(--ink-dim);">تشفير SSL</p>
                </div>
            </div>
            <div class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 transition-transform group-hover:scale-110" style="background:var(--brand-50);">
                    <i class="ph ph-certificate text-xl" style="color:var(--brand-500);"></i>
                </div>
                <div>
                    <p class="text-sm font-bold font-body" style="color:var(--ink);">أصلي 100%</p>
                    <p class="text-xs font-body" style="color:var(--ink-dim);">مضمون</p>
                </div>
            </div>
        </div>
    </div>
</section>

@if($featuredServices->isNotEmpty())
@php
$serviceIcons = [
    1 => ['icon' => 'ph ph-hand-heart', 'bg' => '#fce7f3', 'label' => 'عناية'],
    2 => ['icon' => 'ph ph-sparkle', 'bg' => '#ede9fe', 'label' => 'تجميل'],
    3 => ['icon' => 'ph ph-drop', 'bg' => '#d1fae5', 'label' => 'ترطيب'],
    4 => ['icon' => 'ph ph-flower-lotus', 'bg' => '#fef3c7', 'label' => 'استرخاء'],
    5 => ['icon' => 'ph ph-fire', 'bg' => '#fee2e2', 'label' => 'الأكثر طلباً'],
    6 => ['icon' => 'ph ph-leaf', 'bg' => '#dbeafe', 'label' => 'طبيعي'],
];
@endphp
<section id="services" class="py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold tracking-wide mb-4 font-body" style="background:var(--brand-50);color:var(--brand-600);">
                <i class="ph ph-star-four"></i>
                منتجات مميزة
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4 font-display" style="color:var(--ink);">
                خدمات مختارة <span class="gradient-text">بعناية</span>
            </h2>
            <p class="text-base lg:text-lg max-w-2xl mx-auto font-body" style="color:var(--ink-muted);">
                كل خدمة مصممة بعناية لتكون جزءاً من روتين جمالكِ الشخصي
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($featuredServices as $service)
            @php $meta = $serviceIcons[$service->id] ?? ['icon' => 'ph ph-spa', 'bg' => 'var(--brand-50)', 'label' => '']; @endphp
            <div class="group relative rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl" style="background:white;border:1px solid var(--brand-50);">
                <div class="relative aspect-square overflow-hidden" style="background:{{ $meta['bg'] }};">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="{{ $meta['icon'] }} text-5xl sm:text-6xl transition-transform duration-500 group-hover:scale-125 group-hover:rotate-12" style="color:var(--brand-500);"></i>
                    </div>

                    @if($service->is_on_sale)
                    <div class="absolute top-3 left-3 px-3 py-1 rounded-full text-[10px] font-bold text-white shadow-md" style="background:var(--brand-500);">
                        تخفيض
                    </div>
                    @elseif($service->id <= 3)
                    <div class="absolute top-3 left-3 px-3 py-1 rounded-full text-[10px] font-bold text-white shadow-md" style="background:#10b981;">
                        جديد
                    </div>
                    @endif

                    @if(!empty($meta['label']))
                    <div class="absolute bottom-3 right-3 px-2 py-1 rounded-lg text-[9px] font-bold" style="background:rgba(255,255,255,0.9);color:var(--ink-muted);">
                        {{ $meta['label'] }}
                    </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-6">
                        <a href="{{ route('booking') }}?service={{ $service->id }}" class="px-6 py-2.5 rounded-full text-sm font-bold text-white transition-all duration-300 translate-y-4 group-hover:translate-y-0" style="background:var(--brand-500);">
                            أضيفي للسلة
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

        <div class="text-center mt-12">
            <a href="{{ route('booking') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-full font-bold text-sm transition-all duration-300 hover:-translate-y-1 font-body" style="background:var(--brand-50);color:var(--brand-600);border:1px solid var(--brand-100);">
                عرض جميع الخدمات
                <i class="ph ph-arrow-left"></i>
            </a>
        </div>
    </div>
</section>
@endif

<section class="py-24 lg:py-32 relative overflow-hidden" style="background:var(--surface-alt);">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-64 h-64 rounded-full opacity-20" style="background:radial-gradient(circle, var(--brand-200), transparent 70%);"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 rounded-full opacity-10" style="background:radial-gradient(circle, var(--brand-300), transparent 70%);"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold tracking-wide mb-4 font-body" style="background:var(--brand-50);color:var(--brand-600);">
                <i class="ph ph-heart"></i>
                لماذا نحن
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4 font-display" style="color:var(--ink);">
                لماذا <span class="gradient-text">سماح كير</span>
            </h2>
            <p class="text-base lg:text-lg max-w-2xl mx-auto font-body" style="color:var(--ink-muted);">
                نقدم لكِ تجربة جمالية استثنائية تجمع بين الاحترافية والاهتمام الشخصي
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $features = [
                    ['icon' => 'ph ph-certificate', 'title' => 'خدمات احترافية مضمونة', 'desc' => 'جميع خدماتنا تُقدم بأعلى معايير الجودة على يد خبيرات معتمدات. نضمن لكِ نتائج مبهرة في كل زيارة.', 'color' => '#8b5cf6'],
                    ['icon' => 'ph ph-calendar-check', 'title' => 'حجز سريع ومريح', 'desc' => 'احجزي موعدكِ أونلاين بخطوات بسيطة. اختاري الخدمة والوقت المناسب واستمتعي بتجربة خالية من الانتظار.', 'color' => '#06b6d4'],
                    ['icon' => 'ph ph-headset', 'title' => 'دعم متواصل', 'desc' => 'فريق خدمة عملاء جاهز لمساعدتك يومياً من 9 صباحاً حتى 10 مساءً عبر الواتساب. استفسري وسنرد فوراً.', 'color' => '#10b981'],
                ];
            @endphp
            @foreach($features as $i => $card)
            <div class="group text-center p-8 rounded-3xl transition-all duration-300 hover:-translate-y-2 hover:shadow-xl" style="background:white;border:1px solid var(--brand-50);">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6" style="background:var(--brand-50);">
                    <i class="{{ $card['icon'] }} text-4xl" style="color:var(--brand-500);"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 font-display" style="color:var(--ink);">{{ $card['title'] }}</h3>
                <p class="text-sm leading-relaxed font-body" style="color:var(--ink-muted);">{{ $card['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold tracking-wide mb-4 font-body" style="background:var(--brand-50);color:var(--brand-600);">
                <i class="ph ph-chat-circle-text"></i>
                آراء العميلات
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4 font-display" style="color:var(--ink);">
                ماذا تقول <span class="gradient-text">عميلاتنا</span>
            </h2>
            <p class="text-base lg:text-lg max-w-2xl mx-auto font-body" style="color:var(--ink-muted);">
                تجارب حقيقية من عميلات سعيدات اخترن سماح كير
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            @php
                $testimonials = [
                    ['name' => 'سارة أحمد', 'role' => 'عميلة منتظمة', 'text' => 'تجربة رائعة! الخدمة احترافية والنتائج فاقت توقعاتي. أنصح الجميع بتجربة خدمات العناية بالبشرة.', 'rating' => 5],
                    ['name' => 'نور محمد', 'role' => 'عميلة جديدة', 'text' => 'أول مرة أحجز أونلاين وكانت التجربة سهلة جداً. الفريق محترف والاهتمام بالتفاصيل واضح.', 'rating' => 5],
                    ['name' => 'ليلى خالد', 'role' => 'عميلة VIP', 'text' => 'من أفضل المراكز التي تعاملت معها. الجودة عالية والأسعار معقولة. شكراً سماح كير!', 'rating' => 5],
                ];
            @endphp
            @foreach($testimonials as $testimonial)
            <div class="group p-6 lg:p-8 rounded-3xl transition-all duration-300 hover:-translate-y-2 hover:shadow-xl" style="background:white;border:1px solid var(--brand-50);">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="ph-fill ph-star text-lg" style="color:{{ $i <= $testimonial['rating'] ? '#fbbf24' : '#e5e7eb' }};"></i>
                    @endfor
                </div>
                <p class="text-sm leading-relaxed mb-6 font-body" style="color:var(--ink-muted);">"{{ $testimonial['text'] }}"</p>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background:var(--brand-50);">
                        <span class="text-lg font-bold" style="color:var(--brand-500);">{{ mb_substr($testimonial['name'], 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold font-body" style="color:var(--ink);">{{ $testimonial['name'] }}</p>
                        <p class="text-xs font-body" style="color:var(--ink-dim);">{{ $testimonial['role'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-24 lg:py-32" style="background:var(--surface-alt);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold tracking-wide mb-4 font-body" style="background:var(--brand-50);color:var(--brand-600);">
                <i class="ph ph-images"></i>
                معرض الأعمال
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4 font-display" style="color:var(--ink);">
                قبل و<span class="gradient-text">بعد</span>
            </h2>
            <p class="text-base lg:text-lg max-w-2xl mx-auto font-body" style="color:var(--ink-muted);">
                شاهدي التحولات المذهلة التي حققتها عميلاتنا
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
            @php
                $galleryItems = [
                    ['icon' => 'ph ph-sparkle', 'label' => 'العناية بالبشرة'],
                    ['icon' => 'ph ph-eye', 'label' => 'المكياج'],
                    ['icon' => 'ph ph-scissors', 'label' => 'الشعر'],
                    ['icon' => 'ph ph-hand-heart', 'label' => 'الأظافر'],
                ];
            @endphp
            @foreach($galleryItems as $item)
            <div class="group relative aspect-square rounded-2xl overflow-hidden cursor-pointer transition-all duration-300 hover:-translate-y-2 hover:shadow-xl" style="background:linear-gradient(135deg, var(--brand-100), var(--brand-200));">
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="{{ $item['icon'] }} text-5xl lg:text-6xl transition-transform duration-500 group-hover:scale-125" style="color:var(--brand-500);"></i>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-6">
                    <span class="text-sm font-bold text-white">{{ $item['label'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold tracking-wide mb-4 font-body" style="background:var(--brand-50);color:var(--brand-600);">
                <i class="ph ph-article"></i>
                المدونة
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4 font-display" style="color:var(--ink);">
                نصائح <span class="gradient-text">الجمال</span>
            </h2>
            <p class="text-base lg:text-lg max-w-2xl mx-auto font-body" style="color:var(--ink-muted);">
                اكتشفي أحدث النصائح والاتجاهات في عالم الجمال والعناية
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            @php
                $blogPosts = [
                    ['title' => '10 نصائح للعناية بالبشرة في الصيف', 'excerpt' => 'تعرفي على أفضل الطرق للحفاظ على بشرتكِ مشرقة وصحية خلال فصل الصيف.', 'icon' => 'ph ph-sun', 'category' => 'عناية بالبشرة'],
                    ['title' => 'أحدث صيحات المكياج لعام 2024', 'excerpt' => 'اكتشفي أبرز اتجاهات المكياج التي تسيطر على عالم الجمال هذا العام.', 'icon' => 'ph ph-palette', 'category' => 'مكياج'],
                    ['title' => 'روتين العناية بالشعر المجعد', 'excerpt' => 'دليلكِ الشامل للعناية بالشعر المجعد والحصول على تموجات مثالية.', 'icon' => 'ph ph-wind', 'category' => 'عناية بالشعر'],
                ];
            @endphp
            @foreach($blogPosts as $post)
            <article class="group rounded-3xl overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-xl" style="background:white;border:1px solid var(--brand-50);">
                <div class="aspect-[16/10] relative overflow-hidden" style="background:linear-gradient(135deg, var(--brand-50), var(--brand-100));">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="{{ $post['icon'] }} text-5xl transition-transform duration-500 group-hover:scale-110" style="color:var(--brand-500);"></i>
                    </div>
                    <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-[10px] font-bold" style="background:white;color:var(--brand-500);">
                        {{ $post['category'] }}
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-2 line-clamp-2 font-body" style="color:var(--ink);">{{ $post['title'] }}</h3>
                    <p class="text-sm leading-relaxed mb-4 line-clamp-2 font-body" style="color:var(--ink-muted);">{{ $post['excerpt'] }}</p>
                    <a href="#" class="inline-flex items-center gap-1 text-sm font-bold transition-colors" style="color:var(--brand-500);">
                        اقرأ المزيد
                        <i class="ph ph-arrow-left text-xs"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<section class="py-24 lg:py-32 relative overflow-hidden" style="background:linear-gradient(135deg, var(--brand-500), var(--brand-600));">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full opacity-20" style="background:white;"></div>
        <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full opacity-10" style="background:white;"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-8" style="background:rgba(255,255,255,0.2);">
            <i class="ph ph-envelope-simple text-4xl text-white"></i>
        </div>
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-6 font-display text-white">
            اشتركي في نشرتنا
        </h2>
        <p class="text-lg mb-10 max-w-xl mx-auto text-white/80 font-body">
            احصلي على أحدث العروض والنصائح الجمالية مباشرة في بريدكِ الإلكتروني
        </p>
        <form class="flex flex-col sm:flex-row items-center gap-3 max-w-md mx-auto">
            <input type="email" placeholder="بريدكِ الإلكتروني" class="flex-1 w-full px-6 py-4 rounded-full text-sm font-body" style="background:white;color:var(--ink);border:none;outline:none;">
            <button type="submit" class="w-full sm:w-auto px-8 py-4 rounded-full font-bold text-sm transition-all duration-300 hover:-translate-y-1 font-body" style="background:var(--ink);color:white;">
                اشتركي الآن
            </button>
        </form>
        <p class="text-xs mt-4 text-white/60 font-body">لن نشارك بريدكِ الإلكتروني مع أي طرف ثالث</p>
    </div>
</section>

<section class="py-24 lg:py-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-8" style="background:var(--brand-50);">
            <i class="ph ph-calendar-check text-5xl" style="color:var(--brand-500);"></i>
        </div>
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-6 font-display" style="color:var(--ink);">
            مستعدة لتجربة
            <span class="gradient-text">جمال استثنائية؟</span>
        </h2>
        <p class="text-lg mb-10 max-w-xl mx-auto font-body" style="color:var(--ink-muted);">
            انضمي إلى آلاف العميلات السعيدات واحجزي موعدكِ الآن
        </p>
        <a href="{{ route('booking') }}" class="group inline-flex items-center gap-2.5 px-10 py-5 rounded-full font-bold text-base text-white transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 font-body" style="background:var(--brand-500);box-shadow:0 8px 32px rgba(220,38,38,0.4);">
            احجزي موعدك الآن
            <i class="ph ph-arrow-left transition-transform group-hover:-translate-x-1"></i>
        </a>
    </div>
</section>

@endsection
