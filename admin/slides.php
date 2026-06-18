<?php

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin', 'editor']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string)($_POST['action'] ?? '');
    $slideId = (int)($_POST['slide_id'] ?? 0);

    if ($action === 'delete' && $slideId > 0) {
        try {
            $file = '';
            try {
                $stmt = db()->prepare('SELECT image_path FROM slides WHERE id = :id');
                $stmt->execute([':id' => $slideId]);
                $row = $stmt->fetch();
                if ($row) {
                    $p = (string)($row['image_path'] ?? '');
                    if ($p !== '' && strpos($p, UPLOADS_URL . '/') === 0) {
                        $file = UPLOADS_DIR . '/' . basename($p);
                    }
                }
            } catch (Throwable $e) {
            }

            db()->prepare('DELETE FROM slides WHERE id = :id')->execute([':id' => $slideId]);

            if ($file !== '' && is_file($file)) {
                @unlink($file);
            }

            header('Location: slides.php?deleted=1');
            exit;
        } catch (Throwable $e) {
            header('Location: slides.php?deleted=0');
            exit;
        }
    }
}

$slides = db()->query('SELECT id, title_ar, title_en, image_path, sort_order, is_active FROM slides ORDER BY sort_order ASC, id DESC')->fetchAll();

include __DIR__ . '/partials/header.php';

?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 fw-bold m-0"><?= e(t('manage_slides')) ?></h1>
    <a class="btn btn-primary" href="slide_edit.php">+ إضافة سلايد</a>
</div>

<?php if (isset($_GET['deleted'])): ?>
    <?php if ($_GET['deleted'] === '1'): ?>
        <div class="alert alert-success">تم حذف السلايد.</div>
    <?php else: ?>
        <div class="alert alert-danger">تعذر حذف السلايد.</div>
    <?php endif; ?>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>AR</th>
                    <th>EN</th>
                    <th>Image</th>
                    <th>Order</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($slides as $s): ?>
                    <tr>
                        <td><?= (int)$s['id'] ?></td>
                        <td><?= e((string)$s['title_ar']) ?></td>
                        <td><?= e((string)$s['title_en']) ?></td>
                        <td>
                            <?php if ((string)$s['image_path'] !== ''): ?>
                                <img src="<?= e(asset_url('../' . (string)$s['image_path'])) ?>" alt="slide" style="width:110px; height:50px; object-fit:cover; border-radius:8px;">
                            <?php endif; ?>
                        </td>
                        <td><?= (int)$s['sort_order'] ?></td>
                        <td><?= ((int)$s['is_active'] === 1) ? 'Yes' : 'No' ?></td>
                        <td class="text-end">
                            <a class="btn btn-outline-primary btn-sm" href="slide_edit.php?id=<?= (int)$s['id'] ?>">تعديل</a>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="slide_id" value="<?= (int)$s['id'] ?>">
                                <button class="btn btn-outline-danger btn-sm" type="submit" onclick="return confirm('حذف السلايد؟');">حذف</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
