@if(isset($featuredServices) && $featuredServices->isNotEmpty())
<section id="services" class="py-24 relative" style="background: var(--surface);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center gap-4 mb-4 t2-reveal">
            <span class="t2-decor-line"></span>
            <span class="text-sm font-semibold tracking-widest uppercase" style="color: var(--accent-400); font-family: var(--font-en);">Our Services</span>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16">
            <h2 class="text-4xl md:text-5xl font-bold t2-reveal t2-reveal-delay-1" style="color: var(--ink);">
                خدماتنا <span style="font-family: var(--font-en); font-style: italic; color: var(--accent-400);">المتميزة</span>
            </h2>
            <a href="{{ route('booking') }}" class="hidden md:inline-flex t2-underline-link mt-4 md:mt-0">
                عرض الكل <i class="fas fa-arrow-left text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($featuredServices as $index => $service)
            <div class="t2-reveal t2-reveal-delay-{{ ($index % 3) + 1 }}">
                <div class="t2-arch t2-img-zoom relative mb-6" style="height: 320px; background: linear-gradient(180deg, var(--brand-100) 0%, var(--brand-200) 100%);">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-spa text-5xl" style="color: var(--brand-500); opacity: 0.4;"></i>
                    </div>
                    <div class="absolute top-5 right-5 w-10 h-10 flex items-center justify-center" style="background: var(--accent-400);">
                        <span class="text-sm font-bold" style="color: var(--brand-500); font-family: var(--font-en);">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>

                <div class="text-right">
                    <h3 class="text-xl font-bold mb-2" style="color: var(--ink);">{{ $service->name }}</h3>
                    <p class="text-sm leading-relaxed mb-4" style="color: var(--ink-muted);">{{ Str::limit($service->description ?? 'خدمة تجميلية احترافية بأعلى المعايير', 100) }}</p>
                    <a href="{{ route('booking') }}?service={{ $service->id }}" class="t2-underline-link text-sm">
                        احجزي الآن <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 text-center md:hidden">
            <a href="{{ route('booking') }}" class="t2-underline-link">
                عرض كل الخدمات <i class="fas fa-arrow-left text-xs"></i>
            </a>
        </div>
    </div>
</section>
@endif
