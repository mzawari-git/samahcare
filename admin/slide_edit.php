<?php

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin', 'editor']);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$slide = null;

if ($id > 0) {
    $stmt = db()->prepare('SELECT * FROM slides WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $slide = $stmt->fetch();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titleAr = trim((string)($_POST['title_ar'] ?? ''));
    $titleEn = trim((string)($_POST['title_en'] ?? ''));
    $subtitleAr = trim((string)($_POST['subtitle_ar'] ?? ''));
    $subtitleEn = trim((string)($_POST['subtitle_en'] ?? ''));
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    if ($titleAr === '' || $titleEn === '') {
        $errors[] = 'العنوان مطلوب';
    }

    $imagePath = (string)($slide['image_path'] ?? '');

    if (isset($_FILES['image']) && is_array($_FILES['image']) && (int)($_FILES['image']['error'] ?? 1) === UPLOAD_ERR_OK) {
        $tmp = (string)$_FILES['image']['tmp_name'];
        $name = (string)$_FILES['image']['name'];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            $newName = 'slide_' . ($id > 0 ? $id : 'new') . '_' . time() . '.' . $ext;
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
            $stmt = db()->prepare('UPDATE slides SET title_ar=:title_ar, title_en=:title_en, subtitle_ar=:subtitle_ar, subtitle_en=:subtitle_en, image_path=:image_path, sort_order=:sort_order, is_active=:is_active WHERE id=:id');
            $stmt->execute([
                ':title_ar' => $titleAr,
                ':title_en' => $titleEn,
                ':subtitle_ar' => $subtitleAr,
                ':subtitle_en' => $subtitleEn,
                ':image_path' => $imagePath,
                ':sort_order' => $sortOrder,
                ':is_active' => $isActive,
                ':id' => $id,
            ]);
        } else {
            if ($imagePath === '') {
                $imagePath = 'unnamed (1).jpg';
            }
            $stmt = db()->prepare('INSERT INTO slides (title_ar, title_en, subtitle_ar, subtitle_en, image_path, sort_order, is_active) VALUES (:title_ar,:title_en,:subtitle_ar,:subtitle_en,:image_path,:sort_order,:is_active)');
            $stmt->execute([
                ':title_ar' => $titleAr,
                ':title_en' => $titleEn,
                ':subtitle_ar' => $subtitleAr,
                ':subtitle_en' => $subtitleEn,
                ':image_path' => $imagePath,
                ':sort_order' => $sortOrder,
                ':is_active' => $isActive,
            ]);
            $id = (int)db()->lastInsertId();
        }

        header('Location: slides.php');
        exit;
    }
}

$defaults = [
    'title_ar' => $slide['title_ar'] ?? '',
    'title_en' => $slide['title_en'] ?? '',
    'subtitle_ar' => $slide['subtitle_ar'] ?? '',
    'subtitle_en' => $slide['subtitle_en'] ?? '',
    'sort_order' => $slide['sort_order'] ?? 0,
    'is_active' => (int)($slide['is_active'] ?? 1),
    'image_path' => $slide['image_path'] ?? '',
];

include __DIR__ . '/partials/header.php';

?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 fw-bold m-0"><?= $id > 0 ? 'تعديل سلايد' : 'إضافة سلايد' ?></h1>
    <a class="btn btn-outline-secondary" href="slides.php">رجوع</a>
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
                <label class="form-label">العنوان (AR)</label>
                <input class="form-control" name="title_ar" value="<?= e((string)$defaults['title_ar']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Title (EN)</label>
                <input class="form-control" name="title_en" value="<?= e((string)$defaults['title_en']) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">الوصف (AR)</label>
                <input class="form-control" name="subtitle_ar" value="<?= e((string)$defaults['subtitle_ar']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Subtitle (EN)</label>
                <input class="form-control" name="subtitle_en" value="<?= e((string)$defaults['subtitle_en']) ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">Sort order</label>
                <input class="form-control" name="sort_order" type="number" value="<?= e((string)$defaults['sort_order']) ?>">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" <?= ((int)$defaults['is_active'] === 1) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">صورة السلايد</label>
                <input class="form-control" type="file" name="image" accept="image/*">
                <?php if ((string)$defaults['image_path'] !== ''): ?>
                    <div class="mt-2">
                        <img src="<?= e(asset_url('../' . (string)$defaults['image_path'])) ?>" alt="slide" style="width:100%; max-width:360px; height:160px; object-fit:cover; border-radius:12px;">
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
