<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (wants_json()) {
        http_response_code(405);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'ok' => false,
            'message' => current_lang() === 'ar' ? 'طريقة الطلب غير صحيحة.' : 'Invalid request method.',
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
    header('Location: index.php');
    exit;
}

$jsonResponse = static function (array $payload, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
};

$back = isset($_SERVER['HTTP_REFERER']) && is_string($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''
    ? (string)$_SERVER['HTTP_REFERER']
    : 'index.php';

$backHost = (string)(parse_url($back, PHP_URL_HOST) ?? '');
$serverHost = isset($_SERVER['HTTP_HOST']) ? (string)$_SERVER['HTTP_HOST'] : '';
if ($backHost !== '' && $serverHost !== '' && strcasecmp($backHost, $serverHost) !== 0) {
    $back = 'index.php';
}

$sep = (strpos($back, '?') !== false) ? '&' : '?';

$carId = isset($_POST['car_id']) ? (int)$_POST['car_id'] : null;
$offerId = isset($_POST['offer_id']) ? (int)$_POST['offer_id'] : null;
$customerName = trim((string)($_POST['customer_name'] ?? ''));
$phone = trim((string)($_POST['phone'] ?? ''));
$startDate = ($_POST['start_date'] ?? null) ?: null;
$endDate = ($_POST['end_date'] ?? null) ?: null;
$notes = trim((string)($_POST['notes'] ?? ''));
$totalPrice = isset($_POST['selected_price']) ? (float)$_POST['selected_price'] : 0;
$numDays = isset($_POST['selected_days']) ? (int)$_POST['selected_days'] : 1;

if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    if (wants_json()) {
        $jsonResponse([
            'ok' => false,
            'message' => current_lang() === 'ar' ? 'رمز الحماية غير صالح. أعد تحميل الصفحة وحاول مرة أخرى.' : 'Security token is invalid. Please refresh and try again.',
        ], 400);
    }
    header('Location: ' . $back . $sep . 'sent=0');
    exit;
}

if ($customerName === '' || $phone === '') {
    if (wants_json()) {
        $jsonResponse([
            'ok' => false,
            'message' => current_lang() === 'ar' ? 'يرجى تعبئة الاسم ورقم الهاتف.' : 'Please enter your name and phone number.',
        ], 422);
    }
    header('Location: ' . $back . $sep . 'sent=0');
    exit;
}

$phoneDigits = preg_replace('/\D+/', '', $phone);
if ($phoneDigits === '' || strlen($phoneDigits) < 9 || strlen($phoneDigits) > 15) {
    if (wants_json()) {
        $jsonResponse([
            'ok' => false,
            'message' => current_lang() === 'ar' ? 'رقم الهاتف غير صحيح.' : 'Invalid phone number.',
        ], 422);
    }
    header('Location: ' . $back . $sep . 'sent=0');
    exit;
}

if (!$startDate || !$endDate || strtotime((string)$endDate) < strtotime((string)$startDate)) {
    if (wants_json()) {
        $jsonResponse([
            'ok' => false,
            'message' => current_lang() === 'ar' ? 'الرجاء التأكد من التواريخ.' : 'Please check the dates.',
        ], 422);
    }
    header('Location: ' . $back . $sep . 'sent=0');
    exit;
}

$saveUpload = static function (string $field): ?string {
    if (!isset($_FILES[$field]) || !is_array($_FILES[$field])) {
        return null;
    }
    $f = $_FILES[$field];
    if (($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }
    $tmp = (string)($f['tmp_name'] ?? '');
    if ($tmp === '' || !is_uploaded_file($tmp)) {
        return null;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = (string)($finfo->file($tmp) ?: '');
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];
    if (!isset($allowed[$mime])) {
        return null;
    }

    $name = 'booking_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $allowed[$mime];
    $dest = rtrim(UPLOADS_DIR, '/\\') . DIRECTORY_SEPARATOR . $name;
    if (!@move_uploaded_file($tmp, $dest)) {
        return null;
    }

    return rtrim(UPLOADS_URL, '/') . '/' . $name;
};

$idImagePath = $saveUpload('id_image');
$licenseImagePath = $saveUpload('license_image');
if ($idImagePath === null || $licenseImagePath === null) {
    if (wants_json()) {
        $jsonResponse([
            'ok' => false,
            'message' => current_lang() === 'ar' ? 'الرجاء رفع صور الهوية والرخصة بصيغة صحيحة.' : 'Please upload valid ID and license images.',
        ], 422);
    }
    header('Location: ' . $back . $sep . 'sent=0');
    exit;
}

try {
    $stmt = db()->prepare('INSERT INTO bookings (car_id, offer_id, customer_name, phone, start_date, end_date, notes, id_image_path, license_image_path, total_price, num_days) VALUES (:car_id, :offer_id, :customer_name, :phone, :start_date, :end_date, :notes, :id_image_path, :license_image_path, :total_price, :num_days)');
    $stmt->execute([
        ':car_id' => ($carId && $carId > 0) ? $carId : null,
        ':offer_id' => ($offerId && $offerId > 0) ? $offerId : null,
        ':customer_name' => $customerName,
        ':phone' => $phone,
        ':start_date' => $startDate,
        ':end_date' => $endDate,
        ':notes' => $notes,
        ':id_image_path' => $idImagePath,
        ':license_image_path' => $licenseImagePath,
        ':total_price' => $totalPrice,
        ':num_days' => $numDays,
    ]);
} catch (Throwable $e) {
    $stmt = db()->prepare('INSERT INTO bookings (car_id, customer_name, phone, start_date, end_date, notes, total_price, num_days) VALUES (:car_id, :customer_name, :phone, :start_date, :end_date, :notes, :total_price, :num_days)');
    $stmt->execute([
        ':car_id' => ($carId && $carId > 0) ? $carId : null,
        ':customer_name' => $customerName,
        ':phone' => $phone,
        ':start_date' => $startDate,
        ':end_date' => $endDate,
        ':notes' => $notes,
        ':total_price' => $totalPrice,
        ':num_days' => $numDays,
    ]);
}

$newId = 0;
try {
    $newId = (int)db()->lastInsertId();
} catch (Throwable $e) {
    $newId = 0;
}

if ($newId > 0) {
    try {
        send_whatsapp_notification($newId, [
            'car_id' => $carId,
            'customer_name' => $customerName,
            'phone' => $phone,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice,
            'notes' => $notes,
        ]);
    } catch (Throwable $e) {}

    if (wants_json()) {
        $jsonResponse([
            'ok' => true,
            'id' => $newId,
            'redirect' => 'booking_success.php?id=' . (int)$newId,
            'message' => current_lang() === 'ar' ? 'تم إرسال طلبك بنجاح وسيتم التواصل معك قريباً.' : 'Your request has been sent successfully. We will contact you soon.',
        ]);
    }
    header('Location: booking_success.php?id=' . (int)$newId);
    exit;
}

if (wants_json()) {
    $jsonResponse([
        'ok' => true,
        'id' => 0,
        'redirect' => $back . $sep . 'sent=1',
        'message' => current_lang() === 'ar' ? 'تم إرسال طلبك بنجاح وسيتم التواصل معك قريباً.' : 'Your request has been sent successfully. We will contact you soon.',
    ]);
}

header('Location: ' . $back . $sep . 'sent=1');
exit;
