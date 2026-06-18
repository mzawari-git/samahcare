<?php

require_once __DIR__ . '/includes/helpers.php';

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

$page_title = ($lang === 'ar' ? 'مدونة سوى - نصائح ومقالات تأجير السيارات' : 'Sawa Blog - Car Rental Tips & Guides');
$page_description = $lang === 'ar' 
    ? 'مدونة شركة سوى لتأجير السيارات في رام الله - نصائح ذهبية، guides شاملة، ومقارنة الأسعار'
    : 'Sawa Car Rental Blog in Ramallah - Golden tips, comprehensive guides, and price comparisons';
$canonical = abs_url('blog.php');

include __DIR__ . '/partials/header.php';

$blog_articles = [
    [
        'slug' => 'guide-online-rental',
        'title_ar' => 'دليلك الشامل لاستئجار سيارة عبر الإنترنت: 5 نصائح ذهبية قبل الحجز',
        'title_en' => 'Your Complete Guide to Renting a Car Online: 5 Golden Tips Before Booking',
        'desc_ar' => 'تعلم كيفية استئجار سيارة عبر الإنترنت بأمان مع 5 نصائح ذهبية من شركة سوى',
        'desc_en' => 'Learn how to rent a car online safely with 5 golden tips from Sawa',
        'image' => 'uploads/blog-online-rental.svg',
        'category' => 'tips',
        'featured' => true
    ],
    [
        'slug' => 'choose-right-car',
        'title_ar' => 'كيف تختار السيارة المناسبة لرحلتك القادمة؟ (عائلية، اقتصادية، أم فارهة؟)',
        'title_en' => 'How to Choose the Right Car for Your Trip? (Family, Economy, or Luxury?)',
        'desc_ar' => 'دليل شامل لمقارنة فئات السيارات واختيار الأنسب لرحلتك',
        'desc_en' => 'Complete guide to comparing car categories and choosing the best for your trip',
        'image' => 'uploads/blog-choose-car.svg',
        'category' => 'guide',
        'featured' => true
    ],
    [
        'slug' => 'common-mistakes',
        'title_ar' => '7 أخطاء شائعة تجنبها عند استئجار سيارة',
        'title_en' => '7 Common Mistakes to Avoid When Renting a Car',
        'desc_ar' => 'تعرف على الأخطاء الشائعة عند استئجار السيارات وكيفية تجنبها مع سوى',
        'desc_en' => 'Learn common mistakes when renting cars and how to avoid them with Sawa',
        'image' => 'uploads/blog-mistakes.svg',
        'category' => 'tips',
        'featured' => true
    ],
    [
        'slug' => 'first-time-rental-guide',
        'title_ar' => 'دليل تأجير السيارة لأول مرة في فلسطين',
        'title_en' => 'First-Time Car Rental Guide in Palestine',
        'desc_ar' => 'كل ما تحتاج معرفته عن تأجير سيارة لأول مرة في فلسطين',
        'desc_en' => 'Everything you need to know about renting a car for the first time in Palestine',
        'image' => 'uploads/blog-rental-guide.jpg',
        'category' => 'guide'
    ],
    [
        'slug' => 'best-tourist-destinations',
        'title_ar' => 'أفضل 10 وجهات سياحية بالقرب من رام الله',
        'title_en' => 'Top 10 Tourist Destinations Near Ramallah',
        'desc_ar' => 'استكشف أفضل الأماكن السياحية في فلسطين القريبة من رام الله',
        'desc_en' => 'Explore the best tourist places in Palestine near Ramallah',
        'image' => 'uploads/blog-tourism.jpg',
        'category' => 'tourism'
    ],
    [
        'slug' => 'car-rental-prices-comparison',
        'title_ar' => 'مقارنة شاملة: أسعار شركات تأجير السيارات في فلسطين 2026',
        'title_en' => 'Complete Comparison: Car Rental Prices in Palestine 2026',
        'desc_ar' => 'قارن بين أسعار شركات التأجير المختلفة واختر الأفضل',
        'desc_en' => 'Compare prices between different rental companies and choose the best',
        'image' => 'uploads/blog-prices.jpg',
        'category' => 'prices'
    ]
];
?>

