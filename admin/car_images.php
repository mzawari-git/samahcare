<?php

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin', 'editor']);

$carId = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;
$car = car_find($carId);

if (!$car) {
    include __DIR__ . '/partials/header.php';
    ?>
    <div class="alert alert-danger">Car not found</div>
    <a class="btn btn-outline-secondary" href="cars.php">رجوع</a>
    <?php
    include __DIR__ . '/partials/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string)($_POST['action'] ?? '');

    if ($action === 'import_from_folder') {
        $sourceDir = trim((string)($_POST['source_dir'] ?? ''));
        if ($sourceDir === '' && defined('CARS_SOURCE_DIR')) {
            $sourceDir = (string)CARS_SOURCE_DIR;
        }

        $sourceDir = rtrim(str_replace('\\', '/', $sourceDir), '/');

        $imported = 0;
        $failed = 0;
        $failMsg = '';

        if ($sourceDir !== '' && is_dir($sourceDir)) {
            $stmtMax = db()->prepare('SELECT COALESCE(MAX(sort_order),0) AS m FROM car_images WHERE car_id = :id');
            $stmtMax->execute([':id' => $carId]);
            $max = (int)($stmtMax->fetch()['m'] ?? 0);

            $selectedFiles = $_POST['selected_files'] ?? [];
            if (is_array($selectedFiles) && count($selectedFiles) > 0) {
                $files = $selectedFiles;
            } else {
                $files = @scandir($sourceDir) ?: [];
            }
            $i = 0;
            foreach ($files as $f) {
                $f = (string)$f;
                $f = basename($f);
                if ($f === '.' || $f === '..') {
                    continue;
                }
                if (stripos($f, 'logo') !== false) {
                    continue;
                }

                $full = $sourceDir . '/' . $f;
                if (!is_file($full)) {
                    continue;
                }

                if (!is_readable($full)) {
                    $failed++;
                    if ($failMsg === '') {
                        $failMsg = 'لا يمكن قراءة بعض الملفات من المجلد (صلاحيات/مسار).';
                    }
                    continue;
                }

                $ext = strtolower(pathinfo($full, PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                    continue;
                }

                $newName = 'car_' . $carId . '_import_' . time() . '_' . $i . '.' . $ext;
                $dest = UPLOADS_DIR . '/' . $newName;
                if (copy($full, $dest)) {
                    $max++;
                    try {
                        db()->prepare('INSERT INTO car_images (car_id, file_path, sort_order, is_primary) VALUES (:car_id, :path, :sort_order, 0)')
                            ->execute([':car_id' => $carId, ':path' => UPLOADS_URL . '/' . $newName, ':sort_order' => $max]);
                        $imported++;
                    } catch (Throwable $e) {
                        $failed++;
                        if ($failMsg === '') {
                            $failMsg = 'تم نسخ صور ولكن فشل حفظها في قاعدة البيانات.';
                        }
                    }
                } else {
                    $failed++;
                    if ($failMsg === '') {
                        $err = error_get_last();
                        $failMsg = isset($err['message']) ? (string)$err['message'] : 'فشل نسخ بعض الصور إلى uploads.';
                    }
                }

                $i++;
            }

            $stmtPrim = db()->prepare('SELECT COUNT(*) AS c FROM car_images WHERE car_id = :id AND is_primary = 1');
            $stmtPrim->execute([':id' => $carId]);
            $primCount = (int)($stmtPrim->fetch()['c'] ?? 0);
            if ($primCount === 0) {
                $stmt = db()->prepare('SELECT id FROM car_images WHERE car_id = :id ORDER BY sort_order ASC, id ASC LIMIT 1');
                $stmt->execute([':id' => $carId]);
                $first = $stmt->fetch();
                if ($first) {
                    db()->prepare('UPDATE car_images SET is_primary = 1 WHERE id = :id')->execute([':id' => (int)$first['id']]);
                }
            }
        }

        $qs = 'car_id=' . $carId . '&imported=' . $imported . '&failed=' . $failed;
        if ($failMsg !== '') {
            $qs .= '&fail_msg=' . rawurlencode($failMsg);
        }
        header('Location: car_images.php?' . $qs);
        exit;
    }

    if ($action === 'set_primary') {
        $imgId = (int)($_POST['image_id'] ?? 0);
        if ($imgId > 0) {
            db()->prepare('UPDATE car_images SET is_primary = 0 WHERE car_id = :car_id')->execute([':car_id' => $carId]);
            db()->prepare('UPDATE car_images SET is_primary = 1 WHERE id = :id AND car_id = :car_id')->execute([':id' => $imgId, ':car_id' => $carId]);
        }
        header('Location: car_images.php?car_id=' . $carId);
        exit;
    }

    if ($action === 'delete') {
        $imgId = (int)($_POST['image_id'] ?? 0);
        if ($imgId > 0) {
            $stmt = db()->prepare('SELECT file_path FROM car_images WHERE id = :id AND car_id = :car_id');
            $stmt->execute([':id' => $imgId, ':car_id' => $carId]);
            $row = $stmt->fetch();
            if ($row) {
                $path = (string)$row['file_path'];
                if (strpos($path, UPLOADS_URL . '/') === 0) {
                    $local = UPLOADS_DIR . '/' . basename($path);
                    if (is_file($local)) {
                        @unlink($local);
                    }
                }
                db()->prepare('DELETE FROM car_images WHERE id = :id AND car_id = :car_id')->execute([':id' => $imgId, ':car_id' => $carId]);
            }
        }
        header('Location: car_images.php?car_id=' . $carId);
        exit;
    }

    if ($action === 'upload_images') {
        $stmtMax = db()->prepare('SELECT COALESCE(MAX(sort_order),0) AS m FROM car_images WHERE car_id = :id');
        $stmtMax->execute([':id' => $carId]);
        $max = (int)($stmtMax->fetch()['m'] ?? 0);

        if (isset($_FILES['images']) && is_array($_FILES['images'])) {
            $names = $_FILES['images']['name'] ?? [];
            $tmps = $_FILES['images']['tmp_name'] ?? [];
            $errs = $_FILES['images']['error'] ?? [];

            $count = is_array($names) ? count($names) : 0;
            for ($i = 0; $i < $count; $i++) {
                if ((int)($errs[$i] ?? 1) !== UPLOAD_ERR_OK) {
                    continue;
                }
                $orig = (string)($names[$i] ?? '');
                $tmp = (string)($tmps[$i] ?? '');
                if ($tmp === '') {
                    continue;
                }
                $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
                    continue;
                }

                $newName = 'car_' . $carId . '_img_' . time() . '_' . $i . '.' . $ext;
                $dest = UPLOADS_DIR . '/' . $newName;

                if (move_uploaded_file($tmp, $dest)) {
                    $max++;
                    db()->prepare('INSERT INTO car_images (car_id, file_path, sort_order, is_primary) VALUES (:car_id, :path, :sort_order, 0)')
                        ->execute([':car_id' => $carId, ':path' => UPLOADS_URL . '/' . $newName, ':sort_order' => $max]);
                }
            }

            $stmtPrim = db()->prepare('SELECT COUNT(*) AS c FROM car_images WHERE car_id = :id AND is_primary = 1');
            $stmtPrim->execute([':id' => $carId]);
            $primCount = (int)($stmtPrim->fetch()['c'] ?? 0);
            if ($primCount === 0) {
                $stmt = db()->prepare('SELECT id FROM car_images WHERE car_id = :id ORDER BY sort_order ASC, id ASC LIMIT 1');
                $stmt->execute([':id' => $carId]);
                $first = $stmt->fetch();
                if ($first) {
                    db()->prepare('UPDATE car_images SET is_primary = 1 WHERE id = :id')->execute([':id' => (int)$first['id']]);
                }
            }
        }

        header('Location: car_images.php?car_id=' . $carId . '&uploaded=1');
        exit;
    }

    if ($action === 'upload_videos') {
        $stmtMax = db()->prepare('SELECT COALESCE(MAX(sort_order),0) AS m FROM car_images WHERE car_id = :id');
        $stmtMax->execute([':id' => $carId]);
        $max = (int)($stmtMax->fetch()['m'] ?? 0);

        if (isset($_FILES['videos']) && is_array($_FILES['videos'])) {
            $names = $_FILES['videos']['name'] ?? [];
            $tmps = $_FILES['videos']['tmp_name'] ?? [];
            $errs = $_FILES['videos']['error'] ?? [];

            $count = is_array($names) ? count($names) : 0;
            for ($i = 0; $i < $count; $i++) {
                if ((int)($errs[$i] ?? 1) !== UPLOAD_ERR_OK) {
                    continue;
                }
                $orig = (string)($names[$i] ?? '');
                $tmp = (string)($tmps[$i] ?? '');
                if ($tmp === '') {
                    continue;
                }
                $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
                if (!in_array($ext, ['mp4', 'webm', 'avi', 'mov', 'mkv'], true)) {
                    continue;
                }

                $newName = 'car_' . $carId . '_vid_' . time() . '_' . $i . '.' . $ext;
                $dest = UPLOADS_DIR . '/' . $newName;

                if (move_uploaded_file($tmp, $dest)) {
                    $max++;
                    db()->prepare('INSERT INTO car_images (car_id, file_path, sort_order, is_primary, type) VALUES (:car_id, :path, :sort_order, 0, :type)')
                        ->execute([':car_id' => $carId, ':path' => UPLOADS_URL . '/' . $newName, ':sort_order' => $max, ':type' => 'video']);
                }
            }
        }

        header('Location: car_images.php?car_id=' . $carId . '&uploaded=1');
        exit;
    }
}

