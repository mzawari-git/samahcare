@extends('frontend.layouts.app-v2')

@section('title', ($siteSettings['site_name'] ?? 'JeniCare') . ' | جنين للتجميل')

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "{{ $siteSettings['site_name'] ?? 'JeniCare' }}",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('assets/images/logo.png') }}",
  "description": "منصة العناية بالشعر والبشرة الأولى في فلسطين - منتجات أصلية 100%",
  "address": { "@type": "PostalAddress", "addressLocality": "رام الله", "addressCountry": "PS" },
  "contactPoint": { "@type": "ContactPoint", "telephone": "{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}", "contactType": "customer service" },
  "sameAs": ["{{ $siteSettings['facebook_url'] ?? '#' }}", "{{ $siteSettings['instagram_url'] ?? '#' }}"]
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "{{ $siteSettings['site_name'] ?? 'JeniCare' }}",
  "url": "{{ url('/') }}",
  "potentialAction": { "@type": "SearchAction", "target": "{{ url('/shop') }}?search={search_term_string}", "query-input": "required name=search_term_string" }
}
</script>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     القسم الرئيسي (Hero Section) - تصميم احترافي مع سلايدشو
     ═══════════════════════════════════════════════════════════════ --}}
<section class="relative min-h-[90vh] flex items-center overflow-hidden {{ $slides->isNotEmpty() && $slides->first()->parallax ? 'bg-fixed' : '' }}">
    {{-- فيديو خلفية إذا كان متاحا في الشريحة الأولى --}}
    @php
        $firstSlide = $slides->isNotEmpty() ? $slides->first() : null;
        $activeVideo = $firstSlide && $firstSlide->video_url;
        $gradientFrom = $firstSlide ? ($firstSlide->gradient_from ?: '#FDF2F8') : '#FDF2F8';
        $gradientTo = $firstSlide ? ($firstSlide->gradient_to ?: '#FFF1F2') : '#FFF1F2';
        $overlayOpacity = $firstSlide ? floatval($firstSlide->overlay_opacity) : 0.30;
        $textColor = $firstSlide ? ($firstSlide->text_color ?: '#262626') : '#262626';
        $textAlign = $firstSlide ? ($firstSlide->text_align ?: 'right') : 'right';
        $imagePosition = $firstSlide ? ($firstSlide->image_position ?: 'right') : 'right';
        $contentWidth = $firstSlide ? ($firstSlide->content_width ?: 'container') : 'container';
        $fullWidthImage = $firstSlide && $firstSlide->full_width_image;
    @endphp

    @if($activeVideo)
    <div class="absolute inset-0 z-0">
        @if(str_contains($activeVideo, 'youtube.com') || str_contains($activeVideo, 'youtu.be'))
            @php
                preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $activeVideo, $matches);
                $videoId = $matches[1] ?? '';
            @endphp
            @if($videoId)
            <iframe src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&controls=0&loop=1&playlist={{ $videoId }}&playsinline=1"
                class="absolute inset-0 w-full h-full object-cover scale-150" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            @endif
        @elseif(str_contains($activeVideo, 'vimeo.com'))
            @php preg_match('/vimeo\.com\/(\d+)/', $activeVideo, $vmatch); $vimeoId = $vmatch[1] ?? ''; @endphp
            @if($vimeoId)
            <iframe src="https://player.vimeo.com/video/{{ $vimeoId }}?autoplay=1&mute=1&loop=1&background=1"
                class="absolute inset-0 w-full h-full object-cover scale-150" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
            @endif
        @else
            <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
                <source src="{{ $activeVideo }}" type="video/mp4">
            </video>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-ink/{{ intval($overlayOpacity * 100) < 10 ? 10 : intval($overlayOpacity * 100) }} via-ink/{{ max(0, intval($overlayOpacity * 50)) }} to-transparent z-10"></div>
    </div>
    @endif

    {{-- خلفيات زخرفية متحركة (إذا لا يوجد فيديو) --}}
    @if(!$activeVideo)
    <div class="absolute inset-0" style="background: linear-gradient(135deg, {{ $gradientFrom }} 0%, {{ $gradientTo }} 50%, #fff 100%);"></div>
    <div class="blob bg-gradient-to-br from-brand-100 to-pink-100 w-[600px] h-[600px] top-[-200px] right-[-200px] animate-pulse" style="animation-delay:0.5s;"></div>
    <div class="blob bg-gradient-to-br from-purple-100 to-brand-100 w-[500px] h-[500px] bottom-[-150px] left-[-150px] animate-pulse" style="animation-delay: 1.5s;"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23d97a8c&quot; fill-opacity=&quot;0.04&quot;%3E%3Ccircle cx=&quot;30&quot; cy=&quot;30&quot; r=&quot;1&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full pt-28 pb-16 {{ $contentWidth === 'container-fluid' ? 'max-w-none' : '' }}">
        @if($slides->isNotEmpty() && $slides->count() > 1)
            {{-- ═══ سلايدشو متعدد الشرائح ═══ --}}
            <div class="relative" id="heroSlideshow">
                @foreach($slides as $index => $slide)
                <div class="hero-slide grid grid-cols-1 lg:grid-cols-2 gap-12 items-center transition-all duration-1000 {{ $index === 0 ? 'block' : 'hidden' }}"
                     data-slide="{{ $index }}"
                     style="--text-color: {{ $slide->text_color ?: '#262626' }}; --text-align: {{ $slide->text_align === 'center' ? 'center' : ($slide->text_align === 'left' ? 'left' : 'right') }};">

                    {{-- النص --}}
                    <div class="order-2 lg:order-1 {{ $slide->text_align === 'center' ? 'text-center' : ($slide->text_align === 'left' ? 'lg:text-left' : 'lg:text-right') }}">
                        @if($slide->badge_text_ar)
                        <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/90 backdrop-blur-md border border-brand-200/50 shadow-lg text-sm text-brand-700 font-semibold mb-6 animate-slide-down">
                            <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                            <span>{{ $slide->badge_text_ar }}</span>
                        </div>
                        @elseif($slide->subtitle_ar)
                        <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/90 backdrop-blur-md border border-brand-200/50 shadow-lg text-sm text-brand-700 font-semibold mb-6 animate-slide-down">
                            <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                            <span>{{ $slide->subtitle_ar }}</span>
                        </div>
                        @endif

                        <h1 class="text-5xl lg:text-7xl font-extrabold leading-[1.1] mb-6" style="color: {{ $slide->text_color ?: '#262626' }};">
                            @if($slide->title_ar)
                                {!! nl2br(e($slide->title_ar)) !!}
                            @else
                                تألقي بثقة،<br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-l from-brand-600 via-brand-500 to-pink-500 animate-gradient-shift">أنتِ تستحقين الأفضل.</span>
                            @endif
                        </h1>

                        @if($slide->description_ar)
                        <p class="text-lg lg:text-xl leading-relaxed font-light mb-8 max-w-lg {{ $slide->text_align === 'center' ? 'mx-auto' : ($slide->text_align === 'left' ? '' : 'lg:mr-0 lg:ml-auto') }}" style="color: {{ ($textColor === '#262626' && $slide->text_color) ? $slide->text_color : '#4B5563' }}; opacity:0.9;">
                            {{ $slide->description_ar }}
                        </p>
                        @endif

                        <div class="flex flex-col sm:flex-row gap-4 {{ $slide->text_align === 'center' ? 'justify-center' : ($slide->text_align === 'left' ? 'justify-start' : 'lg:justify-start justify-center') }}">
                            @if($slide->button_text_ar && $slide->button_url)
                            <a href="{{ $slide->button_url }}" class="group relative px-8 sm:px-10 py-4 sm:py-5 bg-gradient-to-r from-ink to-brand-600 text-white rounded-full font-bold overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-500 flex items-center justify-center gap-3 transform hover:-translate-y-1 text-base sm:text-lg touch-target">
                                <span class="relative z-10">{{ $slide->button_text_ar }}</span>
                                <i class="ph ph-arrow-left relative z-10 group-hover:-translate-x-2 transition-transform duration-300"></i>
                                <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-pink-500 transform scale-x-0 group-hover:scale-x-100 origin-right transition-transform duration-700 ease-out z-0"></div>
                            </a>
                            @else
                            <a href="{{ route('shop') }}" class="group relative px-8 sm:px-10 py-4 sm:py-5 bg-gradient-to-r from-ink to-brand-600 text-white rounded-full font-bold overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-500 flex items-center justify-center gap-3 transform hover:-translate-y-1 text-base sm:text-lg touch-target">
                                <span class="relative z-10">تسوقي المجموعة</span>
                                <i class="ph ph-arrow-left relative z-10 group-hover:-translate-x-2 transition-transform duration-300"></i>
                                <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-pink-500 transform scale-x-0 group-hover:scale-x-100 origin-right transition-transform duration-700 ease-out z-0"></div>
                            </a>
                            @endif

                            @if($slide->second_button_text_ar && $slide->second_button_url)
                            <a href="{{ $slide->second_button_url }}" class="group relative px-6 sm:px-8 py-4 sm:py-5 bg-white/90 backdrop-blur-md text-ink rounded-full font-bold border-2 border-brand-200 hover:border-brand-500 hover:text-brand-600 transition-all duration-300 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-base sm:text-lg touch-target">
                                <i class="ph ph-sparkle text-xl"></i>
                                <span>{{ $slide->second_button_text_ar }}</span>
                            </a>
                            @else
                            <a href="{{ route('shop') }}?sort=newest" class="group relative px-6 sm:px-8 py-4 sm:py-5 bg-white/90 backdrop-blur-md text-ink rounded-full font-bold border-2 border-brand-200 hover:border-brand-500 hover:text-brand-600 transition-all duration-300 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-base sm:text-lg touch-target">
                                <i class="ph ph-sparkle text-xl group-hover:animate-spin-slow"></i>
                                <span>وصل حديثاً</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- الصورة --}}
                    <div class="order-1 lg:order-2 relative flex justify-center items-center {{ $slide->image_position === 'background' ? '' : 'lg:h-[600px]' }}">
                        @if($slide->image_position === 'background' && $slide->image_url)
                            <div class="absolute inset-0 -m-8 z-0">
                                <img src="{{ $slide->image_url }}" alt="{{ $slide->title_ar }}" class="w-full h-full object-cover rounded-[40px] {{ $slide->parallax ? 'parallax-bg' : '' }}">
                                <div class="absolute inset-0 rounded-[40px]" style="background: linear-gradient(to top, rgba(38,38,38,{{ $overlayOpacity }}), rgba(38,38,38,0));"></div>
                            </div>
                        @else
                            <div class="relative {{ $fullWidthImage ? 'w-full' : 'w-[320px] md:w-[420px]' }} h-[420px] md:h-[520px]">
                                <div class="relative w-full h-full rounded-[40px] overflow-hidden shadow-2xl z-20 {{ $slide->animation_type === 'zoom' ? 'animate-zoom-in' : ($slide->animation_type === 'slide' ? 'animate-slide-in' : 'animate-fade-in') }}">
                                    @if($slide->image_url)
                                    <img src="{{ $slide->image_url }}" alt="{{ $slide->title_ar }}" class="w-full h-full object-cover {{ $slide->parallax ? 'parallax-img' : '' }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}" onerror="this.outerHTML='<div class=&quot;w-full h-full bg-gradient-to-br from-brand-100 to-pink-100 flex items-center justify-center&quot;><i class=&quot;ph ph-sparkle text-6xl text-brand-300&quot;></i></div>'">
                                    @elseif($slide->product && $slide->product->main_image_url)
                                    <img src="{{ $slide->product->main_image_url }}" alt="{{ $slide->product->name_ar }}" class="w-full h-full object-cover" loading="lazy">
                                    @else
                                    <div class="w-full h-full bg-gradient-to-br from-brand-100 to-pink-100 flex items-center justify-center">
                                        <i class="ph ph-sparkle text-6xl text-brand-300"></i>
                                    </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-ink/{{ intval($overlayOpacity * 100) < 10 ? 10 : intval($overlayOpacity * 100) }} via-transparent to-transparent"></div>
                                </div>
                                {{-- إطارات زخرفية --}}
                                <div class="absolute w-full h-full rounded-[40px] border-2 border-brand-500/20 -rotate-6 top-4 z-10 animate-rotate-slow"></div>
                                <div class="absolute w-full h-full rounded-[40px] border border-brand-300/10 rotate-3 top-6 z-10 animate-rotate-slow" style="animation-delay: 2s;"></div>

                                {{-- بطاقات طافية --}}
                                <div class="absolute top-8 -right-6 md:-right-12 bg-white/95 backdrop-blur-lg p-4 rounded-3xl shadow-2xl flex items-center gap-3 w-52 border border-white/50 animate-bounce-slow z-40">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-500 flex items-center justify-center text-white shadow-lg">
                                        <i class="ph-fill ph-check-circle text-2xl"></i>
                                    </div>
                                    <div><p class="text-xs text-gray-500 font-medium">ضمان الجودة</p><p class="text-sm font-bold text-ink">100% أصلي</p></div>
                                </div>
                                <div class="absolute bottom-12 -left-6 md:-left-12 bg-white/95 backdrop-blur-lg p-4 rounded-3xl shadow-2xl border border-white/50 animate-bounce-slow z-40" style="animation-delay: 0.5s;">
                                    <div class="flex -space-x-3 space-x-reverse mb-3">
                                        <div class="w-10 h-10 rounded-full border-3 border-white bg-gradient-to-br from-brand-400 to-brand-500 flex items-center justify-center text-[10px] text-white font-bold shadow-lg">J</div>
                                        <div class="w-10 h-10 rounded-full border-3 border-white bg-gradient-to-br from-brand-300 to-brand-400 flex items-center justify-center text-[10px] text-white font-bold shadow-lg">C</div>
                                        <div class="w-10 h-10 rounded-full border-3 border-white bg-gradient-to-br from-pink-400 to-pink-500 flex items-center justify-center text-xs text-white font-bold shadow-lg">+{{ \App\Models\Product::count() }}</div>
                                    </div>
                                    <p class="text-xs font-bold text-ink">{{ \App\Models\Product::count() }} منتج متاح</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach

                {{-- أزرار تحكم السلايدشو --}}
                <button onclick="previousSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center text-ink hover:bg-white hover:shadow-xl transition-all duration-300 shadow-lg z-30">
                    <i class="ph ph-arrow-right text-xl"></i>
                </button>
                <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center text-ink hover:bg-white hover:shadow-xl transition-all duration-300 shadow-lg z-30">
                    <i class="ph ph-arrow-left text-xl"></i>
                </button>

                {{-- مؤشرات --}}
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-30">
                    @foreach($slides as $idx => $slide)
                    <button onclick="goToSlide({{ $idx }})" class="hero-indicator w-2 h-2 rounded-full transition-all duration-300 {{ $idx === 0 ? 'w-8 bg-white' : 'bg-white/60' }}" data-indicator="{{ $idx }}"></button>
                    @endforeach
                </div>
            </div>
        @elseif($slides->isNotEmpty())
            {{-- ═══ شريحة واحدة ═══ --}}
            @php $slide = $slides->first(); @endphp
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1 {{ $slide->text_align === 'center' ? 'text-center' : ($slide->text_align === 'left' ? 'lg:text-left' : 'lg:text-right') }}">
                    @if($slide->badge_text_ar)
                    <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/90 backdrop-blur-md border border-brand-200/50 shadow-lg text-sm text-brand-700 font-semibold mb-6 animate-slide-down">
                        <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                        <span>{{ $slide->badge_text_ar }}</span>
                    </div>
                    @elseif($slide->subtitle_ar)
                    <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/90 backdrop-blur-md border border-brand-200/50 shadow-lg text-sm text-brand-700 font-semibold mb-6 animate-slide-down">
                        <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                        <span>{{ $slide->subtitle_ar }}</span>
                    </div>
                    @endif

                    <div class="relative mb-8">
                        <h1 class="text-5xl lg:text-7xl font-extrabold leading-[1.1] relative" style="color: {{ $slide->text_color ?: '#262626' }};">
                            @if($slide->title_ar)
                                {!! nl2br(e($slide->title_ar)) !!}
                            @else
                                <span class="animate-text-glow">تألقي بثقة،</span><br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-l from-brand-600 via-brand-500 to-pink-500 animate-gradient-shift">أنتِ تستحقين الأفضل.</span>
                            @endif
                        </h1>
                        <div class="absolute inset-0 bg-gradient-to-r from-brand-500/20 to-pink-500/20 blur-3xl -z-10 animate-pulse"></div>
                    </div>

                    @if($slide->description_ar)
                    <div class="mb-10 max-w-lg {{ $slide->text_align === 'center' ? 'mx-auto' : ($slide->text_align === 'left' ? '' : 'lg:mr-0 lg:ml-auto') }} animate-fade-in-up" style="animation-delay: 0.3s;">
                        <p class="text-lg lg:text-xl leading-relaxed font-light" style="color: #4B5563; opacity:0.9;">
                            {{ $slide->description_ar }}
                        </p>
                    </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-4 {{ $slide->text_align === 'center' ? 'justify-center' : ($slide->text_align === 'left' ? 'justify-start' : 'lg:justify-start justify-center') }} animate-fade-in-up" style="animation-delay: 0.6s;">
                        @if($slide->button_text_ar && $slide->button_url)
                        <a href="{{ $slide->button_url }}" class="group relative px-10 py-4 bg-gradient-to-r from-ink to-brand-600 text-white rounded-full font-bold overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-500 flex items-center justify-center gap-3 transform hover:-translate-y-1">
                            <span class="relative z-10">{{ $slide->button_text_ar }}</span>
                            <i class="ph ph-arrow-left relative z-10 group-hover:-translate-x-2 transition-transform duration-300"></i>
                            <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-pink-500 transform scale-x-0 group-hover:scale-x-100 origin-right transition-transform duration-700 ease-out z-0"></div>
                        </a>
                        @else
                        <a href="{{ route('shop') }}" class="group relative px-10 py-4 bg-gradient-to-r from-ink to-brand-600 text-white rounded-full font-bold overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-500 flex items-center justify-center gap-3 transform hover:-translate-y-1">
                            <span class="relative z-10">تسوقي المجموعة</span>
                            <i class="ph ph-arrow-left relative z-10 group-hover:-translate-x-2 transition-transform duration-300"></i>
                            <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-pink-500 transform scale-x-0 group-hover:scale-x-100 origin-right transition-transform duration-700 ease-out z-0"></div>
                        </a>
                        @endif
                        @if($slide->second_button_text_ar && $slide->second_button_url)
                        <a href="{{ $slide->second_button_url }}" class="group relative px-8 py-4 bg-white/90 backdrop-blur-md text-ink rounded-full font-bold border-2 border-brand-200 hover:border-brand-500 hover:text-brand-600 transition-all duration-300 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="ph ph-sparkle text-xl"></i>
                            <span>{{ $slide->second_button_text_ar }}</span>
                        </a>
                        @else
                        <a href="{{ route('shop') }}?sort=newest" class="group relative px-8 py-4 bg-white/90 backdrop-blur-md text-ink rounded-full font-bold border-2 border-brand-200 hover:border-brand-500 hover:text-brand-600 transition-all duration-300 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="ph ph-sparkle text-xl group-hover:animate-spin-slow"></i>
                            <span>وصل حديثاً</span>
                        </a>
                        @endif
                    </div>
                </div>

                <div class="order-1 lg:order-2 relative flex justify-center items-center {{ $slide->image_position === 'background' ? '' : 'lg:h-[600px]' }}">
                    @if($slide->image_position === 'background' && $slide->image_url)
                        <div class="absolute inset-0 -m-8 z-0">
                            <img src="{{ $slide->image_url }}" alt="{{ $slide->title_ar }}" class="w-full h-full object-cover rounded-[40px] {{ $slide->parallax ? 'parallax-bg' : '' }}">
                            <div class="absolute inset-0 rounded-[40px]" style="background: linear-gradient(to top, rgba(38,38,38,{{ $overlayOpacity }}), rgba(38,38,38,0));"></div>
                        </div>
                    @else
                        <div class="relative {{ $fullWidthImage ? 'w-full' : 'w-[320px] md:w-[420px]' }} h-[420px] md:h-[520px]">
                            <div class="relative w-full h-full rounded-[40px] overflow-hidden shadow-2xl z-20 {{ $slide->animation_type === 'zoom' ? 'animate-zoom-in' : ($slide->animation_type === 'slide' ? 'animate-slide-in' : 'animate-fade-in') }}">
                                @if($slide->image_url)
                                <img src="{{ $slide->image_url }}" alt="{{ $slide->title_ar }}" class="w-full h-full object-cover {{ $slide->parallax ? 'parallax-img' : '' }}" loading="eager" onerror="this.outerHTML='<div class=&quot;w-full h-full bg-gradient-to-br from-brand-100 to-pink-100 flex items-center justify-center&quot;><i class=&quot;ph ph-sparkle text-6xl text-brand-300&quot;></i></div>'">
                                @elseif($featuredProducts->isNotEmpty() && $featuredProducts->first()->main_image_url)
                                <img src="{{ $featuredProducts->first()->main_image_url }}" alt="Beauty" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-gradient-to-br from-brand-100 to-pink-100 flex items-center justify-center">
                                    <i class="ph ph-sparkle text-6xl text-brand-300"></i>
                                </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-ink/{{ intval($overlayOpacity * 100) < 10 ? 10 : intval($overlayOpacity * 100) }} via-transparent to-transparent"></div>
                            </div>
                            <div class="absolute w-full h-full rounded-[40px] border-2 border-brand-500/20 -rotate-6 top-4 z-10 animate-rotate-slow"></div>
                            <div class="absolute w-full h-full rounded-[40px] border border-brand-300/10 rotate-3 top-6 z-10 animate-rotate-slow" style="animation-delay: 2s;"></div>

                            <div class="absolute top-8 -right-6 md:-right-12 bg-white/95 backdrop-blur-lg p-4 rounded-3xl shadow-2xl flex items-center gap-3 w-52 border border-white/50 animate-bounce-slow z-40">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-500 flex items-center justify-center text-white shadow-lg">
                                    <i class="ph-fill ph-check-circle text-2xl"></i>
                                </div>
                                <div><p class="text-xs text-gray-500 font-medium">ضمان الجودة</p><p class="text-sm font-bold text-ink">100% أصلي</p></div>
                            </div>
                            <div class="absolute bottom-12 -left-6 md:-left-12 bg-white/95 backdrop-blur-lg p-4 rounded-3xl shadow-2xl border border-white/50 animate-bounce-slow z-40" style="animation-delay: 0.5s;">
                                <div class="flex -space-x-3 space-x-reverse mb-3">
                                    <div class="w-10 h-10 rounded-full border-3 border-white bg-gradient-to-br from-brand-400 to-brand-500 flex items-center justify-center text-[10px] text-white font-bold shadow-lg">J</div>
                                    <div class="w-10 h-10 rounded-full border-3 border-white bg-gradient-to-br from-brand-300 to-brand-400 flex items-center justify-center text-[10px] text-white font-bold shadow-lg">C</div>
                                    <div class="w-10 h-10 rounded-full border-3 border-white bg-gradient-to-br from-pink-400 to-pink-500 flex items-center justify-center text-xs text-white font-bold shadow-lg">+{{ \App\Models\Product::count() }}</div>
                                </div>
                                <p class="text-xs font-bold text-ink">{{ \App\Models\Product::count() }} منتج متاح</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            {{-- ═══ سقوط للخلف (بدون شرائح) ═══ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1 text-center lg:text-right">
                    <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-white/90 to-white/60 border border-brand-200/50 shadow-lg backdrop-blur-md text-sm text-brand-700 font-semibold mb-6 animate-slide-down">
                        <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                        <span>تشكيلة الصيف الجديدة متوفرة الآن</span>
                        <i class="ph-fill ph-sparkle text-brand-500 animate-spin-slow"></i>
                    </div>
                    <div class="relative mb-8">
                        <h1 class="text-5xl lg:text-7xl font-extrabold text-ink leading-[1.1] relative">
                            <span class="animate-text-glow">تألقي بثقة،</span><br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-l from-brand-600 via-brand-500 to-pink-500 animate-gradient-shift">أنتِ تستحقين الأفضل.</span>
                        </h1>
                        <div class="absolute inset-0 bg-gradient-to-r from-brand-500/20 to-pink-500/20 blur-3xl -z-10 animate-pulse"></div>
                    </div>
                    <div class="mb-10 max-w-lg mx-auto lg:mx-0">
                        <p class="text-lg lg:text-xl text-gray-600 leading-relaxed font-light animate-fade-in-up" style="animation-delay: 0.3s;">
                            اكتشفي أرقى منتجات العناية بالبشرة والشعر من الماركات العالمية الأصلية، مختارة بعناية لتبرز جمالك الطبيعي.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start animate-fade-in-up" style="animation-delay: 0.6s;">
                        <a href="{{ route('shop') }}" class="group relative px-10 py-4 bg-gradient-to-r from-ink to-brand-600 text-white rounded-full font-bold overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-500 flex items-center justify-center gap-3 transform hover:-translate-y-1">
                            <span class="relative z-10">تسوقي المجموعة</span>
                            <i class="ph ph-arrow-left relative z-10 group-hover:-translate-x-2 transition-transform duration-300"></i>
                            <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-pink-500 transform scale-x-0 group-hover:scale-x-100 origin-right transition-transform duration-700 ease-out z-0"></div>
                        </a>
                        <a href="{{ route('shop') }}?sort=newest" class="group relative px-8 py-4 bg-white/90 backdrop-blur-md text-ink rounded-full font-bold border-2 border-brand-200 hover:border-brand-500 hover:text-brand-600 transition-all duration-300 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="ph ph-sparkle text-xl group-hover:animate-spin-slow"></i>
                            <span>وصل حديثاً</span>
                        </a>
                    </div>
                </div>
                <div class="order-1 lg:order-2 relative lg:h-[600px] flex justify-center items-center">
                    <div class="relative w-[320px] h-[420px] md:w-[420px] md:h-[520px]">
                        <div class="relative w-full h-full rounded-[40px] overflow-hidden shadow-2xl z-20 animate-float-3d">
                            @if($featuredProducts->isNotEmpty() && $featuredProducts->first()->main_image_url)
                                <img src="{{ $featuredProducts->first()->main_image_url }}" alt="Beauty" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-brand-100 to-pink-100 flex items-center justify-center">
                                    <i class="ph ph-sparkle text-6xl text-brand-300"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-ink/40 via-transparent to-transparent"></div>
                        </div>
                        <div class="absolute w-full h-full rounded-[40px] border-2 border-brand-500/20 -rotate-6 top-4 z-10 animate-rotate-slow"></div>
                        <div class="absolute w-full h-full rounded-[40px] border border-brand-300/10 rotate-3 top-6 z-10 animate-rotate-slow" style="animation-delay: 2s;"></div>

                        <div class="absolute top-8 -right-6 md:-right-12 bg-white/95 backdrop-blur-lg p-4 rounded-3xl shadow-2xl flex items-center gap-3 w-52 border border-white/50 animate-bounce-slow z-40">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-500 flex items-center justify-center text-white shadow-lg">
                                <i class="ph-fill ph-check-circle text-2xl"></i>
                            </div>
                            <div><p class="text-xs text-gray-500 font-medium">ضمان الجودة</p><p class="text-sm font-bold text-ink">100% أصلي</p></div>
                        </div>
                        <div class="absolute bottom-12 -left-6 md:-left-12 bg-white/95 backdrop-blur-lg p-4 rounded-3xl shadow-2xl border border-white/50 animate-bounce-slow z-40" style="animation-delay: 0.5s;">
                            <div class="flex -space-x-3 space-x-reverse mb-3">
                                <div class="w-10 h-10 rounded-full border-3 border-white bg-gradient-to-br from-brand-400 to-brand-500 flex items-center justify-center text-[10px] text-white font-bold shadow-lg">J</div>
                                <div class="w-10 h-10 rounded-full border-3 border-white bg-gradient-to-br from-brand-300 to-brand-400 flex items-center justify-center text-[10px] text-white font-bold shadow-lg">C</div>
                                <div class="w-10 h-10 rounded-full border-3 border-white bg-gradient-to-br from-pink-400 to-pink-500 flex items-center justify-center text-xs text-white font-bold shadow-lg">+{{ \App\Models\Product::count() }}</div>
                            </div>
                            <p class="text-xs font-bold text-ink">{{ \App\Models\Product::count() }} منتج متاح</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- CSS animations --}}
