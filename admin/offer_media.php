<?php

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin', 'editor']);

$offerId = isset($_GET['offer_id']) ? (int)$_GET['offer_id'] : 0;
$offer = null;

if ($offerId > 0) {
    try {
        $stmt = db()->prepare('SELECT o.*, c.name_ar, c.name_en FROM offers o JOIN cars c ON c.id = o.car_id WHERE o.id = :id');
        $stmt->execute([':id' => $offerId]);
        $offer = $stmt->fetch();
    } catch (Throwable $e) {
        $offer = null;
    }
}

if (!$offer) {
    include __DIR__ . '/partials/header.php';
    ?>
    <div class="alert alert-danger">Offer not found</div>
    <a class="btn btn-outline-secondary" href="offers.php">رجوع</a>
    <?php
    include __DIR__ . '/partials/footer.php';
    exit;
}

$name = current_lang() === 'ar' ? (string)($offer['name_ar'] ?? '') : (string)($offer['name_en'] ?? '');

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string)($_POST['action'] ?? '');

    if ($action === 'upload_images') {
        $replaceImages = isset($_POST['replace_images']);

        if ($replaceImages) {
            $toDelete = [];
            try {
                $stmt = db()->prepare('SELECT id, file_path FROM offer_media WHERE offer_id = :id AND type = "image"');
                $stmt->execute([':id' => $offerId]);
                $rows = $stmt->fetchAll();
                foreach ($rows as $r) {
                    $p = (string)($r['file_path'] ?? '');
                    if ($p !== '' && strpos($p, UPLOADS_URL . '/') === 0) {
                        $toDelete[] = UPLOADS_DIR . '/' . basename($p);
                    }
                }
            } catch (Throwable $e) {
            }

            try {
                db()->prepare('DELETE FROM offer_media WHERE offer_id = :id AND type = "image"')->execute([':id' => $offerId]);
            } catch (Throwable $e) {
            }

            $toDelete = array_values(array_unique($toDelete));
            foreach ($toDelete as $f) {
                if (is_file($f)) {
                    @unlink($f);
                }
            }
        }

        try {
            $stmtMax = db()->prepare('SELECT COALESCE(MAX(sort_order),0) AS m FROM offer_media WHERE offer_id = :id');
            $stmtMax->execute([':id' => $offerId]);
            $max = (int)($stmtMax->fetch()['m'] ?? 0);
        } catch (Throwable $e) {
            $max = 0;
        }

        if (isset($_FILES['images']) && is_array($_FILES['images'])) {
            $names = $_FILES['images']['name'] ?? [];
            $tmps = $_FILES['images']['tmp_name'] ?? [];
            $errs = $_FILES['images']['error'] ?? [];

            $count = is_array($names) ? count($names) : 0;
            $firstNewId = 0;
            for ($i = 0; $i < $count; $i++) {
                if ((int)($errs[$i] ?? 1) !== UPLOAD_ERR_OK) {
                    continue;
                }
                $orig = (string)($names[$i] ?? '');
                $tmp = (string)($tmps[$i] ?? '');
                $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                    continue;
                }

                $newName = 'offer_' . $offerId . '_' . time() . '_' . $i . '.' . $ext;
                $dest = UPLOADS_DIR . '/' . $newName;
                if (move_uploaded_file($tmp, $dest)) {
                    $max++;
                    try {
                        db()->prepare('INSERT INTO offer_media (offer_id, type, file_path, sort_order, is_primary) VALUES (:offer_id, \"image\", :path, :sort_order, 0)')
                            ->execute([':offer_id' => $offerId, ':path' => UPLOADS_URL . '/' . $newName, ':sort_order' => $max]);
                        if ($firstNewId === 0) {
                            $firstNewId = (int)db()->lastInsertId();
                        }
                    } catch (Throwable $e) {
                    }
                }
            }

            if ($replaceImages && $firstNewId > 0) {
                try {
                    db()->prepare('UPDATE offer_media SET is_primary = 0 WHERE offer_id = :offer_id AND type = "image"')->execute([':offer_id' => $offerId]);
                    db()->prepare('UPDATE offer_media SET is_primary = 1 WHERE id = :id AND offer_id = :offer_id')->execute([':id' => $firstNewId, ':offer_id' => $offerId]);
                } catch (Throwable $e) {
                }
            } else {
                try {
                    $stmtPrim = db()->prepare('SELECT COUNT(*) AS c FROM offer_media WHERE offer_id = :id AND type = \"image\" AND is_primary = 1');
                    $stmtPrim->execute([':id' => $offerId]);
                    $primCount = (int)($stmtPrim->fetch()['c'] ?? 0);
                    if ($primCount === 0) {
                        $stmt = db()->prepare('SELECT id FROM offer_media WHERE offer_id = :id AND type = \"image\" ORDER BY sort_order ASC, id ASC LIMIT 1');
                        $stmt->execute([':id' => $offerId]);
                        $first = $stmt->fetch();
                        if ($first) {
                            db()->prepare('UPDATE offer_media SET is_primary = 1 WHERE id = :id AND offer_id = :offer_id')->execute([':id' => (int)$first['id'], ':offer_id' => $offerId]);
                        }
                    }
                } catch (Throwable $e) {
                }
            }
        }

        header('Location: offer_media.php?offer_id=' . $offerId);
        exit;
    }

    if ($action === 'upload_video') {
        if (isset($_FILES['video']) && is_array($_FILES['video']) && (int)($_FILES['video']['error'] ?? 1) === UPLOAD_ERR_OK) {
            $tmp = (string)($_FILES['video']['tmp_name'] ?? '');
            $orig = (string)($_FILES['video']['name'] ?? '');
            $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
            if (!in_array($ext, ['mp4', 'webm', 'ogg'], true)) {
                $errors[] = 'امتداد الفيديو غير مدعوم (mp4/webm/ogg)';
            } else {
                $newName = 'offer_video_' . $offerId . '_' . time() . '.' . $ext;
                $dest = UPLOADS_DIR . '/' . $newName;
                if (move_uploaded_file($tmp, $dest)) {
                    try {
                        $stmtMax = db()->prepare('SELECT COALESCE(MAX(sort_order),0) AS m FROM offer_media WHERE offer_id = :id');
                        $stmtMax->execute([':id' => $offerId]);
                        $max = (int)($stmtMax->fetch()['m'] ?? 0);
                    } catch (Throwable $e) {
                        $max = 0;
                    }

                    try {
                        db()->prepare('INSERT INTO offer_media (offer_id, type, file_path, sort_order, is_primary) VALUES (:offer_id, \"video\", :path, :sort_order, 0)')
                            ->execute([':offer_id' => $offerId, ':path' => UPLOADS_URL . '/' . $newName, ':sort_order' => $max + 1]);
                        $success = true;
                    } catch (Throwable $e) {
                        $errors[] = 'فشل حفظ الفيديو في قاعدة البيانات.';
                    }
                } else {
                    $errors[] = 'فشل رفع الفيديو.';
                }
            }
        }

        if (!$errors) {
            header('Location: offer_media.php?offer_id=' . $offerId);
            exit;
        }
    }

    if ($action === 'add_video_url') {
        $url = trim((string)($_POST['video_url'] ?? ''));
        if ($url === '') {
            $errors[] = 'رابط الفيديو مطلوب';
        } else {
            if (!preg_match('#^https?://#i', $url)) {
                $url = 'https://' . ltrim($url, '/');
            }
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $errors[] = 'رابط الفيديو غير صحيح';
            }
        }

        if (!$errors) {
            try {
                $stmtMax = db()->prepare('SELECT COALESCE(MAX(sort_order),0) AS m FROM offer_media WHERE offer_id = :id');
                $stmtMax->execute([':id' => $offerId]);
                $max = (int)($stmtMax->fetch()['m'] ?? 0);
            } catch (Throwable $e) {
                $max = 0;
            }

            try {
                db()->prepare('INSERT INTO offer_media (offer_id, type, video_url, sort_order, is_primary) VALUES (:offer_id, \"video\", :url, :sort_order, 0)')
                    ->execute([':offer_id' => $offerId, ':url' => $url, ':sort_order' => $max + 1]);
            } catch (Throwable $e) {
            }

            header('Location: offer_media.php?offer_id=' . $offerId);
            exit;
        }
    }

    if ($action === 'set_primary') {
        $mediaId = (int)($_POST['media_id'] ?? 0);
        if ($mediaId > 0) {
            try {
                db()->prepare('UPDATE offer_media SET is_primary = 0 WHERE offer_id = :offer_id AND type = \"image\"')->execute([':offer_id' => $offerId]);
                db()->prepare('UPDATE offer_media SET is_primary = 1 WHERE id = :id AND offer_id = :offer_id')->execute([':id' => $mediaId, ':offer_id' => $offerId]);
            } catch (Throwable $e) {
            }
        }
        header('Location: offer_media.php?offer_id=' . $offerId);
        exit;
    }

    if ($action === 'delete') {
        $mediaId = (int)($_POST['media_id'] ?? 0);
        if ($mediaId > 0) {
            try {
                $stmt = db()->prepare('SELECT file_path FROM offer_media WHERE id = :id AND offer_id = :offer_id');
                $stmt->execute([':id' => $mediaId, ':offer_id' => $offerId]);
                $row = $stmt->fetch();
                if ($row) {
                    $path = (string)($row['file_path'] ?? '');
                    if ($path !== '' && strpos($path, UPLOADS_URL . '/') === 0) {
                        $local = UPLOADS_DIR . '/' . basename($path);
                        if (is_file($local)) {
                            @unlink($local);
                        }
                    }
                    db()->prepare('DELETE FROM offer_media WHERE id = :id AND offer_id = :offer_id')->execute([':id' => $mediaId, ':offer_id' => $offerId]);
                }
            } catch (Throwable $e) {
            }
        }
        header('Location: offer_media.php?offer_id=' . $offerId);
        exit;
    }
}

