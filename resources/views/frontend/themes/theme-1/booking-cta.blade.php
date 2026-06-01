<section class="py-24 relative" style="background: var(--surface-alt, #FFF0F5);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="bg-white shadow-2xl overflow-hidden flex flex-col lg:flex-row" style="border-radius: 40px;">
            <div class="w-full lg:w-2/5 text-white p-12 relative overflow-hidden" style="background: var(--neutral-900, #1A1A1A);">
                <div class="absolute -bottom-20 -right-20 w-64 h-64 rounded-full" style="border: 30px solid rgba(183, 110, 121, 0.2);"></div>
                
                <div class="relative z-10">
                    <h3 class="text-3xl font-bold mb-2 italic" style="font-family: var(--font-en); color: var(--brand-400, #D4AF37);">تألقي الآن</h3>
                    <p class="text-gray-400 mb-10">نحن هنا للإجابة على استفساراتك وتحديد موعدك.</p>
                    
                    <div class="space-y-8">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0" style="background: rgba(255,255,255,0.1);">
                                <i class="fas fa-map-marker-alt text-xl" style="color: var(--brand-500);"></i>
                            </div>
                            <div>
                                <h5 class="font-bold mb-1" style="color: var(--brand-400, #D4AF37);">العنوان</h5>
                                <p class="text-gray-300 text-sm">{{ $siteSettings['site_address'] ?? 'رام الله، فلسطين' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0" style="background: rgba(255,255,255,0.1);">
                                <i class="fas fa-phone-alt text-xl" style="color: var(--brand-500);"></i>
                            </div>
                            <div>
                                <h5 class="font-bold mb-1" style="color: var(--brand-400, #D4AF37);">الهاتف</h5>
                                <p class="text-gray-300 text-sm" dir="ltr">{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0" style="background: rgba(255,255,255,0.1);">
                                <i class="far fa-clock text-xl" style="color: var(--brand-500);"></i>
                            </div>
                            <div>
                                <h5 class="font-bold mb-1" style="color: var(--brand-400, #D4AF37);">ساعات العمل</h5>
                                <p class="text-gray-300 text-sm">يومياً: 9 صباحاً - 10 مساءً</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex gap-4">
                        @if(!empty($siteSettings['instagram_url']))
                        <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center hover:text-white transition-colors duration-300" style="background: rgba(255,255,255,0.1);"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if(!empty($siteSettings['whatsapp_number']))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center hover:text-white transition-colors duration-300" style="background: rgba(255,255,255,0.1);"><i class="fab fa-whatsapp"></i></a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-3/5 p-12 lg:p-16">
                <h2 class="text-3xl font-bold mb-8" style="color: var(--ink);">احجزي <span class="t1-text-gradient">استشارتكِ المجانية</span></h2>
                <form action="{{ route('booking') }}" method="GET" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-2" style="color: var(--ink);">الاسم الكريم</label>
                            <input type="text" name="name" required class="w-full px-4 py-3 border bg-gray-50 outline-none transition-all" style="border-radius: 12px; border-color: var(--neutral-200, #E0E0E0);" placeholder="أدخلي اسمك">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2" style="color: var(--ink);">رقم الجوال</label>
                            <input type="tel" name="phone" required class="w-full px-4 py-3 border bg-gray-50 outline-none transition-all" style="border-radius: 12px; border-color: var(--neutral-200, #E0E0E0);" placeholder="05X XXX XXXX" dir="ltr">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-2" style="color: var(--ink);">ملاحظات إضافية (اختياري)</label>
                        <textarea name="notes" rows="3" class="w-full px-4 py-3 border bg-gray-50 outline-none transition-all resize-none" style="border-radius: 12px; border-color: var(--neutral-200, #E0E0E0);" placeholder="أي تفاصيل تودين إضافتها..."></textarea>
                    </div>

                    <button type="submit" class="w-full t1-btn-primary py-4 font-bold text-lg" style="border-radius: 12px;">
                        تأكيد الطلب
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