<style>
@keyframes slide-down {
    0% { transform: translateY(-20px); opacity: 0; }
    100% { transform: translateY(0); opacity: 1; }
}
@keyframes fade-in-up {
    0% { transform: translateY(20px); opacity: 0; }
    100% { transform: translateY(0); opacity: 1; }
}
@keyframes fade-in {
    0% { opacity: 0; }
    100% { opacity: 1; }
}
@keyframes slide-in {
    0% { transform: translateX(-30px); opacity: 0; }
    100% { transform: translateX(0); opacity: 1; }
}
@keyframes zoom-in {
    0% { transform: scale(0.9); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
@keyframes text-glow {
    0%, 100% { text-shadow: 0 0 20px rgba(217, 122, 140, 0.3); }
    50% { text-shadow: 0 0 30px rgba(217, 122, 140, 0.5); }
}
@keyframes gradient-shift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}
@keyframes float-3d {
    0%, 100% { transform: translateY(0) rotateX(0); }
    50% { transform: translateY(-20px) rotateX(2deg); }
}
@keyframes rotate-slow {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
@keyframes bounce-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
@keyframes spin-slow {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.animate-slide-down { animation: slide-down 0.8s ease-out; }
.animate-fade-in-up { animation: fade-in-up 0.8s ease-out; }
.animate-fade-in { animation: fade-in 0.8s ease-out; }
.animate-slide-in { animation: slide-in 0.8s ease-out; }
.animate-zoom-in { animation: zoom-in 0.8s ease-out; }
.animate-text-glow { animation: text-glow 3s ease-in-out infinite; }
.animate-gradient-shift { 
    background-size: 200% 200%; 
    animation: gradient-shift 4s ease-in-out infinite; 
}
.animate-float-3d { animation: float-3d 6s ease-in-out infinite; }
.animate-rotate-slow { animation: rotate-slow 20s linear infinite; }
.animate-bounce-slow { animation: bounce-slow 3s ease-in-out infinite; }
.animate-spin-slow { animation: spin-slow 3s linear infinite; }

.parallax-bg { transform: translateZ(-1px) scale(1.1); will-change: transform; }
.parallax-img { transition: transform 0.3s ease-out; }
.parallax-img:hover { transform: scale(1.05); }
</style>

{{-- JavaScript for slideshow --}}
<script>
let currentSlide = 0;
let slideInterval = null;
const heroSlideshow = document.getElementById('heroSlideshow');
if (heroSlideshow) {
    const slides = heroSlideshow.querySelectorAll('[data-slide]');
    const indicators = heroSlideshow.querySelectorAll('[data-indicator]');
    const totalSlides = slides.length;

    if (totalSlides > 1) {
        slides.forEach((s, i) => {
            if (i !== 0) s.classList.add('hidden');
            s.style.transition = 'opacity 800ms ease, transform 800ms ease';
        });

        function showSlide(index) {
            slides.forEach((slide, i) => {
                if (i === index) {
                    slide.classList.remove('hidden');
                    slide.classList.add('block');
                    requestAnimationFrame(() => {
                        slide.style.opacity = '1';
                        slide.style.transform = 'scale(1)';
                    });
                } else {
                    slide.style.opacity = '0';
                    slide.style.transform = 'scale(0.95)';
                    const onDone = function() {
                        slide.removeEventListener('transitionend', onDone);
                        slide.classList.add('hidden');
                        slide.classList.remove('block');
                    };
                    slide.addEventListener('transitionend', onDone, { once: true });
                    setTimeout(onDone, 900);
                }
            });

            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('w-8', i === index);
                indicator.classList.toggle('bg-white', i === index);
                indicator.classList.toggle('w-2', i !== index);
                indicator.classList.toggle('bg-white/60', i !== index);
            });
        }

        window.previousSlide = function() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(currentSlide);
            resetAutoPlay();
        };

        window.nextSlide = function() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
            resetAutoPlay();
        };

        window.goToSlide = function(index) {
            currentSlide = index;
            showSlide(currentSlide);
            resetAutoPlay();
        };

        function resetAutoPlay() {
            if (slideInterval) clearInterval(slideInterval);
            slideInterval = setInterval(window.nextSlide, 5000);
        }

        function startAutoPlay() {
            if (slideInterval) clearInterval(slideInterval);
            slideInterval = setInterval(window.nextSlide, 5000);
        }

        function stopAutoPlay() {
            if (slideInterval) clearInterval(slideInterval);
            slideInterval = null;
        }

        heroSlideshow.addEventListener('mouseenter', stopAutoPlay);
        heroSlideshow.addEventListener('mouseleave', startAutoPlay);
        heroSlideshow.addEventListener('touchstart', stopAutoPlay, { passive: true });
        heroSlideshow.addEventListener('touchend', () => setTimeout(startAutoPlay, 2000));

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) stopAutoPlay();
            else startAutoPlay();
        });

        window.addEventListener('beforeunload', () => {
            if (slideInterval) clearInterval(slideInterval);
        });

        startAutoPlay();
    }
}

