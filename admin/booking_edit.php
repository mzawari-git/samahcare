<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin']);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT b.*, 
            c.name_ar AS car_name_ar, c.name_en AS car_name_en,
            o.title_ar AS offer_title_ar, o.title_en AS offer_title_en, o.daily_price AS offer_daily_price, o.days AS offer_days
        FROM bookings b
        LEFT JOIN cars c ON c.id = b.car_id
        LEFT JOIN offers o ON o.id = b.offer_id
        WHERE b.id = :id
        LIMIT 1";
$stmt = db()->prepare($sql);
$stmt->execute([':id' => $id]);
$booking = $stmt->fetch();

if (!$booking) {
    include __DIR__ . '/partials/header.php';
    ?>
    <div class="alert alert-danger">Booking not found</div>
    <a class="btn btn-outline-secondary" href="bookings.php">رجوع</a>
    <?php
    include __DIR__ . '/partials/footer.php';
    exit;
}

$cars = db()->query('SELECT id, name_ar, name_en FROM cars ORDER BY id DESC')->fetchAll();
$offers = db()->query('SELECT id, car_id, title_ar, title_en, days, daily_price FROM offers ORDER BY id DESC')->fetchAll();

$errors = [];
$success = false;

$saveUpload = static function (string $field, string $prefix): ?string {
    if (!isset($_FILES[$field]) || !is_array($_FILES[$field])) {
        return null;
    }
    $f = $_FILES[$field];
    if (($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }

    $tmp = (string)($f['tmp_name'] ?? '');
    if ($tmp === '' || !is_uploaded_file($tmp)) {
        return null;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = (string)($finfo->file($tmp) ?: '');
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];
    if (!isset($allowed[$mime])) {
        return null;
    }

    $name = $prefix . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $allowed[$mime];
    $dest = rtrim(UPLOADS_DIR, '/\\') . DIRECTORY_SEPARATOR . $name;
    if (!@move_uploaded_file($tmp, $dest)) {
        return null;
    }

    return rtrim(UPLOADS_URL, '/') . '/' . $name;
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = trim((string)($_POST['customer_name'] ?? ''));
    $phone = trim((string)($_POST['phone'] ?? ''));
    $startDate = trim((string)($_POST['start_date'] ?? ''));
    $endDate = trim((string)($_POST['end_date'] ?? ''));
    $notes = trim((string)($_POST['notes'] ?? ''));
    $status = trim((string)($_POST['status'] ?? 'new'));
    $carId = (int)($_POST['car_id'] ?? 0);
    $offerId = (int)($_POST['offer_id'] ?? 0);
    $totalPrice = isset($_POST['total_price']) ? (float)$_POST['total_price'] : 0;
    $numDays = isset($_POST['num_days']) ? (int)$_POST['num_days'] : 1;

    if ($customerName === '' || $phone === '') {
        $errors[] = 'الاسم ورقم الهاتف مطلوبان.';
    }

    if ($startDate === '' || $endDate === '' || strtotime($endDate) < strtotime($startDate)) {
        $errors[] = 'تواريخ الحجز غير صحيحة.';
    }

    if (!in_array($status, ['new', 'contacted', 'confirmed', 'cancelled'], true)) {
        $errors[] = 'الحالة غير صحيحة.';
    }

    $carIdDb = $carId > 0 ? $carId : null;
    $offerIdDb = $offerId > 0 ? $offerId : null;

    $idImagePath = $saveUpload('id_image', 'booking_' . (int)$booking['id'] . '_id');
    $licenseImagePath = $saveUpload('license_image', 'booking_' . (int)$booking['id'] . '_lic');

    if (!$errors) {
        $newIdPath = $idImagePath !== null ? $idImagePath : (string)($booking['id_image_path'] ?? '');
        $newLicPath = $licenseImagePath !== null ? $licenseImagePath : (string)($booking['license_image_path'] ?? '');

        $upd = db()->prepare('UPDATE bookings SET car_id = :car_id, offer_id = :offer_id, customer_name = :customer_name, phone = :phone, start_date = :start_date, end_date = :end_date, notes = :notes, status = :status, id_image_path = :id_image_path, license_image_path = :license_image_path, total_price = :total_price, num_days = :num_days WHERE id = :id');
        $upd->execute([
            ':car_id' => $carIdDb,
            ':offer_id' => $offerIdDb,
            ':customer_name' => $customerName,
            ':phone' => $phone,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':notes' => $notes,
            ':status' => $status,
            ':id_image_path' => $newIdPath !== '' ? $newIdPath : null,
            ':license_image_path' => $newLicPath !== '' ? $newLicPath : null,
            ':total_price' => $totalPrice,
            ':num_days' => $numDays,
            ':id' => (int)$booking['id'],
        ]);

        header('Location: booking_edit.php?id=' . (int)$booking['id'] . '&saved=1');
        exit;
    }
}

if (isset($_GET['saved'])) {
    $success = true;
}

// refresh after save
$stmt = db()->prepare($sql);
$stmt->execute([':id' => (int)$booking['id']]);
$booking = $stmt->fetch() ?: $booking;

include __DIR__ . '/partials/header.php';

$lang = current_lang();
$carName = $lang === 'ar' ? (string)($booking['car_name_ar'] ?? '') : (string)($booking['car_name_en'] ?? '');
$offerTitle = $lang === 'ar' ? (string)($booking['offer_title_ar'] ?? '') : (string)($booking['offer_title_en'] ?? '');

?>

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <div>
        <h1 class="h4 fw-bold m-0">تعديل الحجز #<?= (int)$booking['id'] ?></h1>
        <div class="text-secondary small">
            <?= e($carName) ?>
            <?php if (trim($offerTitle) !== ''): ?>
                - <?= e($offerTitle) ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-secondary" href="bookings.php">رجوع</a>
        <a class="btn btn-outline-secondary" href="booking_invoice.php?id=<?= (int)$booking['id'] ?>" target="_blank">فاتورة</a>
    </div>
</div>

<?php if ($success): ?>
    <div class="alert alert-success">تم حفظ التعديل.</div>
<?php endif; ?>

<?php if ($errors): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $err): ?>
            <div><?= e((string)$err) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="post" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">الاسم</label>
                <input class="form-control" name="customer_name" value="<?= e((string)($booking['customer_name'] ?? '')) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">الهاتف</label>
                <input class="form-control" name="phone" value="<?= e((string)($booking['phone'] ?? '')) ?>" dir="ltr" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">من تاريخ</label>
                <input class="form-control" type="date" name="start_date" value="<?= e((string)($booking['start_date'] ?? '')) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">إلى تاريخ</label>
                <input class="form-control" type="date" name="end_date" value="<?= e((string)($booking['end_date'] ?? '')) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">السيارة</label>
                <select class="form-select" name="car_id">
                    <option value="0">بدون</option>
                    <?php foreach ($cars as $c):
                        $name = $lang === 'ar' ? (string)($c['name_ar'] ?? '') : (string)($c['name_en'] ?? '');
                        $selected = ((int)($booking['car_id'] ?? 0) === (int)$c['id']) ? 'selected' : '';
                    ?>
                        <option value="<?= (int)$c['id'] ?>" <?= $selected ?>>#<?= (int)$c['id'] ?> - <?= e($name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">العرض</label>
                <select class="form-select" name="offer_id">
                    <option value="0">بدون</option>
                    <?php foreach ($offers as $o):
                        $t = $lang === 'ar' ? (string)($o['title_ar'] ?? '') : (string)($o['title_en'] ?? '');
                        $t = trim($t) !== '' ? $t : ('Offer #' . (int)$o['id']);
                        $selected = ((int)($booking['offer_id'] ?? 0) === (int)$o['id']) ? 'selected' : '';
                    ?>
                        <option value="<?= (int)$o['id'] ?>" <?= $selected ?>>#<?= (int)$o['id'] ?> - <?= e($t) ?> (<?= (int)($o['days'] ?? 1) ?> يوم / <?= e((string)($o['daily_price'] ?? '0')) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">الحالة</label>
                <select class="form-select" name="status">
                    <?php $st = (string)($booking['status'] ?? 'new'); ?>
                    <option value="new" <?= $st === 'new' ? 'selected' : '' ?>>new</option>
                    <option value="contacted" <?= $st === 'contacted' ? 'selected' : '' ?>>contacted</option>
                    <option value="confirmed" <?= $st === 'confirmed' ? 'selected' : '' ?>>confirmed</option>
                    <option value="cancelled" <?= $st === 'cancelled' ? 'selected' : '' ?>>cancelled</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">ملاحظات</label>
                <textarea class="form-control" rows="2" name="notes"><?= e((string)($booking['notes'] ?? '')) ?></textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">عدد الأيام</label>
                <input class="form-control" type="number" name="num_days" value="<?= (int)($booking['num_days'] ?? 1) ?>" min="1">
            </div>

            <div class="col-md-4">
                <label class="form-label">السعر الإجمالي (₪)</label>
                <input class="form-control" type="number" name="total_price" value="<?= number_format((float)($booking['total_price'] ?? 0), 2, '.', '') ?>" step="0.01" min="0">
            </div>

            <div class="col-md-6">
                <label class="form-label">صورة الهوية (اختياري للتحديث)</label>
                <input class="form-control" type="file" name="id_image" accept="image/*">
                <?php $idImg = trim((string)($booking['id_image_path'] ?? '')); ?>
                <?php if ($idImg !== ''): ?>
                    <div class="mt-2">
                        <a href="<?= e(asset_url('../' . ltrim($idImg, '/'))) ?>" target="_blank" rel="noopener">
                            <img src="<?= e(asset_url('../' . ltrim($idImg, '/'))) ?>" alt="id" style="width:84px; height:84px; object-fit:cover; border-radius:14px;">
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label class="form-label">صورة الرخصة (اختياري للتحديث)</label>
                <input class="form-control" type="file" name="license_image" accept="image/*">
                <?php $licImg = trim((string)($booking['license_image_path'] ?? '')); ?>
                <?php if ($licImg !== ''): ?>
                    <div class="mt-2">
                        <a href="<?= e(asset_url('../' . ltrim($licImg, '/'))) ?>" target="_blank" rel="noopener">
                            <img src="<?= e(asset_url('../' . ltrim($licImg, '/'))) ?>" alt="license" style="width:84px; height:84px; object-fit:cover; border-radius:14px;">
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
