@extends('admin.layouts.app')

@section('title', 'SEO Management')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold"><i class="fas fa-search text-success me-2"></i>SEO Management</h4>
            <p class="text-muted mb-0 small">إدارة محركات البحث - Meta Tags, Schema Markup, Keywords</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-success btn-sm" onclick="generateAll()">
                <i class="fas fa-magic me-1"></i>Auto Generate All
            </button>
            <button class="btn btn-outline-primary btn-sm" onclick="aiGenerateAll()">
                <i class="fas fa-brain me-1"></i>AI Generate All
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold text-primary">{{ $stats['total'] ?? 0 }}</div>
                    <div class="text-muted small">إجمالي الصفحات</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold text-success">{{ $stats['seo_ready'] ?? 0 }}</div>
                    <div class="text-muted small">SEO جاهز</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold text-warning">{{ $stats['missing_meta'] ?? 0 }}</div>
                    <div class="text-muted small">يحتاج Meta Tags</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold text-info">{{ $stats['blog_missing_seo'] ?? 0 }}</div>
                    <div class="text-muted small">مقالات بدون SEO</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pages Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>SEO Status - All Pages</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-3">الصفحة</th>
                            <th class="border-0">Meta Title</th>
                            <th class="border-0">Meta Description</th>
                            <th class="border-0">Keywords</th>
                            <th class="border-0">Schema</th>
                            <th class="border-0">الحالة</th>
                            <th class="border-0 text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                        <tr>
                            <td class="px-3">
                                <div class="fw-bold">{{ $page['title'] }}</div>
                                <small class="text-muted">{{ $page['key'] }}</small>
                            </td>
                            <td>
                                <small class="d-block" style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                    {{ $page['meta_title'] ?: '-' }}
                                </small>
                                <small class="text-muted">{{ strlen($page['meta_title'] ?? '') }}/60</small>
                            </td>
                            <td>
                                <small class="d-block" style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                    {{ $page['meta_description'] ?: '-' }}
                                </small>
                                <small class="text-muted">{{ strlen($page['meta_description'] ?? '') }}/160</small>
                            </td>
                            <td>
                                <small class="d-block" style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                    {{ $page['keywords'] ?: '-' }}
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $page['schema_type'] }}</span>
                            </td>
                            <td>
                                @if($page['is_saved'])
                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>مُحفوظ</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="fas fa-exclamation me-1"></i>افتراضي</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.seo.edit', $page['key']) }}" class="btn btn-outline-primary" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-outline-success" onclick="autoGenerate('{{ $page['key'] }}')" title="توليد تلقائي">
                                        <i class="fas fa-magic"></i>
                                    </button>
                                    <button class="btn btn-outline-info" onclick="viewSchema('{{ $page['key'] }}')" title="Schema Markup">
                                        <i class="fas fa-code"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3 opacity-25"></i>
                                <h5 class="text-muted">لا توجد صفحات</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Schema Modal -->
<div class="modal fade" id="schemaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-code me-2"></i>Schema Markup (JSON-LD)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre id="schemaOutput" class="bg-light p-3 rounded" style="max-height:400px;overflow:auto;font-size:12px;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary" onclick="copySchema()"><i class="fas fa-copy me-1"></i>نسخ</button>
            </div>
        </div>
    </div>
</div>

<script>
function generateAll() {
    if (!confirm('هل تريد توليد SEO لجميع الصفحات غير المُحفوظة؟')) return;
    window.location.href = '{{ route("admin.seo.auto-all") }}';
}

function aiGenerateAll() {
    if (!confirm('هل تريد توليد SEO بالذكاء الاصطناعي لجميع الصفحات؟')) return;
    window.location.href = '{{ route("admin.seo.ai-all") }}';
}

function autoGenerate(key) {
    window.location.href = '/admin/seo/' + key + '/auto';
}

function viewSchema(key) {
    fetch('/admin/seo/' + key + '/schema')
        .then(r => r.json())
        .then(data => {
            document.getElementById('schemaOutput').textContent = JSON.stringify(data, null, 2);
            new bootstrap.Modal(document.getElementById('schemaModal')).show();
        })
        .catch(err => alert('خطأ: ' + err.message));
}

function copySchema() {
    const text = document.getElementById('schemaOutput').textContent;
    navigator.clipboard.writeText(text).then(() => alert('تم النسخ'));
}
</script>
@endsection
