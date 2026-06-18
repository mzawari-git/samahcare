<?php
require_once __DIR__ . '/includes/helpers.php';

$slides  = slides_active();
$cars    = cars_active();
$offers  = offers_active();

// Single optimized query for stats
$statsRow = db()->query('SELECT 
    (SELECT COUNT(*) FROM cars WHERE is_active = 1) as cars_count,
    (SELECT COUNT(*) FROM bookings) as bookings_count
')->fetch();
$stats = [
    'cars'     => (int)($statsRow['cars_count'] ?? 0),
    'bookings' => (int)($statsRow['bookings_count'] ?? 0),
];

$heroBg   = $slides[0]['image_path'] ?? '';
$lang     = current_lang();
$phone1   = setting('company_phone_1', '');
$phone2   = setting('company_phone_2', '');
$address  = company_address();
$hours    = company_working_hours();

// Cache price settings
static $prices = null;
if ($prices === null) {
    $prices = [
        'day_1'  => (float)setting('price_day_1', '120'),
        'day_3'  => (float)setting('price_day_3', '330'),
        'day_10' => (float)setting('price_day_10', '1000'),
        'day_15' => (float)setting('price_day_15', '1350'),
        'day_20' => (float)setting('price_day_20', '1700'),
        'day_30' => (float)setting('price_day_30', '2400'),
        'monthly'=> (float)setting('price_monthly', '2300'),
    ];
}
$priceDay1  = $prices['day_1'];
$priceDay3  = $prices['day_3'];
$priceDay10 = $prices['day_10'];
$priceDay15 = $prices['day_15'];
$priceDay20 = $prices['day_20'];
$priceDay30 = $prices['day_30'];
$priceMonthly = $prices['monthly'];

$page_title       = 'Sawa Rent Car - ' . ($lang === 'ar' ? 'تأجير سيارات في رام الله | أفضل الأسعار' : 'Car Rental in Ramallah | Best Prices');
$page_description = $lang === 'ar' 
    ? 'تأجير سيارات في رام الله بأسعار تنافسية. سيارات حديثة ومؤمنة مع تأمين شامل. احجز الآن واستمتع بتوصيل مجاني!'
    : 'Rent a car in Ramallah at competitive prices. Modern, insured vehicles with full insurance. Book now and enjoy free delivery!';
$page_keywords    = 'تأجير سيارات, rent car ramallah, car rental, cheapest car rental, تأجير سيارات رام الله';
$canonical        = abs_url('index.php');

include __DIR__ . '/partials/header.php';
?>

<!-- ============= HERO SLIDESHOW ============= -->
<section class="site-hero" id="home">
    <?php if ($heroBg !== ''): ?>
        <img src="<?= e(asset_url($heroBg)) ?>" alt="hero" class="hero-bg-img" loading="eager" onerror="this.style.display='none'; this.parentElement.style.background='linear-gradient(135deg, #1a73e8, #34a853, #fbbc04)';">
    <?php else: ?>
        <div style="position:absolute;top:0;left:0;width:100%;height:100%;background:linear-gradient(135deg, #1a73e8, #34a853);z-index:0;"></div>
    <?php endif; ?>
    
    <!-- Animated particles -->
    <div class="hero-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">
        <!-- Carousel Indicators -->
        <div class="carousel-indicators hero-indicators" role="tablist">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        
        <div class="carousel-inner">
            <!-- Slide 1: Calculator -->
            <div class="carousel-item active" data-slide-type="calculator">
                <div class="hero-container">
                    <div class="hero-left">
                        <div class="hero-badge">
                            <i class="fas fa-star"></i>
                            <?= e(company_name()) ?>
                        </div>
                        <h1 class="hero-title">
                            <?= e(t('hero_title')) ?>
                            <?php if ($lang === 'ar'): ?>
                            <span class="highlight">بكل سهولة وأمان</span>
                            <?php else: ?>
                            <span class="highlight">Easy & Safe</span>
                            <?php endif; ?>
                        </h1>
                        <p class="hero-subtitle"><?= e(t('hero_subtitle')) ?></p>
                        <div class="hero-trust">
                            <div class="trust-item">
                                <i class="fas fa-shield-alt"></i>
                                <span><?= e($lang === 'ar' ? 'تأمين شامل' : 'Full Insurance') ?></span>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-headset"></i>
                                <span><?= e($lang === 'ar' ? 'دعم 24/7' : '24/7 Support') ?></span>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-map-marked-alt"></i>
                                <span><?= e($lang === 'ar' ? 'توصيل مجاني' : 'Free Delivery') ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="hero-right">
                        <div class="deal-calc-card hero-calc">
                            <h2 class="deal-section-title mb-3">
                                <?= $lang === 'ar' ? 'احسب سعرك الآن' : 'Calculate Your Price' ?>
                            </h2>
                            
                            <div class="deal-slider-container mb-3">
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
                            
                            <div class="deal-calc-result mb-3">
                                <div class="deal-price-display">
                                    <span class="deal-price-currency">₪</span>
                                    <span class="deal-price-amount" id="totalPrice">1,350</span>
                                </div>
                                <div class="deal-price-meta">
                                    <span id="pricePerDay">90.0</span>
                                    <?= $lang === 'ar' ? 'شيكل / يوم' : 'ILS / day' ?>
                                </div>
                            </div>
                            
                            <div class="deal-savings-display mb-3">
                                <i class="fas fa-piggy-bank"></i>
                                <?= $lang === 'ar' ? 'توفر' : 'You Save' ?>:
                                <strong id="savingsAmount">₪450</strong>
                            </div>
                            
                            <div class="deal-comparison mb-3" id="priceComparison">
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
                            
                            <button class="deal-slide-btn" onclick="openBookingModal()">
                                <i class="fas fa-calendar-check"></i>
                                <span><?= $lang === 'ar' ? 'احجز الآن' : 'Book Now' ?></span>
                                <span class="deal-btn-info" id="dealBtnInfo">15 <?= $lang === 'ar' ? 'يوم' : 'Days' ?> | ₪1,350</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2: Best Value -->
            <div class="carousel-item" data-slide-type="deal">
                <div class="hero-container">
                    <div class="hero-left">
                        <div class="hero-badge">
                            <i class="fas fa-star"></i> <?= $lang === 'ar' ? 'الأفضل قيمة' : 'BEST VALUE' ?>
                        </div>
                        <h1 class="hero-title">
                            <?= $lang === 'ar' ? 'وفّر 25%' : 'Save 25%' ?>
                            <span class="highlight"><?= $lang === 'ar' ? 'على تأجير السيارات' : 'On Car Rental' ?></span>
                        </h1>
                        <p class="hero-subtitle">
                            <?= $lang === 'ar' 
                                ? 'احجز 15 يوم واحصل على أفضل سعر!' 
                                : 'Book 15 days and get the best price!' ?>
                        </p>
                        <div class="hero-actions">
                            <a href="#booking" class="btn-primary-hero">
                                <i class="fas fa-calendar-check"></i> <?= $lang === 'ar' ? 'احجز الآن' : 'Book Now' ?>
                            </a>
                        </div>
                        <div class="hero-trust">
                            <div class="trust-item">
                                <i class="fas fa-check-circle"></i>
                                <span><?= $lang === 'ar' ? 'شامل التأمين' : 'Insurance Included' ?></span>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-check-circle"></i>
                                <span><?= $lang === 'ar' ? 'توصيل مجاني' : 'Free Delivery' ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="hero-right">
                        <div class="hero-deal-card best-value">
                            <div class="hero-deal-badge">
                                <i class="fas fa-star"></i> <?= $lang === 'ar' ? 'الأفضل قيمة' : 'BEST VALUE' ?>
                            </div>
                            <div class="hero-deal-days">
                                <span class="hero-deal-days-num">15</span>
                                <span class="hero-deal-days-label"><?= $lang === 'ar' ? 'أيام' : 'Days' ?></span>
                            </div>
                            <div class="hero-deal-price">
                                <span class="hero-deal-currency">₪</span>
                                <span class="hero-deal-amount">1,350</span>
                            </div>
                            <div class="hero-deal-perday"><?= $lang === 'ar' ? 'بسعر ₪90 / يوم' : 'Only ₪90 / day' ?></div>
                            <div class="hero-deal-savings">
                                <i class="fas fa-piggy-bank"></i> <?= $lang === 'ar' ? 'توفر' : 'You Save' ?>: ₪450
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3: Max Savings -->
            <div class="carousel-item" data-slide-type="deal">
                <div class="hero-container">
                    <div class="hero-left">
                        <div class="hero-badge">
                            <i class="fas fa-fire"></i> <?= $lang === 'ar' ? 'أقصى توفير' : 'MAX SAVINGS' ?>
                        </div>
                        <h1 class="hero-title">
                            <?= $lang === 'ar' ? 'وفّر 33%' : 'Save 33%' ?>
                            <span class="highlight"><?= $lang === 'ar' ? 'شهرياً' : 'Monthly' ?></span>
                        </h1>
                        <p class="hero-subtitle">
                            <?= $lang === 'ar' 
                                ? 'احجز شهر كامل واحصل على أقل سعر!' 
                                : 'Book a full month and get the lowest price!' ?>
                        </p>
                        <div class="hero-actions">
                            <a href="#booking" class="btn-primary-hero">
                                <i class="fas fa-calendar-check"></i> <?= $lang === 'ar' ? 'احجز الآن' : 'Book Now' ?>
                            </a>
                        </div>
                        <div class="hero-trust">
                            <div class="trust-item">
                                <i class="fas fa-check-circle"></i>
                                <span><?= $lang === 'ar' ? 'أقل سعر' : 'Lowest Price' ?></span>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-check-circle"></i>
                                <span><?= $lang === 'ar' ? 'توصيل مجاني' : 'Free Delivery' ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="hero-right">
                        <div class="hero-deal-card max-savings">
                            <div class="hero-deal-badge">
                                <i class="fas fa-fire"></i> <?= $lang === 'ar' ? 'أقصى توفير' : 'MAX SAVINGS' ?>
                            </div>
                            <div class="hero-deal-days">
                                <span class="hero-deal-days-num">30</span>
                                <span class="hero-deal-days-label"><?= $lang === 'ar' ? 'أيام' : 'Days' ?></span>
                            </div>
                            <div class="hero-deal-price">
                                <span class="hero-deal-currency">₪</span>
                                <span class="hero-deal-amount">2,400</span>
                            </div>
                            <div class="hero-deal-perday"><?= $lang === 'ar' ? 'بسعر ₪80 / يوم' : 'Only ₪80 / day' ?></div>
                            <div class="hero-deal-savings">
                                <i class="fas fa-piggy-bank"></i> <?= $lang === 'ar' ? 'توفر' : 'You Save' ?>: ₪1,200
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Carousel Controls -->
        <button class="carousel-control-prev hero-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="hero-control-icon"><i class="fas fa-chevron-<?= $lang === 'ar' ? 'right' : 'left' ?> fa-lg"></i></span>
        </button>
        <button class="carousel-control-next hero-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="hero-control-icon"><i class="fas fa-chevron-<?= $lang === 'ar' ? 'left' : 'right' ?> fa-lg"></i></span>
        </button>
    </div>
    
    <div class="hero-scroll">
        <a href="#stats" class="scroll-indicator">
            <span><?= e($lang === 'ar' ? 'اكتشف المزيد' : 'Scroll Down') ?></span>
            <i class="fas fa-chevron-down"></i>
        </a>
    </div>
</section>

<!-- ============= STATS STRIP ============= -->
<div class="stats-strip" id="stats">
    <div class="stats-inner">
        <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-icon-wrap"><i class="fas fa-car"></i></div>
            <div class="stat-number" data-target="<?= $stats['cars'] ?>" data-suffix="+"><?= $stats['cars'] ?>+</div>
            <div class="stat-label"><?= e($lang === 'ar' ? 'سيارة متاحة' : 'Available Cars') ?></div>
        </div>
        <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-icon-wrap success"><i class="fas fa-users"></i></div>
            <div class="stat-number" data-target="<?= $stats['bookings'] + 500 ?>" data-suffix="+"><?= $stats['bookings'] + 500 ?>+</div>
            <div class="stat-label"><?= e($lang === 'ar' ? 'عميل سعيد' : 'Happy Clients') ?></div>
        </div>
        <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-icon-wrap warning"><i class="fas fa-headset"></i></div>
            <div class="stat-number">24/7</div>
            <div class="stat-label"><?= e($lang === 'ar' ? 'دعم دائم' : 'Support') ?></div>
        </div>
        <div class="stat-box" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-icon-wrap info"><i class="fas fa-award"></i></div>
            <div class="stat-number">100%</div>
            <div class="stat-label"><?= e($lang === 'ar' ? 'ضمان الجودة' : 'Quality Assured') ?></div>
        </div>
    </div>
</div>

<!-- ============= WHY CHOOSE US ============= -->
<section class="section section-light">
    <div class="section-container">
        <div class="section-head" data-aos="fade-up">
            <div class="section-kicker"><i class="fas fa-star"></i> <?= e($lang === 'ar' ? 'لماذا نحن؟' : 'Why Us?') ?></div>
            <h2 class="section-title"><?= e($lang === 'ar' ? 'اخترنا لرحلتك القادمة' : 'Choose Us For Your Next Journey') ?></h2>
            <p class="section-sub"><?= e($lang === 'ar' ? 'نقدم لك تجربة تأجير سيارات استثنائية' : 'We offer an exceptional car rental experience') ?></p>
        </div>
        <div class="features-grid">
            <div class="feature-card card-hover-lift" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon"><i class="fas fa-car-side"></i></div>
                <h3><?= e($lang === 'ar' ? 'أسطول حديث' : 'Modern Fleet') ?></h3>
                <p><?= e($lang === 'ar' ? 'سيارات جديدة ومُحدّثة بانتظام لراحتك وأمانك' : 'New and regularly updated vehicles for your comfort and safety') ?></p>
            </div>
            <div class="feature-card card-hover-lift" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon"><i class="fas fa-tags"></i></div>
                <h3><?= e($lang === 'ar' ? 'أسعار منافسة' : 'Competitive Prices') ?></h3>
                <p><?= e($lang === 'ar' ? 'أفضل الأسعار في السوق مع عروض وخصومات حصرية' : 'Best prices in the market with exclusive offers and discounts') ?></p>
            </div>
            <div class="feature-card card-hover-lift" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h3><?= e($lang === 'ar' ? 'تأمين شامل' : 'Full Insurance') ?></h3>
                <p><?= e($lang === 'ar' ? 'جميع سياراتنا مؤمّنة بتأمين شامل لراحة بالك' : 'All our cars are fully insured for your peace of mind') ?></p>
            </div>
            <div class="feature-card card-hover-lift" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon"><i class="fas fa-clock"></i></div>
                <h3><?= e($lang === 'ar' ? 'استلام سريع' : 'Quick Pickup') ?></h3>
                <p><?= e($lang === 'ar' ? 'استلم سيارتك خلال دقائق من الحجز' : 'Pick up your car within minutes of booking') ?></p>
            </div>
            <div class="feature-card card-hover-lift" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3><?= e($lang === 'ar' ? 'توصيل مجاني' : 'Free Delivery') ?></h3>
                <p><?= e($lang === 'ar' ? 'نوصل السيارة لموقعك دون أي تكلفة إضافية' : 'We deliver the car to your location at no extra cost') ?></p>
            </div>
            <div class="feature-card card-hover-lift" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-icon"><i class="fas fa-headset"></i></div>
                <h3><?= e($lang === 'ar' ? 'دعم متواصل' : '24/7 Support') ?></h3>
                <p><?= e($lang === 'ar' ? 'فريق دعم متاح على مدار الساعة للإجابة على استفساراتك' : 'Support team available around the clock to answer your questions') ?></p>
            </div>
        </div>
    </div>
</section>

<!-- ============= DEAL TIERS SECTION ============= -->
<section id="deals" class="section section-light">
    <div class="section-container">
        <div class="section-head" data-aos="fade-up">
            <div class="section-kicker"><i class="fas fa-tags"></i> <?= $lang === 'ar' ? 'باقات الأسعار' : 'Pricing Packages' ?></div>
            <h2 class="section-title"><?= $lang === 'ar' ? 'اختر باقتك المميزة' : 'Choose Your Premium Package' ?></h2>
            <p class="section-sub"><?= $lang === 'ar' ? 'وفّر حتى 33% مع باقاتنا الحصرية' : 'Save up to 33% with our exclusive packages' ?></p>
        </div>
        
        <div class="deals-tiers-grid">
            <?php
            $tiers = [
                ['days' => 1, 'price' => $priceDay1, 'badge' => '', 'highlight' => false],
                ['days' => 3, 'price' => $priceDay3, 'badge' => '10% OFF', 'highlight' => false],
                ['days' => 10, 'price' => $priceDay10, 'badge' => '17% OFF', 'highlight' => false],
                ['days' => 15, 'price' => $priceDay15, 'badge' => '25% OFF', 'highlight' => true, 'label' => 'BEST VALUE'],
                ['days' => 20, 'price' => $priceDay20, 'badge' => '29% OFF', 'highlight' => false],
                ['days' => 30, 'price' => $priceDay30, 'badge' => '33% OFF', 'highlight' => false],
            ];
            
            foreach ($tiers as $index => $tier):
                $regularPrice = $tier['days'] * $priceDay1;
                $savings = $regularPrice - $tier['price'];
                $savingsPercent = round(($savings / $regularPrice) * 100);
                $perDay = round($tier['price'] / $tier['days'], 1);
                $delay = 100 + $index * 100;
            ?>
            <div class="deal-card card-hover-lift <?= $tier['highlight'] ? 'deal-card-featured' : '' ?>" data-days="<?= $tier['days'] ?>" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                <?php if ($tier['highlight']): ?>
                <div class="deal-card-badge">
                    <i class="fas fa-star"></i> <?= $lang === 'ar' ? 'الأفضل قيمة' : 'BEST VALUE' ?>
                </div>
                <?php endif; ?>
                
                <?php if ($tier['badge']): ?>
                <div class="deal-card-discount">
                    <i class="fas fa-fire"></i> <?= $tier['badge'] ?>
                </div>
                <?php endif; ?>
                
                <div class="deal-card-days">
                    <span class="deal-card-days-num"><?= $tier['days'] ?></span>
                    <span class="deal-card-days-label"><?= $lang === 'ar' ? 'أيام' : 'Days' ?></span>
                </div>
                
                <div class="deal-card-price">
                    <span class="deal-card-currency">₪</span>
                    <span class="deal-card-amount"><?= number_format($tier['price']) ?></span>
                </div>
                
                <div class="deal-card-perday">
                    <?= $lang === 'ar' ? 'بسعر' : 'Only' ?> 
                    <strong><?= $perDay ?></strong> 
                    <?= $lang === 'ar' ? 'شيكل / يوم' : 'ILS / day' ?>
                </div>
                
                <div class="deal-card-savings">
                    <i class="fas fa-piggy-bank"></i>
                    <?= $lang === 'ar' ? 'توفر' : 'Save' ?> 
                    <strong>₪<?= number_format($savings) ?></strong>
                    (<?= $savingsPercent ?>%)
                </div>
                
                <button class="deal-card-btn" onclick="selectDealTier(<?= $tier['days'] ?>, <?= $tier['price'] ?>)">
                    <i class="fas fa-calendar-check"></i> <?= $lang === 'ar' ? 'احجز الآن' : 'Book Now' ?>
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============= HOW IT WORKS ============= -->
<section class="section section-gray">
    <div class="section-container">
        <div class="section-head" data-aos="fade-up">
            <div class="section-kicker"><i class="fas fa-route"></i> <?= e($lang === 'ar' ? 'عملية بسيطة' : 'Simple Process') ?></div>
            <h2 class="section-title"><?= e($lang === 'ar' ? 'كيف تحجز سيارتك؟' : 'How to Book Your Car?') ?></h2>
            <p class="section-sub"><?= e($lang === 'ar' ? 'ثلاث خطوات بسيطة للحصول على سيارتك المثالية' : 'Three simple steps to get your perfect car') ?></p>
        </div>
        <div class="steps-grid">
            <div class="step-card card-hover-lift" data-aos="fade-up" data-aos-delay="100">
                <div class="step-number">1</div>
                <i class="fas fa-car step-icon"></i>
                <div class="step-title"><?= e($lang === 'ar' ? 'اختر سيارتك' : 'Choose Your Car') ?></div>
                <p class="step-desc"><?= e($lang === 'ar' ? 'تصفح أسطولنا واختر السيارة التي تناسب احتياجاتك وميزانيتك' : 'Browse our fleet and choose the car that fits your needs and budget') ?></p>
            </div>
            <div class="step-card card-hover-lift" data-aos="fade-up" data-aos-delay="200">
                <div class="step-number">2</div>
                <i class="fas fa-file-alt step-icon"></i>
                <div class="step-title"><?= e($lang === 'ar' ? 'أرسل طلبك' : 'Submit Request') ?></div>
                <p class="step-desc"><?= e($lang === 'ar' ? 'املأ نموذج الحجز ببياناتك وارفع صور الهوية والرخصة' : 'Fill in your booking details and upload your ID and license photos') ?></p>
            </div>
            <div class="step-card card-hover-lift" data-aos="fade-up" data-aos-delay="300">
                <div class="step-number">3</div>
                <i class="fas fa-key step-icon"></i>
                <div class="step-title"><?= e($lang === 'ar' ? 'استلم السيارة' : 'Pick Up the Car') ?></div>
                <p class="step-desc"><?= e($lang === 'ar' ? 'سنتواصل معك لتأكيد الحجز وتحديد موعد الاستلام' : 'We\'ll contact you to confirm and arrange pickup at your convenience') ?></p>
            </div>
        </div>
    </div>
</section>

<!-- ============= CARS SECTION ============= -->
<section id="cars" class="section section-dark">
    <div class="section-container">
        <div class="section-head" data-aos="fade-up">
            <div class="section-kicker"><i class="fas fa-car"></i> <?= e(t('nav_cars')) ?></div>
            <h2 class="section-title"><?= e(t('section_cars')) ?></h2>
            <p class="section-sub"><?= e($lang === 'ar' ? 'أسطول متنوع يناسب جميع الأذواق والاحتياجات' : 'A diverse fleet for all tastes and needs') ?></p>
            <div style="text-align: center; margin-bottom: 24px;">
                <a href="compare.php" class="compare-btn" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; color: white; text-decoration: none; transition: all 0.3s ease;">
                    <i class="fas fa-balance-scale"></i>
                    <?= $lang === 'ar' ? 'مقارنة السيارات' : 'Compare Cars' ?>
                </a>
            </div>
        </div>

        <div class="cars-grid">
            <?php if (count($cars) === 0): ?>
                <div class="no-cars-message">
                    <i class="fas fa-car"></i>
                    <h3><?= e($lang === 'ar' ? 'لا توجد سيارات متاحة حالياً' : 'No cars available at the moment') ?></h3>
                    <p><?= e($lang === 'ar' ? 'تابعنا للحصول على أحدث العروض' : 'Follow us for the latest offers') ?></p>
                </div>
            <?php endif; ?>

            <?php foreach ($cars as $index => $car):
                $name  = car_name($car);
                $type  = car_type($car);
                $img   = (string)($car['image_path'] ?? '');
                $price = (string)$car['daily_price'];

                $badgeBg = 'var(--primary)';
                if (strpos($type, 'رياضي') !== false || stripos($type, 'sport') !== false)   $badgeBg = 'var(--danger)';
                elseif (strpos($type, 'عائلي') !== false || stripos($type, 'family') !== false) $badgeBg = 'var(--warning)';
                elseif (strpos($type, 'فاخر') !== false || stripos($type, 'luxury') !== false)  $badgeBg = '#7c3aed';
                elseif (strpos($type, 'دفع رباعي') !== false || stripos($type, 'suv') !== false) $badgeBg = 'var(--info)';
            ?>
            <div class="car-card card-hover-lift" data-aos="fade-up" data-aos-delay="<?= 100 + $index * 50 ?>">
                <div class="car-image">
                    <?php if ($img !== ''): ?>
                        <img src="<?= e(asset_url($img)) ?>" alt="<?= e($name) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="car-placeholder"><i class="fas fa-car"></i></div>
                    <?php endif; ?>
                    <span class="car-badge" style="background:<?= $badgeBg ?>;"><?= e($type) ?></span>
                    <?php if ((int)($car['is_offer'] ?? 0) === 1): ?>
                        <span class="car-offer-badge"><i class="fas fa-bolt"></i> <?= e($lang === 'ar' ? 'عرض' : 'Offer') ?></span>
                    <?php endif; ?>
                </div>
                <div class="car-info">
                    <h3 class="car-name"><?= e($name) ?></h3>
                    <div class="car-meta">
                        <span><i class="fas fa-gas-pump"></i> <?= e((string)($car['fuel'] ?? ($lang === 'ar' ? 'بنزين' : 'Petrol'))) ?></span>
                        <span><i class="fas fa-cog"></i> <?= e((string)($car['transmission'] ?? ($lang === 'ar' ? 'أوتوماتيك' : 'Auto'))) ?></span>
                        <span><i class="fas fa-users"></i> <?= e((string)($car['passengers'] ?? '5')) ?></span>
                    </div>
                    <div class="car-price"><?= e($price) ?> <span><?= e(t('currency')) ?> / <?= e($lang === 'ar' ? 'يوم' : 'day') ?></span></div>
                    <?php if (!empty($car['monthly_price'])): ?>
                        <div class="car-monthly"><?= e($lang === 'ar' ? 'أو' : 'or') ?> <?= e($car['monthly_price']) ?> <?= e(t('currency')) ?>/<?= e($lang === 'ar' ? 'شهر' : 'mo') ?></div>
                    <?php endif; ?>
                    <div class="car-actions">
                        <a href="car.php?id=<?= (int)$car['id'] ?>" class="btn-details">
                            <i class="fas fa-info-circle"></i> <?= e($lang === 'ar' ? 'تفاصيل' : 'Details') ?>
                        </a>
                        <a href="#booking" class="btn-book" onclick="(function(){var s=document.querySelector('select[name=\'car_id\']');if(s)s.value='<?= (int)$car['id'] ?>';})()">
                            <i class="fas fa-calendar-check"></i> <?= e(t('book_now')) ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============= OFFERS SECTION ============= -->
<?php if (count($offers) > 0): ?>
<section id="offers" class="section section-light">
    <div class="section-container">
        <div class="section-head" data-aos="fade-up">
            <div class="section-kicker"><i class="fas fa-bolt"></i> <?= e(t('nav_offers')) ?></div>
            <h2 class="section-title"><?= e(t('section_offers')) ?></h2>
            <p class="section-sub"><?= e($lang === 'ar' ? 'عروض حصرية وأسعار لا تُقاوَم' : 'Exclusive deals you can\'t miss') ?></p>
        </div>
        <div class="offers-grid">
            <?php foreach ($offers as $index => $o):
                $carId  = (int)($o['car_id'] ?? 0);
                $oName  = isset($o['name_ar'], $o['name_en']) ? car_name($o) : '';
                $title  = offer_title($o);
                $desc   = offer_description($o);
                $banner = trim((string)($o['offer_image_path'] ?? ''));
                if ($banner === '' && (string)($o['image_path'] ?? '') !== '') $banner = (string)$o['image_path'];
                $daily  = (float)($o['daily_price'] ?? 0);
                $days   = max(1, (int)($o['days'] ?? 1));
                $monthly= (float)($o['monthly_price'] ?? 0);
                $total  = ($days >= 30 && $monthly > 0) ? $monthly : ($daily * $days);
            ?>
            <div class="offer-card card-hover-lift" data-aos="fade-up" data-aos-delay="<?= 100 + $index * 50 ?>">
                <div class="offer-image" style="background:linear-gradient(135deg,#1e293b,#0f172a);">
                    <?php if ($banner !== ''): ?>
                        <img src="<?= e(asset_url($banner)) ?>" alt="offer" loading="lazy">
                    <?php else: ?>
                        <div class="car-placeholder"><i class="fas fa-tag"></i></div>
                    <?php endif; ?>
                    <div class="offer-ribbon"><?= e($lang === 'ar' ? 'عرض خاص' : 'Special Deal') ?></div>
                </div>
                <div class="offer-content">
                    <h3 class="offer-title"><?= e($title !== '' ? $title : $oName) ?></h3>
                    <?php if ($desc !== ''): ?>
                        <p class="offer-desc"><?= e($desc) ?></p>
                    <?php endif; ?>
                    <div class="offer-details">
                        <div class="offer-detail">
                            <span class="offer-detail-label"><?= e(t('offer_duration')) ?></span>
                            <span class="offer-detail-value"><?= (int)$days ?> <?= e(t('days')) ?></span>
                        </div>
                        <div class="offer-detail">
                            <span class="offer-detail-label"><?= e($lang === 'ar' ? 'يومي' : 'Daily') ?></span>
                            <span class="offer-detail-value"><?= number_format($daily, 0) ?> <?= e(t('currency')) ?></span>
                        </div>
                        <div class="offer-total-price">
                            <span class="offer-total-label"><?= e($lang === 'ar' ? 'الإجمالي' : 'Total') ?></span>
                            <span class="offer-total-value"><?= number_format($total, 0) ?> <?= e(t('currency')) ?></span>
                        </div>
                    </div>
                    <div class="offer-actions">
                        <a href="offer.php?id=<?= (int)$o['id'] ?>" class="btn-details">
                            <i class="fas fa-info-circle"></i> <?= e($lang === 'ar' ? 'التفاصيل' : 'Details') ?>
                        </a>
                        <a href="#booking" class="btn-book" onclick="(function(){var s=document.querySelector('select[name=\'car_id\']');if(s)s.value='<?= $carId ?>';})()">
                            <i class="fas fa-calendar-check"></i> <?= e(t('book_now')) ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============= TESTIMONIALS ============= -->
<section class="section testimonials-section">
    <div class="section-container">
        <div class="section-head" data-aos="fade-up">
            <div class="section-kicker"><i class="fas fa-quote-left"></i> <?= e($lang === 'ar' ? 'آراء العملاء' : 'Testimonials') ?></div>
            <h2 class="section-title"><?= e($lang === 'ar' ? 'ماذا يقول عملاؤنا' : 'What Our Clients Say') ?></h2>
            <p class="section-sub"><?= e($lang === 'ar' ? 'ثقة عملائنا هي أكبر دليل على جودة خدماتنا' : 'Our clients\' trust is the best proof of our quality') ?></p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card card-hover-lift" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text"><?= e($lang === 'ar' ? 'خدمة ممتازة وسيارات جديدة ونظيفة. استمتعت كثيراً بالرحلة!' : 'Excellent service and new, clean cars. I really enjoyed the trip!') ?></p>
                <div class="testimonial-author">
                    <div class="author-avatar"><i class="fas fa-user"></i></div>
                    <div>
                        <div class="author-name"><?= e($lang === 'ar' ? 'أحمد محمد' : 'Ahmed M.') ?></div>
                        <div class="author-role"><?= e($lang === 'ar' ? 'رائد أعمال' : 'Business Owner') ?></div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card card-hover-lift" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text"><?= e($lang === 'ar' ? 'أفضل شركة تأجير سيارات تعاملت معها. الأسعار ممتازة والدعم ممتاز.' : 'The best car rental company I\'ve dealt with. Great prices and excellent support.') ?></p>
                <div class="testimonial-author">
                    <div class="author-avatar"><i class="fas fa-user"></i></div>
                    <div>
                        <div class="author-name"><?= e($lang === 'ar' ? 'سارة خالد' : 'Sarah K.') ?></div>
                        <div class="author-role"><?= e($lang === 'ar' ? 'مهندسة' : 'Engineer') ?></div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card card-hover-lift" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="testimonial-text"><?= e($lang === 'ar' ? 'استأجرت السيارة لعائلتي وكانت تجربة رائعة. شكراً جزيلاً!' : 'Rented a car for my family and it was a great experience. Thank you so much!') ?></p>
                <div class="testimonial-author">
                    <div class="author-avatar"><i class="fas fa-user"></i></div>
                    <div>
                        <div class="author-name"><?= e($lang === 'ar' ? 'محمد علي' : 'Mohammed A.') ?></div>
                        <div class="author-role"><?= e($lang === 'ar' ? 'طبيب' : 'Doctor') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============= BOOKING FORM ============= -->
<section id="booking" class="booking-section">
    <div class="booking-wrapper">

        <div class="booking-info">
            <div class="section-kicker"><i class="fas fa-calendar-alt"></i> <?= e($lang === 'ar' ? 'احجز الآن' : 'Book Now') ?></div>
            <h2 class="section-title" style="color:white;margin-bottom:14px;"><?= e($lang === 'ar' ? 'احجز سيارتك اليوم' : 'Book Your Car Today') ?></h2>
            <p class="section-sub" style="margin-bottom:48px;"><?= e($lang === 'ar' ? 'أرسل طلبك وسنتواصل معك خلال أقل من ساعة لتأكيد الحجز' : 'Send your request and we\'ll confirm within the hour') ?></p>

            <div class="booking-info-item">
                <div class="booking-info-icon"><i class="fas fa-phone-alt"></i></div>
                <div>
                    <div class="booking-info-label"><?= e($lang === 'ar' ? 'رقم الهاتف' : 'Phone Numbers') ?></div>
                    <div class="booking-info-value" dir="ltr">0597492182</div>
                    <div class="booking-info-value" dir="ltr">0599930120</div>
                </div>
            </div>
            
            <div class="booking-info-item">
                <div class="booking-info-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="booking-info-label"><?= e($lang === 'ar' ? 'ساعات العمل' : 'Working Hours') ?></div>
                    <div class="booking-info-value"><?= e($lang === 'ar' ? 'يومياً من 8:00 صباحاً - 10:00 مساءً' : 'Daily from 8:00 AM - 10:00 PM') ?></div>
                </div>
            </div>
            
            <div class="booking-info-item">
                <div class="booking-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <div class="booking-info-label"><?= e($lang === 'ar' ? 'العنوان' : 'Address') ?></div>
                    <div class="booking-info-value"><?= e($lang === 'ar' ? 'البيرة، بيت المحسري، بجانب جوال' : 'Al-Bireh, Beit Al-Muhasri, Next to Jawwal') ?></div>
                </div>
            </div>
            
            <div class="booking-trust">
                <div class="trust-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span><?= e($lang === 'ar' ? 'بياناتك آمنة' : 'Your data is safe') ?></span>
                </div>
                <div class="trust-badge">
                    <i class="fas fa-check-circle"></i>
                    <span><?= e($lang === 'ar' ? 'تأكيد سريع' : 'Quick confirmation') ?></span>
                </div>
            </div>
        </div>

        <div class="booking-form-card">
            <div class="booking-form-title"><?= e(t('booking_title')) ?></div>
            <div class="booking-form-sub"><?= e($lang === 'ar' ? 'جميع الحقول المضمّنة بـ * مطلوبة' : 'All fields marked * are required') ?></div>

            <?php if (isset($_GET['sent']) && $_GET['sent'] === '1'): ?>
                <div class="alert-success"><i class="fas fa-check-circle"></i> <?= e($lang === 'ar' ? 'تم إرسال طلبك بنجاح! سنتواصل معك قريباً.' : 'Request sent! We will contact you soon.') ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['sent']) && $_GET['sent'] === '0'): ?>
                <div class="alert-error"><i class="fas fa-exclamation-circle"></i> <?= e($lang === 'ar' ? 'حدث خطأ. تأكد من رفع الصور بصيغة صحيحة.' : 'An error occurred. Please check your file uploads.') ?></div>
            <?php endif; ?>

            <form method="POST" action="booking_submit.php" enctype="multipart/form-data" id="bookingForm" dir="<?= $lang === 'ar' ? 'rtl' : 'ltr' ?>">
                <?= csrf_field() ?>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><?= e(t('full_name')) ?> *</label>
                        <input type="text" class="form-control" name="customer_name" placeholder="<?= e($lang === 'ar' ? 'أدخل اسمك الكامل' : 'Your full name') ?>" dir="auto" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= e(t('phone')) ?> *</label>
                        <input type="tel" class="form-control" name="phone" placeholder="<?= e(t('phone')) ?> 05XXXXXXXX" dir="ltr" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><?= e(t('from_date')) ?> *</label>
                        <input type="date" class="form-control" name="start_date" dir="auto" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= e(t('to_date')) ?> *</label>
                        <input type="date" class="form-control" name="end_date" dir="auto" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?= e($lang === 'ar' ? 'اختر السيارة' : 'Select Car') ?> *</label>
                    <select class="form-control" name="car_id" id="carSelect" required>
                        <option value=""><?= e($lang === 'ar' ? '-- اختر سيارة --' : '-- Select a car --') ?></option>
                        <?php foreach ($cars as $car): ?>
                            <option value="<?= (int)$car['id'] ?>"><?= e(car_name($car)) ?> — <?= e($car['daily_price']) ?> <?= e(t('currency')) ?>/<?= e($lang === 'ar' ? 'يوم' : 'day') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Selected Deal Display -->
                <div class="selected-deal-display" id="selectedDealDisplay" style="display:none;">
                    <div class="selected-deal-badge">
                        <i class="fas fa-tag"></i> 
                        <span id="selectedDealText"><?= $lang === 'ar' ? 'الباقة المختارة' : 'Selected Package' ?></span>
                    </div>
                    <div class="selected-deal-info">
                        <div class="selected-deal-days" id="selectedDealDays">-</div>
                        <div class="selected-deal-price" id="selectedDealPrice">₪0</div>
                    </div>
                    <button type="button" class="selected-deal-clear" onclick="clearSelectedDeal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><?= e(t('id_image')) ?> *</label>
                        <input type="file" class="form-control" name="id_image" accept="image/*" required>
                        <div class="form-hint"><?= e($lang === 'ar' ? 'JPG أو PNG · حد أقصى 5MB' : 'JPG or PNG · max 5MB') ?></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= e(t('license_image')) ?> *</label>
                        <input type="file" class="form-control" name="license_image" accept="image/*" required>
                        <div class="form-hint"><?= e($lang === 'ar' ? 'JPG أو PNG · حد أقصى 5MB' : 'JPG or PNG · max 5MB') ?></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?= e(t('notes')) ?></label>
                    <textarea class="form-control" name="notes" placeholder="<?= e($lang === 'ar' ? 'أي متطلبات أو تفاصيل إضافية...' : 'Any special requirements...') ?>" dir="auto"></textarea>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> <?= e(t('send_request')) ?>
                </button>
                
                <div class="booking-divider">
                    <span><?= $lang === 'ar' ? 'أو' : 'OR' ?></span>
                </div>
                
                <a href="<?= get_whatsapp_link($lang === 'ar' 
                    ? 'مرحباً، أرغب في حجز سيارة من سوا لتأجير السيارات. الرجاء التواصل معي.'
                    : 'Hello, I would like to book a car from Sawa Rent Car. Please contact me.') ?>" 
                   class="btn-whatsapp" target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp"></i>
                    <?= $lang === 'ar' ? 'احجز عبر واتساب' : 'Book via WhatsApp' ?>
                </a>
            </form>
        </div>
    </div>
