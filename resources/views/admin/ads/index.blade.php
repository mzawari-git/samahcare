@extends('admin.layouts.app')
@section('title', 'إدارة الإعلانات')
@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-3"><i class="fas fa-check-circle"></i> {{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-3"><i class="fas fa-exclamation-triangle"></i> {{ session('error') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

@php
    $anyConfigured = false;
    foreach($platforms ?? [] as $p) { if($p['configured']) { $anyConfigured = true; break; } }
@endphp
@if(!$anyConfigured && count($platforms ?? []) > 0)
<div class="alert alert-info mb-3">
    <i class="fas fa-key"></i> <b>لا توجد منصات مهيأة بعد.</b> لإضافة اتصال OAuth بضغطة زر، افتح ملف <code>.env</code> وأزل التعليق عن المفاتيح المطلوبة. مفاتيح Facebook موجودة بالنهاية كقالب جاهز.
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 mb-1"><i class="fas fa-bullhorn" style="color:var(--pink-600);margin-left:8px;"></i> إدارة الإعلانات</h1>
        <p class="text-muted small mb-0">ربط وإدارة حسابات الإعلانات عبر جميع المنصات الاجتماعية</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#manualTokenModal"><i class="fas fa-key"></i> ربط يدوي</button>
        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#connectPlatformModal"><i class="fas fa-link"></i> ربط OAuth</button>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-2 col-6"><div class="stat-card-new"><div class="stat-meta-icon" style="background:#1877F2;color:#fff"><i class="fas fa-plug"></i></div><div class="stat-value-new">{{ $connectedCount ?? 0 }}</div><div class="stat-label-new">حسابات متصلة</div></div></div>
    <div class="col-md-2 col-6"><div class="stat-card-new"><div class="stat-meta-icon" style="background:#8B5CF6;color:#fff"><i class="fas fa-bullhorn"></i></div><div class="stat-value-new">{{ $totalCampaigns ?? 0 }}</div><div class="stat-label-new">الحملات</div></div></div>
    <div class="col-md-2 col-6"><div class="stat-card-new"><div class="stat-meta-icon" style="background:#10B981;color:#fff"><i class="fas fa-play"></i></div><div class="stat-value-new">{{ $activeCount ?? 0 }}</div><div class="stat-label-new">نشطة</div></div></div>
    <div class="col-md-2 col-6"><div class="stat-card-new"><div class="stat-meta-icon" style="background:#f59e0b;color:#fff"><i class="fas fa-pause"></i></div><div class="stat-value-new">{{ $pausedCount ?? 0 }}</div><div class="stat-label-new">متوقفة</div></div></div>
    <div class="col-md-2 col-6"><div class="stat-card-new"><div class="stat-meta-icon" style="background:#6366f1;color:#fff"><i class="fas fa-image"></i></div><div class="stat-value-new">{{ $creatives->count() ?? 0 }}</div><div class="stat-label-new">تصميمات</div></div></div>
    <div class="col-md-2 col-6"><div class="stat-card-new"><div class="stat-meta-icon" style="background:#EC4899;color:#fff"><i class="fas fa-sync-alt"></i></div><div class="stat-value-new"><small>تلقائي</small></div><div class="stat-label-new">مزامنة</div></div></div>
</div>

{{-- Platform Connection Status --}}
<div class="card mb-4">
    <div class="card-header bg-light fw-bold"><i class="fas fa-share-alt" style="color:var(--pink-600);margin-left:6px;"></i> حالة ربط المنصات</div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($platforms ?? [] as $key => $p)
            <div class="col-md-4 col-lg-3">
                <div class="border rounded-3 p-3 text-center h-100">
                    <i class="{{ $p['icon'] }} fa-2x mb-2" style="color:{{ $p['color'] }};"></i>
                    <div class="fw-bold small">{{ $p['name'] }}</div>
                    @if($p['connected'])
                        <span class="badge bg-success"><i class="fas fa-check"></i> متصل</span>
                        <div class="text-muted small mt-1">{{ $p['connected_at'] ? \Carbon\Carbon::parse($p['connected_at'])->diffForHumans() : '' }}</div>
                        <form method="POST" action="{{ route('admin.oauth.disconnect', $key) }}" class="mt-2" onsubmit="return confirm('قطع الاتصال مع {{ $p['name'] }}؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm"><i class="fas fa-unlink"></i> قطع</button>
                        </form>
                    @elseif($p['configured'] && $p['has_oauth'])
                        <a href="{{ route('admin.oauth.redirect', $key) }}" class="btn btn-sm mt-2" style="background:{{ $p['color'] }};color:#fff;">
                            <i class="{{ $p['icon'] }}"></i> ربط
                        </a>
                    @elseif($p['install_mode'])
                        <span class="badge bg-info">تثبيت المتجر</span>
                    @else
                        <span class="badge bg-secondary">مفاتيح مفقودة</span>
                        <div class="text-muted small mt-1" style="font-size:10px;line-height:1.3;">
                            أضف في .env:<br>
                            @if($key === 'meta')META_APP_ID / META_APP_SECRET
                            @elseif($key === 'tiktok')TIKTOK_APP_ID / TIKTOK_APP_SECRET
                            @elseif($key === 'google')GOOGLE_CLIENT_ID / GOOGLE_CLIENT_SECRET
                            @elseif($key === 'snapchat')SNAPCHAT_CLIENT_ID / SNAPCHAT_CLIENT_SECRET
                            @elseif($key === 'pinterest')PINTEREST_APP_ID / PINTEREST_APP_SECRET
                            @elseif($key === 'twitter')TWITTER_CLIENT_ID / TWITTER_CLIENT_SECRET
                            @elseif($key === 'linkedin')LINKEDIN_CLIENT_ID / LINKEDIN_CLIENT_SECRET
                            @else{{ strtoupper($key) }}_CLIENT_ID / {{ strtoupper($key) }}_CLIENT_SECRET
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Connected Meta Accounts --}}
<div class="card mb-4">
    <div class="card-header bg-light fw-bold d-flex justify-content-between align-items-center">
        <span><i class="fab fa-facebook" style="color:#1877F2;margin-left:6px;"></i> حسابات فيسبوك المتصلة</span>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-success" onclick="syncAllCampaigns()"><i class="fas fa-sync-alt"></i> مزامنة الكل</button>
            <a href="{{ route('admin.oauth.redirect', 'meta') }}" class="btn btn-sm btn-primary" style="background:#1877F2;border-color:#1877F2;"><i class="fab fa-facebook"></i> ربط OAuth</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div id="accounts-container">
            @forelse($accounts ?? [] as $acc)
            <div class="border-bottom p-3 d-flex justify-content-between align-items-center" id="account-{{ $acc->id }}">
                <div>
                    <b>{{ $acc->name ?? 'Unnamed' }}</b><br>
                    <span class="text-muted small">ID: {{ $acc->ad_account_id }}</span>
                    <span class="badge bg-{{ $acc->account_status === 'active' ? 'success' : 'secondary' }} ms-2">{{ $acc->account_status }}</span>
                    @if($acc->last_synced_at)<br><span class="text-muted small"><i class="fas fa-clock"></i> آخر مزامنة: {{ $acc->last_synced_at->diffForHumans() }}</span>@endif
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="syncAccount({{ $acc->id }})"><i class="fas fa-sync-alt"></i></button>
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteAccount({{ $acc->id }})"><i class="fas fa-trash"></i></button>
                </div>
            </div>
            @empty
            <p class="text-muted text-center py-4 mb-0">لا توجد حسابات إعلانية متصلة. استخدم زر "ربط OAuth" أو "ربط يدوي".</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Tabs: Campaigns / Creatives --}}
