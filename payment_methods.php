<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

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

$methods = [
    [
        'key' => 'cards',
        'enabled' => $enableCards,
        'title' => 'Visa / MasterCard',
        'desc' => $lang === 'ar'
            ? ($enableCards ? ($cardsConfigured ? 'الدفع الإلكتروني عبر بوابة دفع رسمية.' : 'تم تفعيل الدفع بالبطاقات ولكن بيانات البوابة غير مكتملة بعد.') : 'غير مفعّلة حالياً. يمكن تفعيلها من لوحة التحكم.')
            : ($enableCards ? ($cardsConfigured ? 'Card payments via official hosted payment page.' : 'Cards are enabled but gateway credentials are missing.') : 'Disabled. Enable it from Admin settings.'),
        'details' => $cardsProvider !== '' ? (($lang === 'ar' ? 'المزود: ' : 'Provider: ') . $cardsProvider . ' • ' . ($lang === 'ar' ? 'الوضع: ' : 'Mode: ') . $cardsMode) : '',
    ],
    [
        'key' => 'jawwal',
        'enabled' => $enableJawwal,
        'title' => $lang === 'ar' ? setting('pay_jawwal_label_ar', 'جوال باي') : setting('pay_jawwal_label_en', 'Jawwal Pay'),
        'desc' => $lang === 'ar' ? ($enableJawwal ? 'وسيلة دفع محلية.' : 'غير مفعّلة حالياً. يمكن تفعيلها من لوحة التحكم.') : ($enableJawwal ? 'Local payment method.' : 'Disabled. Enable it from Admin settings.'),
        'details' => $enableJawwal ? ($lang === 'ar' ? setting('pay_jawwal_details_ar', '') : setting('pay_jawwal_details_en', '')) : '',
    ],
    [
        'key' => 'palpay',
        'enabled' => $enablePalpay,
        'title' => $lang === 'ar' ? setting('pay_palpay_label_ar', 'بال باي') : setting('pay_palpay_label_en', 'PalPay'),
        'desc' => $lang === 'ar' ? ($enablePalpay ? 'محفظة دفع محلية.' : 'غير مفعّلة حالياً. يمكن تفعيلها من لوحة التحكم.') : ($enablePalpay ? 'Local wallet.' : 'Disabled. Enable it from Admin settings.'),
        'details' => $enablePalpay ? ($lang === 'ar' ? setting('pay_palpay_details_ar', '') : setting('pay_palpay_details_en', '')) : '',
    ],
    [
        'key' => 'bank',
        'enabled' => $enableBank,
        'title' => $lang === 'ar' ? setting('pay_bank_label_ar', 'تحويل بنكي') : setting('pay_bank_label_en', 'Bank Transfer'),
        'desc' => $lang === 'ar' ? ($enableBank ? 'تحويل بنكي مع إرسال إيصال الدفع.' : 'غير مفعّلة حالياً. يمكن تفعيلها من لوحة التحكم.') : ($enableBank ? 'Bank transfer and send your receipt.' : 'Disabled. Enable it from Admin settings.'),
        'details' => $enableBank ? ($lang === 'ar' ? setting('pay_bank_details_ar', '') : setting('pay_bank_details_en', '')) : '',
    ],
    [
        'key' => 'cash',
        'enabled' => $enableCash,
        'title' => $lang === 'ar' ? 'الدفع في الشركة' : 'Pay at office',
        'desc' => $lang === 'ar' ? ($enableCash ? 'يمكنك الدفع عند الاستلام في المكتب.' : 'غير مفعّلة حالياً. يمكن تفعيلها من لوحة التحكم.') : ($enableCash ? 'You can pay at our office.' : 'Disabled. Enable it from Admin settings.'),
        'details' => $enableCash ? ($lang === 'ar' ? setting('pay_cash_details_ar', '') : setting('pay_cash_details_en', '')) : '',
    ],
];

$page_title = $lang === 'ar' ? 'طرق الدفع' : 'Payment methods';
$page_description = company_name();
$page_image = '';

include __DIR__ . '/partials/header.php';

?>

<section class="py-5">
    <div class="container" dir="<?= e($dir) ?>">
        <div class="section-head mb-4">
            <div>
                <div class="section-kicker"><?= e($lang === 'ar' ? 'دفع آمن' : 'Secure payments') ?></div>
                <h1 class="h3 fw-bold m-0"><?= e($lang === 'ar' ? 'طرق الدفع المتاحة' : 'Available payment methods') ?></h1>
            </div>
        </div>

        <div class="row g-3">
            <?php foreach ($methods as $m): ?>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between gap-2">
                                <div class="fw-bold mb-1"><?= e((string)$m['title']) ?></div>
                                <?php if (!empty($m['enabled'])): ?>
                                    <span class="badge text-bg-success"><?= e($lang === 'ar' ? 'مفعّلة' : 'Enabled') ?></span>
                                <?php else: ?>
                                    <span class="badge text-bg-secondary"><?= e($lang === 'ar' ? 'غير مفعّلة' : 'Disabled') ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="text-secondary small"><?= e((string)$m['desc']) ?></div>
                            <?php if (trim((string)($m['details'] ?? '')) !== ''): ?>
                                <div class="mt-3 small" style="white-space: pre-line;">
                                    <?= e((string)$m['details']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

            <div class="mt-4">
                <div class="card border-0" style="background: rgba(2,35,88,.04);">
                    <div class="card-body p-4">
                        <div class="fw-bold mb-1"><?= e($lang === 'ar' ? 'ملاحظة مهمة' : 'Important note') ?></div>
                        <div class="text-secondary small">
                            <?= e($lang === 'ar'
                                ? 'الدفع الإلكتروني يتم عبر رابط دفع آمن يتم إرساله لك بعد تأكيد الحجز من الإدارة.'
                                : 'Online payments are completed via a secure payment link sent after admin confirmation.') ?>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
