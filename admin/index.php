<?php

require_once __DIR__ . '/includes/auth.php';
require_admin();

$dateRange = trim((string)($_GET['range'] ?? '30'));
$dateFrom = trim((string)($_GET['from'] ?? ''));
$dateTo = trim((string)($_GET['to'] ?? ''));

$days = (int)$dateRange;
if ($days <= 0) $days = 30;

if ($dateFrom !== '' && $dateTo !== '') {
    $whereDate = "WHERE created_at >= :date_from AND created_at <= :date_to";
    $params = [':date_from' => $dateFrom, ':date_to' => $dateTo . ' 23:59:59'];
} else {
    $whereDate = "WHERE created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)";
    $params = [':days' => $days];
}

$stats = [
    'cars' => 0,
    'offers' => 0,
    'slides' => 0,
    'bookings' => 0,
    'bookings_new' => 0,
    'bookings_pending' => 0,
    'bookings_completed' => 0,
    'bookings_cancelled' => 0,
    'total_revenue' => 0,
    'active_cars' => 0,
    'users' => 0,
];

try {
    $stats['cars'] = (int)db()->query('SELECT COUNT(*) AS c FROM cars')->fetch()['c'];
} catch (Throwable $e) {}

try {
    $stats['active_cars'] = (int)db()->query("SELECT COUNT(*) AS c FROM cars WHERE is_active = 1")->fetch()['c'];
} catch (Throwable $e) {}

try {
    $stats['offers'] = (int)db()->query('SELECT COUNT(*) AS c FROM offers WHERE is_active = 1')->fetch()['c'];
} catch (Throwable $e) {}

try {
    $stats['slides'] = (int)db()->query('SELECT COUNT(*) AS c FROM slides WHERE is_active = 1')->fetch()['c'];
} catch (Throwable $e) {}

try {
    $stats['bookings'] = (int)db()->query('SELECT COUNT(*) AS c FROM bookings')->fetch()['c'];
} catch (Throwable $e) {}

try {
    $stats['bookings_new'] = (int)db()->query("SELECT COUNT(*) AS c FROM bookings WHERE status = 'new'")->fetch()['c'];
} catch (Throwable $e) {}

try {
    $stats['bookings_pending'] = (int)db()->query("SELECT COUNT(*) AS c FROM bookings WHERE status = 'contacted'")->fetch()['c'];
} catch (Throwable $e) {}

try {
    $stats['bookings_completed'] = (int)db()->query("SELECT COUNT(*) AS c FROM bookings WHERE status = 'confirmed'")->fetch()['c'];
} catch (Throwable $e) {}

try {
    $stats['bookings_cancelled'] = (int)db()->query("SELECT COUNT(*) AS c FROM bookings WHERE status = 'cancelled'")->fetch()['c'];
} catch (Throwable $e) {}

try {
    $revenue = db()->query("SELECT SUM(amount) AS total FROM payments WHERE status = 'completed'")->fetch();
    $stats['total_revenue'] = (float)($revenue['total'] ?? 0);
} catch (Throwable $e) {}

try {
    $stats['users'] = (int)db()->query('SELECT COUNT(*) AS c FROM users')->fetch()['c'];
} catch (Throwable $e) {}

$monthlyStats = [];
try {
    $sql = "SELECT 
        DATE_FORMAT(created_at, '%Y-%m') as month,
        COUNT(*) as total,
        SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new_count,
        SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed_count,
        SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_count
        FROM bookings 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        GROUP BY DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY month ASC";
    $monthlyStats = db()->query($sql)->fetchAll();
} catch (Throwable $e) {
    $monthlyStats = [];
}

$recentBookings = [];
try {
    $sql = "SELECT b.*, c.name_ar, c.name_en
            FROM bookings b
            LEFT JOIN cars c ON c.id = b.car_id
            ORDER BY b.id DESC
            LIMIT 10";
    $recentBookings = db()->query($sql)->fetchAll();
} catch (Throwable $e) {
    $recentBookings = [];
}

$recentCars = [];
try {
    $sql = "SELECT id, name_ar, name_en, daily_price, monthly_price, is_active, is_offer, created_at
            FROM cars
            ORDER BY id DESC
            LIMIT 5";
    $recentCars = db()->query($sql)->fetchAll();
} catch (Throwable $e) {
    $recentCars = [];
}

