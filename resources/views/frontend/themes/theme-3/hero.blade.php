<section class="relative overflow-hidden" style="background: var(--surface); padding-top: 140px;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-12 gap-8 items-center min-h-[80vh]">
            <div class="col-span-12 md:col-span-5 order-2 md:order-1">
                <p class="text-xs uppercase tracking-widest mb-6 font-light" style="color: var(--ink-dim); font-family: var(--font-en);">Beauty & Wellness</p>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-light leading-tight mb-8" style="color: var(--ink);">
                    جمالٌ نقيّ<br>
                    يبدأ من <span style="color: var(--brand-400);">هنا</span>
                </h1>
                <p class="text-base font-light leading-relaxed mb-10" style="color: var(--ink-muted); max-width: 400px;">
                    نقدم لكِ تجربة تجميلية استثنائية تجمع بين أحدث التقنيات العالمية ولمسة الخبراء المتخصصين.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('booking') }}" class="t3-btn-elegant">
                        <span>احجزي موعدكِ</span>
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                    <a href="{{ route('contact') }}" class="t3-btn-outline">
                        <span>استشارة مجانية</span>
                    </a>
                </div>
            </div>

            <div class="col-span-12 md:col-span-7 order-1 md:order-2">
                <div class="t3-hero-image t3-img-reveal relative" style="height: 550px;">
                    <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(145deg, var(--accent-100), var(--accent-200));">
                        <div class="text-center">
                            <div class="w-28 h-28 flex items-center justify-center mx-auto mb-6" style="border: 1px solid var(--neutral-200);">
                                <i class="fas fa-spa text-5xl" style="color: var(--brand-400);"></i>
                            </div>
                            <p class="text-xl font-light" style="color: var(--ink); letter-spacing: 4px; font-family: var(--font-en);">SAMAH</p>
                            <p class="text-xs mt-2 font-light" style="color: var(--ink-dim); font-family: var(--font-en);">EST. 2026</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
