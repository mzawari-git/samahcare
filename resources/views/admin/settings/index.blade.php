@php
$tabs = ['general', 'seo', 'business', 'social', 'payment', 'features', 'themes'];
$activeTab = request('tab', 'general');
@endphp
@extends('admin.layouts.app')
@section('title', 'الإعدادات')
@push('styles')
<style>
.setting-tabs { border-bottom: 2px solid var(--gray-200); margin-bottom: 1.5rem; display: flex; gap: 0; overflow-x: auto; }
.setting-tabs .tab-link { padding: .75rem 1.25rem; font-weight: 600; font-size: .875rem; color: var(--gray-500); text-decoration: none; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: all .2s; white-space: nowrap; }
.setting-tabs .tab-link:hover { color: var(--pink-600); }
.setting-tabs .tab-link.active { color: var(--pink-600); border-bottom-color: var(--pink-600); }
.setting-tabs .tab-link i { margin-left: 6px; }
.setting-section { display: none; }
.setting-section.active { display: block; }
.setting-card { background: #fff; border-radius: 12px; border: 1px solid var(--gray-200); padding: 1.5rem; margin-bottom: 1rem; }
.setting-card h6 { font-size: .9rem; font-weight: 700; color: var(--gray-700); margin-bottom: 1.25rem; padding-bottom: .75rem; border-bottom: 1px solid var(--gray-100); }
.form-group { margin-bottom: 1rem; }
.form-group label { font-weight: 600; font-size: .85rem; color: var(--gray-700); margin-bottom: .35rem; display: block; }
.form-group .hint { font-size: .75rem; color: var(--gray-400); }
.form-control, .form-select { border-radius: 8px; border: 1px solid var(--gray-200); padding: .5rem .75rem; font-size: .875rem; }
.form-control:focus, .form-select:focus { border-color: var(--pink-400); box-shadow: 0 0 0 3px rgba(219,39,119,0.1); }
.form-switch .form-check-input { width: 2.5em; height: 1.25em; margin-top: .15em; }
.form-switch .form-check-input:checked { background-color: var(--pink-600); border-color: var(--pink-600); }
.logo-preview { width: 80px; height: 80px; border-radius: 12px; object-fit: contain; border: 1px solid var(--gray-200); background: var(--gray-50); }
</style>
@endpush
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 mb-1"><i class="fas fa-cog" style="color:var(--pink-600);margin-left:8px;"></i> الإعدادات</h1>
        <p class="text-muted small mb-0">إدارة إعدادات الموقع العامة والمتقدمة</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="tab" id="activeTab" value="{{ $activeTab }}">

    <div class="setting-tabs">
        <a href="#" class="tab-link {{ $activeTab === 'general' ? 'active' : '' }}" data-tab="general"><i class="fas fa-globe"></i> عام</a>
        <a href="#" class="tab-link {{ $activeTab === 'seo' ? 'active' : '' }}" data-tab="seo"><i class="fas fa-search"></i> SEO</a>
        <a href="#" class="tab-link {{ $activeTab === 'business' ? 'active' : '' }}" data-tab="business"><i class="fas fa-briefcase"></i> الأعمال</a>
        <a href="#" class="tab-link {{ $activeTab === 'social' ? 'active' : '' }}" data-tab="social"><i class="fas fa-share-alt"></i> التواصل الاجتماعي</a>
        <a href="#" class="tab-link {{ $activeTab === 'payment' ? 'active' : '' }}" data-tab="payment"><i class="fas fa-credit-card"></i> الدفع</a>
        <a href="#" class="tab-link {{ $activeTab === 'features' ? 'active' : '' }}" data-tab="features"><i class="fas fa-star"></i> الميزات</a>
        <a href="#" class="tab-link {{ $activeTab === 'themes' ? 'active' : '' }}" data-tab="themes"><i class="fas fa-palette"></i> التصاميم</a>
    </div>

    {{-- General --}}
    <div class="setting-section {{ $activeTab === 'general' ? 'active' : '' }}" id="tab-general">
        <div class="setting-card">
            <h6><i class="fas fa-info-circle" style="color:var(--pink-600);margin-left:6px;"></i> معلومات الموقع</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم الموقع (عربي)</label>
                        <input type="text" name="site_name_ar" class="form-control" value="{{ old('site_name_ar', $settings['site_name_ar'] ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم الموقع (English)</label>
                        <input type="text" name="site_name_en" class="form-control" value="{{ old('site_name_en', $settings['site_name_en'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>وصف الموقع (عربي)</label>
                        <textarea name="site_description_ar" class="form-control" rows="2">{{ old('site_description_ar', $settings['site_description_ar'] ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>وصف الموقع (English)</label>
                        <textarea name="site_description_en" class="form-control" rows="2" dir="ltr">{{ old('site_description_en', $settings['site_description_en'] ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>البريد الإلكتروني للتواصل</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>رقم الهاتف</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>رقم الواتساب</label>
                        <input type="text" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}" dir="ltr">
                        <small class="hint">مثال: 970599123456</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>العنوان</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $settings['address'] ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="setting-card">
            <h6><i class="fas fa-image" style="color:var(--pink-600);margin-left:6px;"></i> الشعار والأيقونة</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>شعار الموقع</label>
                        @if(!empty($settings['site_logo']))
                        <div class="mb-2"><img src="{{ Storage::url($settings['site_logo']) }}" class="logo-preview"></div>
                        @endif
                        <input type="file" name="site_logo" class="form-control" accept="image/*">
                        <small class="hint">يفضل PNG أو SVG بخلفية شفافة</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>أيقونة الموقع (Favicon)</label>
                        @if(!empty($settings['site_favicon']))
                        <div class="mb-2"><img src="{{ Storage::url($settings['site_favicon']) }}" style="width:32px;height:32px;border-radius:4px;"></div>
                        @endif
                        <input type="file" name="site_favicon" class="form-control" accept="image/*">
                        <small class="hint">يفضل PNG بحجم 32x32</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>التصميم الافتراضي</label>
                        <select name="site_theme" class="form-select">
                            <option value="1" {{ ($settings['site_theme'] ?? '1') == '1' ? 'selected' : '' }}>1 - الأناقة الذهبية (Rose Gold)</option>
                            <option value="2" {{ ($settings['site_theme'] ?? '') == '2' ? 'selected' : '' }}>2 - الفخامة الخضراء (Forest Luxury)</option>
                            <option value="3" {{ ($settings['site_theme'] ?? '') == '3' ? 'selected' : '' }}>3 - النقاء العصري (Pure Editorial)</option>
                            <option value="4" {{ ($settings['site_theme'] ?? '') == '4' ? 'selected' : '' }}>4 - وادي سلامة (Wadi Nature)</option>
                            <option value="5" {{ ($settings['site_theme'] ?? '') == '5' ? 'selected' : '' }}>5 - التقنية المتقدمة (Tech Medical)</option>
                        </select>
                        <small class="hint">المستخدم يمكنه التبديل بالضغط على Ctrl+1 إلى Ctrl+5</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SEO --}}
    <div class="setting-section {{ $activeTab === 'seo' ? 'active' : '' }}" id="tab-seo">
        <div class="setting-card">
            <h6><i class="fas fa-tags" style="color:var(--pink-600);margin-left:6px;"></i> إعدادات SEO العامة</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Meta Title (عربي)</label>
                        <input type="text" name="meta_title_ar" class="form-control" value="{{ old('meta_title_ar', $settings['meta_title_ar'] ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Meta Title (English)</label>
                        <input type="text" name="meta_title_en" class="form-control" value="{{ old('meta_title_en', $settings['meta_title_en'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Meta Description (عربي)</label>
                        <textarea name="meta_description_ar" class="form-control" rows="3">{{ old('meta_description_ar', $settings['meta_description_ar'] ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Meta Description (English)</label>
                        <textarea name="meta_description_en" class="form-control" rows="3" dir="ltr">{{ old('meta_description_en', $settings['meta_description_en'] ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label>الكلمات المفتاحية (Meta Keywords)</label>
                        <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}" placeholder="كلمة1, كلمة2, كلمة3...">
                        <small class="hint">افصل بين الكلمات بفاصلة</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Business --}}
    <div class="setting-section {{ $activeTab === 'business' ? 'active' : '' }}" id="tab-business">
        <div class="setting-card">
            <h6><i class="fas fa-chart-bar" style="color:var(--pink-600);margin-left:6px;"></i> إعدادات الأعمال</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>العملة</label>
                        <select name="currency" class="form-select">
                            <option value="ILS" {{ ($settings['currency'] ?? 'ILS') === 'ILS' ? 'selected' : '' }}>شيكل (ILS)</option>
                            <option value="USD" {{ ($settings['currency'] ?? '') === 'USD' ? 'selected' : '' }}>دولار (USD)</option>
                            <option value="JOD" {{ ($settings['currency'] ?? '') === 'JOD' ? 'selected' : '' }}>دينار (JOD)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>رمز العملة</label>
                        <input type="text" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', $settings['currency_symbol'] ?? '₪') }}" style="width:80px;">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>نسبة الضريبة (%)</label>
                        <input type="number" name="tax_rate" class="form-control" value="{{ old('tax_rate', $settings['tax_rate'] ?? '0') }}" step="0.01" min="0" max="100">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Social Media --}}
    <div class="setting-section {{ $activeTab === 'social' ? 'active' : '' }}" id="tab-social">
        <div class="setting-card">
            <h6><i class="fas fa-share-alt" style="color:var(--pink-600);margin-left:6px;"></i> روابط التواصل الاجتماعي</h6>
            <div class="row g-3">
                @php
                $socialFields = [
                    'facebook_url' => ['fab fa-facebook', '#1877F2', 'فيسبوك'],
                    'instagram_url' => ['fab fa-instagram', '#E4405F', 'إنستغرام'],
                    'twitter_url' => ['fab fa-x-twitter', '#000', 'X (تويتر)'],
                    'linkedin_url' => ['fab fa-linkedin', '#0A66C2', 'لينكد إن'],
                    'tiktok_url' => ['fab fa-tiktok', '#000', 'تيك توك'],
                    'youtube_url' => ['fab fa-youtube', '#FF0000', 'يوتيوب'],
                    'snapchat_url' => ['fab fa-snapchat', '#FFFC00', 'سناب شات'],
                    'pinterest_url' => ['fab fa-pinterest', '#E60023', 'بنترست'],
                ];
                @endphp
                @foreach($socialFields as $key => [$icon, $color, $label])
                <div class="col-md-6 col-lg-3">
                    <div class="form-group">
                        <label><i class="{{ $icon }}" style="color:{{ $color }};width:20px;"></i> {{ $label }}</label>
                        <input type="url" name="{{ $key }}" class="form-control" dir="ltr" value="{{ old($key, $settings[$key] ?? '') }}" placeholder="https://">
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="setting-card">
            <h6><i class="fas fa-lock" style="color:var(--pink-600);margin-left:6px;"></i> تسجيل الدخول عبر OAuth</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Google Client ID</label>
                        <input type="text" name="google_client_id" class="form-control font-monospace" value="{{ old('google_client_id', $settings['google_client_id'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Google Client Secret</label>
                        <input type="password" name="google_client_secret" class="form-control font-monospace" value="{{ old('google_client_secret', $settings['google_client_secret'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Facebook Client ID</label>
                        <input type="text" name="facebook_client_id" class="form-control font-monospace" value="{{ old('facebook_client_id', $settings['facebook_client_id'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Facebook Client Secret</label>
                        <input type="password" name="facebook_client_secret" class="form-control font-monospace" value="{{ old('facebook_client_secret', $settings['facebook_client_secret'] ?? '') }}" dir="ltr">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Payment --}}
    <div class="setting-section {{ $activeTab === 'payment' ? 'active' : '' }}" id="tab-payment">
        <div class="setting-card">
            <h6><i class="fas fa-money-check" style="color:var(--pink-600);margin-left:6px;"></i> طرق الدفع</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-flex align-items-center gap-2">
                            <input type="hidden" name="payment_cod_enabled" value="0">
                            <input type="checkbox" name="payment_cod_enabled" class="form-check-input" value="1" {{ ($settings['payment_cod_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                            الدفع عند الاستلام (COD)
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-flex align-items-center gap-2">
                            <input type="hidden" name="payment_bank_enabled" value="0">
                            <input type="checkbox" name="payment_bank_enabled" class="form-check-input" value="1" {{ ($settings['payment_bank_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                            التحويل البنكي
                        </label>
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-2" id="bankSettings" style="display:{{ ($settings['payment_bank_enabled'] ?? '0') == '1' ? 'flex' : 'none' }};">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>اسم البنك</label>
                        <input type="text" name="payment_bank_name" class="form-control" value="{{ old('payment_bank_name', $settings['payment_bank_name'] ?? '') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>اسم صاحب الحساب</label>
                        <input type="text" name="payment_bank_holder" class="form-control" value="{{ old('payment_bank_holder', $settings['payment_bank_holder'] ?? '') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>رقم الحساب</label>
                        <input type="text" name="payment_bank_account" class="form-control" value="{{ old('payment_bank_account', $settings['payment_bank_account'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>رقم IBAN</label>
                        <input type="text" name="payment_bank_iban" class="form-control" value="{{ old('payment_bank_iban', $settings['payment_bank_iban'] ?? '') }}" dir="ltr">
                    </div>
                </div>
            </div>
            <hr>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-flex align-items-center gap-2">
                            <input type="hidden" name="payment_jawwal_enabled" value="0">
                            <input type="checkbox" name="payment_jawwal_enabled" class="form-check-input" value="1" {{ ($settings['payment_jawwal_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                            الدفع عبر جوال (Jawwal Pay)
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-flex align-items-center gap-2">
                            <input type="hidden" name="payment_reflect_enabled" value="0">
                            <input type="checkbox" name="payment_reflect_enabled" class="form-check-input" value="1" {{ ($settings['payment_reflect_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                            الدفع عبر ريفلكت (Reflect)
                        </label>
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-2" id="jawwalSettings" style="display:{{ ($settings['payment_jawwal_enabled'] ?? '0') == '1' ? 'flex' : 'none' }};">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>رقم جوال للدفع</label>
                        <input type="text" name="payment_jawwal_phone" class="form-control" value="{{ old('payment_jawwal_phone', $settings['payment_jawwal_phone'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم صاحب الحساب</label>
                        <input type="text" name="payment_jawwal_holder" class="form-control" value="{{ old('payment_jawwal_holder', $settings['payment_jawwal_holder'] ?? '') }}">
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-2" id="reflectSettings" style="display:{{ ($settings['payment_reflect_enabled'] ?? '0') == '1' ? 'flex' : 'none' }};">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>رقم ريفلكت</label>
                        <input type="text" name="payment_reflect_phone" class="form-control" value="{{ old('payment_reflect_phone', $settings['payment_reflect_phone'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم صاحب الحساب</label>
                        <input type="text" name="payment_reflect_holder" class="form-control" value="{{ old('payment_reflect_holder', $settings['payment_reflect_holder'] ?? '') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Features --}}
    <div class="setting-section {{ $activeTab === 'features' ? 'active' : '' }}" id="tab-features">
        <div class="setting-card">
            <h6><i class="fas fa-toggle-on" style="color:var(--pink-600);margin-left:6px;"></i> الميزات والإعدادات العامة</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-flex align-items-center gap-2">
                            <input type="hidden" name="maintenance_mode" value="0">
                            <input type="checkbox" name="maintenance_mode" class="form-check-input" value="1" {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}>
                            وضع الصيانة
                        </label>
                        <small class="hint d-block mt-1">عند التفعيل، لن يتمكن الزوار من تصفح الموقع</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-flex align-items-center gap-2">
                            <input type="hidden" name="registration_enabled" value="0">
                            <input type="checkbox" name="registration_enabled" class="form-check-input" value="1" {{ ($settings['registration_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                            تفعيل التسجيل
                        </label>
                        <small class="hint d-block mt-1">السماح للمستخدمين الجدد بالتسجيل</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="setting-card">
            <h6><i class="fab fa-facebook" style="color:#1877F2;margin-left:6px;"></i> إعدادات التسويق والتتبع</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Google Analytics ID</label>
                        <input type="text" name="google_analytics_id" class="form-control font-monospace" value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}" dir="ltr" placeholder="G-XXXXXXXXXX">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Facebook Pixel ID</label>
                        <input type="text" name="facebook_pixel_id" class="form-control font-monospace" value="{{ old('facebook_pixel_id', $settings['facebook_pixel_id'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Facebook Access Token</label>
                        <input type="password" name="facebook_access_token" class="form-control font-monospace" value="{{ old('facebook_access_token', $settings['facebook_access_token'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="d-flex align-items-center gap-2">
                            <input type="hidden" name="facebook_pixel_enabled" value="0">
                            <input type="checkbox" name="facebook_pixel_enabled" class="form-check-input" value="1" {{ ($settings['facebook_pixel_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                            تفعيل Pixel
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="d-flex align-items-center gap-2">
                            <input type="hidden" name="facebook_capi_enabled" value="0">
                            <input type="checkbox" name="facebook_capi_enabled" class="form-check-input" value="1" {{ ($settings['facebook_capi_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                            تفعيل CAPI
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Facebook Test Event Code</label>
                        <input type="text" name="facebook_test_event_code" class="form-control font-monospace" value="{{ old('facebook_test_event_code', $settings['facebook_test_event_code'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>TikTok Pixel ID</label>
                        <input type="text" name="tiktok_pixel_id" class="form-control font-monospace" value="{{ old('tiktok_pixel_id', $settings['tiktok_pixel_id'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>TikTok Access Token</label>
                        <input type="password" name="tiktok_access_token" class="form-control font-monospace" value="{{ old('tiktok_access_token', $settings['tiktok_access_token'] ?? '') }}" dir="ltr">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="d-flex align-items-center gap-2">
                            <input type="hidden" name="tiktok_pixel_enabled" value="0">
                            <input type="checkbox" name="tiktok_pixel_enabled" class="form-check-input" value="1" {{ ($settings['tiktok_pixel_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                            تفعيل TikTok Pixel
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="setting-card">
            <h6><i class="fas fa-book-open" style="color:var(--pink-600);margin-left:6px;"></i> صفحة الدليل المرجعي (داخلي)</h6>
            <p class="text-muted small mb-3">صفحة تعليمية داخلية للخبيرات والأخصائيات تحتوي على بروتوكولات الجلسات. لا تظهر في الموقع أو محركات البحث، ولا يمكن الوصول إليها إلا عبر رابط خاص.</p>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="d-flex align-items-center gap-2">
                            <input type="hidden" name="reference_page_enabled" value="0">
                            <input type="checkbox" name="reference_page_enabled" class="form-check-input" value="1" {{ ($settings['reference_page_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                            تفعيل صفحة الدليل
                        </label>
                        <small class="hint d-block mt-1">عند التعطيل، لن يعمل الرابط حتى لو كان صحيحاً</small>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>رابط المشاركة</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-monospace" id="refLink" value="{{ url('ref/' . ($settings['reference_page_token'] ?? '')) }}" dir="ltr" readonly>
                            <button type="button" class="btn btn-outline-secondary" onclick="navigator.clipboard.writeText(document.getElementById('refLink').value); this.innerHTML='<i class=\'fas fa-check\'></i> تم'; setTimeout(()=>this.innerHTML='<i class=\'fas fa-copy\'></i> نسخ', 2000)"><i class="fas fa-copy"></i> نسخ</button>
                        </div>
                        <small class="hint d-block mt-1">شارك هذا الرابط مع الخبيرات فقط. لا تنشره على وسائل التواصل.</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>إعادة توليد الرابط</label>
                        <div class="d-flex align-items-center gap-3">
                            <label class="d-flex align-items-center gap-2">
                                <input type="hidden" name="regenerate_reference_token" value="0">
                                <input type="checkbox" name="regenerate_reference_token" class="form-check-input" value="1">
                                توليد رابط جديد عند الحفظ
                            </label>
                            <small class="hint">⚠️ سيؤدي هذا إلى إبطال الروابط القديمة</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Themes --}}
    <div class="setting-section {{ $activeTab === 'themes' ? 'active' : '' }}" id="tab-themes">
        <div class="setting-card">
            <h6><i class="fas fa-palette" style="color:var(--pink-600);margin-left:6px;"></i> إعدادات التصاميم الخمسة</h6>
            <p class="text-muted small mb-4">يمكنك تخصيص النصوص والصور لكل تصميم من التصاميم الخمسة. المستخدم يمكنه التبديل بين التصاميم بالضغط على Ctrl+1 إلى Ctrl+5</p>
            
            <div class="accordion" id="themesAccordion">
                @php
                $themeNames = [
                    1 => ['name' => 'الأناقة الذهبية', 'color' => '#B76E79', 'icon' => 'fas fa-gem'],
                    2 => ['name' => 'الفخامة الخضراء', 'color' => '#0F241D', 'icon' => 'fas fa-crown'],
                    3 => ['name' => 'النقاء العصري', 'color' => '#C88B76', 'icon' => 'fas fa-leaf'],
                    4 => ['name' => 'وادي سلامة', 'color' => '#5C715E', 'icon' => 'fas fa-tree'],
                    5 => ['name' => 'التقنية المتقدمة', 'color' => '#0055FF', 'icon' => 'fas fa-microchip'],
                ];
                @endphp
                
                @foreach($themeNames as $num => $theme)
                <div class="card mb-3" style="border: 2px solid {{ $theme['color'] }}20;">
                    <div class="card-header p-3" style="background: {{ $theme['color'] }}10; cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#theme{{ $num }}Collapse">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 40px; height: 40px; background: {{ $theme['color'] }}; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="{{ $theme['icon'] }} text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">التصميم {{ $num }}: {{ $theme['name'] }}</h6>
                                <small class="text-muted">Ctrl+{{ $num }} للتفعيل</small>
                            </div>
                            <i class="fas fa-chevron-down ms-auto"></i>
                        </div>
                    </div>
                    <div id="theme{{ $num }}Collapse" class="collapse {{ $num === 1 ? 'show' : '' }}" data-bs-parent="#themesAccordion">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>عنوان القسم الرئيسية (Hero Title)</label>
                                        <input type="text" name="theme{{ $num }}_hero_title" class="form-control" value="{{ old('theme' . $num . '_hero_title', $settings['theme' . $num . '_hero_title'] ?? '') }}" placeholder="اكتشفي جمالكِ الحقيقي">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>العنوان الفرعي (Hero Subtitle)</label>
                                        <input type="text" name="theme{{ $num }}_hero_subtitle" class="form-control" value="{{ old('theme' . $num . '_hero_subtitle', $settings['theme' . $num . '_hero_subtitle'] ?? '') }}" placeholder="خدمات عناية بالبشرة وتجميل فاخرة">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>وصف القسم الرئيسية (Hero Description)</label>
                                        <textarea name="theme{{ $num }}_hero_description" class="form-control" rows="2">{{ old('theme' . $num . '_hero_description', $settings['theme' . $num . '_hero_description'] ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>صورة الخلفية الرئيسية</label>
                                        @if(!empty($settings['theme' . $num . '_hero_image']))
                                        <div class="mb-2"><img src="{{ Storage::url($settings['theme' . $num . '_hero_image']) }}" style="width:100%;max-width:200px;height:120px;object-fit:cover;border-radius:8px;"></div>
                                        @endif
                                        <input type="file" name="theme{{ $num }}_hero_image" class="form-control" accept="image/*">
                                        <small class="hint">يفضل صورة بحجم 1920x1080</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>نص الزر الرئيسي (CTA Button)</label>
                                        <input type="text" name="theme{{ $num }}_cta_text" class="form-control" value="{{ old('theme' . $num . '_cta_text', $settings['theme' . $num . '_cta_text'] ?? '') }}" placeholder="احجزي موعدكِ الآن">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>عنوان قسم الخدمات</label>
                                        <input type="text" name="theme{{ $num }}_services_title" class="form-control" value="{{ old('theme' . $num . '_services_title', $settings['theme' . $num . '_services_title'] ?? '') }}" placeholder="خدماتنا المختارة">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>وصف قسم الخدمات</label>
                                        <textarea name="theme{{ $num }}_services_description" class="form-control" rows="2">{{ old('theme' . $num . '_services_description', $settings['theme' . $num . '_services_description'] ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="setting-card">
            <h6><i class="fas fa-info-circle" style="color:var(--pink-600);margin-left:6px;"></i> معلومات التصاميم</h6>
            <div class="alert alert-info mb-0">
                <h6 class="alert-heading"><i class="fas fa-lightbulb"></i> كيف يعمل نظام التصاميم؟</h6>
                <ul class="mb-0 small">
                    <li>الموقع يحتوي على 5 تصاميم احترافية مختلفة</li>
                    <li>يمكن للمستخدم التبديل بين التصاميم بالضغط على <strong>Ctrl+1</strong> إلى <strong>Ctrl+5</strong></li>
                    <li>كل تصميم له ألوان وخطوط وأنيميشن مختلفة</li>
                    <li>يمكنك تخصيص النصوص والصور لكل تصميم من هنا</li>
                    <li>التصميم الافتراضي هو التصميم رقم 1 (الأناقة الذهبية)</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-pink btn-lg px-5"><i class="fas fa-save"></i> حفظ الإعدادات</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.tab-link').forEach(function(tab) {
    tab.addEventListener('click', function(e) {
        e.preventDefault();
        var tabName = this.dataset.tab;
        document.querySelectorAll('.tab-link').forEach(function(t) { t.classList.remove('active'); });
        document.querySelectorAll('.setting-section').forEach(function(s) { s.classList.remove('active'); });
        this.classList.add('active');
        document.getElementById('tab-' + tabName).classList.add('active');
        document.getElementById('activeTab').value = tabName;
        var url = new URL(window.location);
        url.searchParams.set('tab', tabName);
        window.history.replaceState({}, '', url);
    });
});

document.querySelector('[name="payment_bank_enabled"]').addEventListener('change', function() {
    document.getElementById('bankSettings').style.display = this.checked ? 'flex' : 'none';
});
document.querySelector('[name="payment_jawwal_enabled"]').addEventListener('change', function() {
    document.getElementById('jawwalSettings').style.display = this.checked ? 'flex' : 'none';
});
document.querySelector('[name="payment_reflect_enabled"]').addEventListener('change', function() {
    document.getElementById('reflectSettings').style.display = this.checked ? 'flex' : 'none';
});
</script>
@endpush