<ul class="nav nav-tabs mb-3" id="adsTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="campaigns-tab" data-bs-toggle="tab" data-bs-target="#campaigns" type="button" role="tab">
            <i class="fas fa-bullhorn"></i> الحملات
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="creatives-tab" data-bs-toggle="tab" data-bs-target="#creatives" type="button" role="tab">
            <i class="fas fa-image"></i> التصميمات الإبداعية
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="insights-tab" data-bs-toggle="tab" data-bs-target="#insightsTab" type="button" role="tab">
            <i class="fas fa-chart-bar"></i> Analytics
        </button>
    </li>
</ul>

<div class="tab-content">
    {{───────────── Campaigns Tab ─────────────}}
    <div class="tab-pane fade show active" id="campaigns" role="tabpanel">
        <div class="card">
            <div class="card-header bg-light fw-bold d-flex justify-content-between align-items-center">
                <span><i class="fas fa-list" style="color:var(--pink-600);margin-left:6px;"></i> الحملات ({{ $totalCampaigns ?? 0 }})</span>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-primary" onclick="openCreateCampaign()"><i class="fas fa-plus"></i> حملة جديدة</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="campaigns-table">
                    <thead class="table-light">
                        <tr>
                            <th style="width:30px"></th>
                            <th>اسم الحملة</th>
                            <th>الحساب</th>
                            <th>الهدف</th>
                            <th>الميزانية</th>
                            <th>الحالة</th>
                            <th>أداء</th>
                            <th style="width:160px">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($campaigns ?? [] as $c)
                        <tr id="campaign-row-{{ $c->id }}" class="campaign-row">
                            <td>
                                <button class="btn btn-sm btn-link p-0 text-muted toggle-expand" onclick="toggleCampaignExpand('{{ $c->id }}')">
                                    <i class="fas fa-chevron-left" id="expand-icon-{{ $c->id }}"></i>
                                </button>
                            </td>
                            <td><b>{{ $c->name }}</b></td>
                            <td><span class="text-muted small">{{ $c->adAccount->name ?? '-' }}</span></td>
                            <td><span class="badge bg-light text-dark">{{ $c->objective ?: '-' }}</span></td>
                            <td>{{ $c->daily_budget ? number_format($c->daily_budget, 2) . ' ' . ($c->adAccount->currency ?? 'ILS') : '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $c->status === 'ACTIVE' ? 'success' : ($c->status === 'PAUSED' ? 'warning text-dark' : 'secondary') }} status-badge">{{ $c->status }}</span>
                            </td>
                            <td class="small" style="min-width:100px">
                                @if($c->insights && count($c->insights) > 0)
                                    @php $ins = $c->insights[0]; @endphp
                                    <span title="{{ number_format($ins['impressions'] ?? 0) }} impressions">{{ number_format($ins['impressions'] ?? 0) }} Imp</span>
                                    <br><span title="{{ $ins['ctr'] ?? 0 }}% CTR">CTR {{ number_format($ins['ctr'] ?? 0, 2) }}%</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-info" onclick="viewCampaignInsights('{{ $c->id }}')" title="تحليلات"><i class="fas fa-chart-bar"></i></button>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="toggleCampaign('{{ $c->id }}')" title="تبديل"><i class="fas fa-{{ $c->status === 'ACTIVE' ? 'pause' : 'play' }}"></i></button>
                                    <button class="btn btn-sm btn-outline-primary" onclick="editCampaign('{{ $c->id }}')" title="تعديل"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-success" onclick="duplicateCampaign('{{ $c->id }}')" title="نسخ"><i class="fas fa-copy"></i></button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteCampaign('{{ $c->id }}')" title="حذف"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr id="campaign-detail-{{ $c->id }}" class="campaign-detail-row d-none">
                            <td colspan="8" class="p-0">
                                <div class="p-3 bg-light" id="campaign-content-{{ $c->id }}">
                                    <div class="text-center py-3">
                                        <span class="spinner-border spinner-border-sm"></span> جاري تحميل المجموعات الإعلانية...
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">لا توجد حملات بعد</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{───────────── Creatives Tab ─────────────}}
    <div class="tab-pane fade" id="creatives" role="tabpanel">
        <div class="card">
            <div class="card-header bg-light fw-bold d-flex justify-content-between align-items-center">
                <span><i class="fas fa-image" style="color:var(--pink-600);margin-left:6px;"></i> التصميمات الإبداعية</span>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createCreativeModal"><i class="fas fa-plus"></i> تصميم جديد</button>
            </div>
            <div class="card-body">
                @if(($creatives ?? [])->count() > 0)
                <div class="row g-3" id="creatives-grid">
                    @foreach($creatives ?? [] as $cr)
                    <div class="col-md-4 col-lg-3" id="creative-card-{{ $cr->id }}">
                        <div class="card h-100 shadow-sm">
                            @if($cr->image_hash)
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height:160px;background:#f0f0f0;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                                <small class="text-muted d-block mt-1">{{ $cr->image_hash }}</small>
                            </div>
                            @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:160px;">
                                <i class="fas fa-ad fa-3x text-muted"></i>
                            </div>
                            @endif
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 small">{{ $cr->name }}</h6>
                                @if($cr->title)<p class="card-text small text-muted mb-1">{{ \Str::limit($cr->title, 40) }}</p>@endif
                                <span class="badge bg-{{ $cr->status === 'active' ? 'success' : 'secondary' }}">{{ $cr->status }}</span>
                                <span class="badge bg-info">{{ $cr->call_to_action ?: 'بدون CTA' }}</span>
                            </div>
                            <div class="card-footer bg-transparent p-2 d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary flex-fill" onclick="editCreative({{ $cr->id }})"><i class="fas fa-edit"></i></button>
                                @if($cr->status === 'draft' && $cr->ad_account_id)
                                <button class="btn btn-sm btn-outline-success flex-fill" onclick="publishCreative({{ $cr->id }})"><i class="fas fa-upload"></i></button>
                                @endif
                                <button class="btn btn-sm btn-outline-danger flex-fill" onclick="deleteCreative({{ $cr->id }})"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted text-center py-4 mb-0">لا توجد تصميمات بعد. أنشئ أول تصميم إبداعي.</p>
                @endif
            </div>
        </div>
    </div>

    {{───────────── Insights Tab ─────────────}}
    <div class="tab-pane fade" id="insightsTab" role="tabpanel">
        <div class="card">
            <div class="card-header bg-light fw-bold"><i class="fas fa-chart-bar" style="color:var(--pink-600);margin-left:6px;"></i> نظرة عامة على الأداء</div>
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label small">الحملة</label>
                        <select class="form-select form-select-sm" id="insight-campaign-select">
                            <option value="">اختر حملة</option>
                            @foreach($campaigns ?? [] as $c)
                            <option value="{{ $c->campaign_id }}" data-id="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">المستوى</label>
                        <select class="form-select form-select-sm" id="insight-level">
                            <option value="campaign">حملة</option>
                            <option value="adset">مجموعة إعلانية</option>
                            <option value="ad">إعلان</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">الفترة</label>
                        <select class="form-select form-select-sm" id="insight-date-preset">
                            <option value="today">اليوم</option>
                            <option value="yesterday">أمس</option>
                            <option value="last_7d">آخر 7 أيام</option>
                            <option value="last_14d">آخر 14 يوم</option>
                            <option value="last_30d" selected>آخر 30 يوم</option>
                            <option value="last_90d">آخر 90 يوم</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary btn-sm w-100" onclick="loadInsights()"><i class="fas fa-search"></i> عرض</button>
                    </div>
                </div>
                <div id="insight-results" class="small">
                    <p class="text-muted text-center py-4">اختر حملة لعرض التحليلات</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{═══════════════════════════════════════════════════════════════}}
{{─── MODALS ───}}
{{═══════════════════════════════════════════════════════════════}}

{{─── 1. Manual Token Modal ───}}
<div class="modal fade" id="manualTokenModal" tabindex="-1">
    <div class="modal-dialog modal-lg"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title"><i class="fas fa-key"></i> ربط يدوي بـ Access Token</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="alert alert-info small mb-3">
                <i class="fas fa-info-circle"></i> للفيسبوك: احصل على الرمز من <a href="https://developers.facebook.com/tools/explorer/" target="_blank">Graph API Explorer</a> مع صلاحيات ads_management, ads_read
            </div>
            <div class="alert alert-secondary small" id="manual-result" style="display:none"></div>
            <div class="mb-3"><label class="fw-bold">Access Token</label><input class="form-control font-monospace" id="manual-token" placeholder="EAAB..."></div>
            <button class="btn btn-primary w-100" id="btn-manual-connect" onclick="connectManual()">
                <span id="btn-manual-text"><i class="fas fa-link"></i> ربط</span>
                <span id="btn-manual-spin" class="d-none"><span class="spinner-border spinner-border-sm"></span> جاري...</span>
            </button>
        </div>
    </div></div>
</div>

{{─── 2. OAuth Modal ───}}
<div class="modal fade" id="connectPlatformModal" tabindex="-1">
    <div class="modal-dialog modal-lg"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title"><i class="fas fa-link"></i> ربط منصة إعلانية</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <p class="text-muted small mb-3">اختر المنصة للمتابعة عبر OAuth</p>
            <div class="row g-3">
                @foreach($platforms ?? [] as $key => $p)
                @if($p['has_oauth'])
                <div class="col-md-4">
                    <div class="border rounded-3 p-3 text-center h-100">
                        <i class="{{ $p['icon'] }} fa-3x mb-2" style="color:{{ $p['color'] }};"></i>
                        <div class="fw-bold">{{ $p['name'] }}</div>
                        <div class="text-muted small mb-2">{{ $p['configured'] ? 'جاهز للربط' : 'يحتاج إعداد' }}</div>
                        @if($p['connected'])
                            <span class="badge bg-success">متصل بالفعل</span>
                        @elseif($p['configured'])
                            <a href="{{ route('admin.oauth.redirect', $key) }}" class="btn btn-sm mt-1 w-100" style="background:{{ $p['color'] }};color:#fff;">
                                <i class="{{ $p['icon'] }}"></i> ربط OAuth
                            </a>
                        @else
                            <span class="badge bg-warning text-dark">ادخل المفاتيح أولاً</span>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div></div>
</div>

{{─── 3. Create Campaign Modal ───}}
<div class="modal fade" id="createCampaignModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title"><i class="fas fa-plus"></i> حملة جديدة</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <form id="createCampaignForm" onsubmit="return submitCampaign(event)">
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="campaign-error"></div>
                <div class="mb-3">
                    <label class="fw-bold small">الحساب الإعلاني</label>
                    <select class="form-select" name="ad_account_id" required>
                        <option value="">اختر حساب</option>
                        @foreach($accounts ?? [] as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->name }} ({{ $acc->ad_account_id }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">اسم الحملة</label>
                    <input class="form-control" name="name" required maxlength="255" placeholder="مثال: حملة خصم الصيف">
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">الهدف</label>
                    <select class="form-select" name="objective" required>
                        <option value="OUTCOME_AWARENESS">الوعي (Awareness)</option>
                        <option value="OUTCOME_TRAFFIC">زيارات (Traffic)</option>
                        <option value="OUTCOME_ENGAGEMENT">تفاعل (Engagement)</option>
                        <option value="OUTCOME_LEADS">عملاء محتملين (Leads)</option>
                        <option value="OUTCOME_SALES">مبيعات (Sales)</option>
                        <option value="OUTCOME_APP_PROMOTION">ترقية التطبيق</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">الميزانية اليومية (optional)</label>
                    <input class="form-control" name="daily_budget" type="number" step="0.01" min="1" placeholder="مثال: 50.00">
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">إستراتيجية التسعير</label>
                    <select class="form-select" name="bid_strategy">
                        <option value="LOWEST_COST_WITHOUT_CAP">أقل تكلفة بدون حد</option>
                        <option value="LOWEST_COST_WITH_BID_CAP">أقل تكلفة مع حد تسعير</option>
                        <option value="COST_CAP">حد التكلفة</option>
                        <option value="TARGET_COST">التكلفة المستهدفة</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">الحالة</label>
                    <select class="form-select" name="status">
                        <option value="PAUSED">إيقاف مؤقت</option>
                        <option value="ACTIVE">نشط</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button class="btn btn-primary" id="btn-submit-campaign">
                    <span id="btn-campaign-text"><i class="fas fa-save"></i> إنشاء</span>
                    <span id="btn-campaign-spin" class="d-none"><span class="spinner-border spinner-border-sm"></span> جاري...</span>
                </button>
            </div>
        </form>
    </div></div>
</div>

{{─── 4. Create Ad Set Modal ───}}
<div class="modal fade" id="createAdSetModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title"><i class="fas fa-layer-group"></i> مجموعة إعلانية جديدة</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <form id="createAdSetForm" onsubmit="return submitAdSet(event)">
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="adset-error"></div>
                <div class="mb-3">
                    <label class="fw-bold small">الحملة</label>
                    <select class="form-select" name="campaign_id" id="adset-campaign-select" required>
                        <option value="">اختر حملة</option>
                        @foreach($campaigns ?? [] as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">اسم المجموعة</label>
                    <input class="form-control" name="name" required placeholder="مثال: مجموعة - نساء 25-40">
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">هدف التحسين</label>
                    <select class="form-select" name="optimization_goal" required>
                        <option value="REACH">الوصول</option>
                        <option value="IMPRESSIONS">مرات الظهور</option>
                        <option value="LINK_CLICKS">نقرات الرابط</option>
                        <option value="LANDING_PAGE_VIEWS">مشاهدات الصفحة</option>
                        <option value="LEADS">العملاء المحتملين</option>
                        <option value="CONVERSIONS">التحويلات</option>
                        <option value="VALUE">القيمة</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">حدث الفوترة</label>
                    <select class="form-select" name="billing_event">
                        <option value="IMPRESSIONS">مرات الظهور</option>
                        <option value="CLICKS">النقرات</option>
                        <option value="APP_INSTALLS">تثبيت التطبيق</option>
                        <option value="THRUPLAYS">مشاهدات الفيديو</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">الميزانية اليومية</label>
                    <input class="form-control" name="daily_budget" type="number" step="0.01" min="1" placeholder="مثال: 30.00">
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">مبلغ التسعير (Bid)</label>
                    <input class="form-control" name="bid_amount" type="number" step="0.01" min="0.01" placeholder="اختياري">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button class="btn btn-primary" id="btn-submit-adset">
                    <span id="btn-adset-text"><i class="fas fa-save"></i> إنشاء</span>
                    <span id="btn-adset-spin" class="d-none"><span class="spinner-border spinner-border-sm"></span> جاري...</span>
                </button>
            </div>
        </form>
    </div></div>
</div>

{{─── 5. Create Creative Modal ───}}
<div class="modal fade" id="createCreativeModal" tabindex="-1">
    <div class="modal-dialog modal-lg"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title"><i class="fas fa-image"></i> تصميم إبداعي جديد</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <form id="createCreativeForm" onsubmit="return submitCreative(event)" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="creative-error"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold small">الحساب الإعلاني</label>
                            <select class="form-select" name="ad_account_id" required>
                                <option value="">اختر حساب</option>
                                @foreach($accounts ?? [] as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">اسم التصميم</label>
                            <input class="form-control" name="name" required placeholder="مثال: إعلان الصيف 1">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">العنوان (headline)</label>
                            <input class="form-control" name="title" maxlength="40" placeholder="ما يصل إلى 40 حرف">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">النص الأساسي (primary text)</label>
                            <textarea class="form-control" name="body" rows="3" placeholder="نص الإعلان"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold small">الوصف</label>
                            <input class="form-control" name="description" maxlength="255" placeholder="وصف مختصر">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">رابط الوجهة</label>
                            <input class="form-control" name="link_url" type="url" placeholder="https://example.com">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">زر الدعوة للإجراء</label>
                            <select class="form-select" name="call_to_action">
                                <option value="">بدون</option>
                                <option value="LEARN_MORE">اعرف المزيد</option>
                                <option value="SHOP_NOW">تسوق الآن</option>
                                <option value="SIGN_UP">اشترك</option>
                                <option value="BOOK_NOW">احجز الآن</option>
                                <option value="CONTACT_US">اتصل بنا</option>
                                <option value="GET_OFFER">احصل على العرض</option>
                                <option value="GET_QUOTE">احصل على عرض سعر</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">معرف الصفحة (Page ID)</label>
                            <input class="form-control" name="page_id" placeholder="اختياري">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">الصورة (max 5MB)</label>
                            <input class="form-control" name="image" type="file" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button class="btn btn-primary" id="btn-submit-creative">
                    <span id="btn-creative-text"><i class="fas fa-save"></i> حفظ كمسودة</span>
                    <span id="btn-creative-spin" class="d-none"><span class="spinner-border spinner-border-sm"></span> جاري...</span>
                </button>
            </div>
        </form>
    </div></div>
</div>

{{─── 6. Create Ad Modal ───}}
<div class="modal fade" id="createAdModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title"><i class="fas fa-ad"></i> إعلان جديد</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <form id="createAdForm" onsubmit="return submitAd(event)">
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="ad-error"></div>
                <div class="mb-3">
                    <label class="fw-bold small">المجموعة الإعلانية</label>
                    <select class="form-select" name="ad_set_id" id="ad-adset-select" required>
                        <option value="">اختر مجموعة إعلانية</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">التصميم الإبداعي (منشور على فيسبوك)</label>
                    <select class="form-select" name="creative_id" required>
                        <option value="">اختر تصميماً</option>
                        @foreach($creatives ?? [] as $cr)
                        @if($cr->creative_id && $cr->status === 'active')
                        <option value="{{ $cr->id }}">{{ $cr->name }} @if($cr->title)- {{ $cr->title }}@endif</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">اسم الإعلان</label>
                    <input class="form-control" name="name" required placeholder="مثال: إعلان 1 - مجموعة نساء">
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">الحالة</label>
                    <select class="form-select" name="status">
                        <option value="PAUSED">إيقاف مؤقت</option>
                        <option value="ACTIVE">نشط</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button class="btn btn-primary" id="btn-submit-ad">
                    <span id="btn-ad-text"><i class="fas fa-save"></i> إنشاء</span>
                    <span id="btn-ad-spin" class="d-none"><span class="spinner-border spinner-border-sm"></span> جاري...</span>
                </button>
            </div>
        </form>
    </div></div>
</div>

{{─── 7. Edit Campaign Modal ───}}
<div class="modal fade" id="editCampaignModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title"><i class="fas fa-edit"></i> تعديل الحملة</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <form id="editCampaignForm" onsubmit="return submitEditCampaign(event)">
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="edit-campaign-error"></div>
                <input type="hidden" name="id" id="edit-campaign-id">
                <div class="mb-3">
                    <label class="fw-bold small">اسم الحملة</label>
                    <input class="form-control" name="name" id="edit-campaign-name" required>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">الميزانية اليومية</label>
                    <input class="form-control" name="daily_budget" id="edit-campaign-budget" type="number" step="0.01" min="1">
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">إستراتيجية التسعير</label>
                    <select class="form-select" name="bid_strategy" id="edit-campaign-bid">
                        <option value="LOWEST_COST_WITHOUT_CAP">أقل تكلفة بدون حد</option>
                        <option value="LOWEST_COST_WITH_BID_CAP">أقل تكلفة مع حد تسعير</option>
                        <option value="COST_CAP">حد التكلفة</option>
                        <option value="TARGET_COST">التكلفة المستهدفة</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button class="btn btn-primary" id="btn-edit-campaign">
                    <span id="btn-edit-campaign-text"><i class="fas fa-save"></i> حفظ</span>
                    <span id="btn-edit-campaign-spin" class="d-none"><span class="spinner-border spinner-border-sm"></span> جاري...</span>
                </button>
            </div>
        </form>
    </div></div>
</div>

{{─── 8. Insights Modal ───}}
<div class="modal fade" id="insightsModal" tabindex="-1">
    <div class="modal-dialog modal-xl"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title"><i class="fas fa-chart-bar"></i> <span id="insights-modal-title">التحليلات</span></h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div id="insights-modal-content" class="small">
                <div class="text-center py-4"><span class="spinner-border spinner-border-sm"></span> جاري التحميل...</div>
            </div>
        </div>
    </div></div>
</div>

{{─── 9. Edit Creative Modal ───}}
<div class="modal fade" id="editCreativeModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title"><i class="fas fa-edit"></i> تعديل التصميم</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <form id="editCreativeForm" onsubmit="return submitEditCreative(event)">
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="edit-creative-error"></div>
                <input type="hidden" name="id" id="edit-creative-id">
                <div class="mb-3">
                    <label class="fw-bold small">اسم التصميم</label>
                    <input class="form-control" name="name" id="edit-creative-name" required>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">العنوان</label>
                    <input class="form-control" name="title" id="edit-creative-title" maxlength="40">
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">النص</label>
                    <textarea class="form-control" name="body" id="edit-creative-body" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">الوصف</label>
                    <input class="form-control" name="description" id="edit-creative-desc" maxlength="255">
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">رابط الوجهة</label>
                    <input class="form-control" name="link_url" id="edit-creative-link" type="url">
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">زر الدعوة</label>
                    <select class="form-select" name="call_to_action" id="edit-creative-cta">
                        <option value="">بدون</option>
                        <option value="LEARN_MORE">اعرف المزيد</option>
                        <option value="SHOP_NOW">تسوق الآن</option>
                        <option value="SIGN_UP">اشترك</option>
                        <option value="BOOK_NOW">احجز الآن</option>
                        <option value="CONTACT_US">اتصل بنا</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button class="btn btn-primary" id="btn-edit-creative">
                    <span id="btn-edit-creative-text"><i class="fas fa-save"></i> حفظ</span>
                    <span id="btn-edit-creative-spin" class="d-none"><span class="spinner-border spinner-border-sm"></span> جاري...</span>
                </button>
            </div>
        </form>
    </div></div>
</div>

@include('admin.ads._adset_template')

@endsection

@push('scripts')
<script>
const BASE = window.location.origin + window.location.pathname.replace(/\/admin\/ads.*/, '');
const CSRF = '{{ csrf_token() }}';

// ─── UTILS ───
function btnLoading(prefix, loading) {
    document.getElementById('btn-' + prefix + '-text').classList.toggle('d-none', loading);
    document.getElementById('btn-' + prefix + '-spin').classList.toggle('d-none', !loading);
    document.getElementById('btn-' + prefix).disabled = loading;
}

function showError(id, msg) {
    const el = document.getElementById(id);
    el.classList.remove('d-none');
    el.textContent = msg;
}

function hideError(id) {
    document.getElementById(id).classList.add('d-none');
}

// ─── ACCOUNTS ───
async function connectManual() {
    const token = document.getElementById('manual-token').value.trim();
    if (!token) return alert('أدخل رمز الوصول');
    const el = document.getElementById('manual-result');
    btnLoading('manual-connect', true);
    try {
        const r = await fetch(BASE + '/admin/ads/accounts/connect', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ access_token: token })
        });
        const d = await r.json();
        el.style.display = 'block';
        el.className = 'alert alert-' + (d.success ? 'success' : 'danger') + ' small';
        el.textContent = d.message || (d.success ? 'تم الربط' : 'فشل');
        if (d.success) setTimeout(() => location.reload(), 1200);
    } catch (e) {
        el.style.display = 'block'; el.className = 'alert alert-danger small'; el.textContent = 'فشل الاتصال';
    } finally { btnLoading('manual-connect', false); }
}

async function syncAccount(id) {
    try {
        await fetch(BASE + '/admin/ads/sync', { method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } });
        location.reload();
    } catch (e) { alert('فشلت المزامنة'); }
}

