<section class="relative min-h-screen flex items-center pt-24 pb-16 overflow-hidden t4-bg-lines" style="background: var(--surface);">
    <div class="absolute top-20 right-0 w-96 h-96 rounded-full filter blur-3xl opacity-10" style="background: var(--brand-400);"></div>
    <div class="absolute bottom-20 left-0 w-80 h-80 rounded-full filter blur-3xl opacity-10" style="background: var(--brand-300);"></div>

    <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-[0.03]" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,200 Q250,100 500,200 T1000,200" stroke="var(--brand-500)" stroke-width="2" fill="none"/>
        <path d="M0,400 Q250,300 500,400 T1000,400" stroke="var(--brand-500)" stroke-width="1.5" fill="none"/>
        <path d="M0,600 Q250,500 500,600 T1000,600" stroke="var(--brand-500)" stroke-width="1" fill="none"/>
    </svg>

    <div class="max-w-7xl mx-auto px-6 relative z-10 flex flex-col md:flex-row items-center w-full gap-12">
        <div class="w-full md:w-1/2 text-right">
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm font-semibold mb-8 t4-fade-up" style="background: var(--brand-50); color: var(--brand-600); border: 1px solid var(--brand-200);">
                <i class="fas fa-leaf"></i>
                <span>مستوحى من طبيعة وادي سلامة</span>
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 t4-fade-up t4-delay-100" style="color: var(--ink);">
                اكتشف <span class="t4-text-gradient" style="font-family: var(--font-en); font-style: italic;">الشفاء</span><br>
                في أحضان الطبيعة
            </h1>

            <p class="text-lg mb-10 leading-relaxed max-w-lg t4-fade-up t4-delay-200" style="color: var(--ink-muted);">
                في {{ $siteSettings['site_name'] ?? 'وادي سلامة' }}، نجمع بين حكمة الطبيعة وأحدث العلوم لنقدم لك تجربة علاجية شاملة تُعيد لجسدك وروحك التوازن والحيوية.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 t4-fade-up t4-delay-300">
                <a href="{{ route('booking') }}" class="t4-btn-nature text-lg !py-4 !px-10">
                    احجز استشارتك <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <a href="{{ route('contact') }}" class="t4-btn-outline text-lg !py-4 !px-10">
                    <i class="fas fa-phone-alt"></i> تواصل معنا
                </a>
            </div>

            <div class="mt-12 flex items-center gap-8 pt-8 t4-fade-up t4-delay-400" style="border-top: 1px solid var(--neutral-200);">
                <div>
                    <p class="text-3xl font-bold" style="color: var(--brand-500); font-family: var(--font-en);">+{{ \App\Models\Service::count() }}</p>
                    <p class="text-sm" style="color: var(--ink-muted);">خدمة علاجية</p>
                </div>
                <div class="w-px h-12" style="background: var(--neutral-200);"></div>
                <div>
                    <p class="text-3xl font-bold" style="color: var(--brand-500); font-family: var(--font-en);">5K+</p>
                    <p class="text-sm" style="color: var(--ink-muted);">عميل سعيد</p>
                </div>
                <div class="w-px h-12" style="background: var(--neutral-200);"></div>
                <div>
                    <p class="text-3xl font-bold" style="color: var(--brand-500); font-family: var(--font-en);">4.9</p>
                    <p class="text-sm" style="color: var(--ink-muted);">تقييم العملاء</p>
                </div>
            </div>
        </div>

        <div class="hidden md:block w-full md:w-1/2 relative t4-fade-up t4-delay-500">
            <div class="relative w-[420px] h-[520px] mx-auto">
                <div class="absolute top-0 right-0 w-[320px] h-[400px] t4-blob-shape overflow-hidden shadow-2xl z-10" style="border: 4px solid white;">
                    <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(145deg, var(--brand-100), var(--brand-200));">
                        <div class="text-center">
                            <div class="w-28 h-28 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg bg-white">
                                <i class="fas fa-spa text-5xl" style="color: var(--brand-500);"></i>
                            </div>
                            <p class="text-xl font-bold" style="color: var(--brand-700);">{{ $siteSettings['site_name'] ?? 'وادي سلامة' }}</p>
                            <p class="text-xs mt-1" style="color: var(--brand-500); font-family: var(--font-en);">Nature & Healing</p>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 w-[250px] h-[300px] t4-blob-shape-2 overflow-hidden shadow-xl z-20" style="border: 3px solid white;">
                    <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(145deg, var(--accent-100), var(--accent-200));">
                        <i class="fas fa-leaf text-5xl" style="color: var(--brand-500);"></i>
                    </div>
                </div>

                <div class="absolute top-10 -left-4 w-20 h-20 rounded-full flex items-center justify-center z-30 shadow-lg t4-float" style="background: var(--brand-800); color: white;">
                    <div class="text-center">
                        <i class="fas fa-seedling text-lg"></i>
                        <p class="text-[9px] font-bold mt-0.5">100% طبيعي</p>
                    </div>
                </div>

                <div class="absolute -bottom-4 right-8 bg-white p-4 rounded-3xl shadow-xl z-30 flex items-center gap-3 t4-float-slow" style="border: 1px solid var(--neutral-100);">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: var(--brand-50);">
                        <i class="fas fa-award text-xl" style="color: var(--brand-500);"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm" style="color: var(--ink);">معتمد دولياً</p>
                        <p class="text-xs" style="color: var(--ink-dim);">معايير عالمية</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
