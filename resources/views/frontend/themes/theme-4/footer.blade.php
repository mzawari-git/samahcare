<footer class="relative overflow-hidden pt-20 pb-8" style="background: var(--brand-800);">
    <div class="absolute top-0 left-0 w-full h-px" style="background: linear-gradient(to right, transparent, var(--brand-500), transparent);"></div>
    <div class="absolute -top-32 -right-32 w-64 h-64 rounded-full opacity-5" style="background: var(--brand-300);"></div>
    <div class="absolute -bottom-32 -left-32 w-64 h-64 rounded-full opacity-5" style="background: var(--brand-300);"></div>

    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6" style="background: rgba(137, 159, 138, 0.15); border: 1px solid rgba(137, 159, 138, 0.25);">
            <i class="fas fa-leaf text-2xl" style="color: var(--brand-300);"></i>
        </div>

        <a href="{{ route('home') }}" class="inline-block mb-4">
            <span class="text-2xl font-bold text-white">{{ $siteSettings['site_name'] ?? 'وادي سلامة' }}</span>
        </a>
        <p class="text-sm leading-relaxed mb-8 max-w-md mx-auto" style="color: var(--brand-300);">
            وجهتك الطبيعية للعناية والشفاء. نستلهم من الطبيعة قوتها ونقدم لك تجربة علاجية فريدة تجمع بين الأصالة والعلم.
        </p>

        <div class="flex justify-center gap-4 mb-10">
            @if(!empty($siteSettings['instagram_url']))
            <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110" style="background: rgba(137, 159, 138, 0.15); color: var(--brand-300);" onmouseover="this.style.background='var(--brand-500)'; this.style.color='white';" onmouseout="this.style.background='rgba(137, 159, 138, 0.15)'; this.style.color='var(--brand-300)';">
                <i class="fab fa-instagram"></i>
            </a>
            @endif
            @if(!empty($siteSettings['facebook_url']))
            <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110" style="background: rgba(137, 159, 138, 0.15); color: var(--brand-300);" onmouseover="this.style.background='var(--brand-500)'; this.style.color='white';" onmouseout="this.style.background='rgba(137, 159, 138, 0.15)'; this.style.color='var(--brand-300)';">
                <i class="fab fa-facebook-f"></i>
            </a>
            @endif
            @if(!empty($siteSettings['tiktok_url']))
            <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110" style="background: rgba(137, 159, 138, 0.15); color: var(--brand-300);" onmouseover="this.style.background='var(--brand-500)'; this.style.color='white';" onmouseout="this.style.background='rgba(137, 159, 138, 0.15)'; this.style.color='var(--brand-300)';">
                <i class="fab fa-tiktok"></i>
            </a>
            @endif
            @if(!empty($siteSettings['whatsapp_number']))
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110" style="background: rgba(137, 159, 138, 0.15); color: var(--brand-300);" onmouseover="this.style.background='var(--brand-500)'; this.style.color='white';" onmouseout="this.style.background='rgba(137, 159, 138, 0.15)'; this.style.color='var(--brand-300)';">
                <i class="fab fa-whatsapp"></i>
            </a>
            @endif
        </div>

        <div class="flex flex-wrap justify-center gap-6 mb-10 text-sm" style="color: var(--brand-300);">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">الرئيسية</a>
            <a href="{{ route('booking') }}" class="hover:text-white transition-colors">الخدمات</a>
            <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">المدونة</a>
            <a href="{{ route('contact') }}" class="hover:text-white transition-colors">تواصل معنا</a>
            <a href="{{ route('faq') }}" class="hover:text-white transition-colors">الأسئلة الشائعة</a>
        </div>

        <div class="pt-8" style="border-top: 1px solid rgba(137, 159, 138, 0.15);">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm" style="color: var(--brand-300);">&copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'وادي سلامة' }}. جميع الحقوق محفوظة.</p>
                <div class="flex gap-6 text-sm" style="color: var(--brand-300);">
                    <a href="{{ route('privacy') }}" class="hover:text-white transition-colors">سياسة الخصوصية</a>
                    <a href="{{ route('terms') }}" class="hover:text-white transition-colors">الشروط والأحكام</a>
                </div>
            </div>
        </div>
    </div>
</footer>
