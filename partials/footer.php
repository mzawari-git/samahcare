<?php
require_once __DIR__ . '/../includes/helpers.php';
$lang = current_lang();
$dir  = is_rtl() ? 'rtl' : 'ltr';
$scriptName = basename($_SERVER['SCRIPT_NAME'] ?? '');
$homePrefix = $scriptName === 'index.php' ? '' : 'index.php';

$companyName         = company_name();
$companyAddress      = company_address();
$companyWorkingHours = company_working_hours();
$phone1 = setting('company_phone_1', '');
$phone2 = setting('company_phone_2', '');
$email  = setting('company_email', '');

$digits = preg_replace('/\D+/', '', $phone1);
$wa = ($digits !== '' && $digits[0] === '0') ? '970' . substr($digits, 1) : $digits;

$socialLinks = [
  'social_facebook'  => ['icon' => 'fab fa-facebook-f',  'label' => 'Facebook'],
  'social_instagram' => ['icon' => 'fab fa-instagram',   'label' => 'Instagram'],
  'social_tiktok'    => ['icon' => 'fab fa-tiktok',      'label' => 'TikTok'],
  'social_youtube'   => ['icon' => 'fab fa-youtube',     'label' => 'YouTube'],
  'social_google'    => ['icon' => 'fab fa-google',      'label' => 'Google'],
];
?>

<!-- ============= FOOTER ============= -->
<footer class="site-footer" id="site-footer">
  <div class="footer-grid">

    <!-- Brand -->
    <div>
      <div class="footer-brand-name"><i class="fas fa-car" style="color:var(--primary-light);margin-<?= $dir === 'rtl' ? 'left' : 'right' ?>:8px;"></i><?= e($companyName) ?></div>
      <p class="footer-brand-desc">
        <?= e($lang === 'ar'
          ? 'نوفر أفضل خدمات تأجير السيارات بأسعار تنافسية وأسطول حديث، مع خدمة عملاء متميزة على مدار الساعة.'
          : 'We provide the best car rental services at competitive prices with a modern fleet and excellent 24/7 customer support.') ?>
      </p>
      <div class="footer-social">
        <?php foreach ($socialLinks as $key => $s):
          $url = trim((string)setting($key, ''));
          if ($url === '') continue;
        ?>
        <a href="<?= e($url) ?>" target="_blank" rel="noopener" class="social-btn" title="<?= e($s['label']) ?>">
          <i class="<?= e($s['icon']) ?>"></i>
        </a>
        <?php endforeach; ?>
        <?php if ($wa !== ''): ?>
        <a href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener" class="social-btn" title="WhatsApp" style="background:rgba(37,211,102,.12);border-color:rgba(37,211,102,.2);color:#25d366;">
          <i class="fab fa-whatsapp"></i>
        </a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Quick Links -->
    <div>
      <div class="footer-title"><?= e($lang === 'ar' ? 'روابط سريعة' : 'Quick Links') ?></div>
      <div class="footer-links">
        <a href="<?= e($homePrefix) ?>#cars"    class="footer-link"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i> <?= e(t('nav_cars')) ?></a>
        <a href="services.php" class="footer-link"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i> <?= e($lang === 'ar' ? 'خدماتنا' : 'Services') ?></a>
        <a href="fleet.php" class="footer-link"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i> <?= e($lang === 'ar' ? 'أسطول السيارات' : 'Our Fleet') ?></a>
        <a href="special-deal.php" class="footer-link"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i> <?= e($lang === 'ar' ? 'عروض خاصة' : 'Special Deals') ?></a>
        <a href="<?= e($homePrefix) ?>#offers"  class="footer-link"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i> <?= e(t('nav_offers')) ?></a>
        <a href="<?= e($homePrefix) ?>#booking" class="footer-link"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i> <?= e($lang === 'ar' ? 'احجز الآن' : 'Book Now') ?></a>
        <a href="testimonials.php" class="footer-link"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i> <?= e($lang === 'ar' ? 'آراء العملاء' : 'Testimonials') ?></a>
        <a href="contact.php" class="footer-link"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i> <?= e($lang === 'ar' ? 'اتصل بنا' : 'Contact') ?></a>
        <a href="locations.php" class="footer-link"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i> <?= e($lang === 'ar' ? 'فروعنا' : 'Locations') ?></a>
        <a href="about.php" class="footer-link"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i> <?= e($lang === 'ar' ? 'من نحن' : 'About Us') ?></a>
      </div>
    </div>

    <!-- Legal -->
    <div>
      <div class="footer-title"><?= e($lang === 'ar' ? 'قانوني' : 'Legal') ?></div>
      <div class="footer-links">
        <a href="privacy.php" class="footer-link"><i class="fas fa-shield-alt"></i> <?= e(t('privacy_policy')) ?></a>
        <a href="terms.php"   class="footer-link"><i class="fas fa-file-contract"></i> <?= e(t('terms_of_service')) ?></a>
        <a href="faq.php"    class="footer-link"><i class="fas fa-question-circle"></i> <?= e($lang === 'ar' ? 'الأسئلة الشائعة' : 'FAQ') ?></a>
        <a href="admin/login.php" class="footer-link" style="color:rgba(59,130,246,.6);"><i class="fas fa-lock"></i> <?= e($lang === 'ar' ? 'دخول الإدارة' : 'Admin') ?></a>
      </div>
    </div>

    <!-- Contact -->
    <div>
      <div class="footer-title"><?= e($lang === 'ar' ? 'تواصل معنا' : 'Contact') ?></div>

      <div class="footer-contact-item">
        <div class="footer-contact-icon"><i class="fas fa-phone"></i></div>
        <div>
          <div style="font-size:11px;color:var(--text-light);font-weight:600;margin-bottom:3px;"><?= e($lang === 'ar' ? 'ارقام الهواتف' : 'Phone Numbers') ?></div>
          <a href="tel:0597492182" style="color:rgba(255,255,255,.8);text-decoration:none;display:block;" dir="ltr">0597492182</a>
          <a href="tel:0599930120" style="color:rgba(255,255,255,.8);text-decoration:none;display:block;" dir="ltr">0599930120</a>
        </div>
      </div>

      <div class="footer-contact-item">
        <div class="footer-contact-icon"><i class="fas fa-map-marker-alt"></i></div>
        <div>
          <div style="font-size:11px;color:var(--text-light);font-weight:600;margin-bottom:3px;"><?= e($lang === 'ar' ? 'العنوان' : 'Address') ?></div>
          <span style="color:rgba(255,255,255,.7);"><?= e($lang === 'ar' ? 'البيرة، بيت المحسري، بجانب جوال' : 'Al-Bireh, Beit Al-Muhasri, beside Jawwal') ?></span>
        </div>
      </div>
      
      <?php
      // Include map functions if not already included
      if (!function_exists('render_footer_map')) {
          require_once __DIR__ . '/../includes/map_functions.php';
      }
      
      // Render the advanced footer map
      echo render_footer_map();
      ?>

      <div class="footer-contact-item" style="margin-top:15px;">
        <div class="footer-contact-icon"><i class="fas fa-clock"></i></div>
        <div>
          <div style="font-size:11px;color:var(--text-light);font-weight:600;margin-bottom:3px;"><?= e($lang === 'ar' ? 'ساعات العمل' : 'Working Hours') ?></div>
          <span style="color:rgba(255,255,255,.7);"><?= e($lang === 'ar' ? 'يومياً من 8:00 صباحاً - 10:00 مساءً' : 'Daily from 8:00 AM - 10:00 PM') ?></span>
        </div>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <span>&copy; <?= date('Y') ?> <?= e($companyName) ?>. <?= e($lang === 'ar' ? 'جميع الحقوق محفوظة' : 'All rights reserved') ?>.</span>
    <div style="display:flex;gap:20px;flex-wrap:wrap;">
      <a href="privacy.php"><?= e(t('privacy_policy')) ?></a>
      <a href="terms.php"><?= e(t('terms_of_service')) ?></a>
    </div>
  </div>
