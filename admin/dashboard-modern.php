<?php

require_once __DIR__ . '/includes/auth.php';
require_admin();

// Get statistics
$stats = [
    'cars' => (int)db()->query('SELECT COUNT(*) AS c FROM cars')->fetch()['c'],
    'offers' => 0,
    'slides' => (int)db()->query('SELECT COUNT(*) AS c FROM slides')->fetch()['c'],
    'bookings' => (int)db()->query('SELECT COUNT(*) AS c FROM bookings')->fetch()['c'],
    'bookings_new' => 0,
    'bookings_pending' => 0,
];

try {
    $stats['offers'] = (int)db()->query('SELECT COUNT(*) AS c FROM offers')->fetch()['c'];
} catch (Throwable $e) {
}

try {
    $stats['bookings_new'] = (int)db()->query("SELECT COUNT(*) AS c FROM bookings WHERE status = 'new'")->fetch()['c'];
} catch (Throwable $e) {
}

try {
    $stats['bookings_pending'] = (int)db()->query("SELECT COUNT(*) AS c FROM bookings WHERE status = 'pending'")->fetch()['c'];
} catch (Throwable $e) {
}

// Get recent bookings
$recentBookings = [];
try {
    $sql = "SELECT b.*, c.name_ar, c.name_en
            FROM bookings b
            LEFT JOIN cars c ON c.id = b.car_id
            ORDER BY b.id DESC
            LIMIT 10";
    $recentBookings = db()->query($sql)->fetchAll();
} catch (Throwable $e) {
    $recentBookings = [];
}

// Get recent cars
$recentCars = [];
try {
    $sql = "SELECT id, name_ar, name_en, price, status
            FROM cars
            ORDER BY id DESC
            LIMIT 5";
    $recentCars = db()->query($sql)->fetchAll();
} catch (Throwable $e) {
    $recentCars = [];
}

include __DIR__ . '/partials/header-modern.php';
?>

<!-- Page Header -->
<div class="d-flex align-items-center justify-content-between mb-5 flex-wrap gap-3">
    <div>
        <h1 class="h2 fw-bold m-0" style="color: #0f172a;">
            <i class="fas fa-tachometer-alt"></i> لوحة التحكم
        </h1>
        <p class="text-muted mb-0 mt-2">مرحباً بك في لوحة التحكم الإدارية</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a class="btn btn-outline-secondary" href="../index.php" target="_blank">
            <i class="fas fa-arrow-right"></i> عرض الموقع
        </a>
    </div>
</div>

<!-- Main Statistics -->
<div class="row g-4 mb-5">
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm admin-metric h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="metric-label">
                            <i class="fas fa-car"></i> السيارات
                        </div>
                        <div class="metric-value"><?= number_format($stats['cars']) ?></div>
                        <div class="metric-change positive">
                            <i class="fas fa-arrow-up"></i> من إجمالي الأسطول
                        </div>
                    </div>
                    <div class="metric-icon primary">
                        <i class="fas fa-car"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm admin-metric h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="metric-label">
                            <i class="fas fa-calendar-check"></i> الحجوزات
                        </div>
                        <div class="metric-value"><?= number_format($stats['bookings']) ?></div>
                        <div class="metric-change positive">
                            <i class="fas fa-plus"></i> <?= $stats['bookings_new'] ?> حجز جديد
                        </div>
                    </div>
                    <div class="metric-icon success">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm admin-metric h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="metric-label">
                            <i class="fas fa-tag"></i> العروض
                        </div>
                        <div class="metric-value"><?= number_format($stats['offers']) ?></div>
                        <div class="metric-change">
                            عروض نشطة
                        </div>
                    </div>
                    <div class="metric-icon warning">
                        <i class="fas fa-tag"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm admin-metric h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="metric-label">
                            <i class="fas fa-images"></i> الشرائح
                        </div>
                        <div class="metric-value"><?= number_format($stats['slides']) ?></div>
                        <div class="metric-change">
                            في الصفحة الرئيسية
                        </div>
                    </div>
                    <div class="metric-icon info">
                        <i class="fas fa-images"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Data Sections -->
<div class="row g-4">
    <!-- Recent Bookings -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between p-4">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list"></i> الحجوزات الأخيرة
                </h5>
                <a href="bookings.php" class="btn btn-sm btn-outline-primary">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <?php if (count($recentBookings) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>السيارة</th>
                                    <th>العميل</th>
                                    <th>التاريخ</th>
                                    <th>الحالة</th>
                                    <th>الإجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($recentBookings, 0, 8) as $booking): ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">#<?= e((string)$booking['id']) ?></span>
                                        </td>
                                        <td>
                                            <strong><?= e(current_lang() === 'ar' ? (string)$booking['name_ar'] : (string)$booking['name_en']) ?></strong>
                                        </td>
                                        <td><?= e((string)$booking['customer_name'] ?? '-') ?></td>
                                        <td>
                                            <small class="text-muted">
                                                <?= e(substr((string)$booking['created_at'], 0, 10)) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php
                                            $status = (string)$booking['status'];
                                            $statusClass = 'active';
                                            $statusLabel = 'جديد';
                                            
                                            if ($status === 'completed') {
                                                $statusClass = 'active';
                                                $statusLabel = 'مكتمل';
                                            } elseif ($status === 'pending') {
                                                $statusClass = 'pending';
                                                $statusLabel = 'قيد الانتظار';
                                            } elseif ($status === 'cancelled') {
                                                $statusClass = 'inactive';
                                                $statusLabel = 'ملغى';
                                            }
                                            ?>
                                            <span class="status-badge <?= $statusClass ?>">
                                                <?= $statusLabel ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="booking_edit.php?id=<?= e((string)$booking['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-inbox" style="font-size: 48px; color: #cbd5e1; margin-bottom: 15px; display: block;"></i>
                        <p class="text-muted">لا توجد حجوزات حتى الآن</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-lg-4">
        <!-- Active Cars -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-cog"></i> الحالة
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>السيارات النشطة</span>
                    <span class="badge bg-success"><?= $stats['cars'] ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>الحجوزات الجديدة</span>
                    <span class="badge bg-warning"><?= $stats['bookings_new'] ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>قيد الانتظار</span>
                    <span class="badge bg-info"><?= $stats['bookings_pending'] ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>إجمالي العروض</span>
                    <span class="badge bg-primary"><?= $stats['offers'] ?></span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-bolt"></i> إجراءات سريعة
                </h5>
            </div>
            <div class="card-body">
                <a href="cars.php?action=add" class="btn btn-block btn-outline-primary w-100 mb-2">
                    <i class="fas fa-plus"></i> إضافة سيارة جديدة
                </a>
                <a href="bookings.php" class="btn btn-block btn-outline-success w-100 mb-2">
                    <i class="fas fa-calendar-alt"></i> إدارة الحجوزات
                </a>
                <a href="offers.php?action=add" class="btn btn-block btn-outline-warning w-100 mb-2">
                    <i class="fas fa-plus-circle"></i> إضافة عرض جديد
                </a>
                <a href="settings.php" class="btn btn-block btn-outline-secondary w-100">
                    <i class="fas fa-cog"></i> الإعدادات
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer-modern.php'; ?>