$popularCars = [];
try {
    $sql = "SELECT c.name_ar, c.name_en, COUNT(b.id) as booking_count
            FROM cars c
            LEFT JOIN bookings b ON b.car_id = c.id
            WHERE c.is_active = 1
            GROUP BY c.id
            ORDER BY booking_count DESC
            LIMIT 5";
    $popularCars = db()->query($sql)->fetchAll();
} catch (Throwable $e) {
    $popularCars = [];
}

$revenueData = [];
try {
    $sql = "SELECT 
        DATE_FORMAT(created_at, '%Y-%m-%d') as date,
        COUNT(*) as count,
        SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed
        FROM bookings 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        GROUP BY DATE_FORMAT(created_at, '%Y-%m-%d')
        ORDER BY date ASC";
    $revenueData = db()->query($sql)->fetchAll();
} catch (Throwable $e) {
    $revenueData = [];
}

include __DIR__ . '/partials/header-modern.php';

?>

<style>
.admin-brand-bar {
    background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);
    padding: 12px 20px;
    margin-bottom: 24px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.brand-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.brand-link {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: white;
}
.brand-logo {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid rgba(255,255,255,0.3);
}
.brand-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}
.brand-text {
    display: flex;
    flex-direction: column;
}
.brand-name {
    font-weight: 700;
    font-size: 1.1rem;
    line-height: 1.2;
}
.brand-tagline {
    font-size: 0.75rem;
    opacity: 0.8;
}
.brand-actions .btn {
    border-radius: 8px;
}
@media (max-width: 576px) {
    .brand-tagline { display: none; }
}
</style>

<style>
.dashboard-header {
    background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);
    border-radius: 16px;
    padding: 28px 32px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
    color: white;
}
.dashboard-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(59,130,246,0.3) 0%, transparent 70%);
    border-radius: 50%;
}
.dashboard-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 4px;
}
.dashboard-header p {
    color: rgba(255,255,255,0.7);
    margin: 0;
}
.dashboard-header .time-badge {
    background: rgba(255,255,255,0.15);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
}

