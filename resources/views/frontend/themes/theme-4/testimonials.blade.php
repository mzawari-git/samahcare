<section class="py-24 relative" style="background: var(--neutral-50);">
    <div class="absolute top-0 left-0 w-full h-px" style="background: linear-gradient(to right, transparent, var(--neutral-200), transparent);"></div>

    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold mb-4" style="background: var(--brand-50); color: var(--brand-600); border: 1px solid var(--brand-200);">
                <i class="fas fa-leaf"></i> تجارب عملائنا
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-4" style="color: var(--ink);">قصص <span class="t4-text-gradient">شفاء</span> حقيقية</h2>
            <p class="text-base" style="color: var(--ink-muted);">تجارب حقيقية من عملائنا الذين وجدوا في وادي سلامة ملاذهم الطبيعي</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $testimonials = [
                    ['name' => 'سارة أحمد', 'role' => 'علاج بالأعشاب', 'text' => 'تجربة استثنائية! شعرت بالراحة من أول جلسة. المعالجون محترفون ويستخدمون منتجات طبيعية فعلاً. بشرتي تحسنت بشكل ملحوظ بعد ثلاث جلسات فقط.', 'initial' => 'س'],
                    ['name' => 'ليلى محمود', 'role' => 'مساج علاجي', 'text' => 'المكان يشعرني وكأنني في واحة طبيعية. المساج العلاجي كان ممتازاً وتخلصت من آلام الظهر التي عانيت منها لسنوات. أنصح الجميع بتجربته.', 'initial' => 'ل'],
                    ['name' => 'نور خالد', 'role' => 'عناية بالبشرة', 'text' => 'أخيراً وجدت مركز يهتم بالجودة والنظافة. المنتجات طبيعية ١٠٠٪ والنتائج مبهرة. أصبحت عميلة دائمة ولا أستبدل وادي سلامة بأي مركز آخر.', 'initial' => 'ن'],
                ];
            @endphp

            @foreach($testimonials as $i => $testimonial)
            <div class="p-8 relative transition-all duration-400 hover:-translate-y-2 {{ $i === 1 ? 'md:-mt-4' : '' }}" style="background: var(--surface-elevated); border: 1px solid var(--neutral-100); border-radius: 40px; {{ $i === 0 ? 'border-bottom-right-radius: 0;' : ($i === 2 ? 'border-bottom-left-radius: 0;' : '') }}">
                <i class="fas fa-quote-right absolute top-8 left-8 text-4xl opacity-10" style="color: var(--brand-500);"></i>

                <div class="flex mb-4 text-sm gap-1" style="color: var(--brand-400);">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>

                <p class="mb-8 leading-relaxed text-base" style="color: var(--ink-muted);">"{{ $testimonial['text'] }}"</p>

                <div class="flex items-center gap-4 pt-6" style="border-top: 1px solid var(--neutral-100);">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg" style="background: var(--brand-500);">
                        {{ $testimonial['initial'] }}
                    </div>
                    <div>
                        <h4 class="font-bold text-base" style="color: var(--ink);">{{ $testimonial['name'] }}</h4>
                        <p class="text-xs" style="color: var(--ink-dim);">{{ $testimonial['role'] }}</p>
                    </div>
                    <i class="fas fa-leaf text-sm mr-auto" style="color: var(--brand-200);"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
