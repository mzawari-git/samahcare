@extends($layoutPath)

@section('title', 'إنشاء حساب - ' . ($siteSettings['site_name'] ?? 'سماح كير'))

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-20" style="background:var(--surface-alt);">
    <div class="w-full max-w-lg">
        <div class="rounded-2xl p-8" style="background:white;border:1px solid rgba(0,0,0,0.04);box-shadow:0 4px 24px rgba(0,0,0,0.04);">
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background:var(--brand-50);">
                    <i class="ph ph-user-plus text-3xl" style="color:var(--brand-500);"></i>
                </div>
                <h1 class="text-2xl font-black" style="color:var(--ink);">إنشاء حساب جديد</h1>
                <p class="text-sm mt-1" style="color:var(--ink-muted);">انضمي إلينا واستمتعي بتجربة فريدة</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">الاسم الكامل</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="اسمك الكامل" style="width:100%;padding:0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                    @error('name')<p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="example@email.com" style="width:100%;padding:0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                    @error('email')<p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="05XX XXXXXX" style="width:100%;padding:0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                    @error('phone')<p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">كلمة المرور</label>
                        <input type="password" name="password" required placeholder="********" style="width:100%;padding:0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                        @error('password')<p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" required placeholder="********" style="width:100%;padding:0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">سؤال الأمان</label>
                    <select name="security_question" required style="width:100%;padding:0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                        <option value="" disabled selected>اختر سؤال أمان...</option>
                        <option value="ما هو اسم مدرستك الابتدائية؟" {{ old('security_question') == 'ما هو اسم مدرستك الابتدائية؟' ? 'selected' : '' }}>ما هو اسم مدرستك الابتدائية؟</option>
                        <option value="ما هو اسم أفضل صديق لك في الطفولة؟" {{ old('security_question') == 'ما هو اسم أفضل صديق لك في الطفولة؟' ? 'selected' : '' }}>ما هو اسم أفضل صديق لك في الطفولة؟</option>
                        <option value="ما هو اسم حيوانك الأليف الأول؟" {{ old('security_question') == 'ما هو اسم حيوانك الأليف الأول؟' ? 'selected' : '' }}>ما هو اسم حيوانك الأليف الأول؟</option>
                        <option value="في أي مدينة ولدت؟" {{ old('security_question') == 'في أي مدينة ولدت؟' ? 'selected' : '' }}>في أي مدينة ولدت؟</option>
                        <option value="ما هو اسم جدك (والد أمك)؟" {{ old('security_question') == 'ما هو اسم جدك (والد أمك)؟' ? 'selected' : '' }}>ما هو اسم جدك (والد أمك)؟</option>
                        <option value="ما هي ماركة أول سيارة امتلكتها؟" {{ old('security_question') == 'ما هي ماركة أول سيارة امتلكتها؟' ? 'selected' : '' }}>ما هي ماركة أول سيارة امتلكتها؟</option>
                        <option value="ما هو طعامك المفضل؟" {{ old('security_question') == 'ما هو طعامك المفضل؟' ? 'selected' : '' }}>ما هو طعامك المفضل؟</option>
                        <option value="ما هو اسم معلمك المفضل؟" {{ old('security_question') == 'ما هو اسم معلمك المفضل؟' ? 'selected' : '' }}>ما هو اسم معلمك المفضل؟</option>
                    </select>
                    @error('security_question')<p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color:var(--ink);">إجابة سؤال الأمان</label>
                    <input type="text" name="security_answer" value="{{ old('security_answer') }}" required placeholder="أدخلي إجابتك" style="width:100%;padding:0.75rem 1rem;border:1px solid rgba(0,0,0,0.08);border-radius:0.75rem;font-size:0.9rem;background:var(--surface-alt);color:var(--ink);">
                    @error('security_answer')<p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="w-full py-3.5 rounded-full font-bold text-sm text-white transition-all hover:opacity-90 flex items-center justify-center gap-2" style="background:var(--gradient-primary);">
                    <i class="ph ph-user-plus"></i> إنشاء حساب
                </button>
            </form>

            <p class="text-center text-sm mt-6" style="color:var(--ink-muted);">
                لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="font-bold" style="color:var(--brand-500);">تسجيل الدخول</a>
            </p>
        </div>
    </div>
</div>
@endsection
