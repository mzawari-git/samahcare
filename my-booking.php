<?php
require_once __DIR__ . '/includes/helpers.php';

$lang = current_lang();
$phone = trim((string)($_GET['phone'] ?? ''));
$booking = null;
$error = '';

if ($phone !== '') {
    try {
        $stmt = db()->prepare("SELECT b.*, c.name_ar, c.name_en, c.image_path 
                              FROM bookings b 
                              LEFT JOIN cars c ON c.id = b.car_id 
                              WHERE b.phone LIKE :phone 
                              ORDER BY b.id DESC 
                              LIMIT 5");
        $stmt->execute([':phone' => '%' . $phone]);
        $bookings = $stmt->fetchAll();
        
        if (count($bookings) > 0) {
            $booking = $bookings[0];
        } else {
            $error = $lang === 'ar' 
                ? 'لم يتم العثور على حجز بهذا الرقم'
                : 'No booking found with this phone number';
        }
    } catch (Throwable $e) {
        $error = $lang === 'ar' 
            ? 'حدث خطأ في البحث'
            : 'Error searching for booking';
    }
}

$page_title = $lang === 'ar' ? 'تتبع حجزي | سوا لتأجير السيارات' : 'Track My Booking | Sawa Rent Car';
$page_description = $lang === 'ar' 
    ? 'تتبع حالة حجزك للسيارة من سوا لتأجير السيارات'
    : 'Track your car rental booking status';

include __DIR__ . '/partials/header.php';
?>

<style>
.my-booking-page {
    min-height: 100vh;
    padding: 120px 20px 60px;
    background: linear-gradient(135deg, var(--brand-dark) 0%, #0a1628 100%);
}

.my-booking-card {
    max-width: 500px;
    margin: 0 auto;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    padding: 40px;
}

.my-booking-title {
    text-align: center;
    margin-bottom: 32px;
    color: white;
}

.my-booking-title h1 {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 8px;
}

.my-booking-title p {
    color: rgba(255, 255, 255, 0.6);
}

.search-form {
    margin-bottom: 32px;
}

.search-input {
    width: 100%;
    padding: 16px 20px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 14px;
    color: white;
    font-size: 16px;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: var(--brand-accent);
    background: rgba(255, 255, 255, 0.12);
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.4);
}

.search-btn {
    width: 100%;
    margin-top: 16px;
    padding: 16px 24px;
    background: linear-gradient(135deg, var(--brand-accent), var(--accent-dark));
    border: none;
    border-radius: 14px;
    color: #0a0d12;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(216, 176, 74, 0.3);
}

.error-message {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 12px;
    padding: 16px;
    color: #fca5a5;
    text-align: center;
    margin-bottom: 24px;
}

.booking-result {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 18px;
    overflow: hidden;
}

.booking-header {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.1));
    padding: 24px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.booking-id {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.5);
    margin-bottom: 4px;
}

.booking-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
}

.booking-status.new {
    background: rgba(59, 130, 246, 0.2);
    color: #60a5fa;
}

.booking-status.contacted {
    background: rgba(245, 158, 11, 0.2);
    color: #fbbf24;
}

.booking-status.confirmed {
    background: rgba(34, 197, 94, 0.2);
    color: #4ade80;
}

.booking-status.completed {
    background: rgba(156, 163, 175, 0.2);
    color: #9ca3af;
}

.booking-status.cancelled {
    background: rgba(239, 68, 68, 0.2);
    color: #fca5a5;
}

.booking-details {
    padding: 24px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    color: rgba(255, 255, 255, 0.5);
    font-size: 14px;
}

.detail-value {
    color: white;
    font-weight: 600;
    font-size: 14px;
}

.booking-car {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 12px;
    margin-top: 16px;
}

.car-image {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.car-placeholder {
    width: 80px;
    height: 60px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255, 255, 255, 0.3);
}

.car-info h4 {
    color: white;
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 4px;
}

.car-info p {
    color: rgba(255, 255, 255, 0.5);
    font-size: 13px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    margin-bottom: 24px;
    transition: color 0.3s ease;
}

.back-link:hover {
    color: white;
}

@media (max-width: 576px) {
    .my-booking-card {
        padding: 24px;
    }
    
    .my-booking-title h1 {
        font-size: 24px;
    }
}
</style>

