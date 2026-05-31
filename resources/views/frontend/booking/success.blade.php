@extends($layoutPath)

@section('title', 'تم تأكيد الحجز - ' . ($siteSettings['site_name'] ?? 'سماح كير'))

@section('content')
<div class="max-w-lg mx-auto px-4 py-20">
    <div class="text-center mb-10">
        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background:#dcfce7;animation:successPop 0.5s cubic-bezier(0.34,1.56,0.64,1);">
            <i class="fas fa-check-circle text-4xl" style="color:#22c55e;"></i>
        </div>
        <h1 class="text-2xl font-black mb-2" style="color:var(--ink);">تم استلام <span class="gradient-text">حجزك</span> بنجاح!</h1>
        <p class="text-sm" style="color:var(--ink-muted);">سنقوم بالتواصل معك لتأكيد الموعد خلال 24 ساعة</p>
    </div>

    <div class="rounded-2xl p-6 mb-8" style="background:white;border:1px solid rgba(0,0,0,0.04);box-shadow:0 1px 3px rgba(0,0,0,0.04);">
        <div class="flex items-center gap-2 pb-4 mb-4" style="border-bottom:1px solid rgba(0,0,0,0.04);">
            <i class="fas fa-receipt" style="color:var(--brand-500);"></i>
            <span class="text-sm font-bold" style="color:var(--ink);">تفاصيل الحجز</span>
        </div>
        @foreach([
            ['رقم الحجز', $booking->booking_number],
            ['الخدمة', $booking->service_name],
            ['التاريخ', $booking->booking_date instanceof \Carbon\Carbon ? $booking->booking_date->format('Y-m-d') : $booking->booking_date],
            ['الوقت', $booking->booking_time],
            ['الاسم', $booking->customer_name],
        ] as $line)
        <div class="flex justify-between items-center py-3" style="{{ !$loop->last ? 'border-bottom:1px solid rgba(0,0,0,0.04);' : '' }}">
            <span class="text-sm" style="color:var(--ink-muted);">{{ $line[0] }}</span>
            <span class="text-sm font-bold" style="color:var(--ink);">{{ $line[1] }}</span>
        </div>
        @endforeach
        @if($booking->total_amount > 0)
        <div class="flex justify-between items-center pt-4 mt-2" style="border-top:2px solid var(--brand-50);">
            <span class="text-sm font-bold" style="color:var(--ink);">الإجمالي</span>
            <span class="text-lg font-black" style="color:var(--brand-500);">{{ number_format($booking->total_amount) }} ₪</span>
        </div>
        @endif
    </div>

    <div class="flex flex-col gap-3 items-center">
        <a href="{{ route('booking') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full font-bold text-sm text-white transition-all hover:opacity-90" style="background:var(--gradient-primary);min-width:220px;">
            <i class="fas fa-calendar-plus"></i> حجز جديد
        </a>
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full font-bold text-sm transition-all hover:-translate-y-0.5" style="background:white;color:var(--ink);border:1px solid rgba(0,0,0,0.06);min-width:220px;">
            <i class="fas fa-house"></i> العودة للرئيسية
        </a>
    </div>
</div>

<style>
@keyframes successPop { 0% { transform: scale(0); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
</style>
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
