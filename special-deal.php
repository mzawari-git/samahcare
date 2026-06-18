<?php
require_once __DIR__ . '/includes/helpers.php';

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

$priceDay1  = (float)setting('price_day_1', '120');
$priceDay3  = (float)setting('price_day_3', '330');
$priceDay10 = (float)setting('price_day_10', '1000');
$priceDay15 = (float)setting('price_day_15', '1350');
$priceDay20 = (float)setting('price_day_20', '1700');
$priceDay30 = (float)setting('price_day_30', '2400');

$page_title = ($lang === 'ar' ? 'أفضل عروض التأجير' : 'Best Rental Deals') . ' - ' . company_name();
$page_description = $lang === 'ar' 
    ? 'أفضل عروض تأجير السيارات - خصومات تصل إلى 33% - من 1 إلى 30 يوم'
    : 'Best car rental deals - Up to 33% savings - From 1 to 30 days';

$cars = cars_active();
$featuredCars = array_filter($cars, fn($c) => ($c['is_offer'] ?? 0) == 1);
if (count($featuredCars) === 0) {
    $featuredCars = array_slice($cars, 0, 6);
}

function getDealPrice($days, $priceDay1 = 120, $priceDay3 = 330, $priceDay10 = 1000, $priceDay15 = 1350, $priceDay20 = 1700, $priceDay30 = 2400) {
    $tiers = [
        ['days' => 1, 'price' => $priceDay1],
        ['days' => 3, 'price' => $priceDay3],
        ['days' => 10, 'price' => $priceDay10],
        ['days' => 15, 'price' => $priceDay15],
        ['days' => 20, 'price' => $priceDay20],
        ['days' => 30, 'price' => $priceDay30],
    ];
    
    if ($days <= 0) return 0;
    if ($days === 1) return $priceDay1;
    
    foreach ($tiers as $i => $tier) {
        if ($days === $tier['days']) {
            return $tier['price'];
        }
        if ($days < $tier['days']) {
            $prevTier = $tiers[$i - 1] ?? ['days' => 1, 'price' => $priceDay1];
            $daysDiff = $tier['days'] - $prevTier['days'];
            $priceDiff = $tier['price'] - $prevTier['price'];
            $perDay = $priceDiff / $daysDiff;
            $extraDays = $days - $prevTier['days'];
            return round($prevTier['price'] + ($perDay * $extraDays));
        }
    }
    
    return $priceDay30;
}

function getSavings($days) {
    global $priceDay1;
    $regular = $days * $priceDay1;
    $deal = getDealPrice($days);
    return $regular - $deal;
}

function getRatePerDay($days) {
    global $priceDay1;
    if ($days <= 0) return $priceDay1;
    return round(getDealPrice($days) / $days, 1);
}

$phone1 = setting('company_phone_1', '');
$digits = preg_replace('/\D+/', '', $phone1);
$wa = ($digits !== '' && $digits[0] === '0') ? '970' . substr($digits, 1) : $digits;
?>

<!DOCTYPE html>
<html lang="<?= e($lang) ?>" dir="<?= e($dir) ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page_title) ?></title>
<meta name="description" content="<?= e($page_description) ?>">
<meta name="robots" content="index,follow">

<meta property="og:title" content="<?= e($page_title) ?>">
<meta property="og:description" content="<?= e($page_description) ?>">
<meta property="og:type" content="website">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</noscript>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/<?= $dir === 'rtl' ? 'bootstrap.rtl' : 'bootstrap' ?>.min.css">
<link rel="stylesheet" href="<?= e(asset_url('assets/css/website-modern.css')) ?>">
<link rel="stylesheet" href="<?= e(asset_url('assets/css/special-deal.css')) ?>">
<link rel="stylesheet" href="<?= e(asset_url('assets/css/responsive.css')) ?>">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

<?php include __DIR__ . '/partials/header.php'; ?>

