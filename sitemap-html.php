<?php

require_once __DIR__ . '/includes/helpers.php';

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

$page_title = ($lang === 'ar' ? 'خريطة الموقع' : 'Sitemap') . ' - ' . company_name();
$page_description = $lang === 'ar' 
    ? 'خريطة الموقع - شركة سوى لتأجير السيارات في رام الله'
    : 'Sitemap - Sawa Rent Car in Ramallah';
$canonical = abs_url('sitemap-html.php');

include __DIR__ . '/partials/header.php';

$cars = cars_active();
$offers = offers_active();
?>

<style>
.sitemap-page { padding: 60px 20px; max-width: 1000px; margin: 0 auto; }
.sitemap-title { text-align: center; margin-bottom: 40px; }
.sitemap-title h1 { color: var(--primary); margin-bottom: 10px; }
.sitemap-section { margin-bottom: 40px; }
.sitemap-section h2 { color: #333; font-size: 1.5rem; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid var(--primary); }
.sitemap-list { list-style: none; padding: 0; }
.sitemap-list li { margin-bottom: 12px; }
.sitemap-list a { color: var(--primary); text-decoration: none; font-size: 1.1rem; transition: color 0.3s; }
.sitemap-list a:hover { color: var(--accent); }
.sitemap-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; }
</style>

<div class="sitemap-page">
    <div class="sitemap-title">
        <h1><?= $lang === 'ar' ? 'خريطة الموقع' : 'Sitemap' ?></h1>
        <p><?= $lang === 'ar' ? 'تصفح جميع صفحات موقع سوى لتأجير السيارات' : 'Browse all pages of Sawa Rent Car' ?></p>
    </div>

    <div class="sitemap-grid">
        <!-- Main Pages -->
        <div class="sitemap-section">
            <h2><?= $lang === 'ar' ? 'الصفحات الرئيسية' : 'Main Pages' ?></h2>
            <ul class="sitemap-list">
                <li><a href="index.php"><?= $lang === 'ar' ? 'الرئيسية' : 'Home' ?></a></li>
                <li><a href="special-deal.php"><?= $lang === 'ar' ? 'عروض خاصة' : 'Special Deals' ?></a></li>
                <li><a href="privacy.php"><?= $lang === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' ?></a></li>
                <li><a href="terms.php"><?= $lang === 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' ?></a></li>
                <li><a href="payment_methods.php"><?= $lang === 'ar' ? 'طرق الدفع' : 'Payment Methods' ?></a></li>
            </ul>
        </div>

        <!-- Cars -->
        <div class="sitemap-section">
            <h2><?= $lang === 'ar' ? 'السيارات' : 'Cars' ?></h2>
            <ul class="sitemap-list">
                <?php foreach ($cars as $car): ?>
                <li><a href="car.php?id=<?= (int)$car['id'] ?>"><?= e(car_name($car)) ?></a></li>
                <?php endforeach; ?>
                <?php if (count($cars) === 0): ?>
                <li><?= $lang === 'ar' ? 'لا توجد سيارات متاحة' : 'No cars available' ?></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Offers -->
        <div class="sitemap-section">
            <h2><?= $lang === 'ar' ? 'العروض' : 'Offers' ?></h2>
            <ul class="sitemap-list">
                <?php foreach ($offers as $offer): ?>
                <li><a href="offer.php?id=<?= (int)$offer['id'] ?>"><?= e(offer_title($offer)) ?></a></li>
                <?php endforeach; ?>
                <?php if (count($offers) === 0): ?>
                <li><?= $lang === 'ar' ? 'لا توجد عروض متاحة' : 'No offers available' ?></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Services -->
        <div class="sitemap-section">
            <h2><?= $lang === 'ar' ? 'خدماتنا' : 'Our Services' ?></h2>
            <ul class="sitemap-list">
                <li><?= $lang === 'ar' ? 'تأجير سيارات يومي' : 'Daily Car Rental' ?></li>
                <li><?= $lang === 'ar' ? 'تأجير سيارات شهري' : 'Monthly Car Rental' ?></li>
                <li><?= $lang === 'ar' ? 'توصيل مجاني' : 'Free Delivery' ?></li>
                <li><?= $lang === 'ar' ? 'تأمين شامل' : 'Full Insurance' ?></li>
                <li><?= $lang === 'ar' ? 'دعم 24/7' : '24/7 Support' ?></li>
            </ul>
        </div>

        <!-- Contact -->
        <div class="sitemap-section">
            <h2><?= $lang === 'ar' ? 'اتصل بنا' : 'Contact Us' ?></h2>
            <ul class="sitemap-list">
                <li><?= $lang === 'ar' ? 'الهاتف: 0597492182' : 'Phone: 0597492182' ?></li>
                <li><?= $lang === 'ar' ? 'البريد: info@sawarentcar.ps' : 'Email: info@sawarentcar.ps' ?></li>
                <li><?= $lang === 'ar' ? 'العنوان: رام الله، فلسطين' : 'Address: Ramallah, Palestine' ?></li>
            </ul>
        </div>

        <!-- Locations -->
        <div class="sitemap-section">
            <h2><?= $lang === 'ar' ? 'المناطق' : 'Areas' ?></h2>
            <ul class="sitemap-list">
                <li><?= $lang === 'ar' ? 'تأجير سيارات رام الله' : 'Car Rental Ramallah' ?></li>
                <li><?= $lang === 'ar' ? 'تأجير سيارات البيرة' : 'Car Rental Al-Bireh' ?></li>
                <li><?= $lang === 'ar' ? 'تأجير سيارات نابلس' : 'Car Rental Nablus' ?></li>
                <li><?= $lang === 'ar' ? 'تأجير سيارات جنين' : 'Car Rental Jenin' ?></li>
                <li><?= $lang === 'ar' ? 'تأجير سيارات الخليل' : 'Car Rental Hebron' ?></li>
            </ul>
        </div>
    </div>

    <div style="text-align: center; margin-top: 40px; padding: 20px; background: #f5f5f5; border-radius: 10px;">
        <p><strong>Sawa Rent Car</strong> - <?= $lang === 'ar' ? 'أفضل شركة تأجير سيارات في رام الله' : 'Best Car Rental Company in Ramallah' ?></p>
        <p style="font-size: 0.9rem; color: #666;">
            &copy; <?= date('Y') ?> Sawa Rent Car. All rights reserved.
        </p>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
