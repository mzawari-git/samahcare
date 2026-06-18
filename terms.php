<?php

require_once __DIR__ . '/includes/helpers.php';

$page_title = t('terms_title') . ' - ' . company_name();
$page_description = current_lang() === 'ar'
    ? 'شروط وأحكام الخدمة الخاصة بـ ' . company_name() . ' — قواعد استخدام الموقع وتقديم طلبات الحجز.'
    : 'Terms of Service for ' . company_name() . ' — rules for using the website and submitting booking requests.';
$canonical = abs_url('terms.php');

include __DIR__ . '/partials/header.php';

?>

<section class="legal-hero terms-hero">
    <div class="legal-hero-bg">
        <div class="legal-hero-pattern"></div>
    </div>
    <div class="container">
        <div class="legal-hero-content">
            <div class="legal-badge">
                <i class="fas fa-file-contract"></i>
                <span><?= e(current_lang() === 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions') ?></span>
            </div>
            <h1 class="legal-title"><?= e(t('terms_title')) ?></h1>
            <p class="legal-subtitle"><?= e(current_lang() === 'ar' 
                ? 'العقد الإلكتروني الذي يحمي حقوقك وحقوق الشركة'
                : 'The electronic contract that protects your rights and company rights') ?></p>
            <div class="legal-meta">
                <span><i class="fas fa-calendar-alt"></i> <?= e(current_lang() === 'ar' ? 'آخر تحديث:' : 'Last updated:') ?> 26 <?= e(current_lang() === 'ar' ? 'مارس' : 'March') ?> 2026</span>
            </div>
        </div>
    </div>
</section>

<section class="legal-content-section">
    <div class="container">
        <div class="legal-layout">
            <div class="legal-sidebar">
                <div class="legal-toc">
                    <h3><?= e(current_lang() === 'ar' ? 'المحتويات' : 'Contents') ?></h3>
                    <nav class="toc-nav">
                        <a href="#section-1"><span class="toc-num">01</span> <span><?= e(current_lang() === 'ar' ? 'طبيعة الخدمة' : 'Service Nature') ?></span></a>
                        <a href="#section-2"><span class="toc-num">02</span> <span><?= e(current_lang() === 'ar' ? 'الأسعار والدفع' : 'Pricing & Payment') ?></span></a>
                        <a href="#section-3"><span class="toc-num">03</span> <span><?= e(current_lang() === 'ar' ? 'المتطلبات القانونية' : 'Legal Requirements') ?></span></a>
                        <a href="#section-4"><span class="toc-num">04</span> <span><?= e(current_lang() === 'ar' ? 'الإلغاء والتعديل' : 'Cancellation & Changes') ?></span></a>
                        <a href="#section-5"><span class="toc-num">05</span> <span><?= e(current_lang() === 'ar' ? 'الاستخدام المقبول' : 'Acceptable Use') ?></span></a>
                        <a href="#section-6"><span class="toc-num">06</span> <span><?= e(current_lang() === 'ar' ? 'حدود المسؤولية' : 'Limitation of Liability') ?></span></a>
                        <a href="#section-7"><span class="toc-num">07</span> <span><?= e(current_lang() === 'ar' ? 'فض النزاعات' : 'Dispute Resolution') ?></span></a>
                        <a href="#contact"><span class="toc-num">08</span> <span><?= e(current_lang() === 'ar' ? 'تواصل معنا' : 'Contact Us') ?></span></a>
                    </nav>
                </div>
            </div>
            
            <div class="legal-main">
                <div class="legal-intro">
                    <div class="intro-box">
                        <i class="fas fa-quote-left"></i>
                        <p><?= e(current_lang() === 'ar' 
                            ? 'يعد استخدامك لهذا الموقع الإلكتروني إقراراً منك بالموافقة الكاملة على الشروط والأحكام الواردة أدناه. تشكل هذه الشروط اتفاقية قانونية بينك وبين الشركة، وتستند إلى قانون المعاملات الإلكترونية الفلسطيني رقم (15) لسنة 2017 وقانون حماية المستهلك رقم (21) لسنة 2005.'
                            : 'By using this website, you acknowledge your full agreement to the terms and conditions below. These terms constitute a legal agreement between you and the company, based on Palestinian Electronic Transactions Law No. (15) of 2017 and Consumer Protection Law No. (21) of 2005.') ?></p>
                    </div>
                </div>

                <div class="legal-card" id="section-1">
                    <div class="legal-card-header">
                        <span class="legal-section-num">01</span>
                        <h2><?= e(current_lang() === 'ar' ? 'طبيعة الخدمة وطلبات الحجز' : 'Service Nature & Booking Requests') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <div class="highlight-box info">
                            <i class="fas fa-info-circle"></i>
                            <p><?= e(current_lang() === 'ar' 
                                ? 'إن تعبئة نموذج الحجز عبر الموقع تعتبر "طلب استدراج عروض" ولا تعتبر تعاقداً نهائياً ملزماً للشركة إلا بعد تأكيده رسمياً.'
                                : 'Filling the booking form is considered a "quote request" and is not a final binding contract until officially confirmed.') ?></p>
                        </div>
                        <ul class="legal-list">
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-clipboard-check"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'الحجز المبدئي' : 'Initial Booking') ?></strong>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'عبارة عن طلب استدراج عروض أو رغبة في الحجز.'
                                        : 'It is a quote request or booking intent.') ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-user-check"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'دقة المعلومات' : 'Information Accuracy') ?></strong>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'يقر المستخدم بأن جميع البيانات المقدمة صحيحة ودقيقة.'
                                        : 'The user acknowledges that all submitted data is correct and accurate.') ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-id-badge"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'التحقق' : 'Verification') ?></strong>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'حق الشركة في طلب وثائق إضافية للتحقق من الأهلية القانونية.'
                                        : 'The company reserves the right to request additional documents for legal eligibility verification.') ?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="legal-card" id="section-2">
                    <div class="legal-card-header">
                        <span class="legal-section-num">02</span>
                        <h2><?= e(current_lang() === 'ar' ? 'الأسعار والدفع' : 'Pricing & Payment') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <div class="pricing-grid">
                            <div class="pricing-item">
                                <div class="pricing-icon"><i class="fas fa-tag"></i></div>
                                <h4><?= e(current_lang() === 'ar' ? 'التسعير' : 'Pricing') ?></h4>
                                <p><?= e(current_lang() === 'ar' 
                                    ? 'الأسعار المعروضة أسعار تقديرية وقد تختلف بناءً على المواسم أو الإضافات المطلوبة.'
                                    : 'Displayed prices are estimates and may vary based on seasons or required additions.') ?></p>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-icon"><i class="fas fa-coins"></i></div>
                                <h4><?= e(current_lang() === 'ar' ? 'العملة' : 'Currency') ?></h4>
                                <p><?= e(current_lang() === 'ar' 
                                    ? 'يتم التعامل بالعملة المحلية (شيكل) أو ما يعادلها.'
                                    : 'Transactions are in local currency (Shekel) or equivalent.') ?></p>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-icon"><i class="fas fa-percentage"></i></div>
                                <h4><?= e(current_lang() === 'ar' ? 'الضرائب' : 'Taxes') ?></h4>
                                <p><?= e(current_lang() === 'ar' 
                                    ? 'تخضع جميع الأسعار لضريبة القيمة المضافة (VAT).'
                                    : 'All prices are subject to Value Added Tax (VAT).') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="legal-card" id="section-3">
                    <div class="legal-card-header">
                        <span class="legal-section-num">03</span>
                        <h2><?= e(current_lang() === 'ar' ? 'المتطلبات القانونية للمستأجر' : 'Legal Requirements for Renter') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <p><?= e(current_lang() === 'ar' 
                            ? 'بموجب القوانين والأنظمة المعمول بها في دولة فلسطين، يجب على المستأجر:'
                            : 'Under applicable laws and regulations in the State of Palestine, the renter must:') ?></p>
                        <ul class="legal-list requirements-list">
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-car"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'رخصة القيادة' : 'Driving License') ?></strong>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'أن يحمل رخصة قيادة سارية المفعول (فلسطينية أو دولية معترف بها).'
                                        : 'Hold a valid driving license (Palestinian or recognized international).') ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-birthday-cake"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'السن القانوني' : 'Minimum Age') ?></strong>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'ألا يقل العمر عن السن القانوني المحدد في بوليصة التأمين (21 عاماً فأكثر).'
                                        : 'Be at least the minimum age specified in the insurance policy (21+ years).') ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-traffic-light"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'القوانين المرورية' : 'Traffic Laws') ?></strong>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'الالتزام بكافة القوانين المرورية الفلسطينية وتحمل المسؤولية عن المخالفات.'
                                        : 'Comply with all Palestinian traffic laws and bear responsibility for violations.') ?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="legal-card" id="section-4">
                    <div class="legal-card-header">
                        <span class="legal-section-num">04</span>
                        <h2><?= e(current_lang() === 'ar' ? 'سياسة الإلغاء والتعديل' : 'Cancellation & Amendment Policy') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <div class="policy-grid">
                            <div class="policy-item">
                                <div class="policy-icon cancel"><i class="fas fa-times-circle"></i></div>
                                <h4><?= e(current_lang() === 'ar' ? 'إلغاء الحجز' : 'Booking Cancellation') ?></h4>
                                <p><?= e(current_lang() === 'ar' 
                                    ? 'يحق للعميل إلغاء طلب الحجز قبل 24 ساعة من موعد الاستلام دون رسوم.'
                                    : 'The customer can cancel the booking request 24 hours before pickup without fees.') ?></p>
                            </div>
                            <div class="policy-item">
                                <div class="policy-icon edit"><i class="fas fa-edit"></i></div>
                                <h4><?= e(current_lang() === 'ar' ? 'التعديل' : 'Amendment') ?></h4>
                                <p><?= e(current_lang() === 'ar' 
                                    ? 'يخضع تعديل التواريخ أو نوع السيارة لتوفر الإمكانيات.'
                                    : 'Date or vehicle changes are subject to availability.') ?></p>
                            </div>
                            <div class="policy-item">
                                <div class="policy-icon warning"><i class="fas fa-exclamation-triangle"></i></div>
                                <h4><?= e(current_lang() === 'ar' ? 'عدم الحضور' : 'No Show') ?></h4>
                                <p><?= e(current_lang() === 'ar' 
                                    ? 'في حال عدم الحضور دون إشعار، يحق للشركة إلغاء الحجز.'
                                    : 'In case of no-show without notice, the company can cancel the booking.') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="legal-card" id="section-5">
                    <div class="legal-card-header">
                        <span class="legal-section-num">05</span>
                        <h2><?= e(current_lang() === 'ar' ? 'الاستخدام المقبول للموقع' : 'Acceptable Website Use') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <div class="highlight-box danger">
                            <i class="fas fa-ban"></i>
                            <p><?= e(current_lang() === 'ar' 
                                ? 'يُحظر استخدام الموقع لأي أغراض غير قانونية.'
                                : 'Using the website for any illegal purposes is prohibited.') ?></p>
                        </div>
                        <ul class="legal-list">
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-shield-alt"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'حماية الموقع' : 'Site Protection') ?></strong>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'يُحظر اختراق أو تعطيل البنية التحتية للموقع.'
                                        : 'Hacking or disrupting the website infrastructure is prohibited.') ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-copyright"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'الملكية الفكرية' : 'Intellectual Property') ?></strong>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'جميع المحتويات ملكية فكرية محمية ولا يجوز نسخها دون إذن.'
                                        : 'All content is protected intellectual property and cannot be copied without permission.') ?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="legal-card" id="section-6">
                    <div class="legal-card-header">
                        <span class="legal-section-num">06</span>
                        <h2><?= e(current_lang() === 'ar' ? 'حدود المسؤولية' : 'Limitation of Liability') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <div class="highlight-box warning">
                            <i class="fas fa-exclamation-circle"></i>
                            <p><?= e(current_lang() === 'ar' 
                                ? 'يتم تقديم محتوى الموقع "كما هو" دون ضمانات.'
                                : 'Website content is provided "as is" without warranties.') ?></p>
                        </div>
                        <ul class="legal-list">
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-tools"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'أخطاء تقنية' : 'Technical Errors') ?></strong>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'لا نتحمل المسؤولية عن أخطاء تقنية غير مقصودة.'
                                        : 'We are not liable for unintentional technical errors.') ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-user-times"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'سوء الاستخدام' : 'Misuse') ?></strong>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'لا تتحمل الشركة مسؤولية أضرار ناتجة عن سوء استخدام العميل.'
                                        : 'The company is not liable for damages from customer misuse.') ?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="legal-card" id="section-7">
                    <div class="legal-card-header">
                        <span class="legal-section-num">07</span>
                        <h2><?= e(current_lang() === 'ar' ? 'القانون الواجب التطبيق وفض النزاعات' : 'Applicable Law & Dispute Resolution') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <div class="legal-structure">
                            <div class="structure-step">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h4><?= e(current_lang() === 'ar' ? 'القانون الفلسطيني' : 'Palestinian Law') ?></h4>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'تخضع هذه الشروط للقوانين السارية في دولة فلسطين.'
                                        : 'These terms are governed by applicable laws in the State of Palestine.') ?></p>
                                </div>
                            </div>
                            <div class="structure-step">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <h4><?= e(current_lang() === 'ar' ? 'الحل الودي' : 'Friendly Resolution') ?></h4>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'يتم السعي لحل النزاع ودياً في المقام الأول.'
                                        : 'Disputes are first sought to be resolved amicably.') ?></p>
                                </div>
                            </div>
                            <div class="structure-step">
                                <div class="step-number">3</div>
                                <div class="step-content">
                                    <h4><?= e(current_lang() === 'ar' ? 'المحاكم الفلسطينية' : 'Palestinian Courts') ?></h4>
                                    <p><?= e(current_lang() === 'ar' 
                                        ? 'في حال تعذر الحل الودي، تكون المحاكم الفلسطينية هي الجهة المختصة.'
                                        : 'If amicable resolution fails, Palestinian courts have exclusive jurisdiction.') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="legal-card contact-card" id="contact">
                    <div class="legal-card-header">
                        <span class="legal-section-num"><i class="fas fa-headset"></i></span>
                        <h2><?= e(current_lang() === 'ar' ? 'تواصل معنا' : 'Contact Us') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <p><?= e(current_lang() === 'ar' 
                            ? 'إذا كان لديك أي استفسار حول هذه الشروط، يمكنك التواصل معنا عبر:'
                            : 'If you have any questions about these terms, you can contact us via:') ?></p>
                        <div class="contact-grid">
                            <?php $phone1 = setting('company_phone_1', ''); if ($phone1 !== ''): ?>
                            <a href="tel:<?= e($phone1) ?>" class="contact-item">
                                <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                                <div>
                                    <span class="contact-label"><?= e(current_lang() === 'ar' ? 'الهاتف' : 'Phone') ?></span>
                                    <span class="contact-value"><?= e($phone1) ?></span>
                                </div>
                            </a>
                            <?php endif; ?>
                            <a href="https://wa.me/97<?= e(preg_replace('/[^0-9]/', '', $phone1)) ?>" class="contact-item">
                                <div class="contact-icon whatsapp"><i class="fab fa-whatsapp"></i></div>
                                <div>
                                    <span class="contact-label">WhatsApp</span>
                                    <span class="contact-value"><?= e($phone1) ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
