<?php
require_once __DIR__ . '/includes/helpers.php';

$lang = current_lang();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string)($_POST['name'] ?? ''));
    $rating = (int)($_POST['rating'] ?? 5);
    $review = trim((string)($_POST['review'] ?? ''));
    
    if ($name !== '' && $review !== '') {
        try {
            $stmt = db()->prepare('INSERT INTO reviews (name, rating, review, lang, is_active, created_at) VALUES (:name, :rating, :review, :lang, 0, NOW())');
            $stmt->execute([
                ':name' => $name,
                ':rating' => min(5, max(1, $rating)),
                ':review' => $review,
                ':lang' => $lang
            ]);
            $success = true;
        } catch (Throwable $e) {
            $error = $lang === 'ar' ? 'حدث خطأ. يرجى المحاولة مرة أخرى.' : 'An error occurred. Please try again.';
        }
    } else {
        $error = $lang === 'ar' ? 'يرجى تعبئة جميع الحقول.' : 'Please fill in all fields.';
    }
}

$reviews = [];
try {
    $reviews = db()->query("SELECT * FROM reviews WHERE is_active = 1 AND lang = '$lang' ORDER BY id DESC LIMIT 20")->fetchAll();
} catch (Throwable $e) {}

$avgRating = 0;
$totalReviews = count($reviews);
if ($totalReviews > 0) {
    $avgRating = array_sum(array_column($reviews, 'rating')) / $totalReviews;
}

$page_title = $lang === 'ar' ? 'آراء العملاء | سوا لتأجير السيارات' : 'Customer Reviews | Sawa Rent Car';
$page_description = $lang === 'ar' 
    ? 'اقرأ آراء عملائنا عن خدمات تأجير السيارات لدينا'
    : 'Read what our customers say about our car rental services';

include __DIR__ . '/partials/header.php';
?>

<style>
.reviews-page {
    min-height: 100vh;
    padding: 100px 20px 60px;
    background: linear-gradient(135deg, var(--brand-dark) 0%, #0a1628 100%);
}

.reviews-container {
    max-width: 800px;
    margin: 0 auto;
}

.reviews-header {
    text-align: center;
    margin-bottom: 48px;
    color: white;
}

.reviews-header h1 {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 12px;
}

.reviews-rating {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-bottom: 8px;
}

.rating-stars {
    display: flex;
    gap: 4px;
}

.rating-stars i {
    color: #fbbf24;
    font-size: 24px;
}

.rating-value {
    font-size: 48px;
    font-weight: 800;
    color: var(--brand-accent);
}

.rating-count {
    color: rgba(255, 255, 255, 0.6);
    font-size: 16px;
}

/* Review Card */
.reviews-grid {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 48px;
}

.review-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 24px;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.reviewer-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.reviewer-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--brand-accent), var(--accent-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 700;
    color: #0a0d12;
}

.reviewer-name {
    color: white;
    font-weight: 700;
    font-size: 16px;
}

.reviewer-date {
    color: rgba(255, 255, 255, 0.5);
    font-size: 13px;
}

.review-rating {
    display: flex;
    gap: 3px;
}

.review-rating i {
    color: #fbbf24;
    font-size: 14px;
}

.review-rating i.empty {
    color: rgba(255, 255, 255, 0.2);
}

.review-text {
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.7;
    font-size: 15px;
}

/* Review Form */
.review-form-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 32px;
}

.review-form-card h2 {
    color: white;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 24px;
    text-align: center;
}

.review-form .form-group {
    margin-bottom: 20px;
}

.review-form label {
    display: block;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 8px;
    font-weight: 500;
}

.review-form input,
.review-form textarea {
    width: 100%;
    padding: 14px 18px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    color: white;
    font-size: 15px;
    transition: all 0.3s ease;
}

.review-form input:focus,
.review-form textarea:focus {
    outline: none;
    border-color: var(--brand-accent);
    background: rgba(255, 255, 255, 0.12);
}

.review-form textarea {
    min-height: 120px;
    resize: vertical;
}

.rating-select {
    display: flex;
    gap: 8px;
}

.rating-select input {
    display: none;
}

.rating-select label {
    cursor: pointer;
    font-size: 28px;
    color: rgba(255, 255, 255, 0.2);
    transition: all 0.2s ease;
}

