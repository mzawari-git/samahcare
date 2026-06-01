<section class="relative min-h-screen flex items-center pt-20 overflow-hidden" style="background: var(--surface-alt, #FFF0F5);">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 t1-hero-overlay z-10"></div>
    </div>

    <div class="absolute top-1/4 left-10 w-32 h-32 rounded-full mix-blend-multiply filter blur-3xl opacity-30 t1-animate-float" style="background: var(--brand-400, #D4AF37);"></div>
    <div class="absolute bottom-1/4 right-10 w-40 h-40 rounded-full mix-blend-multiply filter blur-3xl opacity-30 t1-animate-float t1-delay-200" style="background: var(--brand-500, #B76E79);"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 flex flex-col md:flex-row items-center w-full">
        <div class="w-full md:w-1/2 lg:w-5/12 text-right">
            <div class="inline-block px-4 py-1.5 rounded-full text-sm font-bold mb-6 t1-animate-fade-up" style="background: rgba(255,255,255,0.6); backdrop-filter: blur(8px); border: 1px solid rgba(183, 110, 121, 0.3); color: var(--brand-500);">
                <i class="fas fa-sparkles mr-2 ml-1"></i> جمالكِ يبدأ من هنا
            </div>
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6 t1-animate-fade-up t1-delay-100" style="color: var(--ink);">
                استعيدي <span class="t1-text-gradient italic pr-2" style="font-family: var(--font-en);">تألقكِ</span><br>
                مع {{ $siteSettings['site_name'] ?? 'سماح كير' }}
            </h1>
            <p class="text-lg mb-8 leading-relaxed t1-animate-fade-up t1-delay-200" style="color: var(--ink-muted);">
                {{ $siteSettings['about_center_ar'] ?? 'نقدم لكِ أحدث تقنيات الليزر والعناية بالبشرة على أيدي خبراء متخصصين. تجربة فريدة تجمع بين الرفاهية والنتائج المذهلة لجمال يدوم.' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 t1-animate-fade-up t1-delay-300">
                <a href="{{ route('booking') }}" class="t1-btn-primary px-8 py-4 rounded-full font-bold text-center flex items-center justify-center gap-2 text-lg">
                    اكتشفي خدماتنا <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <a href="{{ route('contact') }}" class="t1-btn-outline px-8 py-4 rounded-full font-bold text-center flex items-center justify-center gap-2 text-lg" style="backdrop-filter: blur(8px);">
                    استشارة مجانية <i class="far fa-calendar-alt"></i>
                </a>
            </div>
            
            <div class="mt-12 flex items-center gap-8 pt-8 t1-animate-fade-up t1-delay-400" style="border-top: 1px solid rgba(183, 110, 121, 0.2);">
                <div>
                    <p class="text-3xl font-bold" style="color: var(--brand-400, #D4AF37); font-family: var(--font-en);">+{{ \App\Models\Service::count() }}</p>
                    <p class="text-sm" style="color: var(--ink-muted);">خدمة متاحة</p>
                </div>
                <div class="w-px h-12" style="background: rgba(183, 110, 121, 0.2);"></div>
                <div>
                    <p class="text-3xl font-bold" style="color: var(--brand-400, #D4AF37); font-family: var(--font-en);">5K+</p>
                    <p class="text-sm" style="color: var(--ink-muted);">عميلة سعيدة</p>
                </div>
                <div class="w-px h-12" style="background: rgba(183, 110, 121, 0.2);"></div>
                <div>
                    <p class="text-3xl font-bold" style="color: var(--brand-400, #D4AF37); font-family: var(--font-en);">4.9</p>
                    <p class="text-sm" style="color: var(--ink-muted);">تقييم العميلات</p>
                </div>
            </div>
        </div>
        
        <div class="hidden md:block w-full md:w-1/2 relative mt-12 md:mt-0 t1-animate-fade-up t1-delay-500">
            <div class="relative w-[400px] h-[550px] mx-auto">
                <div class="absolute inset-0 overflow-hidden shadow-2xl z-10 border-4 border-white" style="border-radius: 100px 100px 100px 0;">
                    <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(145deg, var(--brand-100), var(--brand-200));">
                        <div class="text-center">
                            <div class="w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg bg-white">
                                <i class="fas fa-spa text-6xl" style="color: var(--brand-500);"></i>
                            </div>
                            <p class="text-2xl font-bold" style="color: var(--brand-700);">{{ $siteSettings['site_name'] ?? 'سماح كير' }}</p>
                            <p class="text-sm mt-2" style="color: var(--brand-500); font-family: var(--font-en);">Beauty & Wellness</p>
                        </div>
                    </div>
                </div>
                <div class="absolute -inset-4 z-0 translate-x-4 translate-y-4" style="border-radius: 110px 110px 110px 0; border: 2px solid rgba(212, 175, 55, 0.5);"></div>
                
                <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl z-20 flex items-center gap-3" style="border: 1px solid var(--brand-50, #FFF0F5);">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-xl" style="background: var(--brand-50, #FFF0F5); color: var(--brand-500);">
                        <i class="fas fa-award"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm" style="color: var(--ink);">معتمد دولياً</p>
                        <p class="text-xs" style="color: var(--ink-dim);">أحدث الأجهزة العالمية</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
