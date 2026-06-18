CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(190) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) NOT NULL DEFAULT 'admin',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_uq` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `settings` (
  `k` VARCHAR(190) NOT NULL,
  `v` TEXT NOT NULL,
  PRIMARY KEY (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `cars` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` VARCHAR(190) NOT NULL,
  `name_en` VARCHAR(190) NOT NULL,
  `type_ar` VARCHAR(190) NOT NULL,
  `type_en` VARCHAR(190) NOT NULL,
  `daily_price` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `monthly_price` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `features_ar` TEXT NULL,
  `features_en` TEXT NULL,
  `is_offer` TINYINT(1) NOT NULL DEFAULT 0,
  `offer_details_ar` VARCHAR(255) NULL,
  `offer_details_en` VARCHAR(255) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `car_images` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `car_id` INT UNSIGNED NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_primary` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `car_images_car_file_uq` (`car_id`, `file_path`),
  KEY `car_images_car_id_idx` (`car_id`),
  CONSTRAINT `car_images_car_id_fk` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `slides` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_ar` VARCHAR(190) NOT NULL,
  `title_en` VARCHAR(190) NOT NULL,
  `subtitle_ar` VARCHAR(255) NOT NULL,
  `subtitle_en` VARCHAR(255) NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `offers` (
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
  `promo_slide` TINYINT(1) NOT NULL DEFAULT 0,
  `slide_id` INT UNSIGNED NULL,
  `expires_at` DATE NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `offers_car_days_uq` (`car_id`, `days`),
  KEY `offers_car_id_idx` (`car_id`),
  KEY `offers_active_idx` (`is_active`, `sort_order`, `id`),
  KEY `offers_expires_at_idx` (`expires_at`),
  CONSTRAINT `offers_car_id_fk` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `bookings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `car_id` INT UNSIGNED NULL,
  `offer_id` INT UNSIGNED NULL,
  `customer_name` VARCHAR(190) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `start_date` DATE NULL,
  `end_date` DATE NULL,
  `id_image_path` VARCHAR(255) NULL,
  `license_image_path` VARCHAR(255) NULL,
  `notes` TEXT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'new',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bookings_car_id_idx` (`car_id`),
  KEY `bookings_offer_id_idx` (`offer_id`),
  CONSTRAINT `bookings_car_id_fk` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE SET NULL,
  CONSTRAINT `bookings_offer_id_fk` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `payments` (
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
  KEY `payments_status_idx` (`status`, `id`),
  CONSTRAINT `payments_booking_id_fk` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `settings` (`k`, `v`) VALUES
('company_name_ar', 'شركة سوى لتأجير السيارات'),
('company_name_en', 'Sawa Rent Car'),
('company_phone_1', '0597492182'),
('company_phone_2', '0599930120'),
('company_address_ar', ' البيرة، البالوع، قرب شركة جوال'),
('company_address_en', 'Al-Bireh, Al-Baloua, near Jawwal'),
('company_working_hours_ar', 'يومياً من 8:00 صباحاً - 10:00 مساءً'),
('company_working_hours_en', 'Daily from 8:00 AM - 10:00 PM'),
('social_facebook', ''),
('social_instagram', ''),
('social_tiktok', ''),
('social_youtube', '')
ON DUPLICATE KEY UPDATE v=VALUES(v);

INSERT INTO `users` (`username`, `role`, `password_hash`) VALUES
('admin', 'superadmin', '$2y$10$mtQO2azmga.dxKwP68ivI.qKc4dHhy9sAaGF1XSIQxDHIxZMs57we')
ON DUPLICATE KEY UPDATE role=VALUES(role), password_hash=VALUES(password_hash);

INSERT INTO `slides` (`title_ar`, `title_en`, `subtitle_ar`, `subtitle_en`, `image_path`, `sort_order`, `is_active`) VALUES
('انطلق في رحلتك مع سوى', 'Start your trip with Sawa', 'أحدث السيارات، أفضل الأسعار، وخدمة ممتازة.', 'Modern cars, great prices, and great service.', 'unnamed (1).jpg', 1, 1)
ON DUPLICATE KEY UPDATE title_ar=VALUES(title_ar), title_en=VALUES(title_en), subtitle_ar=VALUES(subtitle_ar), subtitle_en=VALUES(subtitle_en), image_path=VALUES(image_path);

INSERT INTO `cars` (`name_ar`, `name_en`, `type_ar`, `type_en`, `daily_price`, `monthly_price`, `features_ar`, `features_en`, `is_offer`, `offer_details_ar`, `offer_details_en`, `is_active`) VALUES
('كيا سيراتو', 'Kia Cerato', 'سيدان', 'Sedan', 120, 2300, NULL, NULL, 1, 'أفضل الأسعار للباقات اليومية والأسبوعية والشهرية', 'Best prices for daily, weekly and monthly packages', 1)
ON DUPLICATE KEY UPDATE name_ar=VALUES(name_ar);

INSERT INTO `car_images` (`car_id`, `file_path`, `sort_order`, `is_primary`)
SELECT c.id, 'unnamed (1).jpg', 1, 1
FROM cars c
ON DUPLICATE KEY UPDATE file_path=VALUES(file_path);
