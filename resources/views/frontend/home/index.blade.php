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

{{-- ═══════════════════════════════════════════════════════════════
     HERO SECTION
     ═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden" style="background: var(--gradient-hero); min-height: 92vh;">
    {{-- Decorative Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-72 h-72 rounded-full opacity-40 animate-float-slow" style="background: radial-gradient(circle, var(--brand-200), transparent 70%);"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 rounded-full opacity-30 animate-float" style="background: radial-gradient(circle, var(--accent-200), transparent 70%);"></div>
        <div class="absolute top-1/2 left-1/3 w-48 h-48 rounded-full opacity-20" style="background: radial-gradient(circle, var(--brand-300), transparent 70%);"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 lg:gap-24 items-center min-h-[92vh] py-20">
            
            {{-- Content --}}
            <div class="order-2 lg:order-1">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-8 animate-fade-up" style="background: rgba(255,255,255,0.8); backdrop-filter: blur(8px); border: 1px solid var(--brand-100); animation-delay: 0.1s;">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background: var(--brand-500);"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5" style="background: var(--brand-500);"></span>
                    </span>
                    <span class="text-sm font-semibold" style="color: var(--brand-700);">تخفيضات الصيف — خصم يصل إلى 40%</span>
                </div>

                {{-- Heading --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black leading-[1.05] tracking-tight mb-6 animate-fade-up" style="color: var(--ink); animation-delay: 0.2s;">
                    اكتشفي
                    <span class="block mt-2">
                        <span class="gradient-text">جمالكِ الحقيقي</span>
                    </span>
                </h1>

                {{-- Description --}}
                <p class="text-lg lg:text-xl leading-relaxed mb-10 max-w-lg animate-fade-up" style="color: var(--ink-muted); animation-delay: 0.3s;">
                    خدمات عناية بالبشرة وتجميل فاخرة بأيدي خبيرات معتمدات. احجزي موعدكِ الآن واستمتعي بتجربة جمالية استثنائية.
                </p>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row items-start gap-4 mb-12 animate-fade-up" style="animation-delay: 0.4s;">
                    <a href="{{ route('booking') }}" class="btn btn-primary group">
                        <span>احجزي موعدكِ الآن</span>
                        <i class="ph ph-arrow-left transition-transform group-hover:-translate-x-1"></i>
                    </a>
                    <a href="#services" class="btn btn-secondary group">
                        <i class="ph ph-grid-four"></i>
                        <span>تصفحي خدماتنا</span>
                    </a>
                </div>

                {{-- Stats --}}
                <div class="flex items-center gap-8 lg:gap-12 animate-fade-up" style="animation-delay: 0.5s;">
                    <div class="text-center">
                        <div class="text-3xl lg:text-4xl font-black" style="color: var(--ink);">+{{ \App\Models\Service::count() }}</div>
                        <div class="text-xs lg:text-sm mt-1" style="color: var(--ink-dim);">خدمة متاحة</div>
                    </div>
                    <div class="w-px h-14" style="background: var(--brand-200);"></div>
                    <div class="text-center">
                        <div class="text-3xl lg:text-4xl font-black" style="color: var(--ink);">5K+</div>
                        <div class="text-xs lg:text-sm mt-1" style="color: var(--ink-dim);">عميلة سعيدة</div>
                    </div>
                    <div class="w-px h-14" style="background: var(--brand-200);"></div>
                    <div class="text-center">
                        <div class="flex items-center gap-1 justify-center">
                            <span class="text-3xl lg:text-4xl font-black" style="color: var(--ink);">4.9</span>
                            <i class="ph-fill ph-star text-xl" style="color: var(--accent-500);"></i>
                        </div>
                        <div class="text-xs lg:text-sm mt-1" style="color: var(--ink-dim);">تقييم العميلات</div>
                    </div>
                </div>
            </div>

            {{-- Visual --}}
            <div class="order-1 lg:order-2 relative animate-fade-up" style="animation-delay: 0.3s;">
                {{-- Main Image Card --}}
                <div class="relative aspect-[4/5] rounded-3xl overflow-hidden shadow-xl" style="background: linear-gradient(145deg, var(--brand-100), var(--brand-200));">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg" style="background: white;">
                                <i class="ph ph-sparkle text-6xl" style="color: var(--brand-500);"></i>
                            </div>
                            <p class="text-2xl font-bold" style="color: var(--brand-700);">سماح كير</p>
                            <p class="text-sm mt-2" style="color: var(--brand-500);">Beauty & Wellness</p>
                        </div>
                    </div>
                </div>

                {{-- Floating Card 1 --}}
                <div class="absolute -bottom-6 -right-4 lg:-right-8 p-5 rounded-2xl shadow-xl animate-float" style="background: white; max-width: 220px; border: 1px solid var(--brand-50);">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: var(--success-bg);">
                            <i class="ph-fill ph-check-circle text-xl" style="color: var(--success);"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold" style="color: var(--ink);">حجز مؤكد</p>
                            <p class="text-xs" style="color: var(--ink-dim);">قبل 3 دقائق</p>
                        </div>
                    </div>
                    <p class="text-xs" style="color: var(--ink-muted);">تم حجز جلسة العناية بالبشرة</p>
                </div>

                {{-- Floating Card 2 --}}
                <div class="absolute -top-4 -left-4 lg:-left-8 p-4 rounded-2xl shadow-xl animate-float-slow" style="background: white; max-width: 180px; border: 1px solid var(--brand-50);">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2 space-x-reverse">
                            <div class="w-9 h-9 rounded-full border-2 border-white flex items-center justify-center text-xs font-bold" style="background: var(--brand-100); color: var(--brand-600);">س</div>
                            <div class="w-9 h-9 rounded-full border-2 border-white flex items-center justify-center text-xs font-bold" style="background: var(--accent-100); color: var(--accent-600);">ن</div>
                            <div class="w-9 h-9 rounded-full border-2 border-white flex items-center justify-center text-xs font-bold" style="background: var(--brand-200); color: var(--brand-700);">ل</div>
                        </div>
                        <div>
                            <p class="text-sm font-bold" style="color: var(--ink);">+120</p>
                            <p class="text-[10px]" style="color: var(--ink-dim);">هذا الشهر</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     TRUST BAR
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-6 lg:py-8 border-b" style="background: var(--surface); border-color: var(--neutral-100);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8">
            <div class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 transition-transform group-hover:scale-110" style="background: var(--brand-50);">
                    <i class="ph ph-truck text-lg" style="color: var(--brand-600);"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold" style="color: var(--ink);">توصيل مجاني</p>
                    <p class="text-xs" style="color: var(--ink-dim);">للطلبات +150 شيكل</p>
                </div>
            </div>
            <div class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 transition-transform group-hover:scale-110" style="background: var(--accent-50);">
                    <i class="ph ph-shield-check text-lg" style="color: var(--accent-600);"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold" style="color: var(--ink);">منتجات أصلية</p>
                    <p class="text-xs" style="color: var(--ink-dim);">ضمان 100%</p>
                </div>
            </div>
            <div class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 transition-transform group-hover:scale-110" style="background: var(--success-bg);">
                    <i class="ph ph-arrow-counter-clockwise text-lg" style="color: var(--success);"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold" style="color: var(--ink);">إرجاع سهل</p>
                    <p class="text-xs" style="color: var(--ink-dim);">خلال 30 يوم</p>
                </div>
            </div>
            <div class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 transition-transform group-hover:scale-110" style="background: var(--info-bg);">
                    <i class="ph ph-headset text-lg" style="color: var(--info);"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold" style="color: var(--ink);">دعم متواصل</p>
                    <p class="text-xs" style="color: var(--ink-dim);">يومياً 9ص - 10م</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     FEATURED SERVICES
     ═══════════════════════════════════════════════════════════════ --}}
@if($featuredServices->isNotEmpty())
@php
$serviceMeta = [
    1 => ['icon' => 'ph ph-hand-heart', 'bg' => 'var(--brand-50)', 'color' => 'var(--brand-500)', 'tag' => 'الأكثر طلباً'],
    2 => ['icon' => 'ph ph-sparkle', 'bg' => 'var(--accent-50)', 'color' => 'var(--accent-500)', 'tag' => 'جديد'],
    3 => ['icon' => 'ph ph-drop', 'bg' => 'var(--success-bg)', 'color' => 'var(--success)', 'tag' => 'مميز'],
    4 => ['icon' => 'ph ph-flower-lotus', 'bg' => 'var(--warning-bg)', 'color' => 'var(--warning)', 'tag' => ''],
    5 => ['icon' => 'ph ph-fire', 'bg' => 'var(--error-bg)', 'color' => 'var(--error)', 'tag' => 'عرض خاص'],
    6 => ['icon' => 'ph ph-leaf', 'bg' => 'var(--info-bg)', 'color' => 'var(--info)', 'tag' => ''],
];
@endphp
<section id="services" class="section-lg" style="background: var(--surface);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Section Header --}}
        <div class="text-center mb-16">
            <span class="badge badge-brand mb-4">
                <i class="ph ph-star-four"></i>
                خدمات مميزة
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4" style="color: var(--ink);">
                خدماتنا <span class="gradient-text">المختارة</span>
            </h2>
            <p class="text-lg max-w-2xl mx-auto" style="color: var(--ink-muted);">
                كل خدمة مصممة بعناية فائقة لتمنحكِ تجربة جمالية لا تُنسى
            </p>
        </div>

        {{-- Services Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
            @foreach($featuredServices as $service)
            @php $meta = $serviceMeta[$service->id] ?? ['icon' => 'ph ph-spa', 'bg' => 'var(--brand-50)', 'color' => 'var(--brand-500)', 'tag' => '']; @endphp
            <div class="card group cursor-pointer">
                {{-- Image Area --}}
                <div class="relative aspect-square overflow-hidden" style="background: {{ $meta['bg'] }};">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="{{ $meta['icon'] }} text-5xl lg:text-6xl transition-all duration-500 group-hover:scale-110" style="color: {{ $meta['color'] }};"></i>
                    </div>

                    {{-- Tag --}}
                    @if($service->is_on_sale)
                    <div class="absolute top-3 left-3 badge" style="background: var(--brand-500); color: white;">
                        تخفيض
                    </div>
                    @elseif(!empty($meta['tag']))
                    <div class="absolute top-3 left-3 badge" style="background: {{ $meta['color'] }}; color: white;">
                        {{ $meta['tag'] }}
                    </div>
                    @endif

                    {{-- Hover Overlay --}}
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300" style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
                        <a href="{{ route('booking') }}?service={{ $service->id }}" class="btn btn-primary py-2.5 px-5 text-sm translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            احجزي الآن
                        </a>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-4 lg:p-5">
                    {{-- Rating --}}
                    <div class="flex items-center gap-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="ph-fill ph-star text-xs" style="color: {{ $i <= 4 ? 'var(--accent-500)' : 'var(--neutral-200)' }};"></i>
                        @endfor
                        <span class="text-xs mr-1" style="color: var(--ink-dim);">(24)</span>
                    </div>

                    {{-- Name --}}
                    <h3 class="text-sm lg:text-base font-bold mb-2 line-clamp-1" style="color: var(--ink);">
                        {{ $service->name }}
                    </h3>

                    {{-- Price --}}
                    <div class="flex items-center gap-2">
                        @if($service->is_on_sale)
                        <span class="text-base font-bold" style="color: var(--brand-600);">{{ number_format($service->final_price, 0) }} ₪</span>
                        <span class="text-sm line-through" style="color: var(--ink-dim);">{{ number_format($service->price, 0) }} ₪</span>
                        @else
                        <span class="text-base font-bold" style="color: var(--ink);">{{ number_format($service->price, 0) }} ₪</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- View All --}}
        <div class="text-center mt-12">
            <a href="{{ route('booking') }}" class="btn btn-secondary">
                <span>عرض جميع الخدمات</span>
                <i class="ph ph-arrow-left"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     WHY CHOOSE US
     ═══════════════════════════════════════════════════════════════ --}}
<section class="section-lg" style="background: var(--surface-alt);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Section Header --}}
        <div class="text-center mb-16">
            <span class="badge badge-brand mb-4">
                <i class="ph ph-heart"></i>
                لماذا سماح كير
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4" style="color: var(--ink);">
                تجربة <span class="gradient-text">استثنائية</span>
            </h2>
            <p class="text-lg max-w-2xl mx-auto" style="color: var(--ink-muted);">
                نجمع بين الاحترافية والاهتمام الشخصي لنقدم لكِ أفضل تجربة جمالية
            </p>
        </div>

        {{-- Features Grid --}}
        <div class="grid md:grid-cols-3 gap-8">
            @php
                $features = [
                    [
                        'icon' => 'ph ph-certificate',
                        'title' => 'خبيرات معتمدات',
                        'desc' => 'فريقنا من الخبيرات المعتمدات يضمن لكِ أعلى معايير الجودة والاحترافية في كل جلسة.',
                        'bg' => 'var(--brand-50)',
                        'color' => 'var(--brand-500)',
                    ],
                    [
                        'icon' => 'ph ph-calendar-check',
                        'title' => 'حجز سهل وسريع',
                        'desc' => 'احجزي موعدكِ أونلاين في ثوانٍ. اختاري الخدمة والوقت المناسب واستمتعي بتجربة سلسة.',
                        'bg' => 'var(--accent-50)',
                        'color' => 'var(--accent-500)',
                    ],
                    [
                        'icon' => 'ph ph-shield-star',
                        'title' => 'منتجات أصلية',
                        'desc' => 'نستخدم فقط المنتجات الأصلية من أشهر الماركات العالمية لضمان أفضل النتائج لبشرتكِ.',
                        'bg' => 'var(--success-bg)',
                        'color' => 'var(--success)',
                    ],
                ];
            @endphp

            @foreach($features as $feature)
            <div class="card p-8 text-center group">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 transition-all duration-300 group-hover:scale-110 group-hover:rotate-6" style="background: {{ $feature['bg'] }};">
                    <i class="{{ $feature['icon'] }} text-4xl" style="color: {{ $feature['color'] }};"></i>
                </div>
                <h3 class="text-xl font-bold mb-3" style="color: var(--ink);">{{ $feature['title'] }}</h3>
                <p class="text-base leading-relaxed" style="color: var(--ink-muted);">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     TESTIMONIALS
     ═══════════════════════════════════════════════════════════════ --}}
