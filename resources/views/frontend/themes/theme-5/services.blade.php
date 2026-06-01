@if(isset($featuredServices) && $featuredServices->isNotEmpty())
<section id="services" class="py-24 relative overflow-hidden" style="background: var(--neutral-900);">
    <div class="t5-bg-grid-dark absolute inset-0 opacity-20"></div>
    <div class="absolute inset-0" style="background: radial-gradient(ellipse at 50% 0%, rgba(0, 85, 255, 0.1) 0%, transparent 50%);"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <span class="t5-tech-label mb-2 block">SYS.ACTIVE // Protocols</span>
            <h2 class="text-4xl md:text-5xl font-bold text-white">
                بروتوكولات <span class="t5-gradient-text">العلاج</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($featuredServices as $index => $service)
            <div class="group relative overflow-hidden transition-all duration-500" style="background: #112240; border: 1px solid rgba(0, 229, 255, 0.08); clip-path: polygon(0 0, 100% 0, 100% calc(100% - 8px), calc(100% - 8px) 100%, 0 100%);" onmouseover="this.style.borderColor='rgba(0,229,255,0.3)';this.style.boxShadow='0 0 30px rgba(0,229,255,0.1)'" onmouseout="this.style.borderColor='rgba(0,229,255,0.08)';this.style.boxShadow='none'">
                <div class="p-5">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-3xl font-bold" style="color: rgba(0, 229, 255, 0.15); font-family: var(--font-en); transition: color 0.4s ease;" onmouseover="this.style.color='rgba(0,229,255,0.5)'" onmouseout="this.style.color='rgba(0,229,255,0.15)'">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="t5-tech-tag" style="font-size: 0.55rem;">SYS.ACTIVE</span>
                    </div>

                    <div class="w-full h-32 relative overflow-hidden mb-4" style="background: linear-gradient(135deg, #1a2a4a, #112240); border: 1px solid rgba(0, 229, 255, 0.05);">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-spa text-3xl" style="color: rgba(0, 229, 255, 0.15);"></i>
                        </div>
                        <div class="t5-scanner-line" style="animation-duration: 4s; opacity: 0; transition: opacity 0.4s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'"></div>
                    </div>

                    <h3 class="text-base font-bold text-white mb-2">{{ $service->name }}</h3>
                    <p class="text-xs leading-relaxed mb-4" style="color: var(--neutral-400);">{{ Str::limit($service->description ?? 'بروتوكول علاجي متقدم بأعلى المعايير الطبية', 80) }}</p>

                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold" style="color: var(--accent-400); font-family: var(--font-en);">{{ number_format($service->price, 0) }} ₪</span>
                        <a href="{{ route('booking') }}?service={{ $service->id }}" class="t5-btn-tech text-xs" style="padding: 8px 16px;">
                            <i class="fas fa-calendar-check"></i> احجزي
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('booking') }}" class="inline-flex items-center gap-2 font-bold transition-colors" style="color: var(--accent-400);">
                عرض كل البروتوكولات <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
</section>
@endif
