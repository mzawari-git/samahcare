<?php

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string)($_POST['action'] ?? 'update_status');
    $id = (int)($_POST['id'] ?? 0);

    if ($action === 'duplicate' && $id > 0) {
        $row = db()->prepare('SELECT car_id, offer_id, customer_name, phone, start_date, end_date, notes FROM bookings WHERE id = :id');
        $row->execute([':id' => $id]);
        $b = $row->fetch();
        if ($b) {
            try {
                db()->prepare('INSERT INTO bookings (car_id, offer_id, customer_name, phone, start_date, end_date, notes, status, id_image_path, license_image_path) VALUES (:car_id, :offer_id, :customer_name, :phone, :start_date, :end_date, :notes, :status, NULL, NULL)')
                    ->execute([
                        ':car_id' => $b['car_id'] ?? null,
                        ':offer_id' => $b['offer_id'] ?? null,
                        ':customer_name' => (string)($b['customer_name'] ?? ''),
                        ':phone' => (string)($b['phone'] ?? ''),
                        ':start_date' => $b['start_date'] ?? null,
                        ':end_date' => $b['end_date'] ?? null,
                        ':notes' => (string)($b['notes'] ?? ''),
                        ':status' => 'new',
                    ]);
            } catch (Throwable $e) {
                db()->prepare('INSERT INTO bookings (car_id, offer_id, customer_name, phone, start_date, end_date, notes, status) VALUES (:car_id, :offer_id, :customer_name, :phone, :start_date, :end_date, :notes, :status)')
                    ->execute([
                        ':car_id' => $b['car_id'] ?? null,
                        ':offer_id' => $b['offer_id'] ?? null,
                        ':customer_name' => (string)($b['customer_name'] ?? ''),
                        ':phone' => (string)($b['phone'] ?? ''),
                        ':start_date' => $b['start_date'] ?? null,
                        ':end_date' => $b['end_date'] ?? null,
                        ':notes' => (string)($b['notes'] ?? ''),
                        ':status' => 'new',
                    ]);
            }
        }
        header('Location: bookings.php?duplicated=1');
        exit;
    }

    if ($action === 'delete' && $id > 0) {
        $stmt = db()->prepare('SELECT id_image_path, license_image_path FROM bookings WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        if ($row) {
            $paths = [
                (string)($row['id_image_path'] ?? ''),
                (string)($row['license_image_path'] ?? ''),
            ];
            foreach ($paths as $path) {
                $path = trim($path);
                if ($path === '') {
                    continue;
                }
                if (strpos($path, UPLOADS_URL . '/') === 0) {
                    $local = UPLOADS_DIR . '/' . basename($path);
                    if (is_file($local)) {
                        @unlink($local);
                    }
                }
            }
        }

        db()->prepare('DELETE FROM bookings WHERE id = :id')->execute([':id' => $id]);
        header('Location: bookings.php?deleted=1');
        exit;
    }

    if ($action === 'bulk_status' && !empty($_POST['selected_bookings'])) {
        $selectedIds = array_map('intval', $_POST['selected_bookings']);
        $newStatus = trim((string)($_POST['new_status'] ?? ''));
        if (in_array($newStatus, ['new', 'contacted', 'confirmed', 'cancelled'], true) && !empty($selectedIds)) {
            $placeholders = implode(',', array_map(fn($i) => (int)$i, $selectedIds));
            db()->exec("UPDATE bookings SET status = " . db()->quote($newStatus) . " WHERE id IN ($placeholders)");
            header('Location: bookings.php?bulk_updated=1');
            exit;
        }
    }

    if ($action === 'bulk_delete' && !empty($_POST['selected_bookings'])) {
        $selectedIds = array_map('intval', $_POST['selected_bookings']);
        if (!empty($selectedIds)) {
            foreach ($selectedIds as $bid) {
                $stmt = db()->prepare('SELECT id_image_path, license_image_path FROM bookings WHERE id = :id');
                $stmt->execute([':id' => $bid]);
                $row = $stmt->fetch();
                if ($row) {
                    foreach ([$row['id_image_path'], $row['license_image_path']] as $path) {
                        $path = trim((string)$path);
                        if ($path !== '' && strpos($path, UPLOADS_URL . '/') === 0) {
                            $local = UPLOADS_DIR . '/' . basename($path);
                            if (is_file($local)) @unlink($local);
                        }
                    }
                }
                db()->prepare('DELETE FROM bookings WHERE id = :id')->execute([':id' => $bid]);
            }
            header('Location: bookings.php?bulk_deleted=1');
            exit;
        }
    }

    $status = trim((string)($_POST['status'] ?? 'new'));
    if ($id > 0 && in_array($status, ['new', 'contacted', 'confirmed', 'cancelled'], true)) {
        $stmt = db()->prepare('UPDATE bookings SET status = :s WHERE id = :id');
        $stmt->execute([':s' => $status, ':id' => $id]);
    }

    header('Location: bookings.php?updated=1');
    exit;
}

