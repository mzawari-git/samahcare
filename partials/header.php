<?php
require_once __DIR__ . '/../includes/helpers.php';

$lang       = current_lang();
$dir        = is_rtl() ? 'rtl' : 'ltr';
$scriptName = basename((string)($_SERVER['SCRIPT_NAME'] ?? ''));
$homePrefix = $scriptName === 'index.php' ? '' : 'index.php';

$page_title       = isset($page_title)       && $page_title       !== '' ? $page_title       : company_name();
$page_description = isset($page_description) && $page_description !== '' ? $page_description : ($lang === 'ar' ? 'تأجير سيارات في رام الله بأسعار تنافسية' : 'Car rental in Ramallah at competitive prices');
$page_keywords    = isset($page_keywords)    && $page_keywords    !== '' ? $page_keywords    : 'تأجير سيارات, rent car ramallah, car rental, cheapest car rental';
$page_image       = isset($page_image)       && $page_image       !== '' ? $page_image       : '';
$canonical        = isset($canonical)        && $canonical        !== '' ? $canonical        : '';
$schema_markup    = isset($schema_markup)   && $schema_markup   !== '' ? $schema_markup   : '';

$heroBg = isset($heroBg) ? $heroBg : '';

// Logo
$logoFromSettings = trim(setting('site_logo', ''));
$logoPath = '';
if ($logoFromSettings !== '') {
    $logoLocal = __DIR__ . '/../' . ltrim($logoFromSettings, '/');
    if (is_file($logoLocal)) $logoPath = $logoFromSettings;
}
if ($logoPath === '' && is_file(__DIR__ . '/../unnamed (1).jpg')) {
    $logoPath = 'unnamed (1).jpg';
}

$phone1 = setting('company_phone_1', '');
$phone2 = setting('company_phone_2', '');
$email = setting('company_email', '');
$facebook = setting('social_facebook', '');
$instagram = setting('social_instagram', '');

$digits = preg_replace('/\D+/', '', $phone1);
$wa = ($digits !== '' && $digits[0] === '0') ? '970' . substr($digits, 1) : $digits;

$siteUrl = setting('site_url', '');
?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>" dir="<?= e($dir) ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page_title) ?></title>
<meta name="description" content="<?= e($page_description) ?>">
<meta name="keywords" content="<?= e($page_keywords) ?>">
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="author" content="Sawa Rent Car">
<meta name="copyright" content="© <?= date('Y') ?> Sawa Rent Car">

<!-- Search Engine Verification Tags -->
<!-- Google Search Console - Replace YOUR_GOOGLE_CODE with your verification code -->
<meta name="google-site-verification" content="YOUR_GOOGLE_VERIFICATION_CODE">

<!-- Bing Webmaster Tools -->
<meta name="msvalidate.01" content="YOUR_BING_VERIFICATION_CODE">

<!-- Yandex Webmaster -->
<meta name="yandex-verification" content="YOUR_YANDEX_VERIFICATION_CODE">

<!-- Baidu Webmaster (China) -->
<meta name="baidu-site-verification" content="YOUR_BAIDU_VERIFICATION_CODE">

<!-- Naver Webmaster (Korea) -->
<meta name="naver-site-verification" content="YOUR_NAVER_VERIFICATION_CODE">

<!-- Pinterest -->
<meta name="pinterest" content="YOUR_PINTEREST_VERIFICATION_CODE">

<!-- Alexa -->
<meta name="alexaVerifyID" content="YOUR_ALEXA_VERIFICATION_CODE">

<!-- DuckDuckGo -->
<meta name="duckduckgo" content="index,follow">

<!-- Ratings & Reviews Schema -->
<meta name="rating" content="General">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?= e($canonical ?: abs_url('')) ?>">
<meta property="og:title" content="<?= e($page_title) ?>">
<meta property="og:description" content="<?= e($page_description) ?>">
<meta property="og:site_name" content="Sawa Rent Car">
<?php if ($page_image !== ''): ?>
<meta property="og:image" content="<?= e(abs_url(asset_url($page_image))) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<?php endif; ?>

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($page_title) ?>">
<meta name="twitter:description" content="<?= e($page_description) ?>">
<?php if ($page_image !== ''): ?>
<meta name="twitter:image" content="<?= e(abs_url(asset_url($page_image))) ?>">
<?php endif; ?>

