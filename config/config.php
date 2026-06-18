<?php
declare(strict_types=1);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(0);

define('APP_NAME', 'Sawa Rent Car');
define('DEFAULT_LANG', 'en');

function env_str(string $key, string $default): string {
    $v = getenv($key);
    if ($v === false || $v === '') { return $default; }
    return (string)$v;
}

$defaultDbHost = 'localhost';
$defaultDbName = 'u920699383_sawa';
$defaultDbUser = 'u920699383_sawa';
$defaultDbPass = 'Mohammed@#!135';

define('DB_HOST', env_str('DB_HOST', $defaultDbHost));
define('DB_NAME', env_str('DB_NAME', $defaultDbName));
define('DB_USER', env_str('DB_USER', $defaultDbUser));
define('DB_PASS', env_str('DB_PASS', $defaultDbPass));

$dbPortEnv = getenv('DB_PORT');
define('DB_PORT', $dbPortEnv !== false && $dbPortEnv !== '' ? (int)$dbPortEnv : 3306);

define('UPLOADS_DIR', __DIR__ . '/../uploads');
define('UPLOADS_URL', 'uploads');

define('CARS_SOURCE_DIR', '');
