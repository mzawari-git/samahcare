{{-- Ad Set Edit Modal --}}
<div class="modal fade" id="editAdSetModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title"><i class="fas fa-edit"></i> تعديل المجموعة الإعلانية</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <form id="editAdSetForm" onsubmit="return submitEditAdSet(event)">
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="edit-adset-error"></div>
                <input type="hidden" name="id" id="edit-adset-id">
                <div class="mb-3">
                    <label class="fw-bold small">اسم المجموعة</label>
                    <input class="form-control" name="name" id="edit-adset-name" required>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">الميزانية اليومية</label>
                    <input class="form-control" name="daily_budget" id="edit-adset-budget" type="number" step="0.01" min="1">
                </div>
                <div class="mb-3">
                    <label class="fw-bold small">مبلغ التسعير</label>
                    <input class="form-control" name="bid_amount" id="edit-adset-bid" type="number" step="0.01" min="0.01">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button class="btn btn-primary" id="btn-edit-adset">
                    <span id="btn-edit-adset-text"><i class="fas fa-save"></i> حفظ</span>
                    <span id="btn-edit-adset-spin" class="d-none"><span class="spinner-border spinner-border-sm"></span> جاري...</span>
                </button>
            </div>
        </form>
    </div></div>
</div>

<script>
function editAdSet(id) {
    hideError('edit-adset-error');
    document.getElementById('edit-adset-id').value = id;
    document.getElementById('edit-adset-name').value = '';
    document.getElementById('edit-adset-budget').value = '';
    document.getElementById('edit-adset-bid').value = '';
    new bootstrap.Modal(document.getElementById('editAdSetModal')).show();
}

async function submitEditAdSet(e) {
    e.preventDefault();
    hideError('edit-adset-error');
    btnLoading('edit-adset', true);

    const id = document.getElementById('edit-adset-id').value;
    const data = {
        name: document.getElementById('edit-adset-name').value,
        daily_budget: document.getElementById('edit-adset-budget').value || null,
        bid_amount: document.getElementById('edit-adset-bid').value || null,
    };

    try {
        const r = await fetch(BASE + '/admin/ads/adsets/' + id, {
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(data)
        });
        const d = await r.json();
        if (d.success) {
            bootstrap.Modal.getInstance(document.getElementById('editAdSetModal')).hide();
            location.reload();
        } else {
            showError('edit-adset-error', d.message || 'فشل التحديث');
        }
    } catch (e) {
        showError('edit-adset-error', 'خطأ في الاتصال');
    } finally { btnLoading('edit-adset', false); }
}
</script>
