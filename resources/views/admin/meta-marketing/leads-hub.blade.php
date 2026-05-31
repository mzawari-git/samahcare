@extends('admin.layouts.app')

@section('title', 'إدارة العملاء المحتملين')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">
                <i class="fab fa-facebook text-primary me-2"></i>إدارة العملاء المحتملين
            </h4>
            <p class="text-muted mb-0 small">مزامنة وتصنيف وإدارة عملاء فيسبوك المحتملين</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-success btn-sm" onclick="syncLeads()">
                <i class="fas fa-sync me-1"></i>مزامنة من Facebook
            </button>
            <button class="btn btn-outline-primary btn-sm" onclick="exportLeads()">
                <i class="fas fa-file-export me-1"></i>تصدير
            </button>
            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#bulkMessageModal">
                <i class="fas fa-paper-plane me-1"></i>رسالة جماعية
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-muted small">إجمالي العملاء</div>
                            <div class="fs-3 fw-bold text-primary">{{ $stats['total'] ?? 0 }}</div>
                        </div>
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width:48px;height:48px;">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-muted small">اليوم</div>
                            <div class="fs-3 fw-bold text-success">{{ $stats['today'] ?? 0 }}</div>
                        </div>
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10" style="width:48px;height:48px;">
                            <i class="fas fa-calendar-day text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-muted small">دافئون (Hot)</div>
                            <div class="fs-3 fw-bold text-danger">{{ $stats['hot'] ?? 0 }}</div>
                        </div>
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10" style="width:48px;height:48px;">
                            <i class="fas fa-fire text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-muted small">متوسط التقييم</div>
                            <div class="fs-3 fw-bold text-warning">{{ $stats['avg_score'] ?? 0 }}</div>
                        </div>
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning bg-opacity-10" style="width:48px;height:48px;">
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.leads-hub.index') }}" class="row g-2">
                <div class="col-md-2">
                    <select class="form-select form-select-sm" name="stage">
                        <option value="">جميع المراحل</option>
                        <option value="hot" {{ request('stage') === 'hot' ? 'selected' : '' }}>دافئ (Hot)</option>
                        <option value="warm" {{ request('stage') === 'warm' ? 'selected' : '' }}>متوسط (Warm)</option>
                        <option value="engaged" {{ request('stage') === 'engaged' ? 'selected' : '' }}>تفاعل (Engaged)</option>
                        <option value="new" {{ request('stage') === 'new' ? 'selected' : '' }}>جديد (New)</option>
                        <option value="cold" {{ request('stage') === 'cold' ? 'selected' : '' }}>بارد (Cold)</option>
                        <option value="customer" {{ request('stage') === 'customer' ? 'selected' : '' }}>عميل (Customer)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control form-control-sm" name="search" placeholder="بحث بالاسم أو البريد..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control form-control-sm" name="min_score" placeholder="الحد الأدنى للتقييم" value="{{ request('min_score') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control form-control-sm" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control form-control-sm" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary w-100"><i class="fas fa-filter me-1"></i>تصفية</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Leads Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($leads->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-3">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th class="border-0">العميل</th>
                                <th class="border-0">التواصل</th>
                                <th class="border-0">المصدر</th>
                                <th class="border-0">التقييم</th>
                                <th class="border-0">المراحل</th>
                                <th class="border-0">النية</th>
                                <th class="border-0">التفاعل</th>
                                <th class="border-0 text-center">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leads as $lead)
                            <tr>
                                <td class="px-3">
                                    <input type="checkbox" class="form-check-input lead-check" value="{{ $lead->id }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                                            <span class="fw-bold text-primary">{{ mb_substr($lead->sender_name ?? '?', 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $lead->sender_name ?? 'غير معروف' }}</div>
                                            <small class="text-muted">#{{ $lead->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @if($lead->email)
                                            <small><i class="fas fa-envelope me-1 text-muted"></i>{{ $lead->email }}</small><br>
                                        @endif
                                        @if($lead->phone)
                                            <small dir="ltr"><i class="fas fa-phone me-1 text-muted"></i>{{ $lead->phone }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $lead->source_campaign ?? $lead->source }}</small>
                                </td>
                                <td>
                                    <span class="fw-bold {{ $lead->lead_score >= 70 ? 'text-danger' : ($lead->lead_score >= 40 ? 'text-warning' : 'text-muted') }}">
                                        {{ $lead->lead_score }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $stageColors = ['hot' => 'danger', 'warm' => 'warning', 'engaged' => 'info', 'new' => 'secondary', 'cold' => 'dark', 'customer' => 'success'];
                                        $stageLabels = ['hot' => 'دافئ', 'warm' => 'متوسط', 'engaged' => 'تفاعل', 'new' => 'جديد', 'cold' => 'بارد', 'customer' => 'عميل'];
                                    @endphp
                                    <span class="badge bg-{{ $stageColors[$lead->stage] ?? 'secondary' }}">
                                        {{ $stageLabels[$lead->stage] ?? $lead->stage }}
                                    </span>
                                </td>
                                <td>
                                    @if($lead->intent)
                                        <span class="badge bg-light text-dark">{{ $lead->intent }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $lead->total_interactions }} تفاعل</small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" onclick="viewLead({{ $lead->id }})" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary" onclick="updateScore({{ $lead->id }}, {{ $lead->lead_score }})" title="تحديث التقييم">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-top">
                    {{ $leads->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fab fa-facebook fa-4x text-muted mb-3 opacity-25"></i>
                    <h5 class="text-muted">لا يوجد عملاء محتملون</h5>
                    <p class="text-muted">قم بمزامنة العملاء من Facebook لبدء إدارة العملاء المحتملين</p>
                    <button class="btn btn-primary" onclick="syncLeads()">
                        <i class="fas fa-sync me-2"></i>مزامنة الآن
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Message Modal -->
<div class="modal fade" id="bulkMessageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-paper-plane me-2"></i>رسالة جماعية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">الرسالة</label>
                    <textarea class="form-control" id="bulkMessage" rows="4" placeholder="اكتب رسالتك هنا..."></textarea>
                    <small class="text-muted">سيتم إرسال الرسالة إلى جميع العملاء المحددين</small>
                </div>
                <div id="selectedCount" class="text-muted small"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" onclick="sendBulkMessage()">إرسال</button>
            </div>
        </div>
    </div>
</div>

<script>
function syncLeads() {
    if (!confirm('هل تريد مزامنة العملاء من Facebook؟')) return;

    fetch('{{ route("admin.leads-hub.sync") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            location.reload();
        } else {
            alert('❌ ' + (data.message || 'فشلت المزامنة'));
        }
    })
    .catch(err => alert('خطأ: ' + err.message));
}

