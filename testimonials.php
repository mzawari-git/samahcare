<?php
require_once __DIR__ . '/includes/helpers.php';
$lang = current_lang();
$dir  = is_rtl() ? 'rtl' : 'ltr';
$page_title       = $lang === 'ar' ? 'آراء العملاء - Sawa Rent Car' : 'Testimonials - Sawa Rent Car';
$page_description = $lang === 'ar' ? 'تعرف على آراء وتجارب عملائنا مع خدمة تأجير السيارات في رام الله والبيرة.' : 'Read reviews and experiences from our car rental customers in Ramallah and Al-Bireh.';
$canonical        = abs_url('testimonials.php');
$testimonials = [
  ['name_ar' => 'أحمد خالد', 'name_en' => 'Ahmed Khaled', 'text_ar' => 'خدمة ممتازة وسيارات نظيفة جداً. أنصح الجميع بالتعامل معهم.', 'text_en' => 'Excellent service and very clean cars. I recommend everyone to deal with them.', 'rating' => 5, 'date' => '2026-01-15'],
  ['name_ar' => 'سارة محمد', 'name_en' => 'Sara Mohammed', 'text_ar' => 'أسعار مناسبة وسيارات حديثة. تجربة رائعة وسأكررها بالتأكيد.', 'text_en' => 'Reasonable prices and modern cars. Great experience and I will definitely repeat it.', 'rating' => 5, 'date' => '2026-02-20'],
  ['name_ar' => 'محمود علي', 'name_en' => 'Mahmoud Ali', 'text_ar' => 'توصيل مجاني للسيارة إلى المنزل، وسرعة في الإجراءات. شكراً لكم.', 'text_en' => 'Free car delivery to home, and fast procedures. Thank you.', 'rating' => 4, 'date' => '2026-03-10'],
  ['name_ar' => 'نور حسن', 'name_en' => 'Noor Hasan', 'text_ar' => 'فريق متعاون وخدمة عملاء ممتازة. السيارة كانت بحالة ممتازة.', 'text_en' => 'Cooperative team and excellent customer service. The car was in excellent condition.', 'rating' => 5, 'date' => '2026-03-22'],
  ['name_ar' => 'عمر يوسف', 'name_en' => 'Omar Yousuf', 'text_ar' => 'أفضل شركة تأجير سيارات في رام الله. أسعار منافسة وخدمة متميزة.', 'text_en' => 'Best car rental company in Ramallah. Competitive prices and distinguished service.', 'rating' => 5, 'date' => '2026-04-05'],
  ['name_ar' => 'ليلى أحمد', 'name_en' => 'Layla Ahmed', 'text_ar' => 'استأجرت سيارة لمدة أسبوع وكانت التجربة رائعة. أنصح بشدة.', 'text_en' => 'I rented a car for a week and the experience was wonderful. Highly recommended.', 'rating' => 4, 'date' => '2026-04-18'],
];
include __DIR__ . '/partials/header.php';
?>
<section class="page-hero" style="background:linear-gradient(135deg,var(--dark-2),var(--dark));padding:120px 20px 60px;text-align:center;">
  <div class="section-container">
    <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:800;color:white;margin-bottom:16px;"><?= $lang === 'ar' ? 'آراء العملاء' : 'Testimonials' ?></h1>
    <p style="font-size:clamp(1rem,2vw,1.2rem);color:rgba(255,255,255,.7);max-width:600px;margin:0 auto;">
      <?= $lang === 'ar' ? 'ماذا يقول عملاؤنا عنا' : 'What our customers say about us' ?>
    </p>
  </div>
</section>
<section class="section" style="padding:80px 20px;">
  <div class="section-container">
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(350px,1fr));gap:30px;">
      <?php $delay = 0; foreach ($testimonials as $t): $delay += 100; ?>
      <div style="background:var(--dark-2);border:1px solid rgba(255,255,255,.06);border-radius:var(--radius-lg);padding:40px 30px;position:relative;" data-aos="fade-up" data-aos-delay="<?= min($delay, 400) ?>">
        <div style="position:absolute;top:20px;<?= $dir === 'rtl' ? 'left' : 'right' ?>:20px;color:rgba(245,158,11,.15);font-size:48px;"><i class="fas fa-quote-<?= $dir === 'rtl' ? 'right' : 'left' ?>"></i></div>
        <div style="display:flex;gap:4px;margin-bottom:16px;">
          <?php for ($i = 1; $i <= 5; $i++): ?>
          <i class="fas fa-star" style="color:<?= $i <= $t['rating'] ? 'var(--accent)' : 'rgba(255,255,255,.15)' ?>;font-size:16px;"></i>
          <?php endfor; ?>
        </div>
        <p style="color:rgba(255,255,255,.7);line-height:1.8;font-size:.95rem;margin-bottom:20px;">"<?= e($t[$lang === 'ar' ? 'text_ar' : 'text_en']) ?>"</p>
        <div style="display:flex;align-items:center;gap:12px;padding-top:16px;border-top:1px solid rgba(255,255,255,.05);">
          <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-light));display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:1rem;">
            <?= e(mb_substr($t[$lang === 'ar' ? 'name_ar' : 'name_en'], 0, 1)) ?>
          </div>
          <div>
            <div style="color:white;font-weight:600;font-size:.95rem;"><?= e($t[$lang === 'ar' ? 'name_ar' : 'name_en']) ?></div>
            <div style="color:rgba(255,255,255,.35);font-size:.8rem;"><?= e($t['date']) ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php include __DIR__ . '/partials/footer.php'; ?>