<!-- ============= HERO SECTION ============= -->
<section class="deal-hero">
    <div class="deal-hero-bg">
        <div class="deal-particles">
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
        </div>
        <div class="deal-glow deal-glow-1"></div>
        <div class="deal-glow deal-glow-2"></div>
    </div>
    
    <div class="container">
        <div class="deal-hero-content text-center">
            <div class="deal-badge">
                <i class="fas fa-fire"></i>
                <?= $lang === 'ar' ? 'عرض خاص محدود' : 'Limited Special Offer' ?>
            </div>
            
            <h1 class="deal-hero-title">
                <?= $lang === 'ar' ? 'أفضل صفقة<br>لتكريد سيارتك' : 'The Best Deal<br>To Rent Your Car' ?>
            </h1>
            
            <p class="deal-hero-subtitle">
                <?= $lang === 'ar' 
                    ? 'وفّر حتى <strong>33%</strong> على الإيجار اليومي!<br>كلما زادت الأيام، زادت التوفيرات!'
                    : 'Save up to <strong>33%</strong> on daily rentals!<br>More days = More savings!' ?>
            </p>
            
            <div class="deal-hero-stats">
                <div class="deal-stat">
                    <span class="deal-stat-num">₪120</span>
                    <span class="deal-stat-label"><?= $lang === 'ar' ? 'يوم واحد' : '1 Day' ?></span>
                </div>
                <div class="deal-stat-divider">→</div>
                <div class="deal-stat">
                    <span class="deal-stat-num">₪80</span>
                    <span class="deal-stat-label"><?= $lang === 'ar' ? '30 يوم' : '30 Days' ?></span>
                </div>
                <div class="deal-stat-divider">=</div>
                <div class="deal-stat deal-stat-save">
                    <span class="deal-stat-num"><?= $lang === 'ar' ? 'توفير 33%' : 'Save 33%' ?></span>
                    <span class="deal-stat-label"><?= $lang === 'ar' ? 'على كل يوم' : 'Every Day' ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============= DEAL CALCULATOR ============= -->
<section class="deal-calculator">
    <div class="container">
        <div class="deal-calc-card">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h2 class="deal-section-title">
                        <?= $lang === 'ar' ? 'احسب سعرك الآن' : 'Calculate Your Price' ?>
                    </h2>
                    
                    <div class="deal-slider-container">
                        <label class="deal-slider-label">
                            <span><?= $lang === 'ar' ? 'عدد الأيام' : 'Number of Days' ?></span>
                            <span class="deal-slider-value" id="daysValue">15</span>
                        </label>
                        <input type="range" class="deal-slider" id="daysSlider" min="1" max="30" value="15">
                        <div class="deal-slider-days">
                            <span>1</span>
                            <span>7</span>
                            <span>15</span>
                            <span>22</span>
                            <span>30</span>
                        </div>
                    </div>
                    
                    <div class="deal-calc-result">
                        <div class="deal-price-display">
                            <span class="deal-price-currency">₪</span>
                            <span class="deal-price-amount" id="totalPrice">1,350</span>
                        </div>
                        <div class="deal-price-meta">
                            <span id="pricePerDay">90.0</span>
                            <?= $lang === 'ar' ? 'شيكل / يوم' : 'ILS / day' ?>
                        </div>
                    </div>
                    
                    <div class="deal-savings-display">
                        <i class="fas fa-piggy-bank"></i>
                        <?= $lang === 'ar' ? 'توفر' : 'You Save' ?>:
                        <strong id="savingsAmount">₪450</strong>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="deal-comparison" id="priceComparison">
                        <div class="deal-comparison-bar">
                            <div class="deal-comparison-label">
                                <span><?= $lang === 'ar' ? 'السعر العادي' : 'Regular Price' ?></span>
                                <span id="regularPrice">₪1,800</span>
                            </div>
                            <div class="deal-comparison-track">
                                <div class="deal-comparison-fill deal-comparison-regular" id="regularBar" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="deal-comparison-bar">
                            <div class="deal-comparison-label">
                                <span><?= $lang === 'ar' ? 'سعرنا المميز' : 'Our Special Price' ?></span>
                                <span id="dealPrice">₪1,350</span>
                            </div>
                            <div class="deal-comparison-track">
                                <div class="deal-comparison-fill deal-comparison-deal" id="dealBar" style="width: 75%"></div>
                            </div>
                        </div>
                        <div class="deal-savings-badge">
                            <i class="fas fa-tag"></i>
                            <span id="savingsPercent">25% <?= $lang === 'ar' ? 'توفير' : 'OFF' ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <button class="deal-slide-btn" onclick="openBookingModal()" style="display: inline-flex;">
                <i class="fas fa-calendar-check"></i>
                <?= $lang === 'ar' ? 'احجز الآن' : 'Book Now' ?>
            </button>
        </div>
    </div>