$sourceDirUi = trim((string)($_GET['source_dir'] ?? ''));
if ($sourceDirUi === '' && defined('CARS_SOURCE_DIR')) {
    $sourceDirUi = (string)CARS_SOURCE_DIR;
}
$sourceDirUi = rtrim(str_replace('\\', '/', $sourceDirUi), '/');

$folderFiles = [];
if ($sourceDirUi !== '' && is_dir($sourceDirUi)) {
    $files = @scandir($sourceDirUi) ?: [];
    foreach ($files as $f) {
        $f = (string)$f;
        $f = basename($f);
        if ($f === '.' || $f === '..') {
            continue;
        }
        if (stripos($f, 'logo') !== false) {
            continue;
        }
        $full = $sourceDirUi . '/' . $f;
        if (!is_file($full)) {
            continue;
        }
        $ext = strtolower(pathinfo($full, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            continue;
        }
        $folderFiles[] = $f;
    }
    sort($folderFiles);
}

$images = car_images($carId);
$name = car_name($car);
$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

include __DIR__ . '/partials/header-modern.php';

?>

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h1 class="h4 fw-bold m-0">
            <i class="fas fa-images text-primary me-2"></i>
            <?= $lang === 'ar' ? 'صور وفيديوهات السيارة' : 'Car Images & Videos' ?>
        </h1>
        <div class="text-secondary small"><?= e($name) ?></div>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-secondary" href="cars.php">
            <i class="fas fa-arrow-right me-1"></i> <?= $lang === 'ar' ? 'رجوع للقائمة' : 'Back to List' ?>
        </a>
        <a class="btn btn-primary" href="car_edit.php?id=<?= (int)$carId ?>">
            <i class="fas fa-edit me-1"></i> <?= $lang === 'ar' ? 'تعديل السيارة' : 'Edit Car' ?>
        </a>
    </div>
</div>

<?php if (isset($_GET['uploaded'])): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle me-1"></i>
        <?= $lang === 'ar' ? 'تم رفع الملفات بنجاح!' : 'Files uploaded successfully!' ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['imported']) || isset($_GET['failed'])): ?>
    <div class="alert alert-info">
        <i class="fas fa-upload me-1"></i>
        <?= $lang === 'ar' ? 'تم الاستيراد:' : 'Imported:' ?> <?= (int)($_GET['imported'] ?? 0) ?> 
        | <?= $lang === 'ar' ? 'فشل:' : 'Failed:' ?> <?= (int)($_GET['failed'] ?? 0) ?>
        <?php if (!empty($_GET['fail_msg'])): ?>
            <div class="small mt-1"><?= e((string)$_GET['fail_msg']) ?></div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- Upload Section -->
    <div class="col-lg-4">
        <div class="card section-card">
            <div class="card-header">
                <h5><i class="fas fa-cloud-upload-alt text-primary me-2"></i> <?= $lang === 'ar' ? 'رفع ملفات' : 'Upload Files' ?></h5>
            </div>
            <div class="card-body">
                <!-- Images Upload -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-image text-success me-2"></i>
                        <?= $lang === 'ar' ? 'الصور' : 'Images' ?>
                    </h6>
                    <form method="post" enctype="multipart/form-data" id="imagesForm">
                        <input type="hidden" name="action" value="upload_images">
                        <div class="upload-zone" id="imageDropZone">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <p class="mb-2"><?= $lang === 'ar' ? 'اسحب الصور هنا' : 'Drag images here' ?></p>
                            <p class="text-secondary small mb-2"><?= $lang === 'ar' ? 'أو' : 'or' ?></p>
                            <label class="btn btn-outline-primary btn-sm mb-2">
                                <?= $lang === 'ar' ? 'اختر ملفات' : 'Choose Files' ?>
                                <input type="file" name="images[]" accept="image/*" multiple hidden onchange="this.form.submit()">
                            </label>
                            <p class="text-secondary small">JPG, PNG, WEBP, GIF • <?= $lang === 'ar' ? 'بدون حد أقصى' : 'Unlimited files' ?></p>
                        </div>
                    </form>
                </div>

                <hr>

                <!-- Videos Upload -->
                <div>
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-video text-danger me-2"></i>
                        <?= $lang === 'ar' ? 'الفيديوهات' : 'Videos' ?>
                    </h6>
                    <form method="post" enctype="multipart/form-data" id="videosForm">
                        <input type="hidden" name="action" value="upload_videos">
                        <div class="upload-zone" id="videoDropZone">
                            <i class="fas fa-film upload-icon"></i>
                            <p class="mb-2"><?= $lang === 'ar' ? 'اسحب الفيديوهات هنا' : 'Drag videos here' ?></p>
                            <p class="text-secondary small mb-2"><?= $lang === 'ar' ? 'أو' : 'or' ?></p>
                            <label class="btn btn-outline-danger btn-sm mb-2">
                                <?= $lang === 'ar' ? 'اختر ملفات' : 'Choose Files' ?>
                                <input type="file" name="videos[]" accept="video/*" multiple hidden onchange="this.form.submit()">
                            </label>
                            <p class="text-secondary small">MP4, WEBM, AVI, MOV • <?= $lang === 'ar' ? 'بدون حد أقصى' : 'Unlimited files' ?></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import from Folder -->
        <div class="card section-card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-folder-open text-warning me-2"></i> <?= $lang === 'ar' ? 'استيراد من مجلد' : 'Import from Folder' ?></h5>
            </div>
            <div class="card-body">
                <form method="get" class="mb-3">
                    <input type="hidden" name="car_id" value="<?= (int)$carId ?>">
                    <label class="form-label"><?= $lang === 'ar' ? 'مسار المجلد' : 'Folder Path' ?></label>
                    <input class="form-control" name="source_dir" value="<?= e($sourceDirUi) ?>" placeholder="C:/Users/.../CARS">
                    <div class="form-text small"><?= $lang === 'ar' ? 'أدخل مسار المجلد ثم اضغط عرض الملفات' : 'Enter folder path and click Show Files' ?></div>
                    <button class="btn btn-outline-warning mt-2 w-100" type="submit">
                        <i class="fas fa-folder-open me-1"></i> <?= $lang === 'ar' ? 'عرض الملفات' : 'Show Files' ?>
                    </button>
                </form>

                <?php if ($sourceDirUi !== '' && is_dir($sourceDirUi)): ?>
                    <form method="post">
                        <input type="hidden" name="action" value="import_from_folder">
                        <input type="hidden" name="source_dir" value="<?= e($sourceDirUi) ?>">
                        <?php if (count($folderFiles) > 0): ?>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small text-secondary"><?= $lang === 'ar' ? 'الملفات:' : 'Files:' ?> <?= count($folderFiles) ?></span>
                                <button class="btn btn-success btn-sm" type="submit">
                                    <i class="fas fa-download me-1"></i> <?= $lang === 'ar' ? 'استيراد الكل' : 'Import All' ?>
                                </button>
                            </div>
                            <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="selectAllFiles">
                                    <label class="form-check-label" for="selectAllFiles"><?= $lang === 'ar' ? 'تحديد الكل' : 'Select All' ?></label>
                                </div>
                                <?php foreach ($folderFiles as $f): ?>
                                    <div class="form-check">
                                        <input class="form-check-input file-check" type="checkbox" name="selected_files[]" value="<?= e($f) ?>" id="f_<?= e(md5($f)) ?>">
                                        <label class="form-check-label small" for="f_<?= e(md5($f)) ?>"><?= e($f) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0 small"><?= $lang === 'ar' ? 'لا توجد ملفات صور صالحة' : 'No valid image files found' ?></div>
                        <?php endif; ?>
                    </form>
                <?php else: ?>
                    <?php if ($sourceDirUi !== ''): ?>
                        <div class="alert alert-warning mb-0 small"><?= $lang === 'ar' ? 'المجلد غير موجود' : 'Folder not found' ?></div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <div class="col-lg-8">
        <div class="card section-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-photo-video text-primary me-2"></i>
                    <?= $lang === 'ar' ? 'المعرض' : 'Gallery' ?>
                    <span class="badge bg-primary ms-2"><?= count($images) ?></span>
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if (count($images) > 0): ?>
                    <div class="gallery-grid">
                        <?php foreach ($images as $img):
                            $isVideo = (isset($img['type']) && $img['type'] === 'video') || preg_match('/\.(mp4|webm|avi|mov|mkv)$/i', (string)$img['file_path']);
                            $isPrimary = (int)($img['is_primary'] ?? 0) === 1;
                        ?>
                            <div class="gallery-item <?= $isPrimary ? 'primary' : '' ?>">
                                <?php if ($isVideo): ?>
                                    <video controls class="gallery-video">
                                        <source src="<?= e(asset_url('../' . ltrim((string)$img['file_path'], '/'))) ?>">
                                    </video>
                                    <div class="gallery-overlay">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                <?php else: ?>
                                    <img src="<?= e(asset_url('../' . ltrim((string)$img['file_path'], '/'))) ?>" alt="image" class="gallery-img">
                                    <?php if ($isPrimary): ?>
                                        <span class="badge bg-success gallery-badge"><?= $lang === 'ar' ? 'رئيسية' : 'Primary' ?></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="gallery-actions">
                                    <?php if (!$isPrimary): ?>
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="image_id" value="<?= (int)$img['id'] ?>">
                                            <button class="btn btn-success btn-sm" type="submit" name="action" value="set_primary" title="<?= $lang === 'ar' ? 'تعيين رئيسية' : 'Set Primary' ?>">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <form method="post" class="d-inline" onsubmit="return confirm('<?= $lang === 'ar' ? 'حذف الملف؟' : 'Delete file?' ?>')">
                                        <input type="hidden" name="image_id" value="<?= (int)$img['id'] ?>">
                                        <button class="btn btn-danger btn-sm" type="submit" name="action" value="delete" title="<?= $lang === 'ar' ? 'حذف' : 'Delete' ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-images" style="font-size: 64px; color: #cbd5e1;"></i>
                        <p class="text-secondary mt-3"><?= $lang === 'ar' ? 'لا توجد صور أو فيديوهات' : 'No images or videos yet' ?></p>
                        <p class="text-secondary small"><?= $lang === 'ar' ? 'قم برفع الصور والفيديوهات من القائمة الجانبية' : 'Upload images and videos from the sidebar' ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.upload-zone {
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    padding: 30px 20px;
    text-align: center;
    background: #f8fafc;
    transition: var(--transition);
}

