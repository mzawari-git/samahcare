@extends('frontend.layouts.app-v2')

@section('title', 'سؤال الأمان - ' . ($siteSettings['site_name'] ?? 'JeniCare'))

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 pt-32 pb-16 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-brand-100 rounded-full blur-3xl opacity-30"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-100 rounded-full blur-3xl opacity-20"></div>
    </div>

    <div class="w-full max-w-md bg-white/80 backdrop-blur-xl rounded-3xl border border-gray-100 shadow-xl p-8 relative z-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-brand-200">
                <i class="ph ph-question text-3xl text-white"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-ink">سؤال الأمان</h1>
            <p class="text-gray-500 text-sm mt-1">أجب على سؤال الأمان لاستعادة كلمة المرور</p>
        </div>

        <div class="bg-surface border border-gray-100 rounded-xl p-4 mb-6">
            <p class="text-sm text-gray-500 mb-1">البريد الإلكتروني</p>
            <p class="font-bold text-ink">{{ $email }}</p>
        </div>

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm flex items-center gap-2">
            <i class="ph ph-warning-circle text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <form action="{{ route('password.check-answer') }}" method="POST" class="space-y-5" novalidate>
            @csrf

            <div>
                <label class="block text-sm font-bold text-ink mb-1.5">سؤال الأمان</label>
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 text-sm text-yellow-800 font-medium">
                    <i class="ph ph-shield-check me-2"></i> {{ $question }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-ink mb-1.5">إجابتك <span class="text-red-400">*</span></label>
                <div class="relative">
                    <i class="ph ph-pencil-simple-line absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                    <input type="text" name="security_answer" required autofocus
                        class="w-full bg-white border border-gray-200 rounded-xl pr-12 pl-4 py-3 text-sm focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all @error('security_answer') border-red-400 @enderror"
                        placeholder="أدخل إجابتك">
                </div>
                @error('security_answer')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="ph ph-warning-circle"></i> {{ $message }}</p>@enderror
            </div>

            <button type="submit"
                class="w-full py-3.5 bg-gradient-to-l from-brand-500 to-brand-600 text-white rounded-full font-bold hover:from-brand-600 hover:to-brand-700 transition-all shadow-lg shadow-brand-200 flex items-center justify-center gap-2">
                <i class="ph ph-check-circle"></i> تحقق
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            <a href="{{ route('password.request') }}" class="text-brand-600 font-bold hover:underline">تغيير البريد الإلكتروني</a>
        </p>
    </div>
</div>
@endsection
