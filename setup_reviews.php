<?php
require_once __DIR__ . '/includes/init.php';

try {
    db()->exec("CREATE TABLE IF NOT EXISTS `reviews` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(190) NOT NULL,
      `rating` TINYINT(1) NOT NULL DEFAULT 5,
      `review` TEXT NOT NULL,
      `lang` VARCHAR(10) NOT NULL DEFAULT 'ar',
      `is_active` TINYINT(1) NOT NULL DEFAULT 0,
      `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `reviews_lang_idx` (`lang`),
      KEY `reviews_active_idx` (`is_active`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
    echo "Reviews table created successfully!";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage();
}