</footer>

<!-- Floating buttons -->
<?php 
$debug_info = "digits=[$digits] wa=[$wa]";
echo "<!-- DEBUG: $debug_info -->"; 
if (true): ?>
  <?php if (isset($wa) && $wa !== ''): ?>
  <a href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener" class="floating-btn whatsapp" title="WhatsApp">
    <i class="fab fa-whatsapp"></i>
  </a>
  <?php endif; ?>
  <?php if (isset($digits) && $digits !== ''): ?>
  <a href="tel:<?= e($digits) ?>" class="floating-btn phone" title="Call">
    <i class="fas fa-phone"></i>
  </a>
  <?php endif; ?>
  <button class="floating-btn top" id="scrollTopBtn" title="Back to top" style="display:none;">
    <i class="fas fa-arrow-up"></i>
  </button>
</div>

<!-- Chat Widget -->
<div class="chat-widget" id="chatWidget">
  <button class="chat-toggle" onclick="toggleChat()">
    <i class="fas fa-comments"></i>
    <span class="chat-toggle-badge" id="chatBadge">1</span>
  </button>
  
  <div class="chat-box" id="chatBox">
    <div class="chat-header">
      <div class="chat-title">
        <i class="fab fa-whatsapp"></i>
        <?= $lang === 'ar' ? 'تواصل معنا' : 'Chat With Us' ?>
      </div>
      <button class="chat-close" onclick="toggleChat()">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="chat-body">
      <p><?= $lang === 'ar' 
          ? 'مرحباً! كيف يمكننا مساعدتك؟'
          : 'Hello! How can we help you?' ?></p>
      <div class="chat-options">
        <a href="https://wa.me/<?= e($wa) ?>?text=<?= urlencode($lang === 'ar' ? 'مرحباً، أرغب في استفسار عن تأجير سيارة' : 'Hello, I would like to inquire about car rental') ?>" 
           target="_blank" 
           class="chat-option">
          <i class="fas fa-car"></i>
          <?= $lang === 'ar' ? 'استئجار سيارة' : 'Rent a Car' ?>
        </a>
        <a href="https://wa.me/<?= e($wa) ?>?text=<?= urlencode($lang === 'ar' ? 'مرحباً، أرغب في الاستفسار عن الأسعار' : 'Hello, I would like to inquire about prices') ?>" 
           target="_blank" 
           class="chat-option">
          <i class="fas fa-dollar-sign"></i>
          <?= $lang === 'ar' ? 'الأسعار والخصومات' : 'Prices & Discounts' ?>
        </a>
        <a href="https://wa.me/<?= e($wa) ?>?text=<?= urlencode($lang === 'ar' ? 'مرحباً، لدي استفسار آخر' : 'Hello, I have another question') ?>" 
           target="_blank" 
           class="chat-option">
          <i class="fas fa-question-circle"></i>
          <?= $lang === 'ar' ? 'استفسار آخر' : 'Other Question' ?>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Floating Social Bar -->