</section>

<script>
// Set minimum date to today
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.querySelectorAll('input[type="date"]').forEach(function(input) {
        input.setAttribute('min', today);
    });
    
    // Deal Calculator
    const slider = document.getElementById('daysSlider');
    if (slider) {
        const daysValue = document.getElementById('daysValue');
        const totalPrice = document.getElementById('totalPrice');
        const pricePerDay = document.getElementById('pricePerDay');
        const savingsAmount = document.getElementById('savingsAmount');
        const regularPrice = document.getElementById('regularPrice');
        const dealPrice = document.getElementById('dealPrice');
        const regularBar = document.getElementById('regularBar');
        const dealBar = document.getElementById('dealBar');
        const savingsPercent = document.getElementById('savingsPercent');
        
        function calculatePrice(days) {
            const tiers = [
                [1, <?= $priceDay1 ?>],
                [3, <?= $priceDay3 ?>],
                [10, <?= $priceDay10 ?>],
                [15, <?= $priceDay15 ?>],
                [20, <?= $priceDay20 ?>],
                [30, <?= $priceDay30 ?>]
            ];
            let price = <?= $priceDay1 ?>, prevTier = [1, <?= $priceDay1 ?>];
            const dayRate = <?= $priceDay1 ?>;
            for (let tier of tiers) {
                if (days === tier[0]) { price = tier[1]; break; }
                if (days < tier[0]) {
                    const daysDiff = tier[0] - prevTier[0];
                    const priceDiff = tier[1] - prevTier[1];
                    price = Math.round(prevTier[1] + ((priceDiff / daysDiff) * (days - prevTier[0])));
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
            const isRTL = document.documentElement.dir === 'rtl';
            const daysText = isRTL ? 'يوم' : 'Days';
            
            if (daysValue) daysValue.textContent = days;
            if (totalPrice) totalPrice.textContent = result.price.toLocaleString();
            if (pricePerDay) pricePerDay.textContent = result.perDayRate;
            if (savingsAmount) savingsAmount.textContent = '₪' + result.savings.toLocaleString();
            if (regularPrice) regularPrice.textContent = '₪' + result.regular.toLocaleString();
            if (dealPrice) dealPrice.textContent = '₪' + result.price.toLocaleString();
            if (regularBar) regularBar.style.width = '100%';
            if (dealBar) dealBar.style.width = ((result.price / 3600) * 100) + '%';
            if (savingsPercent) savingsPercent.textContent = result.savingsPct + '% OFF';
            
            // Update button info
            const dealBtnInfo = document.getElementById('dealBtnInfo');
            if (dealBtnInfo) {
                const btnDaysText = isRTL ? days + ' يوم' : days + ' Days';
                dealBtnInfo.textContent = btnDaysText + ' | ₪' + result.price.toLocaleString();
            }
            
            // Update slider track progress
            if (slider) {
                const percent = ((days - 1) / 29) * 100;
                slider.style.background = `linear-gradient(to left, #e2e8f0 ${100 - percent}%, linear-gradient(90deg, #1e40af, #3b82f6) ${100 - percent}%)`;
            }
        }
        
        // Select deal tier from pricing cards
        window.selectDealTier = function(days, price) {
            // Update slider
            if (slider) {
                slider.value = days;
                updateDisplay(days);
            }
            
            // Scroll to booking section
            const bookingSection = document.getElementById('booking');
            if (bookingSection) {
                bookingSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            
            // Show selected deal in booking form
            const dealDisplay = document.getElementById('selectedDealDisplay');
            const dealDays = document.getElementById('selectedDealDays');
            const dealPrice = document.getElementById('selectedDealPrice');
            const dealText = document.getElementById('selectedDealText');
            const selectedDaysInput = document.getElementById('selectedDays');
            const selectedPriceInput = document.getElementById('selectedPrice');
            
            if (dealDisplay) {
                dealDisplay.style.display = 'flex';
            }
            if (dealDays) {
                dealDays.textContent = days + ' <?= $lang === 'ar' ? 'أيام' : 'Days' ?>';
            }
            if (dealPrice) {
                dealPrice.textContent = '₪' + price.toLocaleString();
            }
            if (selectedDaysInput) {
                selectedDaysInput.value = days;
            }
            if (selectedPriceInput) {
                selectedPriceInput.value = price;
            }
            
            // Highlight the selected tier card
            highlightSelectedDeal(days);
        }
        
        // Highlight selected deal card
        function highlightSelectedDeal(days) {
            document.querySelectorAll('.deal-card').forEach(card => {
                card.classList.remove('deal-card-selected');
            });
            const selectedCard = document.querySelector(`.deal-card[data-days="${days}"]`);
            if (selectedCard) {
                selectedCard.classList.add('deal-card-selected');
            }
        }
        
        // Clear selected deal
        window.clearSelectedDeal = function() {
            const dealDisplay = document.getElementById('selectedDealDisplay');
            const selectedDaysInput = document.getElementById('selectedDays');
            const selectedPriceInput = document.getElementById('selectedPrice');
            
            if (dealDisplay) {
                dealDisplay.style.display = 'none';
            }
            if (selectedDaysInput) {
                selectedDaysInput.value = 1;
            }
            if (selectedPriceInput) {
                selectedPriceInput.value = 0;
            }
            
            document.querySelectorAll('.deal-card').forEach(card => {
                card.classList.remove('deal-card-selected');
            });
        }
        
        slider.addEventListener('input', function() {
            const days = parseInt(this.value);
            updateDisplay(days);
            highlightSelectedDeal(days);
            // Pause carousel when slider is used
            const heroCarousel = document.getElementById('heroCarousel');
            if (heroCarousel && bootstrap && bootstrap.Carousel) {
                const carouselInstance = bootstrap.Carousel.getInstance(heroCarousel);
                if (carouselInstance && typeof carouselInstance.pause === 'function') {
                    carouselInstance.pause();
                }
            }
        });
        
        slider.addEventListener('change', function() {
            // Resume carousel after slider interaction
            const heroCarousel = document.getElementById('heroCarousel');
            if (heroCarousel && bootstrap && bootstrap.Carousel) {
                const carouselInstance = bootstrap.Carousel.getInstance(heroCarousel);
                if (carouselInstance && typeof carouselInstance.cycle === 'function') {
                    carouselInstance.cycle();
                }
            }
        });
        
        updateDisplay(15);
    }
    
    // Hero Carousel hover to pause
    const heroCarousel = document.getElementById('heroCarousel');
    if (heroCarousel && typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
        heroCarousel.addEventListener('mouseenter', function() {
            const instance = bootstrap.Carousel.getInstance(this);
            if (instance && typeof instance.pause === 'function') instance.pause();
        });
        heroCarousel.addEventListener('mouseleave', function() {
            const instance = bootstrap.Carousel.getInstance(this);
            if (instance && typeof instance.cycle === 'function') instance.cycle();
        });
    }
});

// Open booking modal
function openBookingModal(days, price) {
    const isRTL = document.documentElement.dir === 'rtl';
    if (!days) days = parseInt(document.getElementById('daysValue')?.textContent || '15');
    if (!price) {
        const tiers = [
            [1, <?= $priceDay1 ?>],
            [3, <?= $priceDay3 ?>],
            [10, <?= $priceDay10 ?>],
            [15, <?= $priceDay15 ?>],
            [20, <?= $priceDay20 ?>],
            [30, <?= $priceDay30 ?>]
        ];
        let p = <?= $priceDay1 ?>, prevT = [1, <?= $priceDay1 ?>];
        for (let t of tiers) {
            if (days === t[0]) { p = t[1]; break; }
            if (days < t[0]) {
                p = Math.round(prevT[1] + ((t[1] - prevT[1]) / (t[0] - prevT[0])) * (days - prevT[0]));
                break;
            }
            prevT = t;
        }
        if (days >= 30) p = <?= $priceDay30 ?>;
        price = p;
    }
    
    const perDay = (price / days).toFixed(1);
    const lang = isRTL ? 'ar' : 'en';
    
    document.getElementById('selectedDays').value = days;
    document.getElementById('selectedPrice').value = price;
    document.getElementById('modalDealInfo').textContent = days + ' ' + (lang === 'ar' ? 'أيام' : 'days') + ' | ₪' + price.toLocaleString();
    document.getElementById('summaryDays').textContent = days + ' ' + (lang === 'ar' ? 'أيام' : 'Days');
    document.getElementById('summaryPrice').textContent = '₪' + price.toLocaleString();
    document.getElementById('summaryPerDay').textContent = '₪' + perDay + ' / ' + (lang === 'ar' ? 'يوم' : 'day');
    
    const startDate = new Date();
    const endDate = new Date();
    endDate.setDate(endDate.getDate() + days);
    document.getElementById('startDate').value = startDate.toISOString().split('T')[0];
    document.getElementById('endDate').value = endDate.toISOString().split('T')[0];
    
    const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
    modal.show();
}
</script>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1">
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
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="booking_submit.php" enctype="multipart/form-data" id="dealBookingForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="car_id" id="bookingCarId" value="">
                    <input type="hidden" name="offer_id" value="0">
                    <input type="hidden" name="selected_days" id="selectedDays" value="15">
                    <input type="hidden" name="selected_price" id="selectedPrice" value="1350">
                    
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
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-user"></i> <?= e(t('full_name')) ?> *</label>
                                <input type="text" name="customer_name" class="form-control" placeholder="<?= $lang === 'ar' ? 'اسمك الكامل' : 'Your full name' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-phone"></i> <?= e(t('phone')) ?> *</label>
                                <input type="tel" name="phone" class="form-control" placeholder="059xxxxxxxx" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-start"></i> <?= e(t('from_date')) ?> *</label>
                                <input type="date" name="start_date" class="form-control" id="startDate" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-end"></i> <?= e(t('to_date')) ?> *</label>
                                <input type="date" name="end_date" class="form-control" id="endDate" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label><i class="fas fa-id-card"></i> <?= $lang === 'ar' ? 'صورة الهوية' : 'ID Image' ?> *</label>
                                <input type="file" name="id_image" class="form-control" accept="image/*" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label><i class="fas fa-car"></i> <?= $lang === 'ar' ? 'رخصة القيادة' : 'License Image' ?> *</label>
                                <input type="file" name="license_image" class="form-control" accept="image/*" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-comment"></i> <?= e(t('notes')) ?></label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="<?= $lang === 'ar' ? 'ملاحظات...' : 'Notes...' ?>"></textarea>
                    </div>
                    
                    <button type="submit" class="btn-submit-deal">
                        <i class="fas fa-paper-plane"></i> <?= e(t('send_request')) ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============= CONTACT & MAP SECTION ============= -->
<section id="contact" class="contact-section-premium">
    <div class="contact-section-inner">

        <!-- Left: Contact Info Panel -->
        <div class="contact-info-panel">
            <!-- Header -->
            <div class="contact-panel-header">
                <div class="contact-panel-badge">
                    <i class="fas fa-map-marker-alt"></i>
                    <?= $lang === 'ar' ? 'تواصل معنا' : 'Contact Us' ?>
                </div>
                <h2 class="contact-panel-title">
                    <?= $lang === 'ar' ? 'نحن هنا لخدمتك' : 'We Are Here For You' ?>
                </h2>
                <p class="contact-panel-sub">
                    <?= $lang === 'ar' ? 'زورنا أو تواصل معنا في أي وقت خلال ساعات العمل' : 'Visit us or reach out anytime during working hours' ?>
                </p>
            </div>

            <!-- Contact Cards -->
            <div class="contact-cards-list">

                <!-- Phone 1 -->
                <a href="tel:0597492182" class="contact-info-card" id="contact-phone">
                    <div class="contact-card-icon contact-icon-phone">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-card-content">
                        <div class="contact-card-label"><?= $lang === 'ar' ? 'رقم الهاتف 1' : 'Phone 1' ?></div>
                        <div class="contact-card-value" dir="ltr">0597 492 182</div>
                        <div class="contact-card-sub"><?= $lang === 'ar' ? 'اتصل بنا مباشرة' : 'Call us directly' ?></div>
                    </div>
                    <div class="contact-card-arrow"><i class="fas fa-chevron-<?= $lang === 'ar' ? 'left' : 'right' ?>"></i></div>
                </a>

                <!-- Phone 2 -->
                <a href="tel:0599930120" class="contact-info-card" id="contact-phone2">
                    <div class="contact-card-icon contact-icon-phone">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-card-content">
                        <div class="contact-card-label"><?= $lang === 'ar' ? 'رقم الهاتف 2' : 'Phone 2' ?></div>
                        <div class="contact-card-value" dir="ltr">0599 930 120</div>
                        <div class="contact-card-sub"><?= $lang === 'ar' ? 'اتصل بنا مباشرة' : 'Call us directly' ?></div>
                    </div>
                    <div class="contact-card-arrow"><i class="fas fa-chevron-<?= $lang === 'ar' ? 'left' : 'right' ?>"></i></div>
                </a>
                </a>

                <!-- Address -->
                <a href="https://www.google.com/maps/search/?api=1&query=بيت+المحسري+البيرة+فلسطين" target="_blank" class="contact-info-card" id="contact-address">
                    <div class="contact-card-icon contact-icon-map">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-card-content">
                        <div class="contact-card-label"><?= $lang === 'ar' ? 'العنوان' : 'Address' ?></div>
                        <div class="contact-card-value"><?= $lang === 'ar' ? 'البيرة، بيت المحسري' : 'Al-Bireh, Beit Al-Mahsiri' ?></div>
                        <div class="contact-card-sub"><?= $lang === 'ar' ? 'بجانب جوال' : 'Next to Jawwal' ?></div>
                    </div>
                    <div class="contact-card-arrow"><i class="fas fa-chevron-<?= $lang === 'ar' ? 'left' : 'right' ?>"></i></div>
                </a>

                <!-- Working Hours -->
                <div class="contact-info-card no-link" id="contact-hours">
                    <div class="contact-card-icon contact-icon-clock">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-card-content">
                        <div class="contact-card-label"><?= $lang === 'ar' ? 'ساعات العمل' : 'Working Hours' ?></div>
                        <div class="contact-card-value"><?= $lang === 'ar' ? 'يومياً' : 'Daily' ?></div>
                        <div class="contact-card-sub"><?= $lang === 'ar' ? '8:00 صباحاً — 10:00 مساءً' : '8:00 AM — 10:00 PM' ?></div>
                    </div>
                    <div class="contact-status-dot"><span></span> <?= $lang === 'ar' ? 'مفتوح الآن' : 'Open Now' ?></div>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="contact-action-btns">
                <a href="https://wa.me/970597492182" target="_blank" class="contact-btn-whatsapp" id="contact-whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    <span><?= $lang === 'ar' ? 'واتساب' : 'WhatsApp' ?></span>
                </a>
                <a href="tel:0597492182" class="contact-btn-call" id="contact-call">
                    <i class="fas fa-phone"></i>
                    <span><?= $lang === 'ar' ? 'اتصل الآن' : 'Call Now' ?></span>
                </a>
                <a href="https://www.google.com/maps/search/?api=1&query=بيت+المحسري+البيرة" target="_blank" class="contact-btn-map" id="contact-directions">
                    <i class="fas fa-directions"></i>
                    <span><?= $lang === 'ar' ? 'الاتجاهات' : 'Directions' ?></span>
                </a>
            </div>

            <!-- Trust Badges -->
            <div class="contact-trust-row">
                <div class="contact-trust-item">
                    <i class="fas fa-shield-alt"></i>
                    <span><?= $lang === 'ar' ? 'بياناتك آمنة' : 'Your data is safe' ?></span>
                </div>
                <div class="contact-trust-item">
                    <i class="fas fa-check-circle"></i>
                    <span><?= $lang === 'ar' ? 'تأكيد سريع' : 'Quick confirmation' ?></span>
                </div>
            </div>
        </div>

        <!-- Right: Map Panel -->
        <div class="contact-map-panel">
            <div class="contact-map-wrap" id="mapContainer">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3389.6582531652156!2d35.21696!3d31.927931!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2zMzHCsDU1JzQwLjYiTiAzNcKwMTMnMDEuMSJF!5e0!3m2!1sen!2s!4v1700000000000!5m2!1sen!2s"
                    width="100%" 
                    height="100%" 
                    style="border:0;min-height:380px;" 
                    allowfullscreen 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

    </div>
</section>

<script>
// No JS needed for iframe map
</script>

<style>
/* =============================================
   PREMIUM CONTACT & MAP SECTION
   =============================================*/
.contact-section-premium {
    background: linear-gradient(135deg, #0a0f1e 0%, #0d1b2a 50%, #0a1628 100%);
    position: relative;
    overflow: hidden;
}
.contact-section-premium::before {
    content: '';
    position: absolute;
    top: -200px;
    left: -200px;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(30,64,175,0.12) 0%, transparent 70%);
    pointer-events: none;
}
.contact-section-premium::after {
    content: '';
    position: absolute;
    bottom: -150px;
    right: -150px;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(16,185,129,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.contact-section-inner {
    display: grid;
    grid-template-columns: 480px 1fr;
    min-height: 480px;
    position: relative;
    z-index: 1;
}

/* ---- Info Panel ---- */
.contact-info-panel {
    padding: 60px 48px;
    display: flex;
    flex-direction: column;
    gap: 0;
    border-right: 1px solid rgba(255,255,255,0.07);
}
[dir="rtl"] .contact-info-panel {
    border-right: none;
    border-left: 1px solid rgba(255,255,255,0.07);
}
.contact-panel-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(30,64,175,0.18);
    border: 1px solid rgba(59,130,246,0.25);
    color: #93c5fd;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 50px;
    margin-bottom: 18px;
    width: fit-content;
}
.contact-panel-title {
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    line-height: 1.2;
    margin: 0 0 10px;
    background: linear-gradient(135deg, #fff 60%, #93c5fd);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.contact-panel-sub {
    font-size: 0.92rem;
    color: rgba(255,255,255,0.5);
    line-height: 1.6;
    margin: 0 0 32px;
}

/* ---- Contact Cards ---- */
.contact-cards-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 28px;
}
.contact-info-card {
    display: flex;
    align-items: center;
    gap: 16px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    padding: 16px 20px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.contact-info-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(59,130,246,0.06), rgba(16,185,129,0.04));
    opacity: 0;
    transition: opacity 0.3s;
    border-radius: 16px;
}
.contact-info-card:hover::before { opacity: 1; }
.contact-info-card:hover {
    border-color: rgba(59,130,246,0.3);
    transform: translateX(-4px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
}
[dir="rtl"] .contact-info-card:hover { transform: translateX(4px); }
.contact-info-card.no-link { cursor: default; }
.contact-info-card.no-link:hover { transform: none; box-shadow: none; }

.contact-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.contact-icon-phone { background: rgba(59,130,246,0.15); color: #60a5fa; border: 1px solid rgba(59,130,246,0.2); }
.contact-icon-map   { background: rgba(239,68,68,0.12); color: #f87171; border: 1px solid rgba(239,68,68,0.2); }
.contact-icon-clock { background: rgba(16,185,129,0.12); color: #34d399; border: 1px solid rgba(16,185,129,0.2); }

.contact-card-content { flex: 1; min-width: 0; }
.contact-card-label {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.4);
    margin-bottom: 4px;
}
.contact-card-value {
    font-size: 1rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
}
.contact-card-sub {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.45);
    margin-top: 2px;
}
.contact-card-arrow {
    color: rgba(255,255,255,0.2);
    font-size: 0.85rem;
    transition: color 0.2s, transform 0.2s;
}
.contact-info-card:hover .contact-card-arrow {
    color: #60a5fa;
    transform: translateX(-3px);
}
[dir="rtl"] .contact-info-card:hover .contact-card-arrow { transform: translateX(3px); }

.contact-status-dot {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    color: #34d399;
}
.contact-status-dot span {
    width: 7px;
    height: 7px;
    background: #34d399;
    border-radius: 50%;
    display: inline-block;
    animation: pulse-dot 1.8s infinite;
}
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.4); }
}

