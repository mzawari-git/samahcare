<?php

require_once __DIR__ . '/includes/helpers.php';

$lang = current_lang();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$car = car_find($id);

if (!$car) {
    http_response_code(404);
    $not_found_title = current_lang() === 'ar' ? 'السيارة غير موجودة' : 'Car not found';
    $not_found_message = current_lang() === 'ar' ? 'السيارة المطلوبة غير موجودة أو تم تعطيلها.' : 'The requested car does not exist or has been disabled.';
    include __DIR__ . '/404.php';
    exit;
}

$images = car_images((int)$car['id']);
if (!$images && !empty($car['image_path'])) {
    $images = [[
        'id' => 0,
        'file_path' => (string)$car['image_path'],
        'sort_order' => 1,
        'is_primary' => 1,
    ]];
}

$name = car_name($car);
$type = car_type($car);
$features = car_features($car);
$offers = offers_by_car((int)$car['id']);

$page_title = $name . ' - ' . company_name() . ' | ' . ($lang === 'ar' ? 'تأجير في رام الله' : 'Rent in Ramallah');
$page_description = $lang === 'ar'
    ? 'تأجير ' . $name . ' في رام الله بسعر ' . $car['daily_price'] . ' شيكل/يوم. ' . $type . '. احجز الآن!'
    : 'Rent ' . $name . ' in Ramallah for ' . $car['daily_price'] . ' ILS/day. ' . $type . '. Book now!';
$page_keywords = $name . ', تأجير ' . $name . ' رام الله, ' . $type . ', سيارة للإيجار';
$page_image = (string)($images[0]['file_path'] ?? '');
$canonical = abs_url('car.php?id=' . (int)$car['id']);

$carImageUrl = $page_image !== '' ? abs_url(asset_url($page_image)) : '';
$schema_markup = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $name,
    'description' => $type . ' - ' . company_address(),
    'url' => $canonical,
    'image' => $carImageUrl,
    'brand' => [
        '@type' => 'Brand',
        'name' => $type
    ],
    'offers' => [
        '@type' => 'Offer',
        'priceCurrency' => 'ILS',
        'price' => (float)$car['daily_price'],
        'priceValidUntil' => date('Y-12-31'),
        'availability' => 'https://schema.org/InStock',
        'seller' => [
            '@type' => 'Organization',
            'name' => company_name()
        ]
    ]
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

include __DIR__ . '/partials/header.php';

?>

