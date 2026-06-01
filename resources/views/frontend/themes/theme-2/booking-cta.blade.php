<section class="py-24" style="background: var(--surface);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col lg:flex-row overflow-hidden t2-reveal">
            <div class="w-full lg:w-2/5 p-10 lg:p-14" style="background: var(--brand-100);">
                <div class="flex items-center gap-4 mb-6">
                    <span class="t2-decor-line"></span>
                    <span class="text-sm font-semibold tracking-widest uppercase" style="color: var(--accent-600); font-family: var(--font-en);">Book Now</span>
                </div>

                <h2 class="text-3xl lg:text-4xl font-bold mb-4" style="color: var(--brand-500);">
                    احجزي <span style="font-family: var(--font-en); font-style: italic;">موعدكِ</span>
                </h2>
                <p class="mb-10 leading-relaxed" style="color: var(--ink-muted);">
                    نحن هنا للإجابة على استفساراتك وتحديد الموعد المناسب لكِ. تواصلي معنا الآن.
                </p>

                <div class="space-y-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 flex items-center justify-center shrink-0" style="background: var(--accent-400);">
                            <i class="fas fa-map-marker-alt" style="color: var(--brand-500);"></i>
                        </div>
                        <div>
                            <h5 class="font-bold mb-1" style="color: var(--brand-500);">العنوان</h5>
                            <p class="text-sm" style="color: var(--ink-muted);">{{ $siteSettings['site_address'] ?? 'رام الله، فلسطين' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 flex items-center justify-center shrink-0" style="background: var(--accent-400);">
                            <i class="fas fa-phone-alt" style="color: var(--brand-500);"></i>
                        </div>
                        <div>
                            <h5 class="font-bold mb-1" style="color: var(--brand-500);">الهاتف</h5>
                            <p class="text-sm" dir="ltr" style="color: var(--ink-muted);">{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 flex items-center justify-center shrink-0" style="background: var(--accent-400);">
                            <i class="far fa-clock" style="color: var(--brand-500);"></i>
                        </div>
                        <div>
                            <h5 class="font-bold mb-1" style="color: var(--brand-500);">ساعات العمل</h5>
                            <p class="text-sm" style="color: var(--ink-muted);">يومياً: 9 صباحاً - 10 مساءً</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex gap-4">
                    @if(!empty($siteSettings['instagram_url']))
                    <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 flex items-center justify-center transition-all duration-300 hover:bg-[var(--accent-400)] hover:text-[var(--brand-500)]" style="border: 1px solid var(--brand-500); color: var(--brand-500);"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(!empty($siteSettings['whatsapp_number']))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-10 h-10 flex items-center justify-center transition-all duration-300 hover:bg-[var(--accent-400)] hover:text-[var(--brand-500)]" style="border: 1px solid var(--brand-500); color: var(--brand-500);"><i class="fab fa-whatsapp"></i></a>
                    @endif
                </div>
            </div>

            <div class="w-full lg:w-3/5 p-10 lg:p-14" style="background: var(--surface-elevated);">
                <h3 class="text-2xl font-bold mb-8" style="color: var(--ink);">احجزي استشارتكِ المجانية</h3>
                <form action="{{ route('booking') }}" method="GET" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-2" style="color: var(--ink);">الاسم الكريم</label>
                            <input type="text" name="name" required class="t2-input-luxury" placeholder="أدخلي اسمك">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2" style="color: var(--ink);">رقم الجوال</label>
                            <input type="tel" name="phone" required class="t2-input-luxury" placeholder="05X XXX XXXX" dir="ltr">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2" style="color: var(--ink);">الخدمة المطلوبة</label>
                        <select name="service" class="t2-input-luxury">
                            <option value="">اختاري الخدمة</option>
                            <option value="laser">إزالة الشعر بالليزر</option>
                            <option value="facial">تنظيف البشرة العميق</option>
                            <option value="filler">حقن الفيلر والبوتوكس</option>
                            <option value="glow">جلسات النضارة</option>
                            <option value="other">أخرى</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2" style="color: var(--ink);">ملاحظات إضافية</label>
                        <textarea name="notes" rows="3" class="t2-input-luxury resize-none" placeholder="أي تفاصيل تودين إضافتها..."></textarea>
                    </div>

                    <button type="submit" class="w-full t2-btn-luxury py-4 text-lg">
                        تأكيد الحجز <i class="fas fa-arrow-left text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
