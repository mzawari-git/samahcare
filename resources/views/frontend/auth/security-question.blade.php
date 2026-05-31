@extends($layoutPath)

@section('title', 'سؤال الأمان - ' . ($siteSettings['site_name'] ?? 'سماح كير'))

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-20" style="background:var(--surface-alt);">
    <div class="w-full max-w-md">
        <div class="rounded-2xl p-8" style="background:white;border:1px solid rgba(0,0,0,0.04);box-shadow:0 4px 24px rgba(0,0,0,0.04);">
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background:var(--brand-50);">
                    <i class="ph ph-question text-3xl" style="color:var(--brand-500);"></i>
                </div>
                <h1 class="text-2xl font-black" style="color:var(--ink);">سؤال الأمان</h1>
                <p class="text-sm mt-1" style="color:var(--ink-muted);">أجيبي على سؤال الأمان لاستعادة كلمة المرور</p>
            </div>

            <div class="rounded-xl p-4 mb-6" style="background:var(--surface-alt);">
                <p class="text-xs mb-1" style="color:var(--ink-dim);">البريد الإلكتروني</p>
                <p class="font-bold text-sm" style="color:var(--ink);">{{ $email }}</p>
            </div>

            @if(session('error'))
            <div class="flex items-center gap-2 p-4 rounded-xl text-sm mb-6" style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;">
                <i class="ph ph-warning-circle text-lg"></i> {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('password.check-answer') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">سؤال الأمان</label>
                    <div class="rounded-xl px-4 py-3 text-sm font-medium" style="background:#fffbeb;border:1px solid #fde68a;color:#92400e;">
                        <i class="ph ph-shield-check ml-1"></i> {{ $question }}
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">إجابتك</label>
                    <div class="relative">
                        <i class="ph ph-pencil-simple-line absolute right-4 top-1/2 -translate-y-1/2 text-lg" style="color:var(--ink-dim);"></i>
                        <input type="text" name="security_answer" required autofocus placeholder="أدخلي إجابتك" style="width:100%;padding:0.75rem 2.8rem 0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                    </div>
                    @error('security_answer')<p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full py-3.5 rounded-full font-bold text-sm text-white transition-all hover:opacity-90 flex items-center justify-center gap-2" style="background:var(--gradient-primary);">
                    <i class="ph ph-check-circle"></i> تحقق
                </button>
            </form>

            <p class="text-center text-sm mt-6" style="color:var(--ink-muted);">
                <a href="{{ route('password.request') }}" class="font-bold" style="color:var(--brand-500);">تغيير البريد الإلكتروني</a>
            </p>
        </div>
    </div>
</div>
@endsection