<div class="floating-social">
  <?php foreach ($socialLinks as $key => $s):
    $url = trim((string)setting($key, ''));
    if ($url === '') continue;
    $hoverBg = $key === 'social_facebook' ? '#1877f2' : ($key === 'social_instagram' ? '#e4405f' : ($key === 'social_tiktok' ? '#000' : ($key === 'social_youtube' ? '#ff0000' : '#4285f4')));
  ?>
  <a href="<?= e($url) ?>" target="_blank" rel="noopener" class="floating-social-link" title="<?= e($s['label']) ?>" style="--social-hover:<?= $hoverBg ?>;">
    <i class="<?= e($s['icon']) ?>"></i>
  </a>
  <?php endforeach; ?>
</div>

<style>
.chat-widget {
  position: fixed;
  bottom: 90px;
  right: 20px;
  z-index: 1000;
}

html[dir="rtl"] .chat-widget {
  right: auto;
  left: 20px;
}

.chat-toggle {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(135deg, #25d366, #128c7e);
  border: none;
  color: white;
  font-size: 24px;
  cursor: pointer;
  box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
  transition: all 0.3s ease;
  position: relative;
}

.chat-toggle:hover {
  transform: scale(1.1);
}

.chat-toggle-badge {
  position: absolute;
  top: -5px;
  right: -5px;
  background: #ef4444;
  color: white;
  font-size: 12px;
  padding: 4px 8px;
  border-radius: 999px;
  font-weight: 700;
}

html[dir="rtl"] .chat-toggle-badge {
  right: auto;
  left: -5px;
}

.chat-box {
  position: absolute;
  bottom: 70px;
  right: 0;
  width: 300px;
  background: white;
  border-radius: 16px;
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  display: none;
}

html[dir="rtl"] .chat-box {
  right: auto;
  left: 0;
}

.chat-box.open {
  display: block;
  animation: slideUp 0.3s ease;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.chat-header {
  background: linear-gradient(135deg, #25d366, #128c7e);
  color: white;
  padding: 16px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.chat-title {
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 8px;
}

.chat-close {
  background: none;
  border: none;
  color: white;
  font-size: 18px;
  cursor: pointer;
  opacity: 0.8;
  transition: opacity 0.3s;
}

.chat-close:hover {
  opacity: 1;
}

.chat-body {
  padding: 16px;
  color: #333;
}

.chat-body p {
  margin-bottom: 16px;
  line-height: 1.5;
}

.chat-options {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.chat-option {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 16px;
  background: #f5f5f5;
  border-radius: 10px;
  text-decoration: none;
  color: #333;
  font-weight: 500;
  transition: all 0.3s ease;
}

.chat-option:hover {
  background: #e8f5e9;
  color: #128c7e;
}

.chat-option i {
  color: #25d366;
}

@media (max-width: 576px) {
  .chat-box {
    width: calc(100vw - 40px);
    right: -10px;
  }
  
  html[dir="rtl"] .chat-box {
    right: auto;
    left: -10px;
  }
}
</style>

<script>
function toggleChat() {
  const chatBox = document.getElementById('chatBox');
  chatBox.classList.toggle('open');
  
  const badge = document.getElementById('chatBadge');
  if (chatBox.classList.contains('open')) {
    badge.style.display = 'none';
  }
}
</script>
<?php endif; ?>

<script>
// Global error handler to prevent console errors from breaking the page
window.onerror = function(msg, url, lineNo, columnNo, error) {
    if (msg && (msg.includes('iterable') || msg.includes('cross-origin') || msg.includes('Symbol'))) {
        return true;
    }
    return false;
};
</script>

<script src="<?= e(asset_url('assets/js/mobile.js')) ?>"></script>
<script src="<?= e(asset_url('assets/js/site.js')) ?>"></script>
</body>
</html>