$statusFilter = trim((string)($_GET['status'] ?? ''));
$q = trim((string)($_GET['q'] ?? ''));
$dateFrom = trim((string)($_GET['date_from'] ?? ''));
$dateTo = trim((string)($_GET['date_to'] ?? ''));
$carFilter = trim((string)($_GET['car_id'] ?? ''));

$where = [];
$params = [];

if ($statusFilter !== '' && in_array($statusFilter, ['new', 'contacted', 'confirmed', 'cancelled'], true)) {
    $where[] = 'b.status = :status';
    $params[':status'] = $statusFilter;
} else {
    $statusFilter = '';
}

if ($q !== '') {
    $where[] = '(b.customer_name LIKE :q_name OR b.phone LIKE :q_phone OR CAST(b.id AS CHAR) LIKE :q_id)';
    $params[':q_name'] = '%' . $q . '%';
    $params[':q_phone'] = '%' . $q . '%';
    $params[':q_id'] = '%' . $q . '%';
}

if ($dateFrom !== '') {
    $where[] = 'b.start_date >= :date_from';
    $params[':date_from'] = $dateFrom;
}

if ($dateTo !== '') {
    $where[] = 'b.end_date <= :date_to';
    $params[':date_to'] = $dateTo;
}

if ($carFilter !== '') {
    $where[] = 'b.car_id = :car_id';
    $params[':car_id'] = (int)$carFilter;
}

$sql = "SELECT b.*, c.name_ar, c.name_en
        FROM bookings b
        LEFT JOIN cars c ON c.id = b.car_id";

if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

$sql .= ' ORDER BY b.id DESC';

$stmt = db()->prepare($sql);
$stmt->execute($params);
$bookings = $stmt->fetchAll();

$availableCars = [];
try {
    $availableCars = db()->query('SELECT id, name_ar, name_en FROM cars WHERE is_active = 1 ORDER BY name_ar')->fetchAll();
} catch (Throwable $e) {}

$statusCounts = [
    'all' => count($bookings),
    'new' => 0,
    'contacted' => 0,
    'confirmed' => 0,
    'cancelled' => 0,
];
foreach ($bookings as $b) {
    $s = $b['status'] ?? 'new';
    if (isset($statusCounts[$s])) $statusCounts[$s]++;
}

include __DIR__ . '/partials/header-modern.php';

?>

<style>
.bookings-page-header {
    background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    color: white;
}

.bookings-page-header h1 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 4px;
}

.bookings-page-header p {
    color: rgba(255,255,255,0.7);
    margin: 0;
}

.filter-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    margin-bottom: 20px;
}