// Parallax effect on scroll
(function() {
    const parallaxEls = document.querySelectorAll('.parallax-bg, .parallax-img');
    if (!parallaxEls.length) return;
    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;
        parallaxEls.forEach(el => {
            const speed = 0.4;
            el.style.transform = `translateY(${scrollY * speed}px)`;
        });
    });
})();
</script>

{{-- ═══════════════════════════════════════════════════════════════
     شريط متحرك (Marquee Ticker)
     ═══════════════════════════════════════════════════════════════ --}}
<div class="bg-brand-500 py-4 overflow-hidden whitespace-nowrap relative flex items-center border-y border-brand-600">
    <div class="flex gap-8 items-center text-white/90 font-bold text-lg tracking-wider uppercase animate-marquee" style="flex-shrink:0;">
        <span>منتجات طبية تجميلية</span> <i class="ph-fill ph-star-four text-white text-sm"></i>
        <span>شحن لكل فلسطين</span> <i class="ph-fill ph-star-four text-white text-sm"></i>
        <span>تجهيز صالونات</span> <i class="ph-fill ph-star-four text-white text-sm"></i>
        <span>ماركات عالمية</span> <i class="ph-fill ph-star-four text-white text-sm"></i>
        <span>عناية بالبشرة والشعر</span> <i class="ph-fill ph-star-four text-white text-sm"></i>
    </div>
    <div class="flex gap-8 items-center text-white/90 font-bold text-lg tracking-wider uppercase animate-marquee" style="flex-shrink:0;" aria-hidden="true">
        <span>منتجات طبية تجميلية</span> <i class="ph-fill ph-star-four text-white text-sm"></i>
        <span>شحن لكل فلسطين</span> <i class="ph-fill ph-star-four text-white text-sm"></i>
        <span>تجهيز صالونات</span> <i class="ph-fill ph-star-four text-white text-sm"></i>
        <span>ماركات عالمية</span> <i class="ph-fill ph-star-four text-white text-sm"></i>
        <span>عناية بالبشرة والشعر</span> <i class="ph-fill ph-star-four text-white text-sm"></i>
    </div>