</section>

<!-- ============= PRICING TIERS ============= -->
<section class="deal-tiers">
    <div class="container">
        <h2 class="deal-section-title text-center mb-2">
            <?= $lang === 'ar' ? 'باقات الأسعار المميزة' : 'Premium Pricing Packages' ?>
        </h2>
        <p class="deal-section-subtitle text-center mb-5">
            <?= $lang === 'ar' 
                ? 'اختر الباقة المناسبة لك واستمتع بأفضل الأسعار'
                : 'Choose your package and enjoy the best prices' ?>
        </p>
        
        <div class="deal-tiers-grid">
            <?php
            $tiers = [
                ['days' => 1, 'price' => 120, 'badge' => '', 'highlight' => false],
                ['days' => 3, 'price' => 330, 'badge' => '10% OFF', 'highlight' => false],
                ['days' => 10, 'price' => 1000, 'badge' => '17% OFF', 'highlight' => false],
                ['days' => 15, 'price' => 1350, 'badge' => '25% OFF', 'highlight' => true, 'label' => 'BEST VALUE'],
                ['days' => 20, 'price' => 1700, 'badge' => '29% OFF', 'highlight' => false],
                ['days' => 30, 'price' => 2400, 'badge' => '33% OFF', 'highlight' => false],
            ];
            
            foreach ($tiers as $tier):
                $regularPrice = $tier['days'] * 120;
                $savings = $regularPrice - $tier['price'];
                $savingsPercent = round(($savings / $regularPrice) * 100);
                $perDay = round($tier['price'] / $tier['days'], 1);
            ?>
            <div class="deal-tier-card <?= $tier['highlight'] ? 'deal-tier-featured' : '' ?>" data-days="<?= $tier['days'] ?>">
                <?php if ($tier['highlight']): ?>
                <div class="deal-tier-best-badge">
                    <i class="fas fa-star"></i> <?= $lang === 'ar' ? 'الأفضل قيمة' : 'BEST VALUE' ?>
                </div>
                <?php endif; ?>
                
                <?php if ($tier['badge']): ?>
                <div class="deal-tier-discount">
                    <i class="fas fa-fire"></i> <?= $tier['badge'] ?>
                </div>
                <?php endif; ?>
                
                <div class="deal-tier-days">
                    <span class="deal-tier-days-num"><?= $tier['days'] ?></span>
                    <span class="deal-tier-days-label"><?= $lang === 'ar' ? 'أيام' : 'Days' ?></span>
                </div>
                
                <div class="deal-tier-price">
                    <span class="deal-tier-currency">₪</span>
                    <span class="deal-tier-amount"><?= number_format($tier['price']) ?></span>
                </div>
                
                <div class="deal-tier-perday">
                    <?= $lang === 'ar' ? 'بسعر' : 'Only' ?> 
                    <strong><?= $perDay ?></strong> 
                    <?= $lang === 'ar' ? 'شيكل / يوم' : 'ILS / day' ?>
                </div>
                
                <div class="deal-tier-savings">
                    <i class="fas fa-piggy-bank"></i>
                    <?= $lang === 'ar' ? 'توفر' : 'Save' ?> 
                    <strong>₪<?= number_format($savings) ?></strong>
                    (<?= $savingsPercent ?>%)
                </div>
                
                <button class="deal-tier-btn" onclick="selectTier(<?= $tier['days'] ?>)">
                    <?= $lang === 'ar' ? 'اختر هذه الباقة' : 'Select This Package' ?>
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============= FEATURED CARS ============= -->
<?php if (count($featuredCars) > 0): ?>
<section class="deal-cars" id="cars">
    <div class="container">
        <h2 class="deal-section-title text-center mb-2">
            <i class="fas fa-car-side"></i>
            <?= $lang === 'ar' ? 'سيارات متوفرة لهذا العرض' : 'Cars Available For This Deal' ?>
        </h2>
        <p class="deal-section-subtitle text-center mb-5">
            <?= $lang === 'ar' 
                ? 'اختر سيارتك المفضلة واستمتع بأفضل سعر'
                : 'Choose your favorite car and enjoy the best price' ?>
        </p>
        
        <div class="deal-cars-grid">
            <?php foreach (array_slice($featuredCars, 0, 6) as $car):
                $carImage = $car['image_path'] ?? '';
                $carName = car_name($car);
                $carType = car_type($car);
                $carFeatures = car_features($car);
                $carId = (int)($car['id'] ?? 0);
            ?>
            <div class="deal-car-card">
                <div class="deal-car-image">
                    <?php if ($carImage !== ''): ?>
                    <img src="<?= e(asset_url($carImage)) ?>" alt="<?= e($carName) ?>">
                    <?php else: ?>
                    <div class="deal-car-placeholder">
                        <i class="fas fa-car"></i>
                    </div>
                    <?php endif; ?>
                    <div class="deal-car-badge">
                        <i class="fas fa-check-circle"></i>
                        <?= $lang === 'ar' ? 'متاح' : 'Available' ?>
                    </div>
                </div>
                <div class="deal-car-content">
                    <h3 class="deal-car-name"><?= e($carName) ?></h3>
                    <p class="deal-car-type"><?= e($carType) ?></p>
                    
                    <?php if (count($carFeatures) > 0): ?>
                    <div class="deal-car-features">
                        <?php foreach (array_slice($carFeatures, 0, 4) as $feature): ?>
                        <span class="deal-car-feature">
                            <i class="fas fa-check"></i> <?= e($feature) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="deal-car-price">
                        <span class="deal-car-price-from"><?= $lang === 'ar' ? 'يبدأ من' : 'From' ?></span>
                        <span class="deal-car-price-value">₪120</span>
                        <span class="deal-car-price-period">/<?= $lang === 'ar' ? 'يوم' : 'day' ?></span>
                    </div>
                    
                    <button class="deal-car-btn" data-bs-toggle="modal" data-bs-target="#bookingModal" data-car-id="<?= $carId ?>">
                        <i class="fas fa-calendar-check"></i>
                        <?= $lang === 'ar' ? 'احجز الآن' : 'Book Now' ?>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============= HOW IT WORKS ============= -->
