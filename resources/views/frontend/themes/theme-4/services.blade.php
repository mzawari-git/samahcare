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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredServices as $index => $service)
            <div class="t4-card-nature group overflow-hidden" style="border-radius: 30px;">
                <div class="h-52 relative overflow-hidden" style="background: linear-gradient(135deg, var(--brand-50), var(--brand-200));">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-spa text-5xl" style="color: var(--brand-500); opacity: 0.3;"></i>
                    </div>
                    <div class="absolute bottom-4 right-6">
                        <span class="text-5xl font-bold opacity-15" style="color: var(--brand-500); font-family: var(--font-en);">0{{ $index + 1 }}</span>
                    </div>
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background: linear-gradient(135deg, rgba(44,62,45,0.15), transparent);"></div>
                </div>

                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2" style="color: var(--ink);">{{ $service->name }}</h3>
                    <p class="text-sm leading-relaxed mb-4" style="color: var(--ink-muted);">{{ Str::limit($service->description ?? 'خدمة علاجية طبيعية بأعلى المعايير المهنية', 80) }}</p>

                    <div class="flex flex-wrap gap-2 mb-5">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold" style="background: var(--brand-50); color: var(--brand-600);">طبيعي</span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold" style="background: var(--accent-50); color: var(--accent-600);">آمن</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xl font-bold" style="color: var(--brand-500);">{{ number_format($service->price, 0) }} ₪</span>
                        <a href="{{ route('booking') }}?service={{ $service->id }}" class="t4-btn-nature !py-2 !px-5 text-sm">
                            احجز <i class="fas fa-arrow-left text-xs"></i>
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
