<?php

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin']);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = null;

if ($id > 0) {
    $stmt = db()->prepare('SELECT id, username, role, created_at FROM users WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch();
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string)($_POST['username'] ?? ''));
    $role = trim((string)($_POST['role'] ?? 'admin'));
    $password = (string)($_POST['password'] ?? '');
    $password2 = (string)($_POST['password2'] ?? '');

    if ($username === '') {
        $errors[] = 'Username مطلوب';
    }

    if (!in_array($role, ['superadmin', 'admin', 'editor'], true)) {
        $errors[] = 'Role غير صحيح';
    }

    if ($id === 0 && $password === '') {
        $errors[] = 'كلمة المرور مطلوبة للمستخدم الجديد';
    }

    if ($password !== '' && $password !== $password2) {
        $errors[] = 'كلمة المرور غير متطابقة';
    }

    if (!$errors) {
        if ($id > 0) {
            $stmt = db()->prepare('UPDATE users SET username = :u, role = :r WHERE id = :id');
            $stmt->execute([':u' => $username, ':r' => $role, ':id' => $id]);

            if ($password !== '') {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = db()->prepare('UPDATE users SET password_hash = :h WHERE id = :id');
                $stmt->execute([':h' => $hash, ':id' => $id]);
            }
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = db()->prepare('INSERT INTO users (username, role, password_hash) VALUES (:u, :r, :h)');
            $stmt->execute([':u' => $username, ':r' => $role, ':h' => $hash]);
            $id = (int)db()->lastInsertId();
        }

        header('Location: users.php');
        exit;
    }
}

$defaults = [
    'username' => $user['username'] ?? '',
    'role' => $user['role'] ?? 'admin',
];

include __DIR__ . '/partials/header.php';

?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 fw-bold m-0"><?= $id > 0 ? 'تعديل مستخدم' : 'إضافة مستخدم' ?></h1>
    <a class="btn btn-outline-secondary" href="users.php">رجوع</a>
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
        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Username</label>
                <input class="form-control" name="username" value="<?= e((string)$defaults['username']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Role</label>
                <select class="form-select" name="role">
                    <option value="superadmin" <?= ((string)$defaults['role'] === 'superadmin') ? 'selected' : '' ?>>superadmin</option>
                    <option value="admin" <?= ((string)$defaults['role'] === 'admin') ? 'selected' : '' ?>>admin</option>
                    <option value="editor" <?= ((string)$defaults['role'] === 'editor') ? 'selected' : '' ?>>editor</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Password <?= $id > 0 ? '(اتركها فارغة بدون تغيير)' : '' ?></label>
                <input class="form-control" type="password" name="password">
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirm password</label>
                <input class="form-control" type="password" name="password2">
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
