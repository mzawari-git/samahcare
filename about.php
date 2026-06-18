<?php

require_once __DIR__ . '/includes/helpers.php';

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

$page_title = $lang === 'ar' ? 'من نحن - شركة سوى لتأجير السيارات' : 'About Us - Sawa Rent Car';
$page_description = $lang === 'ar' 
    ? 'تعرف على شركة سوى لتأجير السيارات في رام الله والبيرة. نوفر أفضل الخدمات بأسعار تنافسية.'
    : 'Learn about Sawa Rent Car in Ramallah and Al-Bireh. We provide the best services at competitive prices.';
$canonical = abs_url('about.php');

include __DIR__ . '/partials/header.php';
?>

<style>
.about-hero {
    background: linear-gradient(135deg, #0a0f1e 0%, #1a237e 50%, #0d1b2a 100%);
    padding: 80px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.about-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="2"/></svg>') center/200px repeat;
    animation: rotate 60s linear infinite;
}
@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.about-hero h1 {
    font-size: 3rem;
    font-weight: 800;
    color: white;
    margin-bottom: 20px;
    position: relative;
}
.about-hero p {
    font-size: 1.3rem;
    color: rgba(255,255,255,0.85);
    max-width: 600px;
    margin: 0 auto;
    position: relative;
}
.about-section {
    padding: 60px 0;
}
.about-section:nth-child(even) {
    background: #f8f9fa;
}
.about-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-top: 40px;
}
.about-card {
    background: white;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.about-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.12);
}
.about-card-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #1a73e8, #34a853);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
    color: white;
}
.about-card h3 {
    color: #1a73e8;
    font-size: 1.4rem;
    margin-bottom: 15px;
}
.about-card p {
    color: #666;
    line-height: 1.7;
}
.stats-section {
    background: linear-gradient(135deg, #1a73e8, #34a853);
    padding: 60px 0;
    color: white;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    text-align: center;
}
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
.stat-item h2 {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 5px;
}
.stat-item p {
    font-size: 1.1rem;
    opacity: 0.9;
}
.team-section {
    padding: 80px 0;
}
.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 40px;
}
.team-member {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    text-align: center;
}
.team-member-img {
    width: 100%;
    height: 200px;
    background: linear-gradient(135deg, #1a73e8, #34a853);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    color: white;
}
.team-member-info {
    padding: 25px;
}
.team-member-info h4 {
    color: #1a73e8;
    font-size: 1.3rem;
    margin-bottom: 5px;
}
.team-member-info p {
    color: #666;
    font-size: 0.95rem;
}
.cta-section {
    background: linear-gradient(135deg, #0a0f1e, #1a237e);
    padding: 80px 0;
    text-align: center;
    color: white;
}
.cta-section h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
}
.cta-section p {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 30px;
}
.btn-cta {
    display: inline-block;
    background: linear-gradient(135deg, #1a73e8, #34a853);
    color: white;
    padding: 18px 40px;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 700;
    text-decoration: none;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.btn-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(26, 115, 232, 0.4);
}
</style>

<!-- Hero Section -->
<div class="about-hero">
    <div class="container">
        <h1><?= $lang === 'ar' ? 'من نحن' : 'About Us' ?></h1>
        <p><?= $lang === 'ar' 
            ? 'شركة سوى لتأجير السيارات -为您提供最优质的租车服务在巴勒斯坦' 
            : 'Sawa Rent Car - Your trusted car rental service in Palestine' ?></p>
    </div>
</div>

<!-- Stats Section -->
<div class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <h2>500+</h2>
                <p><?= $lang === 'ar' ? 'عميل سعيد' : 'Happy Clients' ?></p>
            </div>
            <div class="stat-item">
                <h2>5+</h2>
                <p><?= $lang === 'ar' ? 'سنوات خبرة' : 'Years Experience' ?></p>
            </div>
            <div class="stat-item">
                <h2>50+</h2>
                <p><?= $lang === 'ar' ? 'سيارة متاحة' : 'Cars Available' ?></p>
            </div>
            <div class="stat-item">
                <h2>24/7</h2>
                <p><?= $lang === 'ar' ? 'دعم متواصل' : 'Support Available' ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Why Choose Us -->
<section class="about-section">
    <div class="container">
        <h2 style="text-align:center;font-size:2.2rem;color:#1a73e8;margin-bottom:10px;">
            <?= $lang === 'ar' ? 'لماذا تختار سوى؟' : 'Why Choose Sawa?' ?>
        </h2>
        <p style="text-align:center;color:#666;margin-bottom:40px;max-width:600px;margin-left:auto;margin-right:auto;">
            <?= $lang === 'ar' 
                ? 'نحن نقدم أفضل خدمات تأجير السيارات بأسعار تنافسية وضمان جودة خدمة غير مسبوقة'
                : 'We provide the best car rental services at competitive prices with unmatched service quality' ?>
        </p>
        <div class="about-grid">
            <div class="about-card">
                <div class="about-card-icon"><i class="fas fa-car"></i></div>
                <h3><?= $lang === 'ar' ? 'أسطول حديث' : 'Modern Fleet' ?></h3>
                <p><?= $lang === 'ar' 
                    ? 'سيارات جديدة ومُحدّثة بانتظام لراحتك وأمانك على الطرق'
                    : 'New and regularly updated cars for your comfort and safety on the road' ?></p>
            </div>
            <div class="about-card">
                <div class="about-card-icon"><i class="fas fa-tags"></i></div>
                <h3><?= $lang === 'ar' ? 'أسعار منافسة' : 'Competitive Prices' ?></h3>
                <p><?= $lang === 'ar' 
                    ? 'أفضل الأسعار في السوق مع عروض وخصومات حصرية للعملاء الدائمين'
                    : 'Best prices in the market with exclusive offers for loyal customers' ?></p>
            </div>
            <div class="about-card">
                <div class="about-card-icon"><i class="fas fa-shield-alt"></i></div>
                <h3><?= $lang === 'ar' ? 'تأمين شامل' : 'Full Insurance' ?></h3>
                <p><?= $lang === 'ar' 
                    ? 'جميع سياراتنا مؤمّنة بتأمين شامل لراحة بالك أثناء القيادة'
                    : 'All our cars are fully insured for your peace of mind while driving' ?></p>
            </div>
            <div class="about-card">
                <div class="about-card-icon"><i class="fas fa-clock"></i></div>
                <h3><?= $lang === 'ar' ? 'استلام سريع' : 'Quick Pickup' ?></h3>
                <p><?= $lang === 'ar' 
                    ? 'استلم سيارتك خلال دقائق من الحجز بدون أي تأخير'
                    : 'Pick up your car within minutes of booking without any delay' ?></p>
            </div>
            <div class="about-card">
                <div class="about-card-icon"><i class="fas fa-truck"></i></div>
                <h3><?= $lang === 'ar' ? 'توصيل مجاني' : 'Free Delivery' ?></h3>
                <p><?= $lang === 'ar' 
                    ? 'نوصل السيارة لموقعك دون أي تكلفة إضافية'
                    : 'We deliver the car to your location at no additional cost' ?></p>
            </div>
            <div class="about-card">
                <div class="about-card-icon"><i class="fas fa-headset"></i></div>
                <h3><?= $lang === 'ar' ? 'دعم متواصل' : '24/7 Support' ?></h3>
                <p><?= $lang === 'ar' 
                    ? 'فريق دعم متاح على مدار الساعة للإجابة على استفساراتك'
                    : 'Support team available around the clock to answer your questions' ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="about-section">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:40px;">
            <div style="background:white;padding:40px;border-radius:20px;box-shadow:0 10px 40px rgba(0,0,0,0.08);">
                <div style="width:60px;height:60px;background:linear-gradient(135deg,#1a73e8,#34a853);border-radius:15px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;font-size:1.5rem;color:white;">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 style="color:#1a73e8;font-size:1.5rem;margin-bottom:15px;"><?= $lang === 'ar' ? 'رؤيتنا' : 'Our Vision' ?></h3>
                <p style="color:#666;line-height:1.8;"><?= $lang === 'ar' 
                    ? 'أن نكون الشركة الرائدة في مجال تأجير السيارات في فلسطين، وتقديم خدمات متميزة تسهم في راحة وتنقل عملائنا بأمان وسهولة.'
                    : 'To be the leading car rental company in Palestine, providing exceptional services that contribute to our customers\' comfort, safety, and ease of transportation.' ?></p>
            </div>
            <div style="background:white;padding:40px;border-radius:20px;box-shadow:0 10px 40px rgba(0,0,0,0.08);">
                <div style="width:60px;height:60px;background:linear-gradient(135deg,#34a853,#1a73e8);border-radius:15px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;font-size:1.5rem;color:white;">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3 style="color:#1a73e8;font-size:1.5rem;margin-bottom:15px;"><?= $lang === 'ar' ? 'رسالتنا' : 'Our Mission' ?></h3>
                <p style="color:#666;line-height:1.8;"><?= $lang === 'ar' 
                    ? 'نلتزم بتقديم أفضل خدمات تأجير السيارات بأسعار تنافسية، مع التركيز على رضا العملاء والسلامة والجودة في كل خدمة نقدمها.'
                    : 'We are committed to providing the best car rental services at competitive prices, focusing on customer satisfaction, safety, and quality in every service we provide.' ?></p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<div class="cta-section">
    <div class="container">
        <h2><?= $lang === 'ar' ? 'جاهز للاستئجار؟' : 'Ready to Rent?' ?></h2>
        <p><?= $lang === 'ar' 
            ? 'احجز سيارتك الآن واستمتع بأفضل خدمة تأجير في رام الله والبيرة'
            : 'Book your car now and enjoy the best rental service in Ramallah and Al-Bireh' ?></p>
        <a href="<?= abs_url('index.php#booking') ?>" class="btn-cta">
            <i class="fas fa-calendar-check"></i> <?= $lang === 'ar' ? 'احجز الآن' : 'Book Now' ?>
        </a>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
