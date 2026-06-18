<?php

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin', 'editor']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string)($_POST['action'] ?? '');
    $carId = (int)($_POST['car_id'] ?? 0);

    if ($action === 'delete_all') {
        try {
            $files = [];
            $slideIds = [];

            try {
                $rows = db()->query('SELECT file_path FROM car_images')->fetchAll();
                foreach ($rows as $r) {
                    $p = (string)($r['file_path'] ?? '');
                    if ($p !== '' && strpos($p, UPLOADS_URL . '/') === 0) {
                        $files[] = UPLOADS_DIR . '/' . basename($p);
                    }
                }
            } catch (Throwable $e) {
            }

            try {
                $rows = db()->query('SELECT image_path, slide_id FROM offers')->fetchAll();
                foreach ($rows as $r) {
                    $p = (string)($r['image_path'] ?? '');
                    if ($p !== '' && strpos($p, UPLOADS_URL . '/') === 0) {
                        $files[] = UPLOADS_DIR . '/' . basename($p);
                    }
                    $sid = (int)($r['slide_id'] ?? 0);
                    if ($sid > 0) {
                        $slideIds[$sid] = true;
                    }
                }
            } catch (Throwable $e) {
            }

            if ($slideIds) {
                foreach (array_keys($slideIds) as $sid) {
                    try {
                        $stmt = db()->prepare('SELECT image_path FROM slides WHERE id = :id');
                        $stmt->execute([':id' => (int)$sid]);
                        $row = $stmt->fetch();
                        if ($row) {
                            $p = (string)($row['image_path'] ?? '');
                            if ($p !== '' && strpos($p, UPLOADS_URL . '/') === 0) {
                                $files[] = UPLOADS_DIR . '/' . basename($p);
                            }
                        }
                    } catch (Throwable $e) {
                    }
                    try {
                        db()->prepare('DELETE FROM slides WHERE id = :id')->execute([':id' => (int)$sid]);
                    } catch (Throwable $e) {
                    }
                }
            }

            try {
                db()->exec('DELETE FROM offers');
            } catch (Throwable $e) {
            }
            db()->exec('DELETE FROM cars');

            $files = array_values(array_unique($files));
            foreach ($files as $f) {
                if (is_file($f)) {
                    @unlink($f);
                }
            }

            header('Location: cars.php?deleted_all=1');
            exit;
        } catch (Throwable $e) {
            header('Location: cars.php?deleted_all=0');
            exit;
        }
    }

    if ($action === 'reset_kia_cerato') {
        try {
            $files = [];
            $slideIds = [];

            try {
                $rows = db()->query('SELECT file_path FROM car_images')->fetchAll();
                foreach ($rows as $r) {
                    $p = (string)($r['file_path'] ?? '');
                    if ($p !== '' && strpos($p, UPLOADS_URL . '/') === 0) {
                        $files[] = UPLOADS_DIR . '/' . basename($p);
                    }
                }
            } catch (Throwable $e) {
            }

            try {
                $rows = db()->query('SELECT image_path, slide_id FROM offers')->fetchAll();
                foreach ($rows as $r) {
                    $p = (string)($r['image_path'] ?? '');
                    if ($p !== '' && strpos($p, UPLOADS_URL . '/') === 0) {
                        $files[] = UPLOADS_DIR . '/' . basename($p);
                    }
                    $sid = (int)($r['slide_id'] ?? 0);
                    if ($sid > 0) {
                        $slideIds[$sid] = true;
                    }
                }
            } catch (Throwable $e) {
            }

            if ($slideIds) {
                foreach (array_keys($slideIds) as $sid) {
                    try {
                        $stmt = db()->prepare('SELECT image_path FROM slides WHERE id = :id');
                        $stmt->execute([':id' => (int)$sid]);
                        $row = $stmt->fetch();
                        if ($row) {
                            $p = (string)($row['image_path'] ?? '');
                            if ($p !== '' && strpos($p, UPLOADS_URL . '/') === 0) {
                                $files[] = UPLOADS_DIR . '/' . basename($p);
                            }
                        }
                    } catch (Throwable $e) {
                    }
                    try {
                        db()->prepare('DELETE FROM slides WHERE id = :id')->execute([':id' => (int)$sid]);
                    } catch (Throwable $e) {
                    }
                }
            }

            try {
                db()->exec('DELETE FROM offers');
            } catch (Throwable $e) {
            }
            db()->exec('DELETE FROM cars');

            $stmt = db()->prepare('INSERT INTO cars (name_ar, name_en, type_ar, type_en, daily_price, monthly_price, features_ar, features_en, is_offer, offer_details_ar, offer_details_en, is_active) VALUES (:name_ar,:name_en,:type_ar,:type_en,:daily_price,:monthly_price,:features_ar,:features_en,1,:offer_ar,:offer_en,1)');
            $stmt->execute([
                ':name_ar' => 'كيا سيراتو',
                ':name_en' => 'Kia Cerato',
                ':type_ar' => 'سيدان',
                ':type_en' => 'Sedan',
                ':daily_price' => 120,
                ':monthly_price' => 2300,
                ':features_ar' => null,
                ':features_en' => null,
                ':offer_ar' => 'أفضل الأسعار للباقات اليومية والأسبوعية والشهرية',
                ':offer_en' => 'Best prices for daily, weekly and monthly packages',
            ]);
            $newCarId = (int)db()->lastInsertId();

            $baseDaily = 120.0;
            $monthlyPrice = 2300.0;

            $offers = [
                ['days' => 1, 'daily' => 120.0, 'desc_ar' => 'عرض يوم واحد - فقط 120 شيكل', 'desc_en' => '1-day offer - only 120'],
                ['days' => 3, 'daily' => $baseDaily * 0.8, 'desc_ar' => 'خصم 20% لمدة 3 أيام', 'desc_en' => '20% off for 3 days'],
                ['days' => 5, 'daily' => 79.0, 'desc_ar' => 'عرض 5 أيام - فقط 79 شيكل في اليوم', 'desc_en' => '5-day offer - only 79 per day'],
                ['days' => 30, 'daily' => $monthlyPrice / 30, 'desc_ar' => 'عرض شهري - فقط 2300 شيكل', 'desc_en' => 'Monthly offer - only 2300'],
            ];

            $sql = 'INSERT INTO offers (car_id, days, daily_price, title_ar, title_en, description_ar, description_en, sort_order, is_active, promo_slide, expires_at)
                    VALUES (:car_id, :days, :daily_price, :title_ar, :title_en, :desc_ar, :desc_en, :sort_order, 1, 0, NULL)';
            $stmtOffer = db()->prepare($sql);
            foreach ($offers as $o) {
                $d = (int)$o['days'];
                $stmtOffer->execute([
                    ':car_id' => $newCarId,
                    ':days' => $d,
                    ':daily_price' => (float)$o['daily'],
                    ':title_ar' => 'كيا سيراتو - ' . $d . ' أيام',
                    ':title_en' => 'Kia Cerato - ' . $d . ' days',
                    ':desc_ar' => (string)$o['desc_ar'],
                    ':desc_en' => (string)$o['desc_en'],
                    ':sort_order' => $d,
                ]);
            }

            $files = array_values(array_unique($files));
            foreach ($files as $f) {
                if (is_file($f)) {
                    @unlink($f);
                }
            }

            header('Location: cars.php?reset=1');
            exit;
        } catch (Throwable $e) {
            header('Location: cars.php?reset=0');
            exit;
        }
    }

    if ($action === 'make_single' && $carId > 0) {
        try {
            db()->prepare('UPDATE cars SET is_active = 0, is_offer = 0')->execute();
            db()->prepare('UPDATE cars SET is_active = 1, is_offer = 1 WHERE id = :id')->execute([':id' => $carId]);
            try {
                db()->exec('DELETE FROM offers');
            } catch (Throwable $e) {
            }
            header('Location: cars.php?single=1');
            exit;
        } catch (Throwable $e) {
            header('Location: cars.php?single=0');
            exit;
        }
    }

    if ($action === 'delete' && $carId > 0) {
        try {
            $files = [];
            try {
                $stmt = db()->prepare('SELECT file_path FROM car_images WHERE car_id = :id');
                $stmt->execute([':id' => $carId]);
                $rows = $stmt->fetchAll();
                foreach ($rows as $r) {
                    $p = (string)($r['file_path'] ?? '');
                    if ($p !== '' && strpos($p, UPLOADS_URL . '/') === 0) {
                        $files[] = UPLOADS_DIR . '/' . basename($p);
                    }
                }
            } catch (Throwable $e) {
            }

            try {
                $stmt = db()->prepare('SELECT slide_id FROM offers WHERE car_id = :id');
                $stmt->execute([':id' => $carId]);
                $rows = $stmt->fetchAll();
                foreach ($rows as $r) {
                    $sid = (int)($r['slide_id'] ?? 0);
                    if ($sid > 0) {
                        try {
                            db()->prepare('DELETE FROM slides WHERE id = :id')->execute([':id' => $sid]);
                        } catch (Throwable $e) {
                        }
                    }
                }
            } catch (Throwable $e) {
            }

            try {
                db()->prepare('DELETE FROM offers WHERE car_id = :id')->execute([':id' => $carId]);
            } catch (Throwable $e) {
            }

            db()->prepare('DELETE FROM cars WHERE id = :id')->execute([':id' => $carId]);

            foreach ($files as $f) {
                if (is_file($f)) {
                    @unlink($f);
                }
            }

            header('Location: cars.php?deleted=1');
            exit;
        } catch (Throwable $e) {
            header('Location: cars.php?deleted=0');
            exit;
        }
    }

    if ($action === 'toggle_active' && $carId > 0) {
        try {
            $stmt = db()->prepare('SELECT is_active FROM cars WHERE id = :id');
            $stmt->execute([':id' => $carId]);
            $car = $stmt->fetch();
            if ($car) {
                $newStatus = (int)$car['is_active'] === 1 ? 0 : 1;
                db()->prepare('UPDATE cars SET is_active = :status WHERE id = :id')->execute([':id' => $carId, ':status' => $newStatus]);
            }
            header('Location: cars.php');
            exit;
        } catch (Throwable $e) {
            header('Location: cars.php');
            exit;
        }
    }

    if ($action === 'bulk_delete') {
        $selectedIds = $_POST['selected_cars'] ?? [];
        if (is_array($selectedIds) && count($selectedIds) > 0) {
            try {
                foreach ($selectedIds as $carId) {
                    $cid = (int)$carId;
                    if ($cid > 0) {
                        $files = [];
                        try {
                            $stmt = db()->prepare('SELECT file_path FROM car_images WHERE car_id = :id');
                            $stmt->execute([':id' => $cid]);
                            $rows = $stmt->fetchAll();
                            foreach ($rows as $r) {
                                $p = (string)($r['file_path'] ?? '');
                                if ($p !== '' && strpos($p, UPLOADS_URL . '/') === 0) {
                                    $files[] = UPLOADS_DIR . '/' . basename($p);
                                }
                            }
                        } catch (Throwable $e) {
                        }
                        try {
                            db()->prepare('DELETE FROM offers WHERE car_id = :id')->execute([':id' => $cid]);
                        } catch (Throwable $e) {
                        }
                        db()->prepare('DELETE FROM cars WHERE id = :id')->execute([':id' => $cid]);
                        foreach ($files as $f) {
                            if (is_file($f)) {
                                @unlink($f);
                            }
                        }
                    }
                }
                header('Location: cars.php?bulk_deleted=1');
                exit;
            } catch (Throwable $e) {
                header('Location: cars.php?bulk_deleted=0');
                exit;
            }
        }
        header('Location: cars.php');
        exit;
    }

    header('Location: cars.php');
    exit;
}

