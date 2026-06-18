<?php

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin']);

$users = db()->query('SELECT id, username, role, created_at FROM users ORDER BY id DESC')->fetchAll();

include __DIR__ . '/partials/header.php';

?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 fw-bold m-0">المستخدمون</h1>
    <a class="btn btn-primary" href="user_edit.php">+ إضافة مستخدم</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= (int)$u['id'] ?></td>
                        <td><?= e((string)$u['username']) ?></td>
                        <td><span class="badge bg-secondary"><?= e((string)$u['role']) ?></span></td>
                        <td><?= e((string)$u['created_at']) ?></td>
                        <td class="text-end">
                            <a class="btn btn-outline-primary btn-sm" href="user_edit.php?id=<?= (int)$u['id'] ?>">تعديل</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
