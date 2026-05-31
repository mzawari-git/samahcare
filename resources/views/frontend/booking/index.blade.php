@extends($layoutPath)

@section('title', 'حجز موعد - ' . ($siteSettings['site_name'] ?? 'سماح كير'))

@push('styles')
<style>
.bp-wrap { max-width: 1100px; margin: 0 auto; padding: 2rem 1rem 4rem; }
.bp-header { text-align: center; margin-bottom: 2.5rem; padding-top: 1rem; }
.bp-header h1 { font-size: 1.75rem; font-weight: 900; color: var(--ink); margin-bottom: 0.35rem; }
.bp-header p { color: var(--ink-muted); font-size: 0.95rem; }

.step-progress { display: flex; align-items: center; justify-content: center; margin-bottom: 2rem; }
.step-item { display: flex; align-items: center; gap: 0.5rem; }
.step-circle { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.75rem; transition: all 0.3s; flex-shrink: 0; }
.step-circle.inactive { background: #f3f4f6; border: 2px solid #e5e7eb; color: #9ca3af; }
.step-circle.active { background: var(--brand-500); border: none; color: #fff; box-shadow: 0 4px 14px rgba(196,114,127,0.25); }
.step-circle.done { background: #22c55e; border: none; color: #fff; }
.step-label { font-size: 0.75rem; font-weight: 600; color: #9ca3af; white-space: nowrap; }
.step-item.active .step-label { color: var(--ink); }
.step-item.done .step-label { color: #22c55e; }
.step-connector { width: 36px; height: 2px; background: #e5e7eb; margin: 0 8px; border-radius: 2px; position: relative; overflow: hidden; }
.step-connector::after { content: ''; position: absolute; inset: 0; background: var(--brand-500); width: 0; transition: width 0.5s ease; }
.step-connector.done::after { width: 100%; }

.section-title { display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; font-weight: 800; margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(0,0,0,0.04); color: var(--ink); }
.section-title i { width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; border-radius: 8px; background: var(--brand-50); color: var(--brand-500); font-size: 0.7rem; }

.bp-card { background: #fff; border-radius: 1.25rem; padding: 1.5rem 1.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.04); transition: box-shadow 0.3s; }
.bp-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }

.service-pill { border: 2px solid #e5e7eb; border-radius: 16px; padding: 1rem 0.5rem 0.85rem; text-align: center; cursor: pointer; transition: all 0.25s; user-select: none; background: #fff; position: relative; }
.service-pill:hover { border-color: var(--brand-400); background: var(--brand-50); transform: translateY(-2px); }
.service-pill.selected { border-color: var(--brand-500); background: var(--brand-50); box-shadow: 0 0 0 3px rgba(196,114,127,0.1); }
.service-pill .pill-icon { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem; font-size: 1rem; transition: transform 0.3s; }
.service-pill:hover .pill-icon { transform: scale(1.08); }
.service-pill .pill-name { font-weight: 700; font-size: 0.8rem; color: #4b5563; margin-bottom: 0.2rem; line-height: 1.3; }
.service-pill.selected .pill-name { color: var(--ink); font-weight: 800; }
.service-pill .pill-price { font-weight: 800; font-size: 0.95rem; color: var(--brand-500); }
.service-pill .pill-old-price { text-decoration: line-through; color: #9ca3af; font-size: 0.65rem; font-weight: 500; }
.service-pill .pill-duration { display: inline-flex; align-items: center; gap: 0.2rem; font-size: 0.6rem; font-weight: 600; padding: 0.15rem 0.5rem; border-radius: 999px; background: #f3f4f6; color: #6b7280; margin-top: 0.2rem; }
.service-pill .check-icon { position: absolute; top: 6px; right: 6px; width: 18px; height: 18px; border-radius: 50%; border: 2px solid #e5e7eb; display: flex; align-items: center; justify-content: center; transition: all 0.3s; font-size: 0.45rem; background: #fff; color: transparent; }
.service-pill.selected .check-icon { border-color: var(--brand-500); background: var(--brand-500); color: #fff; }

.form-label { display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 0.35rem; color: var(--ink); }
.input-wrap { position: relative; }
.input-wrap .input-icon { position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.8rem; pointer-events: none; transition: color 0.3s; z-index: 2; }
.input-wrap:focus-within .input-icon { color: var(--brand-500); }
.form-input { width: 100%; background: var(--surface-alt); border: 2px solid #e5e7eb; border-radius: 12px; padding: 0.75rem 2.6rem 0.75rem 1rem; color: var(--ink); font-size: 0.92rem; transition: all 0.25s; }
.form-input:focus { outline: none; border-color: var(--brand-500); background: #fff; box-shadow: 0 0 0 4px rgba(196,114,127,0.08); }
.form-input::placeholder { color: #9ca3af; }
select.form-input { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23666' d='M1.41 0L6 4.58 10.59 0 12 1.41l-6 6-6-6z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: left 1rem center; padding-left: 2.5rem; padding-right: 1rem; }
textarea.form-input { min-height: 76px; resize: vertical; padding-top: 0.75rem; }

.payment-option { background: var(--surface-alt); border: 2px solid #e5e7eb; border-radius: 14px; padding: 0.85rem 1rem; cursor: pointer; transition: all 0.25s; }
.payment-option:hover { border-color: var(--brand-400); background: var(--brand-50); }
.payment-option.selected { border-color: var(--brand-500); background: var(--brand-50); box-shadow: 0 0 0 3px rgba(196,114,127,0.08); }
.payment-option .radio-dot { width: 18px; height: 18px; border-radius: 50%; border: 2px solid #d1d5db; display: flex; align-items: center; justify-content: center; transition: all 0.3s; flex-shrink: 0; }
.payment-option.selected .radio-dot { border-color: var(--brand-500); }
.payment-option .radio-dot::after { content: ''; width: 8px; height: 8px; border-radius: 50%; background: var(--brand-500); transform: scale(0); transition: transform 0.3s; }
.payment-option.selected .radio-dot::after { transform: scale(1); }

.coupon-row { display: flex; gap: 0.5rem; }
.coupon-row .form-input { padding-right: 1rem; }
.coupon-btn { padding: 0 1.25rem; font-weight: 700; font-size: 0.82rem; border: none; border-radius: 12px; background: var(--brand-500); color: #fff; transition: all 0.25s; white-space: nowrap; }
.coupon-btn:hover { opacity: 0.9; }
.coupon-btn.loading { opacity: 0.7; pointer-events: none; }
.coupon-msg { font-size: 0.8rem; font-weight: 500; margin-top: 0.35rem; display: flex; align-items: center; gap: 0.3rem; }
.coupon-msg.success { color: #22c55e; }
.coupon-msg.error { color: #ef4444; }

.bp-summary { background: #fff; border-radius: 1.25rem; padding: 1.5rem; position: sticky; top: 100px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.04); }
.bp-summary .summary-head { display: flex; align-items: center; gap: 0.5rem; padding-bottom: 0.75rem; margin-bottom: 0.75rem; border-bottom: 1px solid rgba(0,0,0,0.04); }
.bp-summary .summary-head i { color: var(--brand-500); font-size: 1rem; }
.bp-summary .summary-head h5 { font-weight: 800; margin-bottom: 0; color: var(--ink); font-size: 0.95rem; }
.summary-empty { text-align: center; padding: 1.5rem 0; color: #9ca3af; }
.summary-empty i { font-size: 2rem; opacity: 0.12; display: block; margin-bottom: 0.5rem; }
.summary-empty small { font-size: 0.8rem; }
.summary-line { display: flex; justify-content: space-between; align-items: center; padding: 0.45rem 0; }
.summary-line + .summary-line { border-top: 1px solid rgba(0,0,0,0.04); }
.summary-line .label { color: #6b7280; font-size: 0.85rem; }
.summary-line .value { font-weight: 700; color: var(--ink); }
.summary-total { display: flex; justify-content: space-between; align-items: center; padding-top: 0.65rem; margin-top: 0.65rem; border-top: 2px solid var(--brand-50); }
.summary-total .label { font-weight: 800; color: var(--ink); font-size: 0.9rem; }
.summary-total .value { font-weight: 900; color: var(--brand-500); font-size: 1.25rem; }

.submit-btn { width: 100%; padding: 0.85rem; font-weight: 800; font-size: 1rem; border: none; border-radius: 9999px; background: var(--gradient-primary); color: #fff; transition: all 0.3s; }
.submit-btn:hover { opacity: 0.9; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(196,114,127,0.2); }
.submit-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
.submit-btn.loading { pointer-events: none; }
.submit-btn .spinner { display: none; width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; margin: 0 auto; }
.submit-btn.loading .spinner { display: block; }
.submit-btn.loading .btn-text { display: none; }
@keyframes spin { to { transform: rotate(360deg); } }

@keyframes fadeInUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
.fade-in-up { animation: fadeInUp 0.45s ease both; }
.delay-1 { animation-delay: 0.05s; } .delay-2 { animation-delay: 0.10s; } .delay-3 { animation-delay: 0.15s; } .delay-4 { animation-delay: 0.20s; } .delay-5 { animation-delay: 0.25s; }

@media (max-width: 576px) {
  .step-label { display: none; } .step-connector { width: 20px; }
  .bp-card, .bp-summary { padding: 1.2rem; } .bp-summary { position: static; }
  .service-pill { padding: 0.8rem 0.4rem; } .bp-header h1 { font-size: 1.4rem; }
}
</style>
@endpush

@section('content')
<div class="bp-wrap">
    <div class="bp-header fade-in-up">
        <h1>اختاري <span class="gradient-text">خدمتك</span> المفضلة</h1>
        <p>اختاري الخدمة المناسبة واحجزي موعدك بسهولة</p>
    </div>

    <div class="step-progress fade-in-up delay-1">
        <div class="step-item" id="step1Indicator"><div class="step-circle active">1</div><span class="step-label">الخدمة</span></div>
        <div class="step-connector" id="stepConnector1"></div>
        <div class="step-item" id="step2Indicator"><div class="step-circle inactive">2</div><span class="step-label">المعلومات</span></div>
        <div class="step-connector" id="stepConnector2"></div>
        <div class="step-item" id="step3Indicator"><div class="step-circle inactive">3</div><span class="step-label">التأكيد</span></div>
    </div>

    @php
    $serviceMeta = [
        1 => ['icon' => 'fas fa-hand-holding-heart', 'color' => '#f472b6'],
        2 => ['icon' => 'fas fa-sparkles', 'color' => '#a78bfa'],
        3 => ['icon' => 'fas fa-bath', 'color' => '#34d399'],
        4 => ['icon' => 'fas fa-hand-sparkles', 'color' => '#fbbf24'],
        5 => ['icon' => 'fas fa-fire', 'color' => '#f87171'],
        6 => ['icon' => 'fas fa-leaf', 'color' => '#60a5fa'],
    ];
    @endphp

    <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
        @csrf
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="bp-card mb-4 fade-in-up delay-1" id="step1Section">
                    <div class="section-title"><i class="fas fa-spa"></i> اختاري الخدمة <span style="color:var(--brand-500);">*</span></div>
                    <div class="row g-2" id="servicesContainer">
                        @foreach($services as $service)
                        @php $meta = $serviceMeta[$service->id] ?? ['icon' => 'fas fa-spa', 'color' => 'var(--brand-500)']; @endphp
                        <div class="col-6 col-md-4">
                            <div class="service-pill {{ old('service_id') == $service->id ? 'selected' : '' }}" data-service-id="{{ $service->id }}" data-price="{{ $service->final_price }}" data-name="{{ $service->name_ar }}" onclick="selectService(this)">
                                <div class="check-icon"><i class="fas fa-check"></i></div>
                                <div class="pill-icon" style="background:{{ $meta['color'] }}12;color:{{ $meta['color'] }};"><i class="{{ $meta['icon'] }}"></i></div>
                                <div class="pill-name">{{ $service->name_ar }}</div>
                                <div class="pill-price">
                                    @if($service->is_on_sale)<div class="pill-old-price">{{ number_format($service->price) }} ₪</div>{{ number_format($service->discount_price) }} ₪@else{{ number_format($service->price) }} ₪@endif
                                </div>
                                @if($service->duration)<div class="pill-duration"><i class="far fa-clock" style="font-size:0.5rem;"></i> {{ $service->duration }} د</div>@endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="service_id" id="selectedServiceId" value="{{ old('service_id') }}">
                    @error('service_id') <small class="text-danger d-block mt-2">{{ $message }}</small> @enderror
                </div>

                <div class="bp-card mb-4 fade-in-up delay-2" id="step2Section">
                    <div class="section-title"><i class="fas fa-user"></i> معلوماتك</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">الاسم الكامل <span style="color:var(--brand-500);">*</span></label>
                            <div class="input-wrap"><i class="far fa-user input-icon"></i><input type="text" name="customer_name" class="form-input" required placeholder="نورة أحمد" value="{{ old('customer_name') }}"></div>
                            @error('customer_name') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم الهاتف <span style="color:var(--brand-500);">*</span></label>
                            <div class="input-wrap"><i class="fas fa-phone input-icon"></i><input type="tel" name="customer_phone" class="form-input" required placeholder="0523843781" value="{{ old('customer_phone') }}" dir="ltr"></div>
                            @error('customer_phone') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني <span style="color:#9ca3af;font-size:0.65rem;font-weight:400;">(اختياري)</span></label>
                            <div class="input-wrap"><i class="far fa-envelope input-icon"></i><input type="email" name="customer_email" class="form-input" placeholder="example@email.com" value="{{ old('customer_email') }}" dir="ltr"></div>
                        </div>
                    </div>
                </div>

                <div class="bp-card mb-4 fade-in-up delay-3" id="step3Section">
                    <div class="section-title"><i class="fas fa-calendar"></i> الموعد</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">التاريخ <span style="color:var(--brand-500);">*</span></label>
                            <div class="input-wrap"><i class="far fa-calendar input-icon"></i><input type="date" name="booking_date" class="form-input" required min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}"></div>
                            @error('booking_date') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الوقت <span style="color:var(--brand-500);">*</span></label>
                            <div class="input-wrap"><i class="far fa-clock input-icon"></i>
                                <select name="booking_time" class="form-input" required>
                                    <option value="">اختاري الوقت</option>
                                    @php $times = ['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00']; @endphp
                                    @foreach($times as $time)<option value="{{ $time }}" {{ old('booking_time') == $time ? 'selected' : '' }}>{{ \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}</option>@endforeach
                                </select>
                            </div>
                            @error('booking_time') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="bp-card mb-4 fade-in-up delay-4">
                    <div class="section-title"><i class="fas fa-tag"></i> كود الخصم والملاحظات</div>
                    <div class="mb-3">
                        <label class="form-label">كود الخصم</label>
                        <div class="coupon-row">
                            <input type="text" name="coupon_code" class="form-input" placeholder="أدخلي الكود" value="{{ old('coupon_code') }}" id="couponInput" style="max-width:200px;">
                            <button type="button" onclick="applyCoupon()" class="coupon-btn" id="couponBtn">تطبيق</button>
                        </div>
                        <div id="couponMsg" class="coupon-msg"></div>
                    </div>
                    <div>
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-input" rows="2" placeholder="أي استفسار أو ملاحظة ...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="bp-card mb-4 fade-in-up delay-5">
                    <div class="section-title"><i class="fas fa-credit-card"></i> طريقة الدفع</div>
                    <div class="row g-2" id="paymentMethods">
                        @foreach($paymentMethods as $method)
                        <div class="col-sm-6">
                            <div class="payment-option {{ old('payment_method') == $method['id'] ? 'selected' : '' }}" onclick="selectPayment('{{ $method['id'] }}')">
                                <div class="d-flex gap-2 align-items-start">
                                    <div class="radio-dot"></div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i class="fas {{ $method['icon'] }}" style="color:{{ $method['color'] }};font-size:1rem;"></i>
                                            <span class="fw-bold" style="color:var(--ink);font-size:0.85rem;">{{ $method['name'] }}</span>
                                        </div>
                                        <small class="d-block" style="color:#6b7280;font-size:0.72rem;">{{ $method['description'] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="payment_method" id="selectedPayment" value="{{ old('payment_method') }}">
                </div>
            </div>

            <div class="col-lg-5">
                <div class="bp-summary fade-in-up delay-3">
                    <div class="summary-head"><i class="fas fa-receipt"></i><h5>ملخص الحجز</h5></div>
                    <div id="summaryContent"><div class="summary-empty"><i class="fas fa-spa"></i><small>اختاري خدمة لعرض الملخص</small></div></div>
                    <div id="totalLine" style="display:none;">
                        <div class="summary-total"><span class="label">الإجمالي</span><span class="value" id="totalDisplay">0 ₪</span></div>
                        <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
                    </div>
                    <button type="submit" class="submit-btn mt-3" id="submitBtn">
                        <span class="btn-text"><i class="far fa-circle-check ml-2"></i> تأكيد الحجز</span>
                        <div class="spinner"></div>
                    </button>
                    <p class="text-center mt-3 mb-0" style="color:#6b7280;font-size:0.75rem;">
                        <i class="far fa-clock ml-1"></i> سنقوم بالتواصل معك لتأكيد الموعد خلال 24 ساعة
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let selectedServiceId = {{ old('service_id') ?: 'null' }};
let selectedServicePrice = 0;
let selectedServiceName = '';
let couponDiscount = 0;

function selectService(el) {
    document.querySelectorAll('.service-pill').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedServiceId = parseInt(el.dataset.serviceId);
    selectedServicePrice = parseFloat(el.dataset.price);
    selectedServiceName = el.dataset.name;
    document.getElementById('selectedServiceId').value = selectedServiceId;
    updateStepProgress(1);
    updateSummary();
}

function updateStepProgress(step) {
    [1, 2, 3].forEach(i => {
        const indicator = document.getElementById('step' + i + 'Indicator');
        const circle = indicator.querySelector('.step-circle');
        const connector = i < 3 ? document.getElementById('stepConnector' + i) : null;
        indicator.classList.remove('active', 'done');
        circle.classList.remove('active', 'done', 'inactive');
        if (connector) connector.classList.remove('done');
        if (i < step) { indicator.classList.add('done'); circle.classList.add('done'); if (connector) connector.classList.add('done'); }
        else if (i === step) { indicator.classList.add('active'); circle.classList.add('active'); }
        else { circle.classList.add('inactive'); }
    });
}

function updateSummary() {
    const total = Math.max(0, selectedServicePrice - couponDiscount);
    const summary = document.getElementById('summaryContent');
    const totalLine = document.getElementById('totalLine');
    if (selectedServiceId) {
        summary.innerHTML = `<div class="summary-line"><span class="label">الخدمة</span><span class="value">${selectedServiceName}</span></div><div class="summary-line"><span class="label">سعر الخدمة</span><span class="value" style="color:var(--brand-500);">${selectedServicePrice.toFixed(0)} ₪</span></div>${couponDiscount > 0 ? `<div class="summary-line"><span class="label" style="color:#22c55e;"><i class="fas fa-tag ml-1"></i> خصم</span><span class="value" style="color:#22c55e;">-${couponDiscount.toFixed(0)} ₪</span></div>` : ''}`;
        totalLine.style.display = 'block';
        document.getElementById('totalDisplay').textContent = total.toFixed(0) + ' ₪';
        document.getElementById('totalAmountInput').value = total;
    } else {
        summary.innerHTML = `<div class="summary-empty"><i class="fas fa-spa"></i><small>اختاري خدمة لعرض الملخص</small></div>`;
        totalLine.style.display = 'none';
    }
}

function selectPayment(id) {
    document.querySelectorAll('.payment-option').forEach(p => p.classList.remove('selected'));
    document.querySelectorAll('.payment-option').forEach(p => { if (p.getAttribute('onclick')?.includes(`'${id}'`)) p.classList.add('selected'); });
    document.getElementById('selectedPayment').value = id;
}

function applyCoupon() {
    const code = document.getElementById('couponInput').value.trim();
    const msg = document.getElementById('couponMsg');
    const btn = document.getElementById('couponBtn');
    if (!code) { msg.className = 'coupon-msg error'; msg.innerHTML = '<i class="fas fa-circle-exclamation"></i> الرجاء إدخال كود الخصم'; return; }
    btn.classList.add('loading'); btn.textContent = '...';
    msg.className = 'coupon-msg'; msg.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التحقق...';
    fetch('{{ route("booking.coupon") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }, body: JSON.stringify({ code: code, amount: selectedServicePrice || 0 }) })
    .then(r => r.json()).then(data => {
        btn.classList.remove('loading'); btn.textContent = 'تطبيق';
        if (data.success) { couponDiscount = data.discount || 0; msg.className = 'coupon-msg success'; msg.innerHTML = '<i class="fas fa-check-circle"></i> ' + (data.message || 'تم تطبيق الخصم'); }
        else { couponDiscount = 0; msg.className = 'coupon-msg error'; msg.innerHTML = '<i class="fas fa-circle-exclamation"></i> ' + (data.message || 'كود خصم غير صالح'); }
        updateSummary();
    }).catch(() => { btn.classList.remove('loading'); btn.textContent = 'تطبيق'; couponDiscount = 0; msg.className = 'coupon-msg error'; msg.innerHTML = '<i class="fas fa-circle-exclamation"></i> خطأ في الاتصال'; updateSummary(); });
}

document.getElementById('bookingForm').addEventListener('submit', function(e) { const btn = document.getElementById('submitBtn'); btn.classList.add('loading'); btn.disabled = true; });

@if(old('service_id'))
document.addEventListener('DOMContentLoaded', function() { const el = document.querySelector(`.service-pill[data-service-id="{{ old('service_id') }}"]`); if (el) { selectService(el); updateStepProgress(2); } });
@endif
</script>
@endsection