$q = trim((string)($_GET['q'] ?? ''));
$activeFilter = trim((string)($_GET['active'] ?? ''));
$offerFilter = trim((string)($_GET['offer'] ?? ''));
$typeFilter = trim((string)($_GET['type'] ?? ''));
$minPrice = trim((string)($_GET['min_price'] ?? ''));
$maxPrice = trim((string)($_GET['max_price'] ?? ''));
$sortBy = trim((string)($_GET['sort'] ?? 'id_desc'));
$viewMode = trim((string)($_GET['view'] ?? 'grid'));

$pageNo = (int)($_GET['page'] ?? 1);
if ($pageNo <= 0) {
    $pageNo = 1;
}
$perPage = 20;
$offset = ($pageNo - 1) * $perPage;
if ($offset < 0) {
    $offset = 0;
}

$where = [];
$params = [];

if ($activeFilter === '1') {
    $where[] = 'c.is_active = 1';
} elseif ($activeFilter === '0') {
    $where[] = 'c.is_active = 0';
}

if ($offerFilter === '1') {
    $where[] = 'c.is_offer = 1';
} elseif ($offerFilter === '0') {
    $where[] = 'c.is_offer = 0';
}

if ($typeFilter !== '') {
    $where[] = '(c.type_ar LIKE :type OR c.type_en LIKE :type)';
    $params[':type'] = '%' . $typeFilter . '%';
}

