@extends('frontend.layouts.app-v2')

@section('title', 'تم تأكيد الطلب - ' . ($siteSettings['site_name'] ?? 'JeniCare'))

@section('content')
<div style="min-height:60vh;display:flex;align-items:center;justify-content:center;padding:140px 16px 40px;">
    <div style="text-align:center;max-width:560px;width:100%;">
        <div style="width:100px;height:100px;background:linear-gradient(135deg,#10B981,#059669);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:2.8rem;color:#fff;box-shadow:0 12px 40px rgba(16,185,129,.3);">
            <i class="fas fa-check"></i>
        </div>
        <h1 style="font-size:1.8rem;font-weight:800;color:var(--gray-800);margin-bottom:8px;">تم تأكيد طلبك بنجاح!</h1>
        <p style="color:var(--gray-500);margin-bottom:24px;line-height:1.7;">شكراً لتسوقك من JeniCare. سيتم التواصل معك قريباً لتأكيد الطلب وترتيب التوصيل.</p>

        <div style="background:#fff;border-radius:16px;border:1px solid var(--gray-100);padding:24px;margin-bottom:20px;text-align:right;">
            <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:12px;margin-bottom:12px;border-bottom:1px solid var(--gray-100);">
                <span style="font-weight:700;font-size:.95rem;color:var(--gray-800);">تفاصيل الطلب</span>
                <span style="background:var(--pink-50);color:var(--pink-600);padding:4px 12px;border-radius:50px;font-size:.8rem;font-weight:700;">{{ $order->status === 'pending' ? 'قيد المراجعة' : $order->status }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:6px 0;">
                <span style="color:var(--gray-500);font-size:.85rem;">رقم الطلب</span>
                <span style="font-weight:800;color:var(--pink-600);font-size:1.1rem;">#{{ $order->order_number }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:6px 0;">
                <span style="color:var(--gray-500);font-size:.85rem;">الإجمالي</span>
                <span style="font-weight:700;color:var(--gray-800);">{{ number_format($order->total_amount, 2) }} ₪</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:6px 0;">
                <span style="color:var(--gray-500);font-size:.85rem;">طريقة الدفع</span>
                <span style="font-weight:600;color:var(--gray-800);font-size:.85rem;">
                    @if($order->payment_method === 'cod') الدفع عند الاستلام
                    @elseif($order->payment_method === 'bank_transfer') تحويل بنكي
                    @elseif($order->payment_method === 'jawwal_pay') جوال باي
                    @elseif($order->payment_method === 'reflect') Reflect
                    @else {{ $order->payment_method }}
                    @endif
                </span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:6px 0;">
                <span style="color:var(--gray-500);font-size:.85rem;">المدينة</span>
                <span style="font-weight:600;color:var(--gray-800);font-size:.85rem;">{{ $order->shipping_city }}</span>
            </div>
        </div>

        {{-- Payment Instructions --}}
        @php $pm = $order->payment_method; @endphp
        @if(in_array($pm, ['bank_transfer','jawwal_pay','reflect']))
        <div style="background:#FFFBEB;border:1px solid #FCD34D;border-radius:12px;padding:16px;margin-bottom:20px;text-align:right;">
            <p style="font-weight:700;color:#92400E;font-size:.85rem;margin-bottom:8px;"><i class="fas fa-info-circle"></i> تعليمات الدفع:</p>
            @if($pm === 'bank_transfer')
            @php $bankSettings = \App\Models\Setting::whereIn('key',['payment_bank_name','payment_bank_holder','payment_bank_account','payment_bank_iban'])->pluck('value','key')->toArray(); @endphp
            <p style="font-size:.8rem;color:#92400E;margin:2px 0;">يرجى تحويل مبلغ <strong>{{ number_format($order->total_amount, 2) }} ₪</strong> إلى الحساب التالي:</p>
            @if($bankSettings['payment_bank_name'] ?? false)<p style="font-size:.8rem;color:#92400E;margin:2px 0;"><strong>البنك:</strong> {{ $bankSettings['payment_bank_name'] }}</p>@endif
            @if($bankSettings['payment_bank_holder'] ?? false)<p style="font-size:.8rem;color:#92400E;margin:2px 0;"><strong>المستفيد:</strong> {{ $bankSettings['payment_bank_holder'] }}</p>@endif
            @if($bankSettings['payment_bank_account'] ?? false)<p style="font-size:.8rem;color:#92400E;margin:2px 0;" dir="ltr"><strong>رقم الحساب:</strong> {{ $bankSettings['payment_bank_account'] }}</p>@endif
            @if($bankSettings['payment_bank_iban'] ?? false)<p style="font-size:.8rem;color:#92400E;margin:2px 0;" dir="ltr"><strong>IBAN:</strong> {{ $bankSettings['payment_bank_iban'] }}</p>@endif
            @elseif($pm === 'jawwal_pay')
            @php $jwSettings = \App\Models\Setting::whereIn('key',['payment_jawwal_phone','payment_jawwal_holder'])->pluck('value','key')->toArray(); @endphp
            <p style="font-size:.8rem;color:#92400E;margin:2px 0;">يرجى إرسال مبلغ <strong>{{ number_format($order->total_amount, 2) }} ₪</strong> عبر جوال باي إلى:</p>
            @if($jwSettings['payment_jawwal_holder'] ?? false)<p style="font-size:.8rem;color:#92400E;margin:2px 0;"><strong>المستفيد:</strong> {{ $jwSettings['payment_jawwal_holder'] }}</p>@endif
            @if($jwSettings['payment_jawwal_phone'] ?? false)<p style="font-size:.8rem;color:#92400E;margin:2px 0;" dir="ltr"><strong>رقم جوال باي:</strong> {{ $jwSettings['payment_jawwal_phone'] }}</p>@endif
            @elseif($pm === 'reflect')
            @php $rfSettings = \App\Models\Setting::whereIn('key',['payment_reflect_holder','payment_reflect_phone'])->pluck('value','key')->toArray(); @endphp
            <p style="font-size:.8rem;color:#92400E;margin:2px 0;">يرجى إرسال مبلغ <strong>{{ number_format($order->total_amount, 2) }} ₪</strong> عبر تطبيق Reflect إلى:</p>
            @if($rfSettings['payment_reflect_holder'] ?? false)<p style="font-size:.8rem;color:#92400E;margin:2px 0;"><strong>المستفيد:</strong> {{ $rfSettings['payment_reflect_holder'] }}</p>@endif
            @if($rfSettings['payment_reflect_phone'] ?? false)<p style="font-size:.8rem;color:#92400E;margin:2px 0;" dir="ltr"><strong>رقم هاتف Reflect:</strong> {{ $rfSettings['payment_reflect_phone'] }}</p>@endif
            @endif
            <p style="font-size:.75rem;color:#D97706;margin-top:8px;">بعد إتمام الدفع، يرجى التواصل معنا عبر واتساب على <strong>{{ $siteSettings['site_whatsapp'] ?? '970591234567' }}</strong> مع إرفاق رقم الطلب <strong>#{{ $order->order_number }}</strong></p>
        </div>
        @endif

        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            @auth
            <a href="{{ route('orders.show', $order->id) }}" style="display:inline-flex;align-items:center;gap:8px;padding:14px 28px;background:linear-gradient(135deg,var(--pink-600),var(--pink-500));color:#fff;border:none;border-radius:50px;font-weight:700;font-size:.95rem;text-decoration:none;box-shadow:0 4px 16px rgba(219,39,119,0.2);transition:all .3s;" onmouseover="this.style.boxShadow='0 8px 24px rgba(219,39,119,0.3)';this.style.transform='translateY(-1px)'" onmouseout="this.style.boxShadow='0 4px 16px rgba(219,39,119,0.2)';this.style.transform='none'">
                <i class="fas fa-eye"></i> عرض تفاصيل الطلب
            </a>
            @endif
            <a href="{{ route('shop') }}" style="display:inline-flex;align-items:center;gap:8px;padding:14px 28px;background:#fff;color:var(--pink-600);border:1px solid var(--pink-200);border-radius:50px;font-weight:700;font-size:.95rem;text-decoration:none;transition:all .3s;" onmouseover="this.style.borderColor='var(--pink-600)';this.style.background='var(--pink-50)'" onmouseout="this.style.borderColor='var(--pink-200)';this.style.background='#fff'">
                <i class="fas fa-store"></i> متابعة التسوق
            </a>
        </div>

        <p style="margin-top:20px;font-size:.8rem;color:var(--gray-400);">لديك استفسار؟ <a href="https://wa.me/{{ $siteSettings['site_whatsapp'] ?? '970591234567' }}" style="color:#25D366;font-weight:600;">تواصل معنا عبر واتساب</a></p>
    </div>
</div>
@endsection
