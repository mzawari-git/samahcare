<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin']);

if (!isset($_SESSION['debug_token']) || !is_string($_SESSION['debug_token']) || $_SESSION['debug_token'] === '') {
    $_SESSION['debug_token'] = bin2hex(random_bytes(16));
}

$token = (string)($_GET['t'] ?? '');
$action = (string)($_GET['action'] ?? '');

$logFile = __DIR__ . '/../logs/error.log';
$logDir = dirname($logFile);
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}

function format_bytes(int $bytes): string
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    $v = (float)$bytes;
    while ($v >= 1024 && $i < count($units) - 1) {
        $v /= 1024;
        $i++;
    }
    return number_format($v, 2) . ' ' . $units[$i];
}

if ($action !== '' && $token === $_SESSION['debug_token']) {
    if ($action === 'clear_logs') {
        if (is_file($logFile)) {
            @file_put_contents($logFile, '');
        }
        header('Location: maintenance.php');
        exit;
    }

    if ($action === 'rotate_logs') {
        if (is_file($logFile)) {
            $maxSize = 5 * 1024 * 1024;
            if (@filesize($logFile) > $maxSize) {
                $backupFile = __DIR__ . '/../logs/error_' . date('Y-m-d_H-i-s') . '.log';
                @rename($logFile, $backupFile);
            }
        }
        header('Location: maintenance.php');
        exit;
    }

    if ($action === 'optimize_db') {
        try {
            $tables = db()->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
            foreach ($tables as $table) {
                db()->query("OPTIMIZE TABLE `$table`");
            }
        } catch (Throwable $e) {
            error_log('optimize_db failed: ' . $e->getMessage());
        }
        header('Location: maintenance.php');
        exit;
    }
}

$envHost = getenv('DB_HOST');
$envName = getenv('DB_NAME');
$envUser = getenv('DB_USER');
$envPass = getenv('DB_PASS');
$envPort = getenv('DB_PORT');

$dbStatus = [
    'ok' => false,
    'message' => '',
    'version' => '',
];

try {
    $pdo = db();
    $dbStatus['ok'] = true;
    $dbStatus['version'] = (string)$pdo->query('SELECT VERSION()')->fetchColumn();
} catch (Throwable $e) {
    $dbStatus['ok'] = false;
    $dbStatus['message'] = $e->getMessage();
}

$recentErrors = [];
if (is_file($logFile)) {
    $lines = @file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (is_array($lines)) {
        $recentErrors = array_slice(array_reverse($lines), 0, 50);
    }
}

$logSize = is_file($logFile) ? (int)@filesize($logFile) : 0;

include __DIR__ . '/partials/header.php';

?>

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h3 fw-bold m-0">مركز الصيانة</h1>
        <div class="text-secondary small">فحص شامل للموقع + أدوات إصلاح</div>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a class="btn btn-outline-secondary" href="../health.php" target="_blank" rel="noopener">Health</a>
        <a class="btn btn-outline-primary" href="../cleanup.php?t=<?= e($_SESSION['debug_token']) ?>" target="_blank" rel="noopener">تشغيل التنظيف</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="fw-bold">حالة قاعدة البيانات</div>
                    <?php if ($dbStatus['ok']): ?>
                        <span class="badge text-bg-success">Connected</span>
                    <?php else: ?>
                        <span class="badge text-bg-danger">Disconnected</span>
                    <?php endif; ?>
                </div>

                <div class="mt-3">
                    <div class="small text-secondary">DB_HOST: <span class="text-body-emphasis"><?= e(DB_HOST) ?></span></div>
                    <div class="small text-secondary">DB_NAME: <span class="text-body-emphasis"><?= e(DB_NAME) ?></span></div>
                    <div class="small text-secondary">DB_USER: <span class="text-body-emphasis"><?= e(DB_USER) ?></span></div>
                    <div class="small text-secondary">DB_PORT: <span class="text-body-emphasis"><?= e((string)DB_PORT) ?></span></div>
                    <div class="small text-secondary">DB_PASS Length: <span class="text-body-emphasis"><?= e((string)strlen((string)DB_PASS)) ?></span></div>
                    <div class="small text-secondary">MySQL Version: <span class="text-body-emphasis"><?= e($dbStatus['version'] !== '' ? $dbStatus['version'] : '-') ?></span></div>

                    <div class="small text-secondary mt-3">ENV DB_HOST: <span class="text-body-emphasis"><?= e($envHost !== false ? 'SET' : 'NOT SET') ?></span></div>
                    <div class="small text-secondary">ENV DB_NAME: <span class="text-body-emphasis"><?= e($envName !== false ? 'SET' : 'NOT SET') ?></span></div>
                    <div class="small text-secondary">ENV DB_USER: <span class="text-body-emphasis"><?= e($envUser !== false ? 'SET' : 'NOT SET') ?></span></div>
                    <div class="small text-secondary">ENV DB_PASS: <span class="text-body-emphasis"><?= e($envPass !== false ? 'SET' : 'NOT SET') ?></span></div>
                    <div class="small text-secondary">ENV DB_PORT: <span class="text-body-emphasis"><?= e($envPort !== false ? 'SET' : 'NOT SET') ?></span></div>

                    <?php if (!$dbStatus['ok'] && $dbStatus['message'] !== ''): ?>
                        <div class="alert alert-danger mt-3 mb-0">
                            <?= e($dbStatus['message']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-2 flex-wrap mt-3">
                    <a class="btn btn-sm btn-outline-danger" href="?action=clear_logs&t=<?= e($_SESSION['debug_token']) ?>">تفريغ السجلات</a>
                    <a class="btn btn-sm btn-outline-secondary" href="?action=rotate_logs&t=<?= e($_SESSION['debug_token']) ?>">تدوير السجلات</a>
                    <a class="btn btn-sm btn-outline-success" href="?action=optimize_db&t=<?= e($_SESSION['debug_token']) ?>">تحسين DB</a>
                </div>

                <div class="text-secondary small mt-2">حجم سجل الأخطاء: <?= e(format_bytes($logSize)) ?></div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="fw-bold mb-3">معلومات السيرفر</div>
                <div class="small text-secondary">PHP: <span class="text-body-emphasis"><?= e(PHP_VERSION) ?></span></div>
                <div class="small text-secondary">SAPI: <span class="text-body-emphasis"><?= e(PHP_SAPI) ?></span></div>
                <div class="small text-secondary">Memory Limit: <span class="text-body-emphasis"><?= e((string)ini_get('memory_limit')) ?></span></div>
                <div class="small text-secondary">Max Execution Time: <span class="text-body-emphasis"><?= e((string)ini_get('max_execution_time')) ?>s</span></div>
                <div class="small text-secondary">Upload Max: <span class="text-body-emphasis"><?= e((string)ini_get('upload_max_filesize')) ?></span></div>
                <div class="small text-secondary">Post Max: <span class="text-body-emphasis"><?= e((string)ini_get('post_max_size')) ?></span></div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="fw-bold">آخر الأخطاء (50)</div>
                </div>

                <?php if (count($recentErrors) === 0): ?>
                    <div class="text-secondary">لا توجد أخطاء مسجلة حالياً.</div>
                <?php else: ?>
                    <div style="max-height: 420px; overflow:auto; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace; font-size:12px;">
                        <?php foreach ($recentErrors as $line): ?>
                            <div class="border-bottom py-1"><?= e($line) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
