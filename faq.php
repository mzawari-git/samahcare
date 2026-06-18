<?php

require_once __DIR__ . '/includes/helpers.php';

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

$page_title = ($lang === 'ar' ? 'الأسئلة الشائعة -faq' : 'Frequently Asked Questions - FAQ');
$page_description = $lang === 'ar' 
    ? 'أسئلة شائعة حول تأجير السيارات في رام الله -Prices، الشروط، والتأمين. Sawa توفر أفضل الخدمات.'
    : 'Common questions about car rental in Ramallah - Prices, conditions, and insurance. Sawa provides the best services.';
$canonical = abs_url('faq.php');

include __DIR__ . '/partials/header.php';

$faqs = [
    [
        'question_ar' => 'كم سعر تأجير سيارة في رام الله؟',
        'question_en' => 'How much does it cost to rent a car in Ramallah?',
        'answer_ar' => 'أسعارنا تبدأ من 120 شيكل يومياً للسيارات الاقتصادية. الأسعار تختلف حسب نوع السيارة ومدة الإيجار. للحصول على أفضل الأسعار، احجز مبكراً واستفد من عروضنا الأسبوعية والشهرية.',
        'answer_en' => 'Our prices start from 120 ILS per day for economy cars. Prices vary depending on the type of car and rental duration. For the best prices, book early and take advantage of our weekly and monthly offers.'
    ],
    [
        'question_ar' => 'ما هي شروط تأجير سيارة في فلسطين؟',
        'question_en' => 'What are the requirements to rent a car in Palestine?',
        'answer_ar' => 'المتطلبات الأساسية: رخصة قيادة سارية المفعول (فلسطينية أو دولية)، عمر السائق 21 سنة على الأقل، وهوية شخصية أو جواز سفر. некоторые الشركات قد تتطلب بطاقة ائتمان للتأمين.',
        'answer_en' => 'Basic requirements: Valid driving license (Palestinian or international), driver must be at least 21 years old, and a valid ID or passport. Some companies may require a credit card for insurance.'
    ],
    [
        'question_ar' => 'هل التأمين مشمول في السعر؟',
        'question_en' => 'Is insurance included in the price?',
        'answer_ar' => 'نعم، جميع حجوزاتنا تشمل تأمين شامل against الغير. يمكنك أيضاً ترقية التأمين لتحمل deductible بقيمة صفر لمزيد من الراحة والأمان währendرحلتك.',
        'answer_en' => 'Yes, all our bookings include comprehensive third-party insurance. You can also upgrade to zero deductible insurance for more peace of mind during your trip.'
    ],
    [
        'question_ar' => 'هل توفرون توصيل مجاني للمطار؟',
        'question_en' => 'Do you offer free airport delivery?',
        'answer_ar' => 'نعم، نقدم خدمة التوصيل والاستلام المجاني من مطار رام الله الدولي ومطارQueen Alia (عمان) للعملاء الذين يحجزون لأكثر من يومين. For shorter rentals،我们可以安排接送服务。',
        'answer_en' => 'Yes, we offer free pickup and delivery from Ramallah International Airport and Queen Alia Airport (Amman) for customers booking more than 2 days. For shorter rentals, we can arrange pickup services.'
    ],
    [
        'question_ar' => 'ما هي طرق الدفع المتاحة؟',
        'question_en' => 'What payment methods are available?',
        'answer_ar' => 'نقبل الدفع نقداً عند استلام السيارة، ainsi que les cartes de crédit et débit principales (Visa، Mastercard، American Express). We also accept Jawwal Pay and bank transfers.',
        'answer_en' => 'We accept cash upon car pickup, as well as all major credit and debit cards (Visa, Mastercard, American Express). We also accept Jawwal Pay and bank transfers.'
    ],
    [
        'question_ar' => 'هل يمكن إلغاء الحجز؟',
        'question_en' => 'Can I cancel my booking?',
        'answer_ar' => 'نعم، يمكنك إلغاء الحجز مجاناً قبل 24 ساعة من الموعد المحدد. Cancellation made less than 24 hours before may incur a small fee. بالنسبة للعروض الخاصة، قد تختلف الشروط.',
        'answer_en' => 'Yes, you can cancel your booking free of charge up to 24 hours before the scheduled time. Cancellation made less than 24 hours before may incur a small fee. For special offers, terms may vary.'
    ],
    [
        'question_ar' => 'ماذا أفعل في حالة حادث؟',
        'question_en' => 'What should I do in case of an accident?',
        'answer_ar' => 'في حالة الحادث، اتصل بنا فوراً على الرقم المتوفر في عقد الإيجار. لا تقم بالإقرار بالمسؤولية لأي طرف.拍照并存档事故现场，这将有助于理赔流程。',
        'answer_en' => 'In case of accident, contact us immediately at the number provided in the rental contract. Do not admit liability to any party. Take photos and document the accident scene, which will help the claims process.'
    ],
    [
        'question_ar' => 'هل يمكن إعادة السيارة لموقع مختلف؟',
        'question_en' => 'Can I return the car to a different location?',
        'answer_ar' => 'نعم، يمكنك إعادة السيارة لموقع مختلف عن نقطة الاستلام مقابل رسوم إضافية بسيطة. يرجى إعلامنا مسبقاً بالتنسيق logistics.',
        'answer_en' => 'Yes, you can return the car to a different location from the pickup point for a small additional fee. Please inform us in advance to coordinate logistics.'
    ],
    [
        'question_ar' => 'ما هو minimum age للتأجير؟',
        'question_en' => 'What is the minimum age to rent?',
        'answer_ar' => 'الحد الأدنى للعمر هو 21 سنة. For certain luxury vehicles and SUVs، قد يكون الحد الأدنى 23 أو 25 سنة. هذا يعتمد على سياسة الشركة.',
        'answer_en' => 'The minimum age is 21 years. For certain luxury vehicles and SUVs, the minimum age may be 23 or 25 years. This depends on company policy.'
    ],
    [
        'question_ar' => 'هل توفرون سيارة مع سائق؟',
        'question_en' => 'Do you provide cars with a driver?',
        'answer_ar' => 'نعم، نوفر خدمة تأجير السيارات مع سائق محترف. هذه الخدمة مثالية для туристов или бизнесменов الذين يرغبون في الاسترخاء أثناء التنقل.',
        'answer_en' => 'Yes, we provide car rental services with a professional driver. This service is ideal for tourists or businessmen who want to relax while traveling.'
    ],
    [
        'question_ar' => 'كم تستغرق عملية الحجز؟',
        'question_en' => 'How long does the booking process take?',
        'answer_ar' => 'عملية الحجز online تستغرق حوالي 3-5 دقائق فقط. ما عليك سوى اختيار السيارة، تحديد التواريخ، وإتمام الدفع. ستصلك رسالة تأكيد فورية.',
        'answer_en' => 'The online booking process takes only about 3-5 minutes. Simply choose your car, specify dates, and complete payment. You will receive an instant confirmation message.'
    ],
    [
        'question_ar' => 'ما هي أنواع السيارات المتاحة؟',
        'question_en' => 'What types of cars are available?',
        'answer_ar' => 'نوفر широкий ассортимент автомобилей: اقتصادية (Kia Cerato، Hyundai Accent)، عائلية (Toyota Camry، Hyundai Sonata)، SUVs (Toyota Land Cruiser، Jeep Grand Cherokee)، وفاخرة (Mercedes، BMW).',
        'answer_en' => 'We offer a wide range of cars: economy (Kia Cerato, Hyundai Accent), family (Toyota Camry, Hyundai Sonata), SUVs (Toyota Land Cruiser, Jeep Grand Cherokee), and luxury (Mercedes, BMW).'
    ],
    [
        'question_ar' => 'هل أسعاركم تنافسية؟',
        'question_en' => 'Are your prices competitive?',
        'answer_ar' => 'نعم، نحن نقدم أفضل الأسعار في السوق الفلسطيني. Our prices are transparent with no hidden fees. قارننا بنفسك - ستجد أن أسعارنا أقل من many competitors!',
        'answer_en' => 'Yes, we offer the best prices in the Palestinian market. Our prices are transparent with no hidden fees. Compare yourself - you will find our prices are lower than many competitors!'
    ],
    [
        'question_ar' => 'ماذا تشمل الأسعار؟',
        'question_en' => 'What do the prices include?',
        'answer_ar' => 'الأسعار تشمل: تأمين شامل، ضرائب، توصيل واستلام مجاني within Ramallah، support 24/7، ومساعدة الطريق. الوقود not included (ممتلئ إلى ممتلئ).',
        'answer_en' => 'Prices include: comprehensive insurance, taxes, free delivery and pickup within Ramallah, 24/7 support, and roadside assistance. Fuel is not included (Full-to-Full policy).'
    ],
    [
        'question_ar' => 'كيف أتواصل معكم للدعم؟',
        'question_en' => 'How can I contact you for support?',
        'answer_ar' => 'يمكنك التواصل معنا عبر: واتساب 0597492182، телефон 0599930120، أو البريد الإلكتروني info@sawarentcar.ps. We are available 24/7 для вашей помощи.',
        'answer_en' => 'You can contact us via: WhatsApp 0597492182, Phone 0599930120, or Email info@sawarentcar.ps. We are available 24/7 for your assistance.'
    ]
];
?>

