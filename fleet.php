<?php
require_once __DIR__ . '/includes/helpers.php';
$lang = current_lang();
$dir  = is_rtl() ? 'rtl' : 'ltr';
$page_title       = $lang === 'ar' ? 'أسطول السيارات - Sawa Rent Car' : 'Our Fleet - Sawa Rent Car';
$page_description = $lang === 'ar' ? 'تصفح أسطولنا من السيارات الحديثة المتاحة للتأجير في رام الله والبيرة. سيارات اقتصادية، عائلية، وفاخرة.' : 'Browse our fleet of modern cars available for rent in Ramallah and Al-Bireh. Economy, family, and luxury cars.';
$canonical        = abs_url('fleet.php');
$cars = cars_active();
include __DIR__ . '/partials/header.php';
?>
<section class="page-hero" style="background:linear-gradient(135deg,var(--dark-2),var(--dark));padding:120px 20px 60px;text-align:center;">
  <div class="section-container">
    <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:800;color:white;margin-bottom:16px;"><?= $lang === 'ar' ? 'أسطول السيارات' : 'Our Fleet' ?></h1>
    <p style="font-size:clamp(1rem,2vw,1.2rem);color:rgba(255,255,255,.7);max-width:600px;margin:0 auto;">
      <?= $lang === 'ar' ? 'اختر سيارتك المثالية من أسطولنا المتنوع' : 'Choose your perfect car from our diverse fleet' ?>
    </p>
  </div>
</section>
<section class="section" style="padding:80px 20px;">
  <div class="section-container">
    <?php if (empty($cars)): ?>
      <div style="text-align:center;padding:60px 20px;color:rgba(255,255,255,.5);">
        <i class="fas fa-car" style="font-size:48px;margin-bottom:16px;opacity:.3;"></i>
        <p><?= $lang === 'ar' ? 'لا توجد سيارات متاحة حالياً' : 'No cars available at the moment' ?></p>
      </div>
    <?php else: ?>
      <div class="fleet-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:30px;">
        <?php foreach ($cars as $car):
          $name = car_name($car);
          $type = car_type($car);
          $img  = !empty($car['image_path']) ? asset_url($car['image_path']) : '';
          $price = (float)($car['price'] ?? 0);
        ?>
        <div class="fleet-card" style="background:var(--dark-2);border:1px solid rgba(255,255,255,.06);border-radius:var(--radius-lg);overflow:hidden;transition:all .3s;" data-aos="fade-up">
          <?php if ($img): ?>
          <div style="height:220px;overflow:hidden;">
            <img src="<?= e($img) ?>" alt="<?= e($name) ?>" style="width:100%;height:100%;object-fit:cover;transition:transform .5s;" loading="lazy">
          </div>
          <?php endif; ?>
          <div style="padding:24px;">
            <h3 style="font-size:1.2rem;font-weight:700;color:white;margin-bottom:8px;"><?= e($name) ?></h3>
            <div style="color:var(--primary-light);font-size:.85rem;font-weight:600;margin-bottom:12px;"><?= e($type) ?></div>
            <?php if ($price > 0): ?>
            <div style="margin-bottom:16px;">
              <span style="font-size:1.4rem;font-weight:800;color:var(--accent);">$<?= number_format($price, 2) ?></span>
              <span style="color:rgba(255,255,255,.4);font-size:.85rem;"> / <?= $lang === 'ar' ? 'اليوم' : 'day' ?></span>
            </div>
            <?php endif; ?>
            <a href="car.php?id=<?= (int)$car['id'] ?>" class="btn-primary" style="display:inline-block;padding:10px 28px;background:var(--primary);color:white;border-radius:var(--radius);text-decoration:none;font-weight:600;font-size:.9rem;transition:all .3s;">
              <?= $lang === 'ar' ? 'عرض التفاصيل' : 'View Details' ?>
            </a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php include __DIR__ . '/partials/footer.php'; ?>