<?php

require_once __DIR__ . '/includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$offer = offer_find($id);

if (!$offer) {
    http_response_code(404);
    $not_found_title = current_lang() === 'ar' ? 'العرض غير موجود' : 'Offer not found';
    $not_found_message = current_lang() === 'ar' ? 'العرض غير موجود أو منتهي.' : 'Offer not found or expired.';
    include __DIR__ . '/404.php';
    exit;
}

$carId = (int)($offer['car_id'] ?? 0);
$carName = car_name($offer);
$carType = car_type($offer);

$daily = (float)($offer['daily_price'] ?? 0);
$days = (int)($offer['days'] ?? 1);
if ($days <= 0) {
    $days = 1;
}
$monthly = (float)($offer['monthly_price'] ?? 0);
$total = ($days >= 30 && $monthly > 0) ? $monthly : ($daily * $days);

$title = offer_title($offer);
$desc = offer_description($offer);
$expiresAt = (string)($offer['expires_at'] ?? '');

$mediaImages = offer_media_images($id);
$mediaVideos = offer_media_videos($id);

$image = (string)($offer['image_path'] ?? '');
if ($image === '') {
    $image = (string)($offer['car_image_path'] ?? '');
}

$coverImage = '';
if (count($mediaImages) > 0) {
    $coverImage = trim((string)($mediaImages[0]['file_path'] ?? ''));
}
if ($coverImage === '') {
    $coverImage = $image;
}

$page_title = ($title !== '' ? $title : (t('offer_duration') . ': ' . $days . ' ' . t('days'))) . ' - ' . company_name();
$page_description = $desc !== '' ? $desc : ($carName . ' - ' . $carType);
$page_image = $coverImage;
$page_keywords = current_lang() === 'ar'
    ? 'عروض تأجير سيارات, ' . $carName . ', ' . $days . ' أيام, تأجير سيارات البيرة, تأجير سيارات رام الله'
    : 'car rental offers, ' . $carName . ', ' . $days . ' days, car rental Al-Bireh, car rental Ramallah';
$canonical = abs_url('offer.php?id=' . (int)$offer['id']);

$schema_markup = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Offer',
    'name' => $title !== '' ? $title : ($days . ' ' . t('days') . ' ' . $carName),
    'description' => $desc !== '' ? $desc : ($carName . ' - ' . $carType . ' - ' . $days . ' ' . t('days') . ' rental offer'),
    'url' => $canonical,
    'image' => $coverImage !== '' ? abs_url(asset_url($coverImage)) : '',
    'price' => $total,
    'priceCurrency' => 'ILS',
    'priceValidUntil' => $expiresAt !== '' ? $expiresAt : '',
    'availability' => 'https://schema.org/InStock',
    'seller' => [
        '@type' => 'Organization',
        'name' => company_name(),
        'url' => abs_url('')
    ],
    'itemOffered' => [
        '@type' => 'Product',
        'name' => $carName,
        'description' => $carType,
        'image' => $coverImage !== '' ? abs_url(asset_url($coverImage)) : '',
        'brand' => [
            '@type' => 'Brand',
            'name' => $carType
        ]
    ],
    'validFrom' => date('Y-m-d')
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

include __DIR__ . '/partials/header.php';

?>

