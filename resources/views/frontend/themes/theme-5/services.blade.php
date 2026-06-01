@if(isset($featuredServices) && $featuredServices->isNotEmpty())
<section id="services" class="py-24 relative overflow-hidden" style="background: var(--neutral-900);">
    <div class="t5-bg-grid-dark absolute inset-0 opacity-20"></div>
    <div class="absolute inset-0" style="background: radial-gradient(ellipse at 50% 0%, rgba(0, 85, 255, 0.1) 0%, transparent 50%);"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div class="max-w-2xl">
                <span class="t5-tech-label mb-2 block">SYS.ACTIVE // Protocols</span>
                <h2 class="text-4xl md:text-5xl font-bold text-white">
                    بروتوكولات <span class="t5-gradient-text">العلاج</span>
                </h2>
            </div>
            <a href="{{ route('booking') }}" class="hidden md:inline-flex items-center gap-2 font-bold transition-colors" style="color: var(--accent-400);">
                عرض كل البروتوكولات <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        <div class="flex flex-col gap-4">
            @foreach($featuredServices as $index => $service)
            <div class="group relative overflow-hidden transition-all duration-500" style="background: #112240; border: 1px solid rgba(0, 229, 255, 0.08); clip-path: polygon(0 0, 100% 0, 100% calc(100% - 12px), calc(100% - 12px) 100%, 0 100%);" onmouseover="this.style.borderColor='rgba(0,229,255,0.3)';this.style.boxShadow='0 0 30px rgba(0,229,255,0.1)'" onmouseout="this.style.borderColor='rgba(0,229,255,0.08)';this.style.boxShadow='none'">
                <div class="flex flex-col md:flex-row items-stretch">
                    <div class="w-full md:w-20 flex items-center justify-center py-6 md:py-0" style="border-left: 1px solid rgba(0, 229, 255, 0.08);">
                        <span class="text-4xl md:text-5xl font-bold" style="color: rgba(0, 229, 255, 0.15); font-family: var(--font-en); transition: color 0.4s ease;" onmouseover="this.style.color='rgba(0,229,255,0.5)'" onmouseout="this.style.color='rgba(0,229,255,0.15)'">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <div class="w-full md:w-48 h-40 md:h-auto relative overflow-hidden">
                        <div class="absolute inset-0 t5-grayscale-img flex items-center justify-center" style="background: linear-gradient(135deg, #1a2a4a, #112240);">
                            <i class="fas fa-spa text-4xl" style="color: rgba(0, 229, 255, 0.2);"></i>
                        </div>
                        <div class="t5-scanner-line" style="animation-duration: 4s; opacity: 0; transition: opacity 0.4s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'"></div>
                    </div>

                    <div class="flex-1 p-6 md:p-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-2">{{ $service->name }}</h3>
                                <p class="text-sm leading-relaxed" style="color: var(--neutral-400);">{{ Str::limit($service->description ?? 'بروتوكول علاجي متقدم بأعلى المعايير الطبية', 120) }}</p>
                            </div>
                            <div class="flex flex-col items-start md:items-end gap-3 shrink-0">
                                <span class="text-xl font-bold" style="color: var(--accent-400); font-family: var(--font-en);">{{ number_format($service->price, 0) }} ₪</span>
                                <div class="flex gap-2">
                                    <span class="t5-tech-tag" style="font-size: 0.6rem;">LASER</span>
                                    <span class="t5-tech-tag" style="font-size: 0.6rem;">SYS.ACTIVE</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-48 flex items-center justify-center p-6" style="border-right: 1px solid rgba(0, 229, 255, 0.08);">
                        <a href="{{ route('booking') }}?service={{ $service->id }}" class="t5-btn-tech text-sm w-full" style="padding: 12px 20px;">
                            <i class="fas fa-calendar-check"></i> احجزي
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-10 text-center md:hidden">
            <a href="{{ route('booking') }}" class="inline-flex items-center gap-2 font-bold" style="color: var(--accent-400);">
                عرض كل البروتوكولات <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
</section>
@endif