</div>

{{-- Trust Stats Counter --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @php $totalProducts = \App\Models\Product::count(); $totalOrders = \App\Models\Order::count(); @endphp
            <div class="space-y-1">
                <div class="text-3xl md:text-4xl font-extrabold text-brand-500 counter" data-target="{{ $totalProducts }}">0</div>
                <div class="text-sm text-gray-500">منتج</div>
            </div>
            <div class="space-y-1">
                <div class="text-3xl md:text-4xl font-extrabold text-brand-500 counter" data-target="{{ $categories->count() }}">0</div>
                <div class="text-sm text-gray-500">قسم</div>
            </div>
            <div class="space-y-1">
                <div class="text-3xl md:text-4xl font-extrabold text-brand-500 counter" data-target="{{ $totalOrders }}">0</div>
                <div class="text-sm text-gray-500">طلب</div>
            </div>
            <div class="space-y-1">
                <div class="text-3xl md:text-4xl font-extrabold text-brand-500">100%</div>
                <div class="text-sm text-gray-500">منتجات أصلية</div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const counters = document.querySelectorAll('.counter');
    if (!counters.length) return;
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = parseInt(el.dataset.target);
            const duration = 1500;
            const start = performance.now();
            function update(now) {
                const elapsed = now - start;
                const progress = Math.min(elapsed / duration, 1);
                el.textContent = Math.floor(progress * target).toLocaleString('ar');
                if (progress < 1) requestAnimationFrame(update);
            }
            requestAnimationFrame(update);
            observer.unobserve(el);
        });
    }, { threshold: 0.3 });
    counters.forEach(c => observer.observe(c));
})();
</script>

