<?php

require_once __DIR__ . '/includes/auth.php';
require_admin();

$stats = [
    'cars' => (int)db()->query('SELECT COUNT(*) AS c FROM cars')->fetch()['c'],
    'offers' => 0,
    'slides' => (int)db()->query('SELECT COUNT(*) AS c FROM slides')->fetch()['c'],
    'bookings' => (int)db()->query('SELECT COUNT(*) AS c FROM bookings')->fetch()['c'],
    'bookings_new' => 0,
];

try {
    $stats['offers'] = (int)db()->query('SELECT COUNT(*) AS c FROM offers')->fetch()['c'];
} catch (Throwable $e) {
}

try {
    $stats['bookings_new'] = (int)db()->query("SELECT COUNT(*) AS c FROM bookings WHERE status = 'new'")->fetch()['c'];
} catch (Throwable $e) {
}

$recentBookings = [];
try {
    $sql = "SELECT b.*, c.name_ar, c.name_en
            FROM bookings b
            LEFT JOIN cars c ON c.id = b.car_id
            ORDER BY b.id DESC
            LIMIT 8";
    $recentBookings = db()->query($sql)->fetchAll();
} catch (Throwable $e) {
    $recentBookings = [];
}

include __DIR__ . '/partials/header.php';

?>

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h3 fw-bold m-0"><?= e(t('dash')) ?></h1>
        <div class="text-secondary small"><?= e(company_name()) ?></div>
    </div>
    <a class="btn btn-outline-secondary" href="../index.php" target="_blank">فتح الموقع</a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm admin-metric">
            <div class="card-body">
                <div class="text-secondary small"><?= e(t('manage_cars')) ?></div>
                <div class="display-6 fw-bold"><?= (int)$stats['cars'] ?></div>
                <a class="btn btn-primary btn-sm mt-2" href="cars.php"><?= e(t('manage_cars')) ?></a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm admin-metric">
            <div class="card-body">
                <div class="text-secondary small"><?= e(t('manage_slides')) ?></div>
                <div class="display-6 fw-bold"><?= (int)$stats['slides'] ?></div>
                <a class="btn btn-primary btn-sm mt-2" href="slides.php"><?= e(t('manage_slides')) ?></a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm admin-metric">
            <div class="card-body">
                <div class="text-secondary small"><?= e(t('manage_bookings')) ?></div>
                <div class="display-6 fw-bold"><?= (int)$stats['bookings'] ?></div>
                <div class="d-flex gap-2 flex-wrap mt-2">
                    <a class="btn btn-primary btn-sm" href="bookings.php"><?= e(t('manage_bookings')) ?></a>
                    <span class="badge text-bg-info align-self-center">New: <?= (int)$stats['bookings_new'] ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm admin-metric">
            <div class="card-body">
                <div class="text-secondary small"><?= e(t('manage_offers')) ?></div>
                <div class="display-6 fw-bold"><?= (int)$stats['offers'] ?></div>
                <a class="btn btn-primary btn-sm mt-2" href="offers.php"><?= e(t('manage_offers')) ?></a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                    <div>
                        <div class="fw-bold">آخر الحجوزات</div>
                        <div class="text-secondary small">آخر 8 طلبات</div>
                    </div>
                    <a class="btn btn-outline-secondary btn-sm" href="bookings.php">عرض الكل</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>العميل</th>
                            <th>الهاتف</th>
                            <th>السيارة</th>
                            <th>الحالة</th>
                            <th class="text-end"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($recentBookings) === 0): ?>
                            <tr>
                                <td colspan="6" class="text-secondary">لا توجد حجوزات حالياً.</td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($recentBookings as $b):
                            $carName = current_lang() === 'ar' ? (string)($b['name_ar'] ?? '') : (string)($b['name_en'] ?? '');
                            $status = (string)($b['status'] ?? '');
                        ?>
                            <tr>
                                <td><?= (int)$b['id'] ?></td>
                                <td><?= e((string)($b['customer_name'] ?? '')) ?></td>
                                <td dir="ltr"><?= e((string)($b['phone'] ?? '')) ?></td>
                                <td><?= e($carName) ?></td>
                                <td><span class="badge text-bg-secondary"><?= e($status) ?></span></td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a class="btn btn-outline-primary btn-sm" href="booking_edit.php?id=<?= (int)$b['id'] ?>">تعديل</a>
                                        <a class="btn btn-outline-secondary btn-sm" href="booking_invoice.php?id=<?= (int)$b['id'] ?>" target="_blank">فاتورة</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