/* ---- Action Buttons ---- */
.contact-action-btns {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
    margin-bottom: 24px;
}
.contact-btn-whatsapp,
.contact-btn-call,
.contact-btn-map {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 14px 10px;
    border-radius: 14px;
    font-weight: 700;
    font-size: 0.78rem;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}
.contact-btn-whatsapp {
    background: rgba(37,211,102,0.12);
    border-color: rgba(37,211,102,0.25);
    color: #25d366;
}
.contact-btn-whatsapp:hover {
    background: #25d366;
    color: #fff;
    box-shadow: 0 8px 24px rgba(37,211,102,0.35);
    transform: translateY(-2px);
}
.contact-btn-call {
    background: rgba(59,130,246,0.1);
    border-color: rgba(59,130,246,0.25);
    color: #60a5fa;
}
.contact-btn-call:hover {
    background: #3b82f6;
    color: #fff;
    box-shadow: 0 8px 24px rgba(59,130,246,0.35);
    transform: translateY(-2px);
}
.contact-btn-map {
    background: rgba(239,68,68,0.1);
    border-color: rgba(239,68,68,0.25);
    color: #f87171;
}
.contact-btn-map:hover {
    background: #ef4444;
    color: #fff;
    box-shadow: 0 8px 24px rgba(239,68,68,0.35);
    transform: translateY(-2px);
}
.contact-btn-whatsapp i,
.contact-btn-call i,
.contact-btn-map i { font-size: 1.3rem; }