{{-- ═══════════════════════════════════════════════════════════════
     الأقسام باستخدام شبكة بينتو (Bento Grid)
     ═══════════════════════════════════════════════════════════════ --}}
@if($categories->isNotEmpty())
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-sm font-bold tracking-widest text-brand-500 uppercase mb-2">تصفحي الأقسام</h2>
            <h3 class="text-3xl md:text-4xl font-extrabold text-ink">كل ما يبرز جمالك<br>في مكان واحد.</h3>
        </div>
        <a href="{{ route('shop') }}" class="hidden md:flex items-center gap-2 font-medium text-ink hover:text-brand-500 transition-colors group">
            عرض الكل <i class="ph ph-arrow-left group-hover:-translate-x-2 transition-transform"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 auto-rows-[250px]">
        @foreach($categories->take(5) as $index => $category)
            @if($index === 0)
            {{-- القسم الرئيسي (حجم كبير) --}}
            <a href="{{ route('shop', ['category' => $category->slug]) }}" class="group relative md:col-span-2 md:row-span-2 rounded-[32px] overflow-hidden bg-gray-100 isolate">
                @if($category->sample_image)
                <img src="{{ $category->sample_image }}" alt="{{ $category->display_name }}" loading="lazy" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                @else
                <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-brand-100 to-brand-200"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-ink/20 to-transparent"></div>
                
                <div class="absolute bottom-0 left-0 w-full p-8 flex justify-between items-end">
                    <div>
                        <div class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full w-max mb-3 border border-white/30">{{ $category->products_count }} منتج</div>
                        <h4 class="text-3xl font-bold text-white mb-2">{{ $category->display_name }}</h4>
                        @if($category->min_price)
                        <p class="text-white/80">{{ number_format($category->min_price) }} - {{ number_format($category->max_price) }} ₪</p>
                        @endif
                    </div>
                    <div class="w-12 h-12 rounded-full bg-white text-ink flex items-center justify-center transform group-hover:-rotate-45 transition-transform duration-300 shadow-lg">
                        <i class="ph ph-arrow-up-right text-xl"></i>
                    </div>
                </div>
            </a>
            @elseif($index <= 2)
            {{-- أقسام عادية --}}
            <a href="{{ route('shop', ['category' => $category->slug]) }}" class="group relative rounded-[32px] overflow-hidden bg-gray-100 isolate">
                @if($category->sample_image)
                <img src="{{ $category->sample_image }}" alt="{{ $category->display_name }}" loading="lazy" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                @else
                <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-brand-100 to-brand-200"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-ink/70 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6">
                    <h4 class="text-xl font-bold text-white mb-1">{{ $category->display_name }}</h4>
                    <span class="text-sm text-white/70 flex items-center gap-1 group-hover:text-brand-100 transition-colors">{{ $category->products_count }} منتج <i class="ph ph-arrow-left text-xs"></i></span>
                </div>
            </a>
            @elseif($index === 3 || $index === 4)
            {{-- قسم أفقي --}}
                @if($index === 3)
            <a href="{{ route('shop', ['category' => $category->slug]) }}" class="group relative md:col-span-2 rounded-[32px] overflow-hidden bg-gray-100 isolate">
                @if($category->sample_image)
                <img src="{{ $category->sample_image }}" alt="{{ $category->display_name }}" loading="lazy" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                @else
                <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-gray-200 to-gray-300"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6 flex justify-between items-end">
                    <div>
                        <h4 class="text-2xl font-bold text-white mb-1">{{ $category->display_name }}</h4>
                        <p class="text-white/80 text-sm">{{ $category->products_count }} منتج متاح</p>
                    </div>
                </div>
            </a>
                @endif
            @endif
        @endforeach
    </div>
    
    <div class="mt-8 text-center md:hidden">
         <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 font-medium text-ink hover:text-brand-500 transition-colors">
            عرض كل الأقسام <i class="ph ph-arrow-left"></i>
        </a>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     المنتجات المميزة (تصميم بطاقات عصرية - تمرير أفقي)
     ═══════════════════════════════════════════════════════════════ --}}
