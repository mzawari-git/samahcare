@extends('admin.layouts.app')

@section('title', 'تحليلات متقدمة')

@push('styles')
<style>
.analytics-header { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff; padding: 24px; border-radius: 16px; margin-bottom: 24px; }
.metric-card { background: #fff; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0; text-align: center; transition: all .3s; }
.metric-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,.1); }
.metric-value { font-size: 2.5rem; font-weight: 800; color: var(--gray-800); }
.metric-label { color: var(--gray-500); font-size: .9rem; font-weight: 500; }
.metric-change { font-size: .85rem; padding: 4px 12px; border-radius: 20px; font-weight: 600; margin-top: 8px; display: inline-block; }
.metric-change.positive { background: #dcfce7; color: #16a34a; }
.metric-change.negative { background: #fee2e2; color: #dc2626; }
.chart-card { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; }
.chart-header { padding: 20px 24px; border-bottom: 1px solid #f1f5f9; font-weight: 700; }
.table-orders th { font-size: .8rem; text-transform: uppercase; letter-spacing: .05em; color: var(--gray-500); font-weight: 600; }
.filter-btn { padding: 8px 20px; border-radius: 10px; font-size: .875rem; font-weight: 500; border: 1px solid #e2e8f0; background: #fff; color: var(--gray-600); transition: all .2s; }
.filter-btn:hover, .filter-btn.active { background: var(--pink-600); color: #fff; border-color: var(--pink-600); }
</style>
@endpush

@section('content')

@php
    $vipCount = $customerAnalytics['topCustomers']->filter(fn($c) => $c->total_spent >= 1000)->count();
    $returningCount = $customerAnalytics['topCustomers']->filter(fn($c) => $c->booking_count > 1 && $c->total_spent < 1000)->count();
    $newCount = max(1, $customerAnalytics['newCustomers'] - $vipCount - $returningCount);
@endphp

{{-- Header --}}
<div class="analytics-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2 class="mb-1" style="font-weight:800;"><i class="fas fa-chart-line me-2"></i> تحليلات الحجوزات</h2>
            <p class="mb-0 opacity-75">تحليل شامل لأداء الحجوزات وسلوك العملاء</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.analytics.export', ['period' => $period]) }}" class="btn btn-light">
                <i class="fas fa-download me-1"></i> تصدير
            </a>
        </div>
    </div>

    {{-- Period Filter --}}
    <div class="mt-4 d-flex gap-2 flex-wrap">
        @php $periods = [7 => '7 أيام', 30 => '30 يوم', 90 => '3 أشهر', 365 => 'سنة']; @endphp
        @foreach($periods as $days => $label)
        <a href="{{ route('admin.analytics.index', ['period' => $days]) }}" 
           class="filter-btn {{ $period == $days ? 'active' : '' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>
</div>

{{-- Overview Metrics --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="metric-card">
            <div class="metric-value" style="color: #db2777;">{{ number_format($overview['revenue'], 0) }} ₪</div>
            <div class="metric-label">إجمالي الإيرادات</div>
            <span class="metric-change {{ $overview['revenueGrowth'] >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ $overview['revenueGrowth'] >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($overview['revenueGrowth']) }}%
            </span>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card">
            <div class="metric-value" style="color: #0284c7;">{{ number_format($overview['bookings']) }}</div>
            <div class="metric-label">عدد الحجوزات</div>
            <span class="metric-change {{ $overview['bookingsGrowth'] >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ $overview['bookingsGrowth'] >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($overview['bookingsGrowth']) }}%
            </span>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card">
            <div class="metric-value" style="color: #16a34a;">{{ number_format($overview['avgBookingValue']) }} ₪</div>
            <div class="metric-label">متوسط قيمة الحجز</div>
            <span class="metric-change {{ $overview['avgBookingValueGrowth'] >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ $overview['avgBookingValueGrowth'] >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($overview['avgBookingValueGrowth']) }}%
            </span>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="metric-card">
            <div class="metric-value" style="color: #8b5cf6;">{{ $overview['customers'] }}</div>
            <div class="metric-label">عملاء جدد</div>
            <span class="metric-change positive">
                <i class="fas fa-users"></i> خلال الفترة
            </span>
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="chart-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-area me-2" style="color:var(--pink-600);"></i> الأداء عبر الوقت</span>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary active" onclick="toggleMainChart('revenue')">الإيرادات</button>
                    <button class="btn btn-outline-secondary" onclick="toggleMainChart('bookings')">الحجوزات</button>
                </div>
            </div>
            <div class="p-4">
                <div style="height: 320px;">
                    <canvas id="mainTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="chart-header"><i class="fas fa-crown me-2" style="color:var(--pink-600);"></i> أفضل الخدمات</div>
            <div class="p-4">
                @forelse($bookingAnalytics['topServices'] as $service)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span class="fw-bold">{{ $service->name_ar }}</span>
                    <div>
                        <span class="badge bg-light text-dark me-2">{{ $service->total_bookings }} حجز</span>
                        <span class="text-muted small">{{ number_format($service->total_revenue) }} ₪</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">لا توجد بيانات</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Customer & Service Analytics --}}
<div class="row g-3 mb-4">
    {{-- Customer Segments --}}
    <div class="col-lg-4">
        <div class="chart-card h-100">
            <div class="chart-header"><i class="fas fa-users me-2" style="color:var(--pink-600);"></i> شرائح العملاء</div>
            <div class="p-4">
                <div style="height: 250px;">
                    <canvas id="segmentsChart"></canvas>
                </div>
                <div class="mt-3">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="d-flex align-items-center gap-2">
                            <span class="segment-badge" style="background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:600;">VIP</span>
                            <small>أكثر من 1000₪</small>
                        </span>
                        <strong>{{ $vipCount }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="d-flex align-items-center gap-2">
                            <span class="segment-badge" style="background:#dbeafe;color:#1e40af;padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:600;">متكرر</span>
                            <small>أكثر من حجز واحد</small>
                        </span>
                        <strong>{{ $returningCount }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="d-flex align-items-center gap-2">
                            <span class="segment-badge" style="background:#dcfce7;color:#16a34a;padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:600;">جديد</span>
                            <small>عملاء جدد</small>
                        </span>
                        <strong>{{ $newCount }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Customers --}}
    <div class="col-lg-8">
        <div class="chart-card h-100">
            <div class="chart-header d-flex justify-content-between">
                <span><i class="fas fa-crown me-2" style="color:var(--pink-600);"></i> أفضل العملاء</span>
                <span class="badge bg-warning text-dark">{{ $customerAnalytics['activeCustomers'] }} عميل نشط</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-orders">
                    <thead>
                        <tr>
                            <th>العميل</th>
                            <th>الحجوزات</th>
                            <th>إجمالي المشتريات</th>
                            <th>آخر حجز</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customerAnalytics['topCustomers'] as $customer)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-sm" style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--pink-500),var(--pink-600));color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                        {{ substr($customer->customer_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $customer->customer_name }}</div>
                                        <small class="text-muted">{{ $customer->customer_email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark">{{ $customer->booking_count }}</span></td>
                            <td class="fw-bold" style="color:var(--pink-600);">{{ number_format($customer->total_spent) }} ₪</td>
                            <td class="text-muted small">{{ $customer->last_booking ? \Carbon\Carbon::parse($customer->last_booking)->diffForHumans() : '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">لا توجد بيانات</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Services & Booking Details --}}
<div class="row g-3 mb-4">
    {{-- Top Services --}}
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="chart-header d-flex justify-content-between">
                <span><i class="fas fa-concierge-bell me-2" style="color:var(--pink-600);"></i> أكثر الخدمات حجزاً</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th>الخدمة</th>
                            <th>الحجوزات</th>
                            <th>الإيرادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookingAnalytics['topServices'] as $index => $service)
                        <tr>
                            <td>
                                <div class="product-rank" style="width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;{{ $index < 3 ? 'background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;' : 'background:#f1f5f9;color:#64748b;' }}">
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            <td><span class="fw-bold">{{ $service->name_ar }}</span></td>
                            <td><span class="badge bg-success">{{ $service->total_bookings }} حجز</span></td>
                            <td class="fw-bold">{{ number_format($service->total_revenue) }} ₪</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">لا توجد بيانات</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Summary Stats --}}
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="chart-header"><i class="fas fa-info-circle me-2" style="color:var(--pink-600);"></i> ملخص الفترة</div>
            <div class="p-4">
                <div class="mb-4">
                    <small class="text-muted d-block">إجمالي الحجوزات</small>
                    <span class="fw-bold" style="font-size:1.5rem;">{{ number_format($bookingAnalytics['totalBookings']) }}</span>
                </div>
                <div class="mb-4">
                    <small class="text-muted d-block">إجمالي الإيرادات</small>
                    <span class="fw-bold" style="font-size:1.5rem;color:var(--pink-600);">{{ number_format($bookingAnalytics['totalBookingRevenue']) }} ₪</span>
                </div>
                <div class="mb-4">
                    <small class="text-muted d-block">عملاء جدد</small>
                    <span class="fw-bold" style="font-size:1.5rem;color:#16a34a;">{{ number_format($customerAnalytics['newCustomers']) }}</span>
                </div>
                <div>
                    <small class="text-muted d-block">عملاء نشطون</small>
                    <span class="fw-bold" style="font-size:1.5rem;color:#0284c7;">{{ number_format($customerAnalytics['activeCustomers']) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
Chart.defaults.font.family = "'Tajawal', sans-serif";
Chart.defaults.color = '#64748b';

// Main Trend Chart
const trendCtx = document.getElementById('mainTrendChart').getContext('2d');
const dailyData = @json($bookingAnalytics['dailyBookings']);
const labels = dailyData.map(d => d.date);
const revenueData = dailyData.map(d => d.revenue);
const bookingsData = dailyData.map(d => d.count);

const trendChart = new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'الإيرادات',
            data: revenueData,
            borderColor: '#db2777',
            backgroundColor: 'rgba(219, 39, 119, 0.1)',
            fill: true,
            tension: 0.4,
            yAxisID: 'y'
        }, {
            label: 'الحجوزات',
            data: bookingsData,
            borderColor: '#0284c7',
            backgroundColor: 'rgba(2, 132, 199, 0.1)',
            fill: true,
            tension: 0.4,
            yAxisID: 'y1',
            hidden: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { intersect: false, mode: 'index' },
        plugins: { legend: { position: 'top', rtl: true } },
        scales: {
            x: { grid: { display: false } },
            y: { position: 'left', grid: { color: '#f1f5f9' }, ticks: { callback: v => v + ' ₪' } },
            y1: { position: 'right', display: false }
        }
    }
});

function toggleMainChart(type) {
    trendChart.data.datasets[0].hidden = type !== 'revenue';
    trendChart.data.datasets[1].hidden = type !== 'bookings';
    trendChart.update();
    event.target.parentElement.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
}

// Customer Segments
const segmentsCtx = document.getElementById('segmentsChart').getContext('2d');
new Chart(segmentsCtx, {
    type: 'doughnut',
    data: {
        labels: ['VIP', 'متكرر', 'جديد'],
        datasets: [{
            data: [{{ $vipCount }}, {{ $returningCount }}, {{ max(1, $newCount) }}],
            backgroundColor: ['#f59e0b', '#3b82f6', '#10b981'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', rtl: true, labels: { usePointStyle: true, padding: 15 } }
        },
        cutout: '60%'
    }
});
</script>
@endpush