.rating-select label:hover,
.rating-select label:hover ~ label,
.rating-select input:checked ~ label {
    color: #fbbf24;
}

.rating-select label:hover,
.rating-select label:hover ~ label {
    transform: scale(1.1);
}

.submit-review-btn {
    width: 100%;
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

.submit-review-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(216, 176, 74, 0.3);
}

.success-message {
    background: rgba(34, 197, 94, 0.15);
    border: 1px solid rgba(34, 197, 94, 0.3);
    border-radius: 12px;
    padding: 16px;
    color: #4ade80;
    text-align: center;
    margin-bottom: 24px;
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

.empty-reviews {
    text-align: center;
    padding: 48px 24px;
    color: rgba(255, 255, 255, 0.5);
}

.empty-reviews i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.3;
}

@media (max-width: 576px) {
    .reviews-header h1 {
        font-size: 28px;
    }
    
    .rating-value {
        font-size: 36px;
    }
    
    .review-card {
        padding: 20px;
    }
    
    .review-form-card {
        padding: 24px;
    }
}
</style>

<div class="reviews-page">
    <div class="reviews-container" data-aos="fade-up">
        <div class="reviews-header">
            <h1><?= $lang === 'ar' ? 'آراء عملائنا' : 'What Our Customers Say' ?></h1>
            
            <div class="reviews-rating">
                <div class="rating-stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star<?= $i <= round($avgRating) ? '' : '-empty' ?>"></i>
                    <?php endfor; ?>
                </div>
                <span class="rating-value"><?= number_format($avgRating, 1) ?></span>
            </div>
            <p class="rating-count">
                <?= $totalReviews ?> <?= $lang === 'ar' ? 'تقييم' : 'reviews' ?>
            </p>
        </div>
        
        <?php if (isset($success) && $success): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <?= $lang === 'ar' 
                    ? 'شكراً لك! تم إرسال تقييمك بنجاح وسيظهر بعد المراجعة.'
                    : 'Thank you! Your review has been submitted and will appear after review.' ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error) && $error): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?= e($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if (empty($reviews)): ?>
            <div class="empty-reviews">
                <i class="fas fa-star"></i>
                <p><?= $lang === 'ar' 
                    ? 'لا توجد تقييمات بعد. كن أول من يقيم!'
                    : 'No reviews yet. Be the first to review!' ?></p>
            </div>
        <?php else: ?>
            <div class="reviews-grid">
                <?php foreach ($reviews as $r): ?>
                    <div class="review-card" data-aos="fade-up" data-aos-delay="<?= 100 + $loop_index ?? 0 * 50 ?>">
                        <div class="review-header">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    <?= strtoupper(substr($r['name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="reviewer-name"><?= e($r['name']) ?></div>
                                    <div class="reviewer-date">
                                        <?= date('d M Y', strtotime($r['created_at'])) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="review-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star<?= $i <= $r['rating'] ? '' : ' empty' ?>"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <p class="review-text"><?= e($r['review']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="review-form-card" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'أضف تقييمك' : 'Add Your Review' ?></h2>
            
            <form method="POST" class="review-form">
                <div class="form-group">
                    <label><?= $lang === 'ar' ? 'الاسم' : 'Name' ?></label>
                    <input type="text" name="name" required placeholder="<?= $lang === 'ar' ? 'أدخل اسمك' : 'Enter your name' ?>">
                </div>
                
                <div class="form-group">
                    <label><?= $lang === 'ar' ? 'التقييم' : 'Rating' ?></label>
                    <div class="rating-select">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" <?= $i === 5 ? 'checked' : '' ?>>
                            <label for="star<?= $i ?>"><i class="fas fa-star"></i></label>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label><?= $lang === 'ar' ? 'التعليق' : 'Review' ?></label>
                    <textarea name="review" required placeholder="<?= $lang === 'ar' ? 'اكتب تجربتك معنا...' : 'Share your experience with us...' ?>"></textarea>
                </div>
                
                <button type="submit" class="submit-review-btn">
                    <i class="fas fa-paper-plane"></i>
                    <?= $lang === 'ar' ? 'إرسال التقييم' : 'Submit Review' ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
