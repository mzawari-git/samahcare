@if(isset($featuredServices) && $featuredServices->isNotEmpty())
<section class="py-24" style="background: var(--surface);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="text-xs uppercase tracking-widest mb-4 font-light" style="color: var(--ink-dim); font-family: var(--font-en);">Our Services</p>
            <h2 class="text-3xl md:text-4xl font-light" style="color: var(--ink);">خدماتنا المتميزة</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredServices as $index => $service)
            <div class="t3-reveal-up group" style="border: 1px solid var(--neutral-200); border-radius: 0; overflow: hidden; transition: all 0.4s ease; background: #fff;" onmouseover="this.style.borderColor='var(--accent-300)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.05)'" onmouseout="this.style.borderColor='var(--neutral-200)'; this.style.boxShadow='none'">
                <div style="height: 240px; background: linear-gradient(135deg, var(--accent-100), var(--accent-200)); display: flex; align-items: center; justify-content: center; position: relative;">
                    <i class="fas fa-spa text-5xl" style="color: var(--brand-400); opacity: 0.5;"></i>
                    <span class="t3-service-number" style="position: absolute; bottom: 16px; right: 20px; font-size: 3rem; opacity: 0.15; color: var(--ink);">0{{ $index + 1 }}</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-light mb-3" style="color: var(--ink);">{{ $service->name }}</h3>
                    <p class="text-sm font-light leading-relaxed mb-4" style="color: var(--ink-muted);">{{ Str::limit($service->description ?? 'خدمة احترافية بأعلى المعايير', 100) }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-lg" style="color: var(--brand-500); font-weight: 300;">{{ number_format($service->price, 0) }} ₪</span>
                        <a href="{{ route('booking') }}?service={{ $service->id }}" class="t3-btn-elegant text-sm" style="padding: 8px 20px;">
                            <span>احجزي</span>
                            <i class="fas fa-arrow-left text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('booking') }}" class="t3-btn-elegant text-sm" style="padding: 12px 32px;">
                <span>عرض كل الخدمات</span>
                <i class="fas fa-arrow-left text-xs"></i>
            </a>
        </div>
    </div>
</section>
@endif
