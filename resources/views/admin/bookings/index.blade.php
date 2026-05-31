@extends('admin.layouts.app')
@section('title', 'الحجوزات')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">الحجوزات</h5>
</div>
<div class="row g-2 mb-4">
    <div class="col">
        <div class="card text-center p-3 border-0 shadow-sm">
            <div class="fw-bold text-warning fs-4">{{ $statusCounts['pending'] }}</div>
            <small class="text-muted">قيد الانتظار</small>
        </div>
    </div>
    <div class="col">
        <div class="card text-center p-3 border-0 shadow-sm">
            <div class="fw-bold text-primary fs-4">{{ $statusCounts['confirmed'] }}</div>
            <small class="text-muted">مؤكدة</small>
        </div>
    </div>
    <div class="col">
        <div class="card text-center p-3 border-0 shadow-sm">
            <div class="fw-bold text-success fs-4">{{ $statusCounts['completed'] }}</div>
            <small class="text-muted">مكتملة</small>
        </div>
    </div>
    <div class="col">
        <div class="card text-center p-3 border-0 shadow-sm">
            <div class="fw-bold text-danger fs-4">{{ $statusCounts['cancelled'] }}</div>
            <small class="text-muted">ملغية</small>
        </div>
    </div>
</div>
<form method="GET" class="row g-2 mb-4">
    <div class="col-auto">
        <select name="status" class="form-select">
            <option value="">كل الحالات</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>مؤكدة</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتملة</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغية</option>
        </select>
    </div>
    <div class="col-auto">
        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="من تاريخ">
    </div>
    <div class="col-auto">
        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="إلى تاريخ">
    </div>
    <div class="col-auto">
        <input type="text" name="search" class="form-control" placeholder="بحث..." value="{{ request('search') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-pink"><i class="fas fa-search"></i></button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i></a>
    </div>
</form>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>رقم الحجز</th>
                    <th>العميل</th>
                    <th>الهاتف</th>
                    <th>الخدمة</th>
                    <th>التاريخ</th>
                    <th>الوقت</th>
                    <th>المبلغ</th>
                    <th>الحالة</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_number }}</td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ $booking->customer_phone }}</td>
                    <td>{{ $booking->service_name }}</td>
                    <td>{{ $booking->booking_date->format('Y-m-d') }}</td>
                    <td>{{ $booking->booking_time }}</td>
                    <td>{{ number_format($booking->total_amount) }} ₪</td>
                    <td>
                        @switch($booking->status)
                            @case('pending') <span class="badge bg-warning">قيد الانتظار</span> @break
                            @case('confirmed') <span class="badge bg-primary">مؤكد</span> @break
                            @case('completed') <span class="badge bg-success">مكتمل</span> @break
                            @case('cancelled') <span class="badge bg-danger">ملغي</span> @break
                            @default <span class="badge bg-secondary">{{ $booking->status }}</span>
                        @endswitch
                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-pink">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted">لا توجد حجوزات</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $bookings->links() }}
@endsection
