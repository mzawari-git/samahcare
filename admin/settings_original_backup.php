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

$keys = array_values(array_unique(array_merge($siteKeys, $paymentKeys, $pricingKeys)));

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = trim((string)($_POST['_form'] ?? ''));
    if ($form === 'payments') {
        $targetKeys = $paymentKeys;
    } elseif ($form === 'pricing') {
        $targetKeys = $pricingKeys;
    } else {
        $targetKeys = $siteKeys;
    }

    $data = [];
    foreach ($targetKeys as $k) {
        $raw = trim((string)($_POST[$k] ?? ''));
        // Fix Arabic fields: Windows-1256 to UTF-8
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
    } else {
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

        if ($form !== 'payments' && isset($_FILES['site_logo']) && is_array($_FILES['site_logo'])) {
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

        // Favicon upload - only if file is uploaded
        if ($form !== 'payments' && isset($_FILES['site_favicon']) && is_array($_FILES['site_favicon'])) {
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

<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 fw-bold m-0"><?= e(t('settings')) ?></h1>
</div>

<?php if ($success): ?>
    <div class="alert alert-success">تم حفظ الإعدادات.</div>
<?php endif; ?>

<?php if ($errors): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $err): ?>
            <div><?= e((string)$err) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="post" enctype="multipart/form-data" class="row g-3">
            <input type="hidden" name="_form" value="site">
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

            <div class="col-md-6">
                <label class="form-label">Logo (الشعار)</label>
                <input class="form-control" type="file" name="site_logo" accept="image/*">
                <?php if (!empty($current['site_logo'])): ?>
                    <div class="mt-2 d-flex align-items-center gap-2">
                        <img src="<?= e(asset_url('../' . ltrim((string)$current['site_logo'], '/'))) ?>" alt="logo" style="height:44px; width:44px; object-fit:cover; border-radius:50%; border:2px solid #ddd;">
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
                    <div class="mt-2 d-flex align-items-center gap-2">
                        <img src="<?= e(asset_url('../' . ltrim((string)$current['site_favicon'], '/'))) ?>" alt="favicon" style="height:44px; width:44px; object-fit:cover; border-radius:8px; border:2px solid #ddd;">
                        <span class="text-success small"><i class="fas fa-check"></i> الأيقونة الحالية</span>
                    </div>
                <?php else: ?>
                    <div class="form-text small">لم يتم رفع أيقونة - PNG, ICO, أو SVG - 32x32px</div>
                <?php endif; ?>
            </div>

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

            <div class="col-12"><hr class="my-2"></div>

            <div class="col-12">
                <div class="fw-bold">روابط التواصل الاجتماعي</div>
                <div class="text-secondary small">ضع الرابط الكامل (https://...) أو اتركه فارغاً.</div>
            </div>

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

            <div class="col-12">
                <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm mt-3">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
            <div>
                <div class="fw-bold">أسعار التأجير</div>
                <div class="text-secondary small">هذه الأسعار تظهر في صفحة الحجز وعروض التأجير.</div>
            </div>
        </div>

        <form method="post" class="row g-3">
            <input type="hidden" name="_form" value="pricing">
            
            <div class="col-12">
                <div class="alert alert-info mb-2">
                    <i class="fas fa-info-circle"></i> الأسعار بالشيكل الإسرائيلي (₪)
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">يوم واحد</label>
                <div class="input-group">
                    <span class="input-group-text">₪</span>
                    <input class="form-control" type="number" name="price_day_1" value="<?= (float)($current['price_day_1'] ?? 120) ?>" min="0" step="1">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">3 أيام</label>
                <div class="input-group">
                    <span class="input-group-text">₪</span>
                    <input class="form-control" type="number" name="price_day_3" value="<?= (float)($current['price_day_3'] ?? 330) ?>" min="0" step="1">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">10 أيام</label>
                <div class="input-group">
                    <span class="input-group-text">₪</span>
                    <input class="form-control" type="number" name="price_day_10" value="<?= (float)($current['price_day_10'] ?? 1000) ?>" min="0" step="1">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">15 يوم (الأفضل قيمة)</label>
                <div class="input-group">
                    <span class="input-group-text">₪</span>
                    <input class="form-control" type="number" name="price_day_15" value="<?= (float)($current['price_day_15'] ?? 1350) ?>" min="0" step="1">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">20 يوم</label>
                <div class="input-group">
                    <span class="input-group-text">₪</span>
                    <input class="form-control" type="number" name="price_day_20" value="<?= (float)($current['price_day_20'] ?? 1700) ?>" min="0" step="1">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">30 يوم (أقصى توفير)</label>
                <div class="input-group">
                    <span class="input-group-text">₪</span>
                    <input class="form-control" type="number" name="price_day_30" value="<?= (float)($current['price_day_30'] ?? 2400) ?>" min="0" step="1">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">الشهر (30 يوم)</label>
                <div class="input-group">
                    <span class="input-group-text">₪</span>
                    <input class="form-control" type="number" name="price_monthly" value="<?= (float)($current['price_monthly'] ?? 2300) ?>" min="0" step="1">
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">حفظ الأسعار</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm mt-3">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
            <div>
                <div class="fw-bold">وسائل الدفع</div>
                <div class="text-secondary small">قم بتفعيل الوسائل التي تريدها وكتابة تفاصيلها لتظهر في صفحات الدفع.</div>
            </div>
        </div>

        <form method="post" class="row g-3">
            <input type="hidden" name="_form" value="payments">

            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="pay_enable_cards" name="pay_enable_cards" value="1" <?= ($current['pay_enable_cards'] ?? '') === '1' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="pay_enable_cards">تفعيل الدفع بالبطاقات (Visa / MasterCard)</label>
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

            <div class="col-12"><hr class="my-2"></div>

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

            <div class="col-12"><hr class="my-2"></div>

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

            <div class="col-12"><hr class="my-2"></div>

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

            <div class="col-12"><hr class="my-2"></div>

            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="pay_enable_cash" name="pay_enable_cash" value="1" <?= ($current['pay_enable_cash'] ?? '') === '1' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="pay_enable_cash">تفعيل الدفع في الشركة (Cash)</label>
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

            <div class="col-12">
                <button class="btn btn-primary" type="submit">حفظ وسائل الدفع</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