async function syncAllCampaigns() { await syncAccount(0); }

async function deleteAccount(id) {
    if (!confirm('حذف هذا الحساب وجميع حملاته؟')) return;
    try {
        const r = await fetch(BASE + '/admin/ads/accounts/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } });
        if (r.ok) location.reload(); else { const d = await r.json(); alert(d.message || 'فشل'); }
    } catch (e) { alert('فشل'); }
}

// ─── CAMPAIGN EXPAND ───
let expandedCampaigns = {};

async function toggleCampaignExpand(id) {
    const row = document.getElementById('campaign-detail-' + id);
    const icon = document.getElementById('expand-icon-' + id);

    if (expandedCampaigns[id]) {
        row.classList.add('d-none');
        icon.className = 'fas fa-chevron-left';
        expandedCampaigns[id] = false;
        return;
    }

    icon.className = 'fas fa-chevron-down';
    row.classList.remove('d-none');
    expandedCampaigns[id] = true;

    if (row.dataset.loaded) return;

    try {
        const r = await fetch(BASE + '/admin/ads/campaigns/' + id + '/adsets', {
            headers: { 'Accept': 'application/json' }
        });
        const d = await r.json();
        row.dataset.loaded = '1';

        if (d.success && d.data.length > 0) {
            document.getElementById('campaign-content-' + id).innerHTML = renderAdSets(d.data, id);
        } else {
            document.getElementById('campaign-content-' + id).innerHTML = `
                <div class="text-center py-3">
                    <p class="text-muted mb-2">لا توجد مجموعات إعلانية</p>
                    <button class="btn btn-sm btn-outline-primary" onclick="openCreateAdSet('${id}')">
                        <i class="fas fa-plus"></i> إضافة مجموعة إعلانية
                    </button>
                </div>`;
        }
    } catch (e) {
        document.getElementById('campaign-content-' + id).innerHTML = '<div class="text-center py-3 text-danger">فشل تحميل المجموعات</div>';
    }
}

function renderAdSets(adsets, campaignId) {
    let html = `<div class="p-2">
        <div class="d-flex justify-content-between mb-2">
            <span class="fw-bold small"><i class="fas fa-layer-group"></i> المجموعات الإعلانية (${adsets.length})</span>
            <button class="btn btn-sm btn-outline-primary" onclick="openCreateAdSet('${campaignId}')"><i class="fas fa-plus"></i> إضافة</button>
        </div>`;

    adsets.forEach(s => {
        const adsCount = s.ads_count || 0;
        html += `<div class="card mb-2 border-0 shadow-sm">
            <div class="card-body p-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <b class="small">${s.name}</b>
                        <span class="badge bg-${s.status === 'ACTIVE' ? 'success' : (s.status === 'PAUSED' ? 'warning text-dark' : 'secondary')} ms-2">${s.status}</span>
                        <span class="text-muted small me-2">${s.optimization_goal || '-'}</span>
                    </div>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-info" onclick="viewAdSetInsights('${s.id}')" title="تحليلات"><i class="fas fa-chart-bar"></i></button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleAdSet('${s.id}')" title="تبديل"><i class="fas fa-${s.status === 'ACTIVE' ? 'pause' : 'play'}"></i></button>
                        <button class="btn btn-sm btn-outline-primary" onclick="editAdSet('${s.id}')" title="تعديل"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-outline-success" onclick="openCreateAd('${s.id}','${s.name.replace(/'/g, "\\'")}')" title="إضافة إعلان"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                ${s.daily_budget ? `<div class="small text-muted mt-1">الميزانية: ${Number(s.daily_budget).toFixed(2)} / يوم</div>` : ''}
                <div class="mt-2" id="ads-container-${s.id}">
                    ${adsCount > 0 ? `<button class="btn btn-sm btn-link p-0" onclick="loadAds('${s.id}', this)"><i class="fas fa-chevron-left"></i> عرض الإعلانات (${adsCount})</button>` : '<span class="small text-muted">لا توجد إعلانات</span>'}
                </div>
            </div>
        </div>`;
    });

    html += '</div>';
    return html;
}

// ─── ADS ───
let adsLoaded = {};

async function loadAds(adSetId, btn) {
    if (adsLoaded[adSetId]) {
        const container = document.getElementById('ads-container-' + adSetId);
        const adDiv = container.querySelector('.ads-list');
        if (adDiv) {
            adDiv.classList.toggle('d-none');
            btn.innerHTML = adDiv.classList.contains('d-none')
                ? `<i class="fas fa-chevron-left"></i> عرض الإعلانات`
                : `<i class="fas fa-chevron-down"></i> إخفاء الإعلانات`;
            return;
        }
    }

    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> جاري...';
    try {
        const r = await fetch(BASE + '/admin/ads/adsets/' + adSetId + '/ads', {
            headers: { 'Accept': 'application/json' }
        });
        const d = await r.json();
        adsLoaded[adSetId] = true;

        const container = document.getElementById('ads-container-' + adSetId);
        if (d.success && d.data.length > 0) {
            let html = '<div class="ads-list mt-2">';
            d.data.forEach(a => {
                html += `<div class="d-flex justify-content-between align-items-center py-1 border-bottom small">
                    <div><span>${a.name}</span> <span class="badge bg-${a.status === 'ACTIVE' ? 'success' : (a.status === 'PAUSED' ? 'warning text-dark' : 'secondary')}">${a.status}</span></div>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-info py-0 px-1" onclick="viewAdInsights('${a.id}')" title="تحليلات"><i class="fas fa-chart-bar" style="font-size:11px"></i></button>
                        <button class="btn btn-sm btn-outline-secondary py-0 px-1" onclick="toggleAd('${a.id}')" title="تبديل"><i class="fas fa-${a.status === 'ACTIVE' ? 'pause' : 'play'}" style="font-size:11px"></i></button>
                    </div>
                </div>`;
            });
            html += '</div>';
            container.innerHTML = html;
            btn.innerHTML = `<i class="fas fa-chevron-down"></i> إخفاء الإعلانات`;
        } else {
            container.innerHTML = '<div class="small text-muted">لا توجد إعلانات</div>';
            btn.innerHTML = `<i class="fas fa-chevron-left"></i> عرض الإعلانات`;
        }
    } catch (e) {
        btn.innerHTML = 'فشل التحميل';
    }
}

// ─── CAMPAIGN CRUD ───
function openCreateCampaign() {
    hideError('campaign-error');
    document.getElementById('createCampaignForm').reset();
    new bootstrap.Modal(document.getElementById('createCampaignModal')).show();
}

async function submitCampaign(e) {
    e.preventDefault();
    hideError('campaign-error');
    btnLoading('submit-campaign', true);

    const form = document.getElementById('createCampaignForm');
    const data = Object.fromEntries(new FormData(form));

    try {
        const r = await fetch(BASE + '/admin/ads/campaigns', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(data)
        });
        const d = await r.json();
        if (d.success) {
            bootstrap.Modal.getInstance(document.getElementById('createCampaignModal')).hide();
            location.reload();
        } else {
            showError('campaign-error', d.message || 'فشل إنشاء الحملة');
        }
    } catch (e) {
        showError('campaign-error', 'خطأ في الاتصال');
    } finally { btnLoading('submit-campaign', false); }
}

