@extends('admin.layouts.app')

@section('title', 'لوحة التحكم')

@push('styles')
<style>
.analytics-card { background: linear-gradient(135deg, #fff 0%, #f8fafc 100%); border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; }
.analytics-value { font-size: 2rem; font-weight: 800; color: var(--gray-800); }
.analytics-label { font-size: .875rem; color: var(--gray-500); font-weight: 500; }
.analytics-change { font-size: .75rem; padding: 4px 8px; border-radius: 20px; font-weight: 600; }
.analytics-change.up { background: #dcfce7; color: #16a34a; }
.analytics-change.down { background: #fee2e2; color: #dc2626; }
.chart-container { position: relative; height: 300px; }
.chart-container-sm { position: relative; height: 200px; }
</style>
@endpush

@section('content')
{{-- Quick Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-new">
            <div class="d-flex align-items-center justify-content-between">
                <div class="stat-icon-new" style="background: linear-gradient(135deg, #fdf2f8, #fce7f3); color: #db2777;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <span class="analytics-change {{ $analytics['revenueGrowth'] >= 0 ? 'up' : 'down' }}">
                    <i class="fas fa-arrow-{{ $analytics['revenueGrowth'] >= 0 ? 'up' : 'down' }}"></i>
                    {{ abs($analytics['revenueGrowth']) }}%
                </span>
            </div>
            <div class="stat-value-new">{{ number_format($totalBookings) }}</div>
            <div class="stat-label-new">إجمالي الحجوزات</div>
            <div class="mt-2 text-muted small">+{{ $todayBookings }} اليوم</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-new">
            <div class="d-flex align-items-center justify-content-between">
                <div class="stat-icon-new" style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #16a34a;">
                    <i class="fas fa-shekel-sign"></i>
                </div>
                <span class="analytics-change up">
                    <i class="fas fa-arrow-up"></i> {{ number_format($analytics['avgBookingValue']) }}
                </span>
            </div>
            <div class="stat-value-new">{{ number_format($totalRevenue, 0) }} <small style="font-size:1rem;color:var(--gray-400)">₪</small></div>
            <div class="stat-label-new">إجمالي الإيرادات</div>
            <div class="mt-2 text-muted small">{{ number_format($todayRevenue) }} ₪ اليوم</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-new">
            <div class="d-flex align-items-center justify-content-between">
                <div class="stat-icon-new" style="background: linear-gradient(135deg, #e0f2fe, #bae6fd); color: #0284c7;">
                    <i class="fas fa-users"></i>
                </div>
                <span class="analytics-change up">
                    <i class="fas fa-arrow-up"></i> {{ $analytics['newCustomers'] }}
                </span>
            </div>
            <div class="stat-value-new">{{ number_format($totalCustomers) }}</div>
            <div class="stat-label-new">العملاء المسجلين</div>
            <div class="mt-2 text-muted small">{{ $analytics['returningCustomers'] }} عميل متكرر</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-new">
            <div class="d-flex align-items-center justify-content-between">
                <div class="stat-icon-new" style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706;">
                    <i class="fas fa-spa"></i>
                </div>
                <span class="badge bg-success rounded-pill">ممتاز</span>
            </div>
            <div class="stat-value-new">{{ number_format($totalServices) }}</div>
            <div class="stat-label-new">الخدمات النشطة</div>
            <div class="mt-2 text-muted small">{{ $totalBookings }} حجز</div>
        </div>
    </div>
</div>

{{-- Booking Status Quick Actions --}}
<div class="row g-2 mb-4">
    <div class="col-6 col-md-3 col-xl">
        <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="order-status-btn d-flex align-items-center gap-3 text-decoration-none">
            <div style="width:4px;height:32px;border-radius:2px;background:#f59e0b;flex-shrink:0;"></div>
            <div>
                <div class="count">{{ $chartData['status']['pending'] }}</div>
                <div class="label">قيد الانتظار</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3 col-xl">
        <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}" class="order-status-btn d-flex align-items-center gap-3 text-decoration-none">
            <div style="width:4px;height:32px;border-radius:2px;background:#3b82f6;flex-shrink:0;"></div>
            <div>
                <div class="count">{{ $chartData['status']['confirmed'] }}</div>
                <div class="label">مؤكد</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3 col-xl">
        <a href="{{ route('admin.bookings.index', ['status' => 'completed']) }}" class="order-status-btn d-flex align-items-center gap-3 text-decoration-none">
            <div style="width:4px;height:32px;border-radius:2px;background:#10b981;flex-shrink:0;"></div>
            <div>
                <div class="count">{{ $chartData['status']['completed'] }}</div>
                <div class="label">مكتمل</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3 col-xl">
        <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}" class="order-status-btn d-flex align-items-center gap-3 text-decoration-none">
            <div style="width:4px;height:32px;border-radius:2px;background:#ef4444;flex-shrink:0;"></div>
            <div>
                <div class="count">{{ $chartData['status']['cancelled'] }}</div>
                <div class="label">ملغي</div>
            </div>
        </a>
    </div>
</div>

{{-- Charts Row --}}
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-line" style="color:var(--pink-600);margin-left:6px;"></i> أداء الحجوزات (30 يوم)</span>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary active" onclick="toggleChart('revenue')">الإيرادات</button>
                    <button class="btn btn-outline-secondary" onclick="toggleChart('bookings')">الحجوزات</button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><i class="fas fa-chart-pie" style="color:var(--pink-600);margin-left:6px;"></i> توزيع حالة الحجوزات</div>
            <div class="card-body">
                <div class="chart-container-sm">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Analytics & Top Services Row --}}
<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-analytics" style="color:var(--pink-600);margin-left:6px;"></i> تحليلات الأداء</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="analytics-card">
                            <div class="analytics-value" style="font-size:1.5rem;">{{ number_format($analytics['avgBookingValue']) }} ₪</div>
                            <div class="analytics-label">متوسط قيمة الحجز</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="analytics-card">
                            <div class="analytics-value" style="font-size:1.5rem;">{{ $analytics['returningCustomers'] }}</div>
                            <div class="analytics-label">العملاء المتكررون</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-chart-bar" style="color:var(--pink-600);margin-left:6px;"></i> حجوزات حسب الخدمة</div>
            <div class="card-body">
                <div class="chart-container-sm">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Top Cities & Recent Bookings --}}
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clock" style="color:var(--pink-600);margin-left:6px;"></i> آخر الحجوزات</span>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-pink">عرض الكل <i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0 table-hover">
                    <thead>
                        <tr>
                            <th>رقم الحجز</th>
                            <th>العميل</th>
                            <th>الخدمة</th>
                            <th>المبلغ</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $booking)
                        <tr>
                            <td class="fw-bold">#{{ $booking->booking_number ?? $booking->id }}</td>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->service->name_ar ?? $booking->service_name }}</td>
                            <td class="fw-bold" style="color:var(--pink-600);">{{ number_format($booking->total_amount, 2) }} ₪</td>
                            <td>
                                @php
                                    $sMap = ['pending'=>['bg'=>'#FEF3C7','c'=>'#92400E','l'=>'قيد الانتظار'],'confirmed'=>['bg'=>'#DBEAFE','c'=>'#1E40AF','l'=>'مؤكد'],'completed'=>['bg'=>'#DCFCE7','c'=>'#16A34A','l'=>'مكتمل'],'cancelled'=>['bg'=>'#FEE2E2','c'=>'#991B1B','l'=>'ملغي']];
                                    $s = $sMap[$booking->status] ?? ['bg'=>'#F1F5F9','c'=>'#475569','l'=>$booking->status];
                                @endphp
                                <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:9999px;font-size:.75rem;font-weight:600;background:{{ $s['bg'] }};color:{{ $s['c'] }};">{{ $s['l'] }}</span>
                            </td>
                            <td class="text-muted small">{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                            <td><a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm" style="color:var(--pink-600);padding:4px 8px;"><i class="fas fa-eye"></i></a></td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-5 text-muted"><i class="fas fa-inbox mb-2" style="font-size:2rem;display:block;opacity:.3;"></i> لا توجد حجوزات بعد.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><i class="fas fa-link" style="color:var(--pink-600);margin-left:6px;"></i> روابط سريعة</div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.services.create') }}" class="btn btn-pink btn-sm"><i class="fas fa-plus"></i> إضافة خدمة جديدة</a>
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-pink btn-sm"><i class="fas fa-newspaper"></i> إضافة مقال جديد</a>
                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-outline-pink btn-sm"><i class="fas fa-ticket"></i> إضافة كوبون خصم</a>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-pink btn-sm"><i class="fas fa-spa"></i> إدارة الخدمات</a>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-pink btn-sm"><i class="fas fa-newspaper"></i> إدارة المقالات</a>
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

const ctx = document.getElementById('mainChart').getContext('2d');
const mainChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartData['labels']) !!},
        datasets: [{
            label: 'الإيرادات (₪)',
            data: {!! json_encode($chartData['revenue']) !!},
            borderColor: '#db2777',
            backgroundColor: 'rgba(219, 39, 119, 0.1)',
            fill: true,
            tension: 0.4,
            yAxisID: 'y'
        }, {
            label: 'الحجوزات',
            data: {!! json_encode($chartData['bookings']) !!},
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
        plugins: {
            legend: { position: 'top', rtl: true },
            tooltip: {
                rtl: true,
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) label += ': ';
                        if (context.dataset.yAxisID === 'y') {
                            label += new Intl.NumberFormat('ar-SA').format(context.raw) + ' ₪';
                        } else {
                            label += context.raw;
                        }
                        return label;
                    }
                }
            }
        },
        scales: {
            x: { grid: { display: false } },
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                grid: { color: '#f1f5f9' },
                ticks: { callback: function(value) { return value + ' ₪'; } }
            },
            y1: {
                type: 'linear',
                display: false,
                position: 'right',
                grid: { display: false }
            }
        }
    }
});

