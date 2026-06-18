<?php

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin']);

$siteKeys = [
    'site_url',
    'site_theme',
    'site_logo',
    'site_favicon',
    'company_name_ar',
    'company_name_en',
    'company_phone_1',
    'company_phone_2',
    'company_address_ar',
    'company_address_en',
    'company_working_hours_ar',
    'company_working_hours_en',
    'social_facebook',
    'social_instagram',
    'social_tiktok',
    'social_youtube',
];

$pricingKeys = [
    'price_day_1',
    'price_day_3',
    'price_day_10',
    'price_day_15',
    'price_day_20',
    'price_day_30',
    'price_monthly',
];

$paymentKeys = [
    'pay_enable_cards',
    'pay_cards_provider',
    'pay_cards_mode',
    'pay_cards_public_key',
    'pay_cards_secret_key',
    'pay_enable_jawwal',
    'pay_jawwal_label_ar',
    'pay_jawwal_label_en',
    'pay_jawwal_details_ar',
    'pay_jawwal_details_en',
    'pay_enable_palpay',
    'pay_palpay_label_ar',
    'pay_palpay_label_en',
    'pay_palpay_details_ar',
    'pay_palpay_details_en',
    'pay_enable_bank',
    'pay_bank_label_ar',
    'pay_bank_label_en',
    'pay_bank_details_ar',
    'pay_bank_details_en',
    'pay_enable_cash',
    'pay_cash_details_ar',
    'pay_cash_details_en',
];

// Add email settings keys
$emailKeys = [
    'email_smtp_host',
    'email_smtp_port',
    'email_smtp_username',
    'email_smtp_password',
    'email_smtp_encryption',
    'email_from_address',
    'email_from_name',
    'email_admin_address',
    'email_enable_notifications',
    'email_enable_booking_confirm',
    'email_enable_payment_confirm',
];

// Add SEO settings keys
$seoKeys = [
    'seo_meta_title',
    'seo_meta_description',
    'seo_meta_keywords',
    'seo_og_title',
    'seo_og_description',
    'seo_og_image',
    'seo_twitter_title',
    'seo_twitter_description',
    'seo_twitter_image',
    'seo_google_analytics',
    'seo_google_verification',
    'seo_bing_verification',
];

// Add system settings keys
$systemKeys = [
    'system_timezone',
    'system_date_format',
    'system_time_format',
    'system_currency',
    'system_language',
    'system_maintenance_mode',
    'system_debug_mode',
    'system_cache_enabled',
    'system_session_timeout',
];

