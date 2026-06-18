<?php

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin', 'editor']);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$offer = null;

if ($id > 0) {
    try {
        $stmt = db()->prepare('SELECT * FROM offers WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $offer = $stmt->fetch();
    } catch (Throwable $e) {
        $offer = null;
    }
}

$cars = db()->query('SELECT id, name_ar, name_en FROM cars ORDER BY id DESC')->fetchAll();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carId = (int)($_POST['car_id'] ?? 0);
    $titleAr = trim((string)($_POST['title_ar'] ?? ''));
    $titleEn = trim((string)($_POST['title_en'] ?? ''));
    $descAr = trim((string)($_POST['description_ar'] ?? ''));
    $descEn = trim((string)($_POST['description_en'] ?? ''));
    $daily = (float)($_POST['daily_price'] ?? 0);
    $days = (int)($_POST['days'] ?? 1);
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    $promoSlide = isset($_POST['promo_slide']) ? 1 : 0;
    $expiresAt = trim((string)($_POST['expires_at'] ?? ''));
    if ($expiresAt === '') {
        $expiresAt = null;
    }

    if ($carId <= 0) {
        $errors[] = 'السيارة مطلوبة';
    }
    if ($daily <= 0) {
        $errors[] = 'سعر اليوم مطلوب';
    }
    if ($days <= 0) {
        $days = 1;
    }

    $imagePath = (string)($offer['image_path'] ?? '');

    if (isset($_FILES['image']) && is_array($_FILES['image']) && (int)($_FILES['image']['error'] ?? 1) === UPLOAD_ERR_OK) {
        $tmp = (string)$_FILES['image']['tmp_name'];
        $name = (string)$_FILES['image']['name'];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            $newName = 'offer_' . ($id > 0 ? $id : 'new') . '_' . time() . '.' . $ext;
            $dest = UPLOADS_DIR . '/' . $newName;
            if (move_uploaded_file($tmp, $dest)) {
                $imagePath = UPLOADS_URL . '/' . $newName;
            }
        } else {
            $errors[] = 'امتداد الصورة غير مدعوم';
        }
    }

    if (!$errors) {
        if ($id > 0) {
            $stmt = db()->prepare('UPDATE offers SET car_id=:car_id, title_ar=:title_ar, title_en=:title_en, description_ar=:d_ar, description_en=:d_en, daily_price=:daily_price, days=:days, image_path=:image_path, sort_order=:sort_order, is_active=:is_active, promo_slide=:promo_slide, expires_at=:expires_at WHERE id=:id');
            $stmt->execute([
                ':car_id' => $carId,
                ':title_ar' => $titleAr !== '' ? $titleAr : null,
                ':title_en' => $titleEn !== '' ? $titleEn : null,
                ':d_ar' => $descAr !== '' ? $descAr : null,
                ':d_en' => $descEn !== '' ? $descEn : null,
                ':daily_price' => $daily,
                ':days' => $days,
                ':image_path' => $imagePath !== '' ? $imagePath : null,
                ':sort_order' => $sortOrder,
                ':is_active' => $isActive,
                ':promo_slide' => $promoSlide,
                ':expires_at' => $expiresAt,
                ':id' => $id,
            ]);
        } else {
            $stmt = db()->prepare('INSERT INTO offers (car_id, title_ar, title_en, description_ar, description_en, daily_price, days, image_path, sort_order, is_active, promo_slide, expires_at) VALUES (:car_id,:title_ar,:title_en,:d_ar,:d_en,:daily_price,:days,:image_path,:sort_order,:is_active,:promo_slide,:expires_at)');
            $stmt->execute([
                ':car_id' => $carId,
                ':title_ar' => $titleAr !== '' ? $titleAr : null,
                ':title_en' => $titleEn !== '' ? $titleEn : null,
                ':d_ar' => $descAr !== '' ? $descAr : null,
                ':d_en' => $descEn !== '' ? $descEn : null,
                ':daily_price' => $daily,
                ':days' => $days,
                ':image_path' => $imagePath !== '' ? $imagePath : null,
                ':sort_order' => $sortOrder,
                ':is_active' => $isActive,
                ':promo_slide' => $promoSlide,
                ':expires_at' => $expiresAt,
            ]);
            $id = (int)db()->lastInsertId();
        }

        $slideId = (int)($offer['slide_id'] ?? 0);

        if ($promoSlide === 1 && $imagePath !== '') {
            $titleArSlide = $titleAr !== '' ? $titleAr : '';
            $titleEnSlide = $titleEn !== '' ? $titleEn : '';
            $subArSlide = $descAr !== '' ? $descAr : '';
            $subEnSlide = $descEn !== '' ? $descEn : '';

            if ($titleArSlide === '' || $titleEnSlide === '') {
                $stmtCar = db()->prepare('SELECT name_ar, name_en FROM cars WHERE id = :id');
                $stmtCar->execute([':id' => $carId]);
                $c = $stmtCar->fetch() ?: [];
                if ($titleArSlide === '') {
                    $titleArSlide = (string)($c['name_ar'] ?? '');
                }
                if ($titleEnSlide === '') {
                    $titleEnSlide = (string)($c['name_en'] ?? '');
                }
            }

            if ($subArSlide === '') {
                $subArSlide = 'فقط ' . number_format($daily, 0, '.', '') . ' شيكل في اليوم لمدة ' . (int)$days . ' أيام';
            }
            if ($subEnSlide === '') {
                $subEnSlide = 'Only ' . number_format($daily, 0, '.', '') . ' per day for ' . (int)$days . ' days';
            }

            if ($slideId > 0) {
                $stmtSlide = db()->prepare('UPDATE slides SET title_ar=:ta, title_en=:te, subtitle_ar=:sa, subtitle_en=:se, image_path=:img, sort_order=:so, is_active=1 WHERE id=:id');
                $stmtSlide->execute([
                    ':ta' => $titleArSlide,
                    ':te' => $titleEnSlide,
                    ':sa' => $subArSlide,
                    ':se' => $subEnSlide,
                    ':img' => $imagePath,
                    ':so' => $sortOrder,
                    ':id' => $slideId,
                ]);
            } else {
                $stmtSlide = db()->prepare('INSERT INTO slides (title_ar, title_en, subtitle_ar, subtitle_en, image_path, sort_order, is_active) VALUES (:ta,:te,:sa,:se,:img,:so,1)');
                $stmtSlide->execute([
                    ':ta' => $titleArSlide,
                    ':te' => $titleEnSlide,
                    ':sa' => $subArSlide,
                    ':se' => $subEnSlide,
                    ':img' => $imagePath,
                    ':so' => $sortOrder,
                ]);
                $slideId = (int)db()->lastInsertId();
                db()->prepare('UPDATE offers SET slide_id = :sid WHERE id = :id')->execute([':sid' => $slideId, ':id' => $id]);
            }
        }

        if ($promoSlide === 0 && $slideId > 0) {
            try {
                db()->prepare('UPDATE slides SET is_active = 0 WHERE id = :id')->execute([':id' => $slideId]);
            } catch (Throwable $e) {
            }
        }

        header('Location: offers.php');
        exit;
    }
}

