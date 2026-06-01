@extends('admin.layouts.app')
@section('title', 'الخدمات')
@push('styles')
<style>
.service-stat-card {
    background: #fff; border-radius: 16px; padding: 1.25rem 1.5rem;
    border: 1px solid #e2e8f0; transition: all .3s;
    display: flex; align-items: center; gap: 1rem;
}
.service-stat-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,.06); transform: translateY(-2px);
}
.service-stat-card .stat-icon {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center; font-size: 1.25rem;
}
.service-stat-card .stat-info { flex: 1; }
.service-stat-card .stat-number { font-size: 1.5rem; font-weight: 800; color: #1e293b; line-height: 1.2; }
.service-stat-card .stat-label { font-size: .8rem; color: #94a3b8; font-weight: 500; }

.filter-bar { background: #fff; border-radius: 1rem; padding: 1rem 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,.04); }

.service-row { transition: all .2s; }
.service-row:hover { background: #fdf2f8 !important; }
.service-row td { vertical-align: middle; padding: .85rem .75rem; }

.badge-cat {
    font-size: .7rem; font-weight: 600; padding: .2rem .6rem;
    border-radius: 999px; display: inline-flex; align-items: center; gap: .3rem;
}
.toggle-btn {
    width: 36px; height: 36px; border-radius: 10px; border: none;
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .25s;
}
.toggle-btn:hover { transform: scale(1.1); }
.toggle-btn.active { background: #dcfce7; color: #16a34a; }
.toggle-btn.inactive { background: #f1f5f9; color: #94a3b8; }
.toggle-btn.inactive:hover { background: #fef2f2; color: #dc2626; }

.empty-state { text-align: center; padding: 3rem 1rem; }
.empty-state i { font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem; display: block; }
.empty-state p { color: #94a3b8; font-size: .95rem; }

.sort-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 28px; height: 28px; border-radius: 8px; background: #f1f5f9;
    color: #64748b; font-weight: 700; font-size: .75rem;
}
</style>
@endpush
@section('content')
@php
$catLabels = ['face' => 'العناية بالوجه', 'body' => 'العناية بالجسم', 'extremities' => 'سبا الأطراف'];
$catColors = ['face' => '#f472b6', 'body' => '#34d399', 'extremities' => '#a78bfa'];
@endphp

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="service-stat-card">
            <div class="stat-icon" style="background:#fdf2f8;color:#ec4899;"><i class="fas fa-spa"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $stats['total'] }}</div>
                <div class="stat-label">إجمالي الخدمات</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="service-stat-card">
            <div class="stat-icon" style="background:#dcfce7;color:#16a34a;"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $stats['active'] }}</div>
                <div class="stat-label">نشطة</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="service-stat-card">
            <div class="stat-icon" style="background:#f1f5f9;color:#94a3b8;"><i class="fas fa-eye-slash"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $stats['inactive'] }}</div>
                <div class="stat-label">غير نشطة</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="service-stat-card">
            <div class="stat-icon" style="background:#fef3c7;color:#d97706;"><i class="fas fa-star"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $stats['featured'] }}</div>
                <div class="stat-label">مميزة</div>
            </div>
        </div>
    </div>
</div>

