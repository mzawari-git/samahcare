@php if(!isset($headerServices)){$headerServices=\App\Models\Service::active()->ordered()->get();} @endphp

<footer class="relative overflow-hidden" style="background:var(--surface);border-top:1px solid rgba(255,255,255,0.04);">
    {{-- Subtle top gradient --}}
    <div class="absolute top-0 left-0 right-0 h-px" style="background:linear-gradient(to left,transparent,var(--brand-500),transparent);opacity:0.3;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Main footer grid --}}
        <div class="py-14 md:py-18">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8">

                {{-- Brand column --}}
                <div class="lg:col-span-4">
                    <div class="flex items-center gap-3 mb-4">
                        @if(!empty($siteSettings['site_logo_url']))
                            <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name'] ?? 'سماح كير' }}" class="h-9 w-auto object-contain">
                        @else
                            <span class="text-xl font-black" style="color:var(--ink);">{{ $siteSettings['site_name_ar'] ?? 'سماح كير' }}<span style="color:var(--brand-500);">.</span></span>
                        @endif
                    </div>
                    <p class="text-sm leading-relaxed mb-5" style="color:var(--ink-dim);max-width:320px;">{{ $siteSettings['site_description'] ?? 'وجهتك الفاخرة لخدمات التجميل والعناية.' }}</p>
                    <div class="flex gap-2.5">
                        @if(!empty($siteSettings['facebook_url']))
                        <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-9 h-9 rounded-full flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5" style="background:rgba(255,255,255,0.04);color:var(--ink-dim);border:1px solid rgba(255,255,255,0.06);" aria-label="فيسبوك">
                            <i class="ph-fill ph-facebook-logo text-base"></i>
                        </a>
                        @endif
                        @if(!empty($siteSettings['instagram_url']))
                        <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-9 h-9 rounded-full flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5" style="background:rgba(255,255,255,0.04);color:var(--ink-dim);border:1px solid rgba(255,255,255,0.06);" aria-label="إنستغرام">
                            <i class="ph-fill ph-instagram-logo text-base"></i>
                        </a>
                        @endif
                        @if(!empty($siteSettings['whatsapp_number']))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-9 h-9 rounded-full flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5" style="background:rgba(255,255,255,0.04);color:var(--ink-dim);border:1px solid rgba(255,255,255,0.06);" aria-label="واتساب">
                            <i class="ph-fill ph-whatsapp-logo text-base"></i>
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Services --}}
                <div class="lg:col-span-2">
                    <h5 class="font-bold text-sm mb-4" style="color:var(--ink);">خدماتنا</h5>
                    <ul class="space-y-2.5">
                        @foreach($headerServices->take(5) as $s)
                        <li>
                            <a href="{{ route('booking') }}" class="text-sm transition-colors duration-200" style="color:var(--ink-dim);text-decoration:none;">{{ $s->name_ar }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Quick links --}}
                <div class="lg:col-span-2">
                    <h5 class="font-bold text-sm mb-4" style="color:var(--ink);">روابط سريعة</h5>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('booking') }}" class="text-sm transition-colors duration-200" style="color:var(--ink-dim);text-decoration:none;">احجزي موعد</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-sm transition-colors duration-200" style="color:var(--ink-dim);text-decoration:none;">المدونة</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm transition-colors duration-200" style="color:var(--ink-dim);text-decoration:none;">تواصل معنا</a></li>
                        <li><a href="{{ route('terms') }}" class="text-sm transition-colors duration-200" style="color:var(--ink-dim);text-decoration:none;">الشروط والأحكام</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-sm transition-colors duration-200" style="color:var(--ink-dim);text-decoration:none;">سياسة الخصوصية</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div class="lg:col-span-4">
                    <h5 class="font-bold text-sm mb-4" style="color:var(--ink);">تواصل معنا</h5>
                    <ul class="space-y-3.5">
                        <li class="flex items-center gap-3 text-sm" style="color:var(--ink-dim);">
                            <i class="ph-fill ph-map-pin flex-shrink-0" style="color:var(--brand-500);"></i>
                            <span>{{ $siteSettings['site_address'] ?? 'فلسطين، رام الله' }}</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm" style="color:var(--ink-dim);" dir="ltr">
                            <i class="ph-fill ph-phone flex-shrink-0" style="color:var(--brand-500);"></i>
                            <span>{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm" style="color:var(--ink-dim);">
                            <i class="ph-fill ph-envelope flex-shrink-0" style="color:var(--brand-500);"></i>
                            <span>{{ $siteSettings['site_email'] ?? 'info@samahcare.com' }}</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="py-6 flex flex-col md:flex-row justify-between items-center gap-4 text-sm" style="border-top:1px solid rgba(255,255,255,0.04);color:var(--ink-dim);">
            <p>&copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'سماح كير' }}. جميع الحقوق محفوظة.</p>
            <div class="flex items-center gap-3">
                <span class="text-[11px] px-3 py-1 rounded-full" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.06);">الدفع عند الحضور</span>
                <span class="text-[11px] px-3 py-1 rounded-full" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.06);">حجز إلكتروني</span>
            </div>
        </div>
    </div>
</footer>
