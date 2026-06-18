<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin']);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT b.*, 
            c.name_ar AS car_name_ar, c.name_en AS car_name_en,
            c.daily_price AS car_daily_price, c.monthly_price AS car_monthly_price,
            o.title_ar AS offer_title_ar, o.title_en AS offer_title_en, o.daily_price AS offer_daily_price, o.days AS offer_days
        FROM bookings b
        LEFT JOIN cars c ON c.id = b.car_id
        LEFT JOIN offers o ON o.id = b.offer_id
        WHERE b.id = :id
        LIMIT 1";
$stmt = db()->prepare($sql);
$stmt->execute([':id' => $id]);
$b = $stmt->fetch();

if (!$b) {
    http_response_code(404);
    echo 'Not found';
    exit;
}

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

$carName = $lang === 'ar' ? (string)($b['car_name_ar'] ?? '') : (string)($b['car_name_en'] ?? '');
$offerTitle = $lang === 'ar' ? (string)($b['offer_title_ar'] ?? '') : (string)($b['offer_title_en'] ?? '');

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

$lineLabel = $carName !== '' ? $carName : 'Car Rental';
$unitPrice = 0.0;
$qty = $days;
$savedTotal = (float)($b['total_price'] ?? 0);
$savedDays = (int)($b['num_days'] ?? 0);

if ($savedTotal > 0 && $savedDays > 0) {
    $unitPrice = $savedTotal / $savedDays;
    $qty = $savedDays;
    $lineLabel = $lang === 'ar' ? 'تأجير سيارة - صفقة خاصة' : 'Car Rental - Special Deal';
} elseif (!empty($b['offer_id']) && (float)($b['offer_daily_price'] ?? 0) > 0) {
    $unitPrice = (float)$b['offer_daily_price'];
    $pkgDays = (int)($b['offer_days'] ?? 0);
    if ($pkgDays > 0) {
        $qty = $pkgDays;
    }
    if (trim($offerTitle) !== '') {
        $lineLabel .= ' - ' . $offerTitle;
    }
} elseif ((float)($b['car_daily_price'] ?? 0) > 0) {
    $unitPrice = (float)$b['car_daily_price'];
}

$total = $unitPrice * (float)$qty;

$logo = trim(setting('site_logo', ''));
if ($logo === '') {
    $logo = is_file(__DIR__ . '/../unnamed (1).jpg') ? 'unnamed (1).jpg' : '';
}

$invoiceNo = 'INV-' . (int)$b['id'];
$invoiceDate = date('Y-m-d');

$payRef = trim((string)($_GET['pay_ref'] ?? ''));
$payment = null;
try {
    if ($payRef !== '') {
        $stp = db()->prepare('SELECT * FROM payments WHERE booking_id = :bid AND reference = :ref LIMIT 1');
        $stp->execute([':bid' => (int)$b['id'], ':ref' => $payRef]);
        $payment = $stp->fetch() ?: null;
    }
    if (!$payment) {
        $stp = db()->prepare('SELECT * FROM payments WHERE booking_id = :bid ORDER BY id DESC LIMIT 1');
        $stp->execute([':bid' => (int)$b['id']]);
        $payment = $stp->fetch() ?: null;
    }
} catch (Throwable $e) {
    $payment = null;
}

function money_fmt(float $n): string
{
    return number_format($n, 2);
}