$images = [];
$videos = [];
try {
    $stmt = db()->prepare('SELECT id, type, file_path, video_url, sort_order, is_primary FROM offer_media WHERE offer_id = :id ORDER BY is_primary DESC, sort_order ASC, id ASC');
    $stmt->execute([':id' => $offerId]);
    $items = $stmt->fetchAll();
    foreach ($items as $it) {
        if (($it['type'] ?? '') === 'video') {
            $videos[] = $it;
        } else {
            $images[] = $it;
        }
    }
} catch (Throwable $e) {
    $images = [];
    $videos = [];
}

include __DIR__ . '/partials/header.php';

?>

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <div>
        <h1 class="h4 fw-bold m-0">وسائط العرض</h1>
        <div class="text-secondary small">#<?= (int)$offerId ?> · <?= e($name) ?></div>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-secondary" href="offers.php">رجوع</a>
        <a class="btn btn-outline-primary" href="offer_edit.php?id=<?= (int)$offerId ?>">تعديل العرض</a>
        <a class="btn btn-primary" href="../offer.php?id=<?= (int)$offerId ?>" target="_blank" rel="noopener">عرض الصفحة</a>
    </div>
</div>

<?php if ($success): ?>
    <div class="alert alert-success">تم حفظ التغييرات.</div>
