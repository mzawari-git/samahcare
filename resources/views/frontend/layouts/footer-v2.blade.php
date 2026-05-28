{{-- قسم النشرة البريدية --}}
<section class="py-20 bg-brand-50">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <i class="ph-light ph-envelope-open text-5xl text-brand-500 mb-4 inline-block"></i>
        <h2 class="text-3xl font-extrabold text-ink mb-4">انضمي إلى نادي جمال {{ $siteSettings['site_name'] ?? 'JeniCare' }}</h2>
        <p class="text-gray-600 mb-8 font-light">احصلي على خصم 10% على طلبك الأول، وكوني أول من يعرف عن العروض الحصرية والمنتجات الجديدة.</p>
        
        <form class="max-w-md mx-auto relative flex items-center" id="newsletterFormV2">
            @csrf
            <input type="email" name="email" placeholder="عنوان بريدك الإلكتروني" required class="w-full bg-white border border-gray-200 text-ink py-4 px-6 rounded-full focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all shadow-sm text-sm">
            <button type="submit" class="absolute left-2 bg-ink text-white py-2 px-6 rounded-full font-medium hover:bg-brand-600 transition-colors text-sm">
                اشتراك
            </button>
        </form>
        <p id="newsletterMsg" class="text-sm mt-3"></p>
    </div>
</section>

{{-- قسم علامات الثقة --}}
<section class="py-12 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            <div class="flex flex-col items-center text-center p-4">
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mb-3">
                    <i class="ph-fill ph-seal-check text-2xl text-green-600"></i>
                </div>
                <h4 class="font-bold text-ink text-sm mb-1">منتجات أصلية 100%</h4>
                <p class="text-gray-500 text-xs">جميع منتجاتنا أصلية ومستوردة</p>
            </div>
            <div class="flex flex-col items-center text-center p-4">
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                    <i class="ph-fill ph-truck text-2xl text-blue-600"></i>
                </div>
                <h4 class="font-bold text-ink text-sm mb-1">شحن لكل فلسطين</h4>
                <p class="text-gray-500 text-xs">توصيل لجميع المناطق</p>
            </div>
            <div class="flex flex-col items-center text-center p-4">
                <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mb-3">
                    <i class="ph-fill ph-shield-check text-2xl text-purple-600"></i>
                </div>
                <h4 class="font-bold text-ink text-sm mb-1">دفع آمن</h4>
                <p class="text-gray-500 text-xs">الدفع عند الاستلام متاح</p>
            </div>
            <div class="flex flex-col items-center text-center p-4">
                <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                    <i class="ph-fill ph-headset text-2xl text-orange-600"></i>
                </div>
                <h4 class="font-bold text-ink text-sm mb-1">دعم فني</h4>
                <p class="text-gray-500 text-xs">متاح يومياً من 9 صباحاً - 10 مساءً</p>
            </div>
        </div>
        <div class="flex justify-center items-center gap-6 mt-8 pt-8 border-t border-gray-100">
            <div class="flex items-center gap-2">
                <div class="flex -space-x-2 space-x-reverse">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-400 to-brand-500 flex items-center justify-center text-white text-xs font-bold border-2 border-white">أ</div>
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-pink-500 flex items-center justify-center text-white text-xs font-bold border-2 border-white">م</div>
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-purple-500 flex items-center justify-center text-white text-xs font-bold border-2 border-white">س</div>
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center text-white text-xs font-bold border-2 border-white">ن</div>
                </div>
                <div class="text-sm">
                    <span class="font-bold text-ink">+{{ \App\Models\Product::count() }}</span>
                    <span class="text-gray-500">منتج متنوع</span>
                </div>
            </div>
            <div class="hidden md:block w-px h-8 bg-gray-200"></div>
            <div class="hidden md:flex items-center gap-2 text-sm">
                <i class="ph-fill ph-star text-yellow-400"></i>
                <span class="font-bold text-ink">4.8</span>
                <span class="text-gray-500">تقييم العملاء</span>
            </div>
        </div>
    </div>
