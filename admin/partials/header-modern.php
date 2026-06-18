<?php

require_once __DIR__ . '/../includes/auth.php';
require_admin();

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

// منطق الشعار
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

// --- تحسين مصفوفة التنقل لتكون موحدة وديناميكية ---
$navItems = [
    ['href' => 'index.php', 'label' => t('dash'), 'icon' => 'fa-tachometer-alt'],
    ['href' => 'cars.php', 'label' => t('manage_cars'), 'icon' => 'fa-car'],
    ['href' => 'offers.php', 'label' => t('manage_offers'), 'icon' => 'fa-tags'],
    ['href' => 'slides.php', 'label' => t('manage_slides'), 'icon' => 'fa-images'],
    ['href' => 'bookings.php', 'label' => t('manage_bookings'), 'icon' => 'fa-calendar-check'],
    ['href' => 'settings.php', 'label' => t('settings'), 'icon' => 'fa-cog'],
];

// إضافة الروابط بناءً على الصلاحيات
if (in_array(admin_role(), ['superadmin', 'admin'], true)) {
    $navItems[] = ['href' => 'payments.php', 'label' => ($lang === 'ar' ? 'المدفوعات' : 'Payments'), 'icon' => 'fa-credit-card'];
    $navItems[] = ['href' => 'maintenance.php', 'label' => ($lang === 'ar' ? 'الصيانة' : 'Maintenance'), 'icon' => 'fa-tools'];
}
if (admin_role() === 'superadmin') {
    $navItems[] = ['href' => 'users.php', 'label' => ($lang === 'ar' ? 'المستخدمون' : 'Users'), 'icon' => 'fa-users'];
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= e(asset_url('../assets/css/admin-modern.css')) ?>">
    <style>
    /* ── Admin Brand Bar ── */
    .admin-brand-bar {
        background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);
        padding: 12px 20px;
        margin: 0 0 20px 0;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .admin-brand-bar .brand-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .admin-brand-bar .brand-link {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: white;
    }
    .admin-brand-bar .brand-logo {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.3);
    }
    .admin-brand-bar .brand-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .admin-brand-bar .brand-text {
        display: flex;
        flex-direction: column;
    }
    .admin-brand-bar .brand-name {
        font-weight: 700;
        font-size: 1.1rem;
        line-height: 1.2;
    }
    .admin-brand-bar .brand-tagline {
        font-size: 0.75rem;
        opacity: 0.8;
    }
    @media (max-width: 576px) {
        .admin-brand-bar .brand-tagline { display: none; }
    }
    
    /* ── Sidebar & Layout ── */
    #adminSidebar {
        display: block !important;
        visibility: visible !important;
    }
    
    /* Toggle Button */
    #sidebarToggle {
        display: none;
    }
    
    /* Desktop: Always show sidebar */
    @media (min-width: 993px) {
        #sidebarToggle {
            display: none !important;
        }
        #adminSidebar {
            transform: none !important;
            position: fixed !important;
            <?= is_rtl() ? 'right: 0 !important;' : 'left: 0 !important;' ?>
        }
    }
    
    /* Mobile: Toggle sidebar */
    @media (max-width: 992px) {
        #sidebarToggle {
            display: flex !important;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.4);
        }
        
        #sidebarToggle:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.5);
        }
        
        #sidebarToggle.active {
            background: linear-gradient(135deg, #dc2626, #ef4444);
        }
        
        #adminSidebar {
            position: fixed !important;
            top: 0 !important;
            height: 100vh !important;
            width: 85% !important;
            max-width: 320px !important;
            z-index: 1050 !important;
            overflow-y: auto !important;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
            transform: <?= is_rtl() ? 'translateX(100%)' : 'translateX(-100%)' ?> !important;
            <?= is_rtl() ? 'right: 0 !important; left: auto !important;' : 'left: 0 !important; right: auto !important;' ?>
        }
        
        #adminSidebar.show {
            transform: translateX(0) !important;
        }
        
        /* Mobile Topbar */
        .admin-topbar {
            padding: 12px 16px !important;
            margin-left: 0 !important;
            flex-direction: column !important;
            gap: 10px !important;
        }
        
        html[dir="rtl"] .admin-topbar {
            margin-right: 0 !important;
        }
        
        .admin-topbar > div {
            width: 100%;
            justify-content: center !important;
        }
        
        /* Mobile Nav Icons - Bigger & Colored */
        .admin-nav a {
            padding: 14px 18px !important;
            border-radius: 12px !important;
            margin-bottom: 4px !important;
        }
        
        .admin-nav a i {
            font-size: 20px !important;
            width: 32px !important;
        }
        
        .admin-nav a span {
            font-size: 15px !important;
        }
    }
    
    /* Small Mobile */
    @media (max-width: 480px) {
        #sidebarToggle {
            width: 44px;
            height: 44px;
            font-size: 16px;
        }
        
        .admin-topbar .btn {
            padding: 8px 12px !important;
            font-size: 12px !important;
        }
        
        .admin-topbar .btn i {
            margin: 0 !important;
        }
        
        .admin-topbar .btn span {
            display: none !important;
        }
    }
    </style>