<div class="my-booking-page">
    <div class="my-booking-card" data-aos="fade-up">
        <div class="my-booking-title">
            <h1><?= $lang === 'ar' ? 'تتبع حجزك' : 'Track Your Booking' ?></h1>
            <p><?= $lang === 'ar' 
                ? 'أدخل رقم الهاتف الذي استخدمته في الحجز'
                : 'Enter the phone number you used for booking' ?></p>
        </div>
        
        <form method="GET" class="search-form">
            <input type="tel" 
                   name="phone" 
                   class="search-input" 
                   placeholder="<?= $lang === 'ar' ? 'رقم الهاتف' : 'Phone Number' ?>"
                   value="<?= e($phone) ?>"
                   required>
            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i>
                <?= $lang === 'ar' ? 'ابحث عن حجزي' : 'Search My Booking' ?>
            </button>
        </form>
        
        <?php if ($error): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?= e($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($booking): ?>
            <div class="booking-result" data-aos="fade-up" data-aos-delay="100">
                <div class="booking-header">
                    <div class="booking-id">
                        <?= $lang === 'ar' ? 'رقم الحجز' : 'Booking #' ?><?= (int)$booking['id'] ?>
                    </div>
                    <span class="booking-status <?= e($booking['status']) ?>">
                        <?php
                        $statusText = [
                            'new' => $lang === 'ar' ? 'جديد' : 'New',
                            'contacted' => $lang === 'ar' ? 'تم التواصل' : 'Contacted',
                            'confirmed' => $lang === 'ar' ? 'مؤكد' : 'Confirmed',
                            'completed' => $lang === 'ar' ? 'مكتمل' : 'Completed',
                            'cancelled' => $lang === 'ar' ? 'ملغي' : 'Cancelled',
                        ];
                        echo $statusText[$booking['status']] ?? $booking['status'];
                        ?>
                    </span>
                </div>
                
                <div class="booking-details">
                    <div class="detail-row">
                        <span class="detail-label"><?= $lang === 'ar' ? 'الاسم' : 'Name' ?></span>
                        <span class="detail-value"><?= e($booking['customer_name']) ?></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label"><?= $lang === 'ar' ? 'رقم الهاتف' : 'Phone' ?></span>
                        <span class="detail-value" dir="ltr"><?= e($booking['phone']) ?></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label"><?= $lang === 'ar' ? 'من تاريخ' : 'From' ?></span>
                        <span class="detail-value"><?= e($booking['start_date']) ?></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label"><?= $lang === 'ar' ? 'إلى تاريخ' : 'To' ?></span>
                        <span class="detail-value"><?= e($booking['end_date']) ?></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label"><?= $lang === 'ar' ? 'عدد الأيام' : 'Days' ?></span>
                        <span class="detail-value"><?= (int)$booking['num_days'] ?></span>
                    </div>
                    
                    <?php if ($booking['total_price'] > 0): ?>
                    <div class="detail-row">
                        <span class="detail-label"><?= $lang === 'ar' ? 'السعر الإجمالي' : 'Total Price' ?></span>
                        <span class="detail-value" style="color: var(--brand-accent);">
                            ₪<?= number_format($booking['total_price']) ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($booking['name_ar']) || !empty($booking['name_en'])): ?>
                    <div class="booking-car">
                        <?php if (!empty($booking['image_path'])): ?>
                            <img src="<?= e(asset_url($booking['image_path'])) ?>" 
                                 alt="car" 
                                 class="car-image">
                        <?php else: ?>
                            <div class="car-placeholder">
                                <i class="fas fa-car"></i>
                            </div>
                        <?php endif; ?>
                        <div class="car-info">
                            <h4><?= e($lang === 'ar' ? ($booking['name_ar'] ?? '') : ($booking['name_en'] ?? '')) ?></h4>
                            <p><?= $lang === 'ar' ? 'السيارة المحجوزة' : 'Booked Car' ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if ($booking['status'] === 'new' || $booking['status'] === 'contacted'): ?>
            <a href="<?= get_whatsapp_link($lang === 'ar' 
                ? 'مرحباً، أرغب في إلغاء حجز رقم ' . $booking['id']
                : 'Hello, I would like to cancel booking #' . $booking['id']) ?>" 
               class="search-btn" 
               style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; margin-top: 16px; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times-circle"></i>
                <?= $lang === 'ar' ? 'إلغاء الحجز' : 'Cancel Booking' ?>
            </a>
            <?php endif; ?>
        <?php endif; ?>
        
        <a href="index.php" class="back-link" style="display: block; text-align: center; margin-top: 24px;">
            <i class="fas fa-arrow-<?= $lang === 'ar' ? 'right' : 'left' ?>"></i>
            <?= $lang === 'ar' ? 'العودة للرئيسية' : 'Back to Home' ?>
        </a>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
