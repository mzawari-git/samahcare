<section class="py-24" style="background: var(--surface);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="p-8 md:p-16" style="background: var(--accent-200); border-radius: 0;">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <div>
                    <p class="text-xs uppercase tracking-widest mb-6 font-light" style="color: var(--ink-dim); font-family: var(--font-en);">Book Now</p>
                    <h2 class="text-3xl md:text-4xl font-light mb-6" style="color: var(--ink);">احجزي استشارتكِ المجانية</h2>
                    <p class="text-sm font-light leading-relaxed mb-12" style="color: var(--ink-muted);">
                        نحن هنا لمساعدتكِ في اختيار العلاج المناسب. تواصلي معنا اليوم واحصلي على استشارة مجانية مع خبرائنا.
                    </p>

                    <div class="space-y-8">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 flex items-center justify-center flex-shrink-0" style="border: 1px solid var(--neutral-300);">
                                <i class="fas fa-map-marker-alt text-sm" style="color: var(--brand-400);"></i>
                            </div>
                            <div>
                                <p class="text-xs font-light uppercase tracking-wider mb-1" style="color: var(--ink-dim); font-family: var(--font-en);">Address</p>
                                <p class="text-sm font-light" style="color: var(--ink);">{{ $siteSettings['site_address'] ?? 'رام الله، فلسطين' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 flex items-center justify-center flex-shrink-0" style="border: 1px solid var(--neutral-300);">
                                <i class="fas fa-phone-alt text-sm" style="color: var(--brand-400);"></i>
                            </div>
                            <div>
                                <p class="text-xs font-light uppercase tracking-wider mb-1" style="color: var(--ink-dim); font-family: var(--font-en);">Phone</p>
                                <p class="text-sm font-light" style="color: var(--ink);" dir="ltr">{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 flex items-center justify-center flex-shrink-0" style="border: 1px solid var(--neutral-300);">
                                <i class="far fa-clock text-sm" style="color: var(--brand-400);"></i>
                            </div>
                            <div>
                                <p class="text-xs font-light uppercase tracking-wider mb-1" style="color: var(--ink-dim); font-family: var(--font-en);">Hours</p>
                                <p class="text-sm font-light" style="color: var(--ink);">يومياً: 9 صباحاً - 10 مساءً</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 md:p-10" style="background: var(--surface-alt);">
                    <h3 class="text-lg font-light mb-8" style="color: var(--ink);">بيانات الحجز</h3>
                    <form action="{{ route('booking') }}" method="GET" class="space-y-8">
                        <div>
                            <input type="text" name="name" required class="t3-minimal-input" placeholder="الاسم الكريم">
                        </div>
                        <div>
                            <input type="tel" name="phone" required class="t3-minimal-input" placeholder="رقم الجوال" dir="ltr">
                        </div>
                        <div>
                            <textarea name="notes" rows="3" class="t3-minimal-input resize-none" placeholder="ملاحظات إضافية (اختياري)"></textarea>
                        </div>
                        <button type="submit" class="t3-btn-elegant w-full">
                            <span>تأكيد الحجز</span>
                            <i class="fas fa-arrow-left text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