<section class="section-lg" style="background: var(--surface);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Section Header --}}
        <div class="text-center mb-16">
            <span class="badge badge-brand mb-4">
                <i class="ph ph-chat-circle-text"></i>
                آراء العميلات
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4" style="color: var(--ink);">
                ماذا تقول <span class="gradient-text">عميلاتنا</span>
            </h2>
            <p class="text-lg max-w-2xl mx-auto" style="color: var(--ink-muted);">
                تجارب حقيقية من عميلات سعيدات اخترن سماح كير
            </p>
        </div>

        {{-- Testimonials Grid --}}
        <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
            @php
                $testimonials = [
                    [
                        'name' => 'سارة أحمد',
                        'role' => 'عميلة منتظمة',
                        'text' => 'تجربة رائعة! الخدمة احترافية والنتائج فاقت توقعاتي بمراحل. أنصح كل فتاة بتجربة خدمات العناية بالبشرة هنا.',
                        'rating' => 5,
                        'initial' => 'س',
                        'bg' => 'var(--brand-100)',
                    ],
                    [
                        'name' => 'نور محمد',
                        'role' => 'عميلة جديدة',
                        'text' => 'أول مرة أحجز أونلاين وكانت التجربة سهلة جداً ومريحة. الفريق محترف والاهتمام بأدق التفاصيل واضح من أول لحظة.',
                        'rating' => 5,
                        'initial' => 'ن',
                        'bg' => 'var(--accent-100)',
                    ],
                    [
                        'name' => 'ليلى خالد',
                        'role' => 'عميلة VIP',
                        'text' => 'من أفضل المراكز التي تعاملت معها على الإطلاق. الجودة عالية جداً والأسعار معقولة. شكراً سماح كير على التميز!',
                        'rating' => 5,
                        'initial' => 'ل',
                        'bg' => 'var(--success-bg)',
                    ],
                ];
            @endphp

            @foreach($testimonials as $testimonial)
            <div class="card p-6 lg:p-8">
                {{-- Stars --}}
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="ph-fill ph-star text-lg" style="color: {{ $i <= $testimonial['rating'] ? 'var(--accent-500)' : 'var(--neutral-200)' }};"></i>
                    @endfor
                </div>

                {{-- Quote --}}
                <p class="text-base leading-relaxed mb-6" style="color: var(--ink-muted);">
                    "{{ $testimonial['text'] }}"
                </p>

                {{-- Author --}}
                <div class="flex items-center gap-3 pt-4" style="border-top: var(--border-subtle);">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: {{ $testimonial['bg'] }};">
                        <span class="text-lg font-bold" style="color: var(--brand-600);">{{ $testimonial['initial'] }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold" style="color: var(--ink);">{{ $testimonial['name'] }}</p>
                        <p class="text-xs" style="color: var(--ink-dim);">{{ $testimonial['role'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     CATEGORIES PREVIEW
     ═══════════════════════════════════════════════════════════════ --}}
<section class="section-lg" style="background: var(--surface-alt);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Section Header --}}
        <div class="text-center mb-16">
            <span class="badge badge-brand mb-4">
                <i class="ph ph-grid-four"></i>
                تصفحي حسب الفئة
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4" style="color: var(--ink);">
                فئات <span class="gradient-text">خدماتنا</span>
            </h2>
        </div>

        {{-- Categories Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
            @php
                $categories = [
                    ['icon' => 'ph ph-sparkle', 'name' => 'العناية بالبشرة', 'count' => '12 خدمة', 'bg' => 'var(--brand-50)', 'color' => 'var(--brand-500)'],
                    ['icon' => 'ph ph-eye', 'name' => 'المكياج', 'count' => '8 خدمات', 'bg' => 'var(--accent-50)', 'color' => 'var(--accent-500)'],
                    ['icon' => 'ph ph-scissors', 'name' => 'العناية بالشعر', 'count' => '10 خدمات', 'bg' => 'var(--success-bg)', 'color' => 'var(--success)'],
                    ['icon' => 'ph ph-hand-heart', 'name' => 'العناية بالأظافر', 'count' => '6 خدمات', 'bg' => 'var(--info-bg)', 'color' => 'var(--info)'],
                ];
            @endphp

            @foreach($categories as $cat)
            <a href="{{ route('booking') }}" class="card p-6 lg:p-8 text-center group cursor-pointer">
                <div class="w-16 h-16 lg:w-20 lg:h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-all duration-300 group-hover:scale-110" style="background: {{ $cat['bg'] }};">
                    <i class="{{ $cat['icon'] }} text-3xl lg:text-4xl" style="color: {{ $cat['color'] }};"></i>
                </div>
                <h3 class="text-base lg:text-lg font-bold mb-1" style="color: var(--ink);">{{ $cat['name'] }}</h3>
                <p class="text-sm" style="color: var(--ink-dim);">{{ $cat['count'] }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     BLOG PREVIEW
     ═══════════════════════════════════════════════════════════════ --}}
<section class="section-lg" style="background: var(--surface);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Section Header --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12">
            <div>
                <span class="badge badge-brand mb-4">
                    <i class="ph ph-article"></i>
                    المدونة
                </span>
                <h2 class="text-3xl md:text-4xl font-black" style="color: var(--ink);">
                    نصائح <span class="gradient-text">الجمال</span>
                </h2>
            </div>
            <a href="{{ route('blog.index') }}" class="btn btn-secondary mt-4 md:mt-0">
                <span>جميع المقالات</span>
                <i class="ph ph-arrow-left"></i>
            </a>
        </div>

        {{-- Blog Grid --}}
        <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
            @php
                $blogPosts = [
                    ['title' => '10 نصائح ذهبية للعناية بالبشرة في الصيف', 'excerpt' => 'تعرفي على أفضل الطرق للحفاظ على بشرتكِ مشرقة وصحية خلال فصل الصيف الحار.', 'icon' => 'ph ph-sun', 'category' => 'عناية بالبشرة', 'bg' => 'var(--warning-bg)', 'color' => 'var(--warning)'],
                    ['title' => 'أحدث صيحات المكياج الطبيعي لعام 2024', 'excerpt' => 'اكتشفي أبرز اتجاهات المكياج التي تبرز جمالكِ الطبيعي بإطلالة ناعمة وأنيقة.', 'icon' => 'ph ph-palette', 'category' => 'مكياج', 'bg' => 'var(--brand-50)', 'color' => 'var(--brand-500)'],
                    ['title' => 'دليلكِ الشامل للعناية بالشعر المجعد', 'excerpt' => 'نصائح وحيل احترافية للتعامل مع الشعر المجعد والحصول على تموجات مثالية.', 'icon' => 'ph ph-wind', 'category' => 'عناية بالشعر', 'bg' => 'var(--success-bg)', 'color' => 'var(--success)'],
                ];
            @endphp

            @foreach($blogPosts as $post)
            <article class="card group cursor-pointer">
                {{-- Image Area --}}
                <div class="aspect-[16/10] relative overflow-hidden" style="background: {{ $post['bg'] }};">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="{{ $post['icon'] }} text-5xl transition-transform duration-500 group-hover:scale-110" style="color: {{ $post['color'] }};"></i>
                    </div>
                    <div class="absolute top-3 right-3 badge" style="background: white; color: var(--ink);">
                        {{ $post['category'] }}
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-5 lg:p-6">
                    <h3 class="text-lg font-bold mb-2 line-clamp-2 group-hover:text-[var(--brand-600)] transition-colors" style="color: var(--ink);">
                        {{ $post['title'] }}
                    </h3>
                    <p class="text-sm leading-relaxed mb-4 line-clamp-2" style="color: var(--ink-muted);">
                        {{ $post['excerpt'] }}
                    </p>
                    <span class="inline-flex items-center gap-1 text-sm font-semibold group-hover:gap-2 transition-all" style="color: var(--brand-600);">
                        اقرأ المزيد
                        <i class="ph ph-arrow-left text-xs"></i>
                    </span>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     NEWSLETTER
     ═══════════════════════════════════════════════════════════════ --}}
<section class="section-lg relative overflow-hidden" style="background: var(--gradient-primary);">
    {{-- Decorative --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full opacity-20" style="background: white;"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 rounded-full opacity-10" style="background: white;"></div>
    </div>

    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-8" style="background: rgba(255,255,255,0.15);">
            <i class="ph ph-envelope-simple text-4xl text-white"></i>
        </div>
        <h2 class="text-3xl md:text-4xl font-black mb-4 text-white">
            اشتركي في نشرتنا
        </h2>
        <p class="text-lg mb-8 text-white/80">
            احصلي على أحدث العروض والنصائح الجمالية مباشرة في بريدكِ
        </p>
        <form class="flex flex-col sm:flex-row items-center gap-3 max-w-md mx-auto">
            <input type="email" placeholder="بريدكِ الإلكتروني" class="flex-1 w-full px-6 py-4 rounded-full text-base" style="background: white; color: var(--ink); border: none;">
            <button type="submit" class="w-full sm:w-auto px-8 py-4 rounded-full font-bold text-base transition-all hover:scale-105" style="background: var(--ink); color: white;">
                اشتركي الآن
            </button>
        </form>
        <p class="text-sm mt-4 text-white/60">لن نشارك بريدكِ مع أي طرف ثالث</p>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     FINAL CTA
     ═══════════════════════════════════════════════════════════════ --}}
<section class="section-lg" style="background: var(--surface);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-8" style="background: var(--brand-50);">
            <i class="ph ph-calendar-check text-5xl" style="color: var(--brand-500);"></i>
        </div>
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-6" style="color: var(--ink);">
            مستعدة لتجربة
            <span class="gradient-text">جمال استثنائي؟</span>
        </h2>
        <p class="text-lg mb-10 max-w-xl mx-auto" style="color: var(--ink-muted);">
            انضمي إلى آلاف العميلات السعيدات واحجزي موعدكِ الآن
        </p>
        <a href="{{ route('booking') }}" class="btn btn-primary text-lg px-10 py-5">
            <span>احجزي موعدكِ الآن</span>
            <i class="ph ph-arrow-left"></i>
        </a>
    </div>
</section>

@endsection