<!-- Hreflang for multilingual -->
<link rel="alternate" hreflang="ar" href="<?= e(abs_url('')) ?>">
<link rel="alternate" hreflang="en" href="<?= e(str_replace('/ar/', '/en/', abs_url(''))) ?>">
<link rel="alternate" hreflang="x-default" href="<?= e(abs_url('')) ?>">

<!-- Canonical URL -->
<?php if ($canonical !== ''): ?>
<link rel="canonical" href="<?= e($canonical) ?>">
<?php endif; ?>

<!-- LocalBusiness Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "<?= e(company_name()) ?>",
  "alternateName": "Sawa Rent Car | سوا لتأجير السيارات",
  "description": "<?= e($page_description) ?>",
  "url": "<?= e($siteUrl ?: abs_url('')) ?>",
  "telephone": "<?= e($phone1) ?>",
  "email": "<?= e($email) ?>",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Ramallah",
    "addressLocality": "Ramallah",
    "addressRegion": "West Bank",
    "addressCountry": "PS"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "31.9454",
    "longitude": "35.2075"
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Saturday", "Sunday"],
      "opens": "08:00",
      "closes": "20:00"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": "Friday",
      "opens": "10:00",
      "closes": "18:00"
    }
  ],
  "priceRange": "₪₪",
  "paymentAccepted": ["Cash", "Credit Card"],
  "currenciesAccepted": ["ILS", "USD"],
  "sameAs": [
    <?php if ($facebook): ?>"<?= e($facebook) ?>",<?php endif; ?>
    <?php if ($instagram): ?>"<?= e($instagram) ?>"<?php endif; ?>
  ],
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.8",
    "reviewCount": "150",
    "bestRating": "5"
  }
}
</script>
<?php if ($canonical !== ''): ?>
<link rel="canonical" href="<?= e($canonical) ?>">
<?php endif; ?>
<?php if ($schema_markup !== ''): ?>
<script type="application/ld+json"><?= $schema_markup ?></script>
<?php endif; ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</noscript>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css"></noscript>

<!-- Bootstrap for inner pages that use bootstrap classes -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/<?= is_rtl() ? 'bootstrap.rtl' : 'bootstrap' ?>.min.css" rel="stylesheet">

<link rel="preload" href="<?= e(asset_url('assets/css/website-modern.css')) ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="<?= e(asset_url('assets/css/website-modern.css')) ?>"></noscript>
<link rel="stylesheet" href="<?= e(asset_url('assets/css/responsive.css')) ?>" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="<?= e(asset_url('assets/css/responsive.css')) ?>"></noscript>
<link rel="stylesheet" href="<?= e(asset_url('assets/css/animations.css')) ?>">
<link rel="manifest" href="<?= e(abs_url('site.webmanifest')) ?>">
<script>
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('sw.js');
  });
}
</script>

