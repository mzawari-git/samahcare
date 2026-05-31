@extends('admin.layouts.app')
@section('title', 'تعديل خدمة')
@section('content')
<div class="card">
    <div class="card-header">تعديل الخدمة: {{ $service->name_ar }}</div>
    <div class="card-body">
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">الاسم (عربي) *</label>
                    <input type="text" name="name_ar" class="form-control" required value="{{ old('name_ar', $service->name_ar) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">الاسم (إنجليزي)</label>
                    <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $service->name_en) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">السعر *</label>
                    <input type="number" step="0.01" name="price" class="form-control" required value="{{ old('price', $service->price) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">سعر الخصم</label>
                    <input type="number" step="0.01" name="discount_price" class="form-control" value="{{ old('discount_price', $service->discount_price) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">المدة</label>
                    <input type="text" name="duration" class="form-control" placeholder="مثال: 60 دقيقة" value="{{ old('duration', $service->duration) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ترتيب العرض</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $service->sort_order) }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label">الوصف (عربي)</label>
                    <textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar', $service->description_ar) }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label">الوصف (إنجليزي)</label>
                    <textarea name="description_en" class="form-control" rows="3">{{ old('description_en', $service->description_en) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الصورة</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @if($service->image)
                        <small class="text-muted">الصورة الحالية: {{ $service->image }}</small>
                    @endif
                </div>
                <div class="col-md-6 d-flex align-items-end gap-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" {{ $service->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">نشط</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" class="form-check-input" id="isFeatured" value="1" {{ $service->is_featured ? 'checked' : '' }}>
                        <label class="form-check-label" for="isFeatured">مميز</label>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-pink">حفظ التغييرات</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