$keys = array_values(array_unique(array_merge($siteKeys, $paymentKeys, $pricingKeys, $emailKeys, $seoKeys, $systemKeys)));

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = trim((string)($_POST['_form'] ?? ''));
    
    if ($form === 'payments') {
        $targetKeys = $paymentKeys;
    } elseif ($form === 'pricing') {
        $targetKeys = $pricingKeys;
    } elseif ($form === 'email') {
        $targetKeys = $emailKeys;
    } elseif ($form === 'seo') {
        $targetKeys = $seoKeys;
    } elseif ($form === 'system') {
        $targetKeys = $systemKeys;
    } else {
        $targetKeys = $siteKeys;
    }

    $data = [];
    foreach ($targetKeys as $k) {
        $raw = trim((string)($_POST[$k] ?? ''));
        if (str_ends_with($k, '_ar')) {
            $data[$k] = $raw;
        } else {
            $data[$k] = $raw;
        }
    }
    
    // Validate numeric pricing fields
    if ($form === 'pricing') {
        foreach ($pricingKeys as $pk) {
            if (!is_numeric($data[$pk] ?? '')) {
                $data[$pk] = '0';
            }
        }
    }

    if ($form === 'payments') {
        foreach (['pay_enable_cards', 'pay_enable_jawwal', 'pay_enable_palpay', 'pay_enable_bank', 'pay_enable_cash'] as $bk) {
            if (in_array($bk, $targetKeys, true)) {
                $data[$bk] = isset($_POST[$bk]) ? '1' : '0';
            }
        }

        $allowedModes = ['sandbox', 'live'];
        if (!in_array($data['pay_cards_mode'] ?? '', $allowedModes, true)) {
            $data['pay_cards_mode'] = 'sandbox';
        }
    } elseif ($form === 'email') {
        $allowedEncryptions = ['none', 'ssl', 'tls'];
        if (!in_array($data['email_smtp_encryption'] ?? '', $allowedEncryptions, true)) {
            $data['email_smtp_encryption'] = 'tls';
        }
        
        foreach (['email_enable_notifications', 'email_enable_booking_confirm', 'email_enable_payment_confirm'] as $ek) {
            if (in_array($ek, $targetKeys, true)) {
                $data[$ek] = isset($_POST[$ek]) ? '1' : '0';
            }
        }
    } elseif ($form === 'system') {
        $allowedTimezones = ['Asia/Gaza', 'Asia/Hebron', 'UTC', 'Europe/London', 'America/New_York'];
        if (!in_array($data['system_timezone'] ?? '', $allowedTimezones, true)) {
            $data['system_timezone'] = 'Asia/Gaza';
        }
        
        $allowedCurrencies = ['ILS', 'USD', 'EUR', 'GBP'];
        if (!in_array($data['system_currency'] ?? '', $allowedCurrencies, true)) {
            $data['system_currency'] = 'ILS';
        }
        
        $allowedLanguages = ['ar', 'en'];
        if (!in_array($data['system_language'] ?? '', $allowedLanguages, true)) {
            $data['system_language'] = 'ar';
        }
        
        foreach (['system_maintenance_mode', 'system_debug_mode', 'system_cache_enabled'] as $sk) {
            if (in_array($sk, $targetKeys, true)) {
                $data[$sk] = isset($_POST[$sk]) ? '1' : '0';
            }
        }
        
        if (!is_numeric($data['system_session_timeout'] ?? '')) {
            $data['system_session_timeout'] = '3600';
        }
    } elseif ($form === 'site') {
        $allowedThemes = ['gold', 'blue', 'emerald', 'rose'];
        if (!in_array($data['site_theme'] ?? '', $allowedThemes, true)) {
            $data['site_theme'] = 'gold';
        }

        if (($data['company_name_ar'] ?? '') === '' || ($data['company_name_en'] ?? '') === '') {
            $errors[] = 'اسم الشركة مطلوب (AR/EN)';
        }

        $urlKeys = ['site_url', 'social_facebook', 'social_instagram', 'social_tiktok', 'social_youtube'];
        foreach ($urlKeys as $uk) {
            $v = trim((string)($data[$uk] ?? ''));
            if ($v === '') {
                continue;
            }

            if (!preg_match('#^https?://#i', $v)) {
                $v = 'https://' . ltrim($v, '/');
            }

            if (!filter_var($v, FILTER_VALIDATE_URL)) {
                $errors[] = 'رابط غير صحيح: ' . $uk;
                continue;
            }

            $data[$uk] = $v;
        }
    }

    if (!$errors) {
        $stmt = db()->prepare('INSERT INTO settings (k, v) VALUES (:k, :v) ON DUPLICATE KEY UPDATE v = VALUES(v)');
        foreach ($data as $k => $v) {
            $stmt->execute([':k' => $k, ':v' => $v]);
        }

        if ($form === 'site' && isset($_FILES['site_logo']) && is_array($_FILES['site_logo'])) {
            $err = (int)($_FILES['site_logo']['error'] ?? UPLOAD_ERR_NO_FILE);
            if ($err === UPLOAD_ERR_OK && $_FILES['site_logo']['size'] > 0) {
                $orig = (string)($_FILES['site_logo']['name'] ?? '');
                $tmp = (string)($_FILES['site_logo']['tmp_name'] ?? '');
                $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                    $newName = 'logo_' . time() . '.' . $ext;
                    $dest = UPLOADS_DIR . '/' . $newName;
                    if (move_uploaded_file($tmp, $dest)) {
                        db()->prepare("INSERT INTO settings (k, v) VALUES ('site_logo', ?) ON DUPLICATE KEY UPDATE v = VALUES(v)")
                            ->execute([UPLOADS_URL . '/' . $newName]);
                    } else {
                        $errors[] = 'فشل رفع الشعار إلى uploads.';
                    }
                } else {
                    $errors[] = 'صيغة الشعار غير مدعومة. استخدم JPG/PNG/WebP.';
                }
            }
        }

        if ($form === 'site' && isset($_FILES['site_favicon']) && is_array($_FILES['site_favicon'])) {
            $err = (int)($_FILES['site_favicon']['error'] ?? UPLOAD_ERR_NO_FILE);
            if ($err === UPLOAD_ERR_OK && $_FILES['site_favicon']['size'] > 0) {
                $orig = (string)($_FILES['site_favicon']['name'] ?? '');
                $tmp = (string)($_FILES['site_favicon']['tmp_name'] ?? '');
                $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
                if (in_array($ext, ['png', 'ico', 'svg', 'jpg', 'jpeg', 'webp'], true)) {
                    $newName = 'favicon.' . $ext;
                    $dest = UPLOADS_DIR . '/' . $newName;
                    if (move_uploaded_file($tmp, $dest)) {
                        db()->prepare("INSERT INTO settings (k, v) VALUES ('site_favicon', ?) ON DUPLICATE KEY UPDATE v = VALUES(v)")
                            ->execute([UPLOADS_URL . '/' . $newName]);
                    } else {
                        $errors[] = 'فشل رفع الأيقونة.';
                    }
                } else {
                    $errors[] = 'صيغة الأيقونة غير مدعومة. استخدم PNG/ICO/SVG.';
                }
            }
        }

        $success = true;
    }
}

