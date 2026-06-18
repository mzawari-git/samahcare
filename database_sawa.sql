-- =====================================================
-- Sawa Rent Car Database Export
-- Database: u920699383_sawa
-- Generated: 2026-03-27
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+03:00";

-- =====================================================
-- Database Creation
-- =====================================================
CREATE DATABASE IF NOT EXISTS u920699383_sawa DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE u920699383_sawa;

-- =====================================================
-- Table: users
-- =====================================================
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(190) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'admin',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY users_username_uq (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (id, username, password_hash, role, created_at) VALUES
(1, 'admin', '$2y$10$kp5doX..DCUuzPWmlAsRL.m12jFzoboehSxnjPpPAdm4LbO3u.Dn2', 'superadmin', '2026-03-26 21:44:28');

-- =====================================================
-- Table: settings
-- =====================================================
DROP TABLE IF EXISTS settings;
CREATE TABLE settings (
  k VARCHAR(190) NOT NULL,
  v TEXT NOT NULL,
  PRIMARY KEY (k)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO settings (k, v) VALUES
('company_address_ar', 'البيرة، البالوع، بجانب جوال'),
('company_address_en', 'Al-Bireh, Al-Baloua, near Jawwal'),
('company_name_ar', 'شركة سوى لتأجير السيارات'),
('company_name_en', 'Sawa Rent Car'),
('company_phone_1', '0597492182'),
('company_phone_2', '0599930120'),
('company_working_hours_ar', 'يومياً من 8:00 صباحاً - 10:00 مساءً'),
('company_working_hours_en', 'Daily from 8:00 AM - 10:00 PM'),
('pay_bank_details_ar', ''),
('pay_bank_details_en', ''),
('pay_bank_label_ar', ''),
('pay_bank_label_en', ''),
('pay_cards_mode', 'sandbox'),
('pay_cards_provider', ''),
('pay_cards_public_key', ''),
('pay_cards_secret_key', ''),
('pay_cash_details_ar', ''),
('pay_cash_details_en', ''),
('pay_enable_bank', '0'),
('pay_enable_cards', '0'),
('pay_enable_cash', '1'),
('pay_enable_jawwal', '1'),
('pay_enable_palpay', '0'),
('pay_jawwal_details_ar', ''),
('pay_jawwal_details_en', ''),
('pay_jawwal_label_ar', ''),
('pay_jawwal_label_en', ''),
('pay_palpay_details_ar', ''),
('pay_palpay_details_en', ''),
('pay_palpay_label_ar', ''),
('pay_palpay_label_en', ''),
('price_day_1', '120'),
('price_day_10', '1000'),
('price_day_15', '1350'),
('price_day_20', '1700'),
('price_day_3', '330'),
('price_day_30', '2400'),
('price_monthly', '2300'),
('site_theme', 'blue'),
('site_url', 'https://sawarentcar.online'),
('social_facebook', 'https://www.facebook.com/Sawarentcar'),
('social_instagram', ''),
('social_tiktok', ''),
('social_youtube', '');

-- =====================================================
-- Table: cars
-- =====================================================
DROP TABLE IF EXISTS cars;
CREATE TABLE cars (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name_ar VARCHAR(190) NOT NULL,
  name_en VARCHAR(190) NOT NULL,
  type_ar VARCHAR(190) NOT NULL,
  type_en VARCHAR(190) NOT NULL,
  daily_price DECIMAL(10,2) NOT NULL DEFAULT 0,
  monthly_price DECIMAL(10,2) NOT NULL DEFAULT 0,
  features_ar TEXT NULL,
  features_en TEXT NULL,
  is_offer TINYINT(1) NOT NULL DEFAULT 0,
  offer_details_ar VARCHAR(255) NULL,
  offer_details_en VARCHAR(255) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO cars (id, name_ar, name_en, type_ar, type_en, daily_price, monthly_price, features_ar, features_en, is_offer, offer_details_ar, offer_details_en, is_active, created_at) VALUES
(1, 'كيا سيراتو', 'Kia Cerato', 'سيدان', 'Sedan', 120.00, 2300.00, '', '', 0, 'أفضل الأسعار للباقات اليومية والأسبوعية والشهرية', 'Best prices for daily, weekly and monthly packages', 1, '2026-03-26 21:44:28');

-- =====================================================
-- Table: car_images
-- =====================================================
DROP TABLE IF EXISTS car_images;
CREATE TABLE car_images (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  car_id INT UNSIGNED NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_primary TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE KEY car_images_car_file_uq (car_id, file_path),
  KEY car_images_car_id_idx (car_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO car_images (id, car_id, file_path, sort_order, is_primary) VALUES
(10, 1, 'uploads/car_1_img_1774632348_0.webp', 1, 1),
(11, 1, 'uploads/car_1_img_1774632348_1.webp', 2, 0),
(12, 1, 'uploads/car_1_img_1774632348_2.webp', 3, 0),
(13, 1, 'uploads/car_1_img_1774632348_3.jpeg', 4, 0),
(14, 1, 'uploads/car_1_img_1774632348_4.jpeg', 5, 0),
(15, 1, 'uploads/car_1_img_1774632348_5.jpg', 6, 0),
(16, 1, 'uploads/car_1_img_1774632348_6.webp', 7, 0);

-- =====================================================
-- Table: slides
-- =====================================================
DROP TABLE IF EXISTS slides;
CREATE TABLE slides (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  title_ar VARCHAR(190) NOT NULL,
  title_en VARCHAR(190) NOT NULL,
  subtitle_ar VARCHAR(255) NOT NULL,
  subtitle_en VARCHAR(255) NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO slides (id, title_ar, title_en, subtitle_ar, subtitle_en, image_path, sort_order, is_active) VALUES
(1, 'انطلق في رحلتك مع سوى', 'Start your trip with Sawa', 'أحدث السيارات، أفضل الأسعار، وخدمة ممتازة.', 'Modern cars, great prices, and great service.', 'uploads/slide_1_1774556014.png', 1, 1);

-- =====================================================
-- Table: bookings
-- =====================================================
DROP TABLE IF EXISTS bookings;
CREATE TABLE bookings (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  car_id INT UNSIGNED NULL,
  offer_id INT UNSIGNED NULL,
  customer_name VARCHAR(190) NOT NULL,
  phone VARCHAR(50) NOT NULL,
  start_date DATE NULL,
  end_date DATE NULL,
  id_image_path VARCHAR(255) NULL,
  license_image_path VARCHAR(255) NULL,
  notes TEXT NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'new',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  total_price DECIMAL(10,2) DEFAULT 0,
  num_days INT DEFAULT 1,
  PRIMARY KEY (id),
  KEY bookings_car_id_idx (car_id),
  KEY bookings_offer_id_idx (offer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO bookings (id, car_id, offer_id, customer_name, phone, start_date, end_date, id_image_path, license_image_path, notes, status, created_at, total_price, num_days) VALUES
(2, NULL, NULL, 'يببسي', '423432423', '2026-03-27', '2026-04-11', 'uploads/booking_20260327_190539_c1b1b24bc136.png', 'uploads/booking_20260327_190539_0a714216a4b6.webp', '', 'new', '2026-03-27 20:05:39', 0.00, 1),
(3, NULL, NULL, 'dasas', '3123123213', '2026-03-27', '2026-04-11', 'uploads/booking_20260327_190701_0b9c53c5159b.jpg', 'uploads/booking_20260327_190701_a8972245e3c2.png', '', 'new', '2026-03-27 20:07:01', 1350.00, 15);

-- =====================================================
-- Table: offers
-- =====================================================
DROP TABLE IF EXISTS offers;
CREATE TABLE offers (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  car_id INT UNSIGNED NULL,
  title_ar VARCHAR(190) NOT NULL,
  title_en VARCHAR(190) NOT NULL,
  description_ar TEXT NULL,
  description_en TEXT NULL,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  days INT NOT NULL DEFAULT 1,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY offers_car_id_idx (car_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: offer_media
-- =====================================================
DROP TABLE IF EXISTS offer_media;
CREATE TABLE offer_media (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  offer_id INT UNSIGNED NOT NULL,
  type VARCHAR(20) NOT NULL DEFAULT 'image',
  file_path VARCHAR(255) NULL,
  video_url VARCHAR(255) NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_primary TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  KEY offer_media_offer_id_idx (offer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: payments
-- =====================================================
DROP TABLE IF EXISTS payments;
CREATE TABLE payments (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  booking_id INT UNSIGNED NOT NULL,
  amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  method VARCHAR(50) NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'pending',
  reference VARCHAR(190) NULL,
  transaction_id VARCHAR(190) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  PRIMARY KEY (id),
  KEY payments_booking_id_idx (booking_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Indexes for Performance
-- =====================================================
CREATE INDEX idx_cars_is_active ON cars (is_active);
CREATE INDEX idx_cars_is_offer ON cars (is_offer);
CREATE INDEX idx_slides_is_active ON slides (is_active);
CREATE INDEX idx_slides_sort_order ON slides (sort_order);
CREATE INDEX idx_bookings_status ON bookings (status);
CREATE INDEX idx_bookings_created_at ON bookings (created_at);
CREATE INDEX idx_settings_k ON settings (k);

COMMIT;
