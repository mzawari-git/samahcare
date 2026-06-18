<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

http_response_code(404);

$lang = current_lang();

$page_title = isset($page_title) && is_string($page_title) && $page_title !== ''
    ? $page_title
    : ($lang === 'ar' ? 'الصفحة غير موجودة' : 'Page not found');

$page_description = company_name();

$page_robots = 'noindex,follow';

$nfTitle = isset($not_found_title) && is_string($not_found_title) && $not_found_title !== ''
    ? $not_found_title
    : ($lang === 'ar' ? 'لم نعثر على الصفحة المطلوبة' : 'We couldn\'t find that page');

$nfMessage = isset($not_found_message) && is_string($not_found_message) && $not_found_message !== ''
    ? $not_found_message
    : ($lang === 'ar'
        ? 'قد يكون الرابط غير صحيح أو أن الصفحة تم نقلها.'
        : 'The link may be incorrect or the page may have been moved.');

$scriptName = basename((string)($_SERVER['SCRIPT_NAME'] ?? ''));
$homePrefix = $scriptName === 'index.php' ? '' : 'index.php';

include __DIR__ . '/partials/header.php';

?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="section-kicker">404</div>
                        <h1 class="display-6 fw-bold mb-2"><?= e($nfTitle) ?></h1>
                        <p class="text-secondary mb-4"><?= e($nfMessage) ?></p>

                        <div class="d-flex gap-2 flex-wrap mb-4">
                            <a class="btn btn-primary" href="index.php"><?= e($lang === 'ar' ? 'العودة للرئيسية' : 'Back to home') ?></a>
                            <a class="btn btn-outline-primary" href="index.php#contact"><?= e($lang === 'ar' ? 'تواصل معنا' : 'Contact us') ?></a>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="fw-bold mb-2"><?= e($lang === 'ar' ? 'روابط سريعة' : 'Quick links') ?></div>
                                <div class="d-grid gap-2">
                                    <a class="btn btn-outline-secondary" href="<?= e($homePrefix) ?>#offers"><?= e(t('nav_offers')) ?></a>
                                    <a class="btn btn-outline-secondary" href="<?= e($homePrefix) ?>#cars"><?= e(t('nav_cars')) ?></a>
                                    <a class="btn btn-outline-secondary" href="privacy.php"><?= e(t('privacy_policy')) ?></a>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="fw-bold mb-2"><?= e($lang === 'ar' ? 'تواصل سريع' : 'Quick contact') ?></div>
                                <div class="d-grid gap-2" dir="ltr">
                                    <?php $p1 = (string)setting('company_phone_1', ''); ?>
                                    <?php if (trim($p1) !== ''): ?>
                                        <a class="btn btn-outline-secondary" href="tel:<?= e($p1) ?>"><?= e($p1) ?></a>
                                    <?php endif; ?>
                                    <?php $p2 = (string)setting('company_phone_2', ''); ?>
                                    <?php if (trim($p2) !== ''): ?>
                                        <a class="btn btn-outline-secondary" href="tel:<?= e($p2) ?>"><?= e($p2) ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="small text-secondary">
                            <?= e($lang === 'ar' ? 'إذا كنت تعتقد أن هذا خطأ، تواصل معنا وسنساعدك فورًا.' : 'If you think this is an error, contact us and we will help you right away.') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