<section class="deal-how">
    <div class="container">
        <h2 class="deal-section-title text-center mb-5">
            <?= $lang === 'ar' ? 'كيف يعمل؟' : 'How It Works?' ?>
        </h2>
        
        <div class="deal-how-steps">
            <div class="deal-how-step">
                <div class="deal-how-icon">
                    <i class="fas fa-car"></i>
                </div>
                <div class="deal-how-number">1</div>
                <h3><?= $lang === 'ar' ? 'اختر سيارتك' : 'Choose Your Car' ?></h3>
                <p><?= $lang === 'ar' 
                    ? 'تصفح مجموعتنا الواسعة من السيارات الحديثة'
                    : 'Browse our wide range of modern cars' ?></p>
            </div>
            
            <div class="deal-how-connector">
                <i class="fas fa-chevron-right"></i>
            </div>
            
            <div class="deal-how-step">
                <div class="deal-how-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="deal-how-number">2</div>
                <h3><?= $lang === 'ar' ? 'حدد المدة' : 'Select Duration' ?></h3>
                <p><?= $lang === 'ar' 
                    ? 'اختر عدد الأيام واحصل على أفضل سعر'
                    : 'Choose number of days and get the best price' ?></p>
            </div>
            
            <div class="deal-how-connector">
                <i class="fas fa-chevron-right"></i>
            </div>
            
            <div class="deal-how-step">
                <div class="deal-how-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="deal-how-number">3</div>
                <h3><?= $lang === 'ar' ? 'تواصل معنا' : 'Contact Us' ?></h3>
                <p><?= $lang === 'ar' 
                    ? 'اتصل أو راسلنا عبر واتساب للحجز'
                    : 'Call or message us via WhatsApp to book' ?></p>
            </div>
            
            <div class="deal-how-connector">
                <i class="fas fa-chevron-right"></i>
            </div>
            
            <div class="deal-how-step">
                <div class="deal-how-icon">
                    <i class="fas fa-key"></i>
                </div>
                <div class="deal-how-number">4</div>
                <h3><?= $lang === 'ar' ? 'استلم سيارتك' : 'Get Your Car' ?></h3>
                <p><?= $lang === 'ar' 
                    ? 'استلم سيارتك واستمتع برحلتك'
                    : 'Pick up your car and enjoy your trip' ?></p>
            </div>
        </div>
    </div>
