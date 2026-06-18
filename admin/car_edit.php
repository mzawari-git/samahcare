<?php

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin', 'editor']);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$car = null;

if ($id > 0) {
    $stmt = db()->prepare('SELECT * FROM cars WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $car = $stmt->fetch();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nameAr = trim((string)($_POST['name_ar'] ?? ''));
    $nameEn = trim((string)($_POST['name_en'] ?? ''));
    $typeAr = trim((string)($_POST['type_ar'] ?? ''));
    $typeEn = trim((string)($_POST['type_en'] ?? ''));
    $daily = (float)($_POST['daily_price'] ?? 0);
    $monthly = (float)($_POST['monthly_price'] ?? 0);
    $featuresAr = trim((string)($_POST['features_ar'] ?? ''));
    $featuresEn = trim((string)($_POST['features_en'] ?? ''));
    $isOffer = isset($_POST['is_offer']) ? 1 : 0;
    $offerAr = trim((string)($_POST['offer_details_ar'] ?? ''));
    $offerEn = trim((string)($_POST['offer_details_en'] ?? ''));
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    if ($nameAr === '' || $nameEn === '') {
        $errors[] = 'الاسم مطلوب';
    }

    $featuresAr = implode('|', array_values(array_filter(array_map('trim', preg_split('/[\n,]+/', $featuresAr) ?: []))));
    $featuresEn = implode('|', array_values(array_filter(array_map('trim', preg_split('/[\n,]+/', $featuresEn) ?: []))));

    if (!$errors) {
        if ($id > 0) {
            $stmt = db()->prepare('UPDATE cars SET name_ar=:name_ar, name_en=:name_en, type_ar=:type_ar, type_en=:type_en, daily_price=:daily_price, monthly_price=:monthly_price, features_ar=:features_ar, features_en=:features_en, is_offer=:is_offer, offer_details_ar=:offer_ar, offer_details_en=:offer_en, is_active=:is_active WHERE id=:id');
            $stmt->execute([
                ':name_ar' => $nameAr,
                ':name_en' => $nameEn,
                ':type_ar' => $typeAr,
                ':type_en' => $typeEn,
                ':daily_price' => $daily,
                ':monthly_price' => $monthly,
                ':features_ar' => $featuresAr,
                ':features_en' => $featuresEn,
                ':is_offer' => $isOffer,
                ':offer_ar' => $offerAr !== '' ? $offerAr : null,
                ':offer_en' => $offerEn !== '' ? $offerEn : null,
                ':is_active' => $isActive,
                ':id' => $id,
            ]);
        } else {
            $stmt = db()->prepare('INSERT INTO cars (name_ar, name_en, type_ar, type_en, daily_price, monthly_price, features_ar, features_en, is_offer, offer_details_ar, offer_details_en, is_active) VALUES (:name_ar,:name_en,:type_ar,:type_en,:daily_price,:monthly_price,:features_ar,:features_en,:is_offer,:offer_ar,:offer_en,:is_active)');
            $stmt->execute([
                ':name_ar' => $nameAr,
                ':name_en' => $nameEn,
                ':type_ar' => $typeAr,
                ':type_en' => $typeEn,
                ':daily_price' => $daily,
                ':monthly_price' => $monthly,
                ':features_ar' => $featuresAr,
                ':features_en' => $featuresEn,
                ':is_offer' => $isOffer,
                ':offer_ar' => $offerAr !== '' ? $offerAr : null,
                ':offer_en' => $offerEn !== '' ? $offerEn : null,
                ':is_active' => $isActive,
            ]);
            $id = (int)db()->lastInsertId();
        }

        if (isset($_FILES['image']) && is_array($_FILES['image']) && (int)($_FILES['image']['error'] ?? 1) === UPLOAD_ERR_OK) {
            $tmp = (string)$_FILES['image']['tmp_name'];
            $name = (string)$_FILES['image']['name'];
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $newName = 'car_' . $id . '_' . time() . '.' . $ext;
                $dest = UPLOADS_DIR . '/' . $newName;
                if (move_uploaded_file($tmp, $dest)) {
                    db()->prepare('UPDATE car_images SET is_primary = 0 WHERE car_id = :id')->execute([':id' => $id]);
                    db()->prepare('INSERT INTO car_images (car_id, file_path, sort_order, is_primary) VALUES (:car_id, :path, 1, 1)')
                        ->execute([':car_id' => $id, ':path' => UPLOADS_URL . '/' . $newName]);
                }
            }
        }

        header('Location: cars.php');
        exit;
    }
}