/* ---- Trust Row ---- */
.contact-trust-row {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.06);
}
.contact-trust-item {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 0.8rem;
    color: rgba(255,255,255,0.4);
}
.contact-trust-item i { color: #34d399; font-size: 0.85rem; }

/* ---- Map Panel ---- */
.contact-map-panel {
    position: relative;
    overflow: hidden;
    min-height: 380px;
    border-radius: var(--radius-lg);
}
.contact-map-wrap {
    width: 100%;
    height: 100%;
    min-height: 380px;
    position: relative;
}
.contact-map-wrap iframe {
    width: 100%;
    height: 100%;
    min-height: 380px;
    border: none;
    display: block;
}
.contact-map-wrap .map-link-wrapper {
    position: absolute;
    inset: 0;
    display: block;
}
.contact-map-wrap #contactMap {
    width: 100%;
    height: 100%;
    min-height: 380px;
    z-index: 1;
}
.contact-map-wrap .map-open-btn {
    position: absolute;
    top: 16px;
    right: 16px;
    z-index: 1000;
    background: white;
    color: #333;
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}
[dir="rtl"] .contact-map-wrap .map-open-btn {
    right: auto;
    left: 16px;
}
.contact-map-wrap .map-open-btn:hover {
    background: #2563eb;
    color: white;
}
.contact-map-wrap .leaflet-popup-content-wrapper {
    border-radius: 8px;
}
.contact-map-wrap .leaflet-popup-content {
    margin: 12px 16px;
    font-family: 'Cairo', sans-serif;
}

