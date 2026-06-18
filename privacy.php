<?php

require_once __DIR__ . '/includes/helpers.php';

$page_title = t('privacy_title') . ' - ' . company_name();
$page_description = current_lang() === 'ar'
    ? 'سياسة الخصوصية الخاصة بـ ' . company_name() . ' — توضح كيفية جمع واستخدام وحماية البيانات.'
    : 'Privacy Policy for ' . company_name() . ' — how we collect, use, and protect data.';
$canonical = abs_url('privacy.php');

include __DIR__ . '/partials/header.php';

?>

<section class="legal-hero">
    <div class="legal-hero-bg">
        <div class="legal-hero-pattern"></div>
    </div>
    <div class="container">
        <div class="legal-hero-content">
            <div class="legal-badge">
                <i class="fas fa-shield-alt"></i>
                <span><?= e(current_lang() === 'ar' ? 'أمان وخصوصية' : 'Security & Privacy') ?></span>
            </div>
            <h1 class="legal-title"><?= e(t('privacy_title')) ?></h1>
            <p class="legal-subtitle"><?= e(current_lang() === 'ar' ? 'كيف نحمي بياناتك ونستخدمها بمسؤولية' : 'How we protect and use your data responsibly') ?></p>
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
                        <a href="#section-1"><span class="toc-num">01</span> <span><?= e(current_lang() === 'ar' ? 'المرجعية القانونية' : 'Legal Reference') ?></span></a>
                        <a href="#section-2"><span class="toc-num">02</span> <span><?= e(current_lang() === 'ar' ? 'المعلومات المجمعة' : 'Information We Collect') ?></span></a>
                        <a href="#section-3"><span class="toc-num">03</span> <span><?= e(current_lang() === 'ar' ? 'الغرض من المعالجة' : 'Purpose of Processing') ?></span></a>
                        <a href="#section-4"><span class="toc-num">04</span> <span><?= e(current_lang() === 'ar' ? 'مشاركة البيانات' : 'Data Sharing') ?></span></a>
                        <a href="#section-5"><span class="toc-num">05</span> <span><?= e(current_lang() === 'ar' ? 'أمن البيانات' : 'Data Security') ?></span></a>
                        <a href="#section-6"><span class="toc-num">06</span> <span><?= e(current_lang() === 'ar' ? 'حقوقك' : 'Your Rights') ?></span></a>
                        <a href="#section-7"><span class="toc-num">07</span> <span><?= e(current_lang() === 'ar' ? 'التغييرات' : 'Changes') ?></span></a>
                        <a href="#contact"><span class="toc-num">08</span> <span><?= e(current_lang() === 'ar' ? 'تواصل معنا' : 'Contact Us') ?></span></a>
                    </nav>
                </div>
            </div>
            
            <div class="legal-main">
                <div class="legal-intro">
                    <p><?= e(current_lang() === 'ar' 
                        ? 'تلتزم مؤسستنا بحماية خصوصية بياناتك الشخصية ومعالجتها بشفافية ومسؤولية. تم إعداد هذه السياسة لتتوافق مع قانون المعاملات الإلكترونية الفلسطيني رقم (15) لسنة 2017 والمعايير الدولية لحماية البيانات.'
                        : 'Our institution is committed to protecting your personal data privacy and processing it with transparency and responsibility. This policy complies with the Palestinian Electronic Transactions Law No. (15) of 2017 and international data protection standards.') ?></p>
                </div>

                <div class="legal-card" id="section-1">
                    <div class="legal-card-header">
                        <span class="legal-section-num">01</span>
                        <h2><?= e(current_lang() === 'ar' ? 'المرجعية القانونية' : 'Legal Reference') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <p><?= e(current_lang() === 'ar' 
                            ? 'تخضع هذه السياسة وتُفسر وفقاً للقوانين السارية في دولة فلسطين، وعلى وجه الخصوص:'
                            : 'This policy is governed and interpreted according to the applicable laws in the State of Palestine:') ?></p>
                        <ul class="legal-list">
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-balance-scale"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'القانون الأساسي الفلسطيني' : 'Palestinian Basic Law') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'الذي يكفل حرمة الحياة الخاصة.' : 'Which guarantees the sanctity of private life.') ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-file-contract"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'قانون المعاملات الإلكترونية رقم (15) لسنة 2017' : 'Electronic Transactions Law No. (15) of 2017') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'خاصة المواد المتعلقة بحماية البيانات الشخصية وسريتها.' : 'Especially articles related to personal data protection and confidentiality.') ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-user-shield"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'قانون حماية المستهلك الفلسطيني' : 'Palestinian Consumer Protection Law') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'لضمان حقوق المستخدم في الحصول على خدمة آمنة.' : 'To ensure user rights to secure services.') ?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="legal-card" id="section-2">
                    <div class="legal-card-header">
                        <span class="legal-section-num">02</span>
                        <h2><?= e(current_lang() === 'ar' ? 'المعلومات التي نجمعها' : 'Information We Collect') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <p><?= e(current_lang() === 'ar' 
                            ? 'نقوم بجمع البيانات الضرورية فقط لتقديم خدمة حجز السيارات بكفاءة:'
                            : 'We collect only necessary data to efficiently provide car rental services:') ?></p>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-icon"><i class="fas fa-id-card"></i></div>
                                <h4><?= e(current_lang() === 'ar' ? 'بيانات الهوية' : 'Identity Data') ?></h4>
                                <p><?= e(current_lang() === 'ar' ? 'الاسم الكامل، رقم الهاتف، وعنوان البريد الإلكتروني.' : 'Full name, phone number, and email address.') ?></p>
                            </div>
                            <div class="info-item">
                                <div class="info-icon"><i class="fas fa-passport"></i></div>
                                <h4><?= e(current_lang() === 'ar' ? 'وثائق رسمية' : 'Official Documents') ?></h4>
                                <p><?= e(current_lang() === 'ar' ? 'صورة رخصة القيادة ووثيقة إثبات الشخصية.' : 'Driving license and ID document photos.') ?></p>
                            </div>
                            <div class="info-item">
                                <div class="info-icon"><i class="fas fa-calendar-check"></i></div>
                                <h4><?= e(current_lang() === 'ar' ? 'بيانات الحجز' : 'Booking Data') ?></h4>
                                <p><?= e(current_lang() === 'ar' ? 'نوع المركبة، تواريخ الاستلام والتسليم.' : 'Vehicle type, pickup and return dates.') ?></p>
                            </div>
                            <div class="info-item">
                                <div class="info-icon"><i class="fas fa-server"></i></div>
                                <h4><?= e(current_lang() === 'ar' ? 'بيانات تقنية' : 'Technical Data') ?></h4>
                                <p><?= e(current_lang() === 'ar' ? 'عنوان IP، نوع المتصفح، وملفات تعريف الارتباط.' : 'IP address, browser type, and cookies.') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="legal-card" id="section-3">
                    <div class="legal-card-header">
                        <span class="legal-section-num">03</span>
                        <h2><?= e(current_lang() === 'ar' ? 'الغرض من معالجة البيانات' : 'Purpose of Data Processing') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <p><?= e(current_lang() === 'ar' ? 'نستخدم بياناتك للأغراض التالية:' : 'We use your data for the following purposes:') ?></p>
                        <ul class="legal-list">
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-check-circle"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'إتمام عملية الحجز' : 'Complete Booking Process') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'والتحقق من أهلية القيادة قانونياً.' : 'And verify legal driving eligibility.') ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-comments"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'التواصل معك' : 'Communication') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'لتأكيد الحجز أو إرسال تحديثات متعلقة بالخدمة.' : 'To confirm booking or send service updates.') ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'المحاسبة والفواتير' : 'Accounting & Invoices') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'لإصدار الفواتير الضريبية وفق القانون المالي الفلسطيني.' : 'For tax invoices per Palestinian financial law.') ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-gavel"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'الامتثال القانوني' : 'Legal Compliance') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'الاستجابة لطلبات الجهات الأمنية أو القضائية عند الضرورة.' : 'Respond to security or judicial requests when necessary.') ?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="legal-card" id="section-4">
                    <div class="legal-card-header">
                        <span class="legal-section-num">04</span>
                        <h2><?= e(current_lang() === 'ar' ? 'مشاركة البيانات مع أطراف ثالثة' : 'Data Sharing with Third Parties') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <div class="highlight-box warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p><?= e(current_lang() === 'ar' 
                                ? 'نحن لا نبيع بياناتك الشخصية مطلقاً.'
                                : 'We never sell your personal data.') ?></p>
                        </div>
                        <p><?= e(current_lang() === 'ar' ? 'قد نشارك معلوماتك في حالات محددة جداً:' : 'We may share your information in specific cases:') ?></p>
                        <ul class="legal-list">
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-landmark"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'الجهات الحكومية' : 'Government Entities') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'عند وجود طلب قانوني ملزم (مثل الشرطة أو القضاء).' : 'When there is a binding legal request (e.g., police or judiciary).') ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="legal-list-icon"><i class="fas fa-handshake"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'مزودي الخدمات' : 'Service Providers') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'مثل شركات التأمين أو بوابات الدفع الإلكتروني المرخصة.' : 'Such as insurance companies or licensed payment gateways.') ?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="legal-card" id="section-5">
                    <div class="legal-card-header">
                        <span class="legal-section-num">05</span>
                        <h2><?= e(current_lang() === 'ar' ? 'أمن البيانات والاحتفاظ بها' : 'Data Security & Retention') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <div class="security-grid">
                            <div class="security-item">
                                <div class="security-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <h4><?= e(current_lang() === 'ar' ? 'حماية متطورة' : 'Advanced Protection') ?></h4>
                                <p><?= e(current_lang() === 'ar' 
                                    ? 'نستخدم بروتوكولات تشفير متطورة (SSL) لحماية البيانات أثناء النقل والتخزين.'
                                    : 'We use advanced encryption protocols (SSL) to protect data during transfer and storage.') ?></p>
                            </div>
                            <div class="security-item">
                                <div class="security-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h4><?= e(current_lang() === 'ar' ? 'مدة الاحتفاظ' : 'Retention Period') ?></h4>
                                <p><?= e(current_lang() === 'ar' 
                                    ? 'نحتفظ ببياناتك طوال الفترة اللازمة لتقديم الخدمة، وللفترات التي يفرضها القانون.'
                                    : 'We retain your data for the period necessary to provide the service and as required by law.') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="legal-card" id="section-6">
                    <div class="legal-card-header">
                        <span class="legal-section-num">06</span>
                        <h2><?= e(current_lang() === 'ar' ? 'حقوقك كمستخدم' : 'Your Rights as a User') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <p><?= e(current_lang() === 'ar' ? 'بموجب القوانين السارية، يحق لك:' : 'Under applicable laws, you have the right to:') ?></p>
                        <div class="rights-grid">
                            <div class="right-item">
                                <div class="right-icon"><i class="fas fa-search"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'الوصول' : 'Access') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'طلب نسخة من بياناتك.' : 'Request a copy of your data.') ?></p>
                                </div>
                            </div>
                            <div class="right-item">
                                <div class="right-icon"><i class="fas fa-edit"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'التصحيح' : 'Correction') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'تعديل أي بيانات غير دقيقة.' : 'Modify any inaccurate data.') ?></p>
                                </div>
                            </div>
                            <div class="right-item">
                                <div class="right-icon"><i class="fas fa-trash-alt"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'الحذف' : 'Deletion') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'طلب مسح بياناتك.' : 'Request deletion of your data.') ?></p>
                                </div>
                            </div>
                            <div class="right-item">
                                <div class="right-icon"><i class="fas fa-ban"></i></div>
                                <div>
                                    <strong><?= e(current_lang() === 'ar' ? 'الاعتراض' : 'Objection') ?></strong>
                                    <p><?= e(current_lang() === 'ar' ? 'الاعتراض على التسويق المباشر.' : 'Object to direct marketing.') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="legal-card" id="section-7">
                    <div class="legal-card-header">
                        <span class="legal-section-num">07</span>
                        <h2><?= e(current_lang() === 'ar' ? 'التغييرات في سياسة الخصوصية' : 'Changes to Privacy Policy') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <div class="highlight-box info">
                            <i class="fas fa-info-circle"></i>
                            <p><?= e(current_lang() === 'ar' 
                                ? 'نحتفظ بالحق في تحديث هذه السياسة لتعكس التغييرات في ممارساتنا أو القوانين المحلية.'
                                : 'We reserve the right to update this policy to reflect changes in our practices or local laws.') ?></p>
                        </div>
                        <p><?= e(current_lang() === 'ar' 
                            ? 'سيتم نشر أي تعديل على هذه الصفحة مع تحديث التاريخ.'
                            : 'Any modifications will be posted on this page with an updated date.') ?></p>
                    </div>
                </div>

                <div class="legal-card contact-card" id="contact">
                    <div class="legal-card-header">
                        <span class="legal-section-num"><i class="fas fa-envelope"></i></span>
                        <h2><?= e(current_lang() === 'ar' ? 'تواصل معنا' : 'Contact Us') ?></h2>
                    </div>
                    <div class="legal-card-body">
                        <p><?= e(current_lang() === 'ar' 
                            ? 'لأي استفسار قانوني أو لممارسة حقوقك المتعلقة ببياناتك، يرجى التواصل معنا:'
                            : 'For any legal inquiry or to exercise your data rights, please contact us:') ?></p>
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