function exportLeads() {
    window.location.href = '{{ route("admin.leads-hub.export") }}';
}

function viewLead(id) {
    window.location.href = '{{ url("admin/leads-hub") }}/' + id;
}

function updateScore(id, current) {
    const score = prompt('أدخل التقييم الجديد (0-100):', current);
    if (score === null) return;

    fetch(`/admin/leads-hub/${id}/score`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ score: parseInt(score) }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('❌ ' + data.message);
        }
    });
}

function sendBulkMessage() {
    const checked = document.querySelectorAll('.lead-check:checked');
    const message = document.getElementById('bulkMessage').value;

    if (checked.length === 0) {
        alert('يجب تحديد عميل واحد على الأقل');
        return;
    }

    if (!message.trim()) {
        alert('يجب كتابة رسالة');
        return;
    }

    const ids = Array.from(checked).map(c => c.value);

    fetch('{{ route("admin.leads-hub.bulk-message") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ lead_ids: ids, message: message }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            bootstrap.Modal.getInstance(document.getElementById('bulkMessageModal')).hide();
            location.reload();
        } else {
            alert('❌ ' + (data.message || 'فشل الإرسال'));
        }
    });
}

document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('.lead-check').forEach(c => c.checked = this.checked);
});

document.querySelectorAll('.lead-check').forEach(c => {
    c.addEventListener('change', function() {
        const count = document.querySelectorAll('.lead-check:checked').length;
        document.getElementById('selectedCount').textContent = count > 0 ? `تم تحديد ${count} عميل محتمل` : '';
    });
});
</script>
@endsection