/* ---- Map/Satellite Toggle ---- */
.map-view-toggle {
    position: absolute;
    top: 16px;
    right: 16px;
    z-index: 20;
    display: flex;
    gap: 4px;
    background: rgba(10,15,30,0.88);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 12px;
    padding: 4px;
}
[dir="rtl"] .map-view-toggle { right: auto; left: 16px; }
.map-toggle-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 9px;
    border: none;
    background: transparent;
    color: rgba(255,255,255,0.5);
    font-size: 0.78rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s ease;
    white-space: nowrap;
}
.map-toggle-btn i { font-size: 0.85rem; }
.map-toggle-btn.active {
    background: #3b82f6;
    color: #fff;
    box-shadow: 0 2px 10px rgba(59,130,246,0.4);
}
.map-toggle-btn:not(.active):hover {
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.8);
}
.map-brand-badge {
    position: absolute;
    bottom: 24px;
    left: 24px;
    background: rgba(10,15,30,0.92);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.1);
    color: white;
    padding: 10px 18px;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    font-size: 0.88rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    z-index: 5;
}
[dir="rtl"] .map-brand-badge { left: auto; right: 24px; }
.map-brand-badge i {
    color: #60a5fa;
    font-size: 1rem;
}

/* ---- Responsive ---- */
@media (max-width: 1024px) {
    .contact-section-inner {
        grid-template-columns: 1fr;
    }
    .contact-info-panel {
        border-right: none;
        border-left: none;
        border-bottom: 1px solid rgba(255,255,255,0.07);
        padding: 40px 28px;
    }
    .contact-map-panel { order: -1; }
    .contact-map-wrap, .contact-map-wrap iframe { min-height: 320px; }
}
@media (max-width: 640px) {
    .contact-info-panel { padding: 28px 18px; }
    .contact-panel-title { font-size: 1.4rem; }
    .contact-action-btns { grid-template-columns: 1fr 1fr; }
    .contact-btn-map { grid-column: 1 / -1; flex-direction: row; padding: 12px; }
    .contact-map-wrap, .contact-map-wrap iframe { min-height: 260px; }
    .map-toggle-btn span { display: none; }
    .map-toggle-btn { padding: 8px 10px; }
}

