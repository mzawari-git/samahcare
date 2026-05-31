<footer style="background:var(--surface-alt);border-top:1px solid var(--glass-border);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="py-16 lg:py-20 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-4">
                <div class="flex items-center gap-2.5 mb-5">
                    @if(!empty($siteSettings['site_logo_url']))
                        <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name'] ?? 'سماح كير' }}" class="h-10 w-auto object-contain">
                    @else
                        <span class="text-xl font-black font-display" style="color:var(--ink);">سماح <span class="gradient-text">كير</span></span>
                    @endif
                </div>
                <p class="text-sm leading-relaxed mb-6 max-w-sm font-body" style="color:var(--ink-muted);">
                    {{ $siteSettings['site_description'] ?? 'وجهتك الأولى لحجز خدمات العناية بالبشرة والشعر والتجميل. احجزي موعدك الآن بسهولة.' }}
                </p>
                <div class="flex gap-2.5">
                    @if(!empty($siteSettings['facebook_url']))<a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110 hover:shadow-md" style="background:var(--brand-50);color:var(--brand-500);"><i class="ph-fill ph-facebook-logo text-lg"></i></a>@endif
                    @if(!empty($siteSettings['instagram_url']))<a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110 hover:shadow-md" style="background:var(--brand-50);color:var(--brand-500);"><i class="ph-fill ph-instagram-logo text-lg"></i></a>@endif
                    @if(!empty($siteSettings['whatsapp_number']))<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110 hover:shadow-md" style="background:#dcfce7;color:#16a34a;"><i class="ph-fill ph-whatsapp-logo text-lg"></i></a>@endif
                    @if(!empty($siteSettings['tiktok_url']))<a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110 hover:shadow-md" style="background:var(--brand-50);color:var(--brand-500);"><i class="ph-fill ph-tiktok-logo text-lg"></i></a>@endif
                </div>
            </div>

            <div class="lg:col-span-2">
                <h5 class="font-bold text-sm mb-5 font-body" style="color:var(--ink);">روابط سريعة</h5>
                <ul class="space-y-3 text-sm font-body" style="color:var(--ink-muted);">
                    <li><a href="{{ route('home') }}" class="hover:text-[var(--brand-500)] transition-colors inline-flex items-center gap-1"><i class="ph ph-caret-left text-xs"></i>الرئيسية</a></li>
                    <li><a href="{{ route('booking') }}" class="hover:text-[var(--brand-500)] transition-colors inline-flex items-center gap-1"><i class="ph ph-caret-left text-xs"></i>احجزي موعد</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-[var(--brand-500)] transition-colors inline-flex items-center gap-1"><i class="ph ph-caret-left text-xs"></i>المدونة</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-[var(--brand-500)] transition-colors inline-flex items-center gap-1"><i class="ph ph-caret-left text-xs"></i>تواصل معنا</a></li>
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h5 class="font-bold text-sm mb-5 font-body" style="color:var(--ink);">الدعم</h5>
                <ul class="space-y-3 text-sm font-body" style="color:var(--ink-muted);">
                    <li><a href="{{ route('faq') }}" class="hover:text-[var(--brand-500)] transition-colors inline-flex items-center gap-1"><i class="ph ph-caret-left text-xs"></i>الأسئلة الشائعة</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-[var(--brand-500)] transition-colors inline-flex items-center gap-1"><i class="ph ph-caret-left text-xs"></i>الشروط والأحكام</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-[var(--brand-500)] transition-colors inline-flex items-center gap-1"><i class="ph ph-caret-left text-xs"></i>سياسة الخصوصية</a></li>
                </ul>
            </div>

            <div class="lg:col-span-4">
                <h5 class="font-bold text-sm mb-5 font-body" style="color:var(--ink);">تواصلي معنا</h5>
                <ul class="space-y-4 text-sm font-body" style="color:var(--ink-muted);">
                    <li class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:var(--brand-50);">
                            <i class="ph-fill ph-map-pin text-base" style="color:var(--brand-500);"></i>
                        </div>
                        <span>{{ $siteSettings['site_address'] ?? 'فلسطين، رام الله' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:var(--brand-50);">
                            <i class="ph-fill ph-phone text-base" style="color:var(--brand-500);"></i>
                        </div>
                        <span dir="ltr">{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:var(--brand-50);">
                            <i class="ph-fill ph-envelope text-base" style="color:var(--brand-500);"></i>
                        </div>
                        <span>{{ $siteSettings['site_email'] ?? 'hello@samahcare.com' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:var(--brand-50);">
                            <i class="ph-fill ph-clock text-base" style="color:var(--brand-500);"></i>
                        </div>
                        <span>يومياً 9:00 ص - 10:00 م</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="py-6 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-body" style="color:var(--ink-dim);border-top:1px solid var(--glass-border);">
            <p>&copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'سماح كير' }}. جميع الحقوق محفوظة.</p>
            <div class="flex gap-2">
                <span class="px-3 py-1.5 rounded-full font-medium" style="background:var(--brand-50);color:var(--brand-500);">الدفع عند الحضور</span>
                @if(($siteSettings['payment_jawwal_enabled'] ?? '0') == '1')
                <span class="px-3 py-1.5 rounded-full font-medium" style="background:#dcfce7;color:#16a34a;">جوال باي</span>
                @endif
            </div>
        </div>
    </div>
</footer>