$current = [];
foreach ($keys as $k) {
    $raw = setting($k, '');
    if (str_ends_with($k, '_ar')) {
        $current[$k] = $raw;
    } else {
        $current[$k] = $raw;
    }
}
$current['site_logo'] = setting('site_logo', '');
$current['site_favicon'] = setting('site_favicon', '');

include __DIR__ . '/partials/header.php';

?>
<style>
.settings-tabs {
    border-bottom: 2px solid #e5e7eb;
    margin-bottom: 30px;
}

.settings-tabs .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    color: #6b7280;
    font-weight: 500;
    padding: 12px 20px;
    margin-right: 5px;
    transition: all 0.3s ease;
}

.settings-tabs .nav-link:hover {
    color: #374151;
    background: rgba(59, 130, 246, 0.05);
}

.settings-tabs .nav-link.active {
    color: #2563eb;
    border-bottom-color: #2563eb;
    background: rgba(59, 130, 246, 0.1);
}

.settings-tabs .nav-link i {
    margin-right: 8px;
    font-size: 16px;
}

.tab-content {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e5e7eb;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.section-description {
    color: #6b7280;
    font-size: 0.95rem;
    margin: 5px 0 0 0;
}

.form-section {
    margin-bottom: 30px;
}

.form-section-title {
    font-weight: 600;
    color: #374151;
    margin-bottom: 15px;
    padding: 10px 0;
    border-bottom: 1px solid #f3f4f6;
}

.form-section-title i {
    margin-right: 8px;
    color: #2563eb;
}

.settings-card {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    background: #fafafa;
}

.settings-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

.btn-save {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    color: white;
}

.alert-custom {
    border-radius: 8px;
    border: none;
    padding: 15px 20px;
    margin-bottom: 20px;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.form-control, .form-select {
    border: 2px solid #e5e7eb;
    border-radius: 6px;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.input-group-text {
    background: #f8fafc;
    border: 2px solid #e5e7eb;
    color: #6b7280;
}

.form-check-input:checked {
    background-color: #2563eb;
    border-color: #2563eb;
}

.upload-preview {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
}

.upload-preview img {
    border-radius: 8px;
    border: 2px solid #e5e7eb;
}

.tab-pane {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.settings-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.settings-item:hover {
    background: #f1f5f9;
}

.settings-label {
    font-weight: 500;
    color: #374151;
}

.settings-value {
    color: #6b7280;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
}
</style>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 fw-bold m-0">
        <i class="fas fa-cog text-primary"></i>
        <?= e(t('settings')) ?>
    </h1>
    <div class="text-muted">
        <i class="fas fa-info-circle"></i>
        كل خصائص في تبويب منفصل للتنظيم الأفضل
    </div>
</div>

<?php if ($success): ?>
    <div class="alert alert-success alert-custom">
        <i class="fas fa-check-circle"></i>
        تم حفظ الإعدادات بنجاح
    </div>
<?php endif; ?>

<?php if ($errors): ?>
    <div class="alert alert-danger alert-custom">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>خطأ:</strong>
        <?php foreach ($errors as $err): ?>
            <div><?= e((string)$err) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Tab Navigation -->
<ul class="nav nav-tabs settings-tabs" id="settingsTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="site-tab" data-bs-toggle="tab" data-bs-target="#site" type="button" role="tab">
            <i class="fas fa-globe"></i>
            الموقع الأساسي
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pricing-tab" data-bs-toggle="tab" data-bs-target="#pricing" type="button" role="tab">
            <i class="fas fa-tags"></i>
            الأسعار
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab">
            <i class="fas fa-credit-card"></i>
            وسائل الدفع
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button" role="tab">
            <i class="fas fa-envelope"></i>
            البريد الإلكتروني
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab">
            <i class="fas fa-search"></i>
            SEO
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#system" type="button" role="tab">
            <i class="fas fa-cogs"></i>
            النظام
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content" id="settingsTabContent">

    <!-- Site Settings Tab -->
    <div class="tab-pane fade show active" id="site" role="tabpanel">
        <div class="section-header">
            <div>
                <h2 class="section-title">إعدادات الموقع الأساسية</h2>
                <p class="section-description">المعلومات الأساسية للموقع والشعار والروابط</p>
            </div>
        </div>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="_form" value="site">
            
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-link"></i>
                    معلومات الموقع
                </h3>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">رابط الموقع (URL)</label>
                        <input class="form-control" name="site_url" value="<?= e((string)($current['site_url'] ?? '')) ?>" placeholder="https://sawarentcar.online">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">لون الموقع</label>
                        <select class="form-select" name="site_theme">
                            <option value="gold" <?= ($current['site_theme'] ?? '') === 'gold' ? 'selected' : '' ?>>Gold</option>
                            <option value="blue" <?= ($current['site_theme'] ?? '') === 'blue' ? 'selected' : '' ?>>Blue</option>
                            <option value="emerald" <?= ($current['site_theme'] ?? '') === 'emerald' ? 'selected' : '' ?>>Emerald</option>
                            <option value="rose" <?= ($current['site_theme'] ?? '') === 'rose' ? 'selected' : '' ?>>Rose</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-image"></i>
                    الشعار والأيقونة
                </h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Logo (الشعار)</label>
                        <input class="form-control" type="file" name="site_logo" accept="image/*">
                        <?php if (!empty($current['site_logo'])): ?>
                            <div class="upload-preview">
                                <img src="<?= e(asset_url('../' . ltrim((string)$current['site_logo'], '/'))) ?>" alt="logo" style="height:44px; width:44px; object-fit:cover;">
                                <span class="text-success small"><i class="fas fa-check"></i> الشعار الحالي</span>
                            </div>
                        <?php else: ?>
                            <div class="form-text small">لم يتم رفع شعار</div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Favicon (الأيقونة)</label>
                        <input class="form-control" type="file" name="site_favicon" accept="image/png,image/x-icon,image/svg+xml">
                        <?php if (!empty($current['site_favicon'])): ?>
                            <div class="upload-preview">
                                <img src="<?= e(asset_url('../' . ltrim((string)$current['site_favicon'], '/'))) ?>" alt="favicon" style="height:44px; width:44px; object-fit:cover;">
                                <span class="text-success small"><i class="fas fa-check"></i> الأيقونة الحالية</span>
                            </div>
                        <?php else: ?>
                            <div class="form-text small">لم يتم رفع أيقونة - PNG, ICO, أو SVG - 32x32px</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-building"></i>
                    معلومات الشركة
                </h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم الشركة (AR)</label>
                        <input class="form-control" name="company_name_ar" value="<?= e((string)$current['company_name_ar']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company name (EN)</label>
                        <input class="form-control" name="company_name_en" value="<?= e((string)$current['company_name_en']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الهاتف 1</label>
                        <input class="form-control" name="company_phone_1" value="<?= e((string)$current['company_phone_1']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الهاتف 2</label>
                        <input class="form-control" name="company_phone_2" value="<?= e((string)$current['company_phone_2']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">العنوان (AR)</label>
                        <textarea class="form-control" rows="3" name="company_address_ar"><?= e((string)$current['company_address_ar']) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address (EN)</label>
                        <textarea class="form-control" rows="3" name="company_address_en"><?= e((string)$current['company_address_en']) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">ساعات العمل (AR)</label>
                        <input class="form-control" name="company_working_hours_ar" value="<?= e((string)$current['company_working_hours_ar']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Working hours (EN)</label>
                        <input class="form-control" name="company_working_hours_en" value="<?= e((string)$current['company_working_hours_en']) ?>">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-share-alt"></i>
                    روابط التواصل الاجتماعي
                </h3>
                <div class="row g-3">
                    <div class="col-md-6" dir="ltr">
                        <label class="form-label">Facebook</label>
                        <input class="form-control" name="social_facebook" value="<?= e((string)($current['social_facebook'] ?? '')) ?>" placeholder="https://facebook.com/yourpage">
                    </div>
                    <div class="col-md-6" dir="ltr">
                        <label class="form-label">Instagram</label>
                        <input class="form-control" name="social_instagram" value="<?= e((string)($current['social_instagram'] ?? '')) ?>" placeholder="https://instagram.com/yourprofile">
                    </div>
                    <div class="col-md-6" dir="ltr">
                        <label class="form-label">TikTok</label>
                        <input class="form-control" name="social_tiktok" value="<?= e((string)($current['social_tiktok'] ?? '')) ?>" placeholder="https://tiktok.com/@yourprofile">
                    </div>
                    <div class="col-md-6" dir="ltr">
                        <label class="form-label">YouTube</label>
                        <input class="form-control" name="social_youtube" value="<?= e((string)($current['social_youtube'] ?? '')) ?>" placeholder="https://youtube.com/@yourchannel">
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button class="btn btn-save" type="submit">
                    <i class="fas fa-save"></i>
                    حفظ إعدادات الموقع
                </button>
            </div>
        </form>
    </div>

    <!-- Pricing Tab -->
    <div class="tab-pane fade" id="pricing" role="tabpanel">
        <div class="section-header">
            <div>
                <h2 class="section-title">أسعار التأجير</h2>
                <p class="section-description">تحديد أسعار التأجير للفترات المختلفة</p>
            </div>
        </div>

        <form method="post">
            <input type="hidden" name="_form" value="pricing">
            
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                الأسعار بالشيكل الإسرائيلي (₪)
            </div>

            <div class="settings-grid">
                <div class="settings-card">
                    <h5><i class="fas fa-calendar-day"></i> يوم واحد</h5>
                    <div class="input-group">
                        <span class="input-group-text">₪</span>
                        <input class="form-control" type="number" name="price_day_1" value="<?= (float)($current['price_day_1'] ?? 120) ?>" min="0" step="1">
                    </div>
                </div>

                <div class="settings-card">
                    <h5><i class="fas fa-calendar-week"></i> 3 أيام</h5>
                    <div class="input-group">
                        <span class="input-group-text">₪</span>
                        <input class="form-control" type="number" name="price_day_3" value="<?= (float)($current['price_day_3'] ?? 330) ?>" min="0" step="1">
                    </div>
                </div>

                <div class="settings-card">
                    <h5><i class="fas fa-calendar"></i> 10 أيام</h5>
                    <div class="input-group">
                        <span class="input-group-text">₪</span>
                        <input class="form-control" type="number" name="price_day_10" value="<?= (float)($current['price_day_10'] ?? 1000) ?>" min="0" step="1">
                    </div>
                </div>

                <div class="settings-card">
                    <h5><i class="fas fa-star"></i> 15 يوم (الأفضل قيمة)</h5>
                    <div class="input-group">
                        <span class="input-group-text">₪</span>
                        <input class="form-control" type="number" name="price_day_15" value="<?= (float)($current['price_day_15'] ?? 1350) ?>" min="0" step="1">
                    </div>
                </div>

                <div class="settings-card">
                    <h5><i class="fas fa-calendar-alt"></i> 20 يوم</h5>
                    <div class="input-group">
                        <span class="input-group-text">₪</span>
                        <input class="form-control" type="number" name="price_day_20" value="<?= (float)($current['price_day_20'] ?? 1700) ?>" min="0" step="1">
                    </div>
                </div>

                <div class="settings-card">
                    <h5><i class="fas fa-calendar-check"></i> 30 يوم (أقصى توفير)</h5>
                    <div class="input-group">
                        <span class="input-group-text">₪</span>
                        <input class="form-control" type="number" name="price_day_30" value="<?= (float)($current['price_day_30'] ?? 2400) ?>" min="0" step="1">
                    </div>
                </div>

                <div class="settings-card">
                    <h5><i class="fas fa-calendar-times"></i> الشهر (30 يوم)</h5>
                    <div class="input-group">
                        <span class="input-group-text">₪</span>
                        <input class="form-control" type="number" name="price_monthly" value="<?= (float)($current['price_monthly'] ?? 2300) ?>" min="0" step="1">
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button class="btn btn-save" type="submit">
                    <i class="fas fa-save"></i>
                    حفظ الأسعار
                </button>
            </div>
        </form>
    </div>

    <!-- Payments Tab -->
    <div class="tab-pane fade" id="payments" role="tabpanel">
        <div class="section-header">
            <div>
                <h2 class="section-title">وسائل الدفع</h2>
                <p class="section-description">تفعيل وإعدادات وسائل الدفع المتاحة</p>
            </div>
        </div>

        <form method="post">
            <input type="hidden" name="_form" value="payments">

            <!-- Credit Cards -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-credit-card"></i>
                    الدفع بالبطاقات (Visa / MasterCard)
                </h3>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pay_enable_cards" name="pay_enable_cards" value="1" <?= ($current['pay_enable_cards'] ?? '') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="pay_enable_cards">تفعيل الدفع بالبطاقات</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">مزود بوابة البطاقات</label>
                        <input class="form-control" name="pay_cards_provider" value="<?= e((string)($current['pay_cards_provider'] ?? '')) ?>" placeholder="مثال: PayTabs / HyperPay">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">وضع التشغيل</label>
                        <select class="form-select" name="pay_cards_mode">
                            <option value="sandbox" <?= ($current['pay_cards_mode'] ?? '') === 'sandbox' ? 'selected' : '' ?>>Sandbox</option>
                            <option value="live" <?= ($current['pay_cards_mode'] ?? '') === 'live' ? 'selected' : '' ?>>Live</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Public Key</label>
                        <input class="form-control" name="pay_cards_public_key" value="<?= e((string)($current['pay_cards_public_key'] ?? '')) ?>" autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Secret Key</label>
                        <input class="form-control" type="password" name="pay_cards_secret_key" value="<?= e((string)($current['pay_cards_secret_key'] ?? '')) ?>" autocomplete="new-password">
                    </div>
                </div>
            </div>

            <!-- Jawwal Pay -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-mobile-alt"></i>
                    جوال باي
                </h3>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pay_enable_jawwal" name="pay_enable_jawwal" value="1" <?= ($current['pay_enable_jawwal'] ?? '') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="pay_enable_jawwal">تفعيل جوال باي</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">اسم الوسيلة (AR)</label>
                        <input class="form-control" name="pay_jawwal_label_ar" value="<?= e((string)($current['pay_jawwal_label_ar'] ?? 'جوال باي')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Method name (EN)</label>
                        <input class="form-control" name="pay_jawwal_label_en" value="<?= e((string)($current['pay_jawwal_label_en'] ?? 'Jawwal Pay')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">تفاصيل (AR)</label>
                        <textarea class="form-control" rows="3" name="pay_jawwal_details_ar"><?= e((string)($current['pay_jawwal_details_ar'] ?? '')) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Details (EN)</label>
                        <textarea class="form-control" rows="3" name="pay_jawwal_details_en"><?= e((string)($current['pay_jawwal_details_en'] ?? '')) ?></textarea>
                    </div>
                </div>
            </div>

            <!-- PalPay -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-wallet"></i>
                    PalPay
                </h3>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pay_enable_palpay" name="pay_enable_palpay" value="1" <?= ($current['pay_enable_palpay'] ?? '') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="pay_enable_palpay">تفعيل PalPay</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">اسم الوسيلة (AR)</label>
                        <input class="form-control" name="pay_palpay_label_ar" value="<?= e((string)($current['pay_palpay_label_ar'] ?? 'بال باي')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Method name (EN)</label>
                        <input class="form-control" name="pay_palpay_label_en" value="<?= e((string)($current['pay_palpay_label_en'] ?? 'PalPay')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">تفاصيل (AR)</label>
                        <textarea class="form-control" rows="3" name="pay_palpay_details_ar"><?= e((string)($current['pay_palpay_details_ar'] ?? '')) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Details (EN)</label>
                        <textarea class="form-control" rows="3" name="pay_palpay_details_en"><?= e((string)($current['pay_palpay_details_en'] ?? '')) ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Bank Transfer -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-university"></i>
                    التحويل البنكي
                </h3>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pay_enable_bank" name="pay_enable_bank" value="1" <?= ($current['pay_enable_bank'] ?? '') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="pay_enable_bank">تفعيل التحويل البنكي</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">اسم الوسيلة (AR)</label>
                        <input class="form-control" name="pay_bank_label_ar" value="<?= e((string)($current['pay_bank_label_ar'] ?? 'تحويل بنكي')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Method name (EN)</label>
                        <input class="form-control" name="pay_bank_label_en" value="<?= e((string)($current['pay_bank_label_en'] ?? 'Bank Transfer')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">تفاصيل الحساب (AR)</label>
                        <textarea class="form-control" rows="4" name="pay_bank_details_ar"><?= e((string)($current['pay_bank_details_ar'] ?? '')) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Bank details (EN)</label>
                        <textarea class="form-control" rows="4" name="pay_bank_details_en"><?= e((string)($current['pay_bank_details_en'] ?? '')) ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Cash -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-money-bill"></i>
                    الدفع في الشركة (Cash)
                </h3>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pay_enable_cash" name="pay_enable_cash" value="1" <?= ($current['pay_enable_cash'] ?? '') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="pay_enable_cash">تفعيل الدفع في الشركة</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">تفاصيل (AR)</label>
                        <textarea class="form-control" rows="3" name="pay_cash_details_ar"><?= e((string)($current['pay_cash_details_ar'] ?? '')) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Details (EN)</label>
                        <textarea class="form-control" rows="3" name="pay_cash_details_en"><?= e((string)($current['pay_cash_details_en'] ?? '')) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button class="btn btn-save" type="submit">
                    <i class="fas fa-save"></i>
                    حفظ وسائل الدفع
                </button>
            </div>
        </form>
    </div>

    <!-- Email Tab -->
    <div class="tab-pane fade" id="email" role="tabpanel">
        <div class="section-header">
            <div>
                <h2 class="section-title">إعدادات البريد الإلكتروني</h2>
                <p class="section-description">إعدادات SMTP والإشعارات البريدية</p>
            </div>
        </div>

        <form method="post">
            <input type="hidden" name="_form" value="email">

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-server"></i>
                    إعدادات SMTP
                </h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">SMTP Host</label>
                        <input class="form-control" name="email_smtp_host" value="<?= e((string)($current['email_smtp_host'] ?? '')) ?>" placeholder="smtp.gmail.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">SMTP Port</label>
                        <input class="form-control" name="email_smtp_port" value="<?= e((string)($current['email_smtp_port'] ?? '587')) ?>" placeholder="587">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">SMTP Username</label>
                        <input class="form-control" name="email_smtp_username" value="<?= e((string)($current['email_smtp_username'] ?? '')) ?>" placeholder="your@email.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">SMTP Password</label>
                        <input class="form-control" type="password" name="email_smtp_password" value="<?= e((string)($current['email_smtp_password'] ?? '')) ?>" autocomplete="new-password">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Encryption</label>
                        <select class="form-select" name="email_smtp_encryption">
                            <option value="none" <?= ($current['email_smtp_encryption'] ?? '') === 'none' ? 'selected' : '' ?>>None</option>
                            <option value="ssl" <?= ($current['email_smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                            <option value="tls" <?= ($current['email_smtp_encryption'] ?? '') === 'tls' ? 'selected' : '' ?>>TLS</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-envelope-open-text"></i>
                    إعدادات البريد
                </h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">From Address</label>
                        <input class="form-control" name="email_from_address" value="<?= e((string)($current['email_from_address'] ?? '')) ?>" placeholder="noreply@sawa.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">From Name</label>
                        <input class="form-control" name="email_from_name" value="<?= e((string)($current['email_from_name'] ?? '')) ?>" placeholder="Sawa Rent Car">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Admin Address</label>
                        <input class="form-control" name="email_admin_address" value="<?= e((string)($current['email_admin_address'] ?? '')) ?>" placeholder="admin@sawa.com">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-bell"></i>
                    الإشعارات
                </h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="email_enable_notifications" name="email_enable_notifications" value="1" <?= ($current['email_enable_notifications'] ?? '') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="email_enable_notifications">تفعيل الإشعارات</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="email_enable_booking_confirm" name="email_enable_booking_confirm" value="1" <?= ($current['email_enable_booking_confirm'] ?? '') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="email_enable_booking_confirm">تأكيد الحجز</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="email_enable_payment_confirm" name="email_enable_payment_confirm" value="1" <?= ($current['email_enable_payment_confirm'] ?? '') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="email_enable_payment_confirm">تأكيد الدفع</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button class="btn btn-save" type="submit">
                    <i class="fas fa-save"></i>
                    حفظ إعدادات البريد
                </button>
            </div>
        </form>
    </div>

    <!-- SEO Tab -->
    <div class="tab-pane fade" id="seo" role="tabpanel">
        <div class="section-header">
            <div>
                <h2 class="section-title">إعدادات SEO</h2>
                <p class="section-description">تحسين محركات البحث وإعدادات وسائل التواصل الاجتماعي</p>
            </div>
        </div>

        <form method="post">
            <input type="hidden" name="_form" value="seo">

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-search"></i>
                    Meta Tags
                </h3>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Meta Title</label>
                        <input class="form-control" name="seo_meta_title" value="<?= e((string)($current['seo_meta_title'] ?? '')) ?>" placeholder="Sawa Rent Car - Best Car Rental in Palestine">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control" rows="3" name="seo_meta_description" placeholder="Best car rental service in Palestine with affordable prices and quality vehicles"><?= e((string)($current['seo_meta_description'] ?? '')) ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Keywords</label>
                        <input class="form-control" name="seo_meta_keywords" value="<?= e((string)($current['seo_meta_keywords'] ?? '')) ?>" placeholder="car rental, palestine, rent a car, سوا, تأجير سيارات">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fab fa-facebook"></i>
                    Open Graph (Facebook)
                </h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">OG Title</label>
                        <input class="form-control" name="seo_og_title" value="<?= e((string)($current['seo_og_title'] ?? '')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">OG Image</label>
                        <input class="form-control" name="seo_og_image" value="<?= e((string)($current['seo_og_image'] ?? '')) ?>" placeholder="https://sawa.com/images/og-image.jpg">
                    </div>
                    <div class="col-12">
                        <label class="form-label">OG Description</label>
                        <textarea class="form-control" rows="3" name="seo_og_description"><?= e((string)($current['seo_og_description'] ?? '')) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fab fa-twitter"></i>
                    Twitter Cards
                </h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Twitter Title</label>
                        <input class="form-control" name="seo_twitter_title" value="<?= e((string)($current['seo_twitter_title'] ?? '')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Twitter Image</label>
                        <input class="form-control" name="seo_twitter_image" value="<?= e((string)($current['seo_twitter_image'] ?? '')) ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Twitter Description</label>
                        <textarea class="form-control" rows="3" name="seo_twitter_description"><?= e((string)($current['seo_twitter_description'] ?? '')) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-chart-line"></i>
                    Analytics & Verification
                </h3>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Google Analytics</label>
                        <textarea class="form-control" rows="4" name="seo_google_analytics" placeholder="UA-XXXXXXXX-X or G-XXXXXXXXXX"><?= e((string)($current['seo_google_analytics'] ?? '')) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Google Verification</label>
                        <input class="form-control" name="seo_google_verification" value="<?= e((string)($current['seo_google_verification'] ?? '')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Bing Verification</label>
                        <input class="form-control" name="seo_bing_verification" value="<?= e((string)($current['seo_bing_verification'] ?? '')) ?>">
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button class="btn btn-save" type="submit">
                    <i class="fas fa-save"></i>
                    حفظ إعدادات SEO
                </button>
            </div>
        </form>
    </div>

    <!-- System Tab -->
    <div class="tab-pane fade" id="system" role="tabpanel">
        <div class="section-header">
            <div>
                <h2 class="section-title">إعدادات النظام</h2>
                <p class="section-description">الإعدادات العامة للنظام والصيانة</p>
            </div>
        </div>

        <form method="post">
            <input type="hidden" name="_form" value="system">

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-clock"></i>
                    التوقيت والتاريخ
                </h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Timezone</label>
                        <select class="form-select" name="system_timezone">
                            <option value="Asia/Gaza" <?= ($current['system_timezone'] ?? '') === 'Asia/Gaza' ? 'selected' : '' ?>>Asia/Gaza</option>
                            <option value="Asia/Hebron" <?= ($current['system_timezone'] ?? '') === 'Asia/Hebron' ? 'selected' : '' ?>>Asia/Hebron</option>
                            <option value="UTC" <?= ($current['system_timezone'] ?? '') === 'UTC' ? 'selected' : '' ?>>UTC</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date Format</label>
                        <select class="form-select" name="system_date_format">
                            <option value="Y-m-d" <?= ($current['system_date_format'] ?? '') === 'Y-m-d' ? 'selected' : '' ?>>2024-01-01</option>
                            <option value="d/m/Y" <?= ($current['system_date_format'] ?? '') === 'd/m/Y' ? 'selected' : '' ?>>01/01/2024</option>
                            <option value="m/d/Y" <?= ($current['system_date_format'] ?? '') === 'm/d/Y' ? 'selected' : '' ?>>01/01/2024</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Time Format</label>
                        <select class="form-select" name="system_time_format">
                            <option value="24" <?= ($current['system_time_format'] ?? '') === '24' ? 'selected' : '' ?>>24 Hour</option>
                            <option value="12" <?= ($current['system_time_format'] ?? '') === '12' ? 'selected' : '' ?>>12 Hour</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-globe"></i>
                    الإعدادات العامة
                </h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Currency</label>
                        <select class="form-select" name="system_currency">
                            <option value="ILS" <?= ($current['system_currency'] ?? '') === 'ILS' ? 'selected' : '' ?>>₪ ILS</option>
                            <option value="USD" <?= ($current['system_currency'] ?? '') === 'USD' ? 'selected' : '' ?>>$ USD</option>
                            <option value="EUR" <?= ($current['system_currency'] ?? '') === 'EUR' ? 'selected' : '' ?>>€ EUR</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Language</label>
                        <select class="form-select" name="system_language">
                            <option value="ar" <?= ($current['system_language'] ?? '') === 'ar' ? 'selected' : '' ?>>العربية</option>
                            <option value="en" <?= ($current['system_language'] ?? '') === 'en' ? 'selected' : '' ?>>English</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Session Timeout (seconds)</label>
                        <input class="form-control" type="number" name="system_session_timeout" value="<?= (int)($current['system_session_timeout'] ?? 3600) ?>" min="300" step="300">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-tools"></i>
                    وضع الصيانة
                </h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="system_maintenance_mode" name="system_maintenance_mode" value="1" <?= ($current['system_maintenance_mode'] ?? '') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="system_maintenance_mode">وضع الصيانة</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="system_debug_mode" name="system_debug_mode" value="1" <?= ($current['system_debug_mode'] ?? '') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="system_debug_mode">وضع التصحيح</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="system_cache_enabled" name="system_cache_enabled" value="1" <?= ($current['system_cache_enabled'] ?? '') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="system_cache_enabled">تفعيل التخزين المؤقت</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button class="btn btn-save" type="submit">
                    <i class="fas fa-save"></i>
                    حفظ إعدادات النظام
                </button>
            </div>
        </form>
    </div>

</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