@if($featuredProducts->isNotEmpty())
<section class="py-16 bg-white border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl md:text-3xl font-bold text-ink mb-10 text-center">المنتجات <span class="text-brand-500">المميزة</span></h3>
        
        {{-- عرض أفقي قابل للتمرير --}}
        <div class="flex overflow-x-auto gap-6 pb-8 hide-scroll snap-x">
            @foreach($featuredProducts as $product)
            <div class="min-w-[260px] max-w-[260px] snap-start group cursor-pointer">
                <div class="relative bg-surface rounded-2xl aspect-[4/5] mb-4 overflow-hidden flex items-center justify-center p-4">
@if($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                            <div class="absolute top-3 left-3 bg-amber-500 text-white text-[10px] font-bold px-2 py-1 rounded animate-pulse">
                                <i class="ph ph-fire"></i> {{ $product->stock_quantity }} متبقي
                            </div>
                            @endif
                            @if($product->is_on_sale)
                            <div class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">-{{ $product->discount_percentage_display }}%</div>
                            @elseif($product->is_new)
                            <div class="absolute top-3 right-3 bg-brand-500 text-white text-xs font-bold px-2 py-1 rounded">جديد</div>
                            @endif

                            @if($product->main_image_url)
                            <a href="{{ route('product.show', $product->slug) }}">
                                <img src="{{ $product->main_image_url }}" alt="{{ $product->name_ar }}" loading="lazy" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500" onerror="this.parentElement.innerHTML='<i class=&quot;ph ph-package text-5xl text-gray-300&quot;></i>'">
                    </a>
                    @else
                    <a href="{{ route('product.show', $product->slug) }}" class="flex items-center justify-center w-full h-full">
                        <i class="ph ph-package text-5xl text-gray-300"></i>
                    </a>
                    @endif

                </div>
                <div>
                    @if($product->category)
                    <p class="text-xs text-gray-500 mb-1">{{ $product->category->name_ar ?? $product->category->name }}</p>
                    @endif
                    <a href="{{ route('product.show', $product->slug) }}">
                        <h4 class="text-ink font-bold leading-tight mb-2 group-hover:text-brand-500 transition-colors line-clamp-2 text-sm">{{ $product->name_ar }}</h4>
                    </a>
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex gap-2 items-center">
                            <span class="text-lg font-extrabold text-ink">{{ number_format($product->final_b2c_price ?? $product->b2c_price, 0) }} ₪</span>
                            @if($product->is_on_sale)
                            <span class="text-sm text-gray-400 line-through">{{ number_format($product->b2c_price, 0) }} ₪</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="addToCart({{ $product->id }}, 1, this)" class="flex-1 bg-ink text-white py-2 rounded-xl font-medium text-xs shadow-lg hover:bg-gray-800 flex justify-center items-center gap-1.5">
                            <i class="ph ph-shopping-cart-simple text-base"></i> أضف للسلة
                        </button>
                        <a href="https://wa.me/{{ $siteSettings['whatsapp_number'] ?? '970591234567' }}?text={{ urlencode('السلام عليكم، مهتمة بـ: ' . $product->name_ar . ' - ' . number_format($product->final_b2c_price ?? $product->b2c_price, 0) . ' ₪') }}" target="_blank" class="px-3 py-2 border-2 border-green-500 text-green-500 rounded-xl font-medium text-xs hover:bg-green-500 hover:text-white transition-all flex items-center justify-center" title="واتساب">
                            <i class="ph ph-whatsapp-logo text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     وصل حديثاً (تمرير أفقي)
     ═══════════════════════════════════════════════════════════════ --}}