$defaults = [
    'name_ar' => $car['name_ar'] ?? '',
    'name_en' => $car['name_en'] ?? '',
    'type_ar' => $car['type_ar'] ?? '',
    'type_en' => $car['type_en'] ?? '',
    'daily_price' => $car['daily_price'] ?? '0',
    'monthly_price' => $car['monthly_price'] ?? '0',
    'features_ar' => isset($car['features_ar']) ? str_replace('|', "\n", (string)$car['features_ar']) : '',
    'features_en' => isset($car['features_en']) ? str_replace('|', "\n", (string)$car['features_en']) : '',
    'is_offer' => (int)($car['is_offer'] ?? 0),
    'offer_details_ar' => $car['offer_details_ar'] ?? '',
    'offer_details_en' => $car['offer_details_en'] ?? '',
    'is_active' => (int)($car['is_active'] ?? 1),
];

include __DIR__ . '/partials/header.php';

?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 fw-bold m-0"><?= $id > 0 ? 'تعديل سيارة' : 'إضافة سيارة' ?></h1>
    <div class="d-flex gap-2">
        <?php if ($id > 0): ?>
            <a class="btn btn-outline-secondary" href="car_images.php?car_id=<?= (int)$id ?>">صور السيارة</a>
        <?php endif; ?>
        <a class="btn btn-outline-secondary" href="cars.php">رجوع</a>
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
                <label class="form-label">الاسم (AR)</label>
                <input class="form-control" name="name_ar" value="<?= e((string)$defaults['name_ar']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Name (EN)</label>
                <input class="form-control" name="name_en" value="<?= e((string)$defaults['name_en']) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">النوع (AR)</label>
                <input class="form-control" name="type_ar" value="<?= e((string)$defaults['type_ar']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Type (EN)</label>
                <input class="form-control" name="type_en" value="<?= e((string)$defaults['type_en']) ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Daily price</label>
                <input class="form-control" name="daily_price" type="number" step="0.01" value="<?= e((string)$defaults['daily_price']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Monthly price</label>
                <input class="form-control" name="monthly_price" type="number" step="0.01" value="<?= e((string)$defaults['monthly_price']) ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Features (AR) (كل ميزة بسطر)</label>
                <textarea class="form-control" rows="5" name="features_ar"><?= e((string)$defaults['features_ar']) ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Features (EN) (one per line)</label>
                <textarea class="form-control" rows="5" name="features_en"><?= e((string)$defaults['features_en']) ?></textarea>
            </div>

            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_offer" id="is_offer" <?= ((int)$defaults['is_offer'] === 1) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_offer">Offer</label>
                </div>
                <label class="form-label mt-2">Offer details (AR)</label>
                <input class="form-control" name="offer_details_ar" value="<?= e((string)$defaults['offer_details_ar']) ?>">
                <label class="form-label mt-2">Offer details (EN)</label>
                <input class="form-control" name="offer_details_en" value="<?= e((string)$defaults['offer_details_en']) ?>">
            </div>

            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" <?= ((int)$defaults['is_active'] === 1) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>

                <label class="form-label mt-3">الصورة الرئيسية (رفع صورة)</label>
                <input class="form-control" type="file" name="image" accept="image/*">
                <div class="form-text">الامتدادات المسموحة: jpg, jpeg, png, webp</div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
