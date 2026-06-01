@extends($layoutPath)

@section('title', 'الشروط والأحكام - سماح كير')
@section('meta_description', 'الشروط والأحكام المنظمة لاستخدام منصة سماح كير للخدمات الجمالية والحجز الإلكتروني في فلسطين.')
@section('meta_keywords', 'شروط الاستخدام, الأحكام, سماح كير, حجز, خدمات تجميل, فلسطين')
@section('og_image', $siteSettings['site_logo_url'] ?? asset('favicon-32x32.png'))

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
    margin-bottom: 25px;
    padding-bottom: 15px;
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
.terms-section h3 {
    color: #B45309 !important;
    font-size: 1.15rem;
    font-weight: 600;
    margin: 25px 0 15px;
    display: flex;
    align-items: center;
    gap: 8px;
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
.warning-box {
    background: linear-gradient(135deg, #FEE2E2, #FECACA);
    border: 2px solid #EF4444;
    border-radius: 12px;
    padding: 20px;
    margin: 20px 0;
}
.warning-box h4 {
    color: #DC2626 !important;
    font-weight: 700;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}
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
.warning-box p { color: #991B1B !important; }
a.active-section {
    background: #FEF3C7 !important;
    color: #D97706 !important;
    font-weight: 700;
}
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
</style>
@endpush

@section('content')
<div class="terms-hero">
    <div class="container mx-auto">
        <h1 class="text-4xl font-extrabold" style="color:#92400E;"><i class="fas fa-file-contract me-2"></i>الشروط والأحكام</h1>
        <p style="color:#B45309;font-size:1.1rem;">وثيقة قانونية تنظم علاقتكم بمنصتنا، يرجى قراءتها بعناية</p>
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
                <ul id="terms-sidebar">
                    <li><a href="#section1">نطاق التطبيق</a></li>
                    <li><a href="#section2">أنواع الحسابات</a></li>
                    <li><a href="#section3">سياسة التسعير</a></li>
                    <li><a href="#section4">الاستخدام الآمن</a></li>
                    <li><a href="#section5">حقوق الملكية</a></li>
                    <li><a href="#contact">تواصل معنا</a></li>
                </ul>
            </nav>
        </aside>
        <section class="w-full" style="grid-column: span 9 / span 9;">
            <div class="terms-section">
                <p class="lead" style="text-align:center;font-weight:600;font-size:1.1rem;color:#4B5563 !important;">
                    مرحباً بكم في منصة ساماه كير. يرجى قراءة الشروط والأحكام التالية بعناية قبل استخدام الموقع أو الخدمات المقدمة.
                </p>
            </div>

            <div class="terms-section" id="section1">
                <h2><i class="fas fa-gavel"></i>نطاق التطبيق والقانون المرجعي</h2>
                <h3><i class="fas fa-handshake"></i>الاتفاقية المُلزمة</h3>
                <p style="text-align:start;">تُعد هذه الشروط والأحكام بمثابة اتفاقية قانونية ملزمة تماماً بين "شركة ساماه كير" (يُشار إليها لاحقاً بـ "الشركة" أو "المنصة") وبين المستخدم.</p>
                <h3><i class="fas fa-check-double"></i>الموافقة المطلقة</h3>
                <p style="text-align:start;">بمجرد دخولك إلى منصتنا، أو تصفحك لخدماتنا، أو استخدامك لأي من خدماتنا، فإنك تقر صراحةً باطلاعك الكامل على هذه الشروط والموافقة عليها دون أي تحفظ.</p>
                <h3><i class="fas fa-sync-alt"></i>تحديث الشروط</h3>
                <p style="text-align:start;">تحتفظ الشركة بالحق في تعديل أو تحديث هذه الشروط في أي وقت دون إشعار مسبق، ويُعد استمرارك في استخدام المنصة بعد التعديل موافقة ضمنية على الشروط الجديدة.</p>
                <div class="info-box">
                    <h4><i class="fas fa-balance-scale"></i>المرجعية القانونية والاختصاص</h4>
                    <p class="mb-0" style="text-align:start;">تخضع هذه الوثيقة وتُفسر حصرياً وفقاً للقوانين والتشريعات المعمول بها في <strong>دولة فلسطين</strong>.</p>
                </div>
            </div>

            <div class="terms-section" id="section2">
                <h2><i class="fas fa-users-cog"></i>أنواع الحسابات والخدمات المقدمة</h2>
                <p style="text-align:start;">توفر منصتنا بنية تحتية شاملة لخدمة شرائح متعددة من العملاء:</p>
                <ul>
                    <li><strong>حسابات الأفراد (B2C):</strong> مخصصة للمستهلكين النهائيين، تتيح لهم تجربة حجز سلسة.</li>
                    <li><strong>حسابات الشركات (B2B):</strong> حسابات مخصصة لعملاء الجملة، تخضع لعملية تحقق وموافقة مسبقة.</li>
                </ul>
                <div class="warning-box">
                    <h4><i class="fas fa-exclamation-triangle"></i>دقة البيانات والمسؤولية</h4>
                    <p class="mb-0" style="text-align:start;">يلتزم المستخدم بإدخال بيانات تسجيل دقيقة. تُخلي الشركة مسؤوليتها عن أي أضرار ناتجة عن معلومات خاطئة.</p>
                </div>
            </div>

            <div class="terms-section" id="section3">
                <h2><i class="fas fa-tags"></i>سياسة التسعير وإدارة الطلبات</h2>
                <h3><i class="fas fa-boxes"></i>إدارة المخزون والتوافر</h3>
                <p style="text-align:start;">عرض الخدمة على الموقع لا يضمن توافرها الدائم. تخضع جميع الحجوزات للمراجعة والتحقق الفوري.</p>
                <h3><i class="fas fa-shekel-sign"></i>العملة المعتمدة والضرائب</h3>
                <p style="text-align:start;">تُعرض جميع الأسعار على المنصة بالشيكل الإسرائيلي (ILS) وتشمل ضريبة القيمة المضافة.</p>
                <h3><i class="fas fa-edit"></i>تعديل الأسعار</h3>
                <p style="text-align:start;">تحتفظ المنصة بحق تغيير أسعار الخدمات في أي وقت، ولا يسري هذا التغيير على الحجوزات المؤكدة.</p>
            </div>

            <div class="terms-section" id="section4">
                <h2><i class="fas fa-shield-alt"></i>الاستخدام الآمن والقيود التقنية</h2>
                <p style="text-align:start;">لضمان تجربة مستقرة وآمنة، تُطبق إجراءات تقنية متقدمة:</p>
                <ul>
                    <li><strong>نظام تقييد الطلبات:</strong> آلية دفاعية تحظر العناوين التي ترسل طلبات مفرطة.</li>
                    <li><strong>الحماية من الهجمات:</strong> مراقبة حركة المرور وصد أي هجمات.</li>
                </ul>
                <div class="warning-box">
                    <h4><i class="fas fa-ban"></i>المساءلة القانونية</h4>
                    <p style="text-align:start;">أي محاولة لاختراق المنصة ستؤدي إلى الحظر الفوري مع حفظ حق الملاحقة القانونية.</p>
                </div>
            </div>

            <div class="terms-section" id="section5">
                <h2><i class="fas fa-copyright"></i>حقوق الملكية الفكرية والامتثال القانوني</h2>
                <h3><i class="fas fa-gem"></i>الملكية الحصرية</h3>
                <p style="text-align:start;">جميع المحتويات (نصوص، صور، علامات تجارية) هي ملكية فكرية حصرية لساماه كير.</p>
                <h3><i class="fas fa-copy"></i>حظر النسخ</h3>
                <p style="text-align:start;">يُمنع نسخ أو إعادة إنتاج أي جزء من المحتوى دون إذن كتابي مسبق.</p>
                <div class="info-box">
                    <h4><i class="fas fa-robot"></i>الرقابة والامتثال الذكي</h4>
                    <p class="mb-0" style="text-align:start;">تخضع جميع العمليات لرقابة آنية عبر أنظمة التدقيق الآلي لضمان الامتثال للسياسات.</p>
                </div>
            </div>

            <div class="contact-cta" id="contact">
                <h3><i class="fas fa-envelope me-2"></i>هل لديك استفسار قانوني؟</h3>
                <p>فريقنا جاهز لمساعدتك في أي استفسار يتعلق بالشروط والأحكام</p>
                <a href="{{ route('contact') }}" class="btn">تواصل معنا</a>
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var sections = document.querySelectorAll('.terms-section[id]');
    var links = document.querySelectorAll('#terms-sidebar a');
    if (!sections.length || !links.length) return;
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                links.forEach(function (l) { l.classList.remove('active-section'); });
                var id = entry.target.getAttribute('id');
                var match = document.querySelector('#terms-sidebar a[href="#' + id + '"]');
                if (match) match.classList.add('active-section');
            }
        });
    }, { rootMargin: '-80px 0px -50% 0px', threshold: 0 });
    sections.forEach(function (s) { observer.observe(s); });
});
</script>
@endpush
