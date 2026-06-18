<?php

require_once __DIR__ . '/../includes/auth.php';
require_admin();

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

$logoFromSettings = trim(setting('site_logo', ''));
$logoPath = '';
if ($logoFromSettings !== '') {
    $logoLocal = __DIR__ . '/../../' . ltrim($logoFromSettings, '/');
    if (is_file($logoLocal)) {
        $logoPath = $logoFromSettings;
    }
}
if ($logoPath === '' && is_file(__DIR__ . '/../../unnamed (1).jpg')) {
    $logoPath = 'unnamed (1).jpg';
}

$page = basename((string)($_SERVER['PHP_SELF'] ?? 'index.php'));

// Navigation items with icons
if ($lang === 'ar') {
    $navItems = [
        ['href' => 'index.php', 'label' => 'لوحة التحكم', 'icon' => 'fa-tachometer-alt'],
        ['href' => 'cars.php', 'label' => 'إدارة السيارات', 'icon' => 'fa-car'],
        ['href' => 'offers.php', 'label' => 'إدارة العروض', 'icon' => 'fa-tags'],
        ['href' => 'slides.php', 'label' => 'إدارة السلايدشو', 'icon' => 'fa-images'],
        ['href' => 'bookings.php', 'label' => 'طلبات الحجز', 'icon' => 'fa-calendar-check'],
        ['href' => 'settings.php', 'label' => 'الإعدادات', 'icon' => 'fa-cog'],
        ['href' => 'settings_original_backup.php', 'label' => 'الإعدادات (القديم)', 'icon' => 'fa-cog-alt'],
    ];
    if (in_array(admin_role(), ['superadmin', 'admin'], true)) {
        $navItems[] = ['href' => 'payments.php', 'label' => 'المدفوعات', 'icon' => 'fa-credit-card'];
        $navItems[] = ['href' => 'map_settings.php', 'label' => 'إعدادات الخريطة', 'icon' => 'fa-map-marked-alt'];
        $navItems[] = ['href' => 'maintenance.php', 'label' => 'الصيانة', 'icon' => 'fa-tools'];
    }
    if (admin_role() === 'superadmin') {
        $navItems[] = ['href' => 'users.php', 'label' => 'المستخدمون', 'icon' => 'fa-users'];
    }
} else {
    $navItems = [
        ['href' => 'index.php', 'label' => t('dash'), 'icon' => 'fa-tachometer-alt'],
        ['href' => 'cars.php', 'label' => t('manage_cars'), 'icon' => 'fa-car'],
        ['href' => 'offers.php', 'label' => t('manage_offers'), 'icon' => 'fa-tags'],
        ['href' => 'slides.php', 'label' => t('manage_slides'), 'icon' => 'fa-images'],
        ['href' => 'bookings.php', 'label' => t('manage_bookings'), 'icon' => 'fa-calendar-check'],
        ['href' => 'settings.php', 'label' => t('settings'), 'icon' => 'fa-cog'],
        ['href' => 'settings_original_backup.php', 'label' => 'Settings (Old)', 'icon' => 'fa-cog-alt'],
    ];
    if (in_array(admin_role(), ['superadmin', 'admin'], true)) {
        $navItems[] = ['href' => 'payments.php', 'label' => 'Payments', 'icon' => 'fa-credit-card'];
        $navItems[] = ['href' => 'map_settings.php', 'label' => 'Map Settings', 'icon' => 'fa-map-marked-alt'];
        $navItems[] = ['href' => 'maintenance.php', 'label' => 'Maintenance', 'icon' => 'fa-tools'];
    }
    if (admin_role() === 'superadmin') {
        $navItems[] = ['href' => 'users.php', 'label' => 'Users', 'icon' => 'fa-users'];
    }
}

?><!doctype html>
<html lang="<?= e($lang) ?>" dir="<?= e($dir) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(t('dash')) ?> - <?= e(company_name()) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <?php if (is_rtl()): ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <?php else: ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>
     
    <!-- Modern Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
     
    <!-- Modern CSS -->
    <link rel="stylesheet" href="<?= e(asset_url('../assets/css/admin-modern.css')) ?>">
    <style>
    /* ── Sidebar: ALWAYS block, hidden via transform only ── */
    #adminSidebar {
        display: block !important;
        visibility: visible !important;
    }
    @media (max-width: 992px) {
        #adminSidebar {
            position: fixed !important;
            top: 0 !important;
            height: 100vh !important;
            width: 280px !important;
            z-index: 1050 !important;
            overflow-y: auto !important;
            transition: transform 0.3s ease !important;
            transform: <?= is_rtl() ? 'translateX(280px)' : 'translateX(-280px)' ?> !important;
            <?= is_rtl() ? 'right: 0 !important; left: auto !important;' : 'left: 0 !important; right: auto !important;' ?>
        }
        #adminSidebar.show {
            transform: translateX(0) !important;
        }
    }
    @media (min-width: 993px) {
        #adminSidebar {
            transform: none !important;
            position: fixed !important;
            <?= is_rtl() ? 'right: 0 !important;' : 'left: 0 !important;' ?>
        }
    }
    </style>
