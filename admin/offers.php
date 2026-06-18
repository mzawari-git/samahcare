<?php

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin', 'editor']);

if (isset($_GET['debug']) && (string)admin_role() === 'superadmin') {
    @ini_set('display_errors', '1');
    @ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string)($_POST['action'] ?? '');
    $offerId = (int)($_POST['offer_id'] ?? 0);

    if ($action === 'delete' && $offerId > 0) {
        try {
            $files = [];
            $slideId = 0;

            try {
                $stmt = db()->prepare('SELECT image_path, slide_id FROM offers WHERE id = :id');
                $stmt->execute([':id' => $offerId]);
                $row = $stmt->fetch();
                if ($row) {
                    $p = (string)($row['image_path'] ?? '');
                    if ($p !== '' && strpos($p, UPLOADS_URL . '/') === 0) {
                        $files[] = UPLOADS_DIR . '/' . basename($p);
                    }
                    $slideId = (int)($row['slide_id'] ?? 0);
                }
            } catch (Throwable $e) {
            }

            try {
                $stmt = db()->prepare('SELECT file_path FROM offer_media WHERE offer_id = :id');
                $stmt->execute([':id' => $offerId]);
                $rows = $stmt->fetchAll();
                foreach ($rows as $r) {
                    $p = (string)($r['file_path'] ?? '');
                    if ($p !== '' && strpos($p, UPLOADS_URL . '/') === 0) {
                        $files[] = UPLOADS_DIR . '/' . basename($p);
                    }
                }
            } catch (Throwable $e) {
            }

            if ($slideId > 0) {
                try {
                    $stmt = db()->prepare('SELECT image_path FROM slides WHERE id = :id');
                    $stmt->execute([':id' => $slideId]);
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
                    db()->prepare('DELETE FROM slides WHERE id = :id')->execute([':id' => $slideId]);
                } catch (Throwable $e) {
                }
            }

            try {
                db()->prepare('DELETE FROM offers WHERE id = :id')->execute([':id' => $offerId]);
            } catch (Throwable $e) {
            }

            $files = array_values(array_unique($files));
            foreach ($files as $f) {
                if (is_file($f)) {
                    @unlink($f);
                }
            }

            header('Location: offers.php?deleted=1');
            exit;
        } catch (Throwable $e) {
            header('Location: offers.php?deleted=0');
            exit;
        }
    }
}

$sql = "SELECT o.*, c.name_ar, c.name_en
        FROM offers o
        JOIN cars c ON c.id = o.car_id
        ORDER BY o.sort_order ASC, o.id DESC";

try {
    $offers = db()->query($sql)->fetchAll();
} catch (Throwable $e) {
    $offers = [];
}

include __DIR__ . '/partials/header.php';

?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 fw-bold m-0"><?= e(t('manage_offers')) ?></h1>
    <a class="btn btn-primary" href="offer_edit.php">+ إضافة عرض</a>
</div>

<?php if (isset($_GET['deleted'])): ?>
    <?php if ($_GET['deleted'] === '1'): ?>
        <div class="alert alert-success">تم حذف العرض.</div>
    <?php else: ?>
        <div class="alert alert-danger">تعذر حذف العرض.</div>
    <?php endif; ?>
<?php endif; ?>

<?php if (!$offers): ?>
    <div class="alert alert-info">لا توجد عروض بعد. يمكنك إضافة عرض جديد.</div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Car</th>
                    <th>Title (AR)</th>
                    <th>Title (EN)</th>
                    <th>Daily</th>
                    <th>Days</th>
                    <th>Expires</th>
                    <th>Slide</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($offers as $o):
                    $carName = current_lang() === 'ar' ? (string)($o['name_ar'] ?? '') : (string)($o['name_en'] ?? '');
                ?>
                    <tr>
                        <td><?= (int)$o['id'] ?></td>
                        <td><?= e($carName) ?></td>
                        <td><?= e((string)($o['title_ar'] ?? '')) ?></td>
                        <td><?= e((string)($o['title_en'] ?? '')) ?></td>
                        <td><?= e((string)($o['daily_price'] ?? '0')) ?></td>
                        <td><?= (int)($o['days'] ?? 1) ?></td>
                        <td><?= e((string)($o['expires_at'] ?? '')) ?></td>
                        <td><?= ((int)($o['promo_slide'] ?? 0) === 1) ? 'Yes' : 'No' ?></td>
                        <td><?= ((int)($o['is_active'] ?? 0) === 1) ? 'Yes' : 'No' ?></td>
                        <td class="text-end">
                            <a class="btn btn-outline-secondary btn-sm" href="offer_media.php?offer_id=<?= (int)$o['id'] ?>">وسائط</a>
                            <a class="btn btn-outline-primary btn-sm" href="offer_edit.php?id=<?= (int)$o['id'] ?>">تعديل</a>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="offer_id" value="<?= (int)$o['id'] ?>">
                                <button class="btn btn-outline-danger btn-sm" type="submit" onclick="return confirm('حذف العرض؟');">حذف</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
