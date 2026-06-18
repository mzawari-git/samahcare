<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

$bookingId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$booking = null;
if ($bookingId > 0) {
    try {
        $sql = "SELECT b.*, c.name_ar AS car_name_ar, c.name_en AS car_name_en, o.title_ar AS offer_title_ar, o.title_en AS offer_title_en
                FROM bookings b
                LEFT JOIN cars c ON c.id = b.car_id
                LEFT JOIN offers o ON o.id = b.offer_id
                WHERE b.id = :id
                LIMIT 1";
        $stmt = db()->prepare($sql);
        $stmt->execute([':id' => $bookingId]);
        $booking = $stmt->fetch() ?: null;
    } catch (Throwable $e) {
        $booking = null;
    }
}

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

$page_title = $lang === 'ar' ? 'تم استلام طلبك' : 'Request received';
$page_description = company_name();
$page_image = '';

include __DIR__ . '/partials/header.php';

$carName = '';
$offerTitle = '';
if (is_array($booking)) {
    $carName = $lang === 'ar' ? (string)($booking['car_name_ar'] ?? '') : (string)($booking['car_name_en'] ?? '');
    $offerTitle = $lang === 'ar' ? (string)($booking['offer_title_ar'] ?? '') : (string)($booking['offer_title_en'] ?? '');
}

$phone1 = trim(setting('company_phone_1', ''));
$phone2 = trim(setting('company_phone_2', ''));
$waTo = preg_replace('/\D+/', '', $phone1);
if ($waTo !== '' && strpos($waTo, '970') !== 0) {
    if (strpos($waTo, '0') === 0) {
        $waTo = '970' . substr($waTo, 1);
    }
}

$waText = $lang === 'ar'
    ? 'مرحبا، لدي استفسار بخصوص الحجز.'
    : 'Hello, I have a question about my booking.';

$waUrl = $waTo !== '' ? ('https://wa.me/' . urlencode($waTo) . '?text=' . urlencode($waText)) : '';

?>

<section class="py-5">
    <div class="container" dir="<?= e($dir) ?>">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                            <div>
                                <div class="section-kicker"><?= e($lang === 'ar' ? 'تم الإرسال بنجاح' : 'Sent successfully') ?></div>
                                <h1 class="h3 fw-bold mb-2"><?= e($lang === 'ar' ? 'تم استلام طلبك' : 'We received your request') ?></h1>
                                <div class="text-secondary">
                                    <?= e($lang === 'ar'
                                        ? 'سيتم التواصل معك لتأكيد الحجز، وبعد التأكيد سيتم إرسال رابط الدفع.'
                                        : 'We will contact you to confirm the booking. After confirmation, we will send you the payment link.') ?>
                                </div>
                            </div>
                            <?php if ($bookingId > 0): ?>
                                <span class="badge text-bg-secondary" dir="ltr">#<?= (int)$bookingId ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="row g-3 mt-4">
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-number">1</div>
                                    <div class="fw-bold mb-1"><?= e($lang === 'ar' ? 'استلام الطلب' : 'Request received') ?></div>
                                    <div class="text-secondary small"><?= e($lang === 'ar' ? 'تم تسجيل طلب الحجز في النظام.' : 'Your booking request has been recorded.') ?></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-number">2</div>
                                    <div class="fw-bold mb-1"><?= e($lang === 'ar' ? 'تأكيد الحجز' : 'Confirmation') ?></div>
                                    <div class="text-secondary small"><?= e($lang === 'ar' ? 'سنقوم بمراجعة الطلب والتواصل معك.' : 'We will review the request and contact you.') ?></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-number">3</div>
                                    <div class="fw-bold mb-1"><?= e($lang === 'ar' ? 'الدفع' : 'Payment') ?></div>
                                    <div class="text-secondary small"><?= e($lang === 'ar' ? 'بعد التأكيد سيتم إرسال رابط الدفع (Visa/MasterCard أو وسائل محلية).' : 'After confirmation, you will receive a secure payment link (cards or local methods).') ?></div>
                                </div>
                            </div>
                        </div>

                        <?php if (is_array($booking)): ?>
                            <div class="card border-0 mt-4" style="background: rgba(2,35,88,.04);">
                                <div class="card-body p-4">
                                    <div class="fw-bold mb-2"><?= e($lang === 'ar' ? 'ملخص الطلب' : 'Request summary') ?></div>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div class="text-secondary small"><?= e($lang === 'ar' ? 'السيارة' : 'Car') ?></div>
                                            <div class="fw-semibold"><?= e($carName) ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-secondary small"><?= e($lang === 'ar' ? 'العرض' : 'Offer') ?></div>
                                            <div class="fw-semibold"><?= e(trim($offerTitle) !== '' ? $offerTitle : '-') ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-secondary small"><?= e($lang === 'ar' ? 'الاسم' : 'Name') ?></div>
                                            <div class="fw-semibold"><?= e((string)($booking['customer_name'] ?? '')) ?></div>
                                        </div>
                                        <div class="col-md-6" dir="ltr">
                                            <div class="text-secondary small"><?= e($lang === 'ar' ? 'الهاتف' : 'Phone') ?></div>
                                            <div class="fw-semibold"><?= e((string)($booking['phone'] ?? '')) ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-secondary small"><?= e($lang === 'ar' ? 'من' : 'From') ?></div>
                                            <div class="fw-semibold"><?= e((string)($booking['start_date'] ?? '')) ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-secondary small"><?= e($lang === 'ar' ? 'إلى' : 'To') ?></div>
                                            <div class="fw-semibold"><?= e((string)($booking['end_date'] ?? '')) ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex gap-2 flex-wrap mt-4">
                            <a class="btn btn-outline-light" href="index.php#offers"><?= e($lang === 'ar' ? 'العودة للعروض' : 'Back to offers') ?></a>
                            <a class="btn btn-outline-warning" href="payment_methods.php"><?= e($lang === 'ar' ? 'طرق الدفع' : 'Payment methods') ?></a>
                            <a class="btn btn-primary" href="index.php#contact"><?= e($lang === 'ar' ? 'تواصل معنا' : 'Contact us') ?></a>
                            <?php if ($waUrl !== ''): ?>
                                <a class="btn btn-success" href="<?= e($waUrl) ?>" target="_blank" rel="noopener"><?= e($lang === 'ar' ? 'واتساب' : 'WhatsApp') ?></a>
                            <?php endif; ?>
                        </div>

                        <div class="text-secondary small mt-3" dir="ltr">
                            <?= e($phone1) ?>
                            <?php if ($phone2 !== ''): ?>
                                - <?= e($phone2) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