</head>
<body class="admin-body">

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Mobile Hamburger Toggle -->
<button class="topbar-toggle" id="sidebarToggle" onclick="toggleSidebar()"
    style="position: fixed; z-index: 1051; top: 10px; <?= $dir === 'rtl' ? 'right: 10px;' : 'left: 10px;' ?>; width: 40px; height: 40px; border-radius: 8px; border: none; background: #1e40af; color: white; display: none; align-items: center; justify-content: center; font-size: 18px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
    <i class="fas fa-bars"></i>
</button>

<div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar">
        <a class="admin-brand" href="index.php">
            <?php if ($logoPath !== ''): ?>
                <img src="<?= e(asset_url('../' . ltrim($logoPath, '/'))) ?>" class="admin-logo" alt="logo">
            <?php else: ?>
                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px;">
                    S
                </div>
            <?php endif; ?>
            <div>
                <div class="admin-brand-title"><?= e(t('dash')) ?></div>
                <div class="admin-brand-sub"><?= e(company_name()) ?></div>
            </div>
        </a>

        <nav class="admin-nav">
            <?php foreach ($navItems as $item):
                $active = $page === (string)$item['href'];
                echo '<a href="' . e((string)$item['href']) . '" class="' . ($active ? 'active' : '') . '" title="' . e((string)$item['label']) . '">';
                echo '<i class="fas ' . e((string)($item['icon'] ?? 'fa-circle')) . '"></i>';
                echo '<span>' . e((string)$item['label']) . '</span>';
                echo '</a>';
            endforeach; ?>
        </nav>
    </aside>

    <main class="admin-main">
        <div class="admin-topbar">
            <div class="d-flex gap-2 align-items-center flex-wrap">
                <?php if ($dir === 'rtl'): ?>
                    <button class="btn btn-outline-secondary btn-sm d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebarOffcanvas" aria-controls="adminSidebarOffcanvas">
                        <i class="fas fa-bars"></i> القائمة
                    </button>
                <?php endif; ?>
                <a class="btn btn-outline-secondary btn-sm" href="../index.php" target="_blank">
                    <i class="fas fa-globe"></i> <?= e($dir === 'rtl' ? 'فتح الموقع' : 'Open Site') ?>
                </a>
                <?php if (in_array(admin_role(), ['superadmin', 'admin'], true)): ?>
                    <a class="btn btn-outline-primary btn-sm" href="maintenance.php" rel="noopener">
                        <i class="fas fa-tools"></i> <?= e($dir === 'rtl' ? 'الصيانة' : 'Maintenance') ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <div class="btn-group" role="group">
                    <a class="btn btn-sm <?= $lang === 'ar' ? 'btn-primary' : 'btn-outline-secondary' ?>" href="<?= e(lang_url('ar')) ?>">العربية</a>
                    <a class="btn btn-sm <?= $lang === 'en' ? 'btn-primary' : 'btn-outline-secondary' ?>" href="<?= e(lang_url('en')) ?>">English</a>
                </div>
                <span class="badge bg-primary d-none d-lg-inline-flex align-items-center">
                    <i class="fas fa-user-circle"></i>&nbsp;
                    <?= e((string)(admin_user()['username'] ?? '')) ?>
                    (<?= e(admin_role()) ?>)
                </span>
                <a class="btn btn-outline-danger btn-sm" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> <?= e(t('logout')) ?>
                </a>
            </div>
        </div>

        <?php if ($dir === 'rtl'): ?>
        <div class="offcanvas offcanvas-end admin-offcanvas" tabindex="-1" id="adminSidebarOffcanvas" aria-labelledby="adminSidebarOffcanvasLabel">
            <div class="offcanvas-header">
                <div class="d-flex align-items-center gap-2" id="adminSidebarOffcanvasLabel">
                    <?php if ($logoPath !== ''): ?>
                        <img src="<?= e(asset_url('../' . ltrim($logoPath, '/'))) ?>" class="admin-logo" alt="logo">
                    <?php else: ?>
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                            S
                        </div>
                    <?php endif; ?>
                    <div>
                        <div class="fw-bold"><?= e(t('dash')) ?></div>
                        <div class="small text-secondary"><?= e(company_name()) ?></div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <nav class="admin-nav">
                    <?php foreach ($navItems as $item):
                        $active = $page === (string)$item['href'];
                    ?>
                        <a href="<?= e((string)$item['href']) ?>" class="<?= $active ? 'active' : '' ?>" data-bs-dismiss="offcanvas">
                            <i class="fas <?= e((string)($item['icon'] ?? 'fa-circle')) ?>"></i>
                            <span><?= e((string)$item['label']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </div>
        <?php endif; ?>

        <div class="admin-content">
            <div class="container-fluid">

<script>
function toggleSidebar() {
    var sidebar  = document.getElementById('adminSidebar');
    var overlay  = document.getElementById('sidebarOverlay');
    var toggle   = document.getElementById('sidebarToggle');
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
    if (toggle) toggle.classList.toggle('active');
}

// Auto-close sidebar when a nav link is clicked on mobile
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#adminSidebar .admin-nav a').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth < 993) {
                var sidebar = document.getElementById('adminSidebar');
                var overlay = document.getElementById('sidebarOverlay');
                var toggle  = document.getElementById('sidebarToggle');
                if (sidebar) sidebar.classList.remove('show');
                if (overlay) overlay.classList.remove('show');
                if (toggle) toggle.classList.remove('active');
            }
        });
    });
});
</script>