<style>
.faq-page { padding: 60px 20px; max-width: 900px; margin: 0 auto; }
.faq-hero { text-align: center; margin-bottom: 50px; padding: 40px 20px; background: linear-gradient(135deg, #1a73e8, #34a853); border-radius: 20px; color: white; }
.faq-hero h1 { font-size: 2.5rem; margin-bottom: 10px; }
.faq-hero p { opacity: 0.9; font-size: 1.1rem; }
.faq-search { margin-bottom: 40px; }
.faq-search input { width: 100%; padding: 18px 25px; border: 2px solid #e3f2fd; border-radius: 15px; font-size: 1rem; transition: all 0.3s; }
.faq-search input:focus { outline: none; border-color: #1a73e8; box-shadow: 0 0 0 4px rgba(26,115,232,0.1); }
.faq-item { background: #fff; border-radius: 15px; margin-bottom: 15px; box-shadow: 0 2px 15px rgba(0,0,0,0.08); overflow: hidden; }
.faq-question { padding: 20px 25px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 600; color: #333; transition: background 0.3s; }
.faq-question:hover { background: #f8f9fa; }
.faq-question i { transition: transform 0.3s; color: #1a73e8; }
.faq-item.active .faq-question i { transform: rotate(180deg); }
.faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease; }
.faq-item.active .faq-answer { max-height: 500px; }
.faq-answer-content { padding: 0 25px 25px; color: #555; line-height: 1.8; border-top: 1px solid #f0f0f0; padding-top: 20px; }
.faq-category { margin-bottom: 40px; }
.faq-category-title { color: #1a73e8; font-size: 1.5rem; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e3f2fd; }
.faq-cta { text-align: center; margin-top: 50px; padding: 40px; background: #f8f9fa; border-radius: 20px; }
.faq-cta h3 { color: #1a73e8; margin-bottom: 15px; }
.faq-cta p { margin-bottom: 20px; color: #666; }
.faq-cta a { display: inline-block; padding: 14px 35px; background: #1a73e8; color: white; text-decoration: none; border-radius: 25px; font-weight: 600; }
.faq-cta a:hover { background: #1557b0; }
</style>

<script>
function toggleFaq(element) {
    const item = element.parentElement;
    const isActive = item.classList.contains('active');
    
    // Close all
    document.querySelectorAll('.faq-item').forEach(faq => faq.classList.remove('active'));
    
    // Open clicked
    if (!isActive) {
        item.classList.add('active');
    }
}
</script>

<div class="faq-page">
    <div class="faq-hero">
        <h1><?= $lang === 'ar' ? 'الأسئلة الشائعة' : 'Frequently Asked Questions' ?></h1>
        <p><?= $lang === 'ar' ? 'كل ما تحتاج معرفته عن تأجير السيارات' : 'Everything you need to know about car rental' ?></p>
    </div>

    <div class="faq-search">
        <input type="text" placeholder="<?= $lang === 'ar' ? 'ابحث عن سؤال...' : 'Search for a question...' ?>" id="faqSearch" onkeyup="filterFaqs()">
    </div>

    <div class="faq-list" id="faqList">
        <?php foreach ($faqs as $index => $faq): ?>
        <div class="faq-item" data-question="<?= strtolower(strip_tags($faq['question_' . ($lang === 'ar' ? 'ar' : 'en')])) ?>">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span><?= $lang === 'ar' ? $faq['question_ar'] : $faq['question_en'] ?></span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <div class="faq-answer-content">
                    <?= $lang === 'ar' ? $faq['answer_ar'] : $faq['answer_en'] ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="faq-cta">
        <h3><?= $lang === 'ar' ? 'لم تجد إجابة لسؤالك؟' : "Didn't find an answer to your question?" ?></h3>
        <p><?= $lang === 'ar' ? 'فريقنا جاهز لمساعدتك على مدار الساعة' : 'Our team is ready to help you 24/7' ?></p>
        <a href="index.php#contact"><?= $lang === 'ar' ? 'تواصل معنا' : 'Contact Us' ?></a>
    </div>
</div>

<script>
function filterFaqs() {
    const search = document.getElementById('faqSearch').value.toLowerCase();
    const faqs = document.querySelectorAll('.faq-item');
    
    faqs.forEach(faq => {
        const question = faq.getAttribute('data-question');
        if (question.includes(search)) {
            faq.style.display = 'block';
        } else {
            faq.style.display = 'none';
        }
    });
}
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
