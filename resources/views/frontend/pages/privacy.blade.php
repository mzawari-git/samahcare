@extends('frontend.layouts.organic-spa.app')

@section('title', 'سياسة الخصوصية - سماح كير')
@section('meta_description', 'سياسة الخصوصية لمنصة سماح كير - نوضح كيفية جمع واستخدام وحماية معلوماتك الشخصية عند استخدام خدماتنا.')
@section('meta_keywords', 'سياسة الخصوصية, الخصوصية, سماح كير, حماية البيانات, معلومات شخصية, فلسطين')
@section('og_image', asset('assets/images/og-image.webp'))

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
</style>
@endpush

@section('content')
<div class="terms-hero">
    <div class="container mx-auto">
        <h1 class="text-4xl font-extrabold" style="color:#92400E;"><i class="fas fa-user-shield me-2"></i>سياسة الخصوصية</h1>
        <p style="color:#B45309;font-size:1.1rem;">نحن نحترم خصوصيتك ونلتزم بحماية معلوماتك الشخصية.</p>
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
                    <li><a href="#section1">المعلومات التي نجمعها</a></li>
                    <li><a href="#section2">كيفية استخدام المعلومات</a></li>
                    <li><a href="#section3">مشاركة المعلومات</a></li>
                    <li><a href="#section4">الأمان</a></li>
                    <li><a href="#section5">حقوقك</a></li>
                    <li><a href="#contact">تواصل معنا</a></li>
                </ul>
            </nav>
        </aside>
        <section class="w-full" style="grid-column: span 9 / span 9;">
            <div class="terms-section">
                <p class="lead" style="text-align:center;font-weight:600;font-size:1.1rem;color:#4B5563 !important;">
                    نحن في ساماه كير نولي اهتماماً كبيراً بخصوصيتك. يرجى قراءة ما يلي لمعرفة كيفية جمع واستخدام وحماية معلوماتك.
                </p>
            </div>

            <div class="terms-section" id="section1">
                <h2><i class="fas fa-info-circle"></i>المعلومات التي نجمعها</h2>
                <ul>
                    <li><strong>البيانات الشخصية:</strong> مثل الاسم، البريد الإلكتروني، رقم الهاتف عند التسجيل أو الحجز.</li>
                    <li><strong>معلومات الدفع:</strong> تُعالج عبر بوابة دفع آمنة ولا تُخزن لدينا.</li>
                    <li><strong>معلومات الاستخدام:</strong> الصفحات التي تزورها داخل الموقع لتحسين التجربة.</li>
                </ul>
            </div>

            <div class="terms-section" id="section2">
                <h2><i class="fas fa-cogs"></i>كيفية استخدام المعلومات</h2>
                <p>نستخدم بياناتك للآتي:</p>
                <ul>
                    <li>إدارة وحجز المواعيد.</li>
                    <li>إرسال إشعارات حول الحجز وتحديثات الخدمة.</li>
                    <li>تحسين خدمات الموقع وتخصيص التجربة.</li>
                    <li>الامتثال للمتطلبات القانونية.</li>
                </ul>
            </div>

            <div class="terms-section" id="section3">
                <h2><i class="fas fa-share-alt"></i>مشاركة المعلومات</h2>
                <p>لا نشارك معلوماتك الشخصية مع أطراف ثالثة إلا للجهات اللازمة لمعالجة الدفع أو الامتثال للقانون.</p>
            </div>

            <div class="terms-section" id="section4">
                <h2><i class="fas fa-lock"></i>الأمان</h2>
                <p>نتبع إجراءات تقنية وإدارية لحماية بياناتك من الوصول غير المصرح به أو فقدانها.</p>
            </div>

            <div class="terms-section" id="section5">
                <h2><i class="fas fa-user-check"></i>حقوقك</h2>
                <p>يمكنك طلب الوصول إلى بياناتك أو تعديلها أو حذفها في أي وقت عبر <a href="mailto:support@samahcare.com" style="color:#D97706;font-weight:600;">support@samahcare.com</a>.</p>
            </div>

            <div class="contact-cta" id="contact">
                <h3><i class="fas fa-envelope me-2"></i>هل لديك سؤال حول الخصوصية؟</h3>
                <p>فريق الدعم جاهز للرد على استفساراتك.</p>
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