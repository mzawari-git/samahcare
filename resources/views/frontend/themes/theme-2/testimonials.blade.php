<section class="py-24" style="background: var(--surface);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-4 mb-4 t2-reveal">
                <span class="t2-decor-line"></span>
                <span class="text-sm font-semibold tracking-widest uppercase" style="color: var(--accent-400); font-family: var(--font-en);">Testimonials</span>
                <span class="t2-decor-line"></span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold t2-reveal t2-reveal-delay-1" style="color: var(--ink);">
                ماذا تقول <span style="font-family: var(--font-en); font-style: italic; color: var(--accent-400);">عميلاتنا</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $testimonials = [
                    ['name' => 'نور أحمد', 'role' => 'عميلة ليزر', 'text' => 'تجربتي مع جلسات الليزر كانت ممتازة جداً. لا يوجد ألم يذكر والنتيجة ظهرت من الجلسة الثالثة. طاقم العمل محترف وودود للغاية.', 'initial' => 'ن'],
                    ['name' => 'ليلى محمود', 'role' => 'عناية بالبشرة', 'text' => 'عملت هيدرافيشال وبشرتي حرفياً تتنفس! المركز نظيف جداً والاهتمام بالتفاصيل يخليك تحس براحة نفسية. شكراً دكتورة سماح.', 'initial' => 'ل'],
                    ['name' => 'رنا خالد', 'role' => 'تجميل غير جراحي', 'text' => 'حبيت النتيجة الطبيعية لحقن الفيلر للشفايف. الدكتورة إيدها خفيفة وما حسيت بوجع. أكيد راح أعتمد المركز لكل أموري التجميلية.', 'initial' => 'ر'],
                ];
            @endphp

            @foreach($testimonials as $i => $testimonial)
            <div class="p-8 t2-reveal t2-reveal-delay-{{ $i + 1 }}" style="background: var(--surface-elevated); border-right: 3px solid var(--accent-400);">
                <i class="fas fa-quote-right text-3xl mb-6 block" style="color: var(--accent-200);"></i>
                <div class="flex gap-1 mb-4 text-sm" style="color: var(--accent-400);">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="mb-8 leading-relaxed" style="color: var(--ink-muted);">"{{ $testimonial['text'] }}"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 flex items-center justify-center font-bold text-white" style="background: var(--brand-500); border-radius: 50%;">
                        {{ $testimonial['initial'] }}
                    </div>
                    <div>
                        <h4 class="font-bold" style="color: var(--ink);">{{ $testimonial['name'] }}</h4>
                        <p class="text-xs" style="color: var(--ink-dim);">{{ $testimonial['role'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
