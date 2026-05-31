@extends($layoutPath)

@section('title', 'تم تأكيد الحجز - ' . ($siteSettings['site_name'] ?? 'سماح كير '))

@push('styles')
<style>
.bp-success-wrap {
  max-width: 560px;
  margin: 0 auto;
  padding: 2rem 1rem 3rem;
}

.success-header {
  text-align: center;
  margin-bottom: 2rem;
}
.success-icon-wrap {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.25rem;
  background: linear-gradient(135deg, rgba(34,197,94,0.1), rgba(34,197,94,0.05));
  border: 2px solid rgba(34,197,94,0.15);
  animation: successPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.success-icon-wrap i {
  font-size: 2.5rem;
  color: #22c55e;
}
@keyframes successPop {
  0% { transform: scale(0); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}
.success-header h1 {
  font-size: 1.5rem;
  font-weight: 900;
  color: #1a1a2e;
  margin-bottom: 0.4rem;
}
.success-header h1 .gradient-text {
  background: linear-gradient(135deg, #d946ef, #c026d3);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.success-header p {
  color: #6b7280;
  font-size: 0.9rem;
}

.bp-card {
  background: #fff;
  border-radius: 24px;
  padding: 1.5rem 1.75rem;
  box-shadow: 0 4px 24px rgba(0,0,0,0.05);
  border: 1px solid rgba(217,70,239,0.07);
}
.detail-card {
  margin-bottom: 1.5rem;
  animation: fadeInUp 0.45s ease 0.1s both;
}
.detail-card .card-head {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.85rem;
  font-weight: 800;
  padding-bottom: 0.65rem;
  border-bottom: 1px solid #f1f3f5;
  color: #1a1a2e;
  margin-bottom: 0.5rem;
}
.detail-card .card-head i {
  width: 26px;
  height: 26px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  background: rgba(217,70,239,0.1);
  color: #d946ef;
  font-size: 0.7rem;
}
.detail-line {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.55rem 0;
}
.detail-line + .detail-line {
  border-top: 1px solid #f1f3f5;
}
.detail-line .label { color: #868e96; font-size: 0.82rem; }
.detail-line .value { font-weight: 700; color: #1a1a2e; }
.detail-total {
  border-top: 2px solid rgba(217,70,239,0.1);
  margin-top: 0.25rem;
  padding-top: 0.65rem;
}
.detail-total .value { color: #d946ef; font-size: 1.15rem; }

.success-actions {
  display: flex;
  flex-direction: column;
  gap: 0.65rem;
  align-items: center;
  animation: fadeInUp 0.45s ease 0.2s both;
}
.btn-primary-custom {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.4rem;
  padding: 0.85rem 2rem;
  font-weight: 800;
  font-size: 0.92rem;
  border: none;
  border-radius: 16px;
  background: linear-gradient(135deg, #d946ef, #c026d3);
  color: #fff;
  text-decoration: none;
  transition: all 0.3s;
  min-width: 220px;
}
.btn-primary-custom::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.12), transparent 50%);
  pointer-events: none;
}
.btn-primary-custom:hover {
  filter: brightness(1.06);
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(217,70,239,0.25);
  color: #fff;
}
.btn-secondary-custom {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.4rem;
  padding: 0.85rem 2rem;
  font-weight: 700;
  font-size: 0.92rem;
  border: 2px solid #e9ecef;
  border-radius: 16px;
  background: #fff;
  color: #495057;
  text-decoration: none;
  transition: all 0.25s;
  min-width: 220px;
}
.btn-secondary-custom:hover {
  border-color: #d946ef;
  color: #d946ef;
  background: #fdf4ff;
  transform: translateY(-2px);
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(14px); }
  to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 576px) {
  .bp-card { padding: 1.2rem; }
  .success-header h1 { font-size: 1.3rem; }
  .btn-primary-custom, .btn-secondary-custom { min-width: 0; width: 100%; }
}
</style>
@endpush

@section('content')
<div class="bp-success-wrap">

    <div class="success-header fade-in-up">
        <div class="success-icon-wrap">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>تم استلام <span class="gradient-text">حجزك</span> بنجاح!</h1>
        <p>سنقوم بالتواصل معك لتأكيد الموعد خلال 24 ساعة</p>
    </div>

    <div class="bp-card detail-card">
        <div class="card-head">
            <i class="fas fa-receipt"></i>
            تفاصيل الحجز
        </div>
        <div class="detail-line">
            <span class="label">رقم الحجز</span>
            <span class="value">{{ $booking->booking_number }}</span>
        </div>
        <div class="detail-line">
            <span class="label">الخدمة</span>
            <span class="value">{{ $booking->service_name }}</span>
        </div>
        <div class="detail-line">
            <span class="label">التاريخ</span>
            <span class="value">{{ $booking->booking_date instanceof \Carbon\Carbon ? $booking->booking_date->format('Y-m-d') : $booking->booking_date }}</span>
        </div>
        <div class="detail-line">
            <span class="label">الوقت</span>
            <span class="value">{{ $booking->booking_time }}</span>
        </div>
        <div class="detail-line">
            <span class="label">الاسم</span>
            <span class="value">{{ $booking->customer_name }}</span>
        </div>
        @if($booking->total_amount > 0)
        <div class="detail-line detail-total">
            <span class="label fw-bold" style="color:#1a1a2e;">الإجمالي</span>
            <span class="value">{{ number_format($booking->total_amount) }} ₪</span>
        </div>
        @endif
    </div>

    <div class="success-actions">
        <a href="{{ route('booking') }}" class="btn-primary-custom">
            <i class="fas fa-calendar-plus"></i> حجز جديد
        </a>
        <a href="{{ route('home') }}" class="btn-secondary-custom">
            <i class="fas fa-house"></i> العودة للرئيسية
        </a>
    </div>

</div>
@endsection

@if($trackingData && $trackingData['pixel_enabled'])
@push('scripts')
<script>
fbq('track', 'Purchase', {
  value: {{ $trackingData['value'] }},
  currency: '{{ $trackingData['currency'] }}',
  content_name: '{{ $trackingData['content_name'] }}',
  content_ids: ['{{ $trackingData['content_id'] }}'],
  content_type: '{{ $trackingData['content_type'] }}',
  order_id: '{{ $trackingData['order_id'] }}',
}, { eventID: '{{ $trackingData['event_id'] }}' });
</script>
@endpush
@endif
