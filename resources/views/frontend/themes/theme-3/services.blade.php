@if(isset($featuredServices) && $featuredServices->isNotEmpty())
<section class="py-24" style="background: var(--surface);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-24">
            <p class="text-xs uppercase tracking-widest mb-4 font-light" style="color: var(--ink-dim); font-family: var(--font-en);">Our Services</p>
            <h2 class="text-3xl md:text-4xl font-light" style="color: var(--ink);">خدماتنا المتميزة</h2>
        </div>

        <div class="space-y-24">
            @foreach($featuredServices as $index => $service)
            <div class="grid grid-cols-12 gap-8 items-center t3-reveal-up">
                @if($index % 2 === 0)
                <div class="col-span-12 md:col-span-7">
                    <div class="t3-img-reveal" style="border-radius: 0 80px 0 80px; height: 400px;">
                        <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--accent-100), var(--accent-200));">
                            <i class="fas fa-spa text-6xl" style="color: var(--brand-400);"></i>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-5 md:pr-12">
                    <span class="t3-service-number">0{{ $index + 1 }}</span>
                    <h3 class="text-2xl font-light mt-2 mb-4" style="color: var(--ink);">{{ $service->name }}</h3>
                    <p class="text-sm font-light leading-relaxed mb-6" style="color: var(--ink-muted);">{{ Str::limit($service->description ?? 'خدمة تجميلية احترافية بأعلى المعايير', 120) }}</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm font-light" style="color: var(--ink-muted);">
                            <span class="t3-check-icon"><i class="fas fa-check"></i></span>
                            تقنية معتمدة دولياً
                        </li>
                        <li class="flex items-center gap-3 text-sm font-light" style="color: var(--ink-muted);">
                            <span class="t3-check-icon"><i class="fas fa-check"></i></span>
                            نتائج مضمونة وطبيعية
                        </li>
                        <li class="flex items-center gap-3 text-sm font-light" style="color: var(--ink-muted);">
                            <span class="t3-check-icon"><i class="fas fa-check"></i></span>
                            أخصائيون معتمدون
                        </li>
                    </ul>
                    <a href="{{ route('booking') }}?service={{ $service->id }}" class="t3-btn-elegant text-sm">
                        <span>احجزي الآن</span>
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
                @else
                <div class="col-span-12 md:col-span-5 md:pl-12 order-2 md:order-1">
                    <span class="t3-service-number">0{{ $index + 1 }}</span>
                    <h3 class="text-2xl font-light mt-2 mb-4" style="color: var(--ink);">{{ $service->name }}</h3>
                    <p class="text-sm font-light leading-relaxed mb-6" style="color: var(--ink-muted);">{{ Str::limit($service->description ?? 'خدمة تجميلية احترافية بأعلى المعايير', 120) }}</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm font-light" style="color: var(--ink-muted);">
                            <span class="t3-check-icon"><i class="fas fa-check"></i></span>
                            تقنية معتمدة دولياً
                        </li>
                        <li class="flex items-center gap-3 text-sm font-light" style="color: var(--ink-muted);">
                            <span class="t3-check-icon"><i class="fas fa-check"></i></span>
                            نتائج مضمونة وطبيعية
                        </li>
                        <li class="flex items-center gap-3 text-sm font-light" style="color: var(--ink-muted);">
                            <span class="t3-check-icon"><i class="fas fa-check"></i></span>
                            أخصائيون معتمدون
                        </li>
                    </ul>
                    <a href="{{ route('booking') }}?service={{ $service->id }}" class="t3-btn-elegant text-sm">
                        <span>احجزي الآن</span>
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
                <div class="col-span-12 md:col-span-7 order-1 md:order-2">
                    <div class="t3-img-reveal" style="border-radius: 80px 0 80px 0; height: 400px;">
                        <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--accent-100), var(--accent-200));">
                            <i class="fas fa-spa text-6xl" style="color: var(--brand-400);"></i>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
