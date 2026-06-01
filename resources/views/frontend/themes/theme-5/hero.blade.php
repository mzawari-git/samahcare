<section class="relative min-h-screen flex items-center pt-20 overflow-hidden t5-bg-grid" style="background-color: var(--neutral-50);">
    <div class="absolute top-0 left-0 w-full h-full" style="background: radial-gradient(ellipse at 30% 50%, rgba(0, 85, 255, 0.05) 0%, transparent 60%);"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 flex flex-col md:flex-row items-center w-full py-12">
        <div class="w-full md:w-1/2 text-right relative">
            <div class="t5-crosshair"></div>

            <div class="inline-flex items-center gap-2 px-4 py-2 mb-6 t5-reveal" style="border: 1px solid rgba(0, 229, 255, 0.3); background: rgba(0, 229, 255, 0.05);">
                <span class="w-2 h-2 rounded-full t5-pulse-glow-box" style="background: var(--accent-400);"></span>
                <span class="t5-tech-label">Advanced Laser Diagnostics</span>
            </div>

            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight mb-6 t5-reveal t5-reveal-d1" style="color: var(--ink);">
                تقنيات <span class="t5-gradient-text t5-pulse-text" style="font-family: var(--font-en);">متقدمة</span><br>
                لجمالٍ <span style="color: var(--accent-400);">أفضل</span>
            </h1>

            <p class="text-lg mb-8 leading-relaxed max-w-lg t5-reveal t5-reveal-d2" style="color: var(--ink-muted);">
                نستخدم أحدث أجهزة الليزر والتقنيات الطبية المعتمدة عالمياً لنقدم لكِ نتائج استثنائية بأعلى معايير الأمان والفعالية.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 t5-reveal t5-reveal-d3">
                <a href="{{ route('booking') }}" class="t5-btn-tech text-lg" style="padding: 16px 36px;">
                    <i class="fas fa-bolt"></i> احجزي جلستك الآن
                </a>
                <a href="{{ route('contact') }}" class="t5-btn-tech-outline text-lg" style="padding: 16px 36px;">
                    <i class="fas fa-headset"></i> استشارة مجانية
                </a>
            </div>

            <div class="mt-12 flex items-center gap-8 pt-8 t5-reveal t5-reveal-d4" style="border-top: 1px solid var(--neutral-100);">
                <div>
                    <p class="text-3xl font-bold" style="color: var(--brand-500); font-family: var(--font-en);">+{{ \App\Models\Service::count() }}</p>
                    <p class="text-xs mt-1" style="color: var(--ink-muted);">بروتوكول علاجي</p>
                </div>
                <div class="w-px h-12" style="background: var(--neutral-100);"></div>
                <div>
                    <p class="text-3xl font-bold" style="color: var(--brand-500); font-family: var(--font-en);">5K+</p>
                    <p class="text-xs mt-1" style="color: var(--ink-muted);">حالة ناجحة</p>
                </div>
                <div class="w-px h-12" style="background: var(--neutral-100);"></div>
                <div>
                    <p class="text-3xl font-bold" style="color: var(--brand-500); font-family: var(--font-en);">4.9</p>
                    <p class="text-xs mt-1" style="color: var(--ink-muted);">تقييم الدقة</p>
                </div>
            </div>
        </div>

        <div class="hidden md:block w-full md:w-1/2 relative mt-12 md:mt-0 t5-reveal t5-reveal-d5">
            <div class="relative w-[420px] h-[520px] mx-auto">
                <div class="absolute inset-0 overflow-hidden" style="border: 1px solid var(--neutral-100); clip-path: polygon(0 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%); background: linear-gradient(160deg, var(--neutral-900), #112240);">
                    <div class="t5-bg-grid-dark absolute inset-0 opacity-20"></div>
                    <div class="t5-scanner-line"></div>

                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-28 h-28 mx-auto mb-6 flex items-center justify-center" style="border: 2px solid rgba(0, 229, 255, 0.3); background: rgba(0, 229, 255, 0.05);">
                                <i class="fas fa-atom text-5xl" style="color: var(--accent-400);"></i>
                            </div>
                            <p class="text-2xl font-bold text-white">{{ $siteSettings['site_name'] ?? 'سماح' }}</p>
                            <p class="t5-tech-label mt-2">Med-Tech Systems Online</p>
                        </div>
                    </div>

                    <div class="absolute top-4 right-4 flex flex-col gap-2">
                        <div class="px-3 py-1.5 text-left" style="background: rgba(0, 229, 255, 0.1); border: 1px solid rgba(0, 229, 255, 0.2);">
                            <span class="t5-tech-label" style="font-size: 0.55rem; color: var(--neutral-400);">Temp</span>
                            <p class="text-xs font-bold t5-data-flicker" style="color: var(--accent-400); font-family: var(--font-en);">36.7°C</p>
                        </div>
                        <div class="px-3 py-1.5 text-left" style="background: rgba(0, 229, 255, 0.1); border: 1px solid rgba(0, 229, 255, 0.2);">
                            <span class="t5-tech-label" style="font-size: 0.55rem; color: var(--neutral-400);">Cooling</span>
                            <p class="text-xs font-bold t5-data-flicker" style="color: var(--accent-400); font-family: var(--font-en);">ACTIVE</p>
                        </div>
                    </div>

                    <div class="absolute bottom-4 left-4 flex flex-col gap-2">
                        <div class="px-3 py-1.5 text-left" style="background: rgba(0, 229, 255, 0.1); border: 1px solid rgba(0, 229, 255, 0.2);">
                            <span class="t5-tech-label" style="font-size: 0.55rem; color: var(--neutral-400);">Target</span>
                            <p class="text-xs font-bold t5-data-flicker" style="color: var(--accent-400); font-family: var(--font-en);">DERMIS</p>
                        </div>
                        <div class="px-3 py-1.5 text-left" style="background: rgba(0, 229, 255, 0.1); border: 1px solid rgba(0, 229, 255, 0.2);">
                            <span class="t5-tech-label" style="font-size: 0.55rem; color: var(--neutral-400);">Depth</span>
                            <p class="text-xs font-bold t5-data-flicker" style="color: var(--accent-400); font-family: var(--font-en);">2.4mm</p>
                        </div>
                    </div>
                </div>

                <div class="absolute -bottom-6 -right-6 px-5 py-4 z-20" style="background: var(--surface-elevated); border: 1px solid rgba(0, 229, 255, 0.3); clip-path: polygon(0 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%); box-shadow: 0 0 20px rgba(0, 229, 255, 0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 flex items-center justify-center" style="background: rgba(0, 229, 255, 0.1); border: 1px solid rgba(0, 229, 255, 0.3);">
                            <i class="fas fa-shield-alt" style="color: var(--accent-400);"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold" style="color: var(--ink);">FDA Approved</p>
                            <p class="t5-tech-label" style="font-size: 0.55rem;">Certified Protocol</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