<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
        <div>
            <h1 class="h3 fw-bold mb-1"><?= e($name) ?></h1>
            <div class="text-secondary"><?= e($type) ?></div>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="index.php#cars"><?= e(t('back')) ?></a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal" data-car-id="<?= (int)$car['id'] ?>" data-car-name="<?= e($name) ?>"><?= e(t('book_now')) ?></button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <?php if (count($images) > 0): ?>
                <div id="carGallery" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-4 overflow-hidden shadow-sm">
                        <?php foreach ($images as $i => $img): ?>
                            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                <img src="<?= e(asset_url((string)$img['file_path'])) ?>" class="d-block w-100" alt="car" style="height:420px; object-fit:cover;" loading="lazy" decoding="async">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($images) > 1): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carGallery" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carGallery" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    <?php endif; ?>
                </div>

                <?php if (count($images) > 1): ?>
                    <div class="d-flex gap-2 flex-wrap mt-3">
                        <?php foreach ($images as $i => $img): ?>
                            <button class="btn p-0 border rounded-3 overflow-hidden car-thumb" type="button" data-bs-target="#carGallery" data-bs-slide-to="<?= (int)$i ?>" aria-label="Slide <?= (int)($i + 1) ?>">
                                <img src="<?= e(asset_url((string)$img['file_path'])) ?>" alt="thumb" style="width:92px; height:64px; object-fit:cover;" loading="lazy" decoding="async">
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-secondary small"><?= e(t('price_daily')) ?></div>
                            <div class="h4 fw-bold mb-0"><?= e((string)$car['daily_price']) ?> <?= e(t('currency')) ?></div>
                        </div>
                        <div class="col-6">
                            <div class="text-secondary small"><?= e(t('price_monthly')) ?></div>
                            <div class="h4 fw-bold mb-0"><?= e((string)$car['monthly_price']) ?> <?= e(t('currency')) ?></div>
                        </div>
                    </div>

                    <?php if (count($offers) > 0): ?>
                        <hr>
                        <div class="fw-bold mb-2"><?= e(t('section_offers')) ?></div>
                        <div class="row g-3">
                            <?php foreach ($offers as $o):
                                $daily = (float)($o['daily_price'] ?? 0);
                                $days = (int)($o['days'] ?? 1);
                                if ($days <= 0) {
                                    $days = 1;
                                }
                                $monthly = (float)($car['monthly_price'] ?? 0);
                                $total = ($days >= 30 && $monthly > 0) ? $monthly : ($daily * $days);
                                $title = offer_title($o);
                                if ($title === '') {
                                    $title = (string)$days . ' ' . t('days');
                                }
                                $desc = offer_description($o);
                            ?>
                                <div class="col-12 col-md-6">
                                    <div class="card border-0 shadow-sm rounded-4 h-100 offer-mini-card">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start gap-2">
                                                <div>
                                                    <div class="fw-bold"><?= e($title) ?></div>
                                                    <?php if ($desc !== ''): ?>
                                                        <div class="text-secondary small mt-1"><?= e($desc) ?></div>
                                                    <?php endif; ?>
                                                </div>
                                                <span class="badge badge-offer"><?= e(t('offer_badge')) ?></span>
                                            </div>

                                            <div class="row g-2 mt-2">
                                                <div class="col-6">
                                                    <div class="text-secondary small"><?= e(t('offer_duration')) ?></div>
                                                    <div class="fw-bold"><?= (int)$days ?> <?= e(t('days')) ?></div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-secondary small"><?= e(t('price_daily')) ?></div>
                                                    <div class="fw-bold" dir="ltr"><?= e(number_format($daily, 2, '.', '')) ?> <?= e(t('currency')) ?></div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="text-secondary small"><?= e(t('total')) ?></div>
                                                    <div class="h5 fw-bold mb-0" dir="ltr"><?= e(number_format($total, 2, '.', '')) ?> <?= e(t('currency')) ?></div>
                                                </div>
                                            </div>

                                            <div class="d-grid gap-2 mt-3">
                                                <a class="btn btn-outline-primary btn-sm" href="offer.php?id=<?= (int)$o['id'] ?>"><?= e(t('offer_details')) ?></a>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bookingModal" data-car-id="<?= (int)$car['id'] ?>" data-offer-id="<?= (int)$o['id'] ?>" data-car-name="<?= e($name) ?>">
                                                    <?= e(t('book_now')) ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (count($features) > 0): ?>
                        <hr>
                        <div class="fw-bold mb-2"><?= e(t('features')) ?></div>
                        <ul class="mb-0">
                            <?php foreach ($features as $f): ?>
                                <li><?= e($f) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mt-3">
                <div class="card-body p-4">
                    <h2 class="h6 fw-bold mb-3"><?= e(t('booking_title')) ?></h2>
                    <form method="post" action="booking_submit.php" class="row g-3" enctype="multipart/form-data" data-ajax-booking="1">
                        <?= csrf_field() ?>
                        <input type="hidden" name="car_id" value="<?= (int)$car['id'] ?>">
                        <div class="col-12">
                            <label class="form-label"><?= e(t('full_name')) ?></label>
                            <input class="form-control" name="customer_name" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label"><?= e(t('phone')) ?></label>
                            <input class="form-control" name="phone" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= e(t('from_date')) ?></label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= e(t('to_date')) ?></label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= e(t('id_image')) ?></label>
                            <input type="file" class="form-control" name="id_image" accept="image/*" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= e(t('license_image')) ?></label>
                            <input type="file" class="form-control" name="license_image" accept="image/*" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label"><?= e(t('notes')) ?></label>
                            <textarea class="form-control" name="notes" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit"><?= e(t('send_request')) ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 overflow-hidden">
            <div class="modal-header site-modal-header">
                <h5 class="modal-title"><?= e(t('booking_title')) ?>: <span data-booking-title></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="booking_submit.php" class="row g-3" enctype="multipart/form-data" data-ajax-booking="1">
                    <?= csrf_field() ?>
                    <input type="hidden" name="car_id" value="<?= (int)$car['id'] ?>">
                    <input type="hidden" name="offer_id" value="">
                    <div class="col-12">
                        <label class="form-label"><?= e(t('full_name')) ?></label>
                        <input class="form-control" name="customer_name" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?= e(t('phone')) ?></label>
                        <input class="form-control" name="phone" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?= e(t('from_date')) ?></label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?= e(t('to_date')) ?></label>
                        <input type="date" class="form-control" name="end_date" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?= e(t('id_image')) ?></label>
                        <input type="file" class="form-control" name="id_image" accept="image/*" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?= e(t('license_image')) ?></label>
                        <input type="file" class="form-control" name="license_image" accept="image/*" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?= e(t('notes')) ?></label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit"><?= e(t('send_request')) ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
