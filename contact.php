<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/map_functions.php';
$lang = current_lang();
$dir  = is_rtl() ? 'rtl' : 'ltr';
$page_title       = $lang === 'ar' ? 'اتصل بنا - Sawa Rent Car' : 'Contact Us - Sawa Rent Car';
$page_description = $lang === 'ar' ? 'تواصل معنا للحجز والاستفسار. فريقنا جاهز لخدمتك على مدار الساعة.' : 'Contact us for booking and inquiries. Our team is ready to serve you 24/7.';
$canonical        = abs_url('contact.php');
$phone1 = setting('company_phone_1', '0597492182');
$phone2 = setting('company_phone_2', '0599930120');
$email  = setting('company_email', '');
$address = $lang === 'ar' ? 'البيرة، بيت المحسري، بجانب جوال' : 'Al-Bireh, Beit Al-Muhasri, beside Jawwal';
include __DIR__ . '/partials/header.php';
?>
<section class="page-hero" style="background:linear-gradient(135deg,var(--dark-2),var(--dark));padding:120px 20px 60px;text-align:center;">
  <div class="section-container">
    <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:800;color:white;margin-bottom:16px;"><?= $lang === 'ar' ? 'اتصل بنا' : 'Contact Us' ?></h1>
    <p style="font-size:clamp(1rem,2vw,1.2rem);color:rgba(255,255,255,.7);max-width:600px;margin:0 auto;">
      <?= $lang === 'ar' ? 'نحن هنا لمساعدتك، تواصل معنا بأي وقت' : "We're here to help, contact us anytime" ?>
    </p>
  </div>
