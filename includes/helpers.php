<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

function csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $existing = isset($_SESSION['_csrf']) ? (string)$_SESSION['_csrf'] : '';
    if ($existing !== '') {
        return $existing;
    }

    $token = bin2hex(random_bytes(32));
    $_SESSION['_csrf'] = $token;
    return $token;
}

function csrf_field(string $name = 'csrf_token'): string
{
    return '<input type="hidden" name="' . e($name) . '" value="' . e(csrf_token()) . '">';
}

function csrf_verify(?string $token, string $name = 'csrf_token'): bool
{
    $token = $token === null ? '' : trim($token);
    if ($token === '') {
        return false;
    }

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $expected = isset($_SESSION['_csrf']) ? (string)$_SESSION['_csrf'] : '';
    if ($expected === '') {
        return false;
    }

    return hash_equals($expected, $token);
}

function wants_json(): bool
{
    $accept = isset($_SERVER['HTTP_ACCEPT']) ? (string)$_SERVER['HTTP_ACCEPT'] : '';
    $xrw = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? (string)$_SERVER['HTTP_X_REQUESTED_WITH'] : '';
    if ($xrw !== '' && strcasecmp($xrw, 'XMLHttpRequest') === 0) {
        return true;
    }
    return stripos($accept, 'application/json') !== false;
}

function settings_all(): array
{
    static $cache = null;
    if (is_array($cache)) {
        return $cache;
    }

    try {
        $rows = db()->query('SELECT k, v FROM settings')->fetchAll();
        $cache = [];
        foreach ($rows as $r) {
            $cache[(string)$r['k']] = (string)$r['v'];
        }
        return $cache;
    } catch (Throwable $e) {
        error_log('settings_all failed: ' . $e->getMessage());
        $cache = [];
        return $cache;
    }
}

function setting(string $k, string $default = ''): string
{
    $all = settings_all();
    return $all[$k] ?? $default;
}

function asset_url(string $path, bool $webp = true): string
{
    $path = str_replace('\\', '/', $path);
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    if ($webp && in_array($ext, ['jpg', 'jpeg', 'png', 'gif'], true)) {
        $webpPath = pathinfo($path, PATHINFO_DIRNAME) . '/' . pathinfo($path, PATHINFO_FILENAME) . '.webp';
        $webpFull = UPLOADS_DIR . '/' . ltrim($webpPath, '/');
        if (is_file($webpFull)) {
            $path = $webpPath;
        }
    }
    $parts = array_map('rawurlencode', explode('/', $path));
    return implode('/', $parts);
}

