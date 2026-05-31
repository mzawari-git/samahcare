@extends($layoutPath)

@section('title', 'تعيين كلمة مرور جديدة - ' . ($siteSettings['site_name'] ?? 'سماح كير'))

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-20" style="background:var(--surface-alt);">
    <div class="w-full max-w-md">
        <div class="rounded-2xl p-8" style="background:white;border:1px solid rgba(0,0,0,0.04);box-shadow:0 4px 24px rgba(0,0,0,0.04);">
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background:#dcfce7;">
                    <i class="ph ph-lock-simple-open text-3xl" style="color:#16a34a;"></i>
                </div>
                <h1 class="text-2xl font-black" style="color:var(--ink);">كلمة مرور جديدة</h1>
                <p class="text-sm mt-1" style="color:var(--ink-muted);">أدخلي كلمة مرور جديدة لحسابك</p>
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

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">كلمة المرور الجديدة</label>
                    <div class="relative" x-data="{ show: false }">
                        <i class="ph ph-lock absolute right-4 top-1/2 -translate-y-1/2 text-lg" style="color:var(--ink-dim);"></i>
                        <input :type="show ? 'text' : 'password'" name="password" required placeholder="******** (8 أحرف على الأقل)" style="width:100%;padding:0.75rem 2.8rem 0.75rem 2.8rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                        <button type="button" @click="show = !show" class="absolute left-4 top-1/2 -translate-y-1/2" style="color:var(--ink-dim);">
                            <i :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'" class="text-lg"></i>
                        </button>
                    </div>
                    @error('password')<p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">تأكيد كلمة المرور</label>
                    <div class="relative" x-data="{ show: false }">
                        <i class="ph ph-lock-simple absolute right-4 top-1/2 -translate-y-1/2 text-lg" style="color:var(--ink-dim);"></i>
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" required placeholder="********" style="width:100%;padding:0.75rem 2.8rem 0.75rem 2.8rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                        <button type="button" @click="show = !show" class="absolute left-4 top-1/2 -translate-y-1/2" style="color:var(--ink-dim);">
                            <i :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'" class="text-lg"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full py-3.5 rounded-full font-bold text-sm text-white transition-all hover:opacity-90 flex items-center justify-center gap-2" style="background:#16a34a;">
                    <i class="ph ph-check-circle"></i> تعيين كلمة المرور
                </button>
            </form>

            <p class="text-center text-sm mt-6" style="color:var(--ink-muted);">
                <a href="{{ route('login') }}" class="font-bold" style="color:var(--brand-500);">العودة لتسجيل الدخول</a>
            </p>
        </div>
    </div>
</div>
@endsection