</section>
<section class="section" style="padding:80px 20px;">
  <div class="section-container">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:40px;">
      <div>
        <div style="display:grid;gap:24px;">
          <div style="background:var(--dark-2);border:1px solid rgba(255,255,255,.06);border-radius:var(--radius-lg);padding:30px;" data-aos="fade-up">
            <div style="width:50px;height:50px;border-radius:12px;background:rgba(37,99,235,.12);display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--primary-light);margin-bottom:16px;"><i class="fas fa-phone"></i></div>
            <h3 style="font-size:1rem;font-weight:700;color:white;margin-bottom:8px;"><?= $lang === 'ar' ? 'اتصل بنا' : 'Call Us' ?></h3>
            <a href="tel:<?= e($phone1) ?>" style="color:rgba(255,255,255,.7);text-decoration:none;display:block;" dir="ltr"><?= e($phone1) ?></a>
            <a href="tel:<?= e($phone2) ?>" style="color:rgba(255,255,255,.7);text-decoration:none;display:block;" dir="ltr"><?= e($phone2) ?></a>
          </div>
          <div style="background:var(--dark-2);border:1px solid rgba(255,255,255,.06);border-radius:var(--radius-lg);padding:30px;" data-aos="fade-up" data-aos-delay="100">
            <div style="width:50px;height:50px;border-radius:12px;background:rgba(37,211,102,.12);display:flex;align-items:center;justify-content:center;font-size:20px;color:#25d366;margin-bottom:16px;"><i class="fab fa-whatsapp"></i></div>
            <h3 style="font-size:1rem;font-weight:700;color:white;margin-bottom:8px;">WhatsApp</h3>
            <a href="https://wa.me/970597492182" target="_blank" style="color:rgba(255,255,255,.7);text-decoration:none;"><?= $lang === 'ar' ? 'راسلنا على واتساب' : 'Chat on WhatsApp' ?></a>
          </div>
          <div style="background:var(--dark-2);border:1px solid rgba(255,255,255,.06);border-radius:var(--radius-lg);padding:30px;" data-aos="fade-up" data-aos-delay="200">
            <div style="width:50px;height:50px;border-radius:12px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--accent);margin-bottom:16px;"><i class="fas fa-envelope"></i></div>
            <h3 style="font-size:1rem;font-weight:700;color:white;margin-bottom:8px;"><?= $lang === 'ar' ? 'البريد الإلكتروني' : 'Email' ?></h3>
            <a href="mailto:<?= e($email) ?>" style="color:rgba(255,255,255,.7);text-decoration:none;"><?= e($email ?: 'info@sawarentcar.online') ?></a>
          </div>
          <div style="background:var(--dark-2);border:1px solid rgba(255,255,255,.06);border-radius:var(--radius-lg);padding:30px;" data-aos="fade-up" data-aos-delay="300">
            <div style="width:50px;height:50px;border-radius:12px;background:rgba(239,68,68,.12);display:flex;align-items:center;justify-content:center;font-size:20px;color:#ef4444;margin-bottom:16px;"><i class="fas fa-map-marker-alt"></i></div>
            <h3 style="font-size:1rem;font-weight:700;color:white;margin-bottom:8px;"><?= $lang === 'ar' ? 'العنوان' : 'Address' ?></h3>
            <p style="color:rgba(255,255,255,.7);margin:0;"><?= e($address) ?></p>
          </div>
        </div>
      </div>
      <div data-aos="fade-up">
        <div style="background:var(--dark-2);border:1px solid rgba(255,255,255,.06);border-radius:var(--radius-lg);padding:40px;height:100%;">
          <h2 style="font-size:1.4rem;font-weight:700;color:white;margin-bottom:24px;"><?= $lang === 'ar' ? 'أرسل لنا رسالة' : 'Send Us a Message' ?></h2>
          <form action="booking_submit.php" method="POST" style="display:grid;gap:16px;">
            <?php csrf_field(); ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
              <input type="text" name="name" placeholder="<?= $lang === 'ar' ? 'الاسم الكامل' : 'Full Name' ?>" required style="padding:14px 16px;background:var(--dark-3);border:1px solid rgba(255,255,255,.08);border-radius:var(--radius);color:white;font-size:.95rem;">
              <input type="email" name="email" placeholder="<?= $lang === 'ar' ? 'البريد الإلكتروني' : 'Email Address' ?>" style="padding:14px 16px;background:var(--dark-3);border:1px solid rgba(255,255,255,.08);border-radius:var(--radius);color:white;font-size:.95rem;">
            </div>
            <input type="tel" name="phone" placeholder="<?= $lang === 'ar' ? 'رقم الهاتف' : 'Phone Number' ?>" required style="padding:14px 16px;background:var(--dark-3);border:1px solid rgba(255,255,255,.08);border-radius:var(--radius);color:white;font-size:.95rem;">
            <input type="text" name="subject" placeholder="<?= $lang === 'ar' ? 'الموضوع' : 'Subject' ?>" style="padding:14px 16px;background:var(--dark-3);border:1px solid rgba(255,255,255,.08);border-radius:var(--radius);color:white;font-size:.95rem;">
            <textarea name="message" rows="5" placeholder="<?= $lang === 'ar' ? 'رسالتك...' : 'Your message...' ?>" required style="padding:14px 16px;background:var(--dark-3);border:1px solid rgba(255,255,255,.08);border-radius:var(--radius);color:white;font-size:.95rem;resize:vertical;"></textarea>
            <input type="hidden" name="form" value="contact">
            <button type="submit" style="padding:14px 36px;background:var(--primary);color:white;border:none;border-radius:var(--radius);font-weight:700;font-size:1rem;cursor:pointer;transition:all .3s;">
              <?= $lang === 'ar' ? 'إرسال' : 'Send Message' ?>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="section" style="padding:40px 20px 80px;">
  <div class="section-container">
    <div style="border-radius:var(--radius-lg);overflow:hidden;border:1px solid rgba(255,255,255,.06);" data-aos="fade-up">
      <?php echo render_footer_map(); ?>
    </div>
  </div>
</section>
<?php include __DIR__ . '/partials/footer.php'; ?>