if ($q !== '') {
    $where[] = '(c.name_ar LIKE :q_ar OR c.name_en LIKE :q_en OR CAST(c.id AS CHAR) LIKE :q_id)';
    $params[':q_ar'] = '%' . $q . '%';
    $params[':q_en'] = '%' . $q . '%';
    $params[':q_id'] = '%' . $q . '%';
}

if ($minPrice !== '') {
    $where[] = 'c.daily_price >= :min_price';
    $params[':min_price'] = (float)$minPrice;
}

if ($maxPrice !== '') {
    $where[] = 'c.daily_price <= :max_price';
    $params[':max_price'] = (float)$maxPrice;
}

$baseFrom = 'FROM cars c';
$whereSql = $where ? (' WHERE ' . implode(' AND ', $where)) : '';

$orderBy = 'c.id DESC';
switch ($sortBy) {
    case 'id_asc':
        $orderBy = 'c.id ASC';
        break;
    case 'name_asc':
        $orderBy = 'c.name_ar ASC';
        break;
    case 'name_desc':
        $orderBy = 'c.name_ar DESC';
        break;
    case 'price_asc':
        $orderBy = 'c.daily_price ASC';
        break;
    case 'price_desc':
        $orderBy = 'c.daily_price DESC';
        break;
    case 'date_asc':
        $orderBy = 'c.created_at ASC';
        break;
}

