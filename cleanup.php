<?php
require_once __DIR__ . '/includes/init.php';

require_once __DIR__ . '/admin/includes/auth.php';

$isCli = (PHP_SAPI === 'cli');
if (!$isCli) {
    if (!admin_user()) {
        header('Location: admin/login.php');
        exit;
    }
    if (!in_array(admin_role(), ['superadmin', 'admin'], true)) {
        http_response_code(403);
        echo '<h1>403 Forbidden</h1>';
        exit;
    }

    if (!isset($_SESSION['debug_token']) || !is_string($_SESSION['debug_token']) || $_SESSION['debug_token'] === '') {
        $_SESSION['debug_token'] = bin2hex(random_bytes(16));
    }
    $token = isset($_GET['t']) ? (string)$_GET['t'] : '';
    if ($token !== $_SESSION['debug_token']) {
        header('Location: debug.php');
        exit;
    }
}

// Cleanup functions
function cleanupTempFiles() {
    $tempDir = __DIR__ . '/uploads/temp';
    $cleaned = 0;
    
    if (is_dir($tempDir)) {
        $files = glob($tempDir . '/*');
        foreach ($files as $file) {
            if (is_file($file) && (time() - filemtime($file)) > 86400) { // Older than 24 hours
                unlink($file);
                $cleaned++;
            }
        }
    }
    
    return $cleaned;
}

function optimizeDatabase() {
    try {
        $tables = db()->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
        $optimized = 0;
        
        foreach ($tables as $table) {
            db()->query("OPTIMIZE TABLE `$table`");
            $optimized++;
        }
        
        return $optimized;
    } catch (Exception $e) {
        error_log("Database optimization failed: " . $e->getMessage());
        return 0;
    }
}

function rotateLogs() {
    $logFile = __DIR__ . '/logs/error.log';
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    if (file_exists($logFile) && filesize($logFile) > $maxSize) {
        $backupFile = __DIR__ . '/logs/error_' . date('Y-m-d_H-i-s') . '.log';
        rename($logFile, $backupFile);
        return true;
    }
    
    return false;
}

// Perform cleanup
$results = [
    'temp_files' => cleanupTempFiles(),
    'db_optimized' => optimizeDatabase(),
    'logs_rotated' => rotateLogs(),
];

// Output results
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'timestamp' => date('Y-m-d H:i:s'),
    'results' => $results
]);
?>
