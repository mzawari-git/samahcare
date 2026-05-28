@extends('admin.layouts.app')
@section('title', 'إدارة الإعلانات')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h1 class="h4 mb-1"><i class="fas fa-ad" style="color:var(--pink-600);margin-left:8px;"></i> إدارة الإعلانات</h1><p class="text-muted small mb-0">إنشاء وإدارة الحملات الإعلانية — الميزة قيد التطوير</p></div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="stat-card-new"><div class="stat-meta-icon" style="background:#1877F2;color:#fff"><i class="fas fa-bullhorn"></i></div><div class="stat-value-new">{{ $campaigns->count() ?? 0 }}</div><div class="stat-label-new">الحملات</div></div></div>
    <div class="col-md-3"><div class="stat-card-new"><div class="stat-meta-icon" style="background:#10B981;color:#fff"><i class="fas fa-play"></i></div><div class="stat-value-new">{{ $activeCount ?? 0 }}</div><div class="stat-label-new">نشطة</div></div></div>
    <div class="col-md-3"><div class="stat-card-new"><div class="stat-meta-icon" style="background:#f59e0b;color:#fff"><i class="fas fa-pause"></i></div><div class="stat-value-new">{{ $pausedCount ?? 0 }}</div><div class="stat-label-new">متوقفة</div></div></div>
    <div class="col-md-3"><div class="stat-card-new"><div class="stat-meta-icon" style="background:#8B5CF6;color:#fff"><i class="fas fa-image"></i></div><div class="stat-value-new">{{ $creatives->count() ?? 0 }}</div><div class="stat-label-new">إعلانات جاهزة</div></div></div>
</div>

<div class="card">
    <div class="card-header bg-light fw-bold d-flex justify-content-between align-items-center">
        <span><i class="fas fa-facebook" style="color:#1877F2;margin-left:6px;"></i> حسابات الإعلانات</span>
    </div>
    <div class="card-body">
        @forelse($accounts ?? [] as $acc)
        <div class="border rounded-3 p-3 mb-2"><b>{{ $acc->name ?? '-' }}</b> <span class="text-muted small">{{ $acc->ad_account_id ?? '' }}</span></div>
        @empty
        <p class="text-muted text-center py-3 mb-0">لا توجد حسابات إعلانية متصلة</p>
        @endforelse
    </div>
</div>
@endsection