.upload-zone:hover {
    border-color: var(--primary-light);
    background: rgba(37, 99, 235, 0.05);
}

.upload-icon {
    font-size: 36px;
    color: #cbd5e1;
    margin-bottom: 10px;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 16px;
    padding: 20px;
}

.gallery-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 4/3;
    background: #f1f5f9;
}

.gallery-item.primary {
    border: 3px solid var(--success);
}

.gallery-img, .gallery-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 40px;
    opacity: 0;
    transition: var(--transition);
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-badge {
    position: absolute;
    top: 8px;
    right: 8px;
}

.gallery-actions {
    position: absolute;
    bottom: 8px;
    right: 8px;
    display: flex;
    gap: 6px;
    opacity: 0;
    transition: var(--transition);
}

.gallery-item:hover .gallery-actions {
    opacity: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all files checkbox
    var all = document.getElementById('selectAllFiles');
    if (all) {
        all.addEventListener('change', function() {
            var checks = document.querySelectorAll('.file-check');
            for (var i = 0; i < checks.length; i++) {
                checks[i].checked = all.checked;
            }
        });
    }

    // Drag and drop for images
    var imageZone = document.getElementById('imageDropZone');
    if (imageZone) {
        imageZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = 'var(--primary)';
        });
        imageZone.addEventListener('dragleave', function() {
            this.style.borderColor = '#e2e8f0';
        });
        imageZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#e2e8f0';
        });
    }

    // Drag and drop for videos
    var videoZone = document.getElementById('videoDropZone');
    if (videoZone) {
        videoZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = 'var(--danger)';
        });
        videoZone.addEventListener('dragleave', function() {
            this.style.borderColor = '#e2e8f0';
        });
        videoZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#e2e8f0';
        });
    }
});
</script>

<?php include __DIR__ . '/partials/footer-modern.php'; ?>
