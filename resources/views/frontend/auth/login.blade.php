@extends($layoutPath)

@section('title', 'تسجيل الدخول - ' . ($siteSettings['site_name'] ?? 'سماح كير'))

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-20" style="background:var(--surface-alt);">
    <div class="w-full max-w-md">
        <div class="rounded-2xl p-8" style="background:white;border:1px solid rgba(0,0,0,0.04);box-shadow:0 4px 24px rgba(0,0,0,0.04);">
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background:var(--brand-50);">
                    <i class="ph ph-user text-3xl" style="color:var(--brand-500);"></i>
                </div>
                <h1 class="text-2xl font-black" style="color:var(--ink);">تسجيل الدخول</h1>
                <p class="text-sm mt-1" style="color:var(--ink-muted);">أهلاً بعودتك! أدخلي بياناتك</p>
            </div>

            @if(session('error'))
            <div class="flex items-center gap-2 p-4 rounded-xl text-sm mb-6" style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;">
                <i class="ph ph-warning-circle text-lg"></i> {{ session('error') }}
            </div>
            @endif

            @if(session('success'))
            <div class="flex items-center gap-2 p-4 rounded-xl text-sm mb-6" style="background:#dcfce7;color:#166534;border:1px solid #bbf7d0;">
                <i class="ph ph-check-circle text-lg"></i> {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5" id="loginForm">
                @csrf
                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">البريد الإلكتروني</label>
                    <div class="relative">
                        <i class="ph ph-envelope-simple absolute right-4 top-1/2 -translate-y-1/2 text-lg" style="color:var(--ink-dim);"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="example@email.com" style="width:100%;padding:0.75rem 2.8rem 0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                    </div>
                    @error('email')<p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">كلمة المرور</label>
                    <div class="relative" x-data="{ show: false }">
                        <i class="ph ph-lock absolute right-4 top-1/2 -translate-y-1/2 text-lg" style="color:var(--ink-dim);"></i>
                        <input :type="show ? 'text' : 'password'" name="password" required placeholder="********" style="width:100%;padding:0.75rem 2.8rem 0.75rem 2.8rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                        <button type="button" @click="show = !show" class="absolute left-4 top-1/2 -translate-y-1/2" style="color:var(--ink-dim);">
                            <i :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'" class="text-lg"></i>
                        </button>
                    </div>
                    @error('password')<p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" value="1" class="w-4 h-4 rounded" style="accent-color:var(--brand-500);">
                        <span class="text-sm" style="color:var(--ink-muted);">تذكرني</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-medium" style="color:var(--brand-500);">نسيت كلمة المرور؟</a>
                </div>

                <button type="submit" id="loginSubmit" class="w-full py-3.5 rounded-full font-bold text-sm text-white transition-all hover:opacity-90 flex items-center justify-center gap-2" style="background:var(--gradient-primary);">
                    <span id="btnText"><i class="ph ph-sign-in"></i> تسجيل الدخول</span>
                    <span id="btnSpinner" class="hidden">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </span>
                </button>
            </form>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full" style="border-top:1px solid rgba(0,0,0,0.06);"></div></div>
                <div class="relative flex justify-center text-sm"><span class="px-4" style="background:white;color:var(--ink-dim);">أو</span></div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ url('auth/google/redirect') }}" class="flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm transition-all hover:bg-gray-50" style="border:1px solid rgba(0,0,0,0.06);color:var(--ink-muted);">
                    <i class="ph ph-google-logo text-lg" style="color:#ea4335;"></i> Google
                </a>
                <a href="{{ url('auth/facebook/redirect') }}" class="flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm transition-all hover:bg-gray-50" style="border:1px solid rgba(0,0,0,0.06);color:var(--ink-muted);">
                    <i class="ph ph-facebook-logo text-lg" style="color:#1877F2;"></i> Facebook
                </a>
            </div>

            <p class="text-center text-sm mt-6" style="color:var(--ink-muted);">
                ليس لديك حساب؟ <a href="{{ route('register') }}" class="font-bold" style="color:var(--brand-500);">إنشاء حساب جديد</a>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('loginForm').addEventListener('submit', function() {
    const btn = document.getElementById('loginSubmit');
    btn.disabled = true;
    document.getElementById('btnText').classList.add('hidden');
    document.getElementById('btnSpinner').classList.remove('hidden');
});
</script>
@endpush
@endsection
