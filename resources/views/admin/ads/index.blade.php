@extends('admin.layouts.app')

@section('title', 'إدارة الإعلانات')

@push('extra-styles')
<style>
    .ad-stat { background:#fff; border-radius:12px; padding:16px; border:1px solid var(--gray-200); }
    .ad-stat .stat-icon { width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .ad-card { background:#fff; border-radius:12px; border:1px solid var(--gray-200); padding:1rem; margin-bottom:.75rem; }
    .ad-card:hover { box-shadow:0 4px 16px rgba(0,0,0,.04); }
    .btn-xxs { font-size:.68rem; padding:.15rem .5rem; border-radius:6px; }
    .campaign-row { transition:background .15s; }
    .campaign-row:hover { background:var(--pink-50); }
    .badge-ACTIVE { background:#D1FAE5; color:#065F46; }
    .badge-PAUSED { background:#FEF3C7; color:#92400E; }
    .badge-DELETED { background:#F1F5F9; color:#6B7280; }
    .wizard-step { display:none; }
    .wizard-step.active { display:block; animation:fadeInUp .3s ease; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 mb-1"><i class="fas fa-ad" style="color:var(--pink-600);margin-left:8px;"></i> إدارة إعلانات Facebook</h1>
        <p class="text-muted small mb-0">إنشاء وإدارة الحملات الإعلانية مباشرة من المتجر</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-pink btn-sm" onclick="refreshInsights()"><i class="fas fa-sync-alt"></i> تحديث البيانات</button>
        <button class="btn btn-pink btn-sm" data-bs-toggle="modal" data-bs-target="#wizardModal"><i class="fas fa-plus"></i> حملة جديدة</button>
    </div>
</div>

{{-- KPI Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="ad-stat d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#1877F2;color:#fff;"><i class="fas fa-bullhorn"></i></div>
            <div><div class="fw-bold" style="font-size:1.3rem;">{{ $campaigns->count() }}</div><small class="text-muted">الحملات</small></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="ad-stat d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#10B981;color:#fff;"><i class="fas fa-play"></i></div>
            <div><div class="fw-bold" style="font-size:1.3rem;">{{ $activeCount }}</div><small class="text-muted">نشطة</small></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="ad-stat d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#f59e0b;color:#fff;"><i class="fas fa-pause"></i></div>
            <div><div class="fw-bold" style="font-size:1.3rem;">{{ $pausedCount }}</div><small class="text-muted">متوقفة</small></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="ad-stat d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:var(--pink-500);color:#fff;"><i class="fas fa-paint-brush"></i></div>
            <div><div class="fw-bold" style="font-size:1.3rem;">{{ $creatives->count() }}</div><small class="text-muted">إعلانات جاهزة</small></div>
        </div>
    </div>
</div>

{{-- Ad Accounts --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold small"><i class="fas fa-building" style="color:var(--pink-600);margin-left:6px;"></i> حسابات الإعلانات</span>
        <button class="btn btn-xxs btn-pink" onclick="showConnectForm()"><i class="fas fa-link"></i> ربط حساب</button>
    </div>
    <div class="card-body">
        <div id="connect-form" style="display:none;" class="border rounded-3 p-3 mb-3">
            <div class="row g-2">
                <div class="col-md-5">
                    <input type="text" class="form-control form-control-sm" id="connectAccountId" placeholder="act_123456789">
                </div>
                <div class="col-md-5">
                    <input type="password" class="form-control form-control-sm" id="connectAccessToken" placeholder="Access Token">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-pink btn-sm w-100" onclick="connectAccount()">ربط</button>
                </div>
            </div>
            <div id="connect-alert" class="mt-2"></div>
        </div>
        <div class="row g-2" id="accounts-list">
            @forelse($accounts as $acc)
            <div class="col-md-4">
                <div class="border rounded-3 p-3" id="account-{{ $acc->id }}">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="fw-bold small">{{ $acc->name }}</div>
                        <button class="btn btn-xxs btn-outline-danger" onclick="deleteAccount({{ $acc->id }})"><i class="fas fa-trash"></i></button>
                    </div>
                    <div class="small text-muted">{{ $acc->ad_account_id }}</div>
                    <div class="d-flex gap-1 mt-1">
                        <span class="badge bg-light text-dark">{{ $acc->campaigns_count }} حملة</span>
                        <span class="badge bg-light text-dark">{{ $acc->ads_count }} إعلان</span>
                    </div>
                    <button class="btn btn-xxs btn-outline-pink mt-2 w-100" onclick="syncCampaigns({{ $acc->id }})">
                        <i class="fas fa-cloud-download-alt"></i> مزامنة من Facebook
                    </button>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-3 text-muted small">لا توجد حسابات إعلانية. قم بربط حساب Facebook Ads أولاً.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- Campaigns Table --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold small"><i class="fas fa-list" style="color:var(--pink-600);margin-left:6px;"></i> الحملات الإعلانية</span>
        <span class="small text-muted">{{ $campaigns->count() }} حملة</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light small">
                    <tr><th>الاسم</th><th>الهدف</th><th class="text-center">الميزانية</th><th class="text-center">الحالة</th><th class="text-center">Ad Sets</th><th>الحساب</th><th class="text-center">إجراءات</th></tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $c)
                    <tr class="campaign-row" style="font-size:.78rem;">
                        <td class="fw-bold">{{ $c->name }}</td>
                        <td>
                            @php
                                $objLabels = ['OUTCOME_SALES'=>'مبيعات','OUTCOME_TRAFFIC'=>'زيارات','OUTCOME_ENGAGEMENT'=>'تفاعل','OUTCOME_LEADS'=>'عملاء محتملون','OUTCOME_AWARENESS'=>'وعي'];
                            @endphp
                            <span class="badge bg-light text-dark">{{ $objLabels[$c->objective] ?? $c->objective }}</span>
                        </td>
                        <td class="text-center">
                            @if($c->daily_budget) {{ number_format($c->daily_budget, 0) }} ILS/يوم
                            @elseif($c->lifetime_budget) {{ number_format($c->lifetime_budget, 0) }} ILS
                            @else -
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge badge-{{ $c->status }}">{{ $c->status === 'ACTIVE' ? 'نشطة' : 'متوقفة' }}</span>
                        </td>
                        <td class="text-center">{{ $c->adSets->count() }}</td>
                        <td><small>{{ $c->adAccount->name ?? '-' }}</small></td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="btn btn-xxs btn-{{ $c->status === 'ACTIVE' ? 'warning' : 'success' }}" onclick="toggleCampaign({{ $c->id }})">
                                    {{ $c->status === 'ACTIVE' ? 'إيقاف' : 'تشغيل' }}
                                </button>
                                <button class="btn btn-xxs btn-outline-info" onclick="loadInsights({{ $c->id }})">
                                    <i class="fas fa-chart-bar"></i>
                                </button>
                                <button class="btn btn-xxs btn-outline-danger" onclick="deleteCampaign({{ $c->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted small py-4">لا توجد حملات بعد. قم بإنشاء حملة جديدة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Campaign Creation Wizard Modal --}}
<div class="modal fade" id="wizardModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fas fa-magic" style="color:var(--pink-600);margin-left:6px;"></i> إنشاء حملة إعلانية جديدة</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{-- Step 1: Campaign --}}
                <div class="wizard-step active" id="step-1">
                    <h6 class="fw-bold mb-3">الخطوة 1: إعدادات الحملة</h6>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">الحساب الإعلاني</label>
                        <select class="form-control" id="wizAccount">
                            @foreach($accounts as $acc)<option value="{{ $acc->id }}">{{ $acc->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">اسم الحملة</label>
                        <input type="text" class="form-control" id="wizCampaignName" placeholder="حملة منتجات العناية - مايو 2026">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">الهدف</label>
                            <select class="form-control" id="wizObjective">
                                <option value="OUTCOME_SALES">مبيعات</option>
                                <option value="OUTCOME_TRAFFIC">زيارات الموقع</option>
                                <option value="OUTCOME_ENGAGEMENT">تفاعل</option>
                                <option value="OUTCOME_LEADS">عملاء محتملون</option>
                                <option value="OUTCOME_AWARENESS">الوعي بالعلامة</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">استراتيجية المزايدة</label>
                            <select class="form-control" id="wizBidStrategy">
                                <option value="LOWEST_COST_WITHOUT_CAP">أقل تكلفة</option>
                                <option value="COST_CAP">سقف تكلفة</option>
                                <option value="LOWEST_COST_WITH_BID_CAP">أقل تكلفة مع سقف</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label small fw-bold">الميزانية اليومية (ILS)</label>
                        <input type="number" class="form-control" id="wizDailyBudget" placeholder="50" min="5" step="1">
                    </div>
                    <div class="text-start mt-3">
                        <button class="btn btn-pink" onclick="nextStep(2)">التالي: الاستهداف <i class="fas fa-arrow-left"></i></button>
                    </div>
                </div>

                {{-- Step 2: Targeting --}}
                <div class="wizard-step" id="step-2">
                    <h6 class="fw-bold mb-3">الخطوة 2: استهداف الجمهور</h6>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">اسم مجموعة الإعلانات</label>
                        <input type="text" class="form-control" id="wizAdSetName" placeholder="مجموعة إعلانية 1">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">الحد الأدنى للعمر</label>
                            <input type="number" class="form-control" id="wizAgeMin" value="18" min="13" max="65">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">الحد الأقصى للعمر</label>
                            <input type="number" class="form-control" id="wizAgeMax" value="65" min="13" max="65">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">الجنس</label>
                            <select class="form-control" id="wizGender">
                                <option value="0">الكل</option>
                                <option value="1">ذكور</option>
                                <option value="2">إناث</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">الدول المستهدفة</label>
                        <input type="text" class="form-control" id="wizCountries" value="IL" placeholder="IL, PS, JO">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">المنصات</label>
                        <div class="d-flex gap-3 mt-1">
                            <label class="small"><input type="checkbox" checked id="wizPlatFB"> Facebook</label>
                            <label class="small"><input type="checkbox" checked id="wizPlatIG"> Instagram</label>
                            <label class="small"><input type="checkbox" id="wizPlatMsg"> Messenger</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">هدف التحسين</label>
                        <select class="form-control" id="wizOptGoal">
                            <option value="IMPRESSIONS">مرات الظهور</option>
                            <option value="REACH">الوصول</option>
                            <option value="LINK_CLICKS">نقرات الرابط</option>
                            <option value="CONVERSIONS">التحويلات</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-pink" onclick="prevStep(1)"><i class="fas fa-arrow-right"></i> السابق</button>
                        <button class="btn btn-pink" onclick="nextStep(3)">التالي: الإعلان <i class="fas fa-arrow-left"></i></button>
                    </div>
                </div>

                {{-- Step 3: Creative --}}
                <div class="wizard-step" id="step-3">
                    <h6 class="fw-bold mb-3">الخطوة 3: تصميم الإعلان</h6>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">صفحة Facebook للنشر</label>
                        <select class="form-control" id="wizPageId">
                            <option value="">-- اختر صفحة --</option>
                            @foreach($pages as $p)<option value="{{ $p->page_id }}">{{ $p->page_name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">اسم الإعلان</label>
                        <input type="text" class="form-control" id="wizAdName" placeholder="إعلان منتج 1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">العنوان الرئيسي</label>
                        <input type="text" class="form-control" id="wizTitle" placeholder="اكتشف سر جمالك الطبيعي" maxlength="40">
                        <small class="text-muted">الحد الأقصى 40 حرفاً</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">النص الأساسي</label>
                        <textarea class="form-control" id="wizBody" rows="3" placeholder="منتجات طبيعية %100 للعناية بالبشرة..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">رابط الوجهة</label>
                        <input type="url" class="form-control" id="wizLinkUrl" value="{{ url('/') }}" placeholder="https://...">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">زر CTA</label>
                            <select class="form-control" id="wizCTA">
                                <option value="SHOP_NOW">تسوق الآن</option>
                                <option value="LEARN_MORE">اعرف المزيد</option>
                                <option value="SIGN_UP">سجل الآن</option>
                                <option value="CONTACT_US">اتصل بنا</option>
                                <option value="SUBSCRIBE">اشترك</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">صورة الإعلان</label>
                            <input type="file" class="form-control" id="wizImage" accept="image/*">
                        </div>
                    </div>
                    <input type="hidden" id="wizCreatedCampaignId">
                    <input type="hidden" id="wizCreatedAdSetId">
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-pink" onclick="prevStep(2)"><i class="fas fa-arrow-right"></i> السابق</button>
                        <button class="btn btn-pink" onclick="publishCampaign()"><i class="fas fa-rocket"></i> نشر الحملة</button>
                    </div>
                </div>
                <div id="wizard-alert" class="mt-3"></div>
                <div id="wizard-progress" class="mt-2"></div>
            </div>
        </div>
    </div>
</div>

<div id="insights-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h6 class="modal-title">أداء الحملة</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body" id="insights-body"></div></div></div>
</div>
@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name=csrf-token]')?.content || '';

function a(id, msg, type) { const e = document.getElementById(id); if(e) { e.innerHTML = `<div class="alert alert-${type} py-2 px-3 mb-0 rounded-3 small">${msg}</div>`; setTimeout(() => e.innerHTML = '', 4000); } }

function showConnectForm() { document.getElementById('connect-form').style.display = 'block'; }

function connectAccount() {
    const id = document.getElementById('connectAccountId').value.trim();
    const token = document.getElementById('connectAccessToken').value.trim();
    if(!id||!token) return a('connect-alert','أدخل البيانات','warning');
    fetch('{{ route("admin.ads.connect-account") }}', {
        method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify({ad_account_id:id, access_token:token})
    }).then(r=>r.json()).then(d=>{ a('connect-alert',d.message,d.success?'success':'danger'); if(d.success) setTimeout(()=>location.reload(),1200); });
}

function syncCampaigns(id) {
    fetch('{{ route("admin.ads.sync") }}', {
        method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify({ad_account_id:id})
    }).then(r=>r.json()).then(d=>{ alert(d.message); location.reload(); });
}

function toggleCampaign(id) {
    fetch(`/admin/ads/campaigns/${id}/toggle`, { method:'POST', headers:{'X-CSRF-TOKEN':CSRF} })
    .then(r=>r.json()).then(d=>{ if(d.success) location.reload(); else alert(d.message); });
}

function deleteCampaign(id) {
    if(!confirm('حذف الحملة؟')) return;
    fetch(`/admin/ads/campaigns/${id}`, { method:'DELETE', headers:{'X-CSRF-TOKEN':CSRF} })
    .then(r=>r.json()).then(()=>location.reload());
}

function deleteAccount(id) {
    if(!confirm('حذف الحساب الإعلاني؟')) return;
    fetch(`/admin/ads/accounts/${id}`, { method:'DELETE', headers:{'X-CSRF-TOKEN':CSRF} })
    .then(r=>r.json()).then(()=>location.reload());
}

function loadInsights(id) {
    const modal = new bootstrap.Modal(document.getElementById('insights-modal'));
    const body = document.getElementById('insights-body');
    body.innerHTML = '<div class="text-center py-3"><div class="spinner-border spinner-border-sm"></div></div>';
    modal.show();
    fetch(`/admin/ads/campaigns/${id}/insights`, { method:'POST', headers:{'X-CSRF-TOKEN':CSRF} })
    .then(r=>r.json()).then(d=>{
        if(!d.success){ body.innerHTML = '<div class="alert alert-danger">'+d.message+'</div>'; return; }
        const i = d.insights;
        body.innerHTML = `
            <div class="row g-3">
                <div class="col-6"><div class="ad-stat"><small class="text-muted">الإنفاق</small><div class="fw-bold" style="font-size:1.2rem;">${i.spend} ILS</div></div></div>
                <div class="col-6"><div class="ad-stat"><small class="text-muted">ROAS</small><div class="fw-bold" style="font-size:1.2rem;">${i.roas}x</div></div></div>
                <div class="col-3"><div class="ad-stat text-center"><small class="text-muted">ظهور</small><div class="fw-bold">${parseInt(i.impressions).toLocaleString()}</div></div></div>
                <div class="col-3"><div class="ad-stat text-center"><small class="text-muted">نقرات</small><div class="fw-bold">${parseInt(i.clicks).toLocaleString()}</div></div></div>
                <div class="col-3"><div class="ad-stat text-center"><small class="text-muted">CTR</small><div class="fw-bold">${i.ctr}%</div></div></div>
                <div class="col-3"><div class="ad-stat text-center"><small class="text-muted">CPC</small><div class="fw-bold">${i.cpc} ILS</div></div></div>
                <div class="col-6"><div class="ad-stat text-center"><small class="text-muted">الوصول</small><div class="fw-bold">${parseInt(i.reach).toLocaleString()}</div></div></div>
                <div class="col-6"><div class="ad-stat text-center"><small class="text-muted">التكرار</small><div class="fw-bold">${i.frequency}</div></div></div>
                ${i.conversions && Object.keys(i.conversions).length ? `
                <div class="col-12"><h6 class="fw-bold small mt-2">التحويلات</h6>
                ${Object.entries(i.conversions).map(([k,v])=>`<div class="d-flex justify-content-between small"><span>${k}</span><span class="fw-bold">${v}</span></div>`).join('')}
                </div>` : ''}
            </div>`;
    });
}

function refreshInsights() {
    fetch('{{ route("admin.ads.refresh-insights") }}', { method:'POST', headers:{'X-CSRF-TOKEN':CSRF} })
    .then(r=>r.json()).then(d=>{ alert(d.refreshed + ' حملة تم تحديثها'); location.reload(); });
}

let wizardStep = 1;
function nextStep(n) { document.getElementById('step-'+wizardStep).classList.remove('active'); wizardStep=n; document.getElementById('step-'+n).classList.add('active'); document.getElementById('wizard-alert').innerHTML=''; }
function prevStep(n) { document.getElementById('step-'+wizardStep).classList.remove('active'); wizardStep=n; document.getElementById('step-'+n).classList.add('active'); }

function publishCampaign() {
    const accountId = document.getElementById('wizAccount').value;
    if(!accountId) return a('wizard-alert','اختر حساباً إعلانياً','warning');

    const btn = event.target; btn.disabled = true;
    const progress = document.getElementById('wizard-progress');
    progress.innerHTML = '<div class="small text-muted">جاري إنشاء الحملة...</div>';

    fetch('{{ route("admin.ads.create-campaign") }}', {
        method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify({
            ad_account_id: accountId,
            name: document.getElementById('wizCampaignName').value || 'Campaign '+new Date().toISOString(),
            objective: document.getElementById('wizObjective').value,
            daily_budget: document.getElementById('wizDailyBudget').value || null,
            bid_strategy: document.getElementById('wizBidStrategy').value,
        })
    }).then(r=>r.json()).then(d=>{
        if(!d.success){ a('wizard-alert',d.message,'danger'); btn.disabled=false; return; }
        document.getElementById('wizCreatedCampaignId').value = d.campaign.id;
        progress.innerHTML += '<div class="small text-success">✓ الحملة: '+d.campaign.name+'</div>';

        const countries = document.getElementById('wizCountries').value.split(',').map(s=>s.trim()).filter(Boolean);
        const platforms = [];
        if(document.getElementById('wizPlatFB').checked) platforms.push('facebook');
        if(document.getElementById('wizPlatIG').checked) platforms.push('instagram');
        if(document.getElementById('wizPlatMsg').checked) platforms.push('messenger');
        const gender = parseInt(document.getElementById('wizGender').value);
        const genders = gender === 0 ? [0,2] : [gender];

        const targeting = JSON.stringify({
            geo_locations: { countries },
            age_min: parseInt(document.getElementById('wizAgeMin').value)||18,
            age_max: parseInt(document.getElementById('wizAgeMax').value)||65,
            genders,
            publisher_platforms: platforms,
            facebook_positions: ['feed','story'],
            instagram_positions: ['stream','story'],
            device_platforms: ['mobile','desktop'],
        });

        progress.innerHTML += '<div class="small text-muted">جاري إنشاء مجموعة إعلانية...</div>';

        return fetch('{{ route("admin.ads.create-adset") }}', {
            method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
            body: JSON.stringify({
                ad_account_id: accountId,
                campaign_id: d.campaign.id,
                name: document.getElementById('wizAdSetName').value || 'Ad Set '+new Date().toISOString(),
                optimization_goal: document.getElementById('wizOptGoal').value,
                billing_event: 'IMPRESSIONS',
                daily_budget: 30,
                targeting: targeting,
            })
        });
    }).then(r=>r.json()).then(d=>{
        if(!d||!d.success){ a('wizard-alert',d?.message||'Failed','danger'); btn.disabled=false; return; }
        document.getElementById('wizCreatedAdSetId').value = d.ad_set.id;
        progress.innerHTML += '<div class="small text-success">✓ مجموعة إعلانية: '+d.ad_set.name+'</div>';

        const pageId = document.getElementById('wizPageId').value;

        const imageFile = document.getElementById('wizImage').files[0];
        if(!imageFile) { a('wizard-alert','اختر صورة للإعلان','warning'); btn.disabled=false; return; }

        const fd = new FormData();
        fd.append('ad_account_id', accountId);
        fd.append('name', document.getElementById('wizAdName').value || 'Ad '+new Date().toISOString());
        fd.append('title', document.getElementById('wizTitle').value);
        fd.append('body', document.getElementById('wizBody').value);
        fd.append('link_url', document.getElementById('wizLinkUrl').value);
        fd.append('call_to_action', document.getElementById('wizCTA').value);
        fd.append('page_id', pageId);
        fd.append('image', imageFile);
        fd.append('_token', CSRF);

        progress.innerHTML += '<div class="small text-muted">جاري رفع الصورة وإنشاء الإعلان...</div>';

        return fetch('{{ route("admin.ads.upload-creative") }}', { method:'POST', headers:{'X-CSRF-TOKEN':CSRF}, body: fd });
    }).then(r=>r.json()).then(d=>{
        if(!d||!d.success){ a('wizard-alert',d?.message||'Failed','danger'); btn.disabled=false; return; }
        progress.innerHTML += '<div class="small text-success">✓ Creative: '+d.creative.name+'</div>';

        return fetch('{{ route("admin.ads.create-ad") }}', {
            method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
            body: JSON.stringify({
                ad_account_id: accountId,
                ad_set_id: document.getElementById('wizCreatedAdSetId').value,
                creative_id: d.creative.id,
                name: document.getElementById('wizAdName').value || 'Ad',
            })
        });
    }).then(r=>r.json()).then(d=>{
        btn.disabled=false;
        if(d&&d.success){
            progress.innerHTML += '<div class="small text-success fw-bold">✓ تم نشر الإعلان بنجاح!</div>';
            a('wizard-alert','تم إنشاء الحملة بالكامل! يمكنك تشغيلها من الجدول.','success');
            setTimeout(()=>location.reload(),2000);
        } else {
            a('wizard-alert',d?.message||'فشل نشر الإعلان','danger');
        }
    }).catch(()=>{ btn.disabled=false; a('wizard-alert','خطأ في الاتصال','danger'); });
}
</script>
@endpush
