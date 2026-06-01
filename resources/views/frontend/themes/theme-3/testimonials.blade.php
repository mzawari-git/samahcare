<section class="py-24" style="background: var(--surface-alt);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="text-xs uppercase tracking-widest mb-4 font-light" style="color: var(--ink-dim); font-family: var(--font-en);">Testimonials</p>
            <h2 class="text-3xl md:text-4xl font-light" style="color: var(--ink);">ماذا يقلن عميلاتنا</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $testimonials = [
                    ['name' => 'نور أحمد', 'role' => 'عميلة ليزر', 'text' => 'تجربتي مع جلسات الليزر كانت ممتازة جداً. لا يوجد ألم يذكر والنتيجة ظهرت من الجلسة الثالثة. طاقم العمل محترف وودود للغاية.', 'initial' => 'ن'],
                    ['name' => 'ليلى محمود', 'role' => 'عناية بالبشرة', 'text' => 'عملت هيدرافيشال وبشرتي حرفياً تتنفس! المركز نظيف جداً والاهتمام بالتفاصيل يخليك تحس براحة نفسية. شكراً دكتورة سماح.', 'initial' => 'ل'],
                    ['name' => 'رنا خالد', 'role' => 'تجميل غير جراحي', 'text' => 'حبيت النتيجة الطبيعية لحقن الفيلر للشفايف. الدكتورة إيدها خفيفة وما حسيت بوجع. أكيد راح أعتمد المركز لكل أموري التجميلية.', 'initial' => 'ر'],
                ];
            @endphp

            @foreach($testimonials as $testimonial)
            <div class="p-8" style="border: 1px solid var(--neutral-200);">
                <div class="flex mb-4 text-xs" style="color: var(--brand-400);">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-sm font-light leading-relaxed mb-8" style="color: var(--ink-muted);">"{{ $testimonial['text'] }}"</p>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 flex items-center justify-center text-sm font-light" style="background: var(--accent-200); color: var(--ink);">
                        {{ $testimonial['initial'] }}
                    </div>
                    <div>
                        <h4 class="text-sm font-light" style="color: var(--ink);">{{ $testimonial['name'] }}</h4>
                        <p class="text-xs font-light" style="color: var(--ink-dim);">{{ $testimonial['role'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