<?php if ($heroBg !== ''): ?>
<link rel="preload" as="image" href="<?= e(asset_url($heroBg)) ?>">
<style>
.site-hero { background-image: linear-gradient(rgba(10,15,30,.75), rgba(10,15,30,.8)), url('<?= e(asset_url($heroBg)) ?>') !important; background-size: cover !important; background-position: center !important; }
.hero-bg-img { display: none; }
</style>
<?php endif; ?>
<?php
$favicon = setting('site_favicon', '');
if ($favicon !== ''): ?>
<link rel="icon" type="image/<?= str_ends_with($favicon, '.svg') ? 'svg+xml' : (str_ends_with($favicon, '.ico') ? 'x-icon' : 'png') ?>" href="<?= e(asset_url($favicon)) ?>">
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- ============= NAVBAR ============= -->
<header class="site-header" id="site-header">
  <div class="nav-inner">

    <!-- Logo -->
    <a href="<?= e($homePrefix !== '' ? $homePrefix : 'index.php') ?>" class="nav-logo">
      <?php if ($logoPath !== ''): ?>
        <img src="<?= e(asset_url($logoPath)) ?>" alt="logo" style="width:40px;height:40px;object-fit:cover;border-radius:8px;">
      <?php else: ?>
        <div class="nav-logo-icon"><i class="fas fa-car"></i></div>
      <?php endif; ?>
      <div class="nav-logo-text">
        <span class="nav-logo-name">Sawa</span>
        <span class="nav-logo-sub"><?= e(company_name()) ?></span>
      </div>
    </a>

    <!-- Desktop links -->
    <ul class="nav-links">
      <li><a href="<?= e($homePrefix) ?>#cars"><i class="fas fa-car fa-sm"></i> <?= e(t('nav_cars')) ?></a></li>
      <li><a href="special-deal.php"><i class="fas fa-fire fa-sm"></i> <?= e($lang === 'ar' ? 'صفقة مميزة' : 'Best Deal') ?></a></li>
      <li>
        <a href="#" class="dropdown-trigger" role="button"><i class="fas fa-concierge-bell fa-sm"></i> <?= e($lang === 'ar' ? 'الخدمات' : 'Services') ?> <i class="fas fa-chevron-down arrow"></i></a>
        <ul class="dropdown-menu">
          <li><a href="services.php"><i class="fas fa-concierge-bell"></i> <?= e($lang === 'ar' ? 'خدماتنا' : 'Our Services') ?></a></li>
          <li><a href="fleet.php"><i class="fas fa-car-side"></i> <?= e($lang === 'ar' ? 'أسطول السيارات' : 'Our Fleet') ?></a></li>
          <li><a href="<?= e($homePrefix) ?>#offers"><i class="fas fa-tag"></i> <?= e(t('nav_offers')) ?></a></li>
          <li><a href="<?= e($homePrefix) ?>#booking"><i class="fas fa-calendar-alt"></i> <?= e($lang === 'ar' ? 'الحجز' : 'Book Now') ?></a></li>
          <li><a href="testimonials.php"><i class="fas fa-star"></i> <?= e($lang === 'ar' ? 'آراء العملاء' : 'Testimonials') ?></a></li>
          <li><a href="my-booking.php"><i class="fas fa-search"></i> <?= e($lang === 'ar' ? 'تتبع حجزي' : 'Track Booking') ?></a></li>
          <li><a href="faq.php"><i class="fas fa-question-circle"></i> <?= e($lang === 'ar' ? 'الأسئلة الشائعة' : 'FAQ') ?></a></li>
        </ul>
      </li>
      <li>
        <a href="#" class="dropdown-trigger" role="button"><i class="fas fa-info-circle fa-sm"></i> <?= e($lang === 'ar' ? 'المزيد' : 'More') ?> <i class="fas fa-chevron-down arrow"></i></a>
        <ul class="dropdown-menu">
          <li><a href="about.php"><i class="fas fa-info-circle"></i> <?= e($lang === 'ar' ? 'من نحن' : 'About Us') ?></a></li>
          <li><a href="blog.php"><i class="fas fa-blog"></i> <?= e($lang === 'ar' ? 'المدونة' : 'Blog') ?></a></li>
          <li><a href="locations.php"><i class="fas fa-map-marked-alt"></i> <?= e($lang === 'ar' ? 'فروعنا' : 'Locations') ?></a></li>
          <li><a href="reviews.php"><i class="fas fa-star"></i> <?= e($lang === 'ar' ? 'آراء العملاء' : 'Reviews') ?></a></li>
        </ul>
      </li>
      <li><a href="<?= $homePrefix ?>#contact" class="nav-highlight" onclick="if(window.location.href.indexOf('index.php') === -1 && window.location.href.indexOf('/') !== -1) { window.location.href = 'index.php#contact'; return false; }"><i class="fas fa-phone fa-sm"></i> <?= e(t('nav_contact')) ?></a></li>
    </ul>

    <!-- CTA -->
    <div class="nav-cta">
      <?php if ($phone1 !== ''): ?>
      <a href="https://wa.me/<?= e($wa) ?>" target="_blank" class="nav-cta" style="width:38px;height:38px;background:rgba(37,211,102,.12);border:1px solid rgba(37,211,102,.25);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#25d366;font-size:17px;text-decoration:none;transition:all .25s;">
        <i class="fab fa-whatsapp"></i>
      </a>
      <?php endif; ?>
      <a href="admin/login.php" class="btn-nav-admin">
        <i class="fas fa-shield-alt"></i> <?= e($lang === 'ar' ? 'الإدارة' : 'Admin') ?>
      </a>
      <!-- Mobile toggle -->
      <button class="nav-toggle" id="navToggle" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<!-- Mobile Menu -->