async function toggleCampaign(id) {
    try {
        const r = await fetch(BASE + '/admin/ads/campaigns/' + id + '/toggle', {
            method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const d = await r.json();
        if (d.success) location.reload(); else alert(d.message || 'فشل');
    } catch (e) { alert('فشل'); }
}

async function deleteCampaign(id) {
    if (!confirm('حذف هذه الحملة؟')) return;
    try {
        const r = await fetch(BASE + '/admin/ads/campaigns/' + id, {
            method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        if (r.ok) location.reload(); else { const d = await r.json(); alert(d.message || 'فشل'); }
    } catch (e) { alert('فشل'); }
}

async function duplicateCampaign(id) {
    const name = prompt('اسم النسخة الجديدة:');
    if (!name) return;
    try {
        const r = await fetch(BASE + '/admin/ads/campaigns/' + id + '/duplicate', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ name })
        });
        const d = await r.json();
        if (d.success) location.reload(); else alert(d.message || 'فشل');
    } catch (e) { alert('فشل'); }
}

function editCampaign(id) {
    hideError('edit-campaign-error');
    const row = document.getElementById('campaign-row-' + id);
    const name = row.cells[1].textContent.trim();
    const budget = row.cells[4].textContent.trim().split(' ')[0];
    document.getElementById('edit-campaign-id').value = id;
    document.getElementById('edit-campaign-name').value = name;
    document.getElementById('edit-campaign-budget').value = budget && budget !== '-' ? budget : '';
    new bootstrap.Modal(document.getElementById('editCampaignModal')).show();
}

async function submitEditCampaign(e) {
    e.preventDefault();
    hideError('edit-campaign-error');
    btnLoading('edit-campaign', true);

    const id = document.getElementById('edit-campaign-id').value;
    const data = {
        name: document.getElementById('edit-campaign-name').value,
        daily_budget: document.getElementById('edit-campaign-budget').value || null,
        bid_strategy: document.getElementById('edit-campaign-bid').value,
    };

    try {
        const r = await fetch(BASE + '/admin/ads/campaigns/' + id, {
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(data)
        });
        const d = await r.json();
        if (d.success) {
            bootstrap.Modal.getInstance(document.getElementById('editCampaignModal')).hide();
            location.reload();
        } else {
            showError('edit-campaign-error', d.message || 'فشل التحديث');
        }
    } catch (e) {
        showError('edit-campaign-error', 'خطأ في الاتصال');
    } finally { btnLoading('edit-campaign', false); }
}

// ─── AD SET CRUD ───
function openCreateAdSet(campaignId) {
    hideError('adset-error');
    document.getElementById('createAdSetForm').reset();
    if (campaignId) {
        document.getElementById('adset-campaign-select').value = campaignId;
    }
    new bootstrap.Modal(document.getElementById('createAdSetModal')).show();
}

async function submitAdSet(e) {
    e.preventDefault();
    hideError('adset-error');
    btnLoading('submit-adset', true);

    const data = Object.fromEntries(new FormData(document.getElementById('createAdSetForm')));

    try {
        const r = await fetch(BASE + '/admin/ads/adsets', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(data)
        });
        const d = await r.json();
        if (d.success) {
            bootstrap.Modal.getInstance(document.getElementById('createAdSetModal')).hide();
            location.reload();
        } else {
            showError('adset-error', d.message || 'فشل إنشاء المجموعة');
        }
    } catch (e) {
        showError('adset-error', 'خطأ في الاتصال');
    } finally { btnLoading('submit-adset', false); }
}

