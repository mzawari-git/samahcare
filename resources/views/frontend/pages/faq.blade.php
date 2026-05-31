@extends($layoutPath)

@section('title', 'الأسئلة الشائعة - ' . ($siteSettings['site_name'] ?? 'سماح كير'))
@section('meta_description', 'الأسئلة الشائعة حول خدمات سماح كير.')

@section('content')

<section class="py-20 lg:py-28" style="background:var(--surface-alt);">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-black mb-4" style="color:var(--ink);">الأسئلة <span class="gradient-text">الشائعة</span></h1>
        <p class="text-base mb-8" style="color:var(--ink-muted);">إجابات على استفساراتكم حول خدماتنا</p>
        <div class="max-w-md mx-auto relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2" style="color:var(--ink-dim);"></i>
            <input type="text" id="faqSearch" placeholder="ابحث عن سؤال..." onkeyup="searchFAQ()" style="width:100%;padding:0.85rem 1.25rem 0.85rem 2.8rem;border:1px solid rgba(0,0,0,0.08);border-radius:9999px;font-size:0.9rem;background:white;color:var(--ink);">
        </div>
    </div>
</section>

<div class="max-w-3xl mx-auto px-4 py-16">

    <div class="faq-category mb-12" data-category="b2b">
        <h2 class="text-xl font-black mb-6 flex items-center gap-3" style="color:var(--ink);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:var(--brand-50);">
                <i class="fas fa-building" style="color:var(--brand-500);"></i>
            </div>
            طلبات الجملة والشركات (B2B)
        </h2>

        <div class="faq-item rounded-2xl mb-3 overflow-hidden" style="background:white;border:1px solid rgba(0,0,0,0.04);">
            <div class="faq-question px-6 py-5 cursor-pointer flex items-center justify-between transition-all hover:bg-gray-50" onclick="toggleFAQ(this)" style="font-weight:700;color:var(--ink);">
                <span>تفاصيل الطلب بكميات كبيرة (لصالونات التجميل والشركات)</span>
                <i class="fas fa-chevron-down text-sm transition-transform duration-300" style="color:var(--brand-500);"></i>
            </div>
            <div class="faq-answer" style="max-height:0;overflow:hidden;transition:max-height 0.3s ease-out;">
                <div class="px-6 pb-6" style="color:var(--ink-muted);line-height:1.8;">
                    <p class="mb-4">نظام مخصص للشركات (B2B) وطلبات التسعير (RFQ): لا تقتصر منصة {{ $siteSettings['site_name'] ?? 'سماح كير' }} على البيع المباشر للأفراد (B2C)، بل تم بناء وحدة برمجية متكاملة ومستقلة تماماً مخصصة للشركات والصالونات (B2B).</p>

                    <h4 class="font-bold mb-2 flex items-center gap-2" style="color:var(--ink);"><i class="fas fa-check-circle text-sm" style="color:#22c55e;"></i> نظام طلبات عروض الأسعار (RFQ)</h4>
                    <p class="mb-4">تتيح هذه الوحدة لأصحاب الصالونات إنشاء حسابات تجارية، وتقديم طلبات عروض أسعار رسمية (RFQ) للحصول على أفضل التكلفات للكميات الضخمة.</p>

                    <div class="rounded-xl p-4 mb-4" style="background:var(--brand-50);border:1px solid var(--brand-100);">
                        <h5 class="font-bold mb-2 flex items-center gap-2" style="color:var(--brand-700);"><i class="fas fa-calculator"></i> محرك التسعير الذكي (Pricing Engine)</h5>
                        <p class="mb-0">بدلاً من التفاوض اليدوي على الأسعار، تعمل المنصة من خلال "محرك تسعير" متقدم. يقوم هذا النظام بقراءة الكميات المدرجة في سلة المشتريات وتطبيق هيكل خصومات تدريجي وآلي؛ فكلما زادت الكمية، انخفض سعر القطعة الواحدة بشكل فوري وشفاف.</p>
                    </div>

                    <h4 class="font-bold mb-2 flex items-center gap-2" style="color:var(--ink);"><i class="fas fa-check-circle text-sm" style="color:#22c55e;"></i> إدارة مخزون متقدمة</h4>
                    <ul class="list-none p-0 space-y-2">
                        <li class="p-3 rounded-xl" style="background:var(--surface-alt);border-right:3px solid var(--brand-500);">دقة عالية في عرض المنتجات المتوفرة فعلياً في المستودعات</li>
                        <li class="p-3 rounded-xl" style="background:var(--surface-alt);border-right:3px solid var(--brand-500);">منع بيع منتجات غير متاحة</li>
                        <li class="p-3 rounded-xl" style="background:var(--surface-alt);border-right:3px solid var(--brand-500);">تسليم طلبات الصالونات في الوقت المحدد دون تأخير</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="faq-category mb-12" data-category="security">
        <h2 class="text-xl font-black mb-6 flex items-center gap-3" style="color:var(--ink);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#eff6ff;">
                <i class="fas fa-shield-alt" style="color:#3b82f6;"></i>
            </div>
            حماية البيانات والأمان
        </h2>

        <div class="faq-item rounded-2xl mb-3 overflow-hidden" style="background:white;border:1px solid rgba(0,0,0,0.04);">
            <div class="faq-question px-6 py-5 cursor-pointer flex items-center justify-between transition-all hover:bg-gray-50" onclick="toggleFAQ(this)" style="font-weight:700;color:var(--ink);">
                <span>تفاصيل حماية البيانات الشخصية والبنكية</span>
                <i class="fas fa-chevron-down text-sm transition-transform duration-300" style="color:var(--brand-500);"></i>
            </div>
            <div class="faq-answer" style="max-height:0;overflow:hidden;transition:max-height 0.3s ease-out;">
                <div class="px-6 pb-6" style="color:var(--ink-muted);line-height:1.8;">
                    <p class="mb-4">نحن نلتزم بأعلى معايير الأمان لحماية بياناتك الشخصية والمالية. إليك التفاصيل الكاملة لنظام الحماية المتقدم لدينا:</p>

                    <div class="rounded-xl p-4 mb-4" style="background:#eff6ff;border:1px solid #bfdbfe;">
                        <h5 class="font-bold mb-2 flex items-center gap-2" style="color:#1e40af;"><i class="fas fa-shield-virus"></i> الحماية من هجمات حجب الخدمة (DDoS Protection)</h5>
                        <p class="mb-0">المنصة مزودة بجدار حماية متقدم لصد هجمات حجب الخدمة الموزعة (DDoS). هذا يعني أن الموقع محمي ضد محاولات إغراق السيرفر بزيارات وهمية تهدف إلى تعطيله.</p>
                    </div>

                    <h4 class="font-bold mb-2 flex items-center gap-2" style="color:var(--ink);"><i class="fas fa-check-circle text-sm" style="color:#22c55e;"></i> تقييد معدل الطلبات (Rate Limiting)</h4>
                    <p class="mb-4">يستخدم النظام تقنية تقييد معدل الطلبات لمنع أي نشاط آلي مكثف أو روبوتات خبيثة من استغلال الموقع أو محاولة تخمين كلمات المرور.</p>

                    <h4 class="font-bold mb-2 flex items-center gap-2" style="color:var(--ink);"><i class="fas fa-check-circle text-sm" style="color:#22c55e;"></i> سياسة أمن المحتوى (CSP)</h4>
                    <p class="mb-4">تُطبق المنصة سياسة صارمة لأمن المحتوى (CSP). تعتبر هذه الطبقة الأمنية حاسمة لمنع ثغرات الحقن البرمجي (مثل XSS).</p>

                    <div class="rounded-xl p-4 mb-4" style="background:#eff6ff;border:1px solid #bfdbfe;">
                        <h5 class="font-bold mb-2 flex items-center gap-2" style="color:#1e40af;"><i class="fas fa-robot"></i> فحص الامتثال والأمان (AI Compliance)</h5>
                        <p class="mb-0">تحتوي المنصة على وحدة برمجية متخصصة في فحص الامتثال (AI Compliance). تعمل هذه الوحدة على مراقبة العمليات للتأكد من توافقها الدائم مع معايير الأمان وسياسات الخصوصية.</p>
                    </div>

                    <h4 class="font-bold mb-2 flex items-center gap-2" style="color:var(--ink);"><i class="fas fa-check-circle text-sm" style="color:#22c55e;"></i> عزل البيانات الهيكلي</h4>
                    <ul class="list-none p-0 space-y-2">
                        <li class="p-3 rounded-xl" style="background:var(--surface-alt);border-right:3px solid #3b82f6;">يقلل من المخاطر الأمنية</li>
                        <li class="p-3 rounded-xl" style="background:var(--surface-alt);border-right:3px solid #3b82f6;">يضمن بقاء بيانات العملاء في بيئة مشفرة ومعزولة</li>
                        <li class="p-3 rounded-xl" style="background:var(--surface-alt);border-right:3px solid #3b82f6;">يمنع الوصول غير المصرح به إلى المعلومات الحساسة</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="no-results text-center py-12" id="noResults" style="display:none;">
        <i class="fas fa-search text-4xl mb-4" style="color:var(--ink-dim);opacity:0.3;"></i>
        <h4 class="font-bold mb-2" style="color:var(--ink);">لم يتم العثور على نتائج</h4>
        <p style="color:var(--ink-muted);">جرب البحث بكلمات مختلفة أو تواصل معنا مباشرة</p>
    </div>

    <div class="rounded-2xl p-10 text-center mt-8" style="background:var(--brand-50);">
        <h3 class="text-xl font-black mb-3" style="color:var(--ink);">لم تجد إجابة لسؤالك؟</h3>
        <p class="mb-6" style="color:var(--ink-muted);">فريق دعم العملاء جاهز لمساعدتك في أي استفسار</p>
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-full font-bold text-sm text-white transition-all hover:opacity-90" style="background:var(--gradient-primary);">
            <i class="fas fa-envelope"></i> تواصل معنا
        </a>
    </div>
