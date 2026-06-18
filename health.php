<?php

declare(strict_types=1);

header('Content-Type: text/plain; charset=utf-8');

echo "Sawa Health Check\n";
echo "=================\n\n";

echo "PHP: " . PHP_VERSION . "\n";
echo "SAPI: " . (PHP_SAPI ?: 'unknown') . "\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

$root = __DIR__;

$configPath = $root . '/config/config.php';
$dbPath = $root . '/config/db.php';

if (!extension_loaded('pdo')) {
    echo "PDO: MISSING\n";
} else {
    echo "PDO: OK\n";
}

if (!extension_loaded('pdo_mysql')) {
    echo "PDO MySQL: MISSING\n";
} else {
    echo "PDO MySQL: OK\n";
}

echo "\n";

echo "config/config.php: " . (is_file($configPath) ? 'OK' : 'MISSING') . "\n";
echo "config/db.php: " . (is_file($dbPath) ? 'OK' : 'MISSING') . "\n\n";

if (!is_file($configPath) || !is_file($dbPath)) {
    echo "Cannot test DB because config files are missing.\n";
    exit;
}

try {
    require_once $configPath;
    require_once $dbPath;

    $envHost = getenv('DB_HOST');
    $envName = getenv('DB_NAME');
    $envUser = getenv('DB_USER');
    $envPass = getenv('DB_PASS');
    $envPort = getenv('DB_PORT');

    $envHostState = ($envHost === false) ? 'NOT SET' : (($envHost === '') ? 'EMPTY' : 'SET');
    $envNameState = ($envName === false) ? 'NOT SET' : (($envName === '') ? 'EMPTY' : 'SET');
    $envUserState = ($envUser === false) ? 'NOT SET' : (($envUser === '') ? 'EMPTY' : 'SET');
    $envPassState = ($envPass === false) ? 'NOT SET' : (($envPass === '') ? 'EMPTY' : 'SET');
    $envPortState = ($envPort === false) ? 'NOT SET' : (($envPort === '') ? 'EMPTY' : 'SET');

    echo "ENV DB_HOST: " . $envHostState . "\n";
    echo "ENV DB_NAME: " . $envNameState . "\n";
    echo "ENV DB_USER: " . $envUserState . "\n";
    echo "ENV DB_PASS: " . $envPassState . "\n";
    echo "ENV DB_PORT: " . $envPortState . "\n";

    $passLen = defined('DB_PASS') ? strlen((string)DB_PASS) : 0;
    $passSource = ($envPass !== false && $envPass !== '') ? 'env' : 'config default';
    echo "DB_PASS Source: " . $passSource . "\n";
    echo "DB_PASS Length: " . $passLen . "\n\n";

    echo "DB_HOST: " . (defined('DB_HOST') ? DB_HOST : 'not-defined') . "\n";
    echo "DB_NAME: " . (defined('DB_NAME') ? DB_NAME : 'not-defined') . "\n";
    echo "DB_USER: " . (defined('DB_USER') ? DB_USER : 'not-defined') . "\n";
    echo "DB_PORT: " . (defined('DB_PORT') ? (string)DB_PORT : 'not-defined') . "\n\n";

    if (!function_exists('db')) {
        echo "db() function: MISSING\n";
        exit;
    }

    $pdo = db();
    $version = $pdo->query('SELECT VERSION()')->fetchColumn();
    echo "DB Connection: OK\n";
    echo "MySQL Version: " . (string)$version . "\n";

    try {
        $tablesCount = (int)$pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE()")
            ->fetchColumn();
        echo "Tables (in current DB): " . $tablesCount . "\n";
    } catch (Throwable $e) {
        echo "Tables count: ERROR (" . $e->getMessage() . ")\n";
    }

} catch (Throwable $e) {
    echo "DB Connection: ERROR\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