$total = 0;
try {
    $stmtCount = db()->prepare('SELECT COUNT(*) AS c ' . $baseFrom . $whereSql);
    $stmtCount->execute($params);
    $total = (int)($stmtCount->fetch()['c'] ?? 0);
} catch (Throwable $e) {
    $total = 0;
}

$cars = [];
try {
    $sql = 'SELECT c.*, (
                SELECT ci.file_path
                FROM car_images ci
                WHERE ci.car_id = c.id AND ci.is_primary = 1
                LIMIT 1
            ) AS primary_image,
            (
                SELECT COUNT(*)
                FROM car_images ci
                WHERE ci.car_id = c.id
            ) AS image_count,
            (
                SELECT COUNT(*)
                FROM bookings b
                WHERE b.car_id = c.id
            ) AS booking_count
            ' . $baseFrom
        . $whereSql
        . ' ORDER BY ' . $orderBy . ' LIMIT :limit OFFSET :offset';
    $stmt = db()->prepare($sql);
    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v, PDO::PARAM_STR);
    }
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $cars = $stmt->fetchAll();
} catch (Throwable $e) {
    $cars = [];
}

$totalPages = (int)max(1, (int)ceil($total / $perPage));
if ($pageNo > $totalPages) {
    $pageNo = $totalPages;
}

$carTypes = [];
try {
    $types = db()->query("SELECT DISTINCT type_ar, type_en FROM cars WHERE type_ar != '' OR type_en != ''")->fetchAll();
    foreach ($types as $t) {
        if (!empty($t['type_ar'])) $carTypes[] = $t['type_ar'];
        if (!empty($t['type_en'])) $carTypes[] = $t['type_en'];
    }
    $carTypes = array_unique($carTypes);
    sort($carTypes);
} catch (Throwable $e) {
}

$qsBase = [];
if ($q !== '') $qsBase['q'] = $q;
if ($activeFilter !== '') $qsBase['active'] = $activeFilter;
if ($offerFilter !== '') $qsBase['offer'] = $offerFilter;
if ($typeFilter !== '') $qsBase['type'] = $typeFilter;
if ($minPrice !== '') $qsBase['min_price'] = $minPrice;
if ($maxPrice !== '') $qsBase['max_price'] = $maxPrice;
if ($sortBy !== 'id_desc') $qsBase['sort'] = $sortBy;
if ($viewMode !== 'grid') $qsBase['view'] = $viewMode;

include __DIR__ . '/partials/header-modern.php';

?>

<style>
.cars-page-header {
    background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    color: white;
}

.cars-page-header h1 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 4px;
}

.cars-page-header p {
    color: rgba(255,255,255,0.7);
    margin: 0;
}

.filter-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    margin-bottom: 20px;
}

.filter-card .card-body {
    padding: 16px;
}

.filter-toggle {
    cursor: pointer;
    user-select: none;
}

.filter-toggle .filter-icon {
    transition: transform 0.3s;
}

.filter-toggle.collapsed .filter-icon {
    transform: rotate(-90deg);
}

.filter-row {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #e2e8f0;
}

.cars-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.cars-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.car-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
}

.car-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
}

.car-card .car-image {
    position: relative;
    height: 180px;
    overflow: hidden;
    background: #f1f5f9;
}

.car-card .car-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.car-card:hover .car-image img {
    transform: scale(1.05);
}

.car-card .car-image .image-count {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.car-card .car-body {
    padding: 16px;
}

.car-card .car-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 4px;
    color: #1e293b;
}

.car-card .car-type {
    font-size: 0.85rem;
    color: #64748b;
    margin-bottom: 12px;
}

.car-card .car-price {
    display: flex;
    gap: 12px;
    margin-bottom: 12px;
}

.car-card .price-item {
    flex: 1;
    text-align: center;
    padding: 10px;
    background: #f8fafc;
    border-radius: 10px;
}

.car-card .price-label {
    font-size: 11px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.car-card .price-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: #0f172a;
}

.car-card .price-value.daily {
    color: #3b82f6;
}

.car-card .price-value.monthly {
    color: #22c55e;
}

.car-card .car-badges {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 12px;
}

.badge-status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-status.active {
    background: #dcfce7;
    color: #166534;
}

.badge-status.inactive {
    background: #f1f5f9;
    color: #64748b;
}

