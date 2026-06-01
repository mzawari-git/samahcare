<section class="relative min-h-screen flex items-center pt-24 pb-12 overflow-hidden" style="background: var(--surface);">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[12rem] md:text-[20rem] lg:text-[26rem] t2-text-outline select-none whitespace-nowrap z-0">
        SAMAH
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1 text-right">
                <div class="flex items-center gap-4 mb-8 t2-reveal">
                    <span class="t2-decor-line"></span>
                    <span class="text-sm font-semibold tracking-widest uppercase" style="color: var(--accent-400); font-family: var(--font-en);">Luxury Beauty</span>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-8 t2-reveal t2-reveal-delay-1" style="color: var(--ink);">
                    فنّ الجمال<br>
                    <span style="font-family: var(--font-en); font-style: italic; color: var(--accent-400);">يبدأ</span> من هنا
                </h1>

                <p class="text-lg leading-relaxed mb-10 max-w-lg t2-reveal t2-reveal-delay-2" style="color: var(--ink-muted);">
                    في {{ $siteSettings['site_name'] ?? 'سماح كير' }}، نؤمن أن الجمال فن. نقدم لكِ تجربة تجميلية استثنائية تجمع بين أحدث التقنيات واللمسة الإنسانية الحانية.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 t2-reveal t2-reveal-delay-3">
                    <a href="{{ route('booking') }}" class="t2-btn-luxury text-lg px-10 py-4">
                        احجزي استشارتكِ <i class="fas fa-arrow-left text-sm"></i>
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 font-semibold transition-all duration-300 hover:text-[var(--accent-400)]" style="color: var(--ink); border: 1px solid var(--brand-500);">
                        تعرّفي علينا
                    </a>
                </div>
            </div>

            <div class="order-1 lg:order-2 relative t2-reveal t2-reveal-delay-2">
                <div class="relative mx-auto" style="max-width: 450px;">
                    <div class="t2-arch t2-img-zoom relative" style="height: 580px; background: linear-gradient(180deg, var(--brand-100) 0%, var(--brand-200) 100%);">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-28 h-28 mx-auto mb-6 flex items-center justify-center" style="background: rgba(255,255,255,0.3); border-radius: 50%;">
                                    <i class="fas fa-spa text-5xl" style="color: var(--brand-500);"></i>
                                </div>
                                <p class="text-2xl font-bold" style="color: var(--brand-500);">{{ $siteSettings['site_name'] ?? 'سماح كير' }}</p>
                                <p class="text-sm mt-2" style="color: var(--ink-muted); font-family: var(--font-en);">Beauty & Wellness</p>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -bottom-6 -right-6 p-6 shadow-xl z-20" style="background: var(--surface-elevated); border-right: 3px solid var(--accent-400);">
                        <div class="flex items-center gap-4">
                            <span class="text-4xl font-bold" style="color: var(--accent-400); font-family: var(--font-en);">15+</span>
                            <div>
                                <p class="font-bold text-sm" style="color: var(--ink);">عاماً من الخبرة</p>
                                <p class="text-xs" style="color: var(--ink-dim);">في التجميل والعناية</p>
                            </div>
                        </div>
                    </div>

                    <div class="absolute top-12 -left-8 w-16 h-16 hidden lg:flex items-center justify-center" style="background: var(--accent-400); border-radius: 50%;">
                        <i class="fas fa-award text-xl" style="color: var(--brand-500);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 t2-scroll-indicator">
        <span>Scroll</span>
        <div class="t2-scroll-line"></div>
    </div>
</section>