</section>

<!-- ============= FAQ ============= -->
<section class="deal-faq">
    <div class="container">
        <h2 class="deal-section-title text-center mb-5">
            <i class="fas fa-question-circle"></i>
            <?= $lang === 'ar' ? 'أسئلة شائعة' : 'Frequently Asked Questions' ?>
        </h2>
        
        <div class="deal-faq-list">
            <div class="deal-faq-item">
                <button class="deal-faq-question" type="button">
                    <span><?= $lang === 'ar' ? 'هل السعر شامل جميع الخدمات؟' : 'Is the price all-inclusive?' ?></span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="deal-faq-answer">
                    <p><?= $lang === 'ar' 
                        ? 'نعم، السعر يشمل تأجير السيارة مع التأمين الشامل. الأسعار لا تشمل الوقود.'
                        : 'Yes, the price includes car rental with full insurance. Prices do not include fuel.' ?></p>
                </div>
            </div>
            
            <div class="deal-faq-item">
                <button class="deal-faq-question" type="button">
                    <span><?= $lang === 'ar' ? 'هل يمكن تمديد فترة الإيجار؟' : 'Can I extend the rental period?' ?></span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="deal-faq-answer">
                    <p><?= $lang === 'ar' 
                        ? 'بالتأكيد! يمكنك تمديد فترة الإيجار حسبavailability السيارة بسعر اليوم المحدد.'
                        : 'Absolutely! You can extend the rental period based on car availability at the specified day rate.' ?></p>
                </div>
            </div>
            
            <div class="deal-faq-item">
                <button class="deal-faq-question" type="button">
                    <span><?= $lang === 'ar' ? 'ما هي الوثائق المطلوبة؟' : 'What documents are required?' ?></span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="deal-faq-answer">
                    <p><?= $lang === 'ar' 
                        ? 'تحتاج إلى رخصة قيادة سارية وصورة هوية. للطلاب، نحتاج إثبات قيد جامعي.'
                        : 'You need a valid driving license and ID copy. For students, we need a university enrollment proof.' ?></p>
                </div>
            </div>
            
            <div class="deal-faq-item">
                <button class="deal-faq-question" type="button">
                    <span><?= $lang === 'ar' ? 'هل يمكنني إرجاع السيارة لموقع مختلف؟' : 'Can I return the car to a different location?' ?></span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="deal-faq-answer">
                    <p><?= $lang === 'ar' 
                        ? 'نعم، يمكن إرجاع السيارة لموقع مختلف بتكلفة إضافية. يرجى التنسيق مسبقاً.'
                        : 'Yes, you can return the car to a different location with an additional fee. Please coordinate in advance.' ?></p>
                </div>
            </div>
            
            <div class="deal-faq-item">
                <button class="deal-faq-question" type="button">
                    <span><?= $lang === 'ar' ? 'ما هي سياسة الإلغاء؟' : 'What is the cancellation policy?' ?></span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="deal-faq-answer">
                    <p><?= $lang === 'ar' 
                        ? 'يمكن إلغاء الحجز مجاناً قبل 48 ساعة من موعد الاستلام. بعد ذلك يتم فرض رسوم إلغاء.'
                        : 'Free cancellation up to 48 hours before pickup. After that, a cancellation fee applies.' ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============= CTA SECTION ============= -->
