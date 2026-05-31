@php if(!isset($headerServices)){$headerServices=\App\Models\Service::active()->ordered()->get();} @endphp

<footer class="pt-16 pb-8 relative overflow-hidden" style="border-top:2px solid var(--glass-border);">
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 mb-12">
            <div class="lg:col-span-4 text-right">
                <div class="flex items-center gap-3 mb-5 justify-end">
                    @if(!empty($siteSettings['site_logo_url']))
                        <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name'] ?? 'سماح كير ' }}" class="h-10 w-auto object-contain">
                    @else
                        <span class="text-2xl font-extrabold" style="color:var(--ink);">{{ $siteSettings['site_name'] ?? 'سماح كير ' }}<span style="color:var(--brand-500);">.</span></span>
                    @endif
                </div>
                <p class="text-ink-dim text-sm leading-relaxed mb-6 max-w-sm ml-auto">{{ $siteSettings['site_description'] ?? 'خدمات تجميل فاخرة.' }}</p>
                <div class="flex gap-3 justify-end">
                    @if(!empty($siteSettings['facebook_url']))<a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-9 h-9 rounded-full border flex items-center justify-center text-ink-dim hover:text-ink transition-all" style="border-color:var(--glass-border);" aria-label="فيسبوك"><i class="ph-fill ph-facebook-logo text-lg"></i></a>@endif
                    @if(!empty($siteSettings['instagram_url']))<a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-9 h-9 rounded-full border flex items-center justify-center text-ink-dim hover:text-ink transition-all" style="border-color:var(--glass-border);" aria-label="إنستغرام"><i class="ph-fill ph-instagram-logo text-lg"></i></a>@endif
                    @if(!empty($siteSettings['whatsapp_number']))<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-9 h-9 rounded-full border flex items-center justify-center text-ink-dim hover:text-ink transition-all" style="border-color:var(--glass-border);" aria-label="واتساب"><i class="ph-fill ph-whatsapp-logo text-lg"></i></a>@endif
                </div>
            </div>
            <div class="lg:col-span-2 text-right">
                <h5 class="font-bold mb-5 text-sm" style="color:var(--ink);">خدماتنا</h5>
                <ul class="space-y-3 text-ink-dim text-sm">
                    @foreach($headerServices->take(5) as $s)
                        <li><a href="{{ route('booking') }}" class="hover:text-brand-500 transition-colors">{{ $s->name_ar }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="lg:col-span-2 text-right">
                <h5 class="font-bold mb-5 text-sm" style="color:var(--ink);">روابط سريعة</h5>
                <ul class="space-y-3 text-ink-dim text-sm">
                    <li><a href="{{ route('booking') }}" class="hover:text-brand-500 transition-colors">احجزي موعد</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-brand-500 transition-colors">المدونة</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-brand-500 transition-colors">تواصل معنا</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-brand-500 transition-colors">الشروط والأحكام</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-brand-500 transition-colors">سياسة الخصوصية</a></li>
                </ul>
            </div>
            <div class="lg:col-span-4 text-right">
                <h5 class="font-bold mb-5 text-sm" style="color:var(--ink);">تواصل معنا</h5>
                <ul class="space-y-4 text-ink-dim text-sm">
                    <li class="flex items-center gap-3 justify-end"><span>{{ $siteSettings['site_address'] ?? 'فلسطين، رام الله' }}</span><i class="ph-fill ph-map-pin" style="color:var(--brand-500);"></i></li>
                    <li class="flex items-center gap-3 justify-end" dir="ltr"><span>{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}</span><i class="ph-fill ph-phone" style="color:var(--brand-500);"></i></li>
                    <li class="flex items-center gap-3 justify-end"><span>{{ $siteSettings['site_email'] ?? 'info@samahcare.com' }}</span><i class="ph-fill ph-envelope" style="color:var(--brand-500);"></i></li>
                </ul>
            </div>
        </div>
        <div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-ink-dim" style="border-top:2px solid var(--glass-border);">
            <p>&copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'سماح كير ' }}. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</footer>
