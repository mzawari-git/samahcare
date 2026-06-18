<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/map_functions.php';
$lang = current_lang();
$dir  = is_rtl() ? 'rtl' : 'ltr';
$page_title       = $lang === 'ar' ? 'فروعنا - Sawa Rent Car' : 'Our Locations - Sawa Rent Car';
$page_description = $lang === 'ar' ? 'تعرف على مواقع فروعنا ونقاط تسليم واستلام السيارات في رام الله والبيرة.' : 'Find our branch locations and car delivery/pickup points in Ramallah and Al-Bireh.';
$canonical        = abs_url('locations.php');
include __DIR__ . '/partials/header.php';
$locations = [
  [
    'name_ar' => 'الفرع الرئيسي - البيرة',
    'name_en' => 'Main Branch - Al-Bireh',
    'address_ar' => 'البيرة، بيت المحسري، بجانب جوال',
    'address_en' => 'Al-Bireh, Beit Al-Muhasri, beside Jawwal',
    'phone' => '0597492182',
    'hours_ar' => 'يومياً 8:00 صباحاً - 10:00 مساءً',
    'hours_en' => 'Daily 8:00 AM - 10:00 PM',
    'icon' => 'fas fa-map-marker-alt'
  ]
];
?>
<section class="page-hero" style="background:linear-gradient(135deg,var(--dark-2),var(--dark));padding:120px 20px 60px;text-align:center;">
  <div class="section-container">
    <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:800;color:white;margin-bottom:16px;"><?= $lang === 'ar' ? 'فروعنا' : 'Our Locations' ?></h1>
    <p style="font-size:clamp(1rem,2vw,1.2rem);color:rgba(255,255,255,.7);max-width:600px;margin:0 auto;">
      <?= $lang === 'ar' ? 'مواقعنا في رام الله والبيرة لتسهيل وصولك إلينا' : 'Our locations in Ramallah and Al-Bireh for your convenience' ?>
    </p>
  </div>
</section>
<section class="section" style="padding:80px 20px;">
  <div class="section-container">
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(400px,1fr));gap:30px;">
      <?php foreach ($locations as $l): ?>
      <div style="background:var(--dark-2);border:1px solid rgba(255,255,255,.06);border-radius:var(--radius-lg);overflow:hidden;" data-aos="fade-up">
        <div style="padding:30px;">
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
            <div style="width:50px;height:50px;border-radius:12px;background:rgba(37,99,235,.12);display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--primary-light);flex-shrink:0;">
              <i class="<?= $l['icon'] ?>"></i>
            </div>
            <h2 style="font-size:1.2rem;font-weight:700;color:white;margin:0;"><?= e($l[$lang === 'ar' ? 'name_ar' : 'name_en']) ?></h2>
          </div>
          <div style="display:grid;gap:14px;">
            <div style="display:flex;gap:12px;align-items:flex-start;">
              <i class="fas fa-map-pin" style="color:var(--accent);margin-top:3px;flex-shrink:0;"></i>
              <span style="color:rgba(255,255,255,.7);font-size:.95rem;"><?= e($l[$lang === 'ar' ? 'address_ar' : 'address_en']) ?></span>
            </div>
            <div style="display:flex;gap:12px;align-items:center;">
              <i class="fas fa-phone" style="color:var(--primary-light);flex-shrink:0;"></i>
              <a href="tel:<?= e($l['phone']) ?>" style="color:rgba(255,255,255,.7);text-decoration:none;font-size:.95rem;" dir="ltr"><?= e($l['phone']) ?></a>
            </div>
            <div style="display:flex;gap:12px;align-items:center;">
              <i class="fas fa-clock" style="color:#25d366;flex-shrink:0;"></i>
              <span style="color:rgba(255,255,255,.7);font-size:.95rem;"><?= e($l[$lang === 'ar' ? 'hours_ar' : 'hours_en']) ?></span>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="section" style="padding:0 20px 80px;">
  <div class="section-container">
    <div style="border-radius:var(--radius-lg);overflow:hidden;border:1px solid rgba(255,255,255,.06);" data-aos="fade-up">
      <?php echo render_footer_map(); ?>
    </div>
  </div>
</section>
<?php include __DIR__ . '/partials/footer.php'; ?>