{{-- Header + Add --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0" style="color:#1e293b;">
        <i class="fas fa-spa ml-2" style="color:#ec4899;"></i> إدارة الخدمات
    </h5>
    <a href="{{ route('admin.services.create') }}" class="btn btn-pink">
        <i class="fas fa-plus"></i> إضافة خدمة
    </a>
</div>

{{-- Filter Bar --}}
<form method="GET" class="filter-bar mb-3">
    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label mb-0" style="font-size:.8rem;font-weight:600;color:#64748b;">بحث</label>
            <input type="text" name="search" class="form-control form-control-sm" placeholder="اسم الخدمة ..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label mb-0" style="font-size:.8rem;font-weight:600;color:#64748b;">القسم</label>
            <select name="category" class="form-select form-select-sm">
                <option value="">كل الأقسام</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $catLabels[$cat] ?? $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label mb-0" style="font-size:.8rem;font-weight:600;color:#64748b;">الحالة</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">الكل</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-1">
            <button type="submit" class="btn btn-pink btn-sm flex-fill"><i class="fas fa-search"></i></button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary btn-sm flex-fill"><i class="fas fa-times"></i></a>
        </div>
    </div>
</form>

{{-- Table --}}
<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>الخدمة</th>
                    <th>القسم</th>
                    <th style="width:100px;">السعر</th>
                    <th style="width:100px;">سعر الخصم</th>
                    <th style="width:80px;">المدة</th>
                    <th style="width:60px;">الترتيب</th>
                    <th style="width:100px;">الحالة</th>
                    <th style="width:140px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr class="service-row">
                    <td class="text-muted" style="font-size:.85rem;">{{ $service->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="" style="width:40px;height:40px;border-radius:10px;object-fit:cover;">
                            @else
                                <div style="width:40px;height:40px;border-radius:10px;background:var(--pink-50);display:flex;align-items:center;justify-content:center;color:var(--pink-500);font-size:.9rem;">
                                    <i class="fas fa-spa"></i>
                                </div>
                            @endif
                            <div>
                                <div style="font-weight:600;color:#1e293b;">{{ $service->name_ar }}</div>
                                @if($service->name_en)
                                    <small style="color:#94a3b8;font-size:.7rem;">{{ $service->name_en }}</small>
                                @endif
                                @if($service->is_featured)
                                    <span class="badge bg-warning text-dark" style="font-size:.6rem;font-weight:700;"><i class="fas fa-star"></i> مميز</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($service->category)
                            <span class="badge-cat" style="background:{{ $catColors[$service->category] ?? '#e2e8f0' }}18;color:{{ $catColors[$service->category] ?? '#64748b' }};">
                                <i class="fas fa-tag" style="font-size:.55rem;"></i>
                                {{ $catLabels[$service->category] ?? $service->category }}
                            </span>
                        @else
                            <span class="text-muted" style="font-size:.8rem;">—</span>
                        @endif
                    </td>
                    <td style="font-weight:700;color:#1e293b;">{{ number_format($service->price) }} <small style="font-size:.65rem;color:#94a3b8;">₪</small></td>
                    <td>
                        @if($service->discount_price)
                            <span style="color:#16a34a;font-weight:700;">{{ number_format($service->discount_price) }} <small style="font-size:.65rem;color:#94a3b8;">₪</small></span>
                            <small style="display:block;font-size:.6rem;color:#94a3b8;text-decoration:line-through;">{{ number_format($service->price) }} ₪</small>
                        @else
                            <span class="text-muted" style="font-size:.8rem;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($service->duration)
                            <span style="font-size:.82rem;color:#475569;"><i class="far fa-clock ml-1" style="font-size:.65rem;color:#94a3b8;"></i> {{ $service->duration }}</span>
                        @else
                            <span class="text-muted" style="font-size:.8rem;">—</span>
                        @endif
                    </td>
                    <td><span class="sort-badge">{{ $service->sort_order }}</span></td>
                    <td>
                        <form action="{{ route('admin.services.toggle', $service->id) }}" method="POST" id="toggleForm{{ $service->id }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="toggle-btn {{ $service->is_active ? 'active' : 'inactive' }}" title="{{ $service->is_active ? 'إيقاف' : 'تفعيل' }}">
                                <i class="fas {{ $service->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                            </button>
                        </form>
                        <span class="badge bg-{{ $service->is_active ? 'success' : 'secondary' }}" style="font-size:.72rem;font-weight:600;">
                            {{ $service->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-outline-pink" title="تعديل" style="border-radius:8px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف {{ $service->name_ar }}؟')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف" style="border-radius:8px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="fas fa-spa"></i>
                            <p>لا توجد خدمات حالياً</p>
                            <a href="{{ route('admin.services.create') }}" class="btn btn-pink btn-sm">
                                <i class="fas fa-plus"></i> إضافة أول خدمة
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 fade-in-up">
    {{ $services->links() }}
</div>
@endsection