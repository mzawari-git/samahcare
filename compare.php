<?php
require_once __DIR__ . '/includes/helpers.php';

$lang = current_lang();
$cars = cars_active();
$compareIds = array_filter(array_map('intval', explode(',', (string)($_GET['ids'] ?? ''))));
$compareCars = [];

if (!empty($compareIds)) {
    $ids = array_slice($compareIds, 0, 3);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    
    try {
        $stmt = db()->prepare("SELECT * FROM cars WHERE id IN ({$placeholders}) AND is_active = 1");
        $stmt->execute($ids);
        $compareCars = $stmt->fetchAll();
    } catch (Throwable $e) {
        $compareCars = [];
    }
}

$page_title = $lang === 'ar' ? 'مقارنة السيارات | سوا لتأجير السيارات' : 'Compare Cars | Sawa Rent Car';
$page_description = $lang === 'ar' 
    ? 'قارن بين أسعار ومواصفات السيارات المتاحة للتأجير'
    : 'Compare prices and specifications of available rental cars';

include __DIR__ . '/partials/header.php';
?>

<style>
.compare-page {
    min-height: 100vh;
    padding: 100px 20px 60px;
    background: linear-gradient(135deg, var(--brand-dark) 0%, #0a1628 100%);
}

.compare-container {
    max-width: 1200px;
    margin: 0 auto;
}

.compare-header {
    text-align: center;
    margin-bottom: 40px;
    color: white;
}

.compare-header h1 {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 12px;
}

.compare-header p {
    color: rgba(255, 255, 255, 0.6);
}

/* Car Selection */
.car-selection {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.car-select-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 18px;
    padding: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.car-select-card:hover {
    border-color: var(--brand-accent);
    transform: translateY(-4px);
}

.car-select-card.selected {
    border-color: var(--brand-accent);
    background: rgba(216, 176, 74, 0.1);
}

.car-select-card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 16px;
}

.car-select-card .car-placeholder {
    width: 100%;
    height: 160px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    font-size: 48px;
    color: rgba(255, 255, 255, 0.3);
}

.car-select-card h3 {
    color: white;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 8px;
}

.car-select-card .car-price {
    color: var(--brand-accent);
    font-size: 20px;
    font-weight: 800;
}

.car-select-card .car-type {
    color: rgba(255, 255, 255, 0.5);
    font-size: 13px;
    margin-bottom: 12px;
}

.select-btn {
    width: 100%;
    padding: 12px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 10px;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.select-btn:hover {
    background: var(--brand-accent);
    color: #0a0d12;
}

/* Comparison Table */
.compare-table {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    overflow: hidden;
}

.compare-table-header {
    display: grid;
    grid-template-columns: 200px repeat(auto-fit, minmax(220px, 1fr));
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.compare-table-header > div {
    padding: 24px;
    text-align: center;
}

.compare-table-header > div:first-child {
    background: rgba(255, 255, 255, 0.03);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.5);
}

.compare-car-header {
    position: relative;
}

.compare-car-header img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 12px;
}

.compare-car-header .car-name {
    color: white;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 4px;
}

.compare-car-header .car-price {
    color: var(--brand-accent);
    font-size: 22px;
    font-weight: 800;
}

.compare-remove {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 32px;
    height: 32px;
    background: rgba(239, 68, 68, 0.8);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.compare-remove:hover {
    background: #ef4444;
    transform: scale(1.1);
}

.compare-row {
    display: grid;
    grid-template-columns: 200px repeat(auto-fit, minmax(220px, 1fr));
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.compare-row:last-child {
    border-bottom: none;
}

.compare-row > div {
    padding: 16px 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.compare-row > div:first-child {
    background: rgba(255, 255, 255, 0.03);
    color: rgba(255, 255, 255, 0.5);
    font-weight: 600;
    font-size: 14px;
}

.compare-value {
    color: white;
    font-weight: 500;
}

.compare-value.highlight {
    color: var(--brand-accent);
    font-weight: 700;
}

.compare-actions {
    display: flex;
    gap: 12px;
    margin-top: 32px;
    justify-content: center;
}

.compare-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 28px;
    background: linear-gradient(135deg, var(--brand-accent), var(--accent-dark));
    border: none;
    border-radius: 12px;
    color: #0a0d12;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
}

.compare-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(216, 176, 74, 0.3);
    color: #0a0d12;
}

.clear-btn {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

.clear-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    box-shadow: none;
}

.empty-compare {
    text-align: center;
    padding: 60px 20px;
    color: rgba(255, 255, 255, 0.5);
}

.empty-compare i {
    font-size: 64px;
    margin-bottom: 20px;
    opacity: 0.3;
}

@media (max-width: 768px) {
    .compare-table-header,
    .compare-row {
        grid-template-columns: 1fr;
    }
    
    .compare-table-header > div:first-child,
    .compare-row > div:first-child {
        background: rgba(255, 255, 255, 0.08);
        padding: 12px;
        justify-content: flex-start;
        text-align: left;
    }
    
    .compare-table-header > div:not(:first-child),
    .compare-row > div:not(:first-child) {
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }
}
</style>

<div class="compare-page">
    <div class="compare-container" data-aos="fade-up">
        <div class="compare-header">
            <h1><?= $lang === 'ar' ? 'مقارنة السيارات' : 'Compare Cars' ?></h1>
            <p><?= $lang === 'ar' 
                ? 'اختر حتى 3 سيارات للمقارنة'
                : 'Select up to 3 cars to compare' ?></p>
        </div>
        
        <?php if (empty($compareCars)): ?>
        <div class="car-selection">
            <?php foreach ($cars as $car): ?>
                <?php 
                $img = (string)($car['image_path'] ?? '');
                $name = car_name($car);
                $type = car_type($car);
                ?>
                <div class="car-select-card" data-car-id="<?= (int)$car['id'] ?>">
                    <?php if ($img): ?>
                        <img src="<?= e(asset_url($img)) ?>" alt="<?= e($name) ?>">
                    <?php else: ?>
                        <div class="car-placeholder"><i class="fas fa-car"></i></div>
                    <?php endif; ?>
                    <h3><?= e($name) ?></h3>
                    <p class="car-type"><?= e($type) ?></p>
                    <p class="car-price">₪<?= e($car['daily_price']) ?> <span style="font-size: 14px; font-weight: 400; opacity: 0.7;">/ <?= $lang === 'ar' ? 'يوم' : 'day' ?></span></p>
                    <button class="select-btn" onclick="addToCompare(<?= (int)$car['id'] ?>)">
                        <i class="fas fa-plus"></i> <?= $lang === 'ar' ? 'إضافة للمقارنة' : 'Add to Compare' ?>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="empty-compare">
            <i class="fas fa-balance-scale"></i>
            <p><?= $lang === 'ar' 
                ? 'اختر السيارات التي تريد مقارنتها من الأعلى'
                : 'Select the cars you want to compare from above' ?></p>
        </div>
        
        <?php else: ?>
        <div class="compare-table">
            <div class="compare-table-header">
                <div></div>
                <?php foreach ($compareCars as $car): ?>
                    <?php 
                    $img = (string)($car['image_path'] ?? '');
                    $name = car_name($car);
                    ?>
                    <div class="compare-car-header">
                        <button class="compare-remove" onclick="removeFromCompare(<?= (int)$car['id'] ?>)">
                            <i class="fas fa-times"></i>
                        </button>
                        <?php if ($img): ?>
                            <img src="<?= e(asset_url($img)) ?>" alt="<?= e($name) ?>">
                        <?php endif; ?>
                        <div class="car-name"><?= e($name) ?></div>
                        <div class="car-price">₪<?= e($car['daily_price']) ?><span style="font-size: 14px; font-weight: 400;">/<?= $lang === 'ar' ? 'يوم' : 'day' ?></span></div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="compare-row">
                <div><?= $lang === 'ar' ? 'النوع' : 'Type' ?></div>
                <?php foreach ($compareCars as $car): ?>
                    <div class="compare-value"><?= e(car_type($car)) ?></div>
                <?php endforeach; ?>
            </div>
            
            <div class="compare-row">
                <div><?= $lang === 'ar' ? 'ناقل الحركة' : 'Transmission' ?></div>
                <?php foreach ($compareCars as $car): ?>
                    <div class="compare-value"><?= e($car['transmission'] ?? ($lang === 'ar' ? 'أوتوماتيك' : 'Automatic')) ?></div>
                <?php endforeach; ?>
            </div>
            
            <div class="compare-row">
                <div><?= $lang === 'ar' ? 'نوع الوقود' : 'Fuel Type' ?></div>
                <?php foreach ($compareCars as $car): ?>
                    <div class="compare-value"><?= e($car['fuel'] ?? ($lang === 'ar' ? 'بنزين' : 'Petrol')) ?></div>
                <?php endforeach; ?>
            </div>
            
            <div class="compare-row">
                <div><?= $lang === 'ar' ? 'عدد المقاعد' : 'Passengers' ?></div>
                <?php foreach ($compareCars as $car): ?>
                    <div class="compare-value"><?= e($car['passengers'] ?? '5') ?></div>
                <?php endforeach; ?>
            </div>
            
            <div class="compare-row">
                <div><?= $lang === 'ar' ? 'السعر الشهري' : 'Monthly Price' ?></div>
                <?php foreach ($compareCars as $car): ?>
                    <div class="compare-value highlight">
                        <?php if (!empty($car['monthly_price'])): ?>
                            ₪<?= e($car['monthly_price']) ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="compare-row">
                <div><?= $lang === 'ar' ? 'التأمين' : 'Insurance' ?></div>
                <?php foreach ($compareCars as $car): ?>
                    <div class="compare-value"><?= $lang === 'ar' ? 'شامل' : 'Included' ?></div>
                <?php endforeach; ?>
            </div>
            
            <div class="compare-row">
                <div><?= $lang === 'ar' ? 'التوصيل' : 'Delivery' ?></div>
                <?php foreach ($compareCars as $car): ?>
                    <div class="compare-value"><?= $lang === 'ar' ? 'مجاني' : 'Free' ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="compare-actions">
            <a href="compare.php" class="compare-btn clear-btn" onclick="clearCompare(); return false;">
                <i class="fas fa-trash"></i>
                <?= $lang === 'ar' ? 'مسح الكل' : 'Clear All' ?>
            </a>
            <?php if (count($compareCars) > 0): ?>
            <a href="#booking" class="compare-btn" onclick="selectFirstCar(<?= (int)$compareCars[0]['id'] ?>)">
                <i class="fas fa-calendar-check"></i>
                <?= $lang === 'ar' ? 'احجز الآن' : 'Book Now' ?>
            </a>
            <?php endif; ?>
        </div>
        
        <p style="text-align: center; color: rgba(255,255,255,0.4); margin-top: 20px;">
            <a href="compare.php" style="color: var(--brand-accent);">
                <?= $lang === 'ar' ? 'إضافة المزيد للمقارنة' : 'Add more to compare' ?>
            </a>
        </p>
        <?php endif; ?>
    </div>
</div>

<script>
function addToCompare(carId) {
    const url = new URL(window.location.href);
    let ids = url.searchParams.get('ids') || '';
    let idArray = ids ? ids.split(',').map(Number) : [];
    
    if (!idArray.includes(carId) && idArray.length < 3) {
        idArray.push(carId);
        url.searchParams.set('ids', idArray.join(','));
        window.location.href = url.toString();
    } else if (idArray.length >= 3) {
        alert('<?= $lang === 'ar' ? 'يمكنك مقارنة حتى 3 سيارات فقط' : 'You can compare up to 3 cars only' ?>');
    }
}

function removeFromCompare(carId) {
    const url = new URL(window.location.href);
    let ids = url.searchParams.get('ids') || '';
    let idArray = ids ? ids.split(',').map(Number) : [];
    
    idArray = idArray.filter(id => id !== carId);
    
    if (idArray.length > 0) {
        url.searchParams.set('ids', idArray.join(','));
    } else {
        url.searchParams.delete('ids');
    }
    
    window.location.href = url.toString();
}

function clearCompare() {
    const url = new URL(window.location.href);
    url.searchParams.delete('ids');
    window.location.href = url.toString();
}

function selectFirstCar(carId) {
    const select = document.querySelector('select[name="car_id"]');
    if (select) {
        select.value = carId;
        document.getElementById('booking').scrollIntoView({ behavior: 'smooth' });
    }
}
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
