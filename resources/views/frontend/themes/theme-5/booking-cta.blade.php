<section class="py-24 relative overflow-hidden" style="background-color: var(--neutral-50);">
    <div class="t5-bg-grid absolute inset-0 opacity-30"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="overflow-hidden flex flex-col lg:flex-row" style="border: 1px solid var(--neutral-100); clip-path: polygon(0 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%); box-shadow: var(--shadow-xl);">

            <div class="w-full lg:w-2/5 p-12 relative overflow-hidden" style="background: var(--neutral-900);">
                <div class="t5-bg-grid-dark absolute inset-0 opacity-10"></div>

                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-5">
                    <i class="fas fa-fingerprint" style="font-size: 200px; color: var(--accent-400);"></i>
                </div>

                <div class="relative z-10">
                    <span class="t5-tech-label mb-4 block">INITIATE // بدء الحجز</span>
                    <h3 class="text-3xl font-bold text-white mb-2">احجزي <span class="t5-gradient-text">موعدك</span></h3>
                    <p class="text-sm mb-10" style="color: var(--neutral-400);">تواصلي معنا لتحديد موعد الاستشارة المجانية</p>

                    <div class="space-y-8">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 flex items-center justify-center shrink-0" style="background: rgba(0, 229, 255, 0.1); border: 1px solid rgba(0, 229, 255, 0.2);">
                                <i class="fas fa-map-marker-alt" style="color: var(--accent-400);"></i>
                            </div>
                            <div>
                                <span class="t5-tech-label block mb-1" style="font-size: 0.6rem;">LOC_COORDINATES</span>
                                <p class="text-sm text-white">{{ $siteSettings['site_address'] ?? 'رام الله، فلسطين' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 flex items-center justify-center shrink-0" style="background: rgba(0, 229, 255, 0.1); border: 1px solid rgba(0, 229, 255, 0.2);">
                                <i class="fas fa-phone-alt" style="color: var(--accent-400);"></i>
                            </div>
                            <div>
                                <span class="t5-tech-label block mb-1" style="font-size: 0.6rem;">COM_LINK</span>
                                <p class="text-sm text-white" dir="ltr">{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 flex items-center justify-center shrink-0" style="background: rgba(0, 229, 255, 0.1); border: 1px solid rgba(0, 229, 255, 0.2);">
                                <i class="far fa-clock" style="color: var(--accent-400);"></i>
                            </div>
                            <div>
                                <span class="t5-tech-label block mb-1" style="font-size: 0.6rem;">SYS_HOURS</span>
                                <p class="text-sm text-white">يومياً: 9 صباحاً - 10 مساءً</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex gap-3">
                        @if(!empty($siteSettings['instagram_url']))
                        <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-9 h-9 flex items-center justify-center transition-all" style="background: rgba(0, 229, 255, 0.05); border: 1px solid rgba(0, 229, 255, 0.2); color: var(--neutral-400);" onmouseover="this.style.borderColor='var(--accent-400)';this.style.color='var(--accent-400)'" onmouseout="this.style.borderColor='rgba(0,229,255,0.2)';this.style.color='var(--neutral-400)'"><i class="fab fa-instagram text-sm"></i></a>
                        @endif
                        @if(!empty($siteSettings['whatsapp_number']))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-9 h-9 flex items-center justify-center transition-all" style="background: rgba(0, 229, 255, 0.05); border: 1px solid rgba(0, 229, 255, 0.2); color: var(--neutral-400);" onmouseover="this.style.borderColor='var(--accent-400)';this.style.color='var(--accent-400)'" onmouseout="this.style.borderColor='rgba(0,229,255,0.2)';this.style.color='var(--neutral-400)'"><i class="fab fa-whatsapp text-sm"></i></a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-3/5 p-12 lg:p-16" style="background: var(--surface-elevated);">
                <div class="flex items-center gap-3 mb-8">
                    <span class="w-2 h-2 rounded-full" style="background: var(--accent-400); box-shadow: 0 0 8px var(--accent-400);"></span>
                    <span class="t5-tech-label">SECURE_CONNECTION</span>
                </div>

                <h2 class="text-3xl font-bold mb-8" style="color: var(--ink);">
                    طلب <span class="t5-gradient-text">استشارة</span>
                </h2>

                <form action="{{ route('booking') }}" method="GET" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="t5-tech-label block mb-2">ID_Name</label>
                            <input type="text" name="name" required class="t5-input-tech" placeholder="أدخلي اسمك الكامل">
                        </div>
                        <div>
                            <label class="t5-tech-label block mb-2">COM_Number</label>
                            <input type="tel" name="phone" required class="t5-input-tech" placeholder="05X XXX XXXX" dir="ltr">
                        </div>
                    </div>

                    <div>
                        <label class="t5-tech-label block mb-2">REQ_Protocol</label>
                        <select name="service" class="t5-input-tech">
                            <option value="">اختاري البروتوكول العلاجي</option>
                            @if(isset($featuredServices) && $featuredServices->isNotEmpty())
                                @foreach($featuredServices as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="t5-tech-label block mb-2">MSG_Data</label>
                        <textarea name="notes" rows="3" class="t5-input-tech resize-none" placeholder="أي تفاصيل إضافية..."></textarea>
                    </div>

                    <button type="submit" class="t5-btn-tech w-full text-lg" style="padding: 16px 32px;">
                        <i class="fas fa-paper-plane"></i> إرسال الطلب
                    </button>

                    <div class="flex items-center justify-center gap-2 pt-2">
                        <i class="fas fa-lock text-xs" style="color: var(--ink-dim);"></i>
                        <span class="text-xs" style="color: var(--ink-dim); font-family: var(--font-en);">Data encrypted & secure transmission</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