</head>
<body class="admin-body">

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="admin-shell">
    <!-- Mobile Toggle Button -->
    <button class="btn topbar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <aside class="admin-sidebar" id="adminSidebar">
        <div class="mobile-sidebar-header">
            <a class="admin-brand" href="index.php">
                <?php if ($logoPath !== ''): ?>
                    <img src="<?= e(asset_url('../' . ltrim($logoPath, '/'))) ?>" class="admin-logo" alt="logo">
                <?php else: ?>
                    <div class="mobile-logo">
                        <i class="fas fa-car"></i>
                    </div>
                <?php endif; ?>
                <div>
                    <div class="admin-brand-title"><?= e(t('dash')) ?></div>
                    <div class="admin-brand-sub"><?= e(company_name()) ?></div>
                </div>
            </a>
            <button class="mobile-close-btn" onclick="toggleSidebar()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <nav class="admin-nav">
            <?php foreach ($navItems as $item):
                $active = $page === (string)$item['href'];
                $iconClass = 'fas ' . e((string)($item['icon'] ?? 'fa-circle'));
                $labelText = e((string)$item['label']);
                echo '<a href="' . e((string)$item['href']) . '" class="' . ($active ? 'active' : '') . '" title="' . $labelText . '">';
                echo '<i class="' . $iconClass . '"></i>';
                echo '<span>' . $labelText . '</span>';
                echo '</a>';
            endforeach; ?>
        </nav>
        
        <div class="mobile-sidebar-footer">
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span><?= e(t('logout')) ?></span>
            </a>
        </div>
    </aside>

    <main class="admin-main">
        <!-- Admin Brand Bar -->
        <div class="admin-brand-bar">
            <div class="brand-content">
                <a href="index.php" class="brand-link">
                    <?php if ($logoPath !== ''): ?>
                        <img src="<?= e(asset_url('../' . ltrim($logoPath, '/'))) ?>" class="brand-logo" alt="logo">
                    <?php else: ?>
                        <div class="brand-icon"><i class="fas fa-car"></i></div>
                    <?php endif; ?>
                    <div class="brand-text">
                        <span class="brand-name"><?= e(company_name()) ?></span>
                        <span class="brand-tagline"><?= e($lang === 'ar' ? 'لوحة التحكم' : 'Admin Panel') ?></span>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="admin-topbar">
            <div class="topbar-right">
                <a class="btn btn-outline-secondary btn-sm" href="../index.php" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span class="d-none d-sm-inline"><?= e($dir === 'rtl' ? 'الموقع' : 'Website') ?></span>
                </a>
                <?php if (in_array(admin_role(), ['superadmin', 'admin'], true)): ?>
                    <a class="btn btn-outline-primary btn-sm" href="maintenance.php">
                        <i class="fas fa-tools"></i>
                        <span class="d-none d-md-inline"><?= e($dir === 'rtl' ? 'الصيانة' : 'Maintenance') ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <div class="topbar-left">
                <div class="btn-group shadow-sm" role="group">
                    <a class="btn btn-sm <?= $lang === 'ar' ? 'btn-primary' : 'btn-outline-secondary' ?>" href="<?= e(lang_url('ar')) ?>">
                        <i class="fas fa-globe"></i>
                        <span class="d-none d-sm-inline">AR</span>
                    </a>
                    <a class="btn btn-sm <?= $lang === 'en' ? 'btn-primary' : 'btn-outline-secondary' ?>" href="<?= e(lang_url('en')) ?>">
                        <i class="fas fa-globe"></i>
                        <span class="d-none d-sm-inline">EN</span>
                    </a>
                </div>
                <span class="user-badge d-none d-lg-inline-flex align-items-center">
                    <i class="fas fa-user"></i>
                    <?= e((string)(admin_user()['username'] ?? '')) ?>
                </span>
            </div>
        </div>

        <div class="admin-content">
            <div class="container-fluid">

<script>
function toggleSidebar() {
    var sidebar = document.getElementById('adminSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var toggle = document.getElementById('sidebarToggle');
    
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
    toggle.classList.toggle('active');
    
    // Prevent body scroll when sidebar is open
    document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
}

// Close sidebar when clicking a link on mobile
document.querySelectorAll('.admin-sidebar .admin-nav a').forEach(function(link) {
    link.addEventListener('click', function() {
        if (window.innerWidth < 993) {
            toggleSidebar();
        }
    });
});

// Close sidebar on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        var sidebar = document.getElementById('adminSidebar');
        if (sidebar.classList.contains('show')) {
            toggleSidebar();
        }
    }
});
</script>