function toggleChart(type) {
    if (type === 'revenue') {
        mainChart.data.datasets[0].hidden = false;
        mainChart.data.datasets[1].hidden = true;
    } else {
        mainChart.data.datasets[0].hidden = true;
        mainChart.data.datasets[1].hidden = false;
    }
    mainChart.update();
    event.target.parentElement.querySelectorAll('button').forEach(function(btn) { btn.classList.remove('active'); });
    event.target.classList.add('active');
}

const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['قيد الانتظار', 'مؤكد', 'مكتمل', 'ملغي'],
        datasets: [{
            data: [
                {{ $chartData['status']['pending'] }},
                {{ $chartData['status']['confirmed'] }},
                {{ $chartData['status']['completed'] }},
                {{ $chartData['status']['cancelled'] }}
            ],
            backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', rtl: true, labels: { padding: 20, usePointStyle: true } }
        },
        cutout: '65%'
    }
});

const categoryCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(categoryCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartData['serviceBookings']->keys()) !!},
        datasets: [{
            label: 'الحجوزات',
            data: {!! json_encode($chartData['serviceBookings']->values()) !!},
            backgroundColor: 'rgba(219, 39, 119, 0.8)',
            borderRadius: 6,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: { grid: { color: '#f1f5f9' } }
        }
    }
});
</script>
@endpush