?><!doctype html>
<html lang="<?= e($lang) ?>" dir="<?= e($dir) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice <?= e($invoiceNo) ?> - <?= e(company_name()) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <?php if (is_rtl()): ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <?php else: ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>

    <style>
        body { font-family: <?= is_rtl() ? 'Cairo' : 'Inter' ?>, system-ui, -apple-system, "Segoe UI", Arial, sans-serif; background: #f6f7fb; }
        .paper { max-width: 980px; margin: 24px auto; background: #fff; border: 1px solid rgba(15, 23, 42, .08); border-radius: 18px; box-shadow: 0 18px 45px rgba(2, 6, 23, .08); overflow: hidden; }
        .top { padding: 18px 22px; background: linear-gradient(180deg, rgba(2,35,88,.08), rgba(246,247,251,0)); }
        .logo { width: 56px; height: 56px; object-fit: contain; background: #fff; border-radius: 14px; padding: 5px; border: 1px solid rgba(15, 23, 42, .08); }
        .k { color: rgba(15, 23, 42, .65); font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .05em; }
        .v { font-weight: 700; }
        .table th { font-size: 12px; letter-spacing: .06em; text-transform: uppercase; }
        .badge-soft { background: rgba(2,35,88,.08); color: #022358; border: 1px solid rgba(2,35,88,.12); }
        @media print {
            body { background: #fff; }
            .paper { margin: 0; box-shadow: none; border: 0; border-radius: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="paper">
    <div class="top">
        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3">
                <?php if ($logo !== ''): ?>
                    <img class="logo" src="<?= e(asset_url('../' . ltrim($logo, '/'))) ?>" alt="logo">
                <?php endif; ?>
                <div>
                    <div class="h4 fw-bold m-0"><?= e(company_name()) ?></div>
                    <div class="text-secondary small"><?= e(company_address()) ?></div>
                    <div class="small" dir="ltr">
                        <?= e(setting('company_phone_1', '')) ?>
                        <?php if (trim(setting('company_phone_2', '')) !== ''): ?>
                            - <?= e(setting('company_phone_2', '')) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <div class="h5 fw-bold mb-1">Invoice</div>
                <div class="small"><span class="k">No</span> <span class="v"><?= e($invoiceNo) ?></span></div>
                <div class="small"><span class="k">Date</span> <span class="v"><?= e($invoiceDate) ?></span></div>
                <div class="mt-2">
                    <span class="badge badge-soft">Status: <?= e((string)($b['status'] ?? '')) ?></span>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3 no-print">
            <a class="btn btn-outline-secondary btn-sm" href="booking_edit.php?id=<?= (int)$b['id'] ?>">تعديل</a>
            <a class="btn btn-outline-secondary btn-sm" href="bookings.php">رجوع</a>
            <a class="btn btn-primary btn-sm" href="payment_create.php?booking_id=<?= (int)$b['id'] ?>">إنشاء رابط دفع</a>
            <button class="btn btn-primary btn-sm" onclick="window.print()">طباعة</button>
        </div>

        <?php
        $payUrl = '';
        if (is_array($payment) && trim((string)($payment['reference'] ?? '')) !== '') {
            $payUrl = abs_url('pay.php?ref=' . (string)$payment['reference']);
        }

        $customerPhoneRaw = trim((string)($b['phone'] ?? ''));
        $customerPhoneDigits = preg_replace('/\D+/', '', $customerPhoneRaw);
        $waTo = '';
        if ($customerPhoneDigits !== '') {
            if (strpos($customerPhoneDigits, '970') === 0) {
                $waTo = $customerPhoneDigits;
            } elseif (strpos($customerPhoneDigits, '0') === 0) {
                $waTo = '970' . substr($customerPhoneDigits, 1);
            } else {
                $waTo = $customerPhoneDigits;
            }
        }

        $waText = 'رابط الدفع لحجز رقم #' . (int)$b['id'] . "\n" . $payUrl;
        $waUrl = $payUrl !== '' ? ('https://wa.me/' . urlencode($waTo) . '?text=' . urlencode($waText)) : '';
        ?>

        <?php if ($payUrl !== ''): ?>
            <div class="mt-3 no-print">
                <div class="alert alert-info mb-0">
                    <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                        <div>
                            <div class="fw-bold">رابط الدفع جاهز</div>
                            <div class="text-secondary small">الحالة: <?= e((string)($payment['status'] ?? 'pending')) ?><?= trim((string)($payment['method'] ?? '')) !== '' ? ' - ' . e((string)$payment['method']) : '' ?></div>
                            <div class="small mt-1 text-break" dir="ltr"><a class="text-break" href="<?= e($payUrl) ?>" target="_blank" rel="noopener"><?= e($payUrl) ?></a></div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-outline-secondary btn-sm" type="button" data-copy="<?= e($payUrl) ?>">نسخ الرابط</button>
                            <?php if ($waUrl !== ''): ?>
                                <a class="btn btn-success btn-sm" href="<?= e($waUrl) ?>" target="_blank" rel="noopener">واتساب</a>
                            <?php endif; ?>
                            <a class="btn btn-outline-primary btn-sm" href="<?= e($payUrl) ?>" target="_blank" rel="noopener">فتح صفحة الدفع</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="p-4">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="k">Customer</div>
                <div class="v"><?= e((string)($b['customer_name'] ?? '')) ?></div>
                <div class="text-secondary" dir="ltr"><?= e((string)($b['phone'] ?? '')) ?></div>
            </div>
            <div class="col-md-6">
                <div class="k">Booking</div>
                <div class="v">#<?= (int)$b['id'] ?></div>
                <div class="text-secondary small">
                    <?= e($start) ?>
                    <?php if ($end !== ''): ?>
                        - <?= e($end) ?>
                    <?php endif; ?>
                    (<?= (int)$days ?> day)
                </div>
            </div>
        </div>

        <div class="card border-0" style="background: rgba(2,35,88,.04);">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="k">Car / Offer</div>
                        <div class="v"><?= e($lineLabel) ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="k">Notes</div>
                        <div class="v"><?= e(trim((string)($b['notes'] ?? '')) !== '' ? (string)$b['notes'] : '-') ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="width:120px;">Qty</th>
                        <th style="width:160px;">Unit</th>
                        <th style="width:160px;" class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= e($lineLabel) ?></td>
                        <td><?= (int)$qty ?></td>
                        <td><?= e(money_fmt($unitPrice)) ?></td>
                        <td class="text-end fw-bold"><?= e(money_fmt($total)) ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Grand Total</td>
                        <td class="text-end fw-bold"><?= e(money_fmt($total)) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <?php
        $idImg = trim((string)($b['id_image_path'] ?? ''));
        $licImg = trim((string)($b['license_image_path'] ?? ''));
        ?>

        <?php if ($idImg !== '' || $licImg !== ''): ?>
            <div class="mt-4">
                <div class="k mb-2">Attachments</div>
                <div class="d-flex gap-3 flex-wrap">
                    <?php if ($idImg !== ''): ?>
                        <a href="<?= e(asset_url('../' . ltrim($idImg, '/'))) ?>" target="_blank" rel="noopener" class="text-decoration-none">
                            <div class="small text-secondary mb-1">ID</div>
                            <img src="<?= e(asset_url('../' . ltrim($idImg, '/'))) ?>" alt="id" style="width:140px; height:140px; object-fit:cover; border-radius:16px; border:1px solid rgba(15,23,42,.08);">
                        </a>
                    <?php endif; ?>
                    <?php if ($licImg !== ''): ?>
                        <a href="<?= e(asset_url('../' . ltrim($licImg, '/'))) ?>" target="_blank" rel="noopener" class="text-decoration-none">
                            <div class="small text-secondary mb-1">License</div>
                            <img src="<?= e(asset_url('../' . ltrim($licImg, '/'))) ?>" alt="license" style="width:140px; height:140px; object-fit:cover; border-radius:16px; border:1px solid rgba(15,23,42,.08);">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="text-secondary small mt-4">© <?= (int)date('Y') ?> <?= e(company_name()) ?></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        document.addEventListener('click', async function (e) {
            var btn = e.target && e.target.closest ? e.target.closest('[data-copy]') : null;
            if (!btn) return;
            var text = btn.getAttribute('data-copy') || '';
            if (!text) return;
            try {
                await navigator.clipboard.writeText(text);
                btn.textContent = 'تم النسخ';
                setTimeout(function () { btn.textContent = 'نسخ الرابط'; }, 1200);
            } catch (err) {
                try {
                    var ta = document.createElement('textarea');
                    ta.value = text;
                    ta.setAttribute('readonly', 'readonly');
                    ta.style.position = 'fixed';
                    ta.style.left = '-9999px';
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                    btn.textContent = 'تم النسخ';
                    setTimeout(function () { btn.textContent = 'نسخ الرابط'; }, 1200);
                } catch (e2) {
                }
            }
        });
    })();
</script>
</body>
</html>
