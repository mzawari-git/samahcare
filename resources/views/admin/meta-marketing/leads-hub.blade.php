@extends('admin.layouts.app')
@section('title', 'عملاء فيسبوك')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h1 class="h4 mb-1"><i class="fas fa-users" style="color:var(--pink-600);margin-left:8px;"></i> عملاء فيسبوك</h1><p class="text-muted small mb-0">Facebook Leads Hub — إدارة واستيراد العملاء المتوقعين</p></div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.leads-hub.export') }}" class="btn btn-outline-success btn-sm"><i class="fas fa-file-excel"></i> تصدير</a>
        <a href="{{ route('admin.leads-hub.sync-facebook') }}" class="btn btn-pink btn-sm"><i class="fas fa-sync-alt"></i> مزامنة</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card-new">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon-new" style="background:linear-gradient(135deg,#1877F2,#0D6EFD);color:#fff;"><i class="fas fa-users"></i></div>
                <div class="small text-muted">إجمالي العملاء</div>
            </div>
            <div class="stat-value-new">{{ $totalLeads ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-new">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon-new" style="background:linear-gradient(135deg,#10B981,#059669);color:#fff;"><i class="fas fa-calendar-check"></i></div>
                <div class="small text-muted">اليوم</div>
            </div>
            <div class="stat-value-new">{{ $syncedToday ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-new">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon-new" style="background:linear-gradient(135deg,#f59e0b,#D97706);color:#fff;"><i class="fas fa-hourglass-half"></i></div>
                <div class="small text-muted">بانتظار المزامنة</div>
            </div>
            <div class="stat-value-new">0</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-new">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon-new" style="background:linear-gradient(135deg,#EC4899,#DB2777);color:#fff;"><i class="fas fa-check-double"></i></div>
                <div class="small text-muted">تم التواصل</div>
            </div>
            <div class="stat-value-new">{{ $contactedLeads ?? 0 }}</div>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-auto flex-grow-1">
                <label class="small text-muted">بحث</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="اسم، بريد، هاتف..." value="{{ request('search') }}">
            </div>
            <div class="col-auto">
                <label class="small text-muted">المصدر</label>
                <select name="source" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">الكل</option>
                    <option value="facebook" {{ request('source') === 'facebook' ? 'selected' : '' }}>فيسبوك</option>
                    <option value="instagram" {{ request('source') === 'instagram' ? 'selected' : '' }}>انستغرام</option>
                    <option value="manual" {{ request('source') === 'manual' ? 'selected' : '' }}>يدوي</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-pink"><i class="fas fa-search"></i></button>
                @if(request()->anyFilled(['search','source']))
                <a href="{{ route('admin.leads-hub.index') }}" class="btn btn-sm btn-outline-secondary">إلغاء</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light fw-bold d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list" style="color:var(--pink-600);margin-left:6px;"></i> قائمة العملاء</span>
        <small class="text-muted">{{ $totalLeads ?? 0 }} عميل</small>
    </div>
    <div class="card-body p-0">
        @if(($leads->count() ?? 0) > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>الاسم</th>
                        <th>البريد</th>
                        <th>الهاتف</th>
                        <th>المصدر</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($leads as $lead)
                <tr>
                    <td><b>{{ $lead->name ?? '-' }}</b></td>
                    <td class="small">{{ $lead->email ?? '-' }}</td>
                    <td dir="ltr" class="small">{{ $lead->phone ?? '-' }}</td>
                    <td><span class="badge bg-secondary">{{ $lead->source ?? '-' }}</span></td>
                    <td>
                        @if(($lead->contacted ?? false))
                            <span class="badge bg-success">تم التواصل</span>
                        @else
                            <span class="badge bg-warning text-dark">جديد</span>
                        @endif
                    </td>
                    <td><small class="text-muted">{{ $lead->created_at ?? '' }}</small></td>
                    <td>
                        @if(isset($lead->id))
                        <a href="{{ route('admin.leads-hub.show', $lead->id) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-muted text-center py-5 mb-0"><i class="fas fa-inbox d-block mb-2" style="font-size:2rem;opacity:.3;"></i>لا يوجد عملاء بعد</p>
        @endif
    </div>
    @if(method_exists($leads, 'links'))
    <div class="card-footer">{{ $leads->links() }}</div>
    @endif
</div>
@endsection
