<section class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h4 class="font-bold tracking-wider uppercase mb-2 text-sm t1-animate-fade-up" style="color: var(--brand-500);">قالوا عنا</h4>
        <h2 class="text-4xl md:text-5xl font-bold mb-16" style="color: var(--ink);">تجارب <span class="t1-text-gradient">عميلاتنا</span></h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $testimonials = [
                    ['name' => 'نور أحمد', 'role' => 'عميلة ليزر', 'text' => 'تجربتي مع جلسات الليزر كانت ممتازة جداً. لا يوجد ألم يذكر والنتيجة ظهرت من الجلسة الثالثة. طاقم العمل محترف وودود للغاية.', 'initial' => 'ن'],
                    ['name' => 'ليلى محمود', 'role' => 'عناية بالبشرة', 'text' => 'عملت هيدرافيشال وبشرتي حرفياً تتنفس! المركز نظيف جداً والاهتمام بالتفاصيل يخليك تحس براحة نفسية. شكراً دكتورة سماح.', 'initial' => 'ل'],
                    ['name' => 'رنا خالد', 'role' => 'تجميل غير جراحي', 'text' => 'حبيت النتيجة الطبيعية لحقن الفيلر للشفايف. الدكتورة إيدها خفيفة وما حسيت بوجع. أكيد راح أعتمد المركز لكل أموري التجميلية.', 'initial' => 'ر'],
                ];
            @endphp

            @foreach($testimonials as $i => $testimonial)
            <div class="t1-glass-card p-8 text-right relative @if($i === 1) md:-translate-y-6 @endif" style="border-radius: 30px;">
                <i class="fas fa-quote-right absolute top-8 left-8 text-4xl opacity-50" style="color: var(--brand-50, #FFF0F5);"></i>
                <div class="flex mb-4 text-sm" style="color: var(--brand-400, #D4AF37);">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="mb-6 leading-relaxed italic" style="color: var(--ink-muted);">"{{ $testimonial['text'] }}"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold" style="background: var(--brand-500);">
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
