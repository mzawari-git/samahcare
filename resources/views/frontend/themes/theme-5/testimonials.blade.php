<section class="py-24 relative" style="background-color: var(--neutral-50);">
    <div class="t5-bg-grid absolute inset-0 opacity-50"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <span class="t5-tech-label mb-3 block">USER.FEEDBACK // آراء العميلات</span>
        <h2 class="text-4xl md:text-5xl font-bold mb-16" style="color: var(--ink);">
            تجارب <span class="t5-gradient-text">موثقة</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $testimonials = [
                    ['name' => 'نور أحمد', 'role' => 'بروتوكول ليزر', 'text' => 'تجربتي مع جلسات الليزر كانت ممتازة جداً. لا يوجد ألم يذكر والنتيجة ظهرت من الجلسة الثالثة. طاقم العمل محترف وودود للغاية.', 'initial' => 'ن'],
                    ['name' => 'ليلى محمود', 'role' => 'علاج بالبشرة', 'text' => 'عملت هيدرافيشال وبشرتي حرفياً تتنفس! المركز نظيف جداً والاهتمام بالتفاصيل يخليك تحس براحة نفسية. شكراً دكتورة سماح.', 'initial' => 'ل'],
                    ['name' => 'رنا خالد', 'role' => 'تجميل غير جراحي', 'text' => 'حبيت النتيجة الطبيعية لحقن الفيلر للشفايف. الدكتورة إيدها خفيفة وما حسيت بوجع. أكيد راح أعتمد المركز لكل أموري التجميلية.', 'initial' => 'ر'],
                ];
            @endphp

            @foreach($testimonials as $i => $testimonial)
            <div class="t5-card-tech p-8 text-right relative @if($i === 1) md:-translate-y-6 @endif" style="background: var(--surface-elevated);">
                <div class="absolute top-6 left-6">
                    <i class="fas fa-quote-right text-3xl" style="color: rgba(0, 229, 255, 0.1);"></i>
                </div>

                <div class="flex mb-4 gap-1" style="color: var(--accent-400);">
                    <i class="fas fa-star text-xs"></i>
                    <i class="fas fa-star text-xs"></i>
                    <i class="fas fa-star text-xs"></i>
                    <i class="fas fa-star text-xs"></i>
                    <i class="fas fa-star text-xs"></i>
                </div>

                <p class="mb-6 leading-relaxed text-sm" style="color: var(--ink-muted);">"{{ $testimonial['text'] }}"</p>

                <div class="t5-divider-gradient mb-6"></div>

                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 flex items-center justify-center text-white font-bold" style="background: var(--neutral-900); clip-path: polygon(0 0, 100% 0, 100% calc(100% - 8px), calc(100% - 8px) 100%, 0 100%);">
                        {{ $testimonial['initial'] }}
                    </div>
                    <div>
                        <h4 class="font-bold text-sm" style="color: var(--ink);">{{ $testimonial['name'] }}</h4>
                        <p class="t5-tech-label" style="font-size: 0.6rem;">{{ $testimonial['role'] }}</p>
                    </div>
                    <div class="mr-auto">
                        <span class="t5-tech-tag" style="font-size: 0.55rem;">VERIFIED</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
