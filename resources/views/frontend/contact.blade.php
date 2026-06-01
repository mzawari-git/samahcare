@extends($layoutPath)

@section('title', 'تواصل معنا - ' . ($siteSettings['site_name'] ?? 'سماح كير'))
@section('meta_description', 'تواصل مع فريق سماح كير - نحن هنا لمساعدتك.')

@section('content')
<section class="py-20 lg:py-28" style="background:var(--surface-alt);">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4" style="color:var(--ink);">تواصلي <span class="gradient-text">معنا</span></h1>
        <p class="text-base" style="color:var(--ink-muted);">نحن هنا للإجابة على جميع استفساراتك</p>
    </div>
</section>

<div class="max-w-6xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">
        <div class="lg:col-span-3">
            <div class="rounded-2xl p-8" style="background:white;border:1px solid rgba(0,0,0,0.04);box-shadow:0 1px 3px rgba(0,0,0,0.04);">
                <h3 class="text-lg font-bold mb-6" style="color:var(--ink);">أرسلي لنا رسالة</h3>
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                    @csrf
                    @if(session('success'))
                    <div class="flex items-center gap-2 p-4 rounded-xl text-sm" style="background:#dcfce7;color:#166534;border:1px solid #bbf7d0;">
                        <i class="ph ph-check-circle text-lg"></i> {{ session('success') }}
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">الاسم الكامل</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="اسمك الكامل" style="width:100%;padding:0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);transition:border-color 0.2s;">
                        @error('name') <p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="example@email.com" style="width:100%;padding:0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                            @error('email') <p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">رقم الهاتف <span style="color:#9ca3af;font-weight:400;font-size:0.7rem;">(اختياري)</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="05XX XXXXXX" style="width:100%;padding:0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">الموضوع</label>
                        <select name="subject" style="width:100%;padding:0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                            <option value="">اختر الموضوع</option>
                            <option value="استفسار عن خدمة" {{ old('subject') == 'استفسار عن خدمة' ? 'selected' : '' }}>استفسار عن خدمة</option>
                            <option value="طلب شراء B2B" {{ old('subject') == 'طلب شراء B2B' ? 'selected' : '' }}>طلب شراء B2B</option>
                            <option value="شكوى أو اقتراح" {{ old('subject') == 'شكوى أو اقتراح' ? 'selected' : '' }}>شكوى أو اقتراح</option>
                            <option value="أخرى" {{ old('subject') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">رسالتك</label>
                        <textarea name="message" rows="4" required placeholder="اكتبي رسالتك هنا..." style="width:100%;padding:0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);resize:vertical;">{{ old('message') }}</textarea>
                        @error('message') <p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full py-3.5 rounded-full font-bold text-sm text-white transition-all hover:opacity-90" style="background:var(--gradient-primary);">
                        <i class="ph ph-paper-plane-tilt"></i> إرسال الرسالة
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4">
            @foreach([
                ['ph ph-map-pin', 'var(--brand-500)', 'var(--brand-50)', 'العنوان', $siteSettings['site_address'] ?? 'فلسطين، رام الله'],
                ['ph ph-phone', '#0891b2', '#ecfeff', 'الهاتف', $siteSettings['site_phone'] ?? '+972 56 903 0203'],
                ['ph ph-envelope', '#d97706', '#fffbeb', 'البريد الإلكتروني', $siteSettings['site_email'] ?? 'hello@samahcare.com'],
                ['ph ph-clock', '#16a34a', '#dcfce7', 'ساعات العمل', $siteSettings['working_hours'] ?? 'يومياً 9:00 ص - 10:00 م'],
            ] as $info)
            <div class="flex items-center gap-4 p-5 rounded-2xl" style="background:white;border:1px solid rgba(0,0,0,0.04);">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $info[2] }};">
                    <i class="{{ $info[0] }} text-xl" style="color:{{ $info[1] }};"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold" style="color:var(--ink);">{{ $info[3] }}</h4>
                    <p class="text-sm mt-0.5" style="color:var(--ink-muted);">{!! $info[4] !!}</p>
                </div>
            </div>
            @endforeach

            <div class="p-5 rounded-2xl" style="background:white;border:1px solid rgba(0,0,0,0.04);">
                <h4 class="text-sm font-bold mb-4" style="color:var(--ink);">تابعينا</h4>
                <div class="flex gap-2.5">
                    @if($siteSettings['facebook_url'] ?? false)<a href="{{ $siteSettings['facebook_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-white" style="background:#1877F2;"><i class="ph-fill ph-facebook-logo text-lg"></i></a>@endif
                    @if($siteSettings['instagram_url'] ?? false)<a href="{{ $siteSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-white" style="background:#E4405F;"><i class="ph-fill ph-instagram-logo text-lg"></i></a>@endif
                    @if($siteSettings['tiktok_url'] ?? false)<a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-white" style="background:#000;"><i class="ph-fill ph-tiktok-logo text-lg"></i></a>@endif
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$siteSettings['whatsapp_number'] ?? '970591234567') }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-white" style="background:#25D366;"><i class="ph-fill ph-whatsapp-logo text-lg"></i></a>
                </div>
            </div>

            @if(!empty($siteSettings['location_embed']))
            <div class="rounded-2xl overflow-hidden mt-4" style="border:1px solid rgba(0,0,0,0.04);">
                {!! $siteSettings['location_embed'] !!}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