async function toggleAdSet(id) {
    try {
        const r = await fetch(BASE + '/admin/ads/adsets/' + id + '/toggle', {
            method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const d = await r.json();
        if (d.success) location.reload(); else alert(d.message || 'فشل');
    } catch (e) { alert('فشل'); }
}

// ─── CREATIVE CRUD ───
async function submitCreative(e) {
    e.preventDefault();
    hideError('creative-error');
    btnLoading('submit-creative', true);

    const form = document.getElementById('createCreativeForm');
    const formData = new FormData(form);

    try {
        const r = await fetch(BASE + '/admin/ads/creatives', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: formData
        });
        const d = await r.json();
        if (d.success) {
            bootstrap.Modal.getInstance(document.getElementById('createCreativeModal')).hide();
            location.reload();
        } else {
            showError('creative-error', d.message || 'فشل إنشاء التصميم');
        }
    } catch (e) {
        showError('creative-error', 'خطأ في الاتصال');
    } finally { btnLoading('submit-creative', false); }
}

async function publishCreative(id) {
    if (!confirm('نشر هذا التصميم على فيسبوك؟')) return;
    try {
        const r = await fetch(BASE + '/admin/ads/creatives/save', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ creative_id: id })
        });
        const d = await r.json();
        if (d.success) location.reload(); else alert(d.message || 'فشل');
    } catch (e) { alert('فشل'); }
}

