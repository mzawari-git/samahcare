<?php

declare(strict_types=1);

$logFile = __DIR__ . '/../logs/error.log';
$logDir = dirname($logFile);
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}
@ini_set('log_errors', '1');
@ini_set('error_log', $logFile);

set_error_handler(function ($severity, $message, $file, $line) use ($logFile) {
    $timestamp = date('Y-m-d H:i:s');
    switch ($severity) {
        case E_ERROR:
            $level = 'ERROR';
            break;
        case E_WARNING:
            $level = 'WARNING';
            break;
        case E_NOTICE:
            $level = 'NOTICE';
            break;
        case E_USER_ERROR:
            $level = 'USER_ERROR';
            break;
        case E_USER_WARNING:
            $level = 'USER_WARNING';
            break;
        case E_USER_NOTICE:
            $level = 'USER_NOTICE';
            break;
        default:
            $level = 'UNKNOWN';
            break;
    }

    $uri = isset($_SERVER['REQUEST_URI']) ? (string)$_SERVER['REQUEST_URI'] : '';
    $ip = isset($_SERVER['REMOTE_ADDR']) ? (string)$_SERVER['REMOTE_ADDR'] : '';
    $logEntry = "[$timestamp] $level: $message | $file:$line";
    if ($uri !== '') {
        $logEntry .= " | uri=$uri";
    }
    if ($ip !== '') {
        $logEntry .= " | ip=$ip";
    }
    $logEntry .= PHP_EOL;

    @file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    return false;
});

set_exception_handler(function (Throwable $e) use ($logFile) {
    $timestamp = date('Y-m-d H:i:s');
    $uri = isset($_SERVER['REQUEST_URI']) ? (string)$_SERVER['REQUEST_URI'] : '';
    $ip = isset($_SERVER['REMOTE_ADDR']) ? (string)$_SERVER['REMOTE_ADDR'] : '';
    $msg = "[$timestamp] EXCEPTION: " . $e->getMessage() . " | " . $e->getFile() . ':' . $e->getLine();
    if ($uri !== '') {
        $msg .= " | uri=$uri";
    }
    if ($ip !== '') {
        $msg .= " | ip=$ip";
    }
    $msg .= PHP_EOL . $e->getTraceAsString() . PHP_EOL;
    @file_put_contents($logFile, $msg, FILE_APPEND | LOCK_EX);
});

register_shutdown_function(function () use ($logFile) {
    $err = error_get_last();
    if (!$err) {
        return;
    }
    $type = isset($err['type']) ? (int)$err['type'] : 0;
    $fatalTypes = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR];
    if (!in_array($type, $fatalTypes, true)) {
        return;
    }

    $timestamp = date('Y-m-d H:i:s');
    $file = isset($err['file']) ? (string)$err['file'] : '';
    $line = isset($err['line']) ? (int)$err['line'] : 0;
    $message = isset($err['message']) ? (string)$err['message'] : 'Fatal error';
    $uri = isset($_SERVER['REQUEST_URI']) ? (string)$_SERVER['REQUEST_URI'] : '';
    $ip = isset($_SERVER['REMOTE_ADDR']) ? (string)$_SERVER['REMOTE_ADDR'] : '';

    $logEntry = "[$timestamp] FATAL: $message | $file:$line";
    if ($uri !== '') {
        $logEntry .= " | uri=$uri";
    }
    if ($ip !== '') {
        $logEntry .= " | ip=$ip";
    }
    $logEntry .= PHP_EOL;
    @file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
});

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/i18n.php';

// Session cookie hardening (safe defaults)
@ini_set('session.cookie_httponly', '1');
@ini_set('session.use_strict_mode', '1');
@ini_set('session.cookie_samesite', 'Lax');
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    @ini_set('session.cookie_secure', '1');
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Security headers (only for HTTP requests)
if (PHP_SAPI !== 'cli' && !headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    header('Cross-Origin-Opener-Policy: same-origin');
    header('Cache-Control: public, max-age=3600, stale-while-revalidate=86400');

    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }

    // CSP DISABLED - allowing all sources in .htaccess
}

date_default_timezone_set('Asia/Hebron');

