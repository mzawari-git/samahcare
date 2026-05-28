@extends('frontend.layouts.app-v2')

@section('title', 'تواصل معنا - ' . ($siteSettings['site_name'] ?? 'JeniCare'))
@section('meta_description', 'تواصل مع فريق JeniCare. نحن هنا لمساعدتك على مدار الساعة.')

@section('content')
<section class="pt-32 pb-8 bg-gradient-to-b from-brand-50 to-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-ink">تواصل معنا</h1>
        <p class="text-gray-500 mt-1">نحن هنا للإجابة على جميع استفساراتك</p>
    </div>
</section>

<div class="container" style="padding:32px 16px 60px;">
    <div class="row g-4 justify-content-center">
        <div class="col-lg-5">
            <div style="background:#fff;border-radius:16px;border:1px solid var(--gray-100);padding:24px;">
                <h3 style="font-size:1rem;font-weight:700;color:var(--gray-800);margin-bottom:20px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-paper-plane" style="color:var(--pink-600);"></i> أرسل لنا رسالة
                </h3>
                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    @if(session('success'))
                        <div style="background:#F0FDF4;color:#065F46;padding:12px 16px;border-radius:10px;font-size:.85rem;margin-bottom:16px;border:1px solid #BBF7D0;display:flex;align-items:center;gap:8px;">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    <div class="mb-3">
                        <input type="text" name="name" style="width:100%;padding:12px 16px;border:1px solid var(--gray-200);border-radius:10px;font-family:inherit;font-size:.9rem;outline:none;transition:border-color .3s;" onfocus="this.style.borderColor='var(--pink-400)'" onblur="this.style.borderColor='var(--gray-200)'" placeholder="الاسم الكامل" value="{{ old('name') }}" required>
                        @error('name') <div style="color:var(--danger);font-size:.8rem;margin-top:4px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" style="width:100%;padding:12px 16px;border:1px solid var(--gray-200);border-radius:10px;font-family:inherit;font-size:.9rem;outline:none;transition:border-color .3s;" onfocus="this.style.borderColor='var(--pink-400)'" onblur="this.style.borderColor='var(--gray-200)'" placeholder="البريد الإلكتروني" value="{{ old('email') }}" required>
                        @error('email') <div style="color:var(--danger);font-size:.8rem;margin-top:4px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <input type="text" name="phone" style="width:100%;padding:12px 16px;border:1px solid var(--gray-200);border-radius:10px;font-family:inherit;font-size:.9rem;outline:none;transition:border-color .3s;" onfocus="this.style.borderColor='var(--pink-400)'" onblur="this.style.borderColor='var(--gray-200)'" placeholder="رقم الهاتف (اختياري)" value="{{ old('phone') }}">
                        @error('phone') <div style="color:var(--danger);font-size:.8rem;margin-top:4px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <select name="subject" style="width:100%;padding:12px 16px;border:1px solid var(--gray-200);border-radius:10px;font-family:inherit;font-size:.9rem;outline:none;transition:border-color .3s;background:#fff;appearance:none;" onfocus="this.style.borderColor='var(--pink-400)'" onblur="this.style.borderColor='var(--gray-200)'">
                            <option value="">اختر الموضوع</option>
                            <option value="استفسار عن منتج" {{ old('subject') == 'استفسار عن منتج' ? 'selected' : '' }}>استفسار عن منتج</option>
                            <option value="طلب شراء B2B" {{ old('subject') == 'طلب شراء B2B' ? 'selected' : '' }}>طلب شراء B2B</option>
                            <option value="شكوى أو اقتراح" {{ old('subject') == 'شكوى أو اقتراح' ? 'selected' : '' }}>شكوى أو اقتراح</option>
                            <option value="أخرى" {{ old('subject') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                        </select>
                        @error('subject') <div style="color:var(--danger);font-size:.8rem;margin-top:4px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <textarea name="message" rows="4" style="width:100%;padding:12px 16px;border:1px solid var(--gray-200);border-radius:10px;font-family:inherit;font-size:.9rem;outline:none;transition:border-color .3s;resize:vertical;" onfocus="this.style.borderColor='var(--pink-400)'" onblur="this.style.borderColor='var(--gray-200)'" placeholder="رسالتك..." required>{{ old('message') }}</textarea>
                        @error('message') <div style="color:var(--danger);font-size:.8rem;margin-top:4px;">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" style="width:100%;padding:12px;background:linear-gradient(135deg,var(--pink-600),var(--pink-500));color:#fff;border:none;border-radius:50px;font-weight:700;font-size:.95rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all .3s;box-shadow:0 4px 16px rgba(219,39,119,0.2);" onmouseover="this.style.boxShadow='0 8px 24px rgba(219,39,119,0.3)'" onmouseout="this.style.boxShadow='0 4px 16px rgba(219,39,119,0.2)'">
                        <i class="fas fa-paper-plane"></i> إرسال
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="d-flex flex-column gap-3">
                <div style="background:#fff;border-radius:16px;padding:20px;border:1px solid var(--gray-100);display:flex;align-items:center;gap:16px;">
                    <div style="width:48px;height:48px;border-radius:12px;background:var(--pink-50);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--pink-600);font-size:1.1rem;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 style="font-size:.9rem;font-weight:700;color:var(--gray-800);margin-bottom:2px;">العنوان</h4>
                        <p style="color:var(--gray-500);font-size:.85rem;margin:0;">{{ $siteSettings['site_address'] ?? '📍جنين - مُقابل مخبز و مطعم السينما' }}</p>
                    </div>
                </div>
                <div style="background:#fff;border-radius:16px;padding:20px;border:1px solid var(--gray-100);display:flex;align-items:center;gap:16px;">
                    <div style="width:48px;height:48px;border-radius:12px;background:var(--pink-50);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--pink-600);font-size:1.1rem;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <h4 style="font-size:.9rem;font-weight:700;color:var(--gray-800);margin-bottom:2px;">الهاتف وواتساب</h4>
                        <p style="color:var(--gray-500);font-size:.85rem;margin:0;">{{ $siteSettings['site_phone'] ?? '+970 59 123 4567' }}<br>{{ $siteSettings['site_whatsapp'] ?? '+970 59 123 4567' }}</p>
                    </div>
                </div>
                <div style="background:#fff;border-radius:16px;padding:20px;border:1px solid var(--gray-100);display:flex;align-items:center;gap:16px;">
                    <div style="width:48px;height:48px;border-radius:12px;background:var(--pink-50);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--pink-600);font-size:1.1rem;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h4 style="font-size:.9rem;font-weight:700;color:var(--gray-800);margin-bottom:2px;">البريد الإلكتروني</h4>
                        <p style="color:var(--gray-500);font-size:.85rem;margin:0;">{{ $siteSettings['site_email'] ?? 'info@jenincare.com' }}</p>
                    </div>
                </div>
                <div style="background:#fff;border-radius:16px;padding:20px;border:1px solid var(--gray-100);display:flex;align-items:center;gap:16px;">
                    <div style="width:48px;height:48px;border-radius:12px;background:var(--pink-50);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--pink-600);font-size:1.1rem;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h4 style="font-size:.9rem;font-weight:700;color:var(--gray-800);margin-bottom:2px;">ساعات العمل</h4>
                        <p style="color:var(--gray-500);font-size:.85rem;margin:0;">السبت - الخميس: 9:00 صباحاً - 9:00 مساءً<br>الجمعة: مغلق</p>
                    </div>
                </div>
                <div style="background:#fff;border-radius:16px;padding:20px;border:1px solid var(--gray-100);">
                    <h4 style="font-size:.9rem;font-weight:700;color:var(--gray-800);margin-bottom:12px;">تابعنا على</h4>
                    <div class="d-flex gap-2">
                        @if($siteSettings['social_facebook'] ?? false)<a href="{{ $siteSettings['social_facebook'] }}" target="_blank" style="width:36px;height:36px;border-radius:50%;background:#1877F2;color:#fff;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:.85rem;transition:opacity .3s;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'"><i class="fab fa-facebook-f"></i></a>@endif
                        @if($siteSettings['social_instagram'] ?? false)<a href="{{ $siteSettings['social_instagram'] }}" target="_blank" style="width:36px;height:36px;border-radius:50%;background:#E4405F;color:#fff;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:.85rem;transition:opacity .3s;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'"><i class="fab fa-instagram"></i></a>@endif
                        <a href="https://wa.me/{{ $siteSettings['site_whatsapp'] ?? '970591234567' }}" target="_blank" style="width:36px;height:36px;border-radius:50%;background:#25D366;color:#fff;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:.85rem;transition:opacity .3s;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'"><i class="fab fa-whatsapp"></i></a>
                        @if($siteSettings['social_tiktok'] ?? false)<a href="{{ $siteSettings['social_tiktok'] }}" target="_blank" style="width:36px;height:36px;border-radius:50%;background:#000;color:#fff;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:.85rem;transition:opacity .3s;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'"><i class="fab fa-tiktok"></i></a>@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
