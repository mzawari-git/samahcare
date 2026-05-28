@extends('admin.layouts.app')

@section('title', 'Everything Professional')

@push('extra-styles')
<style>
    .meta-tabs .nav-link {
        color: var(--gray-600); font-weight: 600; font-size: .85rem;
        padding: .75rem 1.25rem; border: none;
        border-bottom: 3px solid transparent; transition: all .2s;
    }
    .meta-tabs .nav-link:hover { color: var(--gray-900); border-bottom-color: var(--gray-300); }
    .meta-tabs .nav-link.active { color: var(--pink-600); border-bottom-color: var(--pink-600); }
    .page-card {
        background: #fff; border-radius: 14px; padding: 1.25rem;
        border: 1px solid var(--gray-200); transition: all .2s;
        display: flex; align-items: center; gap: 1rem;
    }
    .page-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.06); }
    .page-card .page-avatar {
        width: 48px; height: 48px; border-radius: 50%;
        background: var(--gray-100); overflow: hidden; flex-shrink: 0;
    }
    .page-card .page-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .webhook-url-box {
        background: var(--gray-800); color: #a5f3fc;
        border-radius: 10px; padding: .85rem 1rem;
        font-family: 'Courier New', monospace; font-size: .75rem;
        word-break: break-all; position: relative;
    }
    .search-result-item {
        padding: .75rem 1rem; border-bottom: 1px solid var(--gray-100);
        transition: background .15s;
    }
    .search-result-item:hover { background: var(--pink-50); }
    .tag-badge {
        display: inline-block; padding: .2rem .65rem;
        border-radius: 20px; font-size: .72rem; font-weight: 600; margin: 2px;
    }
    .stage-hot { background: #FEE2E2; color: #991B1B; }
    .stage-warm { background: #FEF3C7; color: #92400E; }
    .stage-cold { background: #F1F5F9; color: #475569; }
    .stage-engaged { background: #DBEAFE; color: #1E40AF; }
    .stage-new { background: #D1FAE5; color: #065F46; }
    .stage-customer { background: #EDE9FE; color: #5B21B6; }
    .intent-purchase { background: #D1FAE5; color: #065F46; }
    .intent-trust { background: #DBEAFE; color: #1E40AF; }
    .intent-awareness { background: #FEF3C7; color: #92400E; }
    .intent-readiness { background: #E0E7FF; color: #3730A3; }
    .intent-complaint { background: #FEE2E2; color: #991B1B; }
    .stat-meta-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .mini-chart { height: 40px; }
    .mini-chart canvas { width: 100% !important; height: 100% !important; }
    .kpi-up { color: #10b981; }
    .kpi-down { color: #ef4444; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 mb-1">
            <i class="fas fa-rocket" style="color:var(--pink-600);margin-left:8px;"></i>
            Everything Professional
        </h1>
        <p class="text-muted small mb-0">Meta Marketing Automation + Commerce Intelligence — بيانات حية من متجرك</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-pink btn-sm" onclick="refreshStats()">
            <i class="fas fa-sync-alt"></i> تحديث
        </button>
        <a href="{{ route('admin.marketing.index') }}" class="btn btn-pink btn-sm">
            <i class="fas fa-cog"></i> إعدادات التتبع
        </a>
    </div>
</div>

{{-- Row 1: Main KPIs --}}
<div class="row g-3 mb-3">
    <div class="col-md-2">
        <div class="stat-card-new">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="stat-meta-icon" style="background:#1877F2;color:#fff;"><i class="fas fa-shopping-bag"></i></div>
            </div>
            <div class="stat-value-new" style="font-size:1.4rem;">{{ number_format($realStats['total_orders']) }}</div>
            <div class="stat-label-new">إجمالي الطلبات</div>
            <small class="text-muted" style="font-size:.7rem;">اليوم: +{{ $realStats['orders_today'] }}</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card-new">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="stat-meta-icon" style="background:#10B981;color:#fff;"><i class="fas fa-dollar-sign"></i></div>
            </div>
            <div class="stat-value-new" style="font-size:1.4rem;">{{ number_format($realStats['total_revenue'], 0) }} ILS</div>
            <div class="stat-label-new">إجمالي الإيرادات</div>
            <small class="text-muted" style="font-size:.7rem;">اليوم: {{ number_format($realStats['revenue_today'], 0) }} ILS</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card-new">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="stat-meta-icon" style="background:var(--pink-500);color:#fff;"><i class="fas fa-plug"></i></div>
            </div>
            <div class="stat-value-new" style="font-size:1.4rem;">{{ $realStats['capi_tracked'] }}</div>
            <div class="stat-label-new">CAPI تم تتبعه</div>
            @if($realStats['capi_untracked'] > 0)
                <small class="text-warning" style="font-size:.7rem;">{{ $realStats['capi_untracked'] }} غير متتبع</small>
            @else
                <small class="kpi-up" style="font-size:.7rem;">الكل متزامن</small>
            @endif
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card-new">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="stat-meta-icon" style="background:#8B5CF6;color:#fff;"><i class="fas fa-users"></i></div>
            </div>
            <div class="stat-value-new" style="font-size:1.4rem;">{{ number_format($realStats['total_users']) }}</div>
            <div class="stat-label-new">المستخدمين</div>
            <small class="text-muted" style="font-size:.7rem;">الأسبوع: +{{ $realStats['users_week'] }}</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card-new">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="stat-meta-icon" style="background:#f59e0b;color:#fff;"><i class="fas fa-percent"></i></div>
            </div>
            <div class="stat-value-new" style="font-size:1.4rem;">{{ $realStats['conversion_rate'] }}%</div>
            <div class="stat-label-new">معدل التحويل</div>
            <small class="text-muted" style="font-size:.7rem;">AOV: {{ number_format($realStats['avg_order_value'], 0) }} ILS</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card-new">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="stat-meta-icon" style="background:#0891b2;color:#fff;"><i class="fab fa-facebook"></i></div>
            </div>
            <div class="stat-value-new" style="font-size:1.4rem;">{{ $pages->where('webhook_subscribed', true)->count() }}/{{ $pages->count() }}</div>
            <div class="stat-label-new">Meta Pages</div>
            <small class="text-muted" style="font-size:.7rem;">{{ \Modules\Meta\Models\MetaWebhookLog::whereDate('created_at', today())->count() }} webhooks اليوم</small>
        </div>
    </div>
</div>

{{-- Row 2: Funnel + Top Products --}}
<div class="row g-3 mb-4">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header fw-bold small"><i class="fas fa-filter" style="color:var(--pink-600);margin-left:6px;"></i> مسار التحويل الفعلي</div>
            <div class="card-body">
                @php
                    $maxFunnel = max($funnelData['product_views'] ?: 1, $funnelData['add_to_cart'] ?: 1, $funnelData['checkout'] ?: 1, $funnelData['purchases'] ?: 1);
                @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1" style="font-size:.8rem;">
                        <span>Product Views</span>
                        <span class="fw-bold">{{ $funnelData['product_views'] }}</span>
                    </div>
                    <div class="progress-thin">
                        <div class="progress-bar" style="width:{{ ($funnelData['product_views']/$maxFunnel)*100 }}%;background:linear-gradient(90deg,#1877F2,#3b82f6);"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1" style="font-size:.8rem;">
                        <span>Add to Cart</span>
                        <span class="fw-bold">{{ $funnelData['add_to_cart'] }}</span>
                    </div>
                    <div class="progress-thin">
                        <div class="progress-bar" style="width:{{ ($funnelData['add_to_cart']/$maxFunnel)*100 }}%;background:linear-gradient(90deg,#f59e0b,#d97706);"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1" style="font-size:.8rem;">
                        <span>Checkout</span>
                        <span class="fw-bold">{{ $funnelData['checkout'] }}</span>
                    </div>
                    <div class="progress-thin">
                        <div class="progress-bar" style="width:{{ ($funnelData['checkout']/$maxFunnel)*100 }}%;background:linear-gradient(90deg,#ec4899,#db2777);"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-1" style="font-size:.8rem;">
                        <span>Purchases</span>
                        <span class="fw-bold">{{ $funnelData['purchases'] }}</span>
                    </div>
                    <div class="progress-thin">
                        <div class="progress-bar" style="width:{{ ($funnelData['purchases']/$maxFunnel)*100 }}%;background:linear-gradient(90deg,#10b981,#059669);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header fw-bold small"><i class="fas fa-trophy" style="color:#f59e0b;margin-left:6px;"></i> أفضل المنتجات مبيعاً</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light small"><tr><th>المنتج</th><th class="text-center">مباع</th><th class="text-center">السعر</th></tr></thead>
                    <tbody>
                        @forelse($topProducts as $p)
                        <tr>
                            <td class="small">{{ $p['name'] }}</td>
                            <td class="text-center fw-bold small">{{ $p['sold'] }}</td>
                            <td class="text-center small">{{ number_format($p['price'], 0) }} ILS</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted small py-3">لا توجد مبيعات بعد</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card h-100">
            <div class="card-header fw-bold small"><i class="fas fa-plug" style="color:var(--pink-600);margin-left:6px;"></i> Meta + Commerce Sync</div>
            <div class="card-body">
                @php
                    $capiTotal = $realStats['capi_tracked'] + $realStats['capi_untracked'];
                    $capiPct = $capiTotal > 0 ? round(($realStats['capi_tracked'] / $capiTotal) * 100) : 0;
                @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Pixel {{ $settings['facebook']['enabled'] ? 'مفعل' : 'معطل' }}</span>
                        <span class="badge bg-{{ $settings['facebook']['enabled'] ? 'success' : 'secondary' }}">{{ $settings['facebook']['enabled'] ? 'ON' : 'OFF' }}</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-1">
                        <span>CAPI (Server)</span>
                        <span class="badge bg-{{ $settings['facebook']['capi_enabled'] ? 'success' : 'secondary' }}">{{ $settings['facebook']['capi_enabled'] ? 'ON' : 'OFF' }}</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-1">
                        <span>CAPI تتبع المبيعات</span>
                        <span class="fw-bold {{ $capiPct >= 90 ? 'kpi-up' : 'text-warning' }}">{{ $capiPct }}%</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-1">
                        <span>TikTok</span>
                        <span class="badge bg-{{ $settings['tiktok']['enabled'] ? 'success' : 'secondary' }}">{{ $settings['tiktok']['enabled'] ? 'ON' : 'OFF' }}</span>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span>Webhook Pages</span>
                        <span class="fw-bold">{{ $pages->where('webhook_subscribed', true)->count() }}</span>
                    </div>
                </div>

                @if($realStats['capi_untracked'] > 0)
                <button class="btn btn-outline-pink btn-sm w-100" onclick="retryFailedCAPI()">
                    <i class="fas fa-redo"></i> إعادة إرسال {{ $realStats['capi_untracked'] }} طلب غير متتبع
                </button>
                <div id="capi-alert" class="mt-2"></div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Row 3: Recent Orders --}}
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header fw-bold small d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clock" style="color:var(--pink-600);margin-left:6px;"></i> آخر الطلبات — تتبع التحويلات</span>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-pink btn-xs py-0 px-2" style="font-size:.7rem;">كل الطلبات</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th>رقم الطلب</th><th>العميل</th><th class="text-center">المبلغ</th>
                                <th class="text-center">الحالة</th><th class="text-center">CAPI</th><th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr style="font-size:.78rem;">
                                <td><a href="{{ route('admin.orders.show', $order['id']) }}" class="fw-bold text-decoration-none">#{{ $order['order_number'] }}</a></td>
                                <td>{{ $order['customer'] }}</td>
                                <td class="text-center fw-bold">{{ number_format($order['total'], 0) }} ILS</td>
                                <td class="text-center">
                                    @php
                                        $statusColors = [
                                            'pending'=>'warning','confirmed'=>'info','processing'=>'primary',
                                            'packaging'=>'info','ready_for_pickup'=>'info','out_for_delivery'=>'primary',
                                            'delivered'=>'success','cancelled'=>'danger','refunded'=>'secondary','on_hold'=>'warning'
                                        ];
                                        $statusLabels = [
                                            'pending'=>'قيد الانتظار','confirmed'=>'مؤكد','processing'=>'قيد المعالجة',
                                            'packaging'=>'تغليف','ready_for_pickup'=>'جاهز','out_for_delivery'=>'خارج للتوصيل',
                                            'delivered'=>'تم التوصيل','cancelled'=>'ملغي','refunded'=>'مسترجع','on_hold'=>'معلق'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$order['status']] ?? 'secondary' }}">{{ $statusLabels[$order['status']] ?? $order['status'] }}</span>
                                </td>
                                <td class="text-center">
                                    @if($order['capi_sent'])
                                        <i class="fas fa-check-circle kpi-up" title="CAPI tracked"></i>
                                    @else
                                        <i class="fas fa-times-circle text-muted" title="Not tracked"></i>
                                    @endif
                                </td>
                                <td><small>{{ \Carbon\Carbon::parse($order['created_at'])->diffForHumans() }}</small></td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted small py-3">لا توجد طلبات بعد</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Meta Tabs --}}
<div class="card mb-4">
    <div class="card-header p-0">
        <ul class="nav nav-tabs meta-tabs px-3 pt-2" id="metaTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-pages" type="button">
                    <i class="fab fa-facebook"></i> Meta Pages
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-search" type="button">
                    <i class="fas fa-search"></i> بحث متقدم
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-leads" type="button">
                    <i class="fas fa-star"></i> تقييم العملاء
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-retargeting" type="button">
                    <i class="fas fa-bullseye"></i> إعادة الاستهداف
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-settings" type="button">
                    <i class="fas fa-cog"></i> الـ Webhook
                </button>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="metaTabContent">

            <div class="tab-pane fade show active" id="tab-pages">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle" style="color:var(--pink-600);margin-left:6px;"></i> ربط صفحة فيسبوك جديدة</h6>
                        <div class="border rounded-3 p-3">
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Facebook Page ID</label>
                                <input type="text" class="form-control" id="importPageId" placeholder="أدخل معرف الصفحة...">
                                <small class="text-muted">من إعدادات الصفحة → معلومات الصفحة</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Page Access Token (اختياري)</label>
                                <input type="password" class="form-control" id="importAccessToken" placeholder="EAAxxxxxxxxxxxxx">
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="subscribeWebhook" checked>
                                <label class="form-check-label small" for="subscribeWebhook">تفعيل Webhook تلقائياً</label>
                            </div>
                            <button class="btn btn-pink w-100" onclick="importPage()">
                                <i class="fas fa-link"></i> ربط الصفحة
                            </button>
                            <div id="import-alert" class="mt-2"></div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <h6 class="fw-bold mb-3"><i class="fas fa-list" style="color:var(--pink-600);margin-left:6px;"></i> الصفحات المتصلة ({{ $pages->count() }})</h6>
                        <div id="pages-list">
                            @forelse($pages as $page)
                            <div class="page-card mb-2" id="page-{{ $page->id }}">
                                <div class="page-avatar">
                                    @if($page->page_picture_url)
                                        <img src="{{ $page->page_picture_url }}" alt="{{ $page->page_name }}">
                                    @else
                                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#1877F2;color:#fff;">{{ mb_substr($page->page_name, 0, 1) }}</div>
                                    @endif
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div class="fw-bold">{{ $page->page_name }}</div>
                                    <small class="text-muted">ID: {{ $page->page_id }}</small>
                                    <div class="d-flex gap-1 mt-1">
                                        @if($page->webhook_subscribed)<span class="badge bg-success">Webhook مفعل</span>@endif
                                        <span class="badge bg-light text-dark">{{ $page->conversations_count }} محادثة</span>
                                        <span class="badge bg-light text-dark">{{ $page->webhook_logs_count }} سجل</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.meta-marketing.conversations', ['page_id' => $page->page_id]) }}" class="btn btn-sm btn-outline-pink"><i class="fas fa-comments"></i></a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deletePage({{ $page->id }})"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-plug fa-2x mb-2 d-block" style="opacity:.3;"></i>
                                لا توجد صفحات متصلة. قم بربط صفحة فيسبوك أولاً.
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-search">
                <div class="row g-4">
                    <div class="col-12">
                        <h6 class="fw-bold mb-3"><i class="fas fa-search" style="color:var(--pink-600);margin-left:6px;"></i> بحث متقدم في صفحة فيسبوك</h6>
                        <div class="border rounded-3 p-3">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small">اختر الصفحة</label>
                                    <select class="form-control" id="searchPageId">
                                        <option value="">-- اختر صفحة --</option>
                                        @foreach($pages as $page)
                                            <option value="{{ $page->page_id }}">{{ $page->page_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small">نوع البحث</label>
                                    <select class="form-control" id="searchType">
                                        <option value="all">الكل</option>
                                        <option value="comments">التعليقات</option>
                                        <option value="psid">PSID</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-bold small">كلمة البحث / PSID</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="searchQuery" placeholder="ابحث...">
                                        <button class="btn btn-pink" onclick="searchPage()"><i class="fas fa-search"></i> بحث</button>
                                    </div>
                                </div>
                            </div>
                            <div id="search-alert" class="mt-2"></div>
                            <div id="search-results" class="mt-3" style="max-height:500px;overflow-y:auto;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-leads">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <h6 class="fw-bold mb-3">نظام تقييم العملاء (Live Scoring)</h6>
                        <table class="table table-sm table-bordered">
                            <thead class="table-light"><tr><th>السلوك</th><th class="text-center">النقاط</th><th>التصنيف</th></tr></thead>
                            <tbody>
                                <tr><td>مشاهدة المنتج ×3</td><td class="text-center">+20</td><td><span class="badge bg-warning">Warm</span></td></tr>
                                <tr><td>إضافة للسلة</td><td class="text-center">+40</td><td><span class="badge bg-danger">Hot</span></td></tr>
                                <tr><td>فتح الماسنجر</td><td class="text-center">+25</td><td><span class="badge bg-warning">Engaged</span></td></tr>
                                <tr><td>الرد على الرسائل</td><td class="text-center">+30</td><td><span class="badge bg-danger">Hot</span></td></tr>
                                <tr><td>تجاهل الرسائل</td><td class="text-center text-danger">-10</td><td><span class="badge bg-secondary">Cold</span></td></tr>
                                <tr><td>زيارة الدفع</td><td class="text-center">+50</td><td><span class="badge bg-danger">Hot</span></td></tr>
                                <tr><td>شراء</td><td class="text-center">+100</td><td><span class="badge bg-success">Customer</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <h6 class="fw-bold mb-3">توزيع العملاء</h6>
                        <div class="row g-2 mb-3">
                            <div class="col-3"><div class="border rounded-3 p-2 text-center" style="background:#fee2e2;"><div class="fw-bold" style="font-size:1.3rem;color:#991b1b;">{{ $leadStats['hot'] }}</div><small class="fw-bold" style="color:#991b1b;">Hot</small></div></div>
                            <div class="col-3"><div class="border rounded-3 p-2 text-center" style="background:#fef3c7;"><div class="fw-bold" style="font-size:1.3rem;color:#92400e;">{{ $leadStats['warm'] }}</div><small class="fw-bold" style="color:#92400e;">Warm</small></div></div>
                            <div class="col-3"><div class="border rounded-3 p-2 text-center" style="background:#f1f5f9;"><div class="fw-bold" style="font-size:1.3rem;color:#475569;">{{ $leadStats['cold'] }}</div><small class="fw-bold" style="color:#475569;">Cold</small></div></div>
                            <div class="col-3"><div class="border rounded-3 p-2 text-center" style="background:#d1fae5;"><div class="fw-bold" style="font-size:1.3rem;color:#065f46;">{{ $leadStats['engaged'] + $leadStats['new'] }}</div><small class="fw-bold" style="color:#065f46;">New</small></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-retargeting">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <h6 class="fw-bold mb-3">سيناريوهات إعادة الاستهداف</h6>
                        <table class="table table-sm table-bordered">
                            <thead class="table-light"><tr><th>السيناريو</th><th>الإجراء</th></tr></thead>
                            <tbody>
                                <tr><td>مشاهدة المنتج مرتين</td><td>إعلان مراجعات وتقييمات</td></tr>
                                <tr><td>دخول الدفع والخروج</td><td>عرض محدود بخصم خاص</td></tr>
                                <tr><td>ترك السلة</td><td>تذكير متعدد القنوات</td></tr>
                                <tr><td>فتح الرسالة ولم يرد</td><td>متابعة بقناة مختلفة</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <h6 class="fw-bold mb-3">الجماهير — من بياناتك الحقيقية</h6>
                        <div class="border rounded-3 p-3 mb-2">
                            <small class="fw-bold">جمهور المشترين (Custom Audience)</small>
                            <div class="fw-bold" style="font-size:1.2rem;">{{ $realStats['total_orders'] }} <small class="text-muted">طلبات</small></div>
                        </div>
                        <div class="border rounded-3 p-3 mb-2">
                            <small class="fw-bold">جمهور الموقع (Website Visitors)</small>
                            <div class="fw-bold" style="font-size:1.2rem;">{{ $realStats['total_users'] }} <small class="text-muted">مستخدم</small></div>
                        </div>
                        <div class="border rounded-3 p-3">
                            <small class="fw-bold">CAPI Tracked Events (Ready for Lookalike)</small>
                            <div class="fw-bold" style="font-size:1.2rem;">{{ $realStats['capi_tracked'] }} <small class="text-muted">حدث</small></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-settings">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <h6 class="fw-bold mb-3">Webhook Configuration</h6>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Endpoint URL</label>
                            <div class="webhook-url-box">
                                {{ route('api.meta.webhook', [], false) }}
                                <button class="btn btn-sm btn-light" style="position:absolute;top:8px;left:8px;" onclick="navigator.clipboard.writeText('{{ route('api.meta.webhook', [], false) }}').then(()=>{this.textContent='Copied!';setTimeout(()=>{this.textContent='Copy';},2000)})">Copy</button>
                            </div>
                            <small class="text-muted">Facebook Developers → Webhooks → Callback URL</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Verify Token</label>
                            <input type="text" class="form-control" readonly value="jenincare_meta_verify" style="font-family:monospace;">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h6 class="fw-bold mb-3">النظام — حالة حية</h6>
                        <ul class="list-group small">
                            <li class="list-group-item d-flex justify-content-between">
                                Facebook Pixel <span class="badge bg-{{ $settings['facebook']['enabled'] ? 'success' : 'secondary' }}">{{ $settings['facebook']['enabled'] ? 'ON' : 'OFF' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                CAPI Server-Side <span class="badge bg-{{ $settings['facebook']['capi_enabled'] ? 'success' : 'secondary' }}">{{ $settings['facebook']['capi_enabled'] ? 'ON' : 'OFF' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                TikTok Pixel <span class="badge bg-{{ $settings['tiktok']['enabled'] ? 'success' : 'secondary' }}">{{ $settings['tiktok']['enabled'] ? 'ON' : 'OFF' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                Pages Connected <span class="fw-bold">{{ $pages->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                Webhook Active <span class="fw-bold">{{ $pages->where('webhook_subscribed', true)->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                CAPI Synced Orders
                                <span class="fw-bold {{ $capiPct >= 90 ? 'kpi-up' : 'text-warning' }}">{{ $capiPct }}%</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name=csrf-token]')?.content || '';
const BASE = '{{ url('') }}';

function alertMsg(elId, msg, type) {
    const el = document.getElementById(elId);
    if (!el) return;
    el.innerHTML = `<div class="alert alert-${type} py-2 px-3 mb-0 rounded-3 small">${msg}</div>`;
    setTimeout(() => el.innerHTML = '', 5000);
}

function importPage() {
    const pageId = document.getElementById('importPageId').value.trim();
    const accessToken = document.getElementById('importAccessToken').value.trim();
    const subscribe = document.getElementById('subscribeWebhook').checked;
    if (!pageId) return alertMsg('import-alert', 'الرجاء إدخال معرف الصفحة', 'warning');
    const btn = event.target; btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> جارٍ الربط...';
    fetch('{{ route("admin.meta-marketing.import-page") }}', {
        method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify({ page_id:pageId, access_token:accessToken||null, subscribe_webhook:subscribe })
    }).then(r=>r.json()).then(d=>{
        btn.disabled=false; btn.innerHTML='<i class="fas fa-link"></i> ربط الصفحة';
        if(d.success){ alertMsg('import-alert',d.message,'success'); setTimeout(()=>location.reload(),1200); }
        else alertMsg('import-alert',d.message||'فشل الربط','danger');
    }).catch(()=>{ btn.disabled=false; btn.innerHTML='<i class="fas fa-link"></i> ربط الصفحة'; alertMsg('import-alert','خطأ في الاتصال','danger'); });
}

function searchPage() {
    const pageId = document.getElementById('searchPageId').value;
    const query = document.getElementById('searchQuery').value.trim();
    const type = document.getElementById('searchType').value;
    if (!pageId) return alertMsg('search-alert','اختر صفحة','warning');
    const div = document.getElementById('search-results');
    div.innerHTML = '<div class="text-center py-3"><div class="spinner-border spinner-border-sm"></div> جارٍ البحث...</div>';
    fetch('{{ route("admin.meta-marketing.search-page") }}', {
        method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify({page_id:pageId, query:query, type:type})
    }).then(r=>r.json()).then(d=>{
        if(!d.success){ div.innerHTML=`<div class="alert alert-danger">${d.message}</div>`; return; }
        let h=''; const r=d.results;
        if(r.comments&&r.comments.data){ h+=`<h6 class="fw-bold mb-2 small">تعليقات (${r.comments.data.length})</h6>`;
            if(!r.comments.data.length) h+='<small class="text-muted">لا توجد نتائج</small>';
            r.comments.data.forEach(i=>{ h+=`<div class="search-result-item"><div class="fw-bold small">${i.from_name}</div><div class="small">${i.comment_message||i.post_message||'-'}</div></div>`; }); }
        if(r.psid&&r.psid.user){ h+=`<h6 class="fw-bold mt-2 mb-2 small">PSID</h6><div class="search-result-item"><div class="fw-bold">${r.psid.user.name||'Unknown'} (${r.psid.user.id})</div></div>`;
            if(r.psid.conversation){ const c=r.psid.conversation; h+=`<div class="mt-2 p-2 border rounded small">Score: <b>${c.lead_score}</b> | Stage: <span class="tag-badge stage-${c.stage||'new'}">${c.stage}</span> | Intent: <span class="tag-badge intent-${c.intent||'general'}">${c.intent||'general'}</span></div>`; } }
        if(r.conversations){ h+=`<h6 class="fw-bold mt-2 mb-2 small">محادثات</h6>`; r.conversations.forEach(c=>{ h+=`<div class="search-result-item small">${c.sender_name||c.psid} — <span class="tag-badge stage-${c.stage}">${c.stage}</span> Score: ${c.lead_score}</div>`; }); }
        div.innerHTML=h||'<small class="text-muted">لا توجد نتائج</small>';
    }).catch(()=>{ div.innerHTML='<div class="alert alert-danger">خطأ في الاتصال</div>'; });
}

function deletePage(id) {
    if(!confirm('حذف الصفحة؟')) return;
    fetch(`${BASE}/admin/meta-marketing/pages/${id}`, { method:'DELETE', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF} })
    .then(r=>r.json()).then(d=>{ if(d.success){ document.getElementById('page-'+id)?.remove(); location.reload(); } });
}

function retryFailedCAPI() {
    fetch('{{ url("/admin/marketing/retry-failed") }}')
    .then(r=>r.json()).then(d=>{ alertMsg('capi-alert', d.message||'Done', d.success?'success':'danger'); if(d.success) setTimeout(()=>location.reload(),1500); });
}

function refreshStats() {
    fetch('{{ route("admin.meta-marketing.stats") }}').then(r=>r.json()).then(d=>{ location.reload(); });
}

document.getElementById('searchQuery')?.addEventListener('keydown', function(e){ if(e.key==='Enter') searchPage(); });
</script>
@endpush
