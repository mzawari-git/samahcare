@extends($layoutPath)

@section('title', 'سياسة الخصوصية | سماح كير - حماية وأمان بياناتك الشخصية')
@section('meta_description', 'سياسة الخصوصية لمنصة سماح كير. تعرف على كيفية جمع واستخدام وحماية معلوماتك الشخصية، بيانات الدفع، وحقوقك الكاملة في الخصوصية وأمان المعلومات.')
@section('meta_keywords', 'سياسة الخصوصية, الخصوصية, سماح كير, حماية البيانات, أمن المعلومات, خصوصية المستخدمين, حقوق البيانات, معلومات شخصية, سياسة الخصوصية للتجميل, عناية بالبشرة')
@section('og_image', $siteSettings['site_logo_url'] ?? asset('screenshot-home.png'))
@section('canonical_url', route('privacy'))

@push('styles')
<style>
html { scroll-behavior: smooth; }
.terms-hero {
    padding: 140px 0 60px;
    text-align: center;
    margin-bottom: 40px;
    background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 50%, #FDE68A 100%);
}
.terms-section {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: 1px solid #FEF3C7;
    width: 100%;
}
.terms-section h2 {
    color: #D97706 !important;
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 3px solid #FDE68A;
    display: flex;
    align-items: center;
    gap: 12px;
}
.terms-section h2 i {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, #F59E0B, #D97706);
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}
.terms-section p {
    color: #4B5563 !important;
    line-height: 1.9;
    margin-bottom: 15px;
}
.terms-section ul {
    list-style: none;
    padding: 0;
    margin: 15px 0;
}
.terms-section ul li {
    padding: 12px 18px;
    margin-bottom: 10px;
    background: #FFFBEB;
    border-radius: 10px;
    border-right: 4px solid #F59E0B;
    color: #4B5563 !important;
    line-height: 1.7;
}
.terms-section ul li strong { color: #92400E !important; }
.info-box {
    background: linear-gradient(135deg, #DBEAFE, #BFDBFE);
    border: 2px solid #3B82F6;
    border-radius: 12px;
    padding: 20px;
    margin: 20px 0;
}
.info-box h4 {
    color: #1E40AF !important;
    font-weight: 700;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.info-box p { color: #1E40AF !important; }
.terms-nav {
    position: sticky;
    top: 100px;
    background: white;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    width: 100%;
}
.terms-nav h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #92400E;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 2px solid #FDE68A;
}
.terms-nav ul { list-style: none; padding: 0; margin: 0; }
.terms-nav ul li { margin-bottom: 4px; }
.terms-nav ul li a {
    color: #6B7280 !important;
    text-decoration: none;
    font-size: 0.9rem;
    display: block;
    width: 100%;
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.2s;
}
.terms-nav ul li a:hover { background: #FFFBEB; color: #D97706 !important; }
a.active-section {
    background: #FEF3C7 !important;
    color: #D97706 !important;
    font-weight: 700;
}
.contact-cta {
    background: linear-gradient(135deg, #D97706, #F59E0B);
    color: white;
    padding: 32px 24px;
    border-radius: 16px;
    text-align: center;
    margin-top: 32px;
}
.contact-cta h3 { font-size: 1.5rem; font-weight: 700; margin-bottom: 15px; }
.contact-cta p { margin-bottom: 20px; opacity: 0.95; }
.contact-cta h3, .contact-cta p { color: #fff !important; }
.contact-cta .btn {
    background: white;
    color: #D97706;
    padding: 12px 35px;
    border-radius: 30px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
}
.contact-cta .btn:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
.last-updated {
    text-align: center;
    padding: 20px;
    background: #FEF3C7;
    border-radius: 10px;
    margin-bottom: 30px;
    color: #92400E !important;
    font-weight: 600;
}
@media (max-width: 768px) {
    .terms-hero h1 { font-size: 1.8rem; }
    .terms-section { padding: 16px; }
    .terms-nav { display: none; }
}
@media (max-width: 1024px) {
    .terms-section { padding: 18px; }
}
.privacy-article-card:hover .privacy-article-img {
    transform: scale(1.05);
}
</style>
@endpush

@section('content')
<div class="terms-hero">
    <div class="container mx-auto">
        <h1 class="text-4xl font-extrabold" style="color:#92400E;"><i class="fas fa-user-shield me-2"></i>سياسة الخصوصية</h1>
        <p style="color:#B45309;font-size:1.1rem;">نحن في سماح كير ندرك تماماً أهمية خصوصيتك، ونضع حماية بياناتك الشخصية على رأس أولوياتنا.</p>
    </div>
</div>

<div class="container mx-auto mb-12">
    <div class="last-updated">
        <i class="fas fa-calendar-alt me-2"></i> آخر تحديث: {{ date('Y-m-d') }}
    </div>
    <div class="grid md:grid-cols-12 gap-4 w-full">
        <aside class="hidden md:block w-full" style="grid-column: span 3 / span 3;">
            <nav class="terms-nav w-full">
                <h4><i class="fas fa-list me-2"></i>محتوى الوثيقة</h4>
                <ul id="privacy-sidebar">
                    <li><a href="#section1">المعلومات التي نقوم بجمعها</a></li>
                    <li><a href="#section2">كيف نستخدم معلوماتك؟</a></li>
                    <li><a href="#section3">مشاركة المعلومات والإفصاح عنها</a></li>
                    <li><a href="#section4">أمن البيانات وحمايتها</a></li>
                    <li><a href="#section5">حقوقك وخياراتك</a></li>
                    <li><a href="#section6">تواصل معنا</a></li>
                </ul>
            </nav>
        </aside>
        <section class="w-full" style="grid-column: span 9 / span 9;">
            <div class="terms-section">
                <p class="lead" style="text-align:center;font-weight:600;font-size:1.1rem;color:#4B5563 !important;">
                    نحن في سماح كير ندرك تماماً أهمية خصوصيتك، ونضع حماية بياناتك الشخصية على رأس أولوياتنا. توضح سياسة الخصوصية هذه التزامنا الصارم بكيفية جمع، استخدام، وحماية المعلومات التي تشاركها معنا عند استخدامك لموقعنا أو خدماتنا. نرجو منك قراءة هذه الوثيقة بعناية لفهم ممارساتنا بالكامل.
                </p>
            </div>

            <div class="terms-section" id="section1">
                <h2><i class="fas fa-info-circle"></i>المعلومات التي نقوم بجمعها</h2>
                <p>لضمان تقديم أفضل مستوى من الخدمة، نقوم بجمع أنواع محددة من المعلومات، والتي تشمل:</p>
                <ul>
                    <li><strong>البيانات الشخصية الأساسية:</strong> تشمل الاسم الكامل، عنوان البريد الإلكتروني، ورقم الهاتف، والتي يتم جمعها عند إنشاء حساب، تسجيل الدخول، أو حجز المواعيد.</li>
                    <li><strong>معلومات الدفع والبيانات المالية:</strong> نحرص على أعلى درجات الأمان؛ لذا تُعالج جميع بيانات الدفع عبر بوابات دفع إلكترونية خارجية مشفرة وموثوقة. نحن لا نقوم بتخزين أو الاحتفاظ بأي تفاصيل متعلقة ببطاقاتك الائتمانية على خوادمنا.</li>
                    <li><strong>معلومات الاستخدام والتصفح (البيانات التحليلية):</strong> نجمع بيانات تلقائية حول كيفية تفاعلك مع موقعنا، مثل الصفحات التي تزورها والمدة التي تقضيها فيها، وذلك بهدف تحليل الأداء وتحسين تجربة المستخدم.</li>
                </ul>
            </div>

            <div class="terms-section" id="section2">
                <h2><i class="fas fa-cogs"></i>كيف نستخدم معلوماتك؟</h2>
                <p>نحن نستخدم البيانات التي نجمعها لأغراض تشغيلية وتطويرية واضحة ومحددة:</p>
                <ul>
                    <li><strong>إدارة الخدمات:</strong> معالجة طلباتك، تأكيد وتنسيق حجوزات المواعيد بكفاءة.</li>
                    <li><strong>التواصل الفعال:</strong> إرسال التنبيهات الضرورية، إشعارات تأكيد الحجز، التذكير بالمواعيد، وتحديثات الخدمة.</li>
                    <li><strong>التطوير والتحسين:</strong> دراسة أنماط الاستخدام لتخصيص تجربة التصفح وتطوير جودة الخدمات الرقمية المقدمة عبر الموقع.</li>
                    <li><strong>الامتثال القانوني:</strong> الالتزام بالمتطلبات واللوائح القانونية المعمول بها.</li>
                </ul>
            </div>

            <div class="terms-section" id="section3">
                <h2><i class="fas fa-share-alt"></i>مشاركة المعلومات والإفصاح عنها</h2>
                <p>في "سماح كير"، نعتبر بياناتك أمانة. نحن لا نقوم ببيع، تأجير، أو تداول معلوماتك الشخصية مع أي أطراف خارجية لأغراض تسويقية. يقتصر الإفصاح عن المعلومات على الحالات التالية فقط:</p>
                <ul>
                    <li><strong>مزودي الخدمات الموثوقين:</strong> مثل بوابات الدفع الآمنة، لإتمام العمليات المالية التي تطلبها.</li>
                    <li><strong>الجهات القانونية:</strong> عند الضرورة القصوى للامتثال للقوانين واللوائح التنظيمية، أو استجابةً لطلبات قانونية رسمية حمايةً لحقوقنا أو حقوق عملائنا.</li>
                </ul>
            </div>

            <div class="terms-section" id="section4">
                <h2><i class="fas fa-lock"></i>أمن البيانات وحمايتها</h2>
                <p>نطبق في "سماح كير" بروتوكولات وإجراءات أمنية، تقنية وإدارية، صارمة ومتوافقة مع المعايير القياسية لحماية بياناتك الشخصية من الوصول غير المصرح به، التعديل، الإفصاح، أو الإتلاف.</p>
            </div>

            <div class="terms-section" id="section5">
                <h2><i class="fas fa-user-check"></i>حقوقك وخياراتك</h2>
                <p>نحن نحترم حقوقك الكاملة فيما يتعلق ببياناتك الشخصية. بصفتك مستخدماً لخدماتنا، يحق لك في أي وقت:</p>
                <ul>
                    <li><strong>الوصول</strong> إلى معلوماتك الشخصية المسجلة لدينا.</li>
                    <li><strong>تعديل أو تحديث</strong> بياناتك في حال وجود أي تغييرات أو أخطاء.</li>
                    <li><strong>طلب الحذف</strong> التام لمعلوماتك الشخصية من سجلاتنا.</li>
                </ul>
                <p>يمكنك ممارسة هذه الحقوق في أي وقت عبر مراسلتنا على <a href="mailto:support@samahcare.com" style="color:#D97706;font-weight:600;">support@samahcare.com</a>.</p>
            </div>

            <div class="terms-section" id="section6">
                <h2><i class="fas fa-envelope"></i>تواصل معنا</h2>
                <p>إذا كانت لديك أي استفسارات، مخاوف، أو طلبات تتعلق بسياسة الخصوصية هذه أو بكيفية معالجتنا لبياناتك، يسعدنا تواصلك معنا مباشرة عبر البريد الإلكتروني المخصص للدعم:</p>
                <p style="text-align:center;font-size:1.2rem;font-weight:700;color:#D97706 !important;direction:ltr;">
                    <a href="mailto:support@samahcare.com" style="color:#D97706;">support@samahcare.com</a>
                </p>
            </div>

        </section>
    </div>

    <div style="margin-top:48px;">
        <div style="text-align:center;margin-bottom:32px;">
            <h2 style="color:#92400E;font-size:1.6rem;font-weight:800;">
                <i class="fas fa-newspaper me-2"></i>مقالات حول الخصوصية والأمان الرقمي
            </h2>
            <p style="color:#B45309;font-size:1rem;">نشاركك معلومات قيمة لحماية بياناتك الشخصية في عالم العناية والتجميل الرقمي</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px;">
            <div class="privacy-article-card" style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.05);border:1px solid #FEF3C7;transition:all 0.3s;text-decoration:none;cursor:default;">
                <div style="position:relative;overflow:hidden;height:200px;">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=800&auto=format&fit=crop"
                         alt="أمان البيانات وحماية المعلومات الشخصية"
                         class="privacy-article-img"
                         style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s;"
                         loading="lazy">
                    <div style="position:absolute;top:12px;right:12px;">
                        <span style="display:inline-block;background:#D97706;color:white;font-size:10px;font-weight:700;padding:4px 12px;border-radius:20px;">الأمان الرقمي</span>
                    </div>
                </div>
                <div style="padding:20px;">
                    <h3 style="color:#92400E;font-size:1rem;font-weight:700;margin-bottom:8px;line-height:1.5;">
                        أهمية حماية بياناتك الشخصية عند حجز خدمات التجميل عبر الإنترنت
                    </h3>
                    <p style="color:#6B7280;font-size:0.85rem;line-height:1.7;margin-bottom:12px;">
                        في عصر التحول الرقمي، أصبحت بياناتك الشخصية ثمينة كجمالك. نقدم لك دليلاً شاملاً حول كيفية التحقق من أمان المنصات التي تشاركها معها معلوماتك قبل حجز موعدك القادم للعناية ببشرتك وجمالك.
                    </p>
                    <div style="display:flex;align-items:center;gap:12px;font-size:0.75rem;color:#9CA3AF;">
                        <span><i class="fas fa-shield-alt me-1"></i> أمان المعلومات</span>
                        <span>&middot;</span>
                        <span><i class="fas fa-clock me-1"></i> 5 دقائق قراءة</span>
                    </div>
                </div>
            </div>

            <div class="privacy-article-card" style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.05);border:1px solid #FEF3C7;transition:all 0.3s;text-decoration:none;cursor:default;">
                <div style="position:relative;overflow:hidden;height:200px;">
                    <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?q=80&w=800&auto=format&fit=crop"
                         alt="خصوصية البيانات في مراكز التجميل"
                         class="privacy-article-img"
                         style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s;"
                         loading="lazy">
                    <div style="position:absolute;top:12px;right:12px;">
                        <span style="display:inline-block;background:#D97706;color:white;font-size:10px;font-weight:700;padding:4px 12px;border-radius:20px;">نصائح وحقوق</span>
                    </div>
                </div>
                <div style="padding:20px;">
                    <h3 style="color:#92400E;font-size:1rem;font-weight:700;margin-bottom:8px;line-height:1.5;">
                        كيف تحمي خصوصيتك في مراكز التجميل الرقمية؟
                    </h3>
                    <p style="color:#6B7280;font-size:0.85rem;line-height:1.7;margin-bottom:12px;">
                        اكتشف أهم الإجراءات التي يجب أن تتخذها مراكز التجميل لحماية بيانات عملائها، وما هي حقوقك القانونية في خصوصية معلوماتك الصحية والجمالية وفقاً لأحدث معايير حماية البيانات.
                    </p>
                    <div style="display:flex;align-items:center;gap:12px;font-size:0.75rem;color:#9CA3AF;">
                        <span><i class="fas fa-gavel me-1"></i> حقوق المستخدم</span>
                        <span>&middot;</span>
                        <span><i class="fas fa-clock me-1"></i> 4 دقائق قراءة</span>
                    </div>
                </div>
            </div>

            <div class="privacy-article-card" style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.05);border:1px solid #FEF3C7;transition:all 0.3s;text-decoration:none;cursor:default;">
                <div style="position:relative;overflow:hidden;height:200px;">
                    <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?q=80&w=800&auto=format&fit=crop"
                         alt="سياسة الخصوصية وحقوق البيانات"
                         class="privacy-article-img"
                         style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s;"
                         loading="lazy">
                    <div style="position:absolute;top:12px;right:12px;">
                        <span style="display:inline-block;background:#D97706;color:white;font-size:10px;font-weight:700;padding:4px 12px;border-radius:20px;">الشفافية</span>
                    </div>
                </div>
                <div style="padding:20px;">
                    <h3 style="color:#92400E;font-size:1rem;font-weight:700;margin-bottom:8px;line-height:1.5;">
                        الشفافية الكاملة: كيف نتعامل مع بياناتك في سماح كير
                    </h3>
                    <p style="color:#6B7280;font-size:0.85rem;line-height:1.7;margin-bottom:12px;">
                        نؤمن في سماح كير أن الشفافية هي أساس الثقة. نوضح لك بالتفصيل رحلة بياناتك منذ لحظة التسجيل وحتى معالجتها وتخزينها، مع ضمان أعلى معايير الأمان والخصوصية.
                    </p>
                    <div style="display:flex;align-items:center;gap:12px;font-size:0.75rem;color:#9CA3AF;">
                        <span><i class="fas fa-check-circle me-1"></i> الشفافية</span>
                        <span>&middot;</span>
                        <span><i class="fas fa-clock me-1"></i> 3 دقائق قراءة</span>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align:center;margin-top:28px;">
            <a href="{{ route('blog.index') }}"
               style="display:inline-block;background:linear-gradient(135deg,#D97706,#F59E0B);color:white;padding:12px 32px;border-radius:30px;font-weight:600;font-size:0.9rem;text-decoration:none;transition:all 0.3s;"
               onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 25px rgba(0,0,0,0.2)'"
               onmouseout="this.style.transform='';this.style.boxShadow=''">
                <i class="fas fa-arrow-left me-2"></i>تصفح جميع المقالات
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "سياسة الخصوصية | سماح كير",
  "description": "سياسة الخصوصية لمنصة سماح كير - نوضح كيفية جمع واستخدام وحماية معلوماتك الشخصية.",
  "url": "{{ route('privacy') }}",
  "inLanguage": "ar",
  "isPartOf": {
    "@type": "WebSite",
    "name": "{{ $siteSettings['site_name'] ?? 'سماح كير' }}",
    "url": "{{ url('/') }}"
  },
  "about": {
    "@type": "Thing",
    "name": "سياسة الخصوصية"
  },
  "maintainer": {
    "@type": "Organization",
    "name": "{{ $siteSettings['site_name'] ?? 'سماح كير' }}",
    "url": "{{ url('/') }}",
    "contactPoint": {
      "@type": "ContactPoint",
      "email": "support@samahcare.com",
      "contactType": "customer service"
    }
  },
  "dateModified": "{{ date('Y-m-d') }}",
  "significantLink": [
    { "@type": "LinkRole", "url": "{{ route('contact') }}", "name": "اتصل بنا" },
    { "@type": "LinkRole", "url": "{{ route('privacy') }}", "name": "سياسة الخصوصية" }
  ]
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var sections = document.querySelectorAll('.terms-section[id]');
    var links = document.querySelectorAll('#privacy-sidebar a');
    if (!sections.length || !links.length) return;
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                links.forEach(function (l) { l.classList.remove('active-section'); });
                var id = entry.target.getAttribute('id');
                var match = document.querySelector('#privacy-sidebar a[href="#' + id + '"]');
                if (match) match.classList.add('active-section');
            }
        });
    }, { rootMargin: '-80px 0px -50% 0px', threshold: 0 });
    sections.forEach(function (s) { observer.observe(s); });
});
</script>
@endpush