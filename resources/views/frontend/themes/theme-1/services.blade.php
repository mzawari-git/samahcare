@if(isset($featuredServices) && $featuredServices->isNotEmpty())
<section id="services" class="py-24 relative" style="background: var(--surface-alt, #FFF0F5);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div class="max-w-2xl">
                <h4 class="font-bold tracking-wider uppercase mb-2 text-sm" style="color: var(--brand-500);">باقات الجمال</h4>
                <h2 class="text-4xl md:text-5xl font-bold" style="color: var(--ink);">خدماتنا <span class="t1-text-gradient">المتميزة</span></h2>
            </div>
            <a href="{{ route('booking') }}" class="hidden md:inline-flex items-center gap-2 font-bold transition-colors" style="color: var(--brand-500);">
                عرض كل الخدمات <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($featuredServices as $index => $service)
            <div class="t1-glass-card overflow-hidden group flex flex-col h-full" style="border-radius: 30px;">
                <div class="h-64 t1-service-img-mask relative" style="background: linear-gradient(135deg, var(--brand-50), var(--brand-100));">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-spa text-6xl" style="color: var(--brand-500);"></i>
                    </div>
                    <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);"></div>
                    <div class="absolute bottom-4 right-6 text-white text-3xl italic" style="font-family: var(--font-en);">0{{ $index + 1 }}</div>
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold mb-3" style="color: var(--ink);">{{ $service->name }}</h3>
                    <p class="mb-6 flex-grow" style="color: var(--ink-muted);">{{ Str::limit($service->description ?? 'خدمة تجميلية احترافية بأعلى المعايير', 100) }}</p>
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-xl font-bold" style="color: var(--brand-500);">{{ number_format($service->price, 0) }} ₪</span>
                    </div>
                    <a href="{{ route('booking') }}?service={{ $service->id }}" class="w-full t1-btn-outline py-3 text-center font-bold" style="border-radius: 12px;">احجزي جلستك</a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-10 text-center md:hidden">
            <a href="{{ route('booking') }}" class="inline-flex items-center gap-2 font-bold" style="color: var(--brand-500);">
                عرض كل الخدمات <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
</section>
@endif
