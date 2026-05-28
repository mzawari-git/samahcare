@extends('admin.layouts.app')
@section('title', 'Facebook Leads Hub')
@push('extra-styles')
<style>
.lead-hub .stat-card{background:#fff;border-radius:14px;padding:1.1rem;border:1px solid var(--gray-200);transition:all .2s}
.lead-hub .stat-card:hover{box-shadow:0 4px 20px rgba(0,0,0,.06)}
.lead-hub .stat-value{font-size:1.5rem;font-weight:800;color:var(--gray-900)}
.lead-hub .stat-label{font-size:.73rem;color:var(--gray-500);margin-top:2px}
.filter-bar{background:#fff;border-radius:14px;padding:1rem 1.25rem;border:1px solid var(--gray-200)}
.filter-bar select, .filter-bar input{font-size:.8rem}
.lead-row{cursor:pointer;transition:background .15s}
.lead-row:hover{background:#fdf2f8}
.lead-row.selected{background:#fce7f3;border-left:3px solid var(--pink-600)}
.stage-hot{background:#FEE2E2;color:#991B1B;padding:2px 10px;border-radius:20px;font-size:.7rem;font-weight:700}
.stage-warm{background:#FEF3C7;color:#92400E;padding:2px 10px;border-radius:20px;font-size:.7rem;font-weight:700}
.stage-engaged{background:#DBEAFE;color:#1E40AF;padding:2px 10px;border-radius:20px;font-size:.7rem;font-weight:700}
.stage-new{background:#D1FAE5;color:#065F46;padding:2px 10px;border-radius:20px;font-size:.7rem;font-weight:700}
.stage-cold{background:#F1F5F9;color:#475569;padding:2px 10px;border-radius:20px;font-size:.7rem;font-weight:700}
.stage-customer{background:#EDE9FE;color:#5B21B6;padding:2px 10px;border-radius:20px;font-size:.7rem;font-weight:700}
.intent-purchase{background:#D1FAE5;color:#065F46;padding:2px 8px;border-radius:12px;font-size:.68rem}
.intent-trust{background:#DBEAFE;color:#1E40AF;padding:2px 8px;border-radius:12px;font-size:.68rem}
.intent-awareness{background:#FEF3C7;color:#92400E;padding:2px 8px;border-radius:12px;font-size:.68rem}
.intent-readiness{background:#E0E7FF;color:#3730A3;padding:2px 8px;border-radius:12px;font-size:.68rem}
.intent-complaint{background:#FEE2E2;color:#991B1B;padding:2px 8px;border-radius:12px;font-size:.68rem}
.gender-male{color:#3b82f6}
.gender-female{color:#ec4899}
.bulk-actions{position:fixed;bottom:20px;left:50%;transform:translateX(-50%);background:var(--gray-900);color:#fff;border-radius:50px;padding:.75rem 1.5rem;box-shadow:0 10px 40px rgba(0,0,0,.3);z-index:1000;display:none;gap:12px;align-items:center}
.bulk-actions.visible{display:flex}
.demographic-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:12px;font-size:.7rem;background:var(--gray-100);color:var(--gray-700)}
</style>
@endpush

@section('content')
<div class="lead-hub">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1"><i class="fas fa-users" style="color:var(--pink-600);margin-left:8px;"></i> Facebook Leads Hub</h1>
            <p class="text-muted small mb-0">إدارة العملاء المتوقعين من فيسبوك - تصفية، رسائل جماعية، تصدير Excel</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-pink btn-sm" onclick="syncLeads()"><i class="fas fa-sync-alt"></i> مزامنة</button>
            <button class="btn btn-pink btn-sm" onclick="syncFromFacebook()"><i class="fab fa-facebook"></i> جلب من فيسبوك</button>
            <a href="{{ route('admin.leads-hub.bulk-campaigns') }}" class="btn btn-outline-pink btn-sm"><i class="fas fa-history"></i> الحملات</a>
            <button class="btn btn-outline-secondary btn-sm" onclick="exportFiltered()"><i class="fas fa-file-excel"></i> تصدير Excel</button>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-auto"><div class="stat-card"><div class="stat-value">{{ $stats['total'] }}</div><div class="stat-label">إجمالي العملاء</div></div></div>
        <div class="col-auto"><div class="stat-card"><div class="stat-value" style="color:#991B1B;">{{ $stats['hot'] }}</div><div class="stat-label">ساخن</div></div></div>
        <div class="col-auto"><div class="stat-card"><div class="stat-value" style="color:#92400E;">{{ $stats['warm'] }}</div><div class="stat-label">دافئ</div></div></div>
        <div class="col-auto"><div class="stat-card"><div class="stat-value" style="color:#065F46;">{{ $stats['purchase_intent'] }}</div><div class="stat-label">نية شراء</div></div></div>
        <div class="col-auto"><div class="stat-card"><div class="stat-value" style="color:#5B21B6;">{{ $stats['customers'] }}</div><div class="stat-label">عملاء</div></div></div>
        <div class="col-auto"><div class="stat-card"><div class="stat-value" style="color:#ec4899;">{{ $stats['female'] }}</div><div class="stat-label">إناث</div></div></div>
        <div class="col-auto"><div class="stat-card"><div class="stat-value" style="color:#3b82f6;">{{ $stats['male'] }}</div><div class="stat-label">ذكور</div></div></div>
        <div class="col-auto"><div class="stat-card"><div class="stat-value" style="color:#0891b2;">{{ $stats['this_week'] }}</div><div class="stat-label">هذا الأسبوع</div></div></div>
    </div>

    {{-- Filters --}}
    <div class="filter-bar mb-3">
        <form id="filterForm" method="GET" class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="form-label small mb-1">الصفحة</label>
                <select name="meta_page_id" class="form-select form-select-sm" onchange="submitFilter()">
                    <option value="">كل الصفحات</option>
                    @foreach($pages as $page)
                    <option value="{{ $page->id }}" {{ request('meta_page_id') == $page->id ? 'selected' : '' }}>{{ $page->page_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label small mb-1">المرحلة</label>
                <select name="stage" class="form-select form-select-sm" onchange="submitFilter()">
                    <option value="">الكل</option>
                    <option value="hot" {{ request('stage') == 'hot' ? 'selected' : '' }}>ساخن</option>
                    <option value="warm" {{ request('warm') == 'warm' ? 'selected' : '' }}>دافئ</option>
                    <option value="engaged" {{ request('engaged') == 'engaged' ? 'selected' : '' }}>متفاعل</option>
                    <option value="new" {{ request('new') == 'new' ? 'selected' : '' }}>جديد</option>
                    <option value="customer" {{ request('stage') == 'customer' ? 'selected' : '' }}>عميل</option>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label small mb-1">الجنس</label>
                <select name="gender" class="form-select form-select-sm" onchange="submitFilter()">
                    <option value="">الكل</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>إناث</option>
                    <option value="male" {{ request('male') == 'male' ? 'selected' : '' }}>ذكور</option>
                    <option value="both" {{ request('both') == 'both' ? 'selected' : '' }}>الكل (ذكر+أنثى)</option>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label small mb-1">العمر</label>
                <select name="age_range" class="form-select form-select-sm" onchange="submitFilter()">
                    <option value="">الكل</option>
                    <option value="18-24" {{ request('age_range') == '18-24' ? 'selected' : '' }}>18-24</option>
                    <option value="25-34" {{ request('age_range') == '25-34' ? 'selected' : '' }}>25-34</option>
                    <option value="35-44" {{ request('age_range') == '35-44' ? 'selected' : '' }}>35-44</option>
                    <option value="45-54" {{ request('age_range') == '45-54' ? 'selected' : '' }}>45-54</option>
                    <option value="55-64" {{ request('age_range') == '55-64' ? 'selected' : '' }}>55-64</option>
                    <option value="65+" {{ request('age_range') == '65+' ? 'selected' : '' }}>65+</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">المدينة</label>
                <select name="city" class="form-select form-select-sm" onchange="submitFilter()">
                    <option value="">كل المدن</option>
                    @foreach($cities as $city)
                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label small mb-1">المصدر</label>
                <select name="source" class="form-select form-select-sm" onchange="submitFilter()">
                    <option value="">الكل</option>
                    <option value="facebook" {{ request('source') == 'facebook' ? 'selected' : '' }}>فيسبوك</option>
                    <option value="instagram" {{ request('instagram') == 'instagram' ? 'selected' : '' }}>انستغرام</option>
                    <option value="website" {{ request('website') == 'website' ? 'selected' : '' }}>الموقع</option>
                    <option value="pixel" {{ request('pixel') == 'pixel' ? 'selected' : '' }}>بكسل</option>
                    <option value="ad" {{ request('ad') == 'ad' ? 'selected' : '' }}>إعلان</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">بحث</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="اسم، PSID، مدينة، إيميل..." value="{{ request('search') }}">
            </div>
            <div class="col-md-1 d-flex gap-1">
                <button type="submit" class="btn btn-pink btn-sm"><i class="fas fa-search"></i></button>
                <a href="{{ route('admin.leads-hub.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-times"></i></a>
            </div>
        </form>
    </div>

    {{-- Leads Table --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-bold small"><i class="fas fa-table" style="color:var(--pink-600);margin-left:6px;"></i> العملاء المتوقعون <span class="badge bg-pink ms-2">{{ $leads->total() }}</span></span>
            <span class="text-muted" style="font-size:.7rem;">اختر العملاء ثم استخدم الشريط السفلي للإرسال</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th width="40"><input type="checkbox" id="selectAll" onchange="toggleSelectAll()"></th>
                            <th>العميل</th>
                            <th>المدينة</th>
                            <th>العمر</th>
                            <th>الجنس</th>
                            <th>المصدر</th>
                            <th>المرحلة</th>
                            <th>النية</th>
                            <th>التقييم</th>
                            <th>آخر نشاط</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                        <tr class="lead-row" data-id="{{ $lead->id }}" onclick="toggleLeadRow(this, {{ $lead->id }})">
                            <td><input type="checkbox" class="lead-checkbox" value="{{ $lead->id }}" onclick="event.stopPropagation()"></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($lead->sender_picture_url)
                                    <img src="{{ $lead->sender_picture_url }}" class="rounded-circle" style="width:32px;height:32px;object-fit:cover;">
                                    @else
                                    <div class="rounded-circle bg-pink-100 d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:.65rem;font-weight:700;color:var(--pink-600);">{{ mb_substr($lead->sender_name ?? 'U', 0, 1) }}</div>
                                    @endif
                                    <div>
                                        <div class="fw-bold" style="font-size:.8rem;">{{ $lead->sender_name ?? 'Unknown' }}</div>
                                        <div class="text-muted" style="font-size:.65rem;">{{ $lead->psid }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="demographic-badge"><i class="fas fa-map-marker-alt" style="font-size:.55rem;"></i> {{ $lead->city ?? '-' }}</span></td>
                            <td><span class="demographic-badge">{{ $lead->age_range ? $lead->age_label : '-' }}</span></td>
                            <td>
                                @if($lead->gender == 'female')<span class="gender-female"><i class="fas fa-venus"></i> أنثى</span>
                                @elseif($lead->gender == 'male')<span class="gender-male"><i class="fas fa-mars"></i> ذكر</span>
                                @else<span class="text-muted">-</span>@endif
                            </td>
                            <td><span class="badge bg-light text-dark">{{ $lead->source }}</span></td>
                            <td><span class="stage-{{ $lead->stage }}">{{ $lead->stage_label }}</span></td>
                            <td>
                                @if($lead->intent)
                                <span class="intent-{{ $lead->intent }}">{{ ['purchase'=>'شراء','trust'=>'ثقة','awareness'=>'وعي','readiness'=>'استعداد','complaint'=>'شكوى'][$lead->intent] ?? $lead->intent }}</span>
                                @else - @endif
                            </td>
                            <td><span class="fw-bold small">{{ $lead->lead_score }}</span></td>
                            <td class="small text-muted">{{ $lead->last_activity_at?->diffForHumans() ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="10" class="text-center text-muted py-4">لا يوجد عملاء متوقعون بعد. قم بربط صفحات فيسبوك لبدء جمع البيانات.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">{{ $leads->appends(request()->query())->links() }}</div>
    </div>
</div>

{{-- Bulk Actions Bar --}}
<div class="bulk-actions" id="bulkBar">
    <span id="selectedCount" class="fw-bold">0</span> <span class="small">محدد</span>
    <button class="btn btn-sm btn-light" onclick="sendBulkMessage()"><i class="fas fa-paper-plane"></i> إرسال رسالة جماعية</button>
    <button class="btn btn-sm btn-outline-light" onclick="exportSelected()"><i class="fas fa-file-excel"></i> تصدير Excel</button>
    <button class="btn btn-sm btn-outline-light" onclick="clearSelection()"><i class="fas fa-times"></i></button>
</div>

{{-- Bulk Message Modal --}}
<div class="modal fade" id="bulkMessageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-paper-plane" style="color:var(--pink-600);margin-left:6px;"></i> إرسال رسالة جماعية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="bulkMsgAlert"></div>
                <div class="mb-3">
                    <label class="form-label">اسم الحملة</label>
                    <input type="text" class="form-control" id="campaignName" placeholder="حملة تسويقية جديدة">
                </div>
                <div class="mb-3">
                    <label class="form-label">نص الرسالة <small class="text-muted">({{ $stats['total'] }} مستخدم متاح)</small></label>
                    <textarea class="form-control" id="messageText" rows="4" maxlength="2000" placeholder="اكتب رسالتك هنا..."></textarea>
                    <small class="text-muted"><span id="charCount">0</span>/2000</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">أزرار الرد السريع (اختياري - حد أقصى 3)</label>
                    <div class="row g-2" id="quickRepliesContainer">
                        <div class="col-4"><input type="text" class="form-control form-control-sm quick-reply" placeholder="زر 1" maxlength="20"></div>
                        <div class="col-4"><input type="text" class="form-control form-control-sm quick-reply" placeholder="زر 2" maxlength="20"></div>
                        <div class="col-4"><input type="text" class="form-control form-control-sm quick-reply" placeholder="زر 3" maxlength="20"></div>
                    </div>
                </div>
                <div class="alert alert-info small mb-0">
                    <i class="fas fa-info-circle"></i> سيتم الإرسال فقط للمستخدمين الذين تفاعلوا مع الصفحة خلال 24 ساعة (سياسة فيسبوك). المستخدمين غير المؤهلين سيتم تخطيهم.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-pink" onclick="executeBulkSend()"><i class="fas fa-paper-plane"></i> إرسال الآن</button>
            </div>
        </div>
    </div>
</div>

<script>
let selectedLeads = new Set();

function toggleLeadRow(row, id) {
    const checkbox = row.querySelector('.lead-checkbox');
    checkbox.checked = !checkbox.checked;
    if (checkbox.checked) { selectedLeads.add(id); row.classList.add('selected'); }
    else { selectedLeads.delete(id); row.classList.remove('selected'); }
    updateBulkBar();
}

function toggleSelectAll() {
    const all = document.getElementById('selectAll').checked;
    document.querySelectorAll('.lead-checkbox').forEach(cb => {
        cb.checked = all;
        const id = parseInt(cb.value);
        if (all) { selectedLeads.add(id); cb.closest('.lead-row').classList.add('selected'); }
        else { selectedLeads.delete(id); cb.closest('.lead-row').classList.remove('selected'); }
    });
    updateBulkBar();
}

function updateBulkBar() {
    const bar = document.getElementById('bulkBar');
    document.getElementById('selectedCount').textContent = selectedLeads.size;
    if (selectedLeads.size > 0) bar.classList.add('visible');
    else bar.classList.remove('visible');
}

function clearSelection() {
    selectedLeads.clear();
    document.querySelectorAll('.lead-checkbox').forEach(cb => { cb.checked = false; cb.closest('.lead-row').classList.remove('selected'); });
    updateBulkBar();
}

function sendBulkMessage() {
    if (selectedLeads.size === 0) { alert('اختر عميلاً واحداً على الأقل'); return; }
    new bootstrap.Modal(document.getElementById('bulkMessageModal')).show();
}

function executeBulkSend() {
    const name = document.getElementById('campaignName').value.trim();
    const msg = document.getElementById('messageText').value.trim();
    if (!name || !msg) { document.getElementById('bulkMsgAlert').innerHTML = '<div class="alert alert-danger py-1">الرجاء إدخال اسم الحملة ونص الرسالة</div>'; return; }

    const replies = [];
    document.querySelectorAll('.quick-reply').forEach(el => { if (el.value.trim()) replies.push(el.value.trim()); });

    document.getElementById('bulkMsgAlert').innerHTML = '<div class="alert alert-info py-1">جاري الإرسال...</div>';

    fetch('{{ route("admin.leads-hub.bulk-message") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
        body: JSON.stringify({ name, message_text: msg, quick_replies: replies.length ? replies : null, lead_ids: Array.from(selectedLeads).join(',') })
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            document.getElementById('bulkMsgAlert').innerHTML = '<div class="alert alert-success py-1"><i class="fas fa-check-circle"></i> ' + d.message + '</div>';
            setTimeout(() => { bootstrap.Modal.getInstance(document.getElementById('bulkMessageModal')).hide(); clearSelection(); }, 1500);
        } else {
            document.getElementById('bulkMsgAlert').innerHTML = '<div class="alert alert-danger py-1">' + d.message + '</div>';
        }
    })
    .catch(() => { document.getElementById('bulkMsgAlert').innerHTML = '<div class="alert alert-danger py-1">حدث خطأ</div>'; });
}

function exportSelected() {
    if (selectedLeads.size === 0) { alert('اختر عميلاً واحداً على الأقل'); return; }
    window.location.href = '{{ route("admin.leads-hub.export-selected") }}?ids=' + Array.from(selectedLeads).join(',');
}

function exportFiltered() {
    const form = document.getElementById('filterForm');
    const params = new URLSearchParams(new FormData(form)).toString();
    window.location.href = '{{ route("admin.leads-hub.export") }}?' + params;
}

function submitFilter() { document.getElementById('filterForm').submit(); }

function syncLeads() {
    const btn = event.target.closest('button');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري المزامنة...';
    fetch('{{ route("admin.leads-hub.sync") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
    })
    .then(r => r.json())
    .then(d => {
        btn.innerHTML = '<i class="fas fa-check-circle"></i> تمت المزامنة';
        btn.className = 'btn btn-success btn-sm';
        setTimeout(() => { location.reload(); }, 1500);
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-sync-alt"></i> مزامنة';
    });
}

function syncFromFacebook() {
    const btn = event.target.closest('button');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الجلب من فيسبوك...';
    fetch('{{ route("admin.leads-hub.sync-facebook") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
    })
    .then(r => r.json())
    .then(d => {
        btn.innerHTML = '<i class="fas fa-check-circle"></i> ' + d.message;
        btn.className = 'btn btn-success btn-sm';
        setTimeout(() => { location.reload(); }, 2000);
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fab fa-facebook"></i> جلب من فيسبوك';
    });
}

document.getElementById('messageText').addEventListener('input', function() {
    document.getElementById('charCount').textContent = this.value.length;
});
</script>
@endsection