<section class="deal-cta">
    <div class="deal-cta-bg">
        <div class="deal-glow deal-glow-3"></div>
    </div>
    <div class="container text-center">
        <h2 class="deal-cta-title">
            <?= $lang === 'ar' ? 'جاهز للحصول على أفضل صفقة؟' : 'Ready To Get The Best Deal?' ?>
        </h2>
        <p class="deal-cta-subtitle">
            <?= $lang === 'ar' 
                ? 'تواصل معنا الآن واحجز سيارتك بأفضل سعر!'
                : 'Contact us now and book your car at the best price!' ?>
        </p>
        
        <div class="deal-cta-buttons">
            <?php if ($wa !== ''): ?>
            <a href="https://wa.me/<?= e($wa) ?>?text=<?= urlencode($lang === 'ar' ? 'مرحباً، أريد حجز سيارة - عرض خاص' : 'Hello, I want to book a car - Special offer') ?>" 
               class="deal-btn-whatsapp" target="_blank">
                <i class="fab fa-whatsapp"></i>
                <?= $lang === 'ar' ? 'تواصل واتساب' : 'WhatsApp Us' ?>
            </a>
            <?php endif; ?>
            
            <?php if ($phone1 !== ''): ?>
            <a href="tel:<?= e($phone1) ?>" class="deal-btn-phone">
                <i class="fas fa-phone-alt"></i>
                <?= e($phone1) ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ============= BOOKING MODAL ============= -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content deal-modal">
            <div class="modal-header">
                <div class="modal-title-wrapper">
                    <i class="fas fa-calendar-check"></i>
                    <div>
                        <h5 class="modal-title mb-0"><?= $lang === 'ar' ? 'حجز سريع' : 'Quick Booking' ?></h5>
                        <small class="modal-subtitle" id="modalDealInfo"></small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="booking_submit.php" class="deal-form" enctype="multipart/form-data" id="bookingForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="car_id" id="bookingCarId" value="">
                    <input type="hidden" name="offer_id" value="0">
                    <input type="hidden" name="selected_days" id="selectedDays" value="15">
                    <input type="hidden" name="selected_price" id="selectedPrice" value="1350">
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="deal-form-group">
                                <label><i class="fas fa-user"></i> <?= e(t('full_name')) ?></label>
                                <input type="text" name="customer_name" class="form-control" placeholder="<?= $lang === 'ar' ? 'اسمك الكامل' : 'Your full name' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="deal-form-group">
                                <label><i class="fas fa-phone"></i> <?= e(t('phone')) ?></label>
                                <input type="tel" name="phone" class="form-control" placeholder="059xxxxxxxx" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="deal-booking-summary" id="bookingSummary">
                        <div class="booking-summary-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span id="summaryDays">15 <?= $lang === 'ar' ? 'أيام' : 'Days' ?></span>
                        </div>
                        <div class="booking-summary-item">
                            <i class="fas fa-tag"></i>
                            <span id="summaryPrice">₪1,350</span>
                        </div>
                        <div class="booking-summary-item">
                            <i class="fas fa-tag"></i>
                            <span id="summaryPerDay">₪90 / <?= $lang === 'ar' ? 'يوم' : 'day' ?></span>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="deal-form-group">
                                <label><i class="fas fa-calendar-start"></i> <?= e(t('from_date')) ?></label>
                                <input type="date" name="start_date" class="form-control" id="startDate" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="deal-form-group">
                                <label><i class="fas fa-calendar-end"></i> <?= e(t('to_date')) ?></label>
                                <input type="date" name="end_date" class="form-control" id="endDate" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="deal-form-group">
                                <label><i class="fas fa-id-card"></i> <?= e(t('id_image')) ?></label>
                                <input type="file" name="id_image" class="form-control" accept="image/*" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="deal-form-group">
                                <label><i class="fas fa-car"></i> <?= $lang === 'ar' ? 'صورة رخصة القيادة' : 'License Image' ?></label>
                                <input type="file" name="license_image" class="form-control" accept="image/*" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="deal-form-group">
                        <label><i class="fas fa-comment"></i> <?= e(t('notes')) ?></label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="<?= $lang === 'ar' ? 'ملاحظات إضافية...' : 'Additional notes...' ?>"></textarea>
                    </div>
                    
                    <button type="submit" class="deal-btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        <?= e(t('send_request')) ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('daysSlider');
    const daysValue = document.getElementById('daysValue');
    const totalPrice = document.getElementById('totalPrice');
    const pricePerDay = document.getElementById('pricePerDay');
    const savingsAmount = document.getElementById('savingsAmount');
    const regularPrice = document.getElementById('regularPrice');
    const dealPrice = document.getElementById('dealPrice');
    const regularBar = document.getElementById('regularBar');
    const dealBar = document.getElementById('dealBar');
    const savingsPercent = document.getElementById('savingsPercent');
    
    const isRTL = document.documentElement.dir === 'rtl';
    
    function calculatePrice(days) {
        const tiers = [
            [1, <?= $priceDay1 ?>],
            [3, <?= $priceDay3 ?>],
            [10, <?= $priceDay10 ?>],
            [15, <?= $priceDay15 ?>],
            [20, <?= $priceDay20 ?>],
            [30, <?= $priceDay30 ?>]
        ];
        
        let price = <?= $priceDay1 ?>;
        let prevTier = [1, <?= $priceDay1 ?>];
        const dayRate = <?= $priceDay1 ?>;
        
        for (let tier of tiers) {
            if (days === tier[0]) {
                price = tier[1];
                break;
            }
            if (days < tier[0]) {
                const daysDiff = tier[0] - prevTier[0];
                const priceDiff = tier[1] - prevTier[1];
                const perDay = priceDiff / daysDiff;
                price = Math.round(prevTier[1] + (perDay * (days - prevTier[0])));
                break;
            }
            prevTier = tier;
        }
        
        if (days >= 30) price = <?= $priceDay30 ?>;
        
        const regular = days * dayRate;
        const savings = regular - price;
        const savingsPct = Math.round((savings / regular) * 100);
        const perDayRate = (price / days).toFixed(1);
        
        return { price, regular, savings, savingsPct, perDayRate };
    }
    
    function updateDisplay(days) {
        const result = calculatePrice(days);
        
        daysValue.textContent = days;
        totalPrice.textContent = result.price.toLocaleString();
        pricePerDay.textContent = result.perDayRate;
        savingsAmount.textContent = '₪' + result.savings.toLocaleString();
        regularPrice.textContent = '₪' + result.regular.toLocaleString();
        dealPrice.textContent = '₪' + result.price.toLocaleString();
        
        const maxPrice = 30 * <?= $priceDay1 ?>;
        regularBar.style.width = '100%';
        dealBar.style.width = ((result.price / maxPrice) * 100) + '%';
        
        savingsPercent.textContent = result.savingsPct + '% OFF';
        
        document.querySelectorAll('.deal-tier-card').forEach(card => {
            card.classList.remove('selected');
            if (parseInt(card.dataset.days) === days) {
                card.classList.add('selected');
            }
        });
    }
    
    slider.addEventListener('input', function() {
        updateDisplay(parseInt(this.value));
    });
    
    window.selectTier = function(days) {
        slider.value = days;
        updateDisplay(days);
        document.querySelector('.deal-tiers').scrollIntoView({ behavior: 'smooth' });
    };
    
    // Open booking modal function
    window.openBookingModal = function(days, price) {
        if (!days) days = parseInt(document.getElementById('daysValue').textContent);
        if (!price) {
            const result = calculatePrice(days);
            price = result.price;
        }
        
        const perDay = (price / days).toFixed(1);
        const lang = isRTL ? 'ar' : 'en';
        
        document.getElementById('selectedDays').value = days;
        document.getElementById('selectedPrice').value = price;
        document.getElementById('modalDealInfo').textContent = days + ' ' + (lang === 'ar' ? 'أيام' : 'days') + ' | ₪' + price.toLocaleString();
        document.getElementById('summaryDays').textContent = days + ' ' + (lang === 'ar' ? 'أيام' : 'Days');
        document.getElementById('summaryPrice').textContent = '₪' + price.toLocaleString();
        document.getElementById('summaryPerDay').textContent = '₪' + perDay + ' / ' + (lang === 'ar' ? 'يوم' : 'day');
        
        // Calculate dates based on days
        const startDate = new Date();
        const endDate = new Date();
        endDate.setDate(endDate.getDate() + days);
        
        const formatDate = (date) => date.toISOString().split('T')[0];
        document.getElementById('startDate').value = formatDate(startDate);
        document.getElementById('endDate').value = formatDate(endDate);
        
        // Open modal
        const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
        modal.show();
    };
    
    // FAQ Accordion
    document.querySelectorAll('.deal-faq-question').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.deal-faq-item');
            const answer = item.querySelector('.deal-faq-answer');
            const icon = this.querySelector('i');
            
            document.querySelectorAll('.deal-faq-answer').forEach(a => {
                if (a !== answer) {
                    a.style.maxHeight = '0';
                    a.closest('.deal-faq-item').classList.remove('open');
                }
            });
            document.querySelectorAll('.deal-faq-question i').forEach(i => {
                if (i !== icon) i.style.transform = 'rotate(0deg)';
            });
            
            if (item.classList.contains('open')) {
                answer.style.maxHeight = '0';
                item.classList.remove('open');
                icon.style.transform = 'rotate(0deg)';
            } else {
                answer.style.maxHeight = answer.scrollHeight + 'px';
                item.classList.add('open');
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
    
    // Booking modal triggers
    document.querySelectorAll('[data-bs-target="#bookingModal"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const carId = this.dataset.carId;
            if (carId) {
                document.getElementById('bookingCarId').value = carId;
            }
            openBookingModal();
        });
    });
    
    // Set minimum date for date inputs
    const today = new Date().toISOString().split('T')[0];
    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.min = today;
    });
    
    updateDisplay(15);
    
    // Carousel hover to pause
    const carousel = document.getElementById('dealCarousel');
    if (carousel && typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
        carousel.addEventListener('mouseenter', function() {
            const instance = bootstrap.Carousel.getInstance(this);
            if (instance && typeof instance.pause === 'function') instance.pause();
        });
        carousel.addEventListener('mouseleave', function() {
            const instance = bootstrap.Carousel.getInstance(this);
            if (instance && typeof instance.cycle === 'function') instance.cycle();
        });
    }
});
</script>

</body>
</html>