@if($newProducts->isNotEmpty())
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl md:text-3xl font-bold text-ink mb-10 text-center">وصل حديثاً <span class="text-brand-500">وحصرياً</span></h3>
        
        <div class="flex overflow-x-auto gap-6 pb-8 hide-scroll snap-x">
            @foreach($newProducts as $product)
            <div class="min-w-[260px] max-w-[260px] snap-start group cursor-pointer">
                <div class="relative bg-surface rounded-2xl aspect-[4/5] mb-4 overflow-hidden flex items-center justify-center p-4">
                    <div class="absolute top-3 right-3 bg-brand-500 text-white text-xs font-bold px-2 py-1 rounded">جديد</div>
                    @if($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                    <div class="absolute top-3 left-3 bg-amber-500 text-white text-[10px] font-bold px-2 py-1 rounded animate-pulse">
                        <i class="ph ph-fire"></i> {{ $product->stock_quantity }} متبقي
                    </div>
                    @endif

                    @if($product->main_image_url)
                    <a href="{{ route('product.show', $product->slug) }}">
                        <img src="{{ $product->main_image_url }}" alt="{{ $product->name_ar }}" loading="lazy" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500" onerror="this.parentElement.innerHTML='<i class=&quot;ph ph-package text-5xl text-gray-300&quot;></i>'">
                    </a>
                    @else
                    <a href="{{ route('product.show', $product->slug) }}" class="flex items-center justify-center w-full h-full">
                        <i class="ph ph-package text-5xl text-gray-300"></i>
                    </a>
                    @endif
                </div>
                <div>
                    @if($product->category)
                    <p class="text-xs text-gray-500 mb-1">{{ $product->category->name_ar ?? $product->category->name }}</p>
                    @endif
                    <a href="{{ route('product.show', $product->slug) }}">
                        <h4 class="text-ink font-bold leading-tight mb-2 group-hover:text-brand-500 transition-colors line-clamp-2 text-sm">{{ $product->name_ar }}</h4>
                    </a>
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex gap-2 items-center">
                            <span class="text-lg font-extrabold text-ink">{{ number_format($product->final_b2c_price ?? $product->b2c_price, 0) }} ₪</span>
                            @if($product->is_on_sale)
                            <span class="text-sm text-gray-400 line-through">{{ number_format($product->b2c_price, 0) }} ₪</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="addToCart({{ $product->id }}, 1, this)" class="flex-1 bg-ink text-white py-2 rounded-xl font-medium text-xs shadow-lg hover:bg-gray-800 flex justify-center items-center gap-1.5">
                            <i class="ph ph-shopping-cart-simple text-base"></i> أضف للسلة
                        </button>
                        <a href="https://wa.me/{{ $siteSettings['whatsapp_number'] ?? '970591234567' }}?text={{ urlencode('السلام عليكم، مهتمة بـ: ' . $product->name_ar . ' - ' . number_format($product->final_b2c_price ?? $product->b2c_price, 0) . ' ₪') }}" target="_blank" class="px-3 py-2 border-2 border-green-500 text-green-500 rounded-xl font-medium text-xs hover:bg-green-500 hover:text-white transition-all flex items-center justify-center" title="واتساب">
                            <i class="ph ph-whatsapp-logo text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     شاهدتِ مؤخراً + منتجات اقتصادية
     ═══════════════════════════════════════════════════════════════ --}}
