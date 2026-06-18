<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

if (admin_user()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    $stmt = db()->prepare('SELECT id, username, role, password_hash FROM users WHERE username = :u LIMIT 1');
    $stmt->execute([':u' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, (string)$user['password_hash'])) {
        $_SESSION['admin_user'] = ['id' => (int)$user['id'], 'username' => (string)$user['username'], 'role' => (string)($user['role'] ?? 'admin')];
        header('Location: index.php');
        exit;
    }

    $error = 'بيانات الدخول غير صحيحة';
}

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

?><!doctype html>
<html lang="<?= e($lang) ?>" dir="<?= e($dir) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(t('admin_login')) ?> - <?= e(company_name()) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <?php if (is_rtl()): ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <?php else: ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= e(asset_url('../assets/css/style.css')) ?>">
</head>
<body class="admin-body">

<div class="auth-shell">
    <div class="auth-card">
        <div class="p-4 p-md-4">
            <div class="auth-brand">
                <div>
                    <div class="title h4 m-0"><?= e(t('admin_login')) ?></div>
                    <div class="sub"><?= e(company_name()) ?></div>
                </div>
                <div class="d-flex gap-2">
                    <a class="btn btn-sm <?= $lang === 'ar' ? 'btn-light text-dark' : 'btn-outline-light' ?>" href="<?= e(lang_url('ar')) ?>">AR</a>
                    <a class="btn btn-sm <?= $lang === 'en' ? 'btn-light text-dark' : 'btn-outline-light' ?>" href="<?= e(lang_url('en')) ?>">EN</a>
                </div>
            </div>

            <?php if ($error !== ''): ?>
                <div class="alert alert-danger"><?= e($error) ?></div>
            <?php endif; ?>

            <form method="post" class="row g-3">
                <div class="col-12">
                    <label class="form-label"><?= e(t('username')) ?></label>
                    <input class="form-control" name="username" required>
                </div>
                <div class="col-12">
                    <label class="form-label"><?= e(t('password')) ?></label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit"><?= e(t('login')) ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
