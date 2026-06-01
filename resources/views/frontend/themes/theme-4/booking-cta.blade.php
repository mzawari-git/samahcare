<section class="py-24 relative overflow-hidden" style="background: var(--brand-500);">
    <div class="absolute top-10 right-10 opacity-10">
        <i class="fas fa-leaf" style="font-size: 200px; color: var(--brand-800); transform: rotate(-30deg);"></i>
    </div>
    <div class="absolute bottom-10 left-10 opacity-10">
        <i class="fas fa-leaf" style="font-size: 150px; color: var(--brand-800); transform: rotate(150deg);"></i>
    </div>

    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="t4-glass-dark overflow-hidden flex flex-col lg:flex-row" style="border-radius: 50px;">
            <div class="w-full lg:w-5/12 p-10 lg:p-14 relative" style="background: rgba(30, 46, 31, 0.6);">
                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold mb-6" style="background: rgba(137, 159, 138, 0.2); color: var(--brand-300); border: 1px solid rgba(137, 159, 138, 0.3);">
                        <i class="fas fa-calendar-check"></i> احجز موعدك
                    </div>

                    <h3 class="text-3xl font-bold mb-2 text-white">ابدأ رحلة <span style="color: var(--brand-300); font-family: var(--font-en); font-style: italic;">الشفاء</span></h3>
                    <p class="text-sm mb-10" style="color: var(--brand-300);">تواصل معنا اليوم واحصل على استشارتك المجانية</p>

                    <div class="space-y-6">
                        <div class="p-4 flex items-start gap-4" style="background: rgba(255, 255, 255, 0.05); border-radius: 20px; border: 1px solid rgba(137, 159, 138, 0.1);">
                            <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background: rgba(137, 159, 138, 0.15);">
                                <i class="fas fa-map-marker-alt" style="color: var(--brand-300);"></i>
                            </div>
                            <div>
                                <h5 class="font-bold text-sm mb-1 text-white">العنوان</h5>
                                <p class="text-sm" style="color: var(--brand-300);">{{ $siteSettings['site_address'] ?? 'رام الله، فلسطين' }}</p>
                            </div>
                        </div>

                        <div class="p-4 flex items-start gap-4" style="background: rgba(255, 255, 255, 0.05); border-radius: 20px; border: 1px solid rgba(137, 159, 138, 0.1);">
                            <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background: rgba(137, 159, 138, 0.15);">
                                <i class="fas fa-phone-alt" style="color: var(--brand-300);"></i>
                            </div>
                            <div>
                                <h5 class="font-bold text-sm mb-1 text-white">الهاتف</h5>
                                <p class="text-sm" style="color: var(--brand-300);" dir="ltr">{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}</p>
                            </div>
                        </div>

                        <div class="p-4 flex items-start gap-4" style="background: rgba(255, 255, 255, 0.05); border-radius: 20px; border: 1px solid rgba(137, 159, 138, 0.1);">
                            <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background: rgba(137, 159, 138, 0.15);">
                                <i class="far fa-clock" style="color: var(--brand-300);"></i>
                            </div>
                            <div>
                                <h5 class="font-bold text-sm mb-1 text-white">ساعات العمل</h5>
                                <p class="text-sm" style="color: var(--brand-300);">يومياً: 9 صباحاً - 10 مساءً</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        @if(!empty($siteSettings['instagram_url']))
                        <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300" style="background: rgba(137, 159, 138, 0.15); color: var(--brand-300);" onmouseover="this.style.background='var(--brand-800)'; this.style.color='white';" onmouseout="this.style.background='rgba(137, 159, 138, 0.15)'; this.style.color='var(--brand-300)';">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        @if(!empty($siteSettings['whatsapp_number']))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300" style="background: rgba(137, 159, 138, 0.15); color: var(--brand-300);" onmouseover="this.style.background='var(--brand-800)'; this.style.color='white';" onmouseout="this.style.background='rgba(137, 159, 138, 0.15)'; this.style.color='var(--brand-300)';">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-7/12 p-10 lg:p-14" style="background: var(--neutral-50); border-radius: 0 50px 50px 0;">
                <h2 class="text-2xl font-bold mb-8" style="color: var(--ink);">احجز <span class="t4-text-gradient">استشارتك المجانية</span></h2>

                <form action="{{ route('booking') }}" method="GET" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold mb-2" style="color: var(--ink);">الاسم الكريم</label>
                            <input type="text" name="name" required class="t4-leaf-input" placeholder="أدخل اسمك الكامل">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2" style="color: var(--ink);">رقم الجوال</label>
                            <input type="tel" name="phone" required class="t4-leaf-input" placeholder="05X XXX XXXX" dir="ltr">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2" style="color: var(--ink);">البريد الإلكتروني</label>
                        <input type="email" name="email" class="t4-leaf-input" placeholder="example@email.com" dir="ltr">
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2" style="color: var(--ink);">الخدمة المطلوبة</label>
                        <select name="service" class="t4-leaf-input">
                            <option value="">اختر الخدمة</option>
                            @if(isset($featuredServices))
                                @foreach($featuredServices as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2" style="color: var(--ink);">ملاحظات إضافية</label>
                        <textarea name="notes" rows="3" class="t4-leaf-input resize-none" placeholder="أي تفاصيل تود إضافتها..."></textarea>
                    </div>

                    <button type="submit" class="t4-btn-nature w-full !py-4 text-lg">
                        <i class="fas fa-paper-plane"></i> تأكيد الحجز
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