if (!is_dir(UPLOADS_DIR)) {
    @mkdir(UPLOADS_DIR, 0775, true);
}

try {
    db()->exec("CREATE TABLE IF NOT EXISTS `users` (\n      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,\n      `username` VARCHAR(190) NOT NULL,\n      `password_hash` VARCHAR(255) NOT NULL,\n      `role` VARCHAR(50) NOT NULL DEFAULT 'admin',\n      `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,\n      PRIMARY KEY (`id`),\n      UNIQUE KEY `users_username_uq` (`username`)\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    db()->exec("CREATE TABLE IF NOT EXISTS `settings` (\n      `k` VARCHAR(190) NOT NULL,\n      `v` TEXT NOT NULL,\n      PRIMARY KEY (`k`)\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    db()->exec("CREATE TABLE IF NOT EXISTS `cars` (\n      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,\n      `name_ar` VARCHAR(190) NOT NULL,\n      `name_en` VARCHAR(190) NOT NULL,\n      `type_ar` VARCHAR(190) NOT NULL,\n      `type_en` VARCHAR(190) NOT NULL,\n      `daily_price` DECIMAL(10,2) NOT NULL DEFAULT 0,\n      `monthly_price` DECIMAL(10,2) NOT NULL DEFAULT 0,\n      `features_ar` TEXT NULL,\n      `features_en` TEXT NULL,\n      `is_offer` TINYINT(1) NOT NULL DEFAULT 0,\n      `offer_details_ar` VARCHAR(255) NULL,\n      `offer_details_en` VARCHAR(255) NULL,\n      `is_active` TINYINT(1) NOT NULL DEFAULT 1,\n      `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,\n      PRIMARY KEY (`id`)\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    db()->exec("CREATE TABLE IF NOT EXISTS `slides` (\n      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,\n      `title_ar` VARCHAR(190) NOT NULL,\n      `title_en` VARCHAR(190) NOT NULL,\n      `subtitle_ar` VARCHAR(255) NOT NULL,\n      `subtitle_en` VARCHAR(255) NOT NULL,\n      `image_path` VARCHAR(255) NOT NULL,\n      `sort_order` INT NOT NULL DEFAULT 0,\n      `is_active` TINYINT(1) NOT NULL DEFAULT 1,\n      PRIMARY KEY (`id`)\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    db()->exec("CREATE TABLE IF NOT EXISTS `car_images` (\n      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,\n      `car_id` INT UNSIGNED NOT NULL,\n      `file_path` VARCHAR(255) NOT NULL,\n      `sort_order` INT NOT NULL DEFAULT 0,\n      `is_primary` TINYINT(1) NOT NULL DEFAULT 0,\n      PRIMARY KEY (`id`),\n      UNIQUE KEY `car_images_car_file_uq` (`car_id`, `file_path`),\n      KEY `car_images_car_id_idx` (`car_id`)\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    try {
        db()->exec("ALTER TABLE `car_images` ADD CONSTRAINT `car_images_car_id_fk` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE");
    } catch (Throwable $e) {
    }

    db()->exec("CREATE TABLE IF NOT EXISTS `bookings` (\n      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,\n      `car_id` INT UNSIGNED NULL,\n      `offer_id` INT UNSIGNED NULL,\n      `customer_name` VARCHAR(190) NOT NULL,\n      `phone` VARCHAR(50) NOT NULL,\n      `start_date` DATE NULL,\n      `end_date` DATE NULL,\n      `id_image_path` VARCHAR(255) NULL,\n      `license_image_path` VARCHAR(255) NULL,\n      `notes` TEXT NULL,\n      `status` VARCHAR(50) NOT NULL DEFAULT 'new',\n      `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,\n      PRIMARY KEY (`id`),\n      KEY `bookings_car_id_idx` (`car_id`),\n      KEY `bookings_offer_id_idx` (`offer_id`)\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    try {
        db()->exec("ALTER TABLE `bookings` ADD CONSTRAINT `bookings_car_id_fk` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE SET NULL");
    } catch (Throwable $e) {
    }

    db()->exec("CREATE TABLE IF NOT EXISTS `offers` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `car_id` INT UNSIGNED NOT NULL,
      `title_ar` VARCHAR(190) NULL,
      `title_en` VARCHAR(190) NULL,
      `description_ar` VARCHAR(255) NULL,
      `description_en` VARCHAR(255) NULL,
      `daily_price` DECIMAL(10,2) NOT NULL DEFAULT 0,
      `days` INT NOT NULL DEFAULT 1,
      `image_path` VARCHAR(255) NULL,
      `sort_order` INT NOT NULL DEFAULT 0,
      `is_active` TINYINT(1) NOT NULL DEFAULT 1,
      `expires_at` DATE NULL,
      `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `offers_car_id_idx` (`car_id`),
      KEY `offers_active_idx` (`is_active`, `sort_order`, `id`),
      KEY `offers_expires_at_idx` (`expires_at`),
      CONSTRAINT `offers_car_id_fk` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    db()->exec("CREATE TABLE IF NOT EXISTS `offer_media` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `offer_id` INT UNSIGNED NOT NULL,
      `type` VARCHAR(20) NOT NULL DEFAULT 'image',
      `file_path` VARCHAR(255) NULL,
      `video_url` TEXT NULL,
      `sort_order` INT NOT NULL DEFAULT 0,
      `is_primary` TINYINT(1) NOT NULL DEFAULT 0,
      `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `offer_media_offer_id_idx` (`offer_id`),
      KEY `offer_media_type_idx` (`type`, `id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    try {
        db()->exec("ALTER TABLE `offer_media` ADD CONSTRAINT `offer_media_offer_id_fk` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE");
    } catch (Throwable $e) {
    }

    try {
        db()->exec("ALTER TABLE `offers` ADD COLUMN `promo_slide` TINYINT(1) NOT NULL DEFAULT 0");
    } catch (Throwable $e) {
    }
    try {
        db()->exec("ALTER TABLE `offers` ADD COLUMN `slide_id` INT UNSIGNED NULL");
    } catch (Throwable $e) {
    }
    try {
        db()->exec("ALTER TABLE `offers` ADD COLUMN `expires_at` DATE NULL");
    } catch (Throwable $e) {
    }
    try {
        db()->exec("ALTER TABLE `offers` ADD UNIQUE KEY `offers_car_days_uq` (`car_id`, `days`)");
    } catch (Throwable $e) {
    }

    try {
        db()->exec("ALTER TABLE `offers` ADD KEY `offers_expires_at_idx` (`expires_at`)");
    } catch (Throwable $e) {
    }

    try {
        db()->exec("ALTER TABLE `bookings` ADD COLUMN `offer_id` INT UNSIGNED NULL");
    } catch (Throwable $e) {
    }

    try {
        db()->exec("ALTER TABLE `bookings` ADD CONSTRAINT `bookings_offer_id_fk` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE SET NULL");
    } catch (Throwable $e) {
    }

    try {
        db()->exec("ALTER TABLE `bookings` ADD COLUMN `id_image_path` VARCHAR(255) NULL");
    } catch (Throwable $e) {
    }
    try {
        db()->exec("ALTER TABLE `bookings` ADD COLUMN `license_image_path` VARCHAR(255) NULL");
    } catch (Throwable $e) {
    }

    db()->exec("CREATE TABLE IF NOT EXISTS `payments` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `booking_id` INT UNSIGNED NULL,
      `amount` DECIMAL(10,2) NOT NULL DEFAULT 0,
      `currency` CHAR(3) NOT NULL DEFAULT 'ILS',
      `status` VARCHAR(30) NOT NULL DEFAULT 'pending',
      `method` VARCHAR(50) NULL,
      `provider` VARCHAR(80) NULL,
      `reference` VARCHAR(80) NOT NULL,
      `provider_ref` VARCHAR(190) NULL,
      `meta` TEXT NULL,
      `paid_at` DATETIME NULL,
      `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `payments_reference_uq` (`reference`),
      KEY `payments_booking_id_idx` (`booking_id`),
      KEY `payments_status_idx` (`status`, `id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    try {
        db()->exec("ALTER TABLE `payments` ADD CONSTRAINT `payments_booking_id_fk` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL");
    } catch (Throwable $e) {
    }
} catch (Throwable $e) {
}