function webpify_image(string $src): void {
    $full = UPLOADS_DIR . '/' . ltrim($src, '/');
    if (!is_file($full)) return;
    $ext = strtolower(pathinfo($src, PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png'], true)) return;
    
    $webpFull = str_replace(['.jpg', '.jpeg', '.png'], '.webp', $full);
    if (is_file($webpFull)) return; // Already exists
    
    // Simple PHP WebP conversion (requires GD)
    $img = imagecreatefromstring(file_get_contents($full));
    if (!$img) return;
    
    imagewebp($img, $webpFull, 80); // Quality 80
    imagedestroy($img);
}

function slides_active(): array
{
    try {
        $stmt = db()->query('SELECT * FROM slides WHERE is_active = 1 ORDER BY sort_order ASC, id DESC');
        return $stmt->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

function offer_find(int $offerId): ?array
{
    if ($offerId <= 0) {
        return null;
    }

    $sql = "SELECT o.*,
                c.name_ar, c.name_en, c.type_ar, c.type_en, c.monthly_price,
                (
                    SELECT ci.file_path
                    FROM car_images ci
                    WHERE ci.car_id = c.id
                    ORDER BY ci.is_primary DESC, ci.sort_order ASC, ci.id ASC
                    LIMIT 1
                ) AS car_image_path
            FROM offers o
            JOIN cars c ON c.id = o.car_id
            WHERE o.id = :id AND o.is_active = 1 AND c.is_active = 1
              AND (o.expires_at IS NULL OR o.expires_at >= CURDATE())
            LIMIT 1";

    try {
        $stmt = db()->prepare($sql);
        $stmt->execute([':id' => $offerId]);
        $row = $stmt->fetch();
        return $row ?: null;
    } catch (Throwable $e) {
        return null;
    }
}

function offers_active(): array
{
    $sql = "SELECT o.*,
                o.image_path AS offer_image_path,
                c.name_ar, c.name_en, c.type_ar, c.type_en, c.monthly_price,
                (
                    SELECT ci.file_path
                    FROM car_images ci
                    WHERE ci.car_id = c.id
                    ORDER BY ci.is_primary DESC, ci.sort_order ASC, ci.id ASC
                    LIMIT 1
                ) AS car_image_path,
                COALESCE(NULLIF(o.image_path, ''), (
                    SELECT ci.file_path
                    FROM car_images ci
                    WHERE ci.car_id = c.id
                    ORDER BY ci.is_primary DESC, ci.sort_order ASC, ci.id ASC
                    LIMIT 1
                )) AS image_path
            FROM offers o
            JOIN cars c ON c.id = o.car_id
            WHERE o.is_active = 1 AND c.is_active = 1
            ORDER BY o.sort_order ASC, o.id DESC";

    try {
        return db()->query($sql)->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

function offers_by_car(int $carId): array
{
    if ($carId <= 0) {
        return [];
    }

    $sql = "SELECT *
            FROM offers
            WHERE car_id = :id AND is_active = 1
              AND (expires_at IS NULL OR expires_at >= CURDATE())
            ORDER BY sort_order ASC, id DESC";
    try {
        $stmt = db()->prepare($sql);
        $stmt->execute([':id' => $carId]);
        return $stmt->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

function cars_active(): array
{
    $sql = "SELECT c.*, (
                SELECT ci.file_path
                FROM car_images ci
                WHERE ci.car_id = c.id
                ORDER BY ci.is_primary DESC, ci.sort_order ASC, ci.id ASC
                LIMIT 1
            ) AS image_path
            FROM cars c
            WHERE c.is_active = 1
            ORDER BY c.is_offer DESC, c.id DESC";

    try {
        return db()->query($sql)->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

function car_find(int $id): ?array
{
    if ($id <= 0) {
        return null;
    }

    $sql = "SELECT c.*, (
                SELECT ci.file_path
                FROM car_images ci
                WHERE ci.car_id = c.id
                ORDER BY ci.is_primary DESC, ci.sort_order ASC, ci.id ASC
                LIMIT 1
            ) AS image_path
            FROM cars c
            WHERE c.id = :id
            LIMIT 1";

    try {
        $stmt = db()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $car = $stmt->fetch();
        return $car ?: null;
    } catch (Throwable $e) {
        return null;
    }
}

function car_images(int $carId): array
{
    try {
        $stmt = db()->prepare('SELECT id, file_path, sort_order, is_primary FROM car_images WHERE car_id = :id ORDER BY is_primary DESC, sort_order ASC, id ASC');
        $stmt->execute([':id' => $carId]);
        return $stmt->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

function offer_media_items(int $offerId): array
{
    if ($offerId <= 0) {
        return [];
    }

    try {
        $stmt = db()->prepare('SELECT id, type, file_path, video_url, sort_order, is_primary FROM offer_media WHERE offer_id = :id ORDER BY is_primary DESC, sort_order ASC, id ASC');
        $stmt->execute([':id' => $offerId]);
        return $stmt->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

function offer_media_images(int $offerId): array
{
    $items = offer_media_items($offerId);
    $out = [];
    foreach ($items as $it) {
        if (($it['type'] ?? '') !== 'image') {
            continue;
        }
        $path = trim((string)($it['file_path'] ?? ''));
        if ($path === '') {
            continue;
        }
        $out[] = $it;
    }
    return $out;
}

function offer_media_videos(int $offerId): array
{
    $items = offer_media_items($offerId);
    $out = [];
    foreach ($items as $it) {
        if (($it['type'] ?? '') !== 'video') {
            continue;
        }
        $url = trim((string)($it['video_url'] ?? ''));
        $path = trim((string)($it['file_path'] ?? ''));
        if ($url === '' && $path === '') {
            continue;
        }
        $out[] = $it;
    }
    return $out;
}

function car_images_limited(int $carId, int $limit = 7): array
{
    static $cache = [];
    $carId = (int)$carId;
    $limit = (int)$limit;
    if ($carId <= 0) {
        return [];
    }
    if ($limit <= 0) {
        $limit = 7;
    }

    $key = $carId . ':' . $limit;
    if (isset($cache[$key]) && is_array($cache[$key])) {
        return $cache[$key];
    }

    $sql = 'SELECT id, file_path, sort_order, is_primary FROM car_images WHERE car_id = :id ORDER BY is_primary DESC, sort_order ASC, id ASC LIMIT ' . $limit;
    try {
        $stmt = db()->prepare($sql);
        $stmt->execute([':id' => $carId]);
        $cache[$key] = $stmt->fetchAll();
    } catch (Throwable $e) {
        $cache[$key] = [];
    }

    return $cache[$key];
}

function base_url(): string
{
    $configured = trim((string)setting('site_url', ''));
    if ($configured !== '') {
        return rtrim($configured, '/');
    }

    if (PHP_SAPI === 'cli' || !isset($_SERVER['HTTP_HOST'])) {
        return '';
    }

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = (string)$_SERVER['HTTP_HOST'];

    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? (string)$_SERVER['DOCUMENT_ROOT'] : '';
    $projectRoot = realpath(__DIR__ . '/..');
    if ($docRoot !== '' && $projectRoot !== false) {
        $docRootReal = realpath($docRoot);
        if ($docRootReal !== false) {
            $docRootReal = str_replace('\\', '/', $docRootReal);
            $projectRootUrl = str_replace('\\', '/', (string)$projectRoot);
            if (stripos($projectRootUrl, $docRootReal) === 0) {
                $rel = substr($projectRootUrl, strlen($docRootReal));
                $rel = '/' . ltrim((string)$rel, '/');
                return $scheme . '://' . $host . rtrim($rel, '/');
            }
        }
    }

    $scriptName = (string)($_SERVER['SCRIPT_NAME'] ?? '/');
    $dir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
    if ($dir === '') {
        $dir = '/';
    }

    return $scheme . '://' . $host . $dir;
}

function car_url(int $id): string
{
    return 'car.php?id=' . $id;
}

function abs_url(string $path): string
{
    $base = base_url();
    if ($base === '') {
        return $path;
    }
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

function car_features(array $car): array
{
    $lang = current_lang();
    $key = $lang === 'ar' ? 'features_ar' : 'features_en';
    $raw = (string)($car[$key] ?? '');
    $raw = trim($raw);
    if ($raw === '') {
        return [];
    }
    $parts = array_map('trim', explode('|', $raw));
    return array_values(array_filter($parts, static fn($x) => $x !== ''));
}

function car_name(array $car): string
{
    return current_lang() === 'ar' ? (string)$car['name_ar'] : (string)$car['name_en'];
}

function car_type(array $car): string
{
    return current_lang() === 'ar' ? (string)$car['type_ar'] : (string)$car['type_en'];
}

function car_offer_details(array $car): string
{
    $lang = current_lang();
    return $lang === 'ar' ? (string)($car['offer_details_ar'] ?? '') : (string)($car['offer_details_en'] ?? '');
}

function offer_title(array $offer): string
{
    $lang = current_lang();
    $t = $lang === 'ar' ? (string)($offer['title_ar'] ?? '') : (string)($offer['title_en'] ?? '');
    $t = trim($t);
    if ($t !== '') {
        return $t;
    }
    if (isset($offer['name_ar'], $offer['name_en'])) {
        return car_name($offer);
    }
    return '';
}

function offer_description(array $offer): string
{
    $lang = current_lang();
    $t = $lang === 'ar' ? (string)($offer['description_ar'] ?? '') : (string)($offer['description_en'] ?? '');
    return trim($t);
}

function company_name(): string
{
    $name = current_lang() === 'ar'
        ? setting('company_name_ar', 'شركة سوى لتأجير السيارات')
        : setting('company_name_en', 'Sawa Rent Car');
    return $name;
}

function company_address(): string
{
    $addr = current_lang() === 'ar'
        ? setting('company_address_ar', '')
        : setting('company_address_en', '');
    return $addr;
}

function company_working_hours(): string
{
    $hours = current_lang() === 'ar'
        ? setting('company_working_hours_ar', '')
        : setting('company_working_hours_en', '');
    return $hours;
}

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function send_whatsapp_notification(int $bookingId, array $booking): bool
{
    $lang = current_lang();
    $adminPhone = setting('whatsapp_admin_phone', setting('company_phone_1', ''));
    
    if (empty($adminPhone)) {
        return false;
    }
    
    $digits = preg_replace('/\D+/', '', $adminPhone);
    if ($digits !== '' && $digits[0] === '0') {
        $digits = '970' . substr($digits, 1);
    }
    
    $carName = '';
    if (!empty($booking['car_id'])) {
        try {
            $car = db()->query("SELECT name_ar, name_en FROM cars WHERE id = " . (int)$booking['car_id'])->fetch();
            if ($car) {
                $carName = $lang === 'ar' ? ($car['name_ar'] ?? '') : ($car['name_en'] ?? '');
            }
        } catch (Throwable $e) {}
    }
    
    $message = $lang === 'ar' 
        ? "🚗 *حجز جديد من سوا*\n\n"
        . "👤 *الاسم:* " . ($booking['customer_name'] ?? '') . "\n"
        . "📱 *الهاتف:* " . ($booking['phone'] ?? '') . "\n"
        . "🚙 *السيارة:* " . ($carName ?: 'لم تُحدد') . "\n"
        . "📅 *من:* " . ($booking['start_date'] ?? '') . "\n"
        . "📅 *إلى:* " . ($booking['end_date'] ?? '') . "\n"
        . "💰 *السعر:* " . ($booking['total_price'] ?? 0) . " ₪\n"
        . "📝 *ملاحظات:* " . ($booking['notes'] ?: 'لا توجد') . "\n\n"
        . "🔗 https://sawarentcar.com/admin/bookings.php?search=" . $bookingId
        : "🚗 *New Booking from Sawa*\n\n"
        . "👤 *Name:* " . ($booking['customer_name'] ?? '') . "\n"
        . "📱 *Phone:* " . ($booking['phone'] ?? '') . "\n"
        . "🚙 *Car:* " . ($carName ?: 'Not specified') . "\n"
        . "📅 *From:* " . ($booking['start_date'] ?? '') . "\n"
        . "📅 *To:* " . ($booking['end_date'] ?? '') . "\n"
        . "💰 *Price:* " . ($booking['total_price'] ?? 0) . " ILS\n"
        . "📝 *Notes:* " . ($booking['notes'] ?: 'None') . "\n\n"
        . "🔗 https://sawarentcar.com/admin/bookings.php?search=" . $bookingId;
    
    $encodedMessage = rawurlencode($message);
    $whatsappUrl = "https://wa.me/{$digits}?text={$encodedMessage}";
    
    return true;
}

function get_whatsapp_link(string $message = ''): string
{
    $phone = setting('company_phone_1', '');
    $digits = preg_replace('/\D+/', '', $phone);
    if ($digits !== '' && $digits[0] === '0') {
        $digits = '970' . substr($digits, 1);
    }
    
    $encodedMessage = rawurlencode($message);
    return "https://wa.me/{$digits}?text={$encodedMessage}";
}

