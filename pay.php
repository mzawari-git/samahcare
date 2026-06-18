<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

$ref = trim((string)($_GET['ref'] ?? ''));
if ($ref === '' || !preg_match('/^[a-f0-9]{16,128}$/i', $ref)) {
    http_response_code(404);
    $not_found_title = current_lang() === 'ar' ? 'الدفع غير موجود' : 'Payment not found';
    $not_found_message = current_lang() === 'ar' ? 'رابط الدفع غير صحيح.' : 'Invalid payment link.';
    include __DIR__ . '/404.php';
    exit;
}

$stmt = db()->prepare('SELECT * FROM payments WHERE reference = :ref LIMIT 1');
$stmt->execute([':ref' => $ref]);
$pay = $stmt->fetch();

if (!$pay) {
    http_response_code(404);
    $not_found_title = current_lang() === 'ar' ? 'الدفع غير موجود' : 'Payment not found';
    $not_found_message = current_lang() === 'ar' ? 'عملية الدفع غير موجودة.' : 'Payment record not found.';
    include __DIR__ . '/404.php';
    exit;
}

$booking = null;
$bookingId = (int)($pay['booking_id'] ?? 0);
if ($bookingId > 0) {
    $sql = "SELECT b.*, c.name_ar AS car_name_ar, c.name_en AS car_name_en, o.title_ar AS offer_title_ar, o.title_en AS offer_title_en
            FROM bookings b
            LEFT JOIN cars c ON c.id = b.car_id
            LEFT JOIN offers o ON o.id = b.offer_id
            WHERE b.id = :id
            LIMIT 1";
    $st = db()->prepare($sql);
    $st->execute([':id' => $bookingId]);
    $booking = $st->fetch();
}

$amount = (float)($pay['amount'] ?? 0);
$currency = (string)($pay['currency'] ?? 'ILS');
$status = (string)($pay['status'] ?? 'pending');

$method = (string)($pay['method'] ?? '');

$enableCards = setting('pay_enable_cards', '0') === '1';
$cardsProvider = trim(setting('pay_cards_provider', ''));
$cardsMode = trim(setting('pay_cards_mode', 'sandbox'));
$cardsConfigured = $cardsProvider !== ''
    && trim(setting('pay_cards_public_key', '')) !== ''
    && trim(setting('pay_cards_secret_key', '')) !== '';
$enableJawwal = setting('pay_enable_jawwal', '0') === '1';
$enablePalpay = setting('pay_enable_palpay', '0') === '1';
$enableBank = setting('pay_enable_bank', '0') === '1';
$enableCash = setting('pay_enable_cash', '0') === '1';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $status === 'pending') {
    $picked = trim((string)($_POST['method'] ?? ''));
    $allowed = [];
    if ($enableCards) {
        $allowed[] = 'card';
    }
    if ($enableJawwal) {
        $allowed[] = 'jawwal_pay';
    }
    if ($enablePalpay) {
        $allowed[] = 'palpay';
    }
    if ($enableBank) {
        $allowed[] = 'bank_transfer';
    }
    if ($enableCash) {
        $allowed[] = 'cash';
    }
    if (in_array($picked, $allowed, true)) {
        try {
            db()->prepare('UPDATE payments SET method = :m WHERE id = :id')->execute([
                ':m' => $picked,
                ':id' => (int)$pay['id'],
            ]);
            $method = $picked;
        } catch (Throwable $e) {
        }
    }
}

$page_title = current_lang() === 'ar' ? 'الدفع الآمن' : 'Secure Payment';
$page_description = company_name();
$page_image = '';

include __DIR__ . '/partials/header.php';

function money_fmt(float $n): string
{
    return number_format($n, 2);
}

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

$customer = $booking ? (string)($booking['customer_name'] ?? '') : '';
$phone = $booking ? (string)($booking['phone'] ?? '') : '';
$carName = '';
$offerTitle = '';
if ($booking) {
    $carName = $lang === 'ar' ? (string)($booking['car_name_ar'] ?? '') : (string)($booking['car_name_en'] ?? '');
    $offerTitle = $lang === 'ar' ? (string)($booking['offer_title_ar'] ?? '') : (string)($booking['offer_title_en'] ?? '');
}