/* ---- Keep old map-info-card classes if referenced elsewhere ---- */
.map-info-card {
    position: absolute;
    top: 40px;
    right: 40px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    max-width: 350px;
    z-index: 10;
    border: 1px solid rgba(255,255,255,0.5);
    transition: transform 0.3s ease;
}

.map-info-card:hover {
    transform: translateY(-5px);
}

.map-info-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.map-info-logo {
    width: 50px;
    height: 50px;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.5rem;
}

.map-info-title h3 {
    margin: 0;
    font-size: 1.25rem;
    color: #1e293b;
    font-weight: 700;
}

.map-info-title span {
    font-size: 0.85rem;
    color: #64748b;
}

.map-info-body {
    margin-bottom: 25px;
}

.map-info-item {
    display: flex;
    gap: 12px;
    margin-bottom: 15px;
}

.map-info-item i {
    color: var(--primary);
    font-size: 1.1rem;
    margin-top: 3px;
}

.map-info-item p {
    margin: 0;
    color: #334155;
    font-size: 0.95rem;
    line-height: 1.5;
}

.map-info-footer {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.map-btn-whatsapp, .map-btn-directions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.map-btn-whatsapp {
    background: #25d366;
    color: white;
}

.map-btn-whatsapp:hover {
    background: #1faf54;
    box-shadow: 0 5px 15px rgba(37,211,102,0.3);
}

.map-btn-directions {
    background: #f1f5f9;
    color: #1e293b;
}

.map-btn-directions:hover {
    background: #e2e8f0;
}

@media (max-width: 768px) {
    .map-info-card {
        top: auto;
        bottom: 20px;
        right: 20px;
        left: 20px;
        max-width: none;
        padding: 20px;
    }
    .map-info-header {
        margin-bottom: 15px;
        padding-bottom: 15px;
    }
}
</style>

<?php include __DIR__ . '/partials/footer.php'; ?>
