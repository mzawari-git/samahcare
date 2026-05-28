@extends('admin.layouts.app')

@section('title', 'التسويق والتتبع')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 mb-1"><i class="fas fa-chart-line" style="color:var(--pink-600);margin-left:8px;"></i> إعدادات التتبع والإعلانات</h1>
        <p class="text-muted small mb-0">إدارة Facebook Pixel، TikTok Pixel، وتتبع التحويلات</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#1877F2;color:#fff;"><i class="fab fa-facebook"></i></div>
            <div>
                <div class="stat-value"><span class="badge bg-{{ $settings['facebook']['enabled'] ? 'success' : 'secondary' }} rounded-pill" id="fb-status">{{ $settings['facebook']['enabled'] ? 'مفعل' : 'معطل' }}</span></div>
                <div class="stat-label">Facebook Pixel</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#000;color:#fff;"><i class="fab fa-tiktok"></i></div>
            <div>
                <div class="stat-value"><span class="badge bg-{{ $settings['tiktok']['enabled'] ? 'success' : 'secondary' }} rounded-pill">{{ $settings['tiktok']['enabled'] ? 'مفعل' : 'معطل' }}</span></div>
                <div class="stat-label">TikTok Pixel</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:var(--pink-50);color:var(--pink-600);"><i class="fas fa-server"></i></div>
            <div>
                <div class="stat-value"><span class="badge bg-{{ $settings['facebook']['capi_enabled'] ? 'success' : 'secondary' }} rounded-pill">{{ $settings['facebook']['capi_enabled'] ? 'مفعل' : 'معطل' }}</span></div>
                <div class="stat-label">Facebook CAPI</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:var(--gray-100);color:var(--gray-700);"><i class="fas fa-exchange-alt"></i></div>
            <div>
                <div class="stat-value"><span class="badge bg-{{ $settings['tiktok']['capi_enabled'] ? 'success' : 'secondary' }} rounded-pill">{{ $settings['tiktok']['capi_enabled'] ? 'مفعل' : 'معطل' }}</span></div>
                <div class="stat-label">TikTok Events API</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4" id="marketing-app">
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header" style="background:linear-gradient(135deg,#1877F2,#0D6EFD);color:#fff;"><i class="fab fa-facebook"></i> Facebook Pixel & CAPI</div>
            <div class="card-body">
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="fb_pixel_enabled" {{ $settings['facebook']['enabled'] ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="fb_pixel_enabled">تفعيل Facebook Pixel</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Facebook Pixel ID</label>
                    <input type="text" class="form-control" id="fb_pixel_id" value="{{ $settings['facebook']['pixel_id'] }}" placeholder="1234567890123456" style="font-family:monospace;">
                </div>
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="fb_capi_enabled" {{ $settings['facebook']['capi_enabled'] ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="fb_capi_enabled">تفعيل Facebook Conversions API (Server-Side)</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Facebook Access Token</label>
                    <input type="password" class="form-control" id="fb_access_token" value="{{ $settings['facebook']['access_token'] }}" placeholder="EAAxxxxxxxxxxxxx" style="font-family:monospace;">
                </div>
                <div class="mb-3">
                    <label class="form-label">Test Event Code (اختياري)</label>
                    <input type="text" class="form-control" id="fb_test_code" value="{{ $settings['facebook']['test_event_code'] ?? '' }}" placeholder="TEST12345">
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-pink" onclick="saveFacebook()"><i class="fas fa-save"></i> حفظ</button>
                    <button class="btn btn-outline-pink btn-sm" onclick="testFacebook()"><i class="fas fa-plug"></i> اختبار الاتصال</button>
                </div>
                <div id="fb-alert" class="mt-2"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header" style="background:#000;color:#fff;"><i class="fab fa-tiktok"></i> TikTok Pixel & Events API</div>
            <div class="card-body">
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="tt_pixel_enabled" {{ $settings['tiktok']['enabled'] ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="tt_pixel_enabled">تفعيل TikTok Pixel</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">TikTok Pixel ID</label>
                    <input type="text" class="form-control" id="tt_pixel_id" value="{{ $settings['tiktok']['pixel_id'] }}" placeholder="XXXXXXXXXX" style="font-family:monospace;">
                </div>
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="tt_capi_enabled" {{ $settings['tiktok']['capi_enabled'] ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="tt_capi_enabled">تفعيل TikTok Events API (Server-Side)</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">TikTok Access Token</label>
                    <input type="password" class="form-control" id="tt_access_token" value="{{ $settings['tiktok']['access_token'] }}" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" style="font-family:monospace;">
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-dark" onclick="saveTikTok()"><i class="fas fa-save"></i> حفظ</button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="testTikTok()"><i class="fas fa-plug"></i> اختبار الاتصال</button>
                </div>
                <div id="tt-alert" class="mt-2"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-cog" style="color:var(--pink-600);margin-left:6px;"></i> الإعدادات العامة</div>
            <div class="card-body">
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="tracking_enabled" {{ $settings['test_mode'] ? '' : 'checked' }}>
                    <label class="form-check-label fw-bold" for="tracking_enabled">تفعيل نظام التتبع بالكامل</label>
                </div>
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="test_mode" {{ $settings['test_mode'] ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="test_mode">وضع الاختبار (Test Mode)</label>
                </div>
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="async_mode" checked>
                    <label class="form-check-label fw-bold" for="async_mode">استخدام Queue (إرسال في الخلفية)</label>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-pink btn-sm" onclick="saveGeneral()"><i class="fas fa-save"></i> حفظ</button>
                </div>
                <div id="gen-alert" class="mt-2"></div>
            </div>
        </div>
    </div>

</div>

<script>
const BASE = '{{ url('/') }}';

function alertBox(id, msg, type) {
    const el = document.getElementById(id);
    el.innerHTML = `<div class="alert alert-${type} py-2 px-3 mb-0 rounded-3 small">${msg}</div>`;
    setTimeout(() => el.innerHTML = '', 3000);
}

function saveFacebook() {
    const data = {
        facebook_pixel_enabled: document.getElementById('fb_pixel_enabled').checked ? 1 : 0,
        facebook_pixel_id: document.getElementById('fb_pixel_id').value,
        facebook_capi_enabled: document.getElementById('fb_capi_enabled').checked ? 1 : 0,
        facebook_access_token: document.getElementById('fb_access_token').value,
        facebook_test_event_code: document.getElementById('fb_test_code').value,
    };
    fetch(BASE + '/admin/marketing/facebook', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]')?.content||''},
        body: JSON.stringify(data)
    }).then(r => r.json()).then(d => {
        alertBox('fb-alert', d.message||'تم الحفظ', 'success');
        location.reload();
    }).catch(() => alertBox('fb-alert', 'فشل الحفظ', 'danger'));
}

function saveTikTok() {
    const data = {
        tiktok_pixel_enabled: document.getElementById('tt_pixel_enabled').checked ? 1 : 0,
        tiktok_pixel_id: document.getElementById('tt_pixel_id').value,
        tiktok_capi_enabled: document.getElementById('tt_capi_enabled').checked ? 1 : 0,
        tiktok_access_token: document.getElementById('tt_access_token').value,
    };
    fetch(BASE + '/admin/marketing/tiktok', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]')?.content||''},
        body: JSON.stringify(data)
    }).then(r => r.json()).then(d => {
        alertBox('tt-alert', d.message||'تم الحفظ', 'success');
        location.reload();
    }).catch(() => alertBox('tt-alert', 'فشل الحفظ', 'danger'));
}

function saveGeneral() {
    const data = {
        tracking_enabled: document.getElementById('tracking_enabled').checked ? 1 : 0,
        tracking_test_mode: document.getElementById('test_mode').checked ? 1 : 0,
        tracking_async_mode: document.getElementById('async_mode').checked ? 1 : 0,
    };
    fetch(BASE + '/admin/marketing/general', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]')?.content||''},
        body: JSON.stringify(data)
    }).then(r => r.json()).then(d => alertBox('gen-alert', d.message||'تم الحفظ', 'success')).catch(() => alertBox('gen-alert', 'فشل الحفظ', 'danger'));
}

function testFacebook() {
    fetch(BASE + '/admin/marketing/test-facebook').then(r=>r.json()).then(d=>alert(d.message||'OK')).catch(()=>alert('فشل الاتصال'));
}
function testTikTok() {
    fetch(BASE + '/admin/marketing/test-tiktok').then(r=>r.json()).then(d=>alert(d.message||'OK')).catch(()=>alert('فشل الاتصال'));
}
</script>
@endsection
