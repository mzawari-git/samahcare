<?php
require_once __DIR__ . '/includes/helpers.php';
$lang = current_lang();
$dir  = is_rtl() ? 'rtl' : 'ltr';
$page_title       = $lang === 'ar' ? 'خدماتنا - Sawa Rent Car' : 'Our Services - Sawa Rent Car';
$page_description = $lang === 'ar' ? 'تعرف على خدمات تأجير السيارات المتميزة التي نقدمها: تأمين شامل، توصيل مجاني، سائق خاص، وخدمة 24 ساعة.' : 'Discover our premium car rental services: full insurance, free delivery, private driver, and 24/7 support.';
$canonical        = abs_url('services.php');
include __DIR__ . '/partials/header.php';
$services = [
  [
    'icon' => 'fas fa-shield-alt',
    'title_ar' => 'تأمين شامل',
    'title_en' => 'Full Insurance',
    'desc_ar' => 'جميع سياراتنا مؤمنة تأميناً شاملاً ضد الحوادث والسرقة والضرر، لتضمن راحة بالك اثناء القيادة.',
    'desc_en' => 'All our vehicles are fully insured against accidents, theft, and damage for your peace of mind.'
  ],
  [
    'icon' => 'fas fa-truck',
    'title_ar' => 'توصيل واستلام مجاني',
    'title_en' => 'Free Delivery & Pickup',
    'desc_ar' => 'نوفر خدمة توصيل السيارة إلى أي مكان في رام الله والبيرة مجاناً، واستلامها من نفس الموقع.',
    'desc_en' => 'Free delivery of your rental car anywhere in Ramallah and Al-Bireh, with pickup from the same location.'
  ],
  [
    'icon' => 'fas fa-clock',
    'title_ar' => 'خدمة 24 ساعة',
    'title_en' => '24/7 Support',
    'desc_ar' => 'فريق دعم متاح على مدار الساعة لمساعدتك في أي وقت، مع خدمة طوارئ على مدار الأسبوع.',
    'desc_en' => 'Our support team is available around the clock to assist you anytime, with emergency service 7 days a week.'
  ],
  [
    'icon' => 'fas fa-user-tie',
    'title_ar' => 'سائق خاص (اختياري)',
    'title_en' => 'Private Driver (Optional)',
    'desc_ar' => 'يمكنك طلب سائق خاص بأسعار رمزية، سواء للتنقل اليومي أو الرحلات الطويلة.',
    'desc_en' => 'Request a private driver at nominal rates, whether for daily commutes or long trips.'
  ],
  [
    'icon' => 'fas fa-hand-holding-usd',
    'title_ar' => 'أسعار تنافسية',
    'title_en' => 'Competitive Pricing',
    'desc_ar' => 'أفضل الأسعار في السوق مع عروض خاصة للإيجار اليومي والأسبوعي والشهري. خصومات للعملاء الدائمين.',
    'desc_en' => 'Best prices in the market with special offers for daily, weekly, and monthly rentals. Discounts for regular customers.'
  ],
  [
    'icon' => 'fas fa-wifi',
    'title_ar' => 'سيارات حديثة ومجهزة',
    'title_en' => 'Modern & Equipped Cars',
    'desc_ar' => 'أسطول من السيارات الحديثة المزودة بأحدث التقنيات، مكيفة الهواء، ومزودة بأنظمة ترفيه وملاحة.',
    'desc_en' => 'A fleet of modern cars equipped with the latest technology, air conditioning, entertainment and navigation systems.'
  ]
];
?>
<section class="page-hero" style="background:linear-gradient(135deg, var(--dark-2), var(--dark));padding:120px 20px 60px;text-align:center;">
  <div class="section-container">
    <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:800;color:white;margin-bottom:16px;">
      <?= $lang === 'ar' ? 'خدماتنا' : 'Our Services' ?>
    </h1>
    <p style="font-size:clamp(1rem,2vw,1.2rem);color:rgba(255,255,255,.7);max-width:600px;margin:0 auto;">
      <?= $lang === 'ar' ? 'نقدم لكم أفضل خدمات تأجير السيارات في رام الله والبيرة' : 'We offer the best car rental services in Ramallah and Al-Bireh' ?>
    </p>
  </div>
