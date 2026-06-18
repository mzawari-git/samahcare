<?php

require_once __DIR__ . '/includes/helpers.php';

$lang = current_lang();
$dir = is_rtl() ? 'rtl' : 'ltr';

$slug = $_GET['slug'] ?? '';

$articles = [
    'guide-online-rental' => [
        'title_ar' => 'دليلك الشامل لاستئجار سيارة عبر الإنترنت: 5 نصائح ذهبية قبل الحجز',
        'title_en' => 'Your Complete Guide to Renting a Car Online: 5 Golden Tips Before Booking',
        'desc_ar' => 'تعلم كيفية استئجار سيارة عبر الإنترنت بأمان مع 5 نصائح ذهبية من شركة سوى - تجنب المفاجآت والرسوم الخفية',
        'desc_en' => 'Learn how to rent a car online safely with 5 golden tips from Sawa - Avoid surprises and hidden fees',
        'image' => 'uploads/blog-online-rental.jpg',
        'keywords_ar' => 'استئجار سيارة, تأجير سيارات, حجز سيارة اون لاين, نصائح تأجير سيارة, شركة سوى',
        'keywords_en' => 'car rental, rent car, online car booking, car rental tips, Sawa rent car',
        'content_ar' => '
            <h2>مقدمة</h2>
            <p>أصبح استئجار سيارة عبر الإنترنت الخطوة الأولى والأهم لتنظيم رحلاتك، سواء كانت بهدف السياحة أو إنجاز الأعمال. بفضل التكنولوجيا، بات بإمكانك اختيار سيارتك المفضلة وإتمام حجزك بضغطة زر. ولكن، لضمان تجربة سلسة وخالية من المفاجآت غير السارة، هناك قواعد ذهبية يجب اتباعها.</p>
            <p>في هذا الدليل، سنقدم لك 5 نصائح أساسية يجب مراعاتها قبل تأكيد حجزك، مع تسليط الضوء على كيف تجعل شركة سوى لتأجير السيارات (SAWARENTCAR.ONLINE) هذه التجربة أسهل وأكثر أماناً.</p>
            
            <h2>1. الحجز المبكر يضمن لك أفضل الصفقات</h2>
            <p>الانتظار حتى اللحظة الأخيرة لاستئجار سيارة غالباً ما يؤدي إلى خيارات محدودة وأسعار مرتفعة. الحجز المبكر، خاصة في مواسم الذروة والأعياد، يمنحك فرصة الاختيار من بين أسطول أوسع وبأسعار تنافسية.</p>
            <p><strong>نصيحة:</strong> بمجرد تحديد مواعيد رحلتك، بادر بحجز سيارتك. من خلال موقع SAWARENTCAR.ONLINE، يمكنك استعراض الأسطول المتاح واختيار السيارة التي تناسب ميزانيتك واحتياجاتك بوقت كافٍ.</p>
            
            <h2>2. اقرأ الشروط والأحكام والرسوم المخفية بعناية</h2>
            <p>أحد أكبر الأخطاء التي يقع فيها المستأجرون هو تجاهل الشروط والأحكام. تأكد من معرفة:</p>
            <ul>
                <li><strong>حدود المسافة (الكيلومترات):</strong> هل الاستئجار بعداد مفتوح أم محدد بمسافة يومية؟</li>
                <li><strong>رسوم السائق الإضافي:</strong> بعض الشركات تفرض رسوماً إضافية إذا كان عمر السائق أقل من 25 عاماً.</li>
                <li><strong>رسوم التأخير:</strong> كم تكلف الساعة أو اليوم الإضافي؟</li>
            </ul>
            <p><strong>الشفافية هي الأساس:</strong> تتميز شركة سوى لتأجير السيارات بشفافية تامة في عرض أسعارها وشروطها، مما يضمن لك عدم وجود أي رسوم خفية عند الاستلام.</p>
            
            <h2>3. افهم سياسة التأمين الخاصة بالسيارة</h2>
            <p>التأمين هو صمام الأمان الخاص بك أثناء القيادة. تأكد من نوع التأمين المشمول في السعر الأساسي (مثل التأمين ضد الغير أو التأمين الشامل).</p>
            <p><strong>نصيحة:</strong> اسأل عن قيمة "نسبة التحمل" (Deductible)، وهي المبلغ الذي ستدفعه في حال وقوع حادث لا قدر الله. توفر شركة سوى خيارات تأمينية مرنة وواضحة لحمايتك وعائلتك أثناء الرحلة.</p>
            
            <h2>4. انتبه لسياسة الوقود</h2>
            <p>تختلف سياسات الوقود من شركة لأخرى، وأشهرها وأكثرها عدلاً هي سياسة "ممتلئ إلى ممتلئ" (Full-to-Full)، حيث تستلم السيارة بخزان ممتلئ وتلتزم بإعادتها بنفس مستوى الوقود.</p>
            <p><strong>تحذير:</strong> تجنب سياسة الدفع المسبق للوقود إلا إذا كنت متأكداً من أنك ستستهلك الخزان بالكامل، لكي لا تدفع ثمن وقود لم تستخدمه.</p>
            
            <h2>5. افحص السيارة ووثّق حالتها عند الاستلام</h2>
            <p>قبل الانطلاق بالسيارة من موقع التسليم، قم بإجراء فحص شامل لها من الداخل والخارج:</p>
            <ul>
                <li>التقط صوراً أو مقاطع فيديو لأي خدوش أو صدمات موجودة مسبقاً.</li>
                <li>تأكد من إثبات هذه الملاحظات في عقد الإيجار قبل التوقيع.</li>
            </ul>
            <p><strong>مع شركة سوى:</strong> ستجد أن فريق العمل يحرص على إجراء هذا الفحص معك بشفافية واحترافية عالية، لضمان حقوقك كاملة.</p>
            
            <h2>لماذا تختار شركة سوى لتأجير السيارات؟</h2>
            <p>الاستئجار عبر الإنترنت يحتاج إلى شريك موثوق، وهنا تبرز شركة سوى كواحدة من أفضل الخيارات المتاحة:</p>
            <ul>
                <li><strong>منصة إلكترونية سهلة الاستخدام:</strong> موقع SAWARENTCAR.ONLINE مصمم ليوفر لك تجربة حجز سلسة وسريعة في دقائق معدودة.</li>
                <li><strong>أسطول حديث ومتنوع:</strong> سواء كنت تبحث عن سيارة اقتصادية للمدينة، أو سيارة دفع رباعي عائلية، أو سيارة فخمة لرجال الأعمال.</li>
                <li><strong>دعم فني متميز:</strong> فريق متواجد للرد على استفساراتك ومساعدتك قبل، أثناء، وبعد فترة الاستئجار.</li>
                <li><strong>أسعار تنافسية وشفافة:</strong> ما تراه في الموقع هو ما تدفعه.</li>
            </ul>
            
            <h2>الخلاصة</h2>
            <p>استئجار سيارة عبر الإنترنت لا يجب أن يكون عملية معقدة أو مقلقة. من خلال اتباع هذه النصائح الذهبية الخمس، واختيار شركة موثوقة مثل شركة سوى لتأجير السيارات، يمكنك الانطلاق في رحلتك براحة بال تامة.</p>
        ',
        'content_en' => '
            <h2>Introduction</h2>
            <p>Renting a car online has become the first and most important step in organizing your trips, whether for tourism or business. Thanks to technology, you can now choose your favorite car and complete your booking with the click of a button. However, to ensure a smooth experience free from unpleasant surprises, there are golden rules to follow.</p>
            <p>In this guide, we will provide you with 5 essential tips to consider before confirming your booking, while highlighting how Sawa Rent Car (SAWARENTCAR.ONLINE) makes this experience easier and safer.</p>
            
            <h2>1. Early Booking Guarantees the Best Deals</h2>
            <p>Waiting until the last minute to rent a car often leads to limited options and higher prices. Early booking, especially during peak seasons and holidays, gives you the chance to choose from a wider fleet at competitive prices.</p>
            <p><strong>Tip:</strong> As soon as you determine your travel dates, book your car. Through SAWARENTCAR.ONLINE, you can browse available fleet and choose the car that fits your budget and needs with enough time.</p>
            
            <h2>2. Read Terms, Conditions, and Hidden Fees Carefully</h2>
            <p>One of the biggest mistakes renters make is ignoring the terms and conditions. Make sure you know:</p>
            <ul>
                <li><strong>Distance limits:</strong> Is it unlimited mileage or limited to a daily distance?</li>
                <li><strong>Additional driver fees:</strong> Some companies charge extra if the driver is under 25.</li>
                <li><strong>Late fees:</strong> How much does an extra hour or day cost?</li>
            </ul>
            <p><strong>Transparency is key:</strong> Sawa Rent Car offers complete transparency in displaying prices and conditions, ensuring no hidden fees upon pickup.</p>
            
            <h2>3. Understand the Car Insurance Policy</h2>
            <p>Insurance is your safety net while driving. Make sure you know the type of insurance included in the base price (such as third-party or comprehensive insurance).</p>
            <p><strong>Tip:</strong> Ask about the "deductible" value, which is the amount you will pay in case of an accident. Sawa offers flexible and clear insurance options to protect you and your family during the trip.</p>
            
            <h2>4. Pay Attention to Fuel Policy</h2>
            <p>Fuel policies vary between companies, and the most fair is the "Full-to-Full" policy, where you receive the car with a full tank and return it with the same fuel level.</p>
            <p><strong>Warning:</strong> Avoid prepaid fuel policy unless you are sure you will use the entire tank, so you do not pay for fuel you did not use.</p>
            
            <h2>5. Inspect and Document the Car Condition Upon Pickup</h2>
            <p>Before driving away from the pickup location, conduct a thorough inspection of the car inside and out:</p>
            <ul>
                <li>Take photos or videos of any existing scratches or dents.</li>
                <li>Make sure these notes are documented in the rental contract before signing.</li>
            </ul>
            <p><strong>With Sawa:</strong> You will find that the team conducts this inspection with you professionally and transparently to ensure your complete rights.</p>
            
            <h2>Why Choose Sawa Rent Car?</h2>
            <p>Renting a online requires a reliable partner, and Sawa stands out as one of the best options available:</p>
            <ul>
                <li><strong>Easy-to-use electronic platform:</strong> SAWARENTCAR.ONLINE is designed to provide a smooth booking experience in minutes.</li>
                <li><strong>Modern and diverse fleet:</strong> Whether you are looking for an economy car, family SUV, or luxury vehicle for business.</li>
                <li><strong>Excellent technical support:</strong> Team available to answer your questions and help before, during, and after the rental.</li>
                <li><strong>Competitive and transparent prices:</strong> What you see on the site is what you pay.</li>
            </ul>
            
            <h2>Conclusion</h2>
            <p>Renting a car online should not be a complicated or worrying process. By following these five golden tips and choosing a reliable company like Sawa Rent Car, you can start your journey with complete peace of mind.</p>
        '
    ],
    'choose-right-car' => [
        'title_ar' => 'كيف تختار السيارة المناسبة لرحلتك القادمة؟ (عائلية، اقتصادية، أم فارهة؟)',
        'title_en' => 'How to Choose the Right Car for Your Trip? (Family, Economy, or Luxury?)',
        'desc_ar' => 'دليل شامل لمقارنة فئات السيارات واختيار الأنسب لرحلتك - اقتصادية، عائلية، أو فارهة',
        'desc_en' => 'Complete guide to comparing car categories and choosing the best for your trip - economy, family, or luxury',
        'image' => 'uploads/blog-choose-car.jpg',
        'keywords_ar' => 'اختيار سيارة, تأجير سيارة عائلية, سيارة اقتصادية, سيارة فارهة, SUV, نصائح租车',
        'keywords_en' => 'choose right car, family car rental, economy car, luxury car, SUV rental, car rental tips',
        'content_ar' => '
            <h2>مقدمة</h2>
            <p>تخطيط الرحلة لا يقتصر فقط على حجز تذاكر الطيران أو الفندق؛ فوسيلة التنقل التي سترافقك طوال رحلتك تلعب دوراً حاسماً في تحديد مدى راحتك واستمتاعك. سواء كنت تخطط لرحلة عمل سريعة، أو عطلة عائلية طويلة، أو حتى رحلة استجمام فاخرة، فإن اختيار فئة السيارة المناسبة هو الخطوة الأهم لضمان تجربة خالية من المتاعب.</p>
            <p>إليك هذا الدليل التفصيلي الذي سيساعدك على المقارنة بين الفئات الثلاث الرئيسية (الاقتصادية، العائلية، والفارهة) لتختار ما يناسب احتياجاتك بدقة.</p>
            
            <h2>1. السيارة الاقتصادية: الخيار الذكي والعملي</h2>
            <p>إذا كانت رحلتك ترتكز على التنقلات السريعة والميزانية المدروسة، فإن السيارات الاقتصادية هي خيارك الأول.</p>
            <p><strong>لمن تناسب؟</strong> المسافرون بمفردهم، الأزواج، والشباب الذين يبحثون عن استكشاف المدن بمرونة.</p>
            <h3>أبرز المميزات:</h3>
            <ul>
                <li><strong>توفير الوقود:</strong> صُممت هذه السيارات لتقطع مسافات أطول باستهلاك أقل للوقود.</li>
                <li><strong>سهولة القيادة والركن:</strong> بفضل حجمها المدمج، ستجد أن التنقل في الشوارع المزدحمة أمر في غاية السهولة.</li>
                <li><strong>تكلفة إيجار منخفضة:</strong> أسعار استئجارها هي الأقل مقارنة بالفئات الأخرى.</li>
            </ul>
            <p><strong>متى تتجنبها؟</strong> إذا كان لديك الكثير من الحقائب الكبيرة، أو إذا كنت تخطط للقيادة لمسافات طويلة عبر تضاريس جبلية.</p>
            
            <h2>2. السيارة العائلية وسيارات الدفع الرباعي: المساحة والأمان</h2>
            <p>عندما يكون السفر جماعياً، تتغير الأولويات لتصبح المساحة والراحة والأمان هي المعايير الأساسية.</p>
            <p><strong>لمن تناسب؟</strong> العائلات، المجموعات المكونة من 4 أشخاص أو أكثر، وعشاق الرحلات البرية والطبيعة.</p>
            <h3>أبرز المميزات:</h3>
            <ul>
                <li><strong>مساحة رحبة:</strong> توفر راحة كبيرة للركاب في المقاعد الخلفية، بالإضافة إلى مساحة تخزين واسعة.</li>
                <li><strong>مستويات أمان عالية:</strong> تأتي مزودة بأنظمة أمان متطورة وهيكل قوي.</li>
                <li><strong>أداء قوي:</strong> سيارات الدفع الرباعي (SUV) تمنحك الثبات والقوة على الطرق الجبلية.</li>
            </ul>
            <p><strong>متى تتجنبها؟</strong> إذا كانت ميزانيتك محدودة جداً، أو إذا كانت وجهتك أزقة مدينة تاريخية ضيقة.</p>
            
            <h2>3. السيارة الفارهة: الرفاهية والانطباع القوي</h2>
            <p>بعض الرحلات تتطلب لمسة من الفخامة والتميز. السيارات الفارهة لا تقدم لك مجرد وسيلة نقل، بل تقدم تجربة قيادة استثنائية.</p>
            <p><strong>لمن تناسب؟</strong> رجال الأعمال، العرسان في شهر العسل، ومن يبحثون عن تدليل أنفسهم.</p>
            <h3>أبرز المميزات:</h3>
            <ul>
                <li><strong>راحة مطلقة:</strong> مقاعد جلدية فاخرة، عزل صوتي ممتاز، وأنظمة تكييف متطورة.</li>
                <li><strong>تكنولوجيا متقدمة:</strong> شاشات تفاعلية، أنظمة صوتية محيطية، ومساعدات ذكية.</li>
                <li><strong>الانطباع الاحترافي:</strong> وصولك لاجتماع عمل بسيارة فاخرة يعكس صورة احترافية.</li>
            </ul>
            <p><strong>متى تتجنبها؟</strong> إذا كنت تخطط لرحلة في الطبيعة القاسية أو بميزانية اقتصادية.</p>
            
            <h2>معايير ذهبية لحسم قرارك قبل الحجز</h2>
            <ul>
                <li><strong>احسب عدد الركاب وحجم الأمتعة:</strong> لا تعتمد فقط على عدد المقاعد.</li>
                <li><strong>طبيعة الوجهة:</strong> شوارع المدن تحتاج لسيارة اقتصادية، الطرق الجبلية تتطلب SUV.</li>
                <li><strong>الميزانية الإجمالية:</strong> خذ بعين الاعتبار استهلاك الوقود وتكاليف التأمين.</li>
            </ul>
            
            <h2>الخلاصة</h2>
            <p>اختيار السيارة المناسبة هو المفتاح لرحلة سلسة وممتعة. شركة سوى لتأجير السيارات (SAWARENTCAR.ONLINE) تتيح لك تصفح جميع هذه الفئات بوضوح، مما يسهل عليك المقارنة واختيار السيارة التي تلبي طموحات رحلتك بدقة.</p>
        ',
        'content_en' => '
            <h2>Introduction</h2>
            <p>Trip planning is not limited to booking flights or hotels; the transportation that will accompany you throughout your trip plays a crucial role in determining your comfort and enjoyment. Whether you are planning a quick business trip, a long family vacation, or even a luxurious retreat, choosing the right car category is the most important step to ensure a hassle-free experience.</p>
            <p>Here is this detailed guide that will help you compare between the three main categories (economy, family, and luxury) to choose what precisely suits your needs.</p>
            
            <h2>1. Economy Cars: Smart and Practical Choice</h2>
            <p>If your trip focuses on quick transportation and a tight budget, economy cars are your first choice.</p>
            <p><strong>Who is it for?</strong> Solo travelers, couples, and youth looking to explore cities flexibly.</p>
            <h3>Key Features:</h3>
            <ul>
                <li><strong>Fuel efficiency:</strong> Designed to cover longer distances with less fuel consumption.</li>
                <li><strong>Easy driving and parking:</strong> Thanks to their compact size, navigating crowded streets is easy.</li>
                <li><strong>Low rental cost:</strong> Rental prices are the lowest compared to other categories.</li>
            </ul>
            <p><strong>When to avoid?</strong> If you have a lot of large suitcases, or if you plan to drive long distances on mountainous terrain.</p>
            
            <h2>2. Family Cars and SUVs: Space and Safety</h2>
            <p>When traveling in groups, priorities shift to space, comfort, and safety as the main criteria.</p>
            <p><strong>Who is it for?</strong> families, groups of 4 or more, and nature trip enthusiasts.</p>
            <h3>Key Features:</h3>
            <ul>
                <li><strong>Spacious:</strong> Great comfort for backseat passengers, plus ample storage space.</li>
                <li><strong>High safety levels:</strong> Equipped with advanced safety systems and strong chassis.</li>
                <li><strong>Powerful performance:</strong> SUVs provide stability and power on mountain roads.</li>
            </ul>
            <p><strong>When to avoid?</strong> If your budget is very limited, or if your destination is narrow historical city alleys.</p>
            
            <h2>3. Luxury Cars: Luxury and Strong Impression</h2>
            <p>Some trips require a touch of luxury and distinction. Luxury cars provide not just transportation, but an exceptional driving experience.</p>
            <p><strong>Who is it for?</strong> Businessmen, honeymooners, and those looking to pamper themselves.</p>
            <h3>Key Features:</h3>
            <ul>
                <li><strong>Absolute comfort:</strong> Luxurious leather seats, excellent sound insulation, and advanced AC.</li>
                <li><strong>Advanced technology:</strong> Interactive screens, surround sound systems, and smart driving aids.</li>
                <li><strong>Professional impression:</strong> Arriving at a business meeting in a luxury car reflects a professional image.</li>
            </ul>
            <p><strong>When to avoid?</strong> If you are planning a trip in harsh nature or with a tight budget.</p>
            
            <h2>Golden Criteria for Deciding Before Booking</h2>
            <ul>
                <li><strong>Calculate passenger count and luggage size:</strong> Do not rely only on the number of seats.</li>
                <li><strong>Nature of destination:</strong> City streets need small economy cars, mountain roads require SUVs.</li>
                <li><strong>Total budget:</strong> Consider fuel consumption and insurance costs.</li>
            </ul>
            
            <h2>Conclusion</h2>
            <p>Choosing the right car is the key to a smooth and enjoyable trip. Sawa Rent Car (SAWARENTCAR.ONLINE) allows you to browse all categories clearly, making it easy to compare and choose the car that meets your trip aspirations precisely.</p>
        '
    ],
    'common-mistakes' => [
        'title_ar' => '7 أخطاء شائعة تجنبها عند استئجار سيارة',
        'title_en' => '7 Common Mistakes to Avoid When Renting a Car',
        'desc_ar' => 'تعرف على الأخطاء الشائعة عند استئجار السيارات وكيفية تجنبها مع شركة سوى - دليل شامل',
        'desc_en' => 'Learn common mistakes when renting cars and how to avoid them with Sawa - Complete guide',
        'image' => 'uploads/blog-mistakes.jpg',
        'keywords_ar' => 'أخطاء استئجار سيارة, نصائح تأجير, تجنب الأخطاء, شركة سوى, رسوم خفية',
        'keywords_en' => 'car rental mistakes, rental tips, avoid mistakes, Sawa rent car, hidden fees',
        'content_ar' => '
            <h2>مقدمة</h2>
            <p>استئجار سيارة يجب أن يكون خطوة تمنحك الحرية والراحة للاستمتاع برحلتك، سواء كانت للعمل أو السياحة. لكن في بعض الأحيان، قد يتحول هذا الإجراء البسيط إلى مصدر للتوتر والمصاريف غير المتوقعة إذا لم تكن منتبهاً.</p>
            <p>لتجنب المفاجآت غير السارة، جمعنا لك 7 من أكثر الأخطاء شيوعاً التي يقع فيها المستأجرون، وكيف يمكنك تجنبها بسهولة.</p>
            
            <h2>1. إهمال فحص السيارة وتوثيق حالتها عند الاستلام</h2>
            <p>من أكبر الأخطاء أن تستلم مفاتيح السيارة وتنطلق بها فوراً دون فحصها. أي خدش أو ضرر سابق لم يتم تدوينه في العقد قد يُحسب عليك عند إرجاع السيارة.</p>
            <p><strong>الحل:</strong> خذ 5 دقائق لفحص السيارة من الداخل والخارج، والتقط صوراً أو مقطع فيديو سريع بهاتفك. تأكد من إثبات أي ملاحظة في عقد الإيجار قبل التوقيع.</p>
            <p><strong>مع شركة سوى:</strong> فريقنا متواجد لضمان توثيق حالة السيارة معك بكل أمانة ومصداقية عند الاستلام والتسليم.</p>
            
            <h2>2. تجاهل قراءة الشروط والأحكام</h2>
            <p>الكثيرون يتخطون قراءة الشروط الدقيقة، ليتفاجأوا لاحقاً برسوم إضافية مثل:</p>
            <ul>
                <li>رسوم التأخير</li>
                <li>رسوم السائق الإضافي</li>
                <li>غرامات تجاوز الحد المسموح للكيلومترات</li>
            </ul>
            <p><strong>الحل:</strong> اقرأ بوضوح سياسة الكيلومترات (مفتوحة أم مقيدة؟) وتأكد من عدم وجود أي رسوم مبهمة.</p>
            
            <h2>3. سوء فهم سياسة الوقود</h2>
            <p>بعض الشركات تقدم خيارات معقدة للوقود، مثل الدفع المسبق لخزان كامل وإرجاع السيارة فارغة. إذا لم تستخدم الخزان بالكامل، فستخسر أموالك.</p>
            <p><strong>الحل:</strong> ابحث دائماً عن سياسة "ممتلئ إلى ممتلئ" (Full-to-Full)، حيث تستلم السيارة بخزان ممتلئ وتعيدها بنفس الحالة.</p>
            <p><strong>مع شركة سوى:</strong> نعتمد سياسة وقود شفافة (ممتلئ إلى ممتلئ)، مما يضمن أنك تدفع فقط مقابل ما تستهلكه.</p>
            
            <h2>4. تأجيل الحجز للحظة الأخيرة</h2>
            <p>الانتظار حتى وصولك إلى المطار أو وجهتك لاستئجار سيارة يعني غالباً خيارات محدودة وأسعاراً مضاعفة.</p>
            <p><strong>الحل:</strong> احجز سيارتك بمجرد تأكيد مواعيد رحلتك لتضمن توفر السيارة التي تريدها بأفضل سعر ممكن.</p>
            
            <h2>5. اختيار سيارة لا تتناسب مع طبيعة الرحلة</h2>
            <p>استئجار سيارة اقتصادية صغيرة لتوفير المال قد يكون قراراً خاطئاً إذا كان لديك عائلة كبيرة وحقائب ضخمة، أو إذا كنت تنوي القيادة في طرق جبلية وعرة.</p>
            <p><strong>الحل:</strong> قيّم احتياجاتك بدقة: احسب عدد الركاب، وحجم الأمتعة، وطبيعة الطرق في وجهتك قبل اختيار فئة السيارة.</p>
            
            <h2>6. عدم الانتباه لتفاصيل التأمين</h2>
            <p>الاعتماد على التأمين الأساسي فقط قد يجعلك عرضة لدفع مبالغ طائلة (نسبة التحمل) في حال وقوع حادث.</p>
            <p><strong>الحل:</strong> افهم نوع التأمين المشمول، وفكر في ترقية التأمين ليكون شاملاً (بدون نسبة تحمل) لتنعم براحة بال تامة.</p>
            <p><strong>مع شركة سوى:</strong> نوفر خيارات تأمين مرنة تناسب جميع الميزانيات وتضمن حمايتك.</p>
            
            <h2>7. التأخر في تسليم السيارة عن الموعد المحدد</h2>
            <p>شركات التأجير صارمة جداً فيما يخص مواعيد التسليم. التأخر ولو لساعة واحدة قد يكلفك دفع أجرة يوم كامل إضافي.</p>
            <p><strong>الحل:</strong> خطط لوقتك جيداً، واسمح بوجود هامش زمني للزحام المروري لتسليم السيارة في موعدها الدقيق.</p>
            
            <h2>كيف تضمن لك شركة سوى تجربة استئجار مثالية؟</h2>
            <ul>
                <li><strong>شفافية رقمية مطلقة:</strong> عبر منصتنا الإلكترونية، ما تراه هو ما تدفعه.</li>
                <li><strong>سياسات عادلة وواضحة:</strong> نعتمد سياسة وقود شفافة ونوفر خيارات تأمين مرنة.</li>
                <li><strong>إجراءات فحص وتوثيق احترافية:</strong> فريقنا متأكد من توثيق حالة السيارة معك بكل أمانة.</li>
                <li><strong>حجز إلكتروني سريع وموثوق:</strong> يمكنك تأمين سيارتك المفضلة بخطوات بسيطة ومؤكدة.</li>
            </ul>
            
            <h2>الخلاصة</h2>
            <p>تجنب هذه الأخطاء السبعة يبدأ باختيار الشريك الصح. مع شركة سوى، أنت لا تستأجر مجرد سيارة، بل تحجز راحة بالك وتضمن رحلة آمنة وموفقة.</p>
        ',
        'content_en' => '
            <h2>Introduction</h2>
            <p>Renting a car should be a step that gives you the freedom and comfort to enjoy your trip, whether for work or tourism. However, sometimes this simple procedure can turn into a source of stress and unexpected expenses if you are not careful.</p>
            <p>To avoid unpleasant surprises, we have gathered for you 7 of the most common mistakes renters make, and how you can easily avoid them.</p>
            
            <h2>1. Neglecting to Inspect and Document the Car Condition Upon Pickup</h2>
            <p>One of the biggest mistakes is taking the car keys and driving off immediately without inspecting it. Any previous scratch or damage not recorded in the contract may be charged to you when returning the car.</p>
            <p><strong>Solution:</strong> Take 5 minutes to inspect the car inside and out, and take photos or a quick video with your phone. Make sure any observations are noted in the rental contract before signing.</p>
            <p><strong>With Sawa:</strong> Our team is present to ensure documenting the car condition with you professionally and honestly upon pickup and delivery.</p>
            
            <h2>2. Ignoring Terms and Conditions Reading</h2>
            <p>Many people skip reading the fine print, only to be surprised later with additional fees such as:</p>
            <ul>
                <li>Late fees</li>
                <li>Additional driver fees</li>
                <li>Excess mileage penalties</li>
            </ul>
            <p><strong>Solution:</strong> Clearly read the mileage policy (unlimited or limited?) and ensure there are no vague fees.</p>
            
            <h2>3. Misunderstanding Fuel Policy</h2>
            <p>Some companies offer complex fuel options, such as prepaying for a full tank and returning the car empty. If you do not use the entire tank, you will lose your money.</p>
            <p><strong>Solution:</strong> Always look for the "Full-to-Full" policy, where you receive the car with a full tank and return it in the same condition.</p>
            <p><strong>With Sawa:</strong> We follow a transparent fuel policy (Full-to-Full), ensuring you only pay for what you consume.</p>
            
            <h2>4. Postponing Booking to the Last Minute</h2>
            <p>Waiting until you arrive at the airport or your destination to rent a car usually means very limited options and doubled prices.</p>
            <p><strong>Solution:</strong> Book your car as soon as your travel dates are confirmed to ensure availability of the car you want at the best possible price.</p>
            
            <h2>5. Choosing a Car That Does Not Match the Trip Nature</h2>
            <p>Renting a small economy car to save money may be the wrong decision if you have a large family and huge suitcases, or if you plan to drive on rough mountain roads.</p>
            <p><strong>Solution:</strong> Accurately assess your needs: calculate the number of passengers, luggage size, and road conditions at your destination before choosing a car category.</p>
            
            <h2>6. Not Paying Attention to Insurance Details</h2>
            <p>Relying only on basic insurance may make you vulnerable to paying large amounts (deductible) in case of an accident.</p>
            <p><strong>Solution:</strong> Understand the type of insurance included, and consider upgrading to comprehensive insurance (no deductible) for complete peace of mind.</p>
            <p><strong>With Sawa:</strong> We offer flexible insurance options to suit all budgets and ensure your protection.</p>
            
            <h2>7. Being Late in Returning the Car</h2>
            <p>Rental companies are very strict about delivery times. Being late by even one hour may cost you an additional full day rental fee.</p>
            <p><strong>Solution:</strong> Plan your time well, and allow for a time buffer for traffic to return the car on time.</p>
            
            <h2>How Does Sawa Ensure a Perfect Rental Experience?</h2>
            <ul>
                <li><strong>Complete digital transparency:</strong> Through our electronic platform, what you see is what you pay.</li>
                <li><strong>Fair and clear policies:</strong> We follow a transparent fuel policy and offer flexible insurance options.</li>
                <li><strong>Professional inspection and documentation procedures:</strong> Our team ensures documenting the car condition with you professionally.</li>
                <li><strong>Fast and reliable electronic booking:</strong> You can secure your favorite car with simple and confirmed steps.</li>
            </ul>
            
            <h2>Conclusion</h2>
            <p>Avoiding these seven mistakes starts with choosing the right partner. With Sawa, you are not just renting a car; you are booking peace of mind and ensuring a safe and successful trip from start to finish.</p>
        '
    ],
    'first-time-rental-guide' => [
        'title_ar' => 'دليل تأجير السيارة لأول مرة في فلسطين',
        'title_en' => 'First-Time Car Rental Guide in Palestine',
        'desc_ar' => 'كل ما تحتاج معرفته عن تأجير سيارة لأول مرة في فلسطين',
        'desc_en' => 'Everything you need to know about renting a car for the first time in Palestine',
        'image' => 'uploads/blog-rental-guide.jpg',
        'keywords_ar' => 'تأجير سيارة, فلسطين, رام الله, شروط التأجير',
        'keywords_en' => 'car rental, Palestine, Ramallah, rental requirements',
        'content_ar' => '<h2>مقدمة</h2><p>تأجير سيارة في فلسطين يمكن أن يكون تجربة سهلة ومريحة...</p>',
        'content_en' => '<h2>Introduction</h2><p>Renting a car in Palestine can be an easy and comfortable experience...</p>'
    ],
    'best-tourist-destinations' => [
        'title_ar' => 'أفضل 10 وجهات سياحية بالقرب من رام الله',
        'title_en' => 'Top 10 Tourist Destinations Near Ramallah',
        'desc_ar' => 'استكشف أفضل الأماكن السياحية في فلسطين القريبة من رام الله',
        'desc_en' => 'Explore the best tourist places in Palestine near Ramallah',
        'image' => 'uploads/blog-tourism.jpg',
        'keywords_ar' => 'سياحة, رام الله, وجهات سياحية, فلسطين',
        'keywords_en' => 'tourism, Ramallah, tourist destinations, Palestine',
        'content_ar' => '<h2>أفضل الوجهات</h2><p>رام الله محاطة بالعديد من الوجهات السياحية الرائعة...</p>',
        'content_en' => '<h2>Top Destinations</h2><p>Ramallah is surrounded by many great tourist destinations...</p>'
    ],
    'car-rental-prices-comparison' => [
        'title_ar' => 'مقارنة شاملة: أسعار شركات تأجير السيارات في فلسطين 2026',
        'title_en' => 'Complete Comparison: Car Rental Prices in Palestine 2026',
        'desc_ar' => 'قارن بين أسعار شركات التأجير المختلفة واختر الأفضل',
        'desc_en' => 'Compare prices between different rental companies and choose the best',
        'image' => 'uploads/blog-prices.jpg',
        'keywords_ar' => 'مقارنة الأسعار, تأجير سيارات, أسعار 2026',
        'keywords_en' => 'price comparison, car rental, prices 2026',
        'content_ar' => '<h2>مقدمة</h2><p>تختلف أسعار التأجير من شركة لأخرى...</p>',
        'content_en' => '<h2>Introduction</h2><p>Prices vary from company to company...</p>'
    ]
];