.badge-status.offer {
    background: #fef3c7;
    color: #92400e;
}

.badge-status.no-offer {
    background: #f1f5f9;
    color: #94a3b8;
}

.car-card .car-actions {
    display: flex;
    gap: 8px;
    padding-top: 12px;
    border-top: 1px solid #e2e8f0;
}

.car-card .car-actions .btn {
    flex: 1;
    padding: 8px 12px;
    font-size: 13px;
    border-radius: 8px;
}

.car-card .booking-count {
    font-size: 12px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* List View Styles */
.car-list-item {
    border-radius: 12px;
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
    transition: all 0.2s;
    background: white;
}

.car-list-item:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.car-list-item .car-image {
    width: 120px;
    height: 90px;
    flex-shrink: 0;
    overflow: hidden;
    background: #f1f5f9;
}

.car-list-item .car-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.car-list-item .car-body {
    padding: 12px 16px;
    flex: 1;
    display: flex;
    align-items: center;
    gap: 16px;
}

.car-list-item .car-info {
    flex: 1;
}

.car-list-item .car-price {
    display: flex;
    gap: 16px;
}

.car-list-item .price-item {
    text-align: center;
}

.car-list-item .price-label {
    font-size: 10px;
    color: #64748b;
    text-transform: uppercase;
}

.car-list-item .price-value {
    font-weight: 700;
}

.car-list-item .car-actions {
    display: flex;
    gap: 6px;
}

/* Checkbox styles */
.car-checkbox {
    position: absolute;
    top: 8px;
    left: 8px;
    z-index: 10;
}

.car-checkbox input {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

/* View Toggle */
.view-toggle {
    display: flex;
    background: #f1f5f9;
    border-radius: 8px;
    padding: 4px;
}

.view-toggle button {
    padding: 6px 12px;
    border: none;
    background: transparent;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
    color: #64748b;
}

.view-toggle button.active {
    background: white;
    color: #3b82f6;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.view-toggle button:hover:not(.active) {
    color: #334155;
}

/* Toast Notifications */
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 10px;
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
}

.toast.success {
    background: linear-gradient(135deg, #22c55e, #16a34a);
}

.toast.error {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.toast.info {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
}

.toast.warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Stats mini */
.stats-mini {
    display: flex;
    gap: 16px;
    margin-bottom: 16px;
}

.stats-mini .stat-item {
    text-align: center;
    padding: 8px 16px;
    background: rgba(255,255,255,0.1);
    border-radius: 8px;
}

.stats-mini .stat-value {
    font-size: 1.2rem;
    font-weight: 700;
}

.stats-mini .stat-label {
    font-size: 0.75rem;
    opacity: 0.8;
}

/* Responsive */
@media (max-width: 768px) {
    .cars-grid {
        grid-template-columns: 1fr;
    }
    
    .car-list-item {
        flex-direction: column;
    }
    
    .car-list-item .car-image {
        width: 100%;
        height: 150px;
    }
    
    .car-list-item .car-body {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .stats-mini {
        flex-wrap: wrap;
    }
}
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- Page Header -->
<div class="cars-page-header">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h1><i class="fas fa-car me-2"></i><?= e(t('manage_cars')) ?></h1>
            <p>إدارة شاملة للسيارات والعروض</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <div class="stats-mini">
                <div class="stat-item">
                    <div class="stat-value"><?= number_format($total) ?></div>
                    <div class="stat-label">الإجمالي</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?= number_format(array_sum(array_map(fn($c) => (int)$c['is_active'], $cars))) ?></div>
                    <div class="stat-label">نشط</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters Card -->
<div class="card filter-card">
    <div class="card-body">
        <form method="get" id="carsFilterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">بحث</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input class="form-control" name="q" value="<?= e($q) ?>" placeholder="اسم السيارة أو الرقم...">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">الحالة</label>
                    <select class="form-select" name="active">
                        <option value="">الكل</option>
                        <option value="1" <?= $activeFilter === '1' ? 'selected' : '' ?>>نشط</option>
                        <option value="0" <?= $activeFilter === '0' ? 'selected' : '' ?>>متوقف</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">العرض</label>
                    <select class="form-select" name="offer">
                        <option value="">الكل</option>
                        <option value="1" <?= $offerFilter === '1' ? 'selected' : '' ?>>عرض خاص</option>
                        <option value="0" <?= $offerFilter === '0' ? 'selected' : '' ?>>بدون عرض</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">النوع</label>
                    <select class="form-select" name="type">
                        <option value="">الكل</option>
                        <?php foreach ($carTypes as $type): ?>
                            <option value="<?= e($type) ?>" <?= $typeFilter === $type ? 'selected' : '' ?>><?= e($type) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">السعر (يومي)</label>
                    <div class="input-group">
                        <input class="form-control" name="min_price" value="<?= e($minPrice) ?>" placeholder="من">
                        <input class="form-control" name="max_price" value="<?= e($maxPrice) ?>" placeholder="إلى">
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>
            
            <div class="filter-row d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <label class="form-label mb-0">ترتيب</label>
                        <select class="form-select form-select-sm" name="sort" style="width: auto;">
                            <option value="id_desc" <?= $sortBy === 'id_desc' ? 'selected' : '' ?>>الأحدث أولاً</option>
                            <option value="id_asc" <?= $sortBy === 'id_asc' ? 'selected' : '' ?>>الأقدم أولاً</option>
                            <option value="name_asc" <?= $sortBy === 'name_asc' ? 'selected' : '' ?>>الاسم (أ-ي)</option>
                            <option value="name_desc" <?= $sortBy === 'name_desc' ? 'selected' : '' ?>>الاسم (ي-أ)</option>
                            <option value="price_asc" <?= $sortBy === 'price_asc' ? 'selected' : '' ?>>السعر (منخفض)</option>
                            <option value="price_desc" <?= $sortBy === 'price_desc' ? 'selected' : '' ?>>(مرتفع) السعر</option>
                        </select>
                    </div>
                    <div class="view-toggle">
                        <button type="button" class="<?= $viewMode === 'grid' ? 'active' : '' ?>" onclick="setView('grid')" title="Grid View">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button type="button" class="<?= $viewMode === 'list' ? 'active' : '' ?>" onclick="setView('list')" title="List View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <input type="hidden" name="view" value="<?= e($viewMode) ?>" id="viewInput">
                    <span class="text-secondary small"><?= number_format($total) ?> نتيجة</span>
                    <a class="btn btn-outline-secondary btn-sm" href="cars.php">مسح</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Actions -->
<form method="post" id="bulkForm">
    <input type="hidden" name="action" value="bulk_delete">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center gap-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">تحديد الكل</label>
            </div>
            <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()" id="bulkDeleteBtn" style="display: none;">
                <i class="fas fa-trash me-1"></i> حذف المحدد
            </button>
        </div>
        <div class="d-flex gap-2">
            <form method="post" class="d-inline" onsubmit="return confirm('سيتم حذف جميع السيارات والعروض والصور. هل أنت متأكد؟');">
                <input type="hidden" name="action" value="delete_all">
                <button class="btn btn-outline-danger btn-sm" type="submit">
                    <i class="fas fa-trash me-1"></i> حذف الكل
                </button>
            </form>
            <a class="btn btn-primary" href="car_edit.php">
                <i class="fas fa-plus me-1"></i> إضافة سيارة
            </a>
        </div>
    </div>

    <!-- Messages -->
    <?php if (isset($_GET['single'])): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>
            <?= $_GET['single'] === '1' ? 'تم تفعيل سيارة واحدة في الموقع.' : 'فشل تنفيذ العملية.' ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>
            <?= $_GET['deleted'] === '1' ? 'تم حذف السيارة بنجاح.' : 'فشل حذف السيارة.' ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['deleted_all'])): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>
            <?= $_GET['deleted_all'] === '1' ? 'تم حذف جميع السيارات.' : 'فشل الحذف.' ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['reset'])): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>
            <?= $_GET['reset'] === '1' ? 'تم إعداد كيا سيراتو مع العروض.' : 'فشل الإعداد.' ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['bulk_deleted'])): ?>
        <div class="alert alert-<?= $_GET['bulk_deleted'] === '1' ? 'success' : 'danger' ?>">
            <i class="fas fa-<?= $_GET['bulk_deleted'] === '1' ? 'check' : 'times' ?>-circle me-2"></i>
            <?= $_GET['bulk_deleted'] === '1' ? 'تم حذف السيارات المحددة.' : 'فشل الحذف.' ?>
        </div>
    <?php endif; ?>

    <!-- Cars Display -->
    <?php if ($viewMode === 'grid'): ?>
        <div class="cars-grid">
            <?php foreach ($cars as $c): ?>
                <div class="car-card">
                    <div class="car-image">
                        <div class="car-checkbox">
                            <input type="checkbox" name="selected_cars[]" value="<?= (int)$c['id'] ?>" class="car-select">
                        </div>
                        <?php if (!empty($c['primary_image'])): ?>
                            <img src="<?= e(asset_url('../' . ltrim($c['primary_image'], '/'))) ?>" alt="<?= e($c['name_ar']) ?>">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center h-100 text-secondary">
                                <i class="fas fa-car fa-3x" style="opacity: 0.3;"></i>
                            </div>
                        <?php endif; ?>
                        <?php if ((int)$c['image_count'] > 0): ?>
                            <span class="image-count"><i class="fas fa-images"></i> <?= (int)$c['image_count'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="car-body">
                        <div class="car-title"><?= e($c['name_ar']) ?></div>
                        <div class="car-type"><?= e($c['type_ar'] ?? $c['type_en'] ?? '') ?></div>
                        
                        <div class="car-badges">
                            <span class="badge-status <?= (int)$c['is_active'] === 1 ? 'active' : 'inactive' ?>">
                                <?= (int)$c['is_active'] === 1 ? 'نشط' : 'متوقف' ?>
                            </span>
                            <span class="badge-status <?= (int)$c['is_offer'] === 1 ? 'offer' : 'no-offer' ?>">
                                <?= (int)$c['is_offer'] === 1 ? 'عرض خاص' : 'بدون عرض' ?>
                            </span>
                        </div>
                        
                        <div class="car-price">
                            <div class="price-item">
                                <div class="price-label">يومي</div>
                                <div class="price-value daily">₪<?= number_format((float)$c['daily_price'], 0) ?></div>
                            </div>
                            <div class="price-item">
                                <div class="price-label">شهري</div>
                                <div class="price-value monthly">₪<?= number_format((float)$c['monthly_price'], 0) ?></div>
                            </div>
                        </div>
                        
                        <div class="booking-count">
                            <i class="fas fa-calendar-check"></i>
                            <?= (int)$c['booking_count'] ?> حجز
                        </div>
                        
                        <div class="car-actions">
                            <form method="post" class="d-inline flex-fill">
                                <input type="hidden" name="action" value="toggle_active">
                                <input type="hidden" name="car_id" value="<?= (int)$c['id'] ?>">
                                <button class="btn btn-outline-<?= (int)$c['is_active'] === 1 ? 'warning' : 'success' ?>" title="<?= (int)$c['is_active'] === 1 ? 'تعطيل' : 'تفعيل' ?>">
                                    <i class="fas fa-<?= (int)$c['is_active'] === 1 ? 'ban' : 'check' ?>"></i>
                                </button>
                            </form>
                            <a class="btn btn-outline-secondary flex-fill" href="car_images.php?car_id=<?= (int)$c['id'] ?>" title="الصور">
                                <i class="fas fa-images"></i>
                            </a>
                            <a class="btn btn-outline-primary flex-fill" href="car_edit.php?id=<?= (int)$c['id'] ?>" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="post" class="d-inline flex-fill" onsubmit="return confirm('حذف السيارة؟')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="car_id" value="<?= (int)$c['id'] ?>">
                                <button class="btn btn-outline-danger" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="cars-list">
            <?php foreach ($cars as $c): ?>
                <div class="car-list-item d-flex">
                    <div class="car-checkbox" style="position: relative; top: auto; left: auto; padding: 8px;">
                        <input type="checkbox" name="selected_cars[]" value="<?= (int)$c['id'] ?>" class="car-select">
                    </div>
                    <div class="car-image">
                        <?php if (!empty($c['primary_image'])): ?>
                            <img src="<?= e(asset_url('../' . ltrim($c['primary_image'], '/'))) ?>" alt="<?= e($c['name_ar']) ?>">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center h-100 text-secondary">
                                <i class="fas fa-car fa-2x" style="opacity: 0.3;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="car-body">
                        <div class="car-info">
                            <div class="car-title"><?= e($c['name_ar']) ?></div>
                            <div class="car-type"><?= e($c['type_ar'] ?? $c['type_en'] ?? '') ?></div>
                        </div>
                        <div class="car-price">
                            <div class="price-item">
                                <div class="price-label">يومي</div>
                                <div class="price-value" style="color: #3b82f6;">₪<?= number_format((float)$c['daily_price'], 0) ?></div>
                            </div>
                            <div class="price-item">
                                <div class="price-label">شهري</div>
                                <div class="price-value" style="color: #22c55e;">₪<?= number_format((float)$c['monthly_price'], 0) ?></div>
                            </div>
                        </div>
                        <div class="car-badges">
                            <span class="badge-status <?= (int)$c['is_active'] === 1 ? 'active' : 'inactive' ?>">
                                <?= (int)$c['is_active'] === 1 ? 'نشط' : 'متوقف' ?>
                            </span>
                            <span class="badge-status <?= (int)$c['is_offer'] === 1 ? 'offer' : 'no-offer' ?>">
                                <?= (int)$c['is_offer'] === 1 ? 'عرض' : 'بدون' ?>
                            </span>
                        </div>
                        <div class="car-actions">
                            <form method="post" class="d-inline">
                                <input type="hidden" name="action" value="toggle_active">
                                <input type="hidden" name="car_id" value="<?= (int)$c['id'] ?>">
                                <button class="btn btn-sm btn-outline-<?= (int)$c['is_active'] === 1 ? 'warning' : 'success' ?>">
                                    <i class="fas fa-<?= (int)$c['is_active'] === 1 ? 'ban' : 'check' ?>"></i>
                                </button>
                            </form>
                            <a class="btn btn-sm btn-outline-secondary" href="car_images.php?car_id=<?= (int)$c['id'] ?>">
                                <i class="fas fa-images"></i>
                            </a>
                            <a class="btn btn-sm btn-outline-primary" href="car_edit.php?id=<?= (int)$c['id'] ?>">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="post" class="d-inline" onsubmit="return confirm('حذف؟')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="car_id" value="<?= (int)$c['id'] ?>">
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!$cars): ?>
        <div class="text-center py-5">
            <i class="fas fa-car" style="font-size: 64px; color: #cbd5e1; margin-bottom: 16px; display: block;"></i>
            <p class="text-secondary">لا توجد سيارات</p>
            <a href="car_edit.php" class="btn btn-primary">إضافة سيارة جديدة</a>
        </div>
    <?php endif; ?>
