<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin']);

$bookingId = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
if ($bookingId <= 0) {
    header('Location: bookings.php');
    exit;
}

try {
    $stmt = db()->prepare("SELECT reference FROM payments WHERE booking_id = :id AND status = 'pending' ORDER BY id DESC LIMIT 1");
    $stmt->execute([':id' => $bookingId]);
    $existing = $stmt->fetch();
    if ($existing && trim((string)($existing['reference'] ?? '')) !== '') {
        header('Location: booking_invoice.php?id=' . (int)$bookingId . '&pay_ref=' . urlencode((string)$existing['reference']));
        exit;
    }
} catch (Throwable $e) {
}

$sql = "SELECT b.*, 
            c.name_ar AS car_name_ar, c.name_en AS car_name_en,
            c.daily_price AS car_daily_price,
            o.title_ar AS offer_title_ar, o.title_en AS offer_title_en, o.daily_price AS offer_daily_price, o.days AS offer_days
        FROM bookings b
        LEFT JOIN cars c ON c.id = b.car_id
        LEFT JOIN offers o ON o.id = b.offer_id
        WHERE b.id = :id
        LIMIT 1";
$stmt = db()->prepare($sql);
$stmt->execute([':id' => $bookingId]);
$b = $stmt->fetch();

if (!$b) {
    header('Location: bookings.php');
    exit;
}

$start = (string)($b['start_date'] ?? '');
$end = (string)($b['end_date'] ?? '');
$days = 1;
if ($start !== '' && $end !== '') {
    try {
        $d1 = new DateTime($start);
        $d2 = new DateTime($end);
        $diffDays = (int)$d1->diff($d2)->format('%a');
        $days = max(1, $diffDays + 1);
    } catch (Throwable $e) {
        $days = 1;
    }
}

$unitPrice = 0.0;
$qty = $days;

if (!empty($b['offer_id']) && (float)($b['offer_daily_price'] ?? 0) > 0) {
    $unitPrice = (float)$b['offer_daily_price'];
    $pkgDays = (int)($b['offer_days'] ?? 0);
    if ($pkgDays > 0) {
        $qty = $pkgDays;
    }
} elseif ((float)($b['car_daily_price'] ?? 0) > 0) {
    $unitPrice = (float)$b['car_daily_price'];
}

$amount = $unitPrice * (float)$qty;
if ($amount < 0) {
    $amount = 0;
}

$ref = bin2hex(random_bytes(16));
try {
    $stmt = db()->prepare('INSERT INTO payments (booking_id, amount, currency, status, reference) VALUES (:booking_id, :amount, :currency, :status, :reference)');
    $stmt->execute([
        ':booking_id' => $bookingId,
        ':amount' => $amount,
        ':currency' => 'ILS',
        ':status' => 'pending',
        ':reference' => $ref,
    ]);
} catch (Throwable $e) {
    header('Location: booking_invoice.php?id=' . (int)$bookingId);
    exit;
}

header('Location: booking_invoice.php?id=' . (int)$bookingId . '&pay_ref=' . urlencode($ref));
exit;
