<footer class="pt-20 pb-10 relative overflow-hidden" style="background: var(--brand-500);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="inline-block mb-6">
                    <span class="text-4xl font-bold tracking-wider block" style="font-family: var(--font-en); color: var(--accent-400);">SAMAH</span>
                    <span class="text-sm" style="color: var(--ink-inverse); opacity: 0.7;">{{ $siteSettings['site_name'] ?? 'سماح كير' }}</span>
                </a>
                <p class="text-sm leading-relaxed mb-8" style="color: rgba(250, 248, 245, 0.6);">
                    وجهتكِ الأولى للعناية والجمال. نجمع بين الخبرة الطبية والتكنولوجيا المتقدمة لنبرز أجمل ما فيكِ.
                </p>
                <div class="flex gap-4">
                    @if(!empty($siteSettings['instagram_url']))
                    <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 flex items-center justify-center transition-all duration-300 hover:bg-[var(--accent-400)] hover:text-[var(--brand-500)]" style="border: 1px solid rgba(255,255,255,0.15); color: var(--ink-inverse);"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(!empty($siteSettings['facebook_url']))
                    <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-10 h-10 flex items-center justify-center transition-all duration-300 hover:bg-[var(--accent-400)] hover:text-[var(--brand-500)]" style="border: 1px solid rgba(255,255,255,0.15); color: var(--ink-inverse);"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(!empty($siteSettings['tiktok_url']))
                    <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="w-10 h-10 flex items-center justify-center transition-all duration-300 hover:bg-[var(--accent-400)] hover:text-[var(--brand-500)]" style="border: 1px solid rgba(255,255,255,0.15); color: var(--ink-inverse);"><i class="fab fa-tiktok"></i></a>
                    @endif
                </div>
            </div>

            <div>
                <h4 class="text-sm font-bold tracking-widest uppercase mb-8" style="color: var(--accent-400); font-family: var(--font-en);">روابط سريعة</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('home') }}" class="text-sm transition-colors" style="color: rgba(250, 248, 245, 0.6);">الرئيسية</a></li>
                    <li><a href="{{ route('booking') }}" class="text-sm transition-colors" style="color: rgba(250, 248, 245, 0.6);">المتجر</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-sm transition-colors" style="color: rgba(250, 248, 245, 0.6);">المدونة</a></li>
                    <li><a href="{{ route('contact') }}" class="text-sm transition-colors" style="color: rgba(250, 248, 245, 0.6);">تواصلي معنا</a></li>
                    <li><a href="{{ route('faq') }}" class="text-sm transition-colors" style="color: rgba(250, 248, 245, 0.6);">الأسئلة الشائعة</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold tracking-widest uppercase mb-8" style="color: var(--accent-400); font-family: var(--font-en);">تواصلي معنا</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1 text-xs" style="color: var(--accent-400);"></i>
                        <span class="text-sm" style="color: rgba(250, 248, 245, 0.6);">{{ $siteSettings['site_address'] ?? 'رام الله، فلسطين' }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-phone-alt mt-1 text-xs" style="color: var(--accent-400);"></i>
                        <span class="text-sm" dir="ltr" style="color: rgba(250, 248, 245, 0.6);">{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="far fa-clock mt-1 text-xs" style="color: var(--accent-400);"></i>
                        <span class="text-sm" style="color: rgba(250, 248, 245, 0.6);">يومياً: 9 صباحاً - 10 مساءً</span>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold tracking-widest uppercase mb-8" style="color: var(--accent-400); font-family: var(--font-en);">النشرة البريدية</h4>
                <p class="text-sm mb-6" style="color: rgba(250, 248, 245, 0.6);">اشتركي لتصلك أحدث العروض ونصائح الجمال.</p>
                <form onsubmit="event.preventDefault();" class="flex flex-col gap-4">
                    <input type="email" placeholder="البريد الإلكتروني" required class="t2-underlined-input">
                    <button type="submit" class="t2-btn-luxury w-full" style="background: var(--accent-400); color: var(--brand-500); border-color: var(--accent-400);">
                        اشتركي الآن
                    </button>
                </form>
            </div>
        </div>

        <div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
            <p class="text-sm" style="color: rgba(250, 248, 245, 0.4);">&copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'سماح كير' }}. جميع الحقوق محفوظة.</p>
            <div class="flex gap-6 text-sm" style="color: rgba(250, 248, 245, 0.4);">
                <a href="{{ route('privacy') }}" class="hover:text-[var(--accent-400)] transition-colors">سياسة الخصوصية</a>
                <a href="{{ route('terms') }}" class="hover:text-[var(--accent-400)] transition-colors">الشروط والأحكام</a>
            </div>
        </div>
    </div>
</footer>