<div class="container py-4">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-3">
        <div>
            <div class="section-kicker"><?= e(t('section_offers')) ?></div>
            <h1 class="h3 fw-bold mb-1"><?= e($title !== '' ? $title : ($days . ' ' . t('days'))) ?></h1>
            <div class="text-secondary"><?= e($carName) ?> · <?= e($carType) ?></div>
            <?php if ($expiresAt !== ''): ?>
                <div class="text-secondary small mt-1"><?= e(current_lang() === 'ar' ? 'ينتهي بتاريخ:' : 'Expires on:') ?> <?= e($expiresAt) ?></div>
            <?php endif; ?>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-primary" href="index.php#offers"><?= e(current_lang() === 'ar' ? 'العودة للعروض' : 'Back to offers') ?></a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal" data-car-id="<?= (int)$carId ?>" data-offer-id="<?= (int)$offer['id'] ?>" data-car-name="<?= e($carName) ?>">
                <?= e(t('book_now')) ?>
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm offer-page-card">
                <?php if (count($mediaImages) > 1): ?>
                    <div id="offerMediaCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php $activeSet = false; ?>
                            <?php foreach ($mediaImages as $idx => $img):
                                $p = trim((string)($img['file_path'] ?? ''));
                                if ($p === '') {
                                    continue;
                                }
                                $isActive = !$activeSet;
                                if (!$activeSet) {
                                    $activeSet = true;
                                }
                            ?>
                                <div class="carousel-item <?= $isActive ? 'active' : '' ?>">
                                    <img src="<?= e(asset_url($p)) ?>" class="w-100 offer-page-img" alt="offer" loading="lazy" decoding="async" />
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#offerMediaCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#offerMediaCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                <?php else:
                    $single = '';
                    if (count($mediaImages) === 1) {
                        $single = trim((string)($mediaImages[0]['file_path'] ?? ''));
                    }
                    if ($single === '') {
                        $single = $image;
                    }
                ?>
                    <?php if ($single !== ''): ?>
                        <img src="<?= e(asset_url($single)) ?>" class="w-100 offer-page-img" alt="offer" loading="lazy" decoding="async" />
                    <?php endif; ?>
                <?php endif; ?>
                <div class="card-body p-4">
                    <?php if ($desc !== ''): ?>
                        <div class="offer-page-desc mb-3"><?= e($desc) ?></div>
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="text-secondary small"><?= e(t('offer_duration')) ?></div>
                            <div class="h5 fw-bold mb-0"><?= (int)$days ?> <?= e(t('days')) ?></div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="text-secondary small"><?= e(t('price_daily')) ?></div>
                            <div class="h5 fw-bold mb-0"><?= e(number_format($daily, 2, '.', '')) ?> <?= e(t('currency')) ?></div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="text-secondary small"><?= e(t('total')) ?></div>
                            <div class="h4 fw-bold mb-0"><?= e(number_format($total, 2, '.', '')) ?> <?= e(t('currency')) ?></div>
                        </div>
                    </div>

                    <?php
                    $video = null;
                    if (count($mediaVideos) > 0) {
                        $video = $mediaVideos[0];
                    }
                    $videoFile = $video ? trim((string)($video['file_path'] ?? '')) : '';
                    $videoUrl = $video ? trim((string)($video['video_url'] ?? '')) : '';

                    $youtubeEmbed = '';
                    if ($videoUrl !== '') {
                        $u = $videoUrl;
                        $id1 = '';
                        if (preg_match('~youtube\.com/watch\?v=([^&]+)~i', $u, $m)) {
                            $id1 = (string)$m[1];
                        } elseif (preg_match('~youtu\.be/([^?&/]+)~i', $u, $m)) {
                            $id1 = (string)$m[1];
                        } elseif (preg_match('~youtube\.com/embed/([^?&/]+)~i', $u, $m)) {
                            $id1 = (string)$m[1];
                        }
                        if ($id1 !== '') {
                            $youtubeEmbed = 'https://www.youtube-nocookie.com/embed/' . rawurlencode($id1);
                        }
                    }
                    ?>

                    <?php if ($videoFile !== '' || $videoUrl !== ''): ?>
                        <div class="mt-4">
                            <?php if ($videoFile !== ''): ?>
                                <video controls style="width:100%; border-radius:14px;">
                                    <source src="<?= e(asset_url($videoFile)) ?>">
                                </video>
                            <?php elseif ($youtubeEmbed !== ''): ?>
                                <div class="ratio ratio-16x9">
                                    <iframe src="<?= e($youtubeEmbed) ?>" title="video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            <?php else: ?>
                                <a class="btn btn-outline-secondary w-100" href="<?= e($videoUrl) ?>" target="_blank" rel="noopener"><?= e(t('watch_video')) ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid d-md-none mt-4">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal" data-car-id="<?= (int)$carId ?>" data-offer-id="<?= (int)$offer['id'] ?>" data-car-name="<?= e($carName) ?>">
                            <?= e(t('book_now')) ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h2 class="h6 fw-bold mb-3"><?= e(t('booking_title')) ?></h2>
                    <form method="post" action="booking_submit.php" class="row g-3" enctype="multipart/form-data" data-ajax-booking="1">
                        <?= csrf_field() ?>
                        <input type="hidden" name="car_id" value="<?= (int)$carId ?>">
                        <input type="hidden" name="offer_id" value="<?= (int)$offer['id'] ?>">
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
                    <input type="hidden" name="car_id" value="<?= (int)$carId ?>">
                    <input type="hidden" name="offer_id" value="<?= (int)$offer['id'] ?>">
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