.status-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.status-tab {
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    color: #64748b;
    background: #f1f5f9;
    font-weight: 500;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.status-tab:hover {
    background: #e2e8f0;
    color: #334155;
}

.status-tab.active {
    background: #3b82f6;
    color: white;
}

.status-tab .count {
    background: rgba(0,0,0,0.1);
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 12px;
}

.status-tab.active .count {
    background: rgba(255,255,255,0.2);
}

.status-tab.status-new { border-right: 3px solid #06b6d4; }
.status-tab.status-contacted { border-right: 3px solid #f59e0b; }
.status-tab.status-confirmed { border-right: 3px solid #22c55e; }
.status-tab.status-cancelled { border-right: 3px solid #ef4444; }

.booking-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 16px;
    overflow: hidden;
    transition: all 0.3s;
    background: white;
}

.booking-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.booking-card .booking-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

.booking-card .booking-id {
    font-weight: 700;
    font-size: 1.1rem;
    color: #1e293b;
}

.booking-card .booking-status {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.booking-status.new { background: #cffafe; color: #0e7490; }
.booking-status.contacted { background: #fef3c7; color: #92400e; }
.booking-status.confirmed { background: #dcfce7; color: #166534; }
.booking-status.cancelled { background: #fee2e2; color: #991b1b; }

.booking-card .booking-body {
    padding: 20px;
}

.booking-card .customer-info {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 16px;
}

.booking-card .customer-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.2rem;
}

.booking-card .customer-details h4 {
    margin: 0;
    font-weight: 600;
    color: #1e293b;
}

.booking-card .customer-details p {
    margin: 0;
    color: #64748b;
    font-size: 0.9rem;
}

.booking-card .car-info {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #f8fafc;
    border-radius: 10px;
    margin-bottom: 16px;
}

.booking-card .car-image {
    width: 60px;
    height: 45px;
    border-radius: 8px;
    overflow: hidden;
    background: #e2e8f0;
}

.booking-card .car-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.booking-card .car-name {
    font-weight: 600;
    color: #1e293b;
}

.booking-card .dates-info {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}

.booking-card .date-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.booking-card .date-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: #e0f2fe;
    color: #0284c7;
    display: flex;
    align-items: center;
    justify-content: center;
}

.booking-card .date-label {
    font-size: 11px;
    color: #64748b;
    text-transform: uppercase;
}

.booking-card .date-value {
    font-weight: 600;
    color: #1e293b;
}

.booking-card .price-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border-radius: 10px;
    color: white;
}

.booking-card .price-label {
    font-size: 12px;
    opacity: 0.9;
}

.booking-card .price-value {
    font-size: 1.3rem;
    font-weight: 700;
}

.booking-card .booking-images {
    display: flex;
    gap: 12px;
    margin-top: 16px;
}

.booking-card .id-image {
    width: 80px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
}

.booking-card .id-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.booking-card .id-image .image-label {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.7);
    color: white;
    font-size: 10px;
    text-align: center;
    padding: 2px;
}

.booking-card .booking-actions {
    display: flex;
    gap: 8px;
    padding: 16px 20px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    flex-wrap: wrap;
}

.booking-card .notes {
    padding: 12px;
    background: #fef9c3;
    border-radius: 8px;
    font-size: 0.9rem;
    color: #854d0e;
    margin-top: 12px;
}

.checkbox-wrapper {
    display: flex;
    align-items: center;
    padding: 16px 20px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

.bulk-actions {
    display: flex;
    gap: 12px;
    align-items: center;
    padding: 12px 20px;
    background: #eff6ff;
    border-radius: 10px;
    margin-bottom: 20px;
}

.bulk-actions select {
    max-width: 150px;
}

.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
}

.toast {
    padding: 14px 20px;
    border-radius: 10px;
    color: white;
    font-weight: 500;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    animation: slideIn 0.3s ease;
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 280px;
    margin-bottom: 10px;
}

.toast.success { background: linear-gradient(135deg, #22c55e, #16a34a); }
.toast.error { background: linear-gradient(135deg, #ef4444, #dc2626); }

@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@media (max-width: 768px) {
    .booking-card .booking-header {
        flex-direction: column;
        gap: 12px;
        align-items: flex-start;
    }
    
    .booking-card .dates-info {
        flex-direction: column;
    }
    
    .booking-card .booking-actions {
        flex-direction: column;
    }
    
    .booking-card .booking-actions .btn {
        width: 100%;
    }
}
</style>

<div class="toast-container" id="toastContainer"></div>

<div class="bookings-page-header">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h1><i class="fas fa-calendar-check me-2"></i><?= e(t('manage_bookings')) ?></h1>
            <p>إدارة طلبات الحجز والسيارات</p>
        </div>
    </div>
</div>

<!-- Status Tabs -->
<div class="status-tabs">
    <a href="bookings.php" class="status-tab <?= $statusFilter === '' ? 'active' : '' ?>">
        الكل <span class="count"><?= $statusCounts['all'] ?></span>
    </a>
    <a href="?status=new" class="status-tab status-new <?= $statusFilter === 'new' ? 'active' : '' ?>">
        جديد <span class="count"><?= $statusCounts['new'] ?></span>
    </a>
    <a href="?status=contacted" class="status-tab status-contacted <?= $statusFilter === 'contacted' ? 'active' : '' ?>">
        تم التواصل <span class="count"><?= $statusCounts['contacted'] ?></span>
    </a>
    <a href="?status=confirmed" class="status-tab status-confirmed <?= $statusFilter === 'confirmed' ? 'active' : '' ?>">
        مؤكد <span class="count"><?= $statusCounts['confirmed'] ?></span>
    </a>
    <a href="?status=cancelled" class="status-tab status-cancelled <?= $statusFilter === 'cancelled' ? 'active' : '' ?>">
        ملغى <span class="count"><?= $statusCounts['cancelled'] ?></span>
    </a>
</div>

<!-- Filters -->
<div class="card filter-card">
    <div class="card-body">
        <form method="get" id="bookingFilterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">بحث</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input class="form-control" name="q" value="<?= e($q) ?>" placeholder="اسم أو هاتف أو رقم...">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">السيارة</label>
                    <select class="form-select" name="car_id">
                        <option value="">الكل</option>
                        <?php foreach ($availableCars as $car): ?>
                            <option value="<?= (int)$car['id'] ?>" <?= $carFilter == $car['id'] ? 'selected' : '' ?>>
                                <?= e($car['name_ar']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">من تاريخ</label>
                    <input class="form-control" type="date" name="date_from" value="<?= e($dateFrom) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">إلى تاريخ</label>
                    <input class="form-control" type="date" name="date_to" value="<?= e($dateTo) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">الحالة</label>
                    <select class="form-select" name="status">
                        <option value="">الكل</option>
                        <option value="new" <?= $statusFilter === 'new' ? 'selected' : '' ?>>جديد</option>
                        <option value="contacted" <?= $statusFilter === 'contacted' ? 'selected' : '' ?>>تم التواصل</option>
                        <option value="confirmed" <?= $statusFilter === 'confirmed' ? 'selected' : '' ?>>مؤكد</option>
                        <option value="cancelled" <?= $statusFilter === 'cancelled' ? 'selected' : '' ?>>ملغى</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Actions -->
<form method="post" id="bulkForm">
    <input type="hidden" name="action" value="bulk_status">
    <div class="bulk-actions">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="selectAll">
            <label class="form-check-label" for="selectAll">تحديد الكل</label>
        </div>
        <select class="form-select form-select-sm" name="new_status">
            <option value="">تغيير الحالة إلى...</option>
            <option value="new">جديد</option>
            <option value="contacted">تم التواصل</option>
            <option value="confirmed">مؤكد</option>
            <option value="cancelled">ملغى</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">تطبيق</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()">حذف المحدد</button>
        <input type="hidden" name="action" id="bulkAction" value="bulk_status">
    </div>

    <!-- Messages -->
    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>تم حفظ التغييرات.</div>
    <?php endif; ?>
    <?php if (isset($_GET['duplicated'])): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>تم تكرار الحجز.</div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>تم حذف الحجز.</div>
    <?php endif; ?>
    <?php if (isset($_GET['bulk_updated'])): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>تم تحديث حالة العناصر المحددة.</div>
    <?php endif; ?>
    <?php if (isset($_GET['bulk_deleted'])): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>تم حذف العناصر المحددة.</div>
    <?php endif; ?>

    <!-- Bookings List -->
    <?php if (empty($bookings)): ?>
        <div class="text-center py-5">
            <i class="fas fa-calendar-xmark" style="font-size: 64px; color: #cbd5e1; margin-bottom: 16px; display: block;"></i>
            <p class="text-secondary">لا توجد حجوزات</p>
        </div>
    <?php else: ?>
        <?php foreach ($bookings as $b):
            $carName = current_lang() === 'ar' ? (string)($b['name_ar'] ?? 'غير محدد') : (string)($b['name_en'] ?? 'Not specified');
            $idImg = trim((string)($b['id_image_path'] ?? ''));
            $licImg = trim((string)($b['license_image_path'] ?? ''));
            $status = (string)($b['status'] ?? 'new');
            $statusLabel = ['new' => 'جديد', 'contacted' => 'تم التواصل', 'confirmed' => 'مؤكد', 'cancelled' => 'ملغى'][$status] ?? $status;
            $customerName = (string)$b['customer_name'];
            $initial = mb_substr($customerName, 0, 1, 'UTF-8');
            
            $days = 1;
            if (!empty($b['start_date']) && !empty($b['end_date'])) {
                $start = strtotime($b['start_date']);
                $end = strtotime($b['end_date']);
                $days = max(1, ceil(($end - $start) / 86400));
            }
        ?>
            <div class="booking-card">
                <div class="checkbox-wrapper">
                    <input type="checkbox" name="selected_bookings[]" value="<?= (int)$b['id'] ?>" class="booking-select">
                </div>
                <div class="booking-header">
                    <span class="booking-id">#<?= (int)$b['id'] ?></span>
                    <span class="booking-status <?= e($status) ?>"><?= e($statusLabel) ?></span>
                </div>
                <div class="booking-body">
                    <div class="customer-info">
                        <div class="customer-avatar"><?= e($initial) ?></div>
                        <div class="customer-details">
                            <h4><?= e($customerName) ?></h4>
                            <p dir="ltr"><?= e((string)$b['phone']) ?></p>
                        </div>
                    </div>
                    
                    <?php if ($b['car_id']): ?>
                    <div class="car-info">
                        <div class="car-image">
                            <i class="fas fa-car" style="padding: 12px; color: #94a3b8;"></i>
                        </div>
                        <div class="car-name"><?= e($carName) ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="dates-info">
                        <div class="date-item">
                            <div class="date-icon"><i class="fas fa-play"></i></div>
                            <div>
                                <div class="date-label">الاستلام</div>
                                <div class="date-value"><?= e((string)($b['start_date'] ?? '-')) ?></div>
                            </div>
                        </div>
                        <div class="date-item">
                            <div class="date-icon"><i class="fas fa-stop"></i></div>
                            <div>
                                <div class="date-label">التسليم</div>
                                <div class="date-value"><?= e((string)($b['end_date'] ?? '-')) ?></div>
                            </div>
                        </div>
                        <div class="date-item">
                            <div class="date-icon"><i class="fas fa-clock"></i></div>
                            <div>
                                <div class="date-label">المدة</div>
                                <div class="date-value"><?= $days ?> يوم</div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ((float)$b['total_price'] > 0): ?>
                    <div class="price-info">
                        <div>
                            <div class="price-label">السعر الإجمالي</div>
                            <div class="price-value">₪<?= number_format((float)$b['total_price'], 0) ?></div>
                        </div>
                        <div>
                            <div class="price-label">عدد الأيام</div>
                            <div class="price-value"><?= $days ?></div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($idImg !== '' || $licImg !== ''): ?>
                    <div class="booking-images">
                        <?php if ($idImg !== ''): ?>
                            <div class="id-image">
                                <img src="<?= e(asset_url('../' . ltrim($idImg, '/'))) ?>" alt="ID">
                                <div class="image-label">هوية</div>
                            </div>
                        <?php endif; ?>
                        <?php if ($licImg !== ''): ?>
                            <div class="id-image">
                                <img src="<?= e(asset_url('../' . ltrim($licImg, '/'))) ?>" alt="License">
                                <div class="image-label">رخصة</div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (trim((string)$b['notes']) !== ''): ?>
                    <div class="notes">
                        <i class="fas fa-sticky-note me-2"></i><?= e((string)$b['notes']) ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="booking-actions">
                    <form method="post" class="d-inline">
                        <input type="hidden" name="action" value="update_status">
                        <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                        <select class="form-select form-select-sm" name="status" onchange="this.form.submit()" style="width: auto;">
                            <option value="new" <?= $status === 'new' ? 'selected' : '' ?>>جديد</option>
                            <option value="contacted" <?= $status === 'contacted' ? 'selected' : '' ?>>تم التواصل</option>
                            <option value="confirmed" <?= $status === 'confirmed' ? 'selected' : '' ?>>مؤكد</option>
                            <option value="cancelled" <?= $status === 'cancelled' ? 'selected' : '' ?>>ملغى</option>
                        </select>
                    </form>
                    <a class="btn btn-primary btn-sm" href="booking_edit.php?id=<?= (int)$b['id'] ?>">
                        <i class="fas fa-edit me-1"></i> تعديل
                    </a>
                    <a class="btn btn-secondary btn-sm" href="booking_invoice.php?id=<?= (int)$b['id'] ?>" target="_blank">
                        <i class="fas fa-file-invoice me-1"></i> فاتورة
                    </a>
                    <form method="post" class="d-inline">
                        <input type="hidden" name="action" value="duplicate">
                        <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                        <button class="btn btn-warning btn-sm" type="submit" onclick="return confirm('تكرار الحجز؟')">
                            <i class="fas fa-copy me-1"></i> تكرار
                        </button>
                    </form>
                    <form method="post" class="d-inline">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('حذف الحجز نهائياً؟')">
                            <i class="fas fa-trash me-1"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</form>

<script>
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('.booking-select').forEach(cb => cb.checked = this.checked);
});

function bulkDelete() {
    const checked = document.querySelectorAll('.booking-select:checked');
    if (checked.length === 0) {
        showToast('يرجى تحديد حجوزات للحذف', 'error');
        return;
    }
    if (confirm('حذف ' + checked.length + ' حجز؟')) {
        document.getElementById('bulkAction').value = 'bulk_delete';
        document.getElementById('bulkForm').submit();
    }
}

function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = 'toast ' + type;
    toast.innerHTML = '<i class="fas ' + (type === 'success' ? 'fa-check-circle' : 'fa-times-circle') + '"></i><span>' + message + '</span>';
    container.appendChild(toast);
    setTimeout(() => { toast.style.animation = 'slideIn 0.3s reverse'; setTimeout(() => toast.remove(), 300); }, 3000);
}

<?php if (isset($_GET['updated']) || isset($_GET['bulk_updated'])): ?>
showToast('تم التحديث بنجاح', 'success');
<?php endif; ?>
<?php if (isset($_GET['deleted']) || isset($_GET['bulk_deleted'])): ?>
showToast('تم الحذف بنجاح', 'success');
<?php endif; ?>
</script>

<?php include __DIR__ . '/partials/footer-modern.php'; ?>