@php
    $cheapestProducts = \App\Models\Product::active()->showInB2C()
        ->where('stock_quantity', '>', 0)
        ->where('b2c_price', '>', 0)
        ->orderBy('b2c_price')
        ->limit(8)
        ->get();
@endphp
<div id="recentlyViewed" class="hidden py-16 bg-surface border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl font-bold text-ink mb-10 text-center">شاهدتِ <span class="text-brand-500">مؤخراً</span></h3>
        <div class="flex overflow-x-auto gap-6 pb-4 hide-scroll snap-x" id="recentlyViewedGrid"></div>
    </div>
</div>

@if($cheapestProducts->isNotEmpty())
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl md:text-3xl font-bold text-ink mb-2 text-center">منتجات <span class="text-brand-500">اقتصادية</span></h3>
        <p class="text-gray-400 text-sm text-center mb-10">أفضل العروض بأسعار مناسبة</p>
        <div class="flex overflow-x-auto gap-6 pb-8 hide-scroll snap-x">
            @foreach($cheapestProducts as $product)
            <div class="min-w-[200px] max-w-[200px] snap-start">
                <a href="{{ route('product.show', $product->slug) }}" class="block no-underline">
                    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        @if($product->main_image_url)
                        <img src="{{ $product->main_image_url }}" alt="{{ $product->name_ar }}" loading="lazy" class="w-full aspect-square object-cover">
                        @else
                        <div class="w-full aspect-square bg-gray-50 flex items-center justify-center"><i class="ph ph-package text-3xl text-gray-200"></i></div>
                        @endif
                        <div class="p-3">
                            <div class="text-xs font-semibold text-ink truncate">{{ $product->name_ar }}</div>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="text-sm font-extrabold text-brand-500">{{ number_format($product->final_b2c_price ?? $product->b2c_price, 0) }} ₪</span>
                                @if($product->is_on_sale)
                                <span class="text-[10px] text-gray-400 line-through">{{ number_format($product->b2c_price, 0) }} ₪</span>
                                @endif
                            </div>
                            @if($product->stock_quantity <= 10 && $product->stock_quantity > 0)
                            <span class="text-[10px] text-amber-600 font-bold">تبقى {{ $product->stock_quantity }} فقط</span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- قسم إكمال المجموعة (Cross-sells) --}}
@php
    $crossSellProducts = \App\Models\Product::active()->showInB2C()
        ->where('stock_quantity', '>', 0)
        ->where('b2c_price', '>', 0)
        ->where('is_featured', true)
        ->inRandomOrder()
        ->limit(6)
        ->get();
@endphp
@if($crossSellProducts->isNotEmpty())
<section class="py-16 bg-gradient-to-b from-brand-50/30 to-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="inline-block bg-brand-100 text-brand-600 text-xs font-bold px-4 py-1 rounded-full mb-3">✨ اكتشفي المزيد</span>
            <h3 class="text-2xl md:text-3xl font-bold text-ink">قد يعجبك أيضاً</h3>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($crossSellProducts as $product)
            <a href="{{ route('product.show', $product->slug) }}" class="group">
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="relative aspect-square overflow-hidden">
                        @if($product->main_image_url)
                        <img src="{{ $product->main_image_url }}" alt="{{ $product->name_ar }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gray-50 flex items-center justify-center"><i class="ph ph-package text-3xl text-gray-200"></i></div>
                        @endif
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
                    </div>
                    <div class="p-3">
                        <div class="text-xs font-semibold text-ink line-clamp-2 leading-tight mb-2">{{ $product->name_ar }}</div>
                        <div class="text-sm font-extrabold text-brand-500">{{ number_format($product->final_b2c_price ?? $product->b2c_price, 0) }} ₪</div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<script>
(function() {
    const viewed = JSON.parse(localStorage.getItem('recentlyViewed') || '[]');
    if (viewed.length < 1) return;
    const section = document.getElementById('recentlyViewed');
    const grid = document.getElementById('recentlyViewedGrid');
    const bp = window.basePath || '';
    section.classList.remove('hidden');
    grid.innerHTML = viewed.slice(0, 6).map(p => `
        <div class="min-w-[180px] max-w-[180px] snap-start">
            <a href="${bp}/product/${p.slug}" class="block no-underline">
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    ${p.img ? `<img src="${p.img}" class="w-full aspect-square object-cover" loading="lazy" onerror="this.parentElement.innerHTML='<div class=&quot;w-full aspect-square bg-gray-50 flex items-center justify-center&quot;><i class=&quot;ph ph-package text-3xl text-gray-200&quot;></i></div>'">` : '<div class="w-full aspect-square bg-gray-50 flex items-center justify-center"><i class="ph ph-package text-3xl text-gray-200"></i></div>'}
                    <div class="p-3">
                        <div class="text-xs font-semibold text-ink truncate">${p.name}</div>
                        <div class="text-sm font-extrabold text-brand-500 mt-1">${p.price}</div>
                    </div>
                </div>
            </a>
        </div>
    `).join('');
})();
</script>

@endsection