async function deleteCreative(id) {
    if (!confirm('حذف هذا التصميم؟')) return;
    try {
        const r = await fetch(BASE + '/admin/ads/creatives/' + id, {
            method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        if (r.ok) location.reload(); else { const d = await r.json(); alert(d.message || 'فشل'); }
    } catch (e) { alert('فشل'); }
}

function editCreative(id) {
    fetch(BASE + '/admin/ads/creatives/list?page=1', {
        headers: { 'Accept': 'application/json' }
    }).then(r => r.json()).then(d => {
        if (!d.success) return;
        const cr = d.data.find(c => c.id == id);
        if (!cr) return;
        document.getElementById('edit-creative-id').value = cr.id;
        document.getElementById('edit-creative-name').value = cr.name || '';
        document.getElementById('edit-creative-title').value = cr.title || '';
        document.getElementById('edit-creative-body').value = cr.body || '';
        document.getElementById('edit-creative-desc').value = cr.description || '';
        document.getElementById('edit-creative-link').value = cr.link_url || '';
        document.getElementById('edit-creative-cta').value = cr.call_to_action || '';
        hideError('edit-creative-error');
        new bootstrap.Modal(document.getElementById('editCreativeModal')).show();
    }).catch(() => alert('فشل تحميل بيانات التصميم'));
}

async function submitEditCreative(e) {
    e.preventDefault();
    hideError('edit-creative-error');
    btnLoading('edit-creative', true);

    const id = document.getElementById('edit-creative-id').value;
    const data = {
        name: document.getElementById('edit-creative-name').value,
        title: document.getElementById('edit-creative-title').value,
        body: document.getElementById('edit-creative-body').value,
        description: document.getElementById('edit-creative-desc').value,
        link_url: document.getElementById('edit-creative-link').value,
        call_to_action: document.getElementById('edit-creative-cta').value,
    };

    try {
        const r = await fetch(BASE + '/admin/ads/creatives/' + id, {
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(data)
        });
        const d = await r.json();
        if (d.success) {
            bootstrap.Modal.getInstance(document.getElementById('editCreativeModal')).hide();
            location.reload();
        } else {
            showError('edit-creative-error', d.message || 'فشل التحديث');
        }
    } catch (e) {
        showError('edit-creative-error', 'خطأ في الاتصال');
    } finally { btnLoading('edit-creative', false); }
}

// ─── AD CRUD ───
function openCreateAd(adSetId, adSetName) {
    hideError('ad-error');
    document.getElementById('createAdForm').reset();

    const select = document.getElementById('ad-adset-select');
    select.innerHTML = '<option value="">اختر مجموعة إعلانية</option>';

    const opt = document.createElement('option');
    opt.value = adSetId;
    opt.textContent = adSetName || 'المجموعة #' + adSetId;
    opt.selected = true;
    select.appendChild(opt);

    new bootstrap.Modal(document.getElementById('createAdModal')).show();
}

async function submitAd(e) {
    e.preventDefault();
    hideError('ad-error');
    btnLoading('submit-ad', true);

    const data = Object.fromEntries(new FormData(document.getElementById('createAdForm')));

    try {
        const r = await fetch(BASE + '/admin/ads/create', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(data)
        });
        const d = await r.json();
        if (d.success) {
            bootstrap.Modal.getInstance(document.getElementById('createAdModal')).hide();
            location.reload();
        } else {
            showError('ad-error', d.message || 'فشل إنشاء الإعلان');
        }
    } catch (e) {
        showError('ad-error', 'خطأ في الاتصال');
    } finally { btnLoading('submit-ad', false); }
}

async function toggleAd(id) {
    try {
        const r = await fetch(BASE + '/admin/ads/' + id + '/toggle', {
            method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const d = await r.json();
        if (d.success) location.reload(); else alert(d.message || 'فشل');
    } catch (e) { alert('فشل'); }
}

// ─── INSIGHTS ───
async function viewCampaignInsights(id) {
    document.getElementById('insights-modal-title').textContent = 'تحليلات الحملة';
    document.getElementById('insights-modal-content').innerHTML =
        '<div class="text-center py-4"><span class="spinner-border spinner-border-sm"></span> جاري تحميل التحليلات...</div>';
    new bootstrap.Modal(document.getElementById('insightsModal')).show();

    try {
        const r = await fetch(BASE + '/admin/ads/campaigns/' + id + '/insights', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ date_preset: 'last_30d' })
        });
        const d = await r.json();
        document.getElementById('insights-modal-content').innerHTML = renderInsights(d.data);
    } catch (e) {
        document.getElementById('insights-modal-content').innerHTML =
            '<div class="text-center py-4 text-danger">فشل تحميل التحليلات</div>';
    }
}

