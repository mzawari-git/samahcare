@if(isset($featuredServices) && $featuredServices->isNotEmpty())
<section id="services" class="py-24 relative t4-bg-lines" style="background: var(--surface);">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold mb-4" style="background: var(--brand-50); color: var(--brand-600); border: 1px solid var(--brand-200);">
                <i class="fas fa-seedling"></i> خدماتنا المتميزة
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-4" style="color: var(--ink);">علاجات <span class="t4-text-gradient">طبيعية</span> متكاملة</h2>
            <p class="text-base" style="color: var(--ink-muted);">مجموعة مختارة من أفضل خدماتنا العلاجية المستوحاة من قوة الطبيعة</p>
        </div>

        <div class="space-y-8">
            @foreach($featuredServices as $index => $service)
            <div class="t4-card-nature flex flex-col {{ $index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' }} group" style="border-radius: 40px;">
                <div class="w-full md:w-2/5 h-64 md:h-auto relative overflow-hidden" style="border-radius: {{ $index % 2 === 0 ? '40px 0 0 40px' : '0 40px 40px 0' }};">
                    <div class="absolute inset-0 flex items-center justify-center" style="background: linear-gradient(135deg, var(--brand-50), var(--brand-200));">
                        <div class="text-center">
                            <i class="fas fa-spa text-6xl mb-3" style="color: var(--brand-500);"></i>
                            <p class="text-5xl font-bold opacity-10" style="font-family: var(--font-en);">0{{ $index + 1 }}</p>
                        </div>
                    </div>
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background: linear-gradient(135deg, rgba(44,62,45,0.1), transparent);"></div>
                </div>

                <div class="w-full md:w-3/5 p-8 md:p-12 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-4xl font-bold opacity-20" style="color: var(--brand-500); font-family: var(--font-en);">0{{ $index + 1 }}</span>
                        <div class="h-px flex-1" style="background: var(--neutral-200);"></div>
                    </div>

                    <h3 class="text-2xl md:text-3xl font-bold mb-3" style="color: var(--ink);">{{ $service->name }}</h3>
                    <p class="mb-6 leading-relaxed" style="color: var(--ink-muted);">{{ Str::limit($service->description ?? 'خدمة علاجية طبيعية بأعلى المعايير المهنية', 120) }}</p>

                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-4 py-1.5 rounded-full text-xs font-semibold" style="background: var(--brand-50); color: var(--brand-600);">طبيعي</span>
                        <span class="px-4 py-1.5 rounded-full text-xs font-semibold" style="background: var(--accent-50); color: var(--accent-600);">آمن</span>
                        <span class="px-4 py-1.5 rounded-full text-xs font-semibold" style="background: var(--neutral-100); color: var(--ink-muted);">معتمد</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold" style="color: var(--brand-500);">{{ number_format($service->price, 0) }} ₪</span>
                        <a href="{{ route('booking') }}?service={{ $service->id }}" class="t4-btn-nature !py-2.5 !px-6 text-sm">
                            احجز الآن <i class="fas fa-arrow-left text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('booking') }}" class="t4-btn-outline">
                عرض جميع الخدمات <i class="fas fa-arrow-left mr-2"></i>
            </a>
        </div>
    </div>
</section>
@endif
