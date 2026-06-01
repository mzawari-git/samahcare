@extends('admin.layouts.app')
@section('title', 'تفاصيل الحجز')
@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">معلومات الحجز</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th>رقم الحجز</th><td>{{ $booking->booking_number }}</td></tr>
                    <tr><th>الخدمة</th><td>{{ $booking->service_name }}</td></tr>
                    <tr><th>عدد الجلسات</th><td>{{ $booking->sessions_count ?? 1 }}</td></tr>
                    <tr><th>السعر</th><td>{{ number_format($booking->service_price) }} ₪</td></tr>
                    @if($booking->discount_amount > 0)
                    <tr><th>الخصم</th><td>-{{ number_format($booking->discount_amount) }} ₪</td></tr>
                    @endif
                    <tr><th>الإجمالي</th><td class="fw-bold">{{ number_format($booking->total_amount) }} ₪</td></tr>
                    <tr><th>تاريخ الحجز</th><td>{{ $booking->booking_date->format('Y-m-d') }}</td></tr>
                    <tr><th>الوقت</th><td>{{ $booking->booking_time }}</td></tr>
                    <tr><th>الحالة</th>
                        <td>
                            @switch($booking->status)
                                @case('pending') <span class="badge bg-warning">قيد الانتظار</span> @break
                                @case('confirmed') <span class="badge bg-primary">مؤكد</span> @break
                                @case('completed') <span class="badge bg-success">مكتمل</span> @break
                                @case('cancelled') <span class="badge bg-danger">ملغي</span> @break
                            @endswitch
                        </td>
                    </tr>
                    <tr><th>حالة الدفع</th><td>{{ $booking->payment_status }}</td></tr>
                    <tr><th>طريقة الدفع</th><td>{{ $booking->payment_method ?? '-' }}</td></tr>
                    <tr><th>ملاحظات العميل</th><td>{{ $booking->notes ?? '-' }}</td></tr>
                    <tr><th>تاريخ الإنشاء</th><td>{{ $booking->created_at }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">العميل</div>
            <div class="card-body">
                <p><strong>الاسم:</strong> {{ $booking->customer_name }}</p>
                <p><strong>الهاتف:</strong> {{ $booking->customer_phone }}</p>
                @if($booking->customer_email)
                <p><strong>البريد:</strong> {{ $booking->customer_email }}</p>
                @endif
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">تحديث الحالة</div>
            <div class="card-body">
                <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">سبب الإلغاء</label>
                        <textarea name="cancellation_reason" class="form-control" rows="2">{{ $booking->cancellation_reason }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات إدارية</label>
                        <textarea name="admin_notes" class="form-control" rows="3">{{ $booking->admin_notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-pink w-100">تحديث الحالة</button>
                </form>
            </div>
        </div>
    </div>
</div>
<a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary mt-3">عودة</a>
@endsection