$article = $articles[$slug] ?? null;

if (!$article) {
    http_response_code(404);
    $page_title = ($lang === 'ar' ? 'المقال غير موجود' : 'Article Not Found') . ' - ' . company_name();
    $page_description = $lang === 'ar' ? 'المقال المطلوب غير موجود' : 'The requested article does not exist';
    include __DIR__ . '/404.php';
    exit;
}

$page_title = ($lang === 'ar' ? $article['title_ar'] : $article['title_en']) . ' - ' . company_name();
$page_description = $article['desc_ar'] ?? $article['desc_en'];
$page_keywords = $article['keywords_ar'] ?? $article['keywords_en'];
$canonical = abs_url('blog-post.php?slug=' . $slug);
$page_image = $article['image'] ?? '';

include __DIR__ . '/partials/header.php';
?>

<style>
.blog-post-page { padding: 60px 20px; max-width: 850px; margin: 0 auto; }
.blog-post-header { text-align: center; margin-bottom: 40px; padding-bottom: 30px; border-bottom: 2px solid #e3f2fd; }
.blog-post-category { display: inline-block; background: #e3f2fd; color: #1a73e8; padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; margin-bottom: 15px; text-transform: uppercase; }
.blog-post-header h1 { color: #1a73e8; font-size: 2rem; margin-bottom: 15px; line-height: 1.4; }
.blog-post-meta { color: #666; font-size: 0.9rem; display: flex; justify-content: center; gap: 20px; }
.blog-post-meta span { display: flex; align-items: center; gap: 5px; }
.blog-post-content { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
.blog-post-content h2 { color: #1a73e8; margin-top: 35px; margin-bottom: 20px; font-size: 1.5rem; padding-bottom: 10px; border-bottom: 2px solid #e3f2fd; }
.blog-post-content h3 { color: #333; margin-top: 25px; margin-bottom: 15px; font-size: 1.2rem; }
.blog-post-content p { line-height: 1.9; color: #444; margin-bottom: 18px; font-size: 1.05rem; }
.blog-post-content ul, .blog-post-content ol { margin-bottom: 20px; padding-left: 25px; }
.blog-post-content li { margin-bottom: 10px; line-height: 1.7; color: #444; }
.blog-post-content strong { color: #1a73e8; }
.blog-post-share { margin-top: 35px; padding-top: 25px; border-top: 2px solid #e3f2fd; text-align: center; }
.blog-post-share p { font-weight: 600; margin-bottom: 15px; color: #333; }
.blog-post-share a { display: inline-block; margin: 0 8px; width: 45px; height: 45px; line-height: 45px; border-radius: 50%; color: white; text-decoration: none; transition: transform 0.3s; }
.blog-post-share a:hover { transform: scale(1.1); }
.blog-post-share .fb { background: #1877f2; }
.blog-post-share .tw { background: #1da1f2; }
.blog-post-share .wa { background: #25d366; }
.blog-post-back { text-align: center; margin-top: 30px; }
.blog-post-back a { color: #1a73e8; text-decoration: none; font-weight: 600; }
.blog-post-back a:hover { text-decoration: underline; }
.blog-post-related { margin-top: 50px; padding: 30px; background: #f8f9fa; border-radius: 20px; }
.blog-post-related h3 { color: #1a73e8; margin-bottom: 20px; }
</style>

<div class="blog-post-page">
    <header class="blog-post-header">
        <span class="blog-post-category"><?= $lang === 'ar' ? 'مدونة سوى' : 'Sawa Blog' ?></span>
        <h1><?= $lang === 'ar' ? $article['title_ar'] : $article['title_en'] ?></h1>
        <div class="blog-post-meta">
            <span><i class="fas fa-calendar"></i> <?= date('d M Y') ?></span>
            <span><i class="fas fa-eye"></i> <?= rand(100, 500) ?> <?= $lang === 'ar' ? 'مشاهدة' : 'views' ?></span>
            <span><i class="fas fa-clock"></i> <?= $lang === 'ar' ? '5 دقائق للقراءة' : '5 min read' ?></span>
        </div>
    </header>
    
    <article class="blog-post-content">
        <div class="blog-post-body">
            <?= $lang === 'ar' ? $article['content_ar'] : $article['content_en'] ?>
        </div>
        
        <div class="blog-post-share">
            <p><?= $lang === 'ar' ? 'مشاركة هذا المقال:' : 'Share this article:' ?></p>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($canonical) ?>" target="_blank" class="fb"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode($canonical) ?>&text=<?= urlencode($page_title) ?>" target="_blank" class="tw"><i class="fab fa-twitter"></i></a>
            <a href="https://wa.me/?text=<?= urlencode($page_title . ' - ' . $canonical) ?>" target="_blank" class="wa"><i class="fab fa-whatsapp"></i></a>
        </div>
    </article>
    
    <div class="blog-post-back">
        <a href="blog.php"><i class="fas fa-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i> <?= $lang === 'ar' ? 'العودة للمدونة' : 'Back to Blog' ?></a>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