<nav class="nav-mobile" id="navMobile">
  <div class="nav-mobile-group">
    <div class="nav-mobile-label"><?= e($lang === 'ar' ? 'تصفح' : 'Browse') ?></div>
    <a href="<?= e($homePrefix) ?>#cars"><i class="fas fa-car"></i> <?= e(t('nav_cars')) ?></a>
    <a href="special-deal.php" style="background:linear-gradient(135deg, var(--accent), var(--accent-dark));color:white;"><i class="fas fa-fire"></i> <?= e($lang === 'ar' ? 'صفقة مميزة' : 'Best Deal') ?></a>
    <a href="fleet.php"><i class="fas fa-car-side"></i> <?= e($lang === 'ar' ? 'أسطول السيارات' : 'Our Fleet') ?></a>
  </div>
  <div class="nav-mobile-group">
    <div class="nav-mobile-label"><?= e($lang === 'ar' ? 'خدمات' : 'Services') ?></div>
    <a href="services.php"><i class="fas fa-concierge-bell"></i> <?= e($lang === 'ar' ? 'خدماتنا' : 'Our Services') ?></a>
    <a href="<?= e($homePrefix) ?>#offers"><i class="fas fa-tag"></i> <?= e(t('nav_offers')) ?></a>
    <a href="<?= e($homePrefix) ?>#booking"><i class="fas fa-calendar-alt"></i> <?= e($lang === 'ar' ? 'الحجز' : 'Book Now') ?></a>
    <a href="my-booking.php"><i class="fas fa-search"></i> <?= e($lang === 'ar' ? 'تتبع حجزي' : 'Track Booking') ?></a>
  </div>
  <div class="nav-mobile-group">
    <div class="nav-mobile-label"><?= e($lang === 'ar' ? 'المزيد' : 'More') ?></div>
    <a href="about.php"><i class="fas fa-info-circle"></i> <?= e($lang === 'ar' ? 'من نحن' : 'About Us') ?></a>
    <a href="blog.php"><i class="fas fa-blog"></i> <?= e($lang === 'ar' ? 'المدونة' : 'Blog') ?></a>
    <a href="locations.php"><i class="fas fa-map-marked-alt"></i> <?= e($lang === 'ar' ? 'فروعنا' : 'Locations') ?></a>
    <a href="testimonials.php"><i class="fas fa-star"></i> <?= e($lang === 'ar' ? 'آراء العملاء' : 'Testimonials') ?></a>
    <a href="faq.php"><i class="fas fa-question-circle"></i> <?= e($lang === 'ar' ? 'الأسئلة الشائعة' : 'FAQ') ?></a>
    <a href="reviews.php"><i class="fas fa-star"></i> <?= e($lang === 'ar' ? 'التقييمات' : 'Reviews') ?></a>
  </div>
  <div class="nav-mobile-group">
    <a href="<?= e($homePrefix) ?>#contact" style="background:linear-gradient(135deg,var(--primary),var(--primary-dark));border-color:transparent;color:white;"><i class="fas fa-phone"></i> <?= e(t('nav_contact')) ?></a>
    <a href="admin/login.php" style="background:rgba(37,99,235,.15);border-color:rgba(37,99,235,.3);color:var(--primary-light);"><i class="fas fa-shield-alt"></i> <?= e($lang === 'ar' ? 'لوحة الإدارة' : 'Admin Panel') ?></a>
  </div>
</nav>

<script>
(function(){
  const toggle = document.getElementById('navToggle');
  const menu   = document.getElementById('navMobile');
  const header = document.getElementById('site-header');
  toggle && toggle.addEventListener('click', function(){
    this.classList.toggle('open');
    menu.classList.toggle('open');
    document.body.style.overflow = menu.classList.contains('open') ? 'hidden' : '';
  });
  menu && menu.querySelectorAll('a').forEach(a => a.addEventListener('click', function(){
    toggle.classList.remove('open');
    menu.classList.remove('open');
    document.body.style.overflow = '';
  }));
  window.addEventListener('scroll', function(){
    header && header.classList.toggle('scrolled', window.scrollY > 20);
  });
  // Dropdown click toggle for touch devices
  document.querySelectorAll('.nav-links .dropdown-trigger').forEach(function(trigger){
    trigger.addEventListener('click', function(e){
      var li = this.closest('li');
      if (!li) return;
      var menu = li.querySelector('.dropdown-menu');
      if (!menu) return;
      var isOpen = menu.style.display === 'block';
      // Close all sibling dropdowns
      li.parentNode.querySelectorAll('.dropdown-menu').forEach(function(m){
        m.style.display = 'none';
      });
      menu.style.display = isOpen ? 'none' : 'block';
      e.preventDefault();
      e.stopPropagation();
    });
  });
  // Close dropdown on outside click
  document.addEventListener('click', function(e){
    if (!e.target.closest('.nav-links li')) {
      document.querySelectorAll('.nav-links .dropdown-menu').forEach(function(m){
        m.style.display = '';
      });
    }
  });
})();
</script>