</div>

<script>
function toggleFAQ(element) {
    const item = element.parentElement;
    const isActive = item.classList.contains('active');
    document.querySelectorAll('.faq-item').forEach(faq => {
        faq.classList.remove('active');
        faq.querySelector('.faq-answer').style.maxHeight = '0';
        faq.querySelector('.faq-question i').style.transform = 'rotate(0deg)';
    });
    if (!isActive) {
        item.classList.add('active');
        const answer = item.querySelector('.faq-answer');
        answer.style.maxHeight = answer.scrollHeight + 'px';
        item.querySelector('.faq-question i').style.transform = 'rotate(180deg)';
    }
}

function searchFAQ() {
    const searchTerm = document.getElementById('faqSearch').value.toLowerCase();
    const items = document.querySelectorAll('.faq-item');
    const categories = document.querySelectorAll('.faq-category');
    let hasResults = false;
    items.forEach(item => {
        const question = item.querySelector('.faq-question span').textContent.toLowerCase();
        const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
        if (question.includes(searchTerm) || answer.includes(searchTerm)) { item.style.display = 'block'; hasResults = true; }
        else { item.style.display = 'none'; }
    });
    categories.forEach(category => {
        const visibleItems = category.querySelectorAll('.faq-item[style="display: block;"]').length;
        if (visibleItems === 0 && searchTerm !== '') { category.style.display = 'none'; }
        else { category.style.display = 'block'; }
    });
    const noResults = document.getElementById('noResults');
    if (!hasResults && searchTerm !== '') { noResults.style.display = 'block'; }
    else { noResults.style.display = 'none'; }
}
</script>

@endsection