</section>
<section class="section" style="padding:80px 20px;">
  <div class="section-container">
    <div class="section-head" style="text-align:center;margin-bottom:60px;">
      <span class="section-kicker"><?= $lang === 'ar' ? 'ماذا نقدم' : 'What We Offer' ?></span>
      <h2 class="section-title"><?= $lang === 'ar' ? 'خدمات متكاملة تلبي احتياجاتك' : 'Comprehensive Services for Your Needs' ?></h2>
      <p class="section-sub"><?= $lang === 'ar' ? 'نسعى دائماً لتقديم أفضل تجربة تأجير سيارات لعملائنا' : 'We always strive to provide the best car rental experience for our customers' ?></p>
    </div>
    <div class="services-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:30px;">
      <?php foreach ($services as $s): ?>
      <div class="service-card" style="background:var(--dark-2);border:1px solid rgba(255,255,255,.06);border-radius:var(--radius-lg);padding:40px 30px;transition:all .3s ease;text-align:center;" data-aos="fade-up">
        <div style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,rgba(37,99,235,.15),rgba(59,130,246,.08));display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:28px;color:var(--primary-light);transition:all .3s;">
          <i class="<?= $s['icon'] ?>"></i>
        </div>
        <h3 style="font-size:1.25rem;font-weight:700;color:white;margin-bottom:12px;"><?= $s[$lang === 'ar' ? 'title_ar' : 'title_en'] ?></h3>
        <p style="color:rgba(255,255,255,.6);line-height:1.7;font-size:.95rem;"><?= $s[$lang === 'ar' ? 'desc_ar' : 'desc_en'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="section" style="padding:80px 20px;background:var(--dark-2);">
  <div class="section-container">
    <div class="cta-box" style="background:linear-gradient(135deg,rgba(37,99,235,.1),rgba(245,158,11,.05));border:1px solid rgba(37,99,235,.15);border-radius:var(--radius-lg);padding:60px 40px;text-align:center;">
      <h2 style="font-size:clamp(1.5rem,3vw,2.2rem);font-weight:800;color:white;margin-bottom:16px;">
        <?= $lang === 'ar' ? 'جاهز لتجربة قيادة استثنائية؟' : 'Ready for an Exceptional Driving Experience?' ?>
      </h2>
      <p style="color:rgba(255,255,255,.6);max-width:500px;margin:0 auto 30px;font-size:1.05rem;">
        <?= $lang === 'ar' ? 'احجز سيارتك الآن واستمتع بخدماتنا المتميزة' : 'Book your car now and enjoy our premium services' ?>
      </p>
      <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
        <a href="index.php#booking" class="btn-primary" style="padding:14px 36px;background:var(--primary);color:white;border-radius:var(--radius);text-decoration:none;font-weight:700;transition:all .3s;">
          <?= $lang === 'ar' ? 'احجز الآن' : 'Book Now' ?>
        </a>
        <a href="https://wa.me/<?= e(preg_replace('/\D+/','',setting('company_phone_1','')))?>" target="_blank" class="btn-secondary" style="padding:14px 36px;background:rgba(255,255,255,.05);color:white;border:1px solid rgba(255,255,255,.15);border-radius:var(--radius);text-decoration:none;font-weight:600;transition:all .3s;">
          <i class="fab fa-whatsapp"></i> <?= $lang === 'ar' ? 'تواصل معنا' : 'Contact Us' ?>
        </a>
      </div>
    </div>
  </div>
</section>
<?php include __DIR__ . '/partials/footer.php'; ?>