<?php

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=export_' . date('Y-m-d') . '.csv');

$type = $_GET['type'] ?? 'bookings';
$format = $_GET['format'] ?? 'csv';

if ($format === 'json') {
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename=export_' . date('Y-m-d') . '.json');
}

function cleanForCsv($value) {
    if ($value === null) return '';
    $value = (string)$value;
    if (strpos($value, ',') !== false || strpos($value, '"') !== false || strpos($value, "\n") !== false) {
        return '"' . str_replace('"', '""', $value) . '"';
    }
    return $value;
}

if ($type === 'bookings') {
    $bookings = [];
    try {
        $sql = "SELECT b.*, c.name_ar, c.name_en
                FROM bookings b
                LEFT JOIN cars c ON c.id = b.car_id
                ORDER BY b.id DESC";
        $bookings = db()->query($sql)->fetchAll();
    } catch (Throwable $e) {
        $bookings = [];
    }

    if ($format === 'json') {
        $output = [];
        foreach ($bookings as $b) {
            $output[] = [
                'id' => (int)$b['id'],
                'car' => $b['name_ar'] ?? $b['name_en'] ?? 'غير محدد',
                'customer_name' => $b['customer_name'],
                'phone' => $b['phone'],
                'start_date' => $b['start_date'],
                'end_date' => $b['end_date'],
                'total_price' => (float)$b['total_price'],
                'status' => $b['status'],
                'notes' => $b['notes'],
                'created_at' => $b['created_at'],
            ];
        }
        echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    $headers = ['ID', 'السيارة', 'اسم العميل', 'الهاتف', 'تاريخ الاستلام', 'تاريخ التسليم', 'السعر', 'الحالة', 'ملاحظات', 'تاريخ الإنشاء'];
    echo "\xEF\xBB\xBF";
    $output = fopen('php://output', 'w');
    fputcsv($output, $headers, ',');
    
    $statusLabels = [
        'new' => 'جديد',
        'contacted' => 'تم التواصل',
        'confirmed' => 'مؤكد',
        'cancelled' => 'ملغى'
    ];
    
    foreach ($bookings as $b) {
        $row = [
            $b['id'],
            $b['name_ar'] ?? $b['name_en'] ?? 'غير محدد',
            $b['customer_name'],
            $b['phone'],
            $b['start_date'],
            $b['end_date'],
            $b['total_price'] . ' ₪',
            $statusLabels[$b['status']] ?? $b['status'],
            $b['notes'],
            $b['created_at']
        ];
        fputcsv($output, $row, ',');
    }
    fclose($output);
    exit;
}

if ($type === 'cars') {
    $cars = [];
    try {
        $sql = "SELECT c.*, 
                (SELECT COUNT(*) FROM car_images WHERE car_id = c.id) as image_count,
                (SELECT COUNT(*) FROM bookings WHERE car_id = c.id) as booking_count
                FROM cars c
                ORDER BY c.id DESC";
        $cars = db()->query($sql)->fetchAll();
    } catch (Throwable $e) {
        $cars = [];
    }

    if ($format === 'json') {
        $output = [];
        foreach ($cars as $c) {
            $output[] = [
                'id' => (int)$c['id'],
                'name_ar' => $c['name_ar'],
                'name_en' => $c['name_en'],
                'type' => $c['type_ar'] ?? $c['type_en'],
                'daily_price' => (float)$c['daily_price'],
                'monthly_price' => (float)$c['monthly_price'],
                'is_active' => (bool)$c['is_active'],
                'is_offer' => (bool)$c['is_offer'],
                'image_count' => (int)$c['image_count'],
                'booking_count' => (int)$c['booking_count'],
                'created_at' => $c['created_at'],
            ];
        }
        echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    $headers = ['ID', 'الاسم (AR)', 'الاسم (EN)', 'النوع', 'السعر اليومي', 'السعر الشهري', 'نشط', 'عرض خاص', 'عدد الصور', 'عدد الحجوزات'];
    echo "\xEF\xBB\xBF";
    $output = fopen('php://output', 'w');
    fputcsv($output, $headers, ',');
    
    foreach ($cars as $c) {
        $row = [
            $c['id'],
            $c['name_ar'],
            $c['name_en'],
            $c['type_ar'] ?? $c['type_en'] ?? '',
            $c['daily_price'] . ' ₪',
            $c['monthly_price'] . ' ₪',
            $c['is_active'] ? 'نعم' : 'لا',
            $c['is_offer'] ? 'نعم' : 'لا',
            $c['image_count'],
            $c['booking_count']
        ];
        fputcsv($output, $row, ',');
    }
    fclose($output);
    exit;
}

if ($type === 'offers') {
    $offers = [];
    try {
        $sql = "SELECT o.*, c.name_ar, c.name_en
                FROM offers o
                LEFT JOIN cars c ON c.id = o.car_id
                ORDER BY o.id DESC";
        $offers = db()->query($sql)->fetchAll();
    } catch (Throwable $e) {
        $offers = [];
    }

    if ($format === 'json') {
        $output = [];
        foreach ($offers as $o) {
            $output[] = [
                'id' => (int)$o['id'],
                'car' => $o['name_ar'] ?? $o['name_en'] ?? 'غير محدد',
                'title' => $o['title_ar'] ?? $o['title_en'],
                'days' => (int)$o['days'],
                'daily_price' => (float)$o['daily_price'],
                'is_active' => (bool)$o['is_active'],
            ];
        }
        echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    $headers = ['ID', 'السيارة', 'العنوان', 'الأيام', 'السعر اليومي', 'نشط'];
    echo "\xEF\xBB\xBF";
    $output = fopen('php://output', 'w');
    fputcsv($output, $headers, ',');
    
    foreach ($offers as $o) {
        $row = [
            $o['id'],
            $o['name_ar'] ?? $o['name_en'] ?? '',
            $o['title_ar'] ?? $o['title_en'] ?? '',
            $o['days'],
            $o['daily_price'] . ' ₪',
            $o['is_active'] ? 'نعم' : 'لا'
        ];
        fputcsv($output, $row, ',');
    }
    fclose($output);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Invalid type']);