</section>

{{-- الفوتر --}}
<footer class="bg-ink text-white pt-20 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            
            {{-- تعريف الشركة --}}
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="inline-block mb-6">
                    @if(!empty($siteSettings['site_logo_url']))
                        <img src="{{ $siteSettings['site_logo_url'] }}" alt="{{ $siteSettings['site_name'] ?? 'JeniCare' }}" class="h-10 w-auto object-contain brightness-0 invert">
                    @else
                        <span class="text-3xl font-extrabold tracking-tight text-white">{{ $siteSettings['site_name'] ?? 'JeniCare' }}<span class="text-brand-500">.</span></span>
                    @endif
                </a>
                <p class="text-gray-400 text-sm leading-relaxed mb-6 font-light">
                    {{ $siteSettings['site_description'] ?? 'وجهتك الفاخرة لمنتجات العناية بالبشرة والشعر والمستلزمات الطبية التجميلية في فلسطين. جودة أصلية، ثقة، وجمال.' }}
                </p>
                <div class="flex gap-4">
                    @if(!empty($siteSettings['instagram_url']))
                    <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 rounded-full border border-gray-700 flex items-center justify-center text-gray-300 hover:bg-brand-500 hover:border-brand-500 hover:text-white transition-all">
                        <i class="ph-fill ph-instagram-logo text-xl"></i>
                    </a>
                    @endif
                    @if(!empty($siteSettings['facebook_url']))
                    <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-10 h-10 rounded-full border border-gray-700 flex items-center justify-center text-gray-300 hover:bg-blue-600 hover:border-blue-600 hover:text-white transition-all">
                        <i class="ph-fill ph-facebook-logo text-xl"></i>
                    </a>
                    @endif
                    @if(!empty($siteSettings['whatsapp_number']))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" class="w-10 h-10 rounded-full border border-gray-700 flex items-center justify-center text-gray-300 hover:bg-green-500 hover:border-green-500 hover:text-white transition-all">
                        <i class="ph-fill ph-whatsapp-logo text-xl"></i>
                    </a>
                    @endif
                    @if(!empty($siteSettings['tiktok_url']))
                    <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="w-10 h-10 rounded-full border border-gray-700 flex items-center justify-center text-gray-300 hover:bg-white hover:border-white hover:text-black transition-all">
                        <i class="ph-fill ph-tiktok-logo text-xl"></i>
                    </a>
                    @endif
                    @if(!empty($siteSettings['twitter_url']))
                    <a href="{{ $siteSettings['twitter_url'] }}" target="_blank" class="w-10 h-10 rounded-full border border-gray-700 flex items-center justify-center text-gray-300 hover:bg-blue-400 hover:border-blue-400 hover:text-white transition-all">
                        <i class="ph-fill ph-twitter-logo text-xl"></i>
                    </a>
                    @endif
                </div>
            </div>

            {{-- المتجر --}}
            <div>
                <h4 class="text-lg font-bold mb-6">المتجر</h4>
                <ul class="space-y-4 text-gray-400 text-sm font-light">
                    <li><a href="{{ route('shop') }}" class="hover:text-brand-400 transition-colors">المتجر</a></li>
                    @php
                        $footerCats = $headerCategories ?? \App\Models\Category::active()->withCount('products')->having('products_count', '>', 0)->orderBy('sort_order')->get();
                    @endphp
                    @foreach($footerCats->take(4) as $fcat)
                        @php
                            $arLbl = $fcat->ar_label ?? preg_replace('/\s{2,}/', ' ', trim(preg_replace('/[a-zA-Z&\-\(\)]+/', '', $fcat->name_ar)));
                            $arLbl = !empty($arLbl) ? $arLbl : $fcat->name_ar;
                        @endphp
                        <li><a href="{{ route('shop', ['category' => $fcat->slug]) }}" class="hover:text-brand-400 transition-colors">{{ $arLbl }}</a></li>
                    @endforeach
                    <li><a href="{{ route('b2b') }}" class="hover:text-brand-400 transition-colors">للأعمال (طلب جملة)</a></li>
                </ul>
            </div>

            {{-- المساعدة --}}
            <div>
                <h4 class="text-lg font-bold mb-6">المساعدة والدعم</h4>
                <ul class="space-y-4 text-gray-400 text-sm font-light">
                    <li><a href="{{ route('shipping-policy') }}" class="hover:text-brand-400 transition-colors">الشحن والتوصيل</a></li>
                    <li><a href="{{ route('return-policy') }}" class="hover:text-brand-400 transition-colors">سياسة الإرجاع</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-brand-400 transition-colors">الأسئلة الشائعة</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-brand-400 transition-colors">الشروط والأحكام</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-brand-400 transition-colors">تواصل معنا</a></li>
                    <li><a href="{{ route('admin.login') }}" class="hover:text-brand-400 transition-colors">دخول الإدارة</a></li>
                </ul>
            </div>

            {{-- تواصل --}}
            <div>
                <h4 class="text-lg font-bold mb-6">معلومات الاتصال</h4>
                <ul class="space-y-4 text-gray-400 text-sm font-light">
                    <li class="flex items-start gap-3">
                        <i class="ph-fill ph-map-pin text-brand-500 text-lg mt-0.5"></i>
                        <span>{{ $siteSettings['site_address'] ?? 'فلسطين، رام الله' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="ph-fill ph-phone text-brand-500 text-lg"></i>
                        <span dir="ltr">{{ $siteSettings['site_phone'] ?? '+972 56 903 0203' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="ph-fill ph-envelope text-brand-500 text-lg"></i>
                        <span>{{ $siteSettings['site_email'] ?? 'hello@jenincare.com' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- حقوق النشر --}}
        <div class="pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-sm font-light">
                &copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'شركة جنين للتجميل' }}. جميع الحقوق محفوظة.
            </p>
            <div class="flex gap-2">
                <div class="bg-gray-800 px-3 py-1 rounded text-xs text-gray-400">الدفع عند الاستلام</div>
                @if(($siteSettings['payment_bank_enabled'] ?? '0') == '1')
                <div class="bg-gray-800 px-3 py-1 rounded text-xs text-gray-400">تحويل بنكي</div>
                @endif
                @if(($siteSettings['payment_jawwal_enabled'] ?? '0') == '1')
                <div class="bg-yellow-900/30 px-3 py-1 rounded text-xs text-yellow-400">جوال باي</div>
                @endif
                @if(($siteSettings['payment_reflect_enabled'] ?? '0') == '1')
                <div class="bg-cyan-900/30 px-3 py-1 rounded text-xs text-cyan-400">Reflect</div>
                @endif
            </div>
        </div>
    </div>
</footer>

<script>
document.getElementById('newsletterFormV2')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    const msgEl = document.getElementById('newsletterMsg');
    const email = this.querySelector('input[name="email"]').value.trim();
    if (!email) return;
    btn.disabled = true;
    btn.innerHTML = 'جاري...';
    const basePath = window.basePath || '';
    try {
        const r = await fetch(basePath + '/newsletter/subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ email })
        });
        const d = await r.json();
        if (d.success) {
            msgEl.innerHTML = '<span class="text-green-600 font-medium">' + d.message + '</span>';
            this.querySelector('input[name="email"]').value = '';
            if (window.showNotification) showNotification('success', d.message);
        } else {
            msgEl.innerHTML = '<span class="text-red-500">' + (d.message || 'حدث خطأ') + '</span>';
        }
    } catch(e) {
        msgEl.innerHTML = '<span class="text-red-500">حدث خطأ في الاتصال</span>';
    }
    btn.disabled = false;
    btn.innerHTML = 'اشتراك';
    setTimeout(() => { msgEl.innerHTML = ''; }, 5000);
});
</script>