<?php endif; ?>

<?php if ($errors): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $err): ?>
            <div><?= e((string)$err) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="fw-bold mb-2">صور العرض</div>
        <form method="post" enctype="multipart/form-data" class="row g-2 align-items-end">
            <input type="hidden" name="action" value="upload_images">
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="replace_images" id="replace_images">
                    <label class="form-check-label" for="replace_images">استبدال صور العرض الحالية (حذف القديمة)</label>
                </div>
            </div>
            <div class="col-md-9">
                <label class="form-label">رفع صور (يمكن اختيار أكثر من صورة)</label>
                <input class="form-control" type="file" name="images[]" accept="image/*" multiple>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" type="submit">رفع</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <?php foreach ($images as $img): ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <img src="<?= e(asset_url('../' . ltrim((string)($img['file_path'] ?? ''), '/'))) ?>" alt="img" style="width:100%; height:160px; object-fit:cover;">
                <div class="card-body p-2 d-flex flex-column gap-2">
                    <?php if ((int)($img['is_primary'] ?? 0) === 1): ?>
                        <span class="badge bg-success">Primary</span>
                    <?php endif; ?>

                    <form method="post" class="d-grid gap-2">
                        <input type="hidden" name="media_id" value="<?= (int)($img['id'] ?? 0) ?>">
                        <button class="btn btn-outline-primary btn-sm" type="submit" name="action" value="set_primary">تعيين رئيسية</button>
                        <button class="btn btn-outline-danger btn-sm" type="submit" name="action" value="delete" onclick="return confirm('حذف الوسائط؟');">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="fw-bold mb-2">فيديو</div>

        <form method="post" class="row g-2 align-items-end mb-3">
            <input type="hidden" name="action" value="add_video_url">
            <div class="col-md-9" dir="ltr">
                <label class="form-label">رابط فيديو (YouTube/أي رابط مباشر)</label>
                <input class="form-control" name="video_url" placeholder="https://www.youtube.com/watch?v=...">
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-primary w-100" type="submit">إضافة رابط</button>
            </div>
        </form>

        <form method="post" enctype="multipart/form-data" class="row g-2 align-items-end">
            <input type="hidden" name="action" value="upload_video">
            <div class="col-md-9">
                <label class="form-label">رفع فيديو (mp4/webm/ogg)</label>
                <input class="form-control" type="file" name="video" accept="video/*">
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-secondary w-100" type="submit">رفع فيديو</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3">
    <?php foreach ($videos as $v):
        $file = trim((string)($v['file_path'] ?? ''));
        $url = trim((string)($v['video_url'] ?? ''));
    ?>
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <div class="fw-bold">Video</div>
                        <form method="post" class="m-0">
                            <input type="hidden" name="media_id" value="<?= (int)($v['id'] ?? 0) ?>">
                            <button class="btn btn-outline-danger btn-sm" type="submit" name="action" value="delete" onclick="return confirm('حذف الوسائط؟');">حذف</button>
                        </form>
                    </div>
                    <div class="mt-2" dir="ltr">
                        <?php if ($file !== ''): ?>
                            <video controls style="width:100%; border-radius:12px;">
                                <source src="<?= e(asset_url('../' . ltrim($file, '/'))) ?>">
                            </video>
                        <?php elseif ($url !== ''): ?>
                            <a href="<?= e($url) ?>" target="_blank" rel="noopener"><?= e($url) ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/partials/footer.php';