.stat-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    overflow: hidden;
}
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}
.stat-card .card-body {
    padding: 24px;
}
.stat-card .stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 16px;
}
.stat-card .stat-value {
    font-size: 28px;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 4px;
}
.stat-card .stat-label {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
}
.stat-card .stat-trend {
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 20px;
    margin-top: 8px;
}
.stat-card .stat-trend.up { background: rgba(34,197,94,0.1); color: #16a34a; }
.stat-card .stat-trend.neutral { background: rgba(100,116,139,0.1); color: #64748b; }

.icon-gradient-blue { background: linear-gradient(135deg, #3b82f6, #1e40af); color: white; }
.icon-gradient-green { background: linear-gradient(135deg, #22c55e, #16a34a); color: white; }
.icon-gradient-purple { background: linear-gradient(135deg, #8b5cf6, #6d28d9); color: white; }
.icon-gradient-orange { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
.icon-gradient-red { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
.icon-gradient-cyan { background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; }
.icon-gradient-pink { background: linear-gradient(135deg, #ec4899, #db2777); color: white; }

/* Modern stat card enhancements */
.stat-card {
    position: relative;
    overflow: hidden;
}
.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--accent-color, #3b82f6), transparent);
}
.stat-card:hover::before {
    height: 6px;
}

.quick-action-btn {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: #334155;
    transition: all 0.25s ease;
    font-weight: 500;
}
.quick-action-btn:hover {
    border-color: #3b82f6;
    background: #f8fafc;
    color: #1e40af;
    transform: translateY(-2px);
}
.quick-action-btn .action-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.section-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}
.section-card .card-header {
    background: white;
    border-bottom: 1px solid #f1f5f9;
    padding: 18px 24px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.section-card .card-header h5 {
    margin: 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.status-pill {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.status-new { background: #cffafe; color: #0e7490; }
.status-contacted { background: #fef3c7; color: #92400e; }
.status-confirmed { background: #dcfce7; color: #166534; }
.status-cancelled { background: #fee2e2; color: #991b1b; }

.chart-container {
    position: relative;
    height: 280px;
}

.date-range-picker {
    display: flex;
    gap: 8px;
    align-items: center;
}
.date-range-picker .btn {
    padding: 6px 12px;
    font-size: 13px;
}
.date-range-picker .btn.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.export-dropdown .dropdown-menu {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    padding: 8px;
}
.export-dropdown .dropdown-item {
    border-radius: 8px;
    padding: 10px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.export-dropdown .dropdown-item i {
    width: 20px;
}

@media (max-width: 768px) {
    .dashboard-header {
        padding: 16px 20px !important;
    }
    .dashboard-header h1 {
        font-size: 1.3rem !important;
    }
    .stat-card {
        margin-bottom: 12px !important;
    }
}
</style>

<div class="dashboard-header">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h1><i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم</h1>
            <p>إدارة شاملة لسياراتك وحجوزاتك</p>
        </div>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span class="time-badge">
                <i class="fas fa-clock me-1"></i>
                <span id="currentTime"></span>
            </span>
            <div class="dropdown export-dropdown">
                <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-download me-1"></i> تصدير
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="api/export.php?type=bookings&format=csv">
                        <i class="fas fa-file-csv text-success"></i> تصدير الحجوزات (CSV)
                    </a></li>
                    <li><a class="dropdown-item" href="api/export.php?type=bookings&format=json">
                        <i class="fas fa-file-code text-info"></i> تصدير الحجوزات (JSON)
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="api/export.php?type=cars&format=csv">
                        <i class="fas fa-file-csv text-success"></i> تصدير السيارات (CSV)
                    </a></li>
                </ul>
            </div>
            <a class="btn btn-light btn-sm" href="../index.php" target="_blank">
                <i class="fas fa-external-link-alt me-1"></i> عرض الموقع
            </a>
        </div>
    </div>
</div>

<!-- Date Range -->
<div class="date-range-picker mb-4">
    <span class="text-secondary">الفترة:</span>
    <a href="?range=7" class="btn btn-outline-secondary btn-sm <?= $dateRange == '7' ? 'active' : '' ?>">أسبوع</a>
    <a href="?range=30" class="btn btn-outline-secondary btn-sm <?= $dateRange == '30' ? 'active' : '' ?>">شهر</a>
    <a href="?range=90" class="btn btn-outline-secondary btn-sm <?= $dateRange == '90' ? 'active' : '' ?>">3 أشهر</a>
    <a href="?range=365" class="btn btn-outline-secondary btn-sm <?= $dateRange == '365' ? 'active' : '' ?>">سنة</a>
</div>

<!-- Main Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="stat-icon icon-gradient-blue"><i class="fas fa-car"></i></div>
                <div class="stat-value"><?= number_format($stats['active_cars']) ?></div>
                <div class="stat-label">سيارة نشطة</div>
                <div class="stat-trend neutral">
                    <i class="fas fa-car"></i> من أصل <?= number_format($stats['cars']) ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="stat-icon icon-gradient-green"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-value"><?= number_format($stats['bookings']) ?></div>
                <div class="stat-label">إجمالي الحجوزات</div>
                <div class="stat-trend <?= $stats['bookings_new'] > 0 ? 'up' : 'neutral' ?>">
                    <i class="fas fa-bell"></i> <?= $stats['bookings_new'] ?> جديد
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="stat-icon icon-gradient-purple"><i class="fas fa-tag"></i></div>
                <div class="stat-value"><?= number_format($stats['offers']) ?></div>
                <div class="stat-label">العروض النشطة</div>
                <div class="stat-trend neutral">
                    <i class="fas fa-tag"></i> عروض متاحة
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="stat-icon <?= $stats['total_revenue'] > 0 ? 'icon-gradient-orange' : 'icon-gradient-cyan' ?>">
                    <i class="fas fa-shekel-sign"></i>
                </div>
                <div class="stat-value">₪<?= number_format($stats['total_revenue'], 0) ?></div>
                <div class="stat-label">الإيرادات</div>
                <div class="stat-trend neutral">
                    <i class="fas fa-chart-line"></i> المدفوعات
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Booking Status Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body text-center">
                <div class="stat-icon mx-auto icon-gradient-blue"><i class="fas fa-bell"></i></div>
                <div class="stat-value"><?= number_format($stats['bookings_new']) ?></div>
                <div class="stat-label">جديد</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body text-center">
                <div class="stat-icon mx-auto icon-gradient-orange"><i class="fas fa-phone-alt"></i></div>
                <div class="stat-value"><?= number_format($stats['bookings_pending']) ?></div>
                <div class="stat-label">تم التواصل</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body text-center">
                <div class="stat-icon mx-auto icon-gradient-green"><i class="fas fa-check-circle"></i></div>
                <div class="stat-value"><?= number_format($stats['bookings_completed']) ?></div>
                <div class="stat-label">مؤكد</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body text-center">
                <div class="stat-icon mx-auto icon-gradient-red"><i class="fas fa-times-circle"></i></div>
                <div class="stat-value"><?= number_format($stats['bookings_cancelled']) ?></div>
                <div class="stat-label">ملغى</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="row g-4">
    <!-- Chart Section -->
    <div class="col-xl-8">
        <div class="card section-card">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar text-primary"></i> إحصائيات الحجوزات</h5>
                <span class="badge bg-light text-dark">آخر 6 أشهر</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="bookingsChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Status Chart -->
        <div class="card section-card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-chart-pie text-info"></i> حالة الحجوزات</h5>
            </div>
            <div class="card-body">
                <div class="chart-container" style="max-height: 280px;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-xl-4">
        <div class="card section-card h-100">
            <div class="card-header">
                <h5><i class="fas fa-bolt text-warning"></i> إجراءات سريعة</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <a href="cars.php?action=add" class="quick-action-btn">
                        <div class="action-icon icon-gradient-blue"><i class="fas fa-plus"></i></div>
                        <div>
                            <div class="fw-semibold">إضافة سيارة جديدة</div>
                            <small class="text-muted">إضافة سيارة للأسطول</small>
                        </div>
                    </a>
                    <a href="offers.php?action=add" class="quick-action-btn">
                        <div class="action-icon icon-gradient-purple"><i class="fas fa-tag"></i></div>
                        <div>
                            <div class="fw-semibold">إضافة عرض جديد</div>
                            <small class="text-muted">إنشاء عرض خاص</small>
                        </div>
                    </a>
                    <a href="bookings.php" class="quick-action-btn">
                        <div class="action-icon icon-gradient-green"><i class="fas fa-calendar-check"></i></div>
                        <div>
                            <div class="fw-semibold">مراجعة الحجوزات</div>
                            <small class="text-muted">عرض طلبات الحجز</small>
                        </div>
                    </a>
                    <a href="settings.php" class="quick-action-btn">
                        <div class="action-icon icon-gradient-orange"><i class="fas fa-cog"></i></div>
                        <div>
                            <div class="fw-semibold">الإعدادات</div>
                            <small class="text-muted">إعدادات الموقع</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="row g-4 mt-2">
    <!-- Recent Bookings -->
    <div class="col-xl-8">
        <div class="card section-card">
            <div class="card-header">
                <h5><i class="fas fa-list text-success"></i> أحدث الحجوزات</h5>
                <a href="bookings.php" class="btn btn-sm btn-outline-primary">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <?php if (count($recentBookings) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>السيارة</th>
                                    <th>العميل</th>
                                    <th>الهاتف</th>
                                    <th>الحالة</th>
                                    <th>التاريخ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($recentBookings, 0, 6) as $booking): ?>
                                    <?php
                                    $status = (string)($booking['status'] ?? 'new');
                                    $statusClass = 'status-new';
                                    $statusLabel = ['new' => 'جديد', 'contacted' => 'تم التواصل', 'confirmed' => 'مؤكد', 'cancelled' => 'ملغى'][$status] ?? $status;
                                    ?>
                                    <tr>
                                        <td><span class="badge bg-light text-dark">#<?= e((string)$booking['id']) ?></span></td>
                                        <td><strong><?= e(current_lang() === 'ar' ? (string)($booking['name_ar'] ?? '-') : (string)($booking['name_en'] ?? '-')) ?></strong></td>
                                        <td><?= e((string)($booking['customer_name'] ?? '-')) ?></td>
                                        <td dir="ltr"><?= e((string)($booking['phone'] ?? '-')) ?></td>
                                        <td><span class="status-pill <?= e($statusClass) ?>"><?= e($statusLabel) ?></span></td>
                                        <td><small class="text-muted"><?= e(substr((string)($booking['created_at'] ?? ''), 0, 10)) ?></small></td>
                                        <td>
                                            <a href="booking_edit.php?id=<?= (int)$booking['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-inbox" style="font-size: 48px; color: #cbd5e1; margin-bottom: 15px; display: block;"></i>
                        <p class="text-muted">لا توجد حجوزات حتى الآن</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Popular Cars -->
    <div class="col-xl-4">
        <div class="card section-card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-fire text-danger"></i> الأكثر طلباً</h5>
            </div>
            <div class="card-body">
                <?php if (count($popularCars) > 0): ?>
                    <?php foreach ($popularCars as $index => $car): ?>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark"><?= $index + 1 ?></span>
                                <span><?= e(current_lang() === 'ar' ? (string)$car['name_ar'] : (string)$car['name_en']) ?></span>
                            </div>
                            <span class="badge bg-primary"><?= (int)$car['booking_count'] ?> حجز</span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">لا توجد بيانات</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Recent Cars -->
        <div class="card section-card">
            <div class="card-header">
                <h5><i class="fas fa-car text-primary"></i> أحدث السيارات</h5>
                <a href="cars.php" class="btn btn-sm btn-outline-primary">الكل</a>
            </div>
            <div class="card-body p-0">
                <?php if (count($recentCars) > 0): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentCars as $car): ?>
                            <div class="list-group-item d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="fw-semibold"><?= e(current_lang() === 'ar' ? (string)$car['name_ar'] : (string)$car['name_en']) ?></div>
                                    <small class="text-muted">₪<?= e($car['daily_price']) ?> /يوم</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <?php if ((int)$car['is_active'] === 1): ?>
                                        <span class="badge bg-success">نشط</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">متوقف</span>
                                    <?php endif; ?>
                                    <a href="car_edit.php?id=<?= (int)$car['id'] ?>" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted mb-2">لا توجد سيارات</p>
                        <a href="car_edit.php" class="btn btn-primary btn-sm">إضافة سيارة</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function updateTime() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    document.getElementById('currentTime').textContent = now.toLocaleDateString('ar-SA', options);
}
updateTime();
setInterval(updateTime, 60000);

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('bookingsChart');
    if (ctx) {
        const monthlyData = <?= json_encode(array_map(function($row) {
            return [
                'month' => $row['month'] ?? '',
                'total' => (int)($row['total'] ?? 0),
                'new' => (int)($row['new_count'] ?? 0),
                'confirmed' => (int)($row['confirmed_count'] ?? 0),
                'cancelled' => (int)($row['cancelled_count'] ?? 0)
            ];
        }, $monthlyStats)) ?>;
        
        const labels = monthlyData.map(item => {
            const date = new Date(item.month + '-01');
            return date.toLocaleDateString('ar-SA', { month: 'short', year: 'numeric' });
        });
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'إجمالي الحجوزات',
                        data: monthlyData.map(item => item.total),
                        borderColor: '#3b82f6',
                        backgroundColor: (context) => {
                            const ctx = context.chart.ctx;
                            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.25)');
                            gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');
                            return gradient;
                        },
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'جديد',
                        data: monthlyData.map(item => item.new),
                        borderColor: '#06b6d4',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#06b6d4',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'مؤكد',
                        data: monthlyData.map(item => item.confirmed),
                        borderColor: '#22c55e',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#22c55e',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'ملغى',
                        data: monthlyData.map(item => item.cancelled),
                        borderColor: '#ef4444',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#ef4444',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        borderDash: [5, 5]
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: "'Cairo', sans-serif",
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: {
                            family: "'Cairo', sans-serif",
                            size: 14
                        },
                        bodyFont: {
                            family: "'Cairo', sans-serif",
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                family: "'Cairo', sans-serif"
                            },
                            color: '#64748b'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: "'Cairo', sans-serif"
                            },
                            color: '#64748b'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Add booking status pie chart
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['جديد', 'تم التواصل', 'مؤكد', 'ملغى'],
                    datasets: [{
                        data: [
                            <?= (int)$stats['bookings_new'] ?>,
                            <?= (int)$stats['bookings_pending'] ?>,
                            <?= (int)$stats['bookings_completed'] ?>,
                            <?= (int)$stats['bookings_cancelled'] ?>
                        ],
                        backgroundColor: [
                            '#3b82f6',
                            '#f59e0b',
                            '#22c55e',
                            '#ef4444'
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: {
                                    family: "'Cairo', sans-serif",
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: {
                                family: "'Cairo', sans-serif"
                            },
                            bodyFont: {
                                family: "'Cairo', sans-serif"
                            },
                            padding: 12,
                            cornerRadius: 8
                        }
                    }
                }
            });
        }
    }
});
</script>

<?php include __DIR__ . '/partials/footer-modern.php'; ?>
