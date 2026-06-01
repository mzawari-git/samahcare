<footer style="background: var(--neutral-900); color: var(--neutral-300);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="py-16 lg:py-20 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-12">
            
            <div class="lg:col-span-4">
                <div class="flex items-center gap-2.5 mb-6">
                    @if(!empty($siteSettings['site_logo_url']))
                        <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name'] ?? 'سماح كير' }}" class="h-10 w-auto object-contain brightness-0 invert">
                    @else
                        <span class="text-xl font-black text-white">
                            سماح <span style="color: var(--brand-400);">كير</span>
                        </span>
                    @endif
                </div>
                <p class="text-base leading-relaxed mb-6 max-w-sm" style="color: var(--neutral-400);">
                    {{ $siteSettings['site_description'] ?? 'وجهتكِ الأولى لخدمات العناية بالبشرة والتجميل. نقدم لكِ تجربة جمالية استثنائية بأيدي خبيرات معتمدات.' }}
                </p>
                
                <div class="flex gap-2">
                    @if(!empty($siteSettings['facebook_url']))
                    <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:scale-110" style="background: var(--neutral-800); color: var(--neutral-300);">
                        <i class="ph-fill ph-facebook-logo text-lg"></i>
                    </a>
                    @endif
                    @if(!empty($siteSettings['instagram_url']))
                    <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:scale-110" style="background: var(--neutral-800); color: var(--neutral-300);">
                        <i class="ph-fill ph-instagram-logo text-lg"></i>
                    </a>
                    @endif
                    @if(!empty($siteSettings['whatsapp_number']))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:scale-110" style="background: #25D366; color: white;">
                        <i class="ph-fill ph-whatsapp-logo text-lg"></i>
                    </a>
                    @endif
                    @if(!empty($siteSettings['tiktok_url']))
                    <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:scale-110" style="background: var(--neutral-800); color: var(--neutral-300);">
                        <i class="ph-fill ph-tiktok-logo text-lg"></i>
                    </a>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-2">
                <h5 class="text-sm font-bold text-white mb-5 uppercase tracking-wider">روابط سريعة</h5>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" class="footer-link">الرئيسية</a></li>
                    <li><a href="{{ route('booking') }}" class="footer-link">احجزي موعد</a></li>
                    <li><a href="{{ route('blog.index') }}" class="footer-link">المدونة</a></li>
                    <li><a href="{{ route('contact') }}" class="footer-link">تواصلي معنا</a></li>
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h5 class="text-sm font-bold text-white mb-5 uppercase tracking-wider">الدعم</h5>
                <ul class="space-y-3">
                    <li><a href="{{ route('faq') }}" class="footer-link">الأسئلة الشائعة</a></li>
                    <li><a href="{{ route('terms') }}" class="footer-link">الشروط والأحكام</a></li>
                    <li><a href="{{ route('privacy') }}" class="footer-link">سياسة الخصوصية</a></li>
                </ul>
            </div>

            <div class="lg:col-span-4">
                <h5 class="text-sm font-bold text-white mb-5 uppercase tracking-wider">تواصلي معنا</h5>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--neutral-800);">
                            <i class="ph-fill ph-map-pin text-base" style="color: var(--brand-400);"></i>
                        </div>
                        <span>{{ $siteSettings['site_address'] ?? 'فلسطين، رام الله' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--neutral-800);">
                            <i class="ph-fill ph-phone text-base" style="color: var(--brand-400);"></i>
                        </div>
                        <span dir="ltr">{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--neutral-800);">
                            <i class="ph-fill ph-envelope text-base" style="color: var(--brand-400);"></i>
                        </div>
                        <span>{{ $siteSettings['site_email'] ?? 'hello@samahcare.com' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--neutral-800);">
                            <i class="ph-fill ph-clock text-base" style="color: var(--brand-400);"></i>
                        </div>
                        <span>{{ $siteSettings['working_hours'] ?? 'يومياً 9:00 ص - 10:00 م' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="py-6 flex flex-col md:flex-row justify-between items-center gap-4 text-sm" style="border-top: 1px solid var(--neutral-800); color: var(--neutral-500);">
            <p>&copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'سماح كير' }}. جميع الحقوق محفوظة.</p>
            <div class="flex gap-2">
                <span class="px-3 py-1.5 rounded-full text-xs font-medium" style="background: var(--neutral-800); color: var(--neutral-400);">
                    <i class="ph ph-wallet ml-1"></i>
                    الدفع عند الحضور
                </span>
                @if(($siteSettings['payment_jawwal_enabled'] ?? '0') == '1')
                <span class="px-3 py-1.5 rounded-full text-xs font-medium" style="background: rgba(37, 211, 102, 0.15); color: #25D366;">
                    <i class="ph ph-device-mobile ml-1"></i>
                    جوال باي
                </span>
                @endif
            </div>
        </div>
    </div>
</footer>

<style>
.footer-link {
    color: var(--neutral-400);
    text-decoration: none !important;
    transition: color var(--transition-fast);
    font-size: 0.9375rem;
}
.footer-link:hover {
    color: var(--brand-400);
}
</style>