</form>

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
    <nav class="mt-4" aria-label="Pagination">
        <ul class="pagination justify-content-center flex-wrap">
            <?php
            $mk = static function (int $p) use ($qsBase): string {
                $qs = $qsBase;
                $qs['page'] = $p;
                return 'cars.php?' . http_build_query($qs);
            };
            $prev = max(1, $pageNo - 1);
            $next = min($totalPages, $pageNo + 1);
            ?>
            <li class="page-item <?= $pageNo <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= e($mk($prev)) ?>">Previous</a>
            </li>

            <?php
            $start = max(1, $pageNo - 2);
            $end = min($totalPages, $pageNo + 2);
            if ($start > 1) {
                echo '<li class="page-item"><a class="page-link" href="' . e($mk(1)) . '">1</a></li>';
                if ($start > 2) {
                    echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                }
            }
            for ($p = $start; $p <= $end; $p++) {
                $active = $p === $pageNo ? 'active' : '';
                echo '<li class="page-item ' . $active . '"><a class="page-link" href="' . e($mk($p)) . '">' . (int)$p . '</a></li>';
            }
            if ($end < $totalPages) {
                if ($end < $totalPages - 1) {
                    echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                }
                echo '<li class="page-item"><a class="page-link" href="' . e($mk($totalPages)) . '">' . (int)$totalPages . '</a></li>';
            }
            ?>

            <li class="page-item <?= $pageNo >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= e($mk($next)) ?>">Next</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<script>