async function viewAdSetInsights(id) {
    document.getElementById('insights-modal-title').textContent = 'تحليلات المجموعة الإعلانية';
    document.getElementById('insights-modal-content').innerHTML =
        '<div class="text-center py-4"><span class="spinner-border spinner-border-sm"></span> جاري تحميل التحليلات...</div>';
    new bootstrap.Modal(document.getElementById('insightsModal')).show();

    try {
        const r = await fetch(BASE + '/admin/ads/adsets/' + id + '/insights', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ date_preset: 'last_30d' })
        });
        const d = await r.json();
        document.getElementById('insights-modal-content').innerHTML = renderInsights(d.data);
    } catch (e) {
        document.getElementById('insights-modal-content').innerHTML =
            '<div class="text-center py-4 text-danger">فشل تحميل التحليلات</div>';
    }
}

async function viewAdInsights(id) {
    document.getElementById('insights-modal-title').textContent = 'تحليلات الإعلان';
    document.getElementById('insights-modal-content').innerHTML =
        '<div class="text-center py-4"><span class="spinner-border spinner-border-sm"></span> جاري تحميل التحليلات...</div>';
    new bootstrap.Modal(document.getElementById('insightsModal')).show();

    try {
        const r = await fetch(BASE + '/admin/ads/' + id + '/insights', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ date_preset: 'last_30d' })
        });
        const d = await r.json();
        document.getElementById('insights-modal-content').innerHTML = renderInsights(d.data);
    } catch (e) {
        document.getElementById('insights-modal-content').innerHTML =
            '<div class="text-center py-4 text-danger">فشل تحميل التحليلات</div>';
    }
}

