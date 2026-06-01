<footer style="background: var(--neutral-800);">
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16 mb-16">
            <div>
                <a href="{{ route('home') }}" class="block mb-6" style="font-family: var(--font-en); font-size: 2rem; font-weight: 300; letter-spacing: 6px; color: var(--ink-inverse);">
                    SAMAH
                </a>
                <p class="text-sm font-light leading-relaxed" style="color: var(--neutral-400);">
                    وجهتكِ للعناية المتقدمة بالجمال. نجمع بين العلم والتقنية لنبرز أجمل ما فيكِ.
                </p>
            </div>

            <div>
                <h4 class="text-xs font-light uppercase tracking-widest mb-8" style="color: var(--neutral-400); font-family: var(--font-en);">Links</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('home') }}" class="text-sm font-light transition-colors" style="color: var(--neutral-300);">الرئيسية</a></li>
                    <li><a href="{{ route('booking') }}" class="text-sm font-light transition-colors" style="color: var(--neutral-300);">المتجر</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-sm font-light transition-colors" style="color: var(--neutral-300);">المدونة</a></li>
                    <li><a href="{{ route('contact') }}" class="text-sm font-light transition-colors" style="color: var(--neutral-300);">تواصلي معنا</a></li>
                    <li><a href="{{ route('faq') }}" class="text-sm font-light transition-colors" style="color: var(--neutral-300);">الأسئلة الشائعة</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-light uppercase tracking-widest mb-8" style="color: var(--neutral-400); font-family: var(--font-en);">Connect</h4>
                <div class="flex gap-4 mb-8">
                    @if(!empty($siteSettings['instagram_url']))
                    <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 flex items-center justify-center transition-colors" style="border: 1px solid var(--neutral-600); color: var(--neutral-300);">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                    @if(!empty($siteSettings['facebook_url']))
                    <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-10 h-10 flex items-center justify-center transition-colors" style="border: 1px solid var(--neutral-600); color: var(--neutral-300);">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif
                    @if(!empty($siteSettings['tiktok_url']))
                    <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="w-10 h-10 flex items-center justify-center transition-colors" style="border: 1px solid var(--neutral-600); color: var(--neutral-300);">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    @endif
                    @if(!empty($siteSettings['whatsapp_number']))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-10 h-10 flex items-center justify-center transition-colors" style="border: 1px solid var(--neutral-600); color: var(--neutral-300);">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    @endif
                </div>
                <p class="text-sm font-light" style="color: var(--neutral-400);" dir="ltr">{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}</p>
                <p class="text-sm font-light mt-1" style="color: var(--neutral-400);">{{ $siteSettings['site_address'] ?? 'رام الله، فلسطين' }}</p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8" style="border-top: 1px solid var(--neutral-700);">
            <p class="text-xs font-light" style="color: var(--neutral-500);">&copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'سماح كير' }}. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="{{ route('privacy') }}" class="text-xs font-light transition-colors" style="color: var(--neutral-500);">سياسة الخصوصية</a>
                <a href="{{ route('terms') }}" class="text-xs font-light transition-colors" style="color: var(--neutral-500);">الشروط والأحكام</a>
            </div>
        </div>
    </div>
</footer>