function setView(mode) {
    document.getElementById('viewInput').value = mode;
    document.getElementById('carsFilterForm').submit();
}

// Select All Checkbox
document.getElementById('selectAll')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.car-select');
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateBulkButtons();
});

// Individual checkbox
document.querySelectorAll('.car-select').forEach(cb => {
    cb.addEventListener('change', updateBulkButtons);
});

function updateBulkButtons() {
    const checked = document.querySelectorAll('.car-select:checked');
    const btn = document.getElementById('bulkDeleteBtn');
    btn.style.display = checked.length > 0 ? 'inline-block' : 'none';
}

function bulkDelete() {
    const checked = document.querySelectorAll('.car-select:checked');
    if (checked.length === 0) {
        showToast('يرجى تحديد سيارات للحذف', 'warning');
        return;
    }
    if (confirm('حذف ' + checked.length + ' سيارة؟')) {
        document.getElementById('bulkForm').submit();
    }
}

// Toast Notifications
function showToast(message, type = 'info') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = 'toast ' + type;
    
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-times-circle',
        info: 'fa-info-circle',
        warning: 'fa-exclamation-circle'
    };
    
    toast.innerHTML = '<i class="fas ' + icons[type] + '"></i><span>' + message + '</span>';
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideIn 0.3s reverse';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Auto-submit on filter change
document.querySelectorAll('#carsFilterForm select').forEach(select => {
    select.addEventListener('change', () => document.getElementById('carsFilterForm').submit());
});

// Show toast for URL params
<?php if (isset($_GET['deleted']) && $_GET['deleted'] === '1'): ?>
showToast('تم حذف السيارة بنجاح', 'success');
<?php endif; ?>
<?php if (isset($_GET['bulk_deleted']) && $_GET['bulk_deleted'] === '1'): ?>
showToast('تم حذف السيارات المحددة', 'success');
<?php endif; ?>
<?php if (isset($_GET['single']) && $_GET['single'] === '1'): ?>
showToast('تم تفعيل السيارة في الموقع', 'success');
<?php endif; ?>
</script>

<?php include __DIR__ . '/partials/footer-modern.php'; ?>
