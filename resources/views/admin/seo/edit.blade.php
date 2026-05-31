@extends('admin.layouts.app')

@section('title', 'تعديل SEO - ' . ($page['title'] ?? ''))

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">
                <i class="fas fa-edit text-primary me-2"></i>تعديل SEO
                <span class="text-muted fs-6">{{ $page['title'] }}</span>
            </h4>
            <p class="text-muted mb-0 small">{{ $page['url'] }}</p>
        </div>
        <a href="{{ route('admin.seo.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-right me-1"></i>العودة
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.seo.update', $page['key']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-tag me-2"></i>Meta Tags</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" value="{{ $page['meta_title'] }}" maxlength="200">
                            <small class="text-muted">60 characters recommended | {{ strlen($page['meta_title'] ?? '') }}/200</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Description</label>
                            <textarea class="form-control" name="meta_description" rows="3" maxlength="500">{{ $page['meta_description'] }}</textarea>
                            <small class="text-muted">160 characters recommended | {{ strlen($page['meta_description'] ?? '') }}/500</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Keywords</label>
                            <input type="text" class="form-control" name="keywords" value="{{ $page['keywords'] }}" maxlength="500">
                            <small class="text-muted">Comma-separated | {{ strlen($page['keywords'] ?? '') }}/500</small>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-share-alt me-2"></i>Open Graph (Facebook/WhatsApp)</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">OG Title</label>
                            <input type="text" class="form-control" name="og_title" value="{{ $page['og_title'] }}" maxlength="200">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">OG Description</label>
                            <textarea class="form-control" name="og_description" rows="2" maxlength="500">{{ $page['og_description'] }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">OG Image URL</label>
                            <input type="url" class="form-control" name="og_image" value="{{ $page['og_image'] }}">
                            <small class="text-muted">1200x630px recommended</small>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-code me-2"></i>Schema Markup</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Schema Type</label>
                            <select class="form-select" name="schema_type">
                                <option value="WebSite" {{ $page['schema_type'] === 'WebSite' ? 'selected' : '' }}>WebSite</option>
                                <option value="LocalBusiness" {{ $page['schema_type'] === 'LocalBusiness' ? 'selected' : '' }}>LocalBusiness</option>
                                <option value="Service" {{ $page['schema_type'] === 'Service' ? 'selected' : '' }}>Service</option>
                                <option value="FAQPage" {{ $page['schema_type'] === 'FAQPage' ? 'selected' : '' }}>FAQPage</option>
                                <option value="Article" {{ $page['schema_type'] === 'Article' ? 'selected' : '' }}>Article</option>
                                <option value="BreadcrumbList" {{ $page['schema_type'] === 'BreadcrumbList' ? 'selected' : '' }}>BreadcrumbList</option>
                                <option value="Product" {{ $page['schema_type'] === 'Product' ? 'selected' : '' }}>Product</option>
                                <option value="WebPage" {{ $page['schema_type'] === 'WebPage' ? 'selected' : '' }}>WebPage</option>
                                <option value="ContactPage" {{ $page['schema_type'] === 'ContactPage' ? 'selected' : '' }}>ContactPage</option>
                                <option value="Blog" {{ $page['schema_type'] === 'Blog' ? 'selected' : '' }}>Blog</option>
                                <option value="ItemList" {{ $page['schema_type'] === 'ItemList' ? 'selected' : '' }}>ItemList</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i>حفظ التغييرات
                </button>
            </form>
        </div>

        <!-- Preview -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-eye me-2"></i>معاينة Google</h6>
                </div>
                <div class="card-body">
                    <div class="border rounded p-3" style="font-family: Arial, sans-serif;">
                        <div style="color: #1a0dab; font-size: 18px; line-height: 1.3; cursor: pointer;" id="previewTitle">
                            {{ $page['meta_title'] ?: 'Page Title' }}
                        </div>
                        <div style="color: #006621; font-size: 14px; margin-top: 2px;" id="previewUrl">
                            {{ $page['url'] }}
                        </div>
                        <div style="color: #545454; font-size: 13px; line-height: 1.4; margin-top: 4px;" id="previewDesc">
                            {{ $page['meta_description'] ?: 'Page description...' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold"><i class="fab fa-facebook me-2"></i>معاينة Facebook</h6>
                </div>
                <div class="card-body">
                    <div class="border rounded overflow-hidden">
                        <div style="height:150px; background: linear-gradient(135deg, #ec4899, #8b5cf6); display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-image text-white fa-2x opacity-50"></i>
                        </div>
                        <div class="p-2">
                            <div class="text-muted small text-uppercase" id="previewOgDomain">samahcare.shop</div>
                            <div class="fw-bold" style="font-size:14px;" id="previewOgTitle">{{ $page['og_title'] ?: $page['title'] }}</div>
                            <div class="text-muted small" id="previewOgDesc">{{ $page['og_description'] ?: 'Description...' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-list-check me-2"></i>SEO Checklist</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-2" id="checkTitle">
                        <i class="fas fa-circle" style="font-size:8px;"></i>
                        <small>Meta Title exists</small>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2" id="checkDesc">
                        <i class="fas fa-circle" style="font-size:8px;"></i>
                        <small>Meta Description exists</small>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2" id="checkKeywords">
                        <i class="fas fa-circle" style="font-size:8px;"></i>
                        <small>Keywords set</small>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2" id="checkOg">
                        <i class="fas fa-circle" style="font-size:8px;"></i>
                        <small>OG Tags configured</small>
                    </div>
                    <div class="d-flex align-items-center gap-2" id="checkSchema">
                        <i class="fas fa-circle" style="font-size:8px;"></i>
                        <small>Schema Markup type</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateChecklist() {
    const title = document.querySelector('[name="meta_title"]').value;
    const desc = document.querySelector('[name="meta_description"]').value;
    const keywords = document.querySelector('[name="keywords"]').value;
    const ogTitle = document.querySelector('[name="og_title"]').value;

    updateCheck('checkTitle', title.length > 0);
    updateCheck('checkDesc', desc.length > 0);
    updateCheck('checkKeywords', keywords.length > 0);
    updateCheck('checkOg', ogTitle.length > 0);
    updateCheck('checkSchema', true);

    document.getElementById('previewTitle').textContent = title || 'Page Title';
    document.getElementById('previewDesc').textContent = desc || 'Page description...';
    document.getElementById('previewOgTitle').textContent = ogTitle || title || 'Page Title';
    document.getElementById('previewOgDesc').textContent = document.querySelector('[name="og_description"]').value || desc || 'Description...';
}

function updateCheck(id, ok) {
    const el = document.getElementById(id);
    const icon = el.querySelector('i');
    icon.className = ok ? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger';
}

document.querySelectorAll('[name]').forEach(el => el.addEventListener('input', updateChecklist));
updateChecklist();
</script>
@endsection
