@extends('admin.layouts.app')
@section('title', 'الخدمات')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">الخدمات</h5>
    <a href="{{ route('admin.services.create') }}" class="btn btn-pink">
        <i class="fas fa-plus"></i> إضافة خدمة
    </a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>السعر</th>
                    <th>سعر الخصم</th>
                    <th>المدة</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{{ $service->name_ar }}</td>
                    <td>{{ number_format($service->price) }} ₪</td>
                    <td>{{ $service->discount_price ? number_format($service->discount_price) . ' ₪' : '-' }}</td>
                    <td>{{ $service->duration ?? '-' }}</td>
                    <td>{{ $service->sort_order }}</td>
                    <td>
                        <span class="badge bg-{{ $service->is_active ? 'success' : 'secondary' }}">
                            {{ $service->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-outline-pink">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.services.toggle', $service->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-{{ $service->is_active ? 'eye-slash' : 'eye' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الخدمة؟')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">لا توجد خدمات</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $services->links() }}
@endsection