$label = $carName !== '' ? $carName : ($lang === 'ar' ? 'حجز سيارة' : 'Car booking');
if (trim($offerTitle) !== '') {
    $label .= ' - ' . $offerTitle;
}

?>

<section class="py-5">
    <div class="container" dir="<?= e($dir) ?>">
        <div class="section-head mb-4">
            <div>
                <div class="section-kicker"><?= e($lang === 'ar' ? 'دفع آمن وسهل' : 'Safe & easy payment') ?></div>
                <h1 class="h3 fw-bold m-0"><?= e($lang === 'ar' ? 'إتمام الدفع' : 'Complete payment') ?></h1>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between gap-2 flex-wrap">
                            <div>
                                <div class="fw-bold mb-1"><?= e($lang === 'ar' ? 'اختر وسيلة الدفع' : 'Choose payment method') ?></div>
                                <div class="text-secondary small"><?= e($lang === 'ar' ? 'لن يتم حفظ بيانات البطاقة داخل الموقع.' : 'We never store card details on this website.') ?></div>
                            </div>
                            <span class="badge text-bg-secondary"><?= e($status) ?></span>
                        </div>

                        <?php if ($status !== 'pending'): ?>
                            <div class="alert alert-info mt-3 mb-0"><?= e($lang === 'ar' ? 'تم تحديث حالة الدفع. إذا كنت بحاجة للمساعدة تواصل معنا.' : 'Payment status updated. Contact us if you need help.') ?></div>
                        <?php else: ?>
                            <form method="post" class="mt-3">
                                <div class="row g-3">
                                    <?php if ($enableCards): ?>
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-light w-100 text-start border" style="background: rgba(255,255,255,.06);" name="method" value="card" type="submit">
                                                <div class="fw-bold">Visa / MasterCard</div>
                                                <div class="text-secondary small">
                                                    <?php if ($cardsConfigured): ?>
                                                        <?= e($lang === 'ar' ? ('بوابة الدفع: ' . $cardsProvider . ' (' . $cardsMode . ')') : ('Gateway: ' . $cardsProvider . ' (' . $cardsMode . ')')) ?>
                                                    <?php else: ?>
                                                        <?= e($lang === 'ar' ? 'تم تفعيل البطاقات لكن بيانات البوابة غير مكتملة في لوحة التحكم.' : 'Cards are enabled but gateway credentials are missing in Admin settings.') ?>
                                                    <?php endif; ?>
                                                </div>
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($enableJawwal): ?>
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-light w-100 text-start border" style="background: rgba(255,255,255,.06);" name="method" value="jawwal_pay" type="submit">
                                                <div class="fw-bold"><?= e($lang === 'ar' ? setting('pay_jawwal_label_ar', 'جوال باي') : setting('pay_jawwal_label_en', 'Jawwal Pay')) ?></div>
                                                <div class="text-secondary small"><?= e($lang === 'ar' ? 'وسيلة دفع محلية.' : 'Local payment method.') ?></div>
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($enablePalpay): ?>
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-light w-100 text-start border" style="background: rgba(255,255,255,.06);" name="method" value="palpay" type="submit">
                                                <div class="fw-bold"><?= e($lang === 'ar' ? setting('pay_palpay_label_ar', 'بال باي') : setting('pay_palpay_label_en', 'PalPay')) ?></div>
                                                <div class="text-secondary small"><?= e($lang === 'ar' ? 'محفظة دفع محلية.' : 'Local wallet.') ?></div>
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($enableBank): ?>
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-light w-100 text-start border" style="background: rgba(255,255,255,.06);" name="method" value="bank_transfer" type="submit">
                                                <div class="fw-bold"><?= e($lang === 'ar' ? setting('pay_bank_label_ar', 'تحويل بنكي') : setting('pay_bank_label_en', 'Bank transfer')) ?></div>
                                                <div class="text-secondary small"><?= e($lang === 'ar' ? 'تحويل بنكي مع إرسال إيصال الدفع.' : 'Bank transfer and send your receipt.') ?></div>
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($enableCash): ?>
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-light w-100 text-start border" style="background: rgba(255,255,255,.06);" name="method" value="cash" type="submit">
                                                <div class="fw-bold"><?= e($lang === 'ar' ? 'الدفع في الشركة' : 'Pay at office') ?></div>
                                                <div class="text-secondary small"><?= e($lang === 'ar' ? 'الدفع عند الاستلام في المكتب.' : 'Pay at our office.') ?></div>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </form>

                            <?php if ($method !== ''): ?>
                                <div class="alert alert-info mt-3 mb-0">
                                    <div class="fw-bold mb-1"><?= e($lang === 'ar' ? 'تم اختيار الوسيلة' : 'Method selected') ?>: <?= e($method) ?></div>
                                    <div class="text-secondary small">
                                        <?php
                                        $details = '';
                                        if ($method === 'card') {
                                            $details = $cardsProvider !== ''
                                                ? (($lang === 'ar' ? 'بوابة الدفع: ' : 'Gateway: ') . $cardsProvider . ' • ' . ($lang === 'ar' ? 'الوضع: ' : 'Mode: ') . $cardsMode)
                                                : '';
                                            if (!$cardsConfigured) {
                                                $details = $details !== '' ? ($details . "\n\n") : '';
                                                $details .= $lang === 'ar'
                                                    ? 'ملاحظة: بيانات بوابة الدفع غير مكتملة. يرجى إدخال مفاتيح API من لوحة التحكم > الإعدادات > وسائل الدفع.'
                                                    : 'Note: gateway credentials are missing. Please configure API keys in Admin > Settings > Payment methods.';
                                            }
                                        } elseif ($method === 'jawwal_pay') {
                                            $details = $lang === 'ar' ? setting('pay_jawwal_details_ar', '') : setting('pay_jawwal_details_en', '');
                                        } elseif ($method === 'palpay') {
                                            $details = $lang === 'ar' ? setting('pay_palpay_details_ar', '') : setting('pay_palpay_details_en', '');
                                        } elseif ($method === 'bank_transfer') {
                                            $details = $lang === 'ar' ? setting('pay_bank_details_ar', '') : setting('pay_bank_details_en', '');
                                        } elseif ($method === 'cash') {
                                            $details = $lang === 'ar' ? setting('pay_cash_details_ar', '') : setting('pay_cash_details_en', '');
                                        }
                                        ?>
                                        <?php if (trim($details) !== ''): ?>
                                            <div style="white-space: pre-line;">
                                                <?= e($details) ?>
                                            </div>
                                        <?php else: ?>
                                            <?= e($lang === 'ar' ? 'تم اختيار الوسيلة. إذا كانت هذه وسيلة إلكترونية فسيتم تحويلك لبوابة الدفع عند تفعيلها بمفاتيح المزود.' : 'Method selected. If this is an online method you will be redirected once the provider is enabled.') ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="fw-bold mb-2"><?= e($lang === 'ar' ? 'ملخص الدفع' : 'Payment summary') ?></div>

                        <div class="d-flex justify-content-between gap-3">
                            <div class="text-secondary small"><?= e($lang === 'ar' ? 'المرجع' : 'Reference') ?></div>
                            <div class="fw-semibold text-break" dir="ltr"><?= e($ref) ?></div>
                        </div>
                        <hr>

                        <div class="d-flex justify-content-between gap-3">
                            <div class="text-secondary small"><?= e($lang === 'ar' ? 'الخدمة' : 'Service') ?></div>
                            <div class="fw-semibold text-end"><?= e($label) ?></div>
                        </div>

                        <?php if ($customer !== '' || $phone !== ''): ?>
                            <div class="d-flex justify-content-between gap-3 mt-2">
                                <div class="text-secondary small"><?= e($lang === 'ar' ? 'العميل' : 'Customer') ?></div>
                                <div class="fw-semibold text-end">
                                    <?= e($customer) ?>
                                    <?php if ($phone !== ''): ?>
                                        <div class="text-secondary small" dir="ltr"><?= e($phone) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <div class="text-secondary small"><?= e($lang === 'ar' ? 'الإجمالي' : 'Total') ?></div>
                                <div class="h4 fw-bold mb-0"><?= e(money_fmt($amount)) ?> <?= e($currency) ?></div>
                            </div>
                        </div>

                        <div class="mt-3 text-secondary small">
                            <?= e($lang === 'ar' ? 'للمساعدة: ' : 'Support: ') ?>
                            <span dir="ltr"><?= e(setting('company_phone_1', '')) ?></span>
                            <?php if (trim(setting('company_phone_2', '')) !== ''): ?>
                                - <span dir="ltr"><?= e(setting('company_phone_2', '')) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
