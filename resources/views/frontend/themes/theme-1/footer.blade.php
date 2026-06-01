<footer class="pt-20 pb-10 border-t-4 relative overflow-hidden" style="background: var(--neutral-900, #1A1A1A); border-color: var(--brand-500);">
    <div class="absolute -top-24 -left-24 w-64 h-64 rounded-full mix-blend-overlay filter blur-3xl opacity-10" style="background: var(--brand-500);"></div>
    
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: var(--brand-50);">
                        <span class="text-xl font-bold" style="color: var(--brand-500); font-family: var(--font-en);">S</span>
                    </div>
                    <span class="text-2xl font-bold text-white tracking-wide">{{ $siteSettings['site_name'] ?? 'سماح' }}</span>
                </a>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    وجهتك الأولى للجمال والعناية بالبشرة. نجمع بين العلم والفن لنبرز أجمل ما فيكِ بأمان وثقة.
                </p>
                <div class="flex gap-3">
                    @if(!empty($siteSettings['instagram_url']))
                    <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-8 h-8 rounded flex items-center justify-center text-gray-400 hover:text-white transition-colors" style="background: rgba(255,255,255,0.05);"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(!empty($siteSettings['facebook_url']))
                    <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-8 h-8 rounded flex items-center justify-center text-gray-400 hover:text-white transition-colors" style="background: rgba(255,255,255,0.05);"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(!empty($siteSettings['tiktok_url']))
                    <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="w-8 h-8 rounded flex items-center justify-center text-gray-400 hover:text-white transition-colors" style="background: rgba(255,255,255,0.05);"><i class="fab fa-tiktok"></i></a>
                    @endif
                </div>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6" style="font-family: var(--font-en);">روابط سريعة</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs" style="color: var(--brand-500);"></i> الرئيسية</a></li>
                    <li><a href="{{ route('booking') }}" class="text-gray-400 hover:text-white transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs" style="color: var(--brand-500);"></i> المتجر</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-gray-400 hover:text-white transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs" style="color: var(--brand-500);"></i> المدونة</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs" style="color: var(--brand-500);"></i> تواصلي معنا</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6" style="font-family: var(--font-en);">أبرز الخدمات</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('booking') }}" class="text-gray-400 hover:text-white transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs" style="color: var(--brand-500);"></i> إزالة الشعر بالليزر</a></li>
                    <li><a href="{{ route('booking') }}" class="text-gray-400 hover:text-white transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs" style="color: var(--brand-500);"></i> حقن الفيلر والبوتوكس</a></li>
                    <li><a href="{{ route('booking') }}" class="text-gray-400 hover:text-white transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs" style="color: var(--brand-500);"></i> تنظيف البشرة العميق</a></li>
                    <li><a href="{{ route('booking') }}" class="text-gray-400 hover:text-white transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs" style="color: var(--brand-500);"></i> جلسات النضارة</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6" style="font-family: var(--font-en);">النشرة البريدية</h4>
                <p class="text-gray-400 text-sm mb-4">اشتركي لتصلك أحدث العروض ونصائح الجمال.</p>
                <form onsubmit="event.preventDefault();" class="flex">
                    <input type="email" placeholder="البريد الإلكتروني" required class="px-4 py-2 w-full text-white text-sm outline-none rounded-r-lg" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                    <button type="submit" class="px-4 py-2 rounded-l-lg text-white hover:opacity-80 transition-opacity" style="background: var(--brand-500);">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="border-t pt-8 flex flex-col md:flex-row justify-between items-center gap-4" style="border-color: rgba(255,255,255,0.1);">
            <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'سماح كير' }}. جميع الحقوق محفوظة.</p>
            <div class="flex gap-4 text-sm text-gray-500">
                <a href="{{ route('privacy') }}" class="hover:text-white transition-colors">سياسة الخصوصية</a>
                <a href="{{ route('terms') }}" class="hover:text-white transition-colors">الشروط والأحكام</a>
            </div>
        </div>
    </div>
</footer>
