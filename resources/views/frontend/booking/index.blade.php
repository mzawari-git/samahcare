@extends($layoutPath)

@section('title', 'حجز موعد - ' . ($siteSettings['site_name'] ?? 'سماح كير'))

@push('styles')
<style>
/* ── Wizard Layout ── */
.bp-wrap { max-width: 1200px; margin: 0 auto; padding: 2rem 1rem 4rem; }

/* Header */
.bp-header { text-align: center; margin-bottom: 2rem; padding-top: 1rem; }
.bp-header h1 { font-size: 1.85rem; font-weight: 900; color: var(--ink); margin-bottom: 0.35rem; }
.bp-header p { color: var(--ink-muted); font-size: 0.95rem; }

/* ── Step Progress ── */
.step-progress { display: flex; align-items: center; justify-content: center; margin-bottom: 2.5rem; gap: 0; }
.step-item { display: flex; align-items: center; gap: 0.5rem; }
.step-circle { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); flex-shrink: 0; position: relative; }
.step-circle.inactive { background: #f3f4f6; border: 2px solid #e5e7eb; color: #9ca3af; }
.step-circle.active { background: var(--brand-500); border: 2px solid var(--brand-500); color: #fff; box-shadow: 0 4px 14px rgba(0,85,255,0.3); transform: scale(1.08); }
.step-circle.done { background: #22c55e; border: 2px solid #22c55e; color: #fff; }
.step-circle .step-check { display: none; }
.step-circle.done .step-check { display: inline; }
.step-circle.done .step-num { display: none; }
.step-label { font-size: 0.75rem; font-weight: 600; color: #9ca3af; white-space: nowrap; transition: color 0.3s; }
.step-item.active .step-label { color: var(--ink); font-weight: 800; }
.step-item.done .step-label { color: #22c55e; }
.step-connector { width: 48px; height: 3px; background: #e5e7eb; margin: 0 10px; border-radius: 4px; position: relative; overflow: hidden; }
.step-connector::after { content: ''; position: absolute; inset: 0; background: var(--gradient-primary, var(--brand-500)); width: 0; transition: width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); }
.step-connector.done::after { width: 100%; }

/* ── Wizard Steps (hide/show) ── */
.wizard-step { display: none; animation: stepFadeIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) both; }
.wizard-step.active { display: block; }

@keyframes stepFadeIn {
  from { opacity: 0; transform: translateX(30px); }
  to { opacity: 1; transform: translateX(0); }
}

/* ── Section Title ── */
.section-title { display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; font-weight: 800; margin-bottom: 1.25rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(0,0,0,0.04); color: var(--ink); }
.section-title i { width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 8px; background: var(--brand-50); color: var(--brand-500); font-size: 0.75rem; }

/* ── Cards ── */
.bp-card { background: #fff; border-radius: 1.25rem; padding: 1.5rem 1.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.04); transition: box-shadow 0.3s; }
.bp-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }

/* ── Category Tabs ── */
.cat-tabs { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
.cat-tab { padding: 0.6rem 1.25rem; border-radius: 999px; font-weight: 700; font-size: 0.82rem; cursor: pointer; transition: all 0.3s; border: 2px solid #e5e7eb; background: #fff; color: #6b7280; user-select: none; display: flex; align-items: center; gap: 0.4rem; }
.cat-tab:hover { border-color: var(--brand-400); color: var(--brand-500); background: var(--brand-50); }
.cat-tab.active { border-color: var(--brand-500); background: var(--brand-500); color: #fff; box-shadow: 0 4px 14px rgba(0,85,255,0.2); }
.cat-tab .cat-count { background: rgba(0,0,0,0.08); padding: 0.1rem 0.45rem; border-radius: 999px; font-size: 0.65rem; font-weight: 800; }
.cat-tab.active .cat-count { background: rgba(255,255,255,0.25); }
.cat-section { display: none; }
.cat-section.active { display: block; animation: fadeInUp 0.4s ease both; }

/* ── Service Grid (3 per row) ── */
.service-card { border: 2px solid #e5e7eb; border-radius: 16px; padding: 1rem 0.75rem 0.85rem; text-align: center; cursor: pointer; transition: all 0.25s; user-select: none; background: #fff; position: relative; height: 100%; }
.service-card:hover { border-color: var(--brand-400); background: var(--brand-50); transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
.service-card.selected { border-color: var(--brand-500); background: var(--brand-50); box-shadow: 0 0 0 3px rgba(0,85,255,0.12), 0 8px 20px rgba(0,85,255,0.08); }
.service-card .card-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.6rem; font-size: 1.15rem; transition: transform 0.3s; }
.service-card:hover .card-icon { transform: scale(1.1); }
.service-card .card-name { font-weight: 700; font-size: 0.8rem; color: #4b5563; margin-bottom: 0.3rem; line-height: 1.35; min-height: 2.2em; }
.service-card.selected .card-name { color: var(--ink); font-weight: 800; }
.service-card .card-price { font-weight: 800; font-size: 0.95rem; color: var(--brand-500); }
.service-card .card-old-price { text-decoration: line-through; color: #9ca3af; font-size: 0.65rem; font-weight: 500; }
.service-card .card-duration { display: inline-flex; align-items: center; gap: 0.2rem; font-size: 0.6rem; font-weight: 600; padding: 0.15rem 0.5rem; border-radius: 999px; background: #f3f4f6; color: #6b7280; margin-top: 0.3rem; }
.service-card .card-badge { position: absolute; top: -6px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #f59e0b, #ef4444); color: #fff; font-size: 0.55rem; font-weight: 800; padding: 0.15rem 0.6rem; border-radius: 999px; white-space: nowrap; }
.service-card .card-check { position: absolute; top: 8px; right: 8px; width: 20px; height: 20px; border-radius: 50%; border: 2px solid #e5e7eb; display: flex; align-items: center; justify-content: center; transition: all 0.3s; font-size: 0.5rem; background: #fff; color: transparent; }
.service-card.selected .card-check { border-color: var(--brand-500); background: var(--brand-500); color: #fff; transform: scale(1.1); }
.service-card .card-desc { font-size: 0.62rem; color: #9ca3af; line-height: 1.4; margin-top: 0.35rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

/* ── Sessions Toggle ── */
.sessions-toggle { display: flex; align-items: center; justify-content: center; gap: 0.75rem; margin-top: 1.5rem; padding: 1rem 1.5rem; background: var(--brand-50); border-radius: 16px; border: 2px solid rgba(0,85,255,0.1); }
.sessions-label { font-weight: 700; font-size: 0.85rem; color: var(--ink); }
.sessions-btns { display: flex; gap: 0.4rem; }
.sess-btn { width: 40px; height: 40px; border-radius: 10px; border: 2px solid #e5e7eb; background: #fff; font-weight: 800; font-size: 0.85rem; cursor: pointer; transition: all 0.25s; display: flex; align-items: center; justify-content: center; color: #6b7280; }
.sess-btn:hover { border-color: var(--brand-400); color: var(--brand-500); background: var(--brand-50); }
.sess-btn.active { border-color: var(--brand-500); background: var(--brand-500); color: #fff; box-shadow: 0 4px 12px rgba(0,85,255,0.25); transform: scale(1.05); }

/* ── Form ── */
.form-label { display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 0.35rem; color: var(--ink); }
.input-wrap { position: relative; }
.input-wrap .input-icon { position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.8rem; pointer-events: none; transition: color 0.3s; z-index: 2; }
.input-wrap:focus-within .input-icon { color: var(--brand-500); }
.form-input { width: 100%; background: var(--surface-alt); border: 2px solid #e5e7eb; border-radius: 12px; padding: 0.75rem 2.6rem 0.75rem 1rem; color: var(--ink); font-size: 0.92rem; transition: all 0.25s; }
.form-input:focus { outline: none; border-color: var(--brand-500); background: #fff; box-shadow: 0 0 0 4px rgba(0,85,255,0.08); }
.form-input::placeholder { color: #9ca3af; }
select.form-input { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23666' d='M1.41 0L6 4.58 10.59 0 12 1.41l-6 6-6-6z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: left 1rem center; padding-left: 2.5rem; padding-right: 1rem; }
textarea.form-input { min-height: 76px; resize: vertical; padding-top: 0.75rem; }

/* ── Payment Options ── */
.payment-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.75rem; }
.payment-option { background: var(--surface-alt); border: 2px solid #e5e7eb; border-radius: 14px; padding: 0.85rem 1rem; cursor: pointer; transition: all 0.25s; }
.payment-option:hover { border-color: var(--brand-400); background: var(--brand-50); transform: translateY(-2px); }
.payment-option.selected { border-color: var(--brand-500); background: var(--brand-50); box-shadow: 0 0 0 3px rgba(0,85,255,0.08); }
.payment-option .radio-dot { width: 18px; height: 18px; border-radius: 50%; border: 2px solid #d1d5db; display: flex; align-items: center; justify-content: center; transition: all 0.3s; flex-shrink: 0; }
.payment-option.selected .radio-dot { border-color: var(--brand-500); }
.payment-option .radio-dot::after { content: ''; width: 8px; height: 8px; border-radius: 50%; background: var(--brand-500); transform: scale(0); transition: transform 0.3s; }
.payment-option.selected .radio-dot::after { transform: scale(1); }

/* ── Coupon ── */
.coupon-row { display: flex; gap: 0.5rem; }
.coupon-row .form-input { padding-right: 1rem; }
.coupon-btn { padding: 0 1.25rem; font-weight: 700; font-size: 0.82rem; border: none; border-radius: 12px; background: var(--brand-500); color: #fff; transition: all 0.25s; white-space: nowrap; cursor: pointer; }
.coupon-btn:hover { opacity: 0.9; }
.coupon-btn.loading { opacity: 0.7; pointer-events: none; }
.coupon-msg { font-size: 0.8rem; font-weight: 500; margin-top: 0.35rem; display: flex; align-items: center; gap: 0.3rem; }
.coupon-msg.success { color: #22c55e; }
.coupon-msg.error { color: #ef4444; }

/* ── Summary ── */
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

/* ── Wizard Navigation ── */
.wizard-nav { display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; gap: 0.75rem; }
.wizard-nav .btn-prev, .wizard-nav .btn-next, .wizard-nav .btn-submit {
  padding: 0.75rem 1.75rem; font-weight: 800; font-size: 0.9rem; border: none; border-radius: 12px; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem;
}
.wizard-nav .btn-prev { background: var(--surface-alt); color: var(--ink); border: 2px solid #e5e7eb; }
.wizard-nav .btn-prev:hover { border-color: var(--brand-400); color: var(--brand-500); }
.wizard-nav .btn-next { background: var(--brand-500); color: #fff; }
.wizard-nav .btn-next:hover { opacity: 0.9; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,85,255,0.2); }
.wizard-nav .btn-next:disabled, .wizard-nav .btn-submit:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
.wizard-nav .btn-submit { background: linear-gradient(135deg, var(--brand-500), #22c55e); color: #fff; }
.wizard-nav .btn-submit:hover { opacity: 0.9; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,85,255,0.2); }
.wizard-nav .btn-submit.loading { pointer-events: none; }
.wizard-nav .btn-submit .spinner { display: none; width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; margin: 0 auto; }
.wizard-nav .btn-submit.loading .spinner { display: block; }
.wizard-nav .btn-submit.loading .btn-text { display: none; }
.wizard-nav .step-counter { font-size: 0.8rem; color: #9ca3af; font-weight: 600; }

/* ── Confirmation Step ── */
.confirm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
.confirm-item { background: var(--surface-alt); border-radius: 12px; padding: 0.85rem 1rem; border: 1px solid rgba(0,0,0,0.04); }
.confirm-item .confirm-label { font-size: 0.7rem; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem; }
.confirm-item .confirm-value { font-size: 0.9rem; font-weight: 700; color: var(--ink); }

/* ── Theme Switcher ── */
.theme-switcher { position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 6px; align-items: center; }
.theme-switcher .ts-label { font-size: 0.6rem; font-weight: 700; color: var(--ink-muted); background: #fff; padding: 0.2rem 0.5rem; border-radius: 999px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2px; }
.theme-switcher .ts-btns { display: flex; flex-direction: column; gap: 4px; }
.ts-btn { width: 36px; height: 36px; border-radius: 10px; border: 2px solid #e5e7eb; background: #fff; font-weight: 800; font-size: 0.75rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; color: #6b7280; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.ts-btn:hover { border-color: var(--brand-400); transform: scale(1.1); }
.ts-btn.active { border-color: var(--brand-500); background: var(--brand-500); color: #fff; box-shadow: 0 4px 12px rgba(0,85,255,0.3); }

@keyframes fadeInUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
@keyframes spin { to { transform: rotate(360deg); } }

@media (max-width: 576px) {
  .step-label { display: none; } .step-connector { width: 24px; }
  .bp-card, .bp-summary { padding: 1.2rem; } .bp-summary { position: static; }
  .service-card { padding: 0.8rem 0.4rem; } .bp-header h1 { font-size: 1.4rem; }
  .cat-tabs { gap: 0.35rem; } .cat-tab { padding: 0.5rem 0.85rem; font-size: 0.75rem; }
  .sessions-toggle { flex-direction: column; gap: 0.75rem; }
  .wizard-nav { flex-direction: column; }
  .wizard-nav .btn-prev, .wizard-nav .btn-next, .wizard-nav .btn-submit { width: 100%; justify-content: center; }
  .confirm-grid { grid-template-columns: 1fr; }
  .theme-switcher { bottom: 10px; right: 10px; }
  .ts-btn { width: 32px; height: 32px; font-size: 0.7rem; }
}
</style>
@endpush

@section('content')
<div class="bp-wrap">
    <div class="bp-header">
        <h1>اختاري <span class="gradient-text">خدمتك</span> المفضلة</h1>
        <p>اختاري الخدمة المناسبة واحجزي موعدك بسهولة</p>
    </div>

    {{-- Step Progress --}}
    <div class="step-progress">
        <div class="step-item active" id="step1Indicator">
            <div class="step-circle active"><span class="step-num">1</span><span class="step-check"><i class="fas fa-check"></i></span></div>
            <span class="step-label">الخدمة</span>
        </div>
        <div class="step-connector" id="stepConnector1"></div>
        <div class="step-item" id="step2Indicator">
            <div class="step-circle inactive">2</div>
            <span class="step-label">المعلومات</span>
        </div>
        <div class="step-connector" id="stepConnector2"></div>
        <div class="step-item" id="step3Indicator">
            <div class="step-circle inactive">3</div>
            <span class="step-label">الموعد</span>
        </div>
        <div class="step-connector" id="stepConnector3"></div>
        <div class="step-item" id="step4Indicator">
            <div class="step-circle inactive">4</div>
            <span class="step-label">التأكيد</span>
        </div>
    </div>

    @php
    $categories = [
        'face' => ['name' => 'العناية بالوجه', 'icon' => 'fas fa-face-smile-beam', 'color' => '#f472b6'],
        'body' => ['name' => 'العناية بالجسم', 'icon' => 'fas fa-spa', 'color' => '#34d399'],
        'extremities' => ['name' => 'سبا الأطراف', 'icon' => 'fas fa-hand-sparkles', 'color' => '#a78bfa'],
    ];
    $serviceIcons = [
        'التنظيف العميق وتوازن البشرة' => ['icon' => 'fas fa-droplet', 'color' => '#60a5fa'],
        'النضارة الفورية للعرائس' => ['icon' => 'fas fa-crown', 'color' => '#f59e0b'],
        'التقشير الزجاجي (Dermaplaning)' => ['icon' => 'fas fa-gem', 'color' => '#a78bfa'],
        'الشد الفوري بخيوط الحرير' => ['icon' => 'fas fa-wand-magic-sparkles', 'color' => '#f472b6'],
        'الميزوثيرابي السطحي (Dermapen)' => ['icon' => 'fas fa-syringe', 'color' => '#ef4444'],
        'التقشير البحري (Rose de Mer)' => ['icon' => 'fas fa-water', 'color' => '#06b6d4'],
        'العلاج بالضوء المرئي (LED)' => ['icon' => 'fas fa-lightbulb', 'color' => '#fbbf24'],
        'فاشيال الأكسجين' => ['icon' => 'fas fa-wind', 'color' => '#38bdf8'],
        'التقشير الكيميائي' => ['icon' => 'fas fa-flask', 'color' => '#a855f7'],
        'الشد بالتيار الميكروي' => ['icon' => 'fas fa-bolt', 'color' => '#f59e0b'],
        'علاج الكلف والنمش والتصبغات' => ['icon' => 'fas fa-sun', 'color' => '#f97316'],
        'علاج وجه متقدم' => ['icon' => 'fas fa-star', 'color' => '#f472b6'],
        'السنفرة وتلميع الجسم' => ['icon' => 'fas fa-spray-can-sparkles', 'color' => '#34d399'],
        'تنظيف الظهر العميق' => ['icon' => 'fas fa-hand-holding-medical', 'color' => '#60a5fa'],
        'المساج اللمفاوي العطري' => ['icon' => 'fas fa-leaf', 'color' => '#22c55e'],
        'المساج الخشبي (Maderotherapy)' => ['icon' => 'fas fa-fire', 'color' => '#ef4444'],
        'المساج بالأحجار الساخنة' => ['icon' => 'fas fa-fire-flame-curved', 'color' => '#f97316'],
        'لف الجسم (Body Wrapping)' => ['icon' => 'fas fa-bandage', 'color' => '#8b5cf6'],
        'الحمام المغربي التقليدي' => ['icon' => 'fas fa-bath', 'color' => '#06b6d4'],
        'التجويف (Cavitation)' => ['icon' => 'fas fa-wave-square', 'color' => '#3b82f6'],
        'رفع الرموش بالكيراتين' => ['icon' => 'fas fa-eye', 'color' => '#a78bfa'],
        'سبا ديتوكس فروة الرأس' => ['icon' => 'fas fa-brain', 'color' => '#14b8a6'],
        'تصفيح وتحديد الحواجب' => ['icon' => 'fas fa-pen-fancy', 'color' => '#8b5cf6'],
        'أظافر الجل' => ['icon' => 'fas fa-hand-sparkles', 'color' => '#ec4899'],
        'بديكير طبي' => ['icon' => 'fas fa-stethoscope', 'color' => '#3b82f6'],
        'بديكير ومنيكير' => ['icon' => 'fas fa-hand-holding-heart', 'color' => '#f472b6'],
        'سبا البارافين للأطراف' => ['icon' => 'fas fa-hand-holding-droplet', 'color' => '#06b6d4'],
        'علاج التشققات العميقة' => ['icon' => 'fas fa-shield-heart', 'color' => '#f59e0b'],
        'ترطيب البارافين الملكي' => ['icon' => 'fas fa-crown', 'color' => '#d4af37'],
    ];
    @endphp

    <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
        @csrf
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-7">

                {{-- ═══════ STEP 1: SERVICE SELECTION ═══════ --}}
                <div class="wizard-step active" id="wizardStep1">
                    <div class="bp-card">
                        <div class="section-title"><i class="fas fa-spa"></i> اختاري الخدمة <span style="color:var(--brand-500);">*</span></div>

                        <div class="cat-tabs">
                            @foreach($categories as $catKey => $catInfo)
                            <div class="cat-tab {{ $loop->first ? 'active' : '' }}" data-cat="{{ $catKey }}" onclick="switchCategory('{{ $catKey }}')">
                                <i class="{{ $catInfo['icon'] }}" style="font-size:0.75rem;"></i>
                                {{ $catInfo['name'] }}
                                <span class="cat-count">{{ $groupedServices[$catKey]->count() ?? 0 }}</span>
                            </div>
                            @endforeach
                        </div>

                        @foreach($categories as $catKey => $catInfo)
                        <div class="cat-section {{ $loop->first ? 'active' : '' }}" id="cat-{{ $catKey }}">
                            <div class="grid grid-cols-12 gap-2">
                                @if(isset($groupedServices[$catKey]))
                                @foreach($groupedServices[$catKey] as $service)
                                @php $sIcon = $serviceIcons[$service->name_ar] ?? ['icon' => 'fas fa-spa', 'color' => 'var(--brand-500)']; @endphp
                                <div class="col-span-6 md:col-span-4">
                                    <div class="service-card" data-service-id="{{ $service->id }}" data-price="{{ $service->final_price }}" data-name="{{ $service->name_ar }}" onclick="toggleService(this)">
                                        <div class="card-check"><i class="fas fa-check"></i></div>
                                        @if($service->is_on_sale)<div class="card-badge">خصم</div>@endif
                                        <div class="card-icon" style="background:{{ $sIcon['color'] }}12;color:{{ $sIcon['color'] }};"><i class="{{ $sIcon['icon'] }}"></i></div>
                                        <div class="card-name">{{ $service->name_ar }}</div>
                                        <div class="card-price">
                                            @if($service->is_on_sale)<div class="card-old-price">{{ number_format($service->price) }} ₪</div>{{ number_format($service->discount_price) }} ₪@else{{ number_format($service->price) }} ₪@endif
                                        </div>
                                        @if($service->duration)<div class="card-duration"><i class="far fa-clock" style="font-size:0.5rem;"></i> {{ $service->duration }} د</div>@endif
                                        @if($service->description_ar)<div class="card-desc">{{ $service->description_ar }}</div>@endif
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        @endforeach

                        <div class="sessions-toggle">
                            <span class="sessions-label"><i class="fas fa-layer-group" style="color:var(--brand-500);margin-left:0.3rem;"></i> عدد الجلسات</span>
                            <div class="sessions-btns">
                                @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="sess-btn {{ $i === 1 ? 'active' : '' }}" data-sessions="{{ $i }}" onclick="setSessions({{ $i }})">{{ $i }}</button>
                                @endfor
                            </div>
                        </div>

                        <div id="selectedServicesContainer"></div>
                        <input type="hidden" name="sessions_count" id="sessionsCount" value="1">
                        @error('service_ids') <span class="text-red-500 block mt-2 text-xs">{{ $message }}</span> @enderror

                        <div class="wizard-nav">
                            <div></div>
                            <div class="step-counter">الخطوة 1 من 4</div>
                            <button type="button" class="btn-next" onclick="goToStep(2)" id="step1Next" disabled>
                                التالي <i class="fas fa-arrow-left"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ═══════ STEP 2: PERSONAL INFO ═══════ --}}
                <div class="wizard-step" id="wizardStep2">
                    <div class="bp-card">
                        <div class="section-title"><i class="fas fa-user"></i> معلوماتك الشخصية</div>
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">الاسم الكريم <span class="text-red-500">*</span></label>
                                <div class="input-wrap"><i class="fas fa-user input-icon"></i><input type="text" name="customer_name" class="form-input" required placeholder="أدخلي اسمك" value="{{ old('customer_name') }}"></div>
                                @error('customer_name') <span class="text-red-500 block mt-1 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">رقم الهاتف <span class="text-red-500">*</span></label>
                                <div class="input-wrap"><i class="fas fa-phone input-icon"></i><input type="tel" name="customer_phone" class="form-input" required placeholder="05X XXX XXXX" value="{{ old('customer_phone') }}" dir="ltr"></div>
                                @error('customer_phone') <span class="text-red-500 block mt-1 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">البريد الإلكتروني <span style="color:#9ca3af;font-size:0.65rem;font-weight:400;">(اختياري)</span></label>
                                <div class="input-wrap"><i class="far fa-envelope input-icon"></i><input type="email" name="customer_email" class="form-input" placeholder="example@email.com" value="{{ old('customer_email') }}" dir="ltr"></div>
                            </div>
                        </div>

                        <div class="wizard-nav">
                            <button type="button" class="btn-prev" onclick="goToStep(1)"><i class="fas fa-arrow-right"></i> السابق</button>
                            <div class="step-counter">الخطوة 2 من 4</div>
                            <button type="button" class="btn-next" onclick="goToStep(3)" id="step2Next">التالي <i class="fas fa-arrow-left"></i></button>
                        </div>
                    </div>
                </div>

                {{-- ═══════ STEP 3: DATE, TIME & COUPON ═══════ --}}
                <div class="wizard-step" id="wizardStep3">
                    <div class="bp-card">
                        <div class="section-title"><i class="fas fa-calendar"></i> اختاري الموعد</div>
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">التاريخ <span class="text-red-500">*</span></label>
                                <input type="date" name="booking_date" class="form-input" id="bookingDate" value="{{ old('booking_date') }}" required min="{{ date('Y-m-d') }}">
                                @error('booking_date') <span class="text-red-500 block mt-1 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">الوقت <span class="text-red-500">*</span></label>
                                <select name="booking_time" class="form-input" id="bookingTime" required>
                                    <option value="">اختاري الوقت</option>
                                    @foreach($timeSlots as $slot)
                                    <option value="{{ $slot }}" {{ old('booking_time') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                                    @endforeach
                                </select>
                                @error('booking_time') <span class="text-red-500 block mt-1 text-xs">{{ $message }}</span> @enderror
                            </div>

                        </div>
                    </div>

                    <div class="bp-card mt-3">
                        <div class="section-title"><i class="fas fa-tag"></i> كود الخصم والملاحظات</div>
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label"><i class="fas fa-tag" style="color:var(--brand-500);margin-left:0.3rem;"></i> كود خصم</label>
                                <div class="coupon-row">
                                    <input type="text" name="coupon_code" class="form-input" id="couponCode" placeholder="أدخلي الكود إن وجد" value="{{ old('coupon_code') }}">
                                    <button type="button" class="coupon-btn" id="applyCoupon">تطبيق</button>
                                </div>
                                <div id="couponMessage" class="coupon-msg" style="display:none;"></div>
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">ملاحظات</label>
                                <textarea name="notes" class="form-input" rows="2" placeholder="أي استفسار أو ملاحظة ...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="wizard-nav">
                        <button type="button" class="btn-prev" onclick="goToStep(2)"><i class="fas fa-arrow-right"></i> السابق</button>
                        <div class="step-counter">الخطوة 3 من 4</div>
                        <button type="button" class="btn-next" onclick="goToStep(4)" id="step3Next">التالي <i class="fas fa-arrow-left"></i></button>
                    </div>
                </div>

                {{-- ═══════ STEP 4: CONFIRMATION & PAYMENT ═══════ --}}
                <div class="wizard-step" id="wizardStep4">
                    <div class="bp-card">
                        <div class="section-title"><i class="fas fa-check-circle"></i> تأكيد الحجز</div>

                        <div class="confirm-grid">
                            <div class="confirm-item" style="grid-column:1/-1;">
                                <div class="confirm-label">الخدمات المختارة</div>
                                <div class="confirm-value" id="confirmServices">-</div>
                            </div>
                            <div class="confirm-item">
                                <div class="confirm-label">عدد الجلسات</div>
                                <div class="confirm-value" id="confirmSessions">1</div>
                            </div>
                            <div class="confirm-item">
                                <div class="confirm-label">الاسم</div>
                                <div class="confirm-value" id="confirmName">-</div>
                            </div>
                            <div class="confirm-item">
                                <div class="confirm-label">رقم الهاتف</div>
                                <div class="confirm-value" id="confirmPhone">-</div>
                            </div>
                            <div class="confirm-item">
                                <div class="confirm-label">التاريخ</div>
                                <div class="confirm-value" id="confirmDate">-</div>
                            </div>
                            <div class="confirm-item">
                                <div class="confirm-label">الوقت</div>
                                <div class="confirm-value" id="confirmTime">-</div>
                            </div>
                        </div>
                    </div>

                    <div class="bp-card mt-3">
                        <div class="section-title"><i class="fas fa-credit-card"></i> طريقة الدفع</div>
                        <div class="payment-grid" id="paymentMethods">
                            @foreach($paymentMethods as $method)
                            <div class="payment-option {{ old('payment_method') == $method['id'] ? 'selected' : '' }}" onclick="selectPayment('{{ $method['id'] }}', this)">
                                <div class="flex gap-2 items-start">
                                    <div class="radio-dot"></div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <i class="fas {{ $method['icon'] }}" style="color:{{ $method['color'] }};font-size:1rem;"></i>
                                            <span class="font-bold" style="color:var(--ink);font-size:0.85rem;">{{ $method['name'] }}</span>
                                        </div>
                                        <span class="block" style="color:#6b7280;font-size:0.72rem;">{{ $method['description'] }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="payment_method" id="selectedPayment" value="{{ old('payment_method') }}">
                    </div>

                    <div class="wizard-nav">
                        <button type="button" class="btn-prev" onclick="goToStep(3)"><i class="fas fa-arrow-right"></i> السابق</button>
                        <div class="step-counter">الخطوة 4 من 4</div>
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <span class="btn-text"><i class="far fa-circle-check ml-2"></i> تأكيد الحجز</span>
                            <div class="spinner"></div>
                        </button>
                    </div>
                </div>

            </div>

            {{-- ═══════ SIDEBAR: SUMMARY ═══════ --}}
            <div class="col-span-12 lg:col-span-5">
                <div class="bp-summary">
                    <div class="summary-head"><i class="fas fa-receipt"></i><h5>ملخص الحجز</h5></div>
                    <div id="summaryContent"><div class="summary-empty"><i class="fas fa-spa"></i><small>اختاري خدمة لعرض الملخص</small></div></div>
                    <div id="totalLine" style="display:none;">
                        <div class="summary-total"><span class="label">الإجمالي</span><span class="value" id="totalDisplay">0 ₪</span></div>
                        <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
                    </div>
                </div>

                {{-- Center Info Card --}}
                <div class="bp-card mt-3" style="background: var(--brand-50); border-color: var(--brand-200);">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="summary-icon"><i class="fas fa-store"></i></div>
                        <span class="font-bold" style="color: var(--ink); font-size: 0.85rem;">{{ $siteSettings['site_name'] ?? 'سماح كير' }}</span>
                    </div>
                    <div class="flex items-center gap-2 mb-1" style="font-size:0.8rem;color:var(--ink-muted);">
                        <i class="fas fa-spa" style="width:16px;color:var(--brand-500);"></i>
                        <span id="summaryServiceCount">-</span>
                    </div>
                    <div class="flex items-center gap-2 mb-1" style="font-size:0.8rem;color:var(--ink-muted);" dir="ltr">
                        <i class="fas fa-layer-group" style="width:16px;color:var(--brand-500);"></i>
                        <span id="summarySessions">1 جلسة</span>
                    </div>
                    <div class="flex items-center gap-2" style="font-size:0.8rem;color:var(--ink-muted);">
                        <i class="far fa-clock" style="color:var(--brand-400);width:14px;"></i>
                        <span>{{ $siteSettings['working_hours'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="theme-switcher" id="themeSwitcher">
    <span class="ts-label">التصميم</span>
    <div class="ts-btns">
        @for($i = 1; $i <= 5; $i++)
        <button type="button" class="ts-btn" data-theme="{{ $i }}" onclick="switchThemeFromPage({{ $i }})" title="التصميم {{ $i }}">{{ $i }}</button>
        @endfor
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let currentStep = 1;
let selectedServices = [];
let couponDiscount = 0;
let sessionsCount = 1;

function switchCategory(cat) {
    document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.cat-section').forEach(s => s.classList.remove('active'));
    document.querySelector(`.cat-tab[data-cat="${cat}"]`).classList.add('active');
    document.getElementById('cat-' + cat).classList.add('active');
}

function toggleService(el) {
    const id = parseInt(el.dataset.serviceId);
    const price = parseFloat(el.dataset.price);
    const name = el.dataset.name;
    const idx = selectedServices.findIndex(s => s.id === id);
    if (idx > -1) {
        selectedServices.splice(idx, 1);
        el.classList.remove('selected');
    } else {
        selectedServices.push({id, price, name});
        el.classList.add('selected');
    }
    updateHiddenInputs();
    document.getElementById('step1Next').disabled = selectedServices.length === 0;
    updateSummary();
}

function updateHiddenInputs() {
    const container = document.getElementById('selectedServicesContainer');
    container.innerHTML = '';
    selectedServices.forEach(s => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'service_ids[]';
        input.value = s.id;
        container.appendChild(input);
    });
}

function setSessions(count) {
    sessionsCount = count;
    document.querySelectorAll('.sess-btn').forEach(b => b.classList.remove('active'));
    document.querySelector(`.sess-btn[data-sessions="${count}"]`).classList.add('active');
    document.getElementById('sessionsCount').value = count;
    updateSummary();
}

function goToStep(step) {
    if (step < 1 || step > 4) return;

    if (step > currentStep + 1 || step === currentStep + 1) {
        if (currentStep === 1 && selectedServices.length === 0) {
            showStepError('الرجاء اختيار خدمة واحدة على الأقل');
            return;
        }
        if (currentStep === 2) {
            const name = document.querySelector('[name="customer_name"]').value.trim();
            const phone = document.querySelector('[name="customer_phone"]').value.trim();
            if (!name) { showStepError('الرجاء إدخال الاسم'); return; }
            if (!phone) { showStepError('الرجاء إدخال رقم الهاتف'); return; }
        }
    }

    currentStep = step;

    document.querySelectorAll('.wizard-step').forEach(s => s.classList.remove('active'));
    document.getElementById('wizardStep' + step).classList.add('active');

    [1, 2, 3, 4].forEach(i => {
        const indicator = document.getElementById('step' + i + 'Indicator');
        const circle = indicator.querySelector('.step-circle');
        const connector = i < 4 ? document.getElementById('stepConnector' + i) : null;
        indicator.classList.remove('active', 'done');
        circle.classList.remove('active', 'done', 'inactive');
        if (connector) connector.classList.remove('done');
        if (i < step) {
            indicator.classList.add('done');
            circle.classList.add('done');
            if (connector) connector.classList.add('done');
        } else if (i === step) {
            indicator.classList.add('active');
            circle.classList.add('active');
        } else {
            circle.classList.add('inactive');
        }
    });

    if (step === 4) {
        updateConfirmation();
    }
}

function showStepError(msg) {
    const existing = document.querySelector('.wizard-alert');
    if (existing) existing.remove();
    const alert = document.createElement('div');
    alert.className = 'wizard-alert';
    alert.style.cssText = 'padding:0.75rem 1rem;border-radius:12px;font-size:0.85rem;font-weight:600;margin-bottom:1rem;background:#fef2f2;border:1px solid #fecaca;color:#dc2626;display:flex;align-items:center;gap:0.5rem;animation:fadeInUp 0.3s ease both;';
    alert.innerHTML = '<i class="fas fa-circle-exclamation"></i> ' + msg;
    const step = document.getElementById('wizardStep' + currentStep);
    step.insertBefore(alert, step.firstChild);
    setTimeout(() => { if (alert.parentNode) alert.remove(); }, 3000);
}

function updateConfirmation() {
    const name = document.querySelector('[name="customer_name"]').value || '-';
    const phone = document.querySelector('[name="customer_phone"]').value || '-';
    const date = document.querySelector('[name="booking_date"]').value || '-';
    const timeSelect = document.querySelector('[name="booking_time"]');
    const time = timeSelect.options[timeSelect.selectedIndex]?.text || '-';

    const servicesHtml = selectedServices.map((s, i) =>
        `${i + 1}. ${s.name} (${s.price.toFixed(0)} ₪)`
    ).join('<br>');
    document.getElementById('confirmServices').innerHTML = servicesHtml || '-';
    document.getElementById('confirmSessions').textContent = sessionsCount;
    document.getElementById('confirmName').textContent = name;
    document.getElementById('confirmPhone').textContent = phone;
    document.getElementById('confirmDate').textContent = date;
    document.getElementById('confirmTime').textContent = time;
}

function updateSummary() {
    const subtotal = selectedServices.reduce((sum, s) => sum + s.price, 0) * sessionsCount;
    const total = Math.max(0, subtotal - couponDiscount);
    const summary = document.getElementById('summaryContent');
    const totalLine = document.getElementById('totalLine');
    const svcCount = document.getElementById('summaryServiceCount');

    if (selectedServices.length > 0) {
        let html = selectedServices.map(s =>
            `<div class="summary-line"><span class="label">${s.name}</span><span class="value" style="color:var(--brand-500);">${(s.price * sessionsCount).toFixed(0)} ₪</span></div>`
        ).join('');
        if (sessionsCount > 1) {
            html += `<div class="summary-line"><span class="label">عدد الجلسات</span><span class="value">${sessionsCount}</span></div>`;
            html += `<div class="summary-line"><span class="label">المجموع الفرعي</span><span class="value">${subtotal.toFixed(0)} ₪</span></div>`;
        }
        if (couponDiscount > 0) {
            html += `<div class="summary-line"><span class="label" style="color:#22c55e;"><i class="fas fa-tag ml-1"></i> خصم</span><span class="value" style="color:#22c55e;">-${couponDiscount.toFixed(0)} ₪</span></div>`;
        }
        summary.innerHTML = html;
        totalLine.style.display = 'block';
        document.getElementById('totalDisplay').textContent = total.toFixed(0) + ' ₪';
        document.getElementById('totalAmountInput').value = total;
        svcCount.textContent = `${selectedServices.length} خدمة`;
    } else {
        summary.innerHTML = `<div class="summary-empty"><i class="fas fa-spa"></i><small>اختاري خدمة لعرض الملخص</small></div>`;
        totalLine.style.display = 'none';
        svcCount.textContent = '-';
    }
}

function selectPayment(id, el) {
    document.querySelectorAll('.payment-option').forEach(p => p.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('selectedPayment').value = id;
}

function applyCoupon() {
    const code = document.getElementById('couponCode').value.trim();
    const msg = document.getElementById('couponMessage');
    const btn = document.getElementById('applyCoupon');
    if (!code) { msg.style.display = 'block'; msg.className = 'coupon-msg error'; msg.innerHTML = '<i class="fas fa-circle-exclamation"></i> الرجاء إدخال كود الخصم'; return; }
    btn.classList.add('loading'); btn.textContent = '...';
    msg.style.display = 'block'; msg.className = 'coupon-msg'; msg.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التحقق...';
    const total = selectedServices.reduce((sum, s) => sum + s.price, 0) * sessionsCount || 0;
    fetch('{{ route("booking.coupon") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }, body: JSON.stringify({ code, amount: total }) })
    .then(r => r.json()).then(data => {
        btn.classList.remove('loading'); btn.textContent = 'تطبيق';
        msg.className = 'coupon-msg ' + (data.success ? 'success' : 'error');
        msg.innerHTML = data.success ? '<i class="fas fa-check-circle"></i> ' + data.message : '<i class="fas fa-circle-exclamation"></i> ' + data.message;
        couponDiscount = data.success ? (data.discount || 0) : 0;
        updateSummary();
    }).catch(() => {
        btn.classList.remove('loading'); btn.textContent = 'تطبيق';
        couponDiscount = 0; msg.style.display = 'block'; msg.className = 'coupon-msg error';
        msg.innerHTML = '<i class="fas fa-circle-exclamation"></i> خطأ في الاتصال';
        updateSummary();
    });
}

function switchThemeFromPage(num) {
    if (window.SamahTheme) {
        window.SamahTheme.switch(num);
    }
}

function highlightCurrentTheme() {
    const current = window.SamahTheme ? window.SamahTheme.getCurrent() : 1;
    document.querySelectorAll('.ts-btn').forEach(b => {
        b.classList.toggle('active', parseInt(b.dataset.theme) === current);
    });
}

document.getElementById('bookingForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('submitBtn');
    btn.classList.add('loading');
    btn.disabled = true;
});

document.addEventListener('DOMContentLoaded', function() {
    highlightCurrentTheme();
    @if(old('service_ids'))
    const ids = {{ json_encode(old('service_ids')) }};
    ids.forEach(function(id) {
        const el = document.querySelector(`.service-card[data-service-id="${id}"]`);
        if (el) {
            toggleService(el);
        }
    });
    if (selectedServices.length > 0) {
        goToStep(4);
    }
    @endif
});
</script>
@endsection