$defaults = [
    'car_id' => (int)($offer['car_id'] ?? 0),
    'title_ar' => (string)($offer['title_ar'] ?? ''),
    'title_en' => (string)($offer['title_en'] ?? ''),
    'description_ar' => (string)($offer['description_ar'] ?? ''),
    'description_en' => (string)($offer['description_en'] ?? ''),
    'daily_price' => (string)($offer['daily_price'] ?? '0'),
    'days' => (int)($offer['days'] ?? 1),
    'sort_order' => (int)($offer['sort_order'] ?? 0),
    'is_active' => (int)($offer['is_active'] ?? 1),
    'image_path' => (string)($offer['image_path'] ?? ''),
    'promo_slide' => (int)($offer['promo_slide'] ?? 0),
    'expires_at' => (string)($offer['expires_at'] ?? ''),
];

include __DIR__ . '/partials/header.php';

?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 fw-bold m-0"><?= $id > 0 ? 'تعديل عرض' : 'إضافة عرض' ?></h1>
    <div class="d-flex gap-2">
        <?php if ($id > 0): ?>
            <a class="btn btn-outline-secondary" href="offer_media.php?offer_id=<?= (int)$id ?>">وسائط العرض</a>
        <?php endif; ?>
        <a class="btn btn-outline-secondary" href="offers.php">رجوع</a>
    </div>
</div>

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
                <label class="form-label">السيارة</label>
                <select class="form-select" name="car_id" required>
                    <option value="">-- اختر السيارة --</option>
                    <?php foreach ($cars as $c):
                        $label = current_lang() === 'ar' ? (string)$c['name_ar'] : (string)$c['name_en'];
                    ?>
                        <option value="<?= (int)$c['id'] ?>" <?= ((int)$defaults['car_id'] === (int)$c['id']) ? 'selected' : '' ?>>
                            #<?= (int)$c['id'] ?> - <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">سعر اليوم</label>
                <input class="form-control" type="number" step="0.01" name="daily_price" value="<?= e((string)$defaults['daily_price']) ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">عدد الأيام</label>
                <input class="form-control" type="number" name="days" value="<?= (int)$defaults['days'] ?>" min="1">
            </div>

            <div class="col-md-6">
                <label class="form-label">عنوان العرض (AR) (اختياري)</label>
                <input class="form-control" name="title_ar" value="<?= e((string)$defaults['title_ar']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Offer title (EN) (optional)</label>
                <input class="form-control" name="title_en" value="<?= e((string)$defaults['title_en']) ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">وصف (AR) (اختياري)</label>
                <input class="form-control" name="description_ar" value="<?= e((string)$defaults['description_ar']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Description (EN) (optional)</label>
                <input class="form-control" name="description_en" value="<?= e((string)$defaults['description_en']) ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">Sort order</label>
                <input class="form-control" name="sort_order" type="number" value="<?= (int)$defaults['sort_order'] ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">تاريخ الانتهاء (اختياري)</label>
                <input class="form-control" name="expires_at" type="date" value="<?= e((string)$defaults['expires_at']) ?>">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" <?= ((int)$defaults['is_active'] === 1) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">صورة العرض (اختياري)</label>
                <input class="form-control" type="file" name="image" accept="image/*">
                <?php if ((string)$defaults['image_path'] !== ''): ?>
                    <div class="mt-2">
                        <img src="<?= e(asset_url('../' . (string)$defaults['image_path'])) ?>" alt="offer" style="width:100%; max-width:360px; height:160px; object-fit:cover; border-radius:12px;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="promo_slide" id="promo_slide" <?= ((int)$defaults['promo_slide'] === 1) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="promo_slide">إضافة هذا العرض إلى السلايدشو (يتطلب صورة للعرض)</label>
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
