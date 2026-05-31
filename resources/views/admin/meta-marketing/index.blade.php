@extends('admin.layouts.app')
@section('title', 'التسويق عبر ميتا')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h4 mb-1"><i class="fas fa-rocket" style="color:var(--pink-600);margin-left:8px;"></i> منصة التسويق المتكاملة</h1>
        <p class="text-muted small mb-0">Meta Marketing Hub — أداء الحملات، CAPI، والإيرادات في لوحة واحدة</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.diagnostics.index') }}" class="btn btn-sm btn-outline-pink"><i class="fas fa-stethoscope"></i> تشخيص CAPI</a>
        <a href="{{ route('admin.ads.dashboard') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-ad"></i> إدارة الإعلانات</a>
        <a href="{{ route('admin.roas.index') }}" class="btn btn-sm btn-outline-success"><i class="fas fa-chart-bar"></i> True ROAS</a>
    </div>
</div>

{{-- Row 1: KPI Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card-new">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="text-muted small">الإيرادات (30 يوم)</span>
                <i class="fas fa-dollar-sign text-success"></i>
            </div>
            <div class="stat-value-new">{{ number_format($overview['total_revenue'], 0) }} <small class="text-muted" style="font-size:.7rem;font-weight:400;">₪</small></div>
            <div class="d-flex justify-content-between small mt-1">
                <span class="text-muted">الطلبات: {{ $overview['total_orders'] }}</span>
                <span class="text-muted">AOV: {{ number_format($overview['aov'], 0) }} ₪</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card-new">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="text-muted small">ROAS</span>
                <i class="fas fa-chart-line text-primary"></i>
            </div>
            <div class="stat-value-new" style="color:{{ $overview['roas'] >= 2 ? '#10B981' : ($overview['roas'] >= 1 ? '#F59E0B' : '#EF4444') }};">{{ $overview['roas'] }}<small style="font-size:.7rem;">x</small></div>
            <div class="small text-muted mt-1">مصاريف: {{ number_format($overview['total_spend'], 0) }} ₪</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card-new">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="text-muted small">CAPI</span>
                <i class="fas fa-server text-info"></i>
            </div>
            <div class="stat-value-new">{{ $overview['capi_events'] }}</div>
            <div class="d-flex justify-content-between small mt-1">
                <span class="text-success">ناجح: {{ $overview['capi_success_rate'] }}%</span>
                <span class="text-muted">شراء: {{ $overview['purchase_events'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card-new">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="text-muted small">الحملات</span>
                <i class="fas fa-bullhorn text-warning"></i>
            </div>
            <div class="stat-value-new">{{ $overview['active_campaigns'] }} <small class="text-muted" style="font-size:.7rem;font-weight:400;">/ {{ $overview['total_campaigns'] }}</small></div>
            <div class="small text-muted mt-1">حسابات متصلة: {{ $overview['connected_accounts'] }}</div>
        </div>
    </div>
</div>

{{-- Row 2: Revenue Trend + CAPI Trend --}}
<div class="row g-3 mb-4">
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-line" style="color:var(--pink-600);margin-left:6px;"></i> اتجاه الإيرادات (30 يوم)</span>
                <span class="small text-muted">الإجمالي: {{ number_format($overview['total_revenue'], 0) }} ₪</span>
            </div>
            <div class="card-body">
                <div id="revenueChart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header"><i class="fas fa-heartbeat" style="color:var(--pink-600);margin-left:6px;"></i> صحة المنصات</div>
            <div class="card-body" id="healthScoresContainer">
                @php
                    $platformLabels = [
                        'facebook' => ['label' => 'فيسبوك', 'icon' => 'fab fa-facebook', 'color' => '#1877F2'],
                        'tiktok' => ['label' => 'تيك توك', 'icon' => 'fab fa-tiktok', 'color' => '#000000'],
                        'google' => ['label' => 'جوجل', 'icon' => 'fab fa-google', 'color' => '#EA4335'],
                        'snapchat' => ['label' => 'سناب شات', 'icon' => 'fab fa-snapchat', 'color' => '#FFFC00'],
                        'pinterest' => ['label' => 'بنترست', 'icon' => 'fab fa-pinterest', 'color' => '#E60023'],
                        'twitter' => ['label' => 'تويتر', 'icon' => 'fab fa-twitter', 'color' => '#1DA1F2'],
                        'linkedin' => ['label' => 'لينكد إن', 'icon' => 'fab fa-linkedin', 'color' => '#0A66C2'],
                    ];
                @endphp
                @forelse($healthScores as $platform => $score)
                    @php $p = $platformLabels[$platform] ?? ['label' => $platform, 'icon' => 'fas fa-cloud', 'color' => '#64748B']; @endphp
                    <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                        <i class="{{ $p['icon'] }}" style="color:{{ $p['color'] }};width:24px;font-size:1.1rem;"></i>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between small">
                                <span>{{ $p['label'] }}</span>
                                <span class="fw-semibold" style="color:{{ $score['score'] >= 80 ? '#10B981' : ($score['score'] >= 50 ? '#F59E0B' : '#EF4444') }};">{{ $score['score'] }}/100</span>
                            </div>
                            <div class="progress-thin mt-1" style="height:4px;">
                                <div class="progress-bar" style="width:{{ $score['score'] }}%;background:{{ $score['score'] >= 80 ? '#10B981' : ($score['score'] >= 50 ? '#F59E0B' : '#EF4444') }};"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted small py-4">لا توجد بيانات صحة بعد</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Row 3: Booking Status + Hourly Volume --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header"><i class="fas fa-chart-pie" style="color:var(--pink-600);margin-left:6px;"></i> توزيع حالات الحجوزات</div>
            <div class="card-body">
                <div id="bookingStatusChart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header"><i class="fas fa-clock" style="color:var(--pink-600);margin-left:6px;"></i> توزيع أحداث CAPI حسب الساعة (7 أيام)</div>
            <div class="card-body">
                <div id="hourlyVolumeChart"></div>
            </div>
        </div>
    </div>
</div>

{{-- Row 4: Campaign Performance Table --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-bullhorn" style="color:var(--pink-600);margin-left:6px;"></i> أداء الحملات الإعلانية</span>
        <small class="text-muted">{{ count($campaigns) }} حملة</small>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>الحملة</th>
                        <th>الهدف</th>
                        <th>الحالة</th>
                        <th>الميزانية</th>
                        <th>المنصرف</th>
                        <th>الظهور</th>
                        <th>CTR</th>
                        <th>CPC</th>
                        <th>التحويلات</th>
                        <th>CPA</th>
                        <th>ROAS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $c)
                    <tr>
                        <td><span class="fw-semibold small">{{ $c['name'] }}</span></td>
                        <td><span class="badge bg-light text-dark rounded-pill px-2 py-1" style="font-size:.65rem;">{{ $c['objective'] }}</span></td>
                        <td>{!! $c['status'] === 'ACTIVE' ? '<span class="badge bg-success">نشط</span>' : ($c['status'] === 'PAUSED' ? '<span class="badge bg-warning text-dark">متوقف</span>' : '<span class="badge bg-secondary">' . $c['status'] . '</span>') !!}</td>
                        <td><small class="text-muted">{{ $c['daily_budget'] > 0 ? number_format($c['daily_budget'], 0) : '—' }}</small></td>
                        <td><small>{{ number_format($c['spend'], 0) }}</small></td>
                        <td><small>{{ number_format($c['impressions']) }}</small></td>
                        <td><small>{{ $c['ctr'] > 0 ? number_format($c['ctr'], 2) . '%' : '—' }}</small></td>
                        <td><small>{{ $c['cpc'] > 0 ? number_format($c['cpc'], 2) : '—' }}</small></td>
                        <td><small>{{ number_format($c['conversions']) }}</small></td>
                        <td><small>{{ $c['cpa'] > 0 ? number_format($c['cpa'], 0) : '—' }}</small></td>
                        <td><span class="badge bg-{{ $c['roas'] >= 2 ? 'success' : ($c['roas'] >= 1 ? 'warning' : 'danger') }} bg-opacity-10 text-{{ $c['roas'] >= 2 ? 'success' : ($c['roas'] >= 1 ? 'warning' : 'danger') }} px-2 py-1 rounded-pill">{{ $c['roas'] > 0 ? number_format($c['roas'], 2) . 'x' : '—' }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="11" class="text-center text-muted small py-4">لا توجد حملات بعد. قم بربط حساب إعلاني لبدء التتبع.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
(function() {
    var revenueData = @json($revenueTrend);
    var capiData = @json($capiTrend);
    var bookingStatus = @json($bookingStatus);
    var hourlyData = @json($hourlyVolume);

    var revenueOptions = {
        chart: { type: 'area', height: 280, toolbar: { show: false }, fontFamily: 'Tajawal, sans-serif' },
        series: [
            { name: 'الإيرادات', data: revenueData.revenue || [] },
            { name: 'الطلبات', data: revenueData.orders || [] }
        ],
        colors: ['#10B981', '#8B5CF6'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: [2, 2], dashArray: [0, 3] },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.1 } },
        xaxis: { categories: revenueData.labels || [], labels: { show: true, rotate: -45, style: { fontSize: '10px', fontFamily: 'Tajawal' } }, axisBorder: { show: false } },
        yaxis: { labels: { style: { fontSize: '10px' }, formatter: function(v) { return v >= 1000 ? (v/1000).toFixed(1) + 'k' : v; } } },
        grid: { borderColor: '#f1f1f1' },
        tooltip: { y: { formatter: function(v) { return v.toLocaleString() + ' ₪'; } } },
        legend: { position: 'top', labels: { fontFamily: 'Tajawal' } }
    };
    if (document.getElementById('revenueChart')) {
        new ApexCharts(document.getElementById('revenueChart'), revenueOptions).render();
    }

    var statusLabels = Object.keys(bookingStatus);
    var statusValues = Object.values(bookingStatus);
    var statusColors = { pending: '#F59E0B', confirmed: '#3B82F6', completed: '#10B981', cancelled: '#EF4444' };
    var statusPalette = statusLabels.map(function(l) { return statusColors[l] || '#94A3B8'; });

    var bookingOptions = {
        chart: { type: 'donut', height: 280, fontFamily: 'Tajawal, sans-serif' },
        series: statusValues,
        labels: statusLabels.map(function(l) {
            var map = { pending: 'معلق', confirmed: 'مؤكد', completed: 'مكتمل', cancelled: 'ملغي' };
            return map[l] || l;
        }),
        colors: statusPalette,
        stroke: { show: false },
        dataLabels: { enabled: false },
        plotOptions: { pie: { donut: { size: '60%', labels: { show: true, total: { show: true, label: 'الإجمالي', fontFamily: 'Tajawal' } } } } },
        legend: { position: 'bottom', labels: { fontFamily: 'Tajawal' } },
        responsive: [{ breakpoint: 480, options: { chart: { height: 220 }, legend: { position: 'bottom' } } }]
    };
    if (document.getElementById('bookingStatusChart')) {
        new ApexCharts(document.getElementById('bookingStatusChart'), bookingOptions).render();
    }

    var hourlyOptions = {
        chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: 'Tajawal, sans-serif' },
        series: [{ name: 'الأحداث', data: hourlyData.values || [] }],
        colors: ['#8B5CF6'],
        plotOptions: { bar: { borderRadius: 4, columnWidth: '70%', distributed: false } },
        dataLabels: { enabled: false },
        xaxis: { categories: hourlyData.labels || [], labels: { show: true, style: { fontSize: '9px', fontFamily: 'Tajawal' } }, tickPlacement: 'on' },
        yaxis: { labels: { style: { fontSize: '10px' } } },
        grid: { borderColor: '#f1f1f1' },
        tooltip: { y: { formatter: function(v) { return v + ' حدث'; } } }
    };
    if (document.getElementById('hourlyVolumeChart')) {
        new ApexCharts(document.getElementById('hourlyVolumeChart'), hourlyOptions).render();
    }
})();
</script>
@endpush