<style>
.blog-page { padding: 60px 20px; max-width: 1200px; margin: 0 auto; }
.blog-header { text-align: center; margin-bottom: 50px; }
.blog-header h1 { color: var(--primary); font-size: 2.5rem; margin-bottom: 15px; }
.blog-header p { color: #666; font-size: 1.1rem; }
.blog-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px; }
.blog-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1); transition: all 0.3s ease; }
.blog-card:hover { transform: translateY(-8px); box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
.blog-card-image { height: 220px; background: linear-gradient(135deg, #1a73e8 0%, #4285f4 50%, #34a853 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
.blog-card-image::before { content: ""; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="2"/></svg>') center/50px repeat; }
.blog-card-image i { font-size: 5rem; color: white; opacity: 0.9; position: relative; z-index: 1; }
.blog-card-badge { position: absolute; top: 15px; right: 15px; background: #ff9800; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; z-index: 2; }
.blog-card-content { padding: 25px; }
.blog-card-category { display: inline-block; background: #e3f2fd; color: #1a73e8; padding: 4px 12px; border-radius: 15px; font-size: 0.75rem; font-weight: 600; margin-bottom: 10px; text-transform: uppercase; }
.blog-card-title { font-size: 1.25rem; margin-bottom: 12px; color: #333; font-weight: 700; line-height: 1.4; }
.blog-card-title a { text-decoration: none; color: inherit; transition: color 0.3s; }
.blog-card-title a:hover { color: #1a73e8; }
.blog-card-desc { color: #666; font-size: 0.95rem; line-height: 1.6; margin-bottom: 15px; }
.blog-card-meta { display: flex; justify-content: space-between; align-items: center; padding-top: 15px; border-top: 1px solid #eee; color: #999; font-size: 0.85rem; }
.blog-card-meta span { display: flex; align-items: center; gap: 5px; }
.blog-cta { text-align: center; margin-top: 60px; padding: 40px; background: linear-gradient(135deg, #1a73e8, #34a853); border-radius: 20px; color: white; }
.blog-cta h3 { font-size: 1.8rem; margin-bottom: 10px; }
.blog-cta p { opacity: 0.9; margin-bottom: 20px; }
.blog-featured-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
@media (max-width: 900px) { .blog-featured-grid { grid-template-columns: 1fr; } }
</style>

<div class="blog-page">
    <div class="blog-header">
        <h1><?= $lang === 'ar' ? 'مدونة سوى لتأجير السيارات' : 'Sawa Car Rental Blog' ?></h1>
        <p><?= $lang === 'ar' 
            ? 'نصائح ذهبية، guides شاملة، ومقارنة الأسعار من أفضل شركة تأجير في فلسطين' 
            : 'Golden tips, comprehensive guides, and price comparisons from the best rental company in Palestine' ?></p>
    </div>

    <!-- Featured Articles -->
    <?php 
    $featured = array_filter($blog_articles, fn($a) => !empty($a['featured']));
    if (count($featured) > 0): 
    ?>
    <div class="blog-featured-grid">
        <?php foreach ($featured as $article): ?>
        <article class="blog-card">
            <div class="blog-card-image">
                <?php if (!empty($article['featured'])): ?>
                <span class="blog-card-badge"><?= $lang === 'ar' ? 'مهم' : 'Featured' ?></span>
                <?php endif; ?>
                <i class="fas fa-car"></i>
            </div>
            <div class="blog-card-content">
                <span class="blog-card-category"><?= $article['category'] ?></span>
                <h2 class="blog-card-title">
                    <a href="blog-post.php?slug=<?= $article['slug'] ?>">
                        <?= $lang === 'ar' ? $article['title_ar'] : $article['title_en'] ?>
                    </a>
                </h2>
                <p class="blog-card-desc">
                    <?= $lang === 'ar' ? $article['desc_ar'] : $article['desc_en'] ?>
                </p>
                <div class="blog-card-meta">
                    <span><i class="fas fa-calendar"></i> <?= date('M Y') ?></span>
                    <span><i class="fas fa-eye"></i> <?= rand(100, 500) ?> <?= $lang === 'ar' ? 'مشاهدة' : 'views' ?></span>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- All Articles -->
    <div class="blog-grid">
        <?php foreach ($blog_articles as $article): ?>
        <article class="blog-card">
            <div class="blog-card-image">
                <i class="fas fa-car"></i>
            </div>
            <div class="blog-card-content">
                <span class="blog-card-category"><?= $article['category'] ?></span>
                <h2 class="blog-card-title">
                    <a href="blog-post.php?slug=<?= $article['slug'] ?>">
                        <?= $lang === 'ar' ? $article['title_ar'] : $article['title_en'] ?>
                    </a>
                </h2>
                <p class="blog-card-desc">
                    <?= $lang === 'ar' ? $article['desc_ar'] : $article['desc_en'] ?>
                </p>
                <div class="blog-card-meta">
                    <span><i class="fas fa-calendar"></i> <?= date('M Y') ?></span>
                    <span><i class="fas fa-eye"></i> <?= rand(50, 300) ?> <?= $lang === 'ar' ? 'مشاهدة' : 'views' ?></span>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>

    <div class="blog-cta">
        <h3><?= $lang === 'ar' ? 'هل تحتاج مساعدة في الحجز؟' : 'Need Help Booking?' ?></h3>
        <p><?= $lang === 'ar' 
            ? 'فريق شركة سوى جاهز لمساعدتك على مدار الساعة' 
            : 'Sawa team is ready to help you 24/7' ?></p>
        <a href="index.php#booking" style="background: white; color: #1a73e8; padding: 14px 35px; border-radius: 30px; text-decoration: none; display: inline-block; font-weight: bold;">
            <?= $lang === 'ar' ? 'احجز الآن' : 'Book Now' ?>
        </a>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