function renderInsights(data) {
    if (!data || data.length === 0) {
        return '<div class="text-center py-4 text-muted">لا توجد بيانات متاحة لهذه الفترة</div>';
    }

    const row = data[0];
    const spend = Number(row.spend || 0).toFixed(2);
    const impressions = Number(row.impressions || 0).toLocaleString();
    const clicks = Number(row.clicks || 0).toLocaleString();
    const ctr = Number(row.ctr || 0).toFixed(2);
    const cpc = Number(row.cpc || 0).toFixed(4);
    const cpm = Number(row.cpm || 0).toFixed(2);
    const reach = Number(row.reach || 0).toLocaleString();
    const frequency = Number(row.frequency || 0).toFixed(2);

    let actionsHtml = '';
    if (row.actions) {
        const actions = typeof row.actions === 'string' ? JSON.parse(row.actions) : row.actions;
        if (Array.isArray(actions) && actions.length > 0) {
            actionsHtml = '<h6 class="mt-3 mb-2">الإجراءات</h6><div class="table-responsive"><table class="table table-sm table-bordered mb-0"><thead><tr><th>الإجراء</th><th>العدد</th><th>التكلفة</th></tr></thead><tbody>';
            actions.forEach(a => {
                const actionType = a.action_type || a.action_destination || '-';
                const value = a.value || 0;
                actionsHtml += `<tr><td>${actionType}</td><td>${Number(value).toLocaleString()}</td><td>${spend > 0 && value > 0 ? (Number(spend) / value).toFixed(2) : '-'}</td></tr>`;
            });
            actionsHtml += '</tbody></table></div>';
        }
    }

    return `
        <div class="row g-3 mb-3">
            <div class="col-md-3 col-6"><div class="border rounded p-3 text-center bg-light"><div class="text-muted small">الإنفاق</div><div class="fw-bold fs-5">$${spend}</div></div></div>
            <div class="col-md-3 col-6"><div class="border rounded p-3 text-center bg-light"><div class="text-muted small">مرات الظهور</div><div class="fw-bold fs-5">${impressions}</div></div></div>
            <div class="col-md-3 col-6"><div class="border rounded p-3 text-center bg-light"><div class="text-muted small">النقرات</div><div class="fw-bold fs-5">${clicks}</div></div></div>
            <div class="col-md-3 col-6"><div class="border rounded p-3 text-center bg-light"><div class="text-muted small">الوصول</div><div class="fw-bold fs-5">${reach}</div></div></div>
            <div class="col-md-3 col-6"><div class="border rounded p-3 text-center bg-light"><div class="text-muted small">CTR</div><div class="fw-bold fs-5">${ctr}%</div></div></div>
            <div class="col-md-3 col-6"><div class="border rounded p-3 text-center bg-light"><div class="text-muted small">CPC</div><div class="fw-bold fs-5">$${cpc}</div></div></div>
            <div class="col-md-3 col-6"><div class="border rounded p-3 text-center bg-light"><div class="text-muted small">CPM</div><div class="fw-bold fs-5">$${cpm}</div></div></div>
            <div class="col-md-3 col-6"><div class="border rounded p-3 text-center bg-light"><div class="text-muted small">التكرار</div><div class="fw-bold fs-5">${frequency}</div></div></div>
        </div>
        ${actionsHtml}
        <hr>
        <details class="small">
            <summary class="text-muted">البيانات الخام</summary>
            <pre class="mt-2" style="max-height:300px;overflow:auto;font-size:10px;">${JSON.stringify(data, null, 2)}</pre>
        </details>
    `;
}

// ─── INSIGHTS TAB ───
async function loadInsights() {
    const campaignSelect = document.getElementById('insight-campaign-select');
    const level = document.getElementById('insight-level').value;
    const datePreset = document.getElementById('insight-date-preset').value;
    const campaignId = campaignSelect.value;
    const localId = campaignSelect.options[campaignSelect.selectedIndex]?.dataset?.id;

    if (!campaignId) {
        document.getElementById('insight-results').innerHTML = '<p class="text-muted text-center py-4">اختر حملة لعرض التحليلات</p>';
        return;
    }

    document.getElementById('insight-results').innerHTML = '<div class="text-center py-4"><span class="spinner-border spinner-border-sm"></span> جاري التحميل...</div>';

    let url = '';
    if (level === 'campaign' && localId) {
        url = BASE + '/admin/ads/campaigns/' + localId + '/insights';
    } else if (level === 'adset') {
        url = BASE + '/admin/ads/adsets/0/insights';
    } else {
        url = BASE + '/admin/ads/0/insights';
    }

    try {
        let data = [];
        // For now just try campaign level
        if (localId) {
            const r = await fetch(BASE + '/admin/ads/campaigns/' + localId + '/insights', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ date_preset: datePreset })
            });
            const d = await r.json();
            data = d.data || [];
        }
        document.getElementById('insight-results').innerHTML = renderInsights(data);
    } catch (e) {
        document.getElementById('insight-results').innerHTML = '<div class="text-center py-4 text-danger">فشل تحميل التحليلات</div>';
    }
}

// ─── MODAL RESETS ───
document.getElementById('manualTokenModal')?.addEventListener('show.bs.modal', function () {
    document.getElementById('manual-result').style.display = 'none';
    document.getElementById('manual-token').value = '';
});

document.getElementById('createCampaignModal')?.addEventListener('show.bs.modal', function () {
    hideError('campaign-error');
});

document.getElementById('createAdSetModal')?.addEventListener('show.bs.modal', function () {
    hideError('adset-error');
});

document.getElementById('createCreativeModal')?.addEventListener('show.bs.modal', function () {
    hideError('creative-error');
    document.getElementById('createCreativeForm').reset();
});

document.getElementById('createAdModal')?.addEventListener('show.bs.modal', function () {
    hideError('ad-error');
});

// ─── AUTO SYNC ───
@if($autoSync ?? false)
(function() {
    fetch(BASE + '/admin/ads/sync', { method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } })
        .finally(() => location.reload());
})();
@endif
</script>
@endpush
