@extends('frontend.layouts.app-v2')

@section('title', 'حسابي - ' . ($siteSettings['site_name'] ?? 'JeniCare'))

@section('content')
<section class="pt-32 pb-8 bg-gradient-to-b from-brand-50 to-surface text-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-ink mb-2">حسابي</h1>
        <p class="text-gray-500">مرحباً بعودتك {{ Auth::user()->name }}</p>
    </div>
</section>

<div class="container" style="padding:0 16px 60px;">
    <div class="row g-4">
        <div class="col-lg-3">
            @include('frontend.account.sidebar')
        </div>

        <div class="col-lg-9">
            <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,.08);overflow:hidden;">
                <div style="padding:20px 24px;border-bottom:1px solid var(--gray-200);">
                    <h2 style="font-size:1.15rem;margin:0;display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-clock" style="color:var(--pink-600);"></i> آخر الطلبات
                    </h2>
                </div>
                <div style="padding:24px;">
                    @if($orders->isEmpty())
                    <div style="text-align:center;padding:40px 20px;">
                        <div style="width:80px;height:80px;margin:0 auto 20px;border-radius:50%;background:var(--pink-100);display:flex;align-items:center;justify-content:center;font-size:2rem;color:var(--pink-600);">
                            <i class="fas fa-box"></i>
                        </div>
                        <h3 style="font-size:1.3rem;font-weight:700;margin-bottom:8px;color:var(--gray-800);">لا توجد طلبات</h3>
                        <p style="font-size:.95rem;color:var(--gray-500);margin-bottom:24px;">لم تقم بطلب أي منتجات بعد</p>
                        <a href="{{ route('shop') }}" style="display:inline-flex;align-items:center;gap:8px;padding:12px 32px;background:linear-gradient(135deg,var(--pink-600),var(--pink-500));color:#fff;border:none;border-radius:50px;font-weight:700;font-size:.95rem;text-decoration:none;box-shadow:0 4px 16px rgba(219,39,119,0.2);">تسوق الآن</a>
                    </div>
                    @else
                    <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
                        <table style="width:100%;border-collapse:collapse;">
                            <thead>
                                <tr style="border-bottom:2px solid var(--gray-100);">
                                    <th style="padding:12px 8px;text-align:right;font-size:.85rem;font-weight:600;color:var(--gray-500);">رقم الطلب</th>
                                    <th style="padding:12px 8px;text-align:right;font-size:.85rem;font-weight:600;color:var(--gray-500);">التاريخ</th>
                                    <th style="padding:12px 8px;text-align:right;font-size:.85rem;font-weight:600;color:var(--gray-500);">الحالة</th>
                                    <th style="padding:12px 8px;text-align:right;font-size:.85rem;font-weight:600;color:var(--gray-500);">الإجمالي</th>
                                    <th style="padding:12px 8px;text-align:right;font-size:.85rem;font-weight:600;color:var(--gray-500);"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr style="border-bottom:1px solid var(--gray-100);">
                                    <td style="padding:12px 8px;font-weight:600;font-size:.9rem;">{{ $order->order_number }}</td>
                                    <td style="padding:12px 8px;color:var(--gray-500);font-size:.85rem;">{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td style="padding:12px 8px;">
                                        @switch($order->status)
                                            @case('pending') <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:9999px;font-size:.8rem;font-weight:600;background:#FEF3C7;color:#92400E;">قيد الانتظار</span> @break
                                            @case('confirmed') <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:9999px;font-size:.8rem;font-weight:600;background:#DBEAFE;color:#1E40AF;">مؤكد</span> @break
                                            @case('processing') <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:9999px;font-size:.8rem;font-weight:600;background:#DBEAFE;color:#1E40AF;">قيد المعالجة</span> @break
                                            @case('shipped') <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:9999px;font-size:.8rem;font-weight:600;background:#DBEAFE;color:#1E40AF;">تم الشحن</span> @break
                                            @case('delivered') <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:9999px;font-size:.8rem;font-weight:600;background:#D1FAE5;color:#065F46;">تم التوصيل</span> @break
                                            @case('cancelled') <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:9999px;font-size:.8rem;font-weight:600;background:#FEE2E2;color:#991B1B;">ملغي</span> @break
                                            @default <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:9999px;font-size:.8rem;font-weight:600;background:var(--gray-200);color:var(--gray-800);">{{ $order->status }}</span>
                                        @endswitch
                                    </td>
                                    <td style="padding:12px 8px;font-weight:700;color:var(--pink-600);font-size:.9rem;">{{ number_format($order->total_amount, 2) }} ₪</td>
                                    <td style="padding:12px 8px;">
                                        <a href="{{ route('orders.show', $order->id) }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:transparent;color:var(--pink-600);border:1px solid var(--pink-200);border-radius:50px;font-size:.8rem;font-weight:600;text-decoration:none;transition:all .2s;" onmouseover="this.style.borderColor='var(--pink-600)'" onmouseout="this.style.borderColor='var(--pink-200)'">عرض</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
