@extends('frontend.layouts.app-v2')

@section('title', 'للأعمال - ' . ($siteSettings['site_name'] ?? 'JeniCare'))
@section('meta_description', 'JeniCare للأعمال - حلول متكاملة للصوالين والعيادات والمشتركين التجاريين. أسعار جملة، شحن مجاني، ودعم فني.')

@section('content')
<section style="position:relative;overflow:hidden;padding:140px 0 60px;background:linear-gradient(135deg,#FDF2F8 0%,#FCE7F3 50%,#FFF1F2 100%);">
    <div style="position:absolute;top:-100px;right:-100px;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(219,39,119,0.08) 0%,transparent 70%);"></div>
    <div style="position:absolute;bottom:-80px;left:-80px;width:250px;height:250px;border-radius:50%;background:radial-gradient(circle,rgba(236,72,153,0.06) 0%,transparent 70%);"></div>
    <div class="container" style="position:relative;z-index:1;">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h1 style="font-size:2rem;font-weight:900;color:var(--gray-800);margin-bottom:12px;line-height:1.2;">
                    JeniCare <span style="color:var(--pink-600);">للأعمال</span>
                </h1>
                <p style="color:var(--gray-500);font-size:1.05rem;line-height:1.7;margin-bottom:24px;max-width:540px;">
                    حلول متكاملة للصوالين والعيادات والمشتركين التجاريين. أسعار جملة تنافسية، شحن مجاني للطلبات الكبيرة، ودعم فني مخصص.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;gap:8px;padding:14px 32px;background:linear-gradient(135deg,var(--pink-600),var(--pink-500));color:#fff;border:none;border-radius:50px;font-weight:700;font-size:.95rem;text-decoration:none;box-shadow:0 6px 20px rgba(219,39,119,0.25);transition:all .3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                        <i class="fas fa-user-plus"></i> سجل كشريك تجاري
                    </a>
                    <a href="{{ route('contact') }}" style="display:inline-flex;align-items:center;gap:8px;padding:14px 32px;background:#fff;color:var(--pink-600);border:2px solid var(--pink-200);border-radius:50px;font-weight:700;font-size:.95rem;text-decoration:none;transition:all .3s;" onmouseover="this.style.borderColor='var(--pink-600)'" onmouseout="this.style.borderColor='var(--pink-200)'">
                        <i class="fas fa-headset"></i> تواصل معنا
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:200px;height:200px;border-radius:50%;background:linear-gradient(135deg,var(--pink-100),var(--pink-200));font-size:5rem;color:var(--pink-600);">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<section style="padding:60px 0;background:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="font-size:1.5rem;font-weight:800;color:var(--gray-800);margin-bottom:6px;">مميزات برنامج <span style="color:var(--pink-600);">B2B</span></h2>
            <p style="color:var(--gray-500);font-size:.95rem;">كل ما تحتاجه لتطوير عملك في مجال العناية بالشعر والبشرة</p>
        </div>
        <div class="row g-4 justify-content-center" style="max-width:900px;margin:0 auto;">
            <div class="col-md-6 col-lg-4">
                <div style="text-align:center;padding:28px 20px;background:#fff;border-radius:16px;border:1px solid var(--gray-100);height:100%;transition:all .3s;" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,.08)';this.style.transform='translateY(-3px)'" onmouseout="this.style.boxShadow='none';this.style.transform='none'">
                    <div style="width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,var(--pink-50),var(--pink-100));display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:1.3rem;color:var(--pink-600);">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <h3 style="font-size:1rem;font-weight:700;color:var(--gray-800);margin-bottom:6px;">أسعار الجملة</h3>
                    <p style="color:var(--gray-500);font-size:.85rem;line-height:1.6;margin:0;">خصومات تصل إلى 40% على الطلبات الكبيرة مع نظام تسعير تدريجي حسب الكمية</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div style="text-align:center;padding:28px 20px;background:#fff;border-radius:16px;border:1px solid var(--gray-100);height:100%;transition:all .3s;" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,.08)';this.style.transform='translateY(-3px)'" onmouseout="this.style.boxShadow='none';this.style.transform='none'">
                    <div style="width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,#E0F2FE,#BAE6FD);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:1.3rem;color:#0284C7;">
                        <i class="fas fa-truck-fast"></i>
                    </div>
                    <h3 style="font-size:1rem;font-weight:700;color:var(--gray-800);margin-bottom:6px;">شحن مجاني</h3>
                    <p style="color:var(--gray-500);font-size:.85rem;line-height:1.6;margin:0;">شحن مجاني للطلبات التي تتجاوز 500 ₪ مع توصيل لجميع محافظات فلسطين</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div style="text-align:center;padding:28px 20px;background:#fff;border-radius:16px;border:1px solid var(--gray-100);height:100%;transition:all .3s;" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,.08)';this.style.transform='translateY(-3px)'" onmouseout="this.style.boxShadow='none';this.style.transform='none'">
                    <div style="width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,#FEF3C7,#FDE68A);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:1.3rem;color:#D97706;">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3 style="font-size:1rem;font-weight:700;color:var(--gray-800);margin-bottom:6px;">الدفع بالآجل</h3>
                    <p style="color:var(--gray-500);font-size:.85rem;line-height:1.6;margin:0;">نظام ائتماني مرن مع إمكانية الدفع خلال 30 يوماً للعملاء المعتمدين</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div style="text-align:center;padding:28px 20px;background:#fff;border-radius:16px;border:1px solid var(--gray-100);height:100%;transition:all .3s;" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,.08)';this.style.transform='translateY(-3px)'" onmouseout="this.style.boxShadow='none';this.style.transform='none'">
                    <div style="width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,#DCFCE7,#BBF7D0);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:1.3rem;color:#16A34A;">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 style="font-size:1rem;font-weight:700;color:var(--gray-800);margin-bottom:6px;">دعم مخصص</h3>
                    <p style="color:var(--gray-500);font-size:.85rem;line-height:1.6;margin:0;">مدير حساب مخصص يتابع طلباتك ويقدم لك الاستشارات والدعم</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div style="text-align:center;padding:28px 20px;background:#fff;border-radius:16px;border:1px solid var(--gray-100);height:100%;transition:all .3s;" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,.08)';this.style.transform='translateY(-3px)'" onmouseout="this.style.boxShadow='none';this.style.transform='none'">
                    <div style="width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,#F3E8FF,#E9D5FF);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:1.3rem;color:#9333EA;">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h3 style="font-size:1rem;font-weight:700;color:var(--gray-800);margin-bottom:6px;">فواتير ضريبية</h3>
                    <p style="color:var(--gray-500);font-size:.85rem;line-height:1.6;margin:0;">فواتير رسمية معتمدة لجميع الطلبات لتسهيل المحاسبة والضرائب</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div style="text-align:center;padding:28px 20px;background:#fff;border-radius:16px;border:1px solid var(--gray-100);height:100%;transition:all .3s;" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,.08)';this.style.transform='translateY(-3px)'" onmouseout="this.style.boxShadow='none';this.style.transform='none'">
                    <div style="width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,#FEE2E2,#FECACA);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:1.3rem;color:#DC2626;">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <h3 style="font-size:1rem;font-weight:700;color:var(--gray-800);margin-bottom:6px;">طلبات مخصصة</h3>
                    <p style="color:var(--gray-500);font-size:.85rem;line-height:1.6;margin:0;">نظام RFQ لتقديم طلبات عروض أسعار للمنتجات والكميات المخصصة</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section style="padding:60px 0;background:linear-gradient(135deg,var(--pink-600),var(--pink-700));color:#fff;text-align:center;">
    <div class="container" style="max-width:600px;">
        <h2 style="font-size:1.6rem;font-weight:800;margin-bottom:8px;">جاهز لتطوير أعمالك؟</h2>
        <p style="opacity:.85;margin-bottom:24px;font-size:1.05rem;">انضم إلى شركائنا واستمتع بأسعار خاصة ومزايا حصرية</p>
        <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;gap:8px;padding:14px 40px;background:#fff;color:var(--pink-600);border:none;border-radius:50px;font-weight:700;font-size:.95rem;text-decoration:none;cursor:pointer;transition:all .3s;box-shadow:0 6px 20px rgba(0,0,0,0.15);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
            <i class="fas fa-rocket"></i> ابدأ الآن
        </a>
    </div>
</section>

<section style="padding:60px 0;background:var(--gray-50);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="font-size:1.5rem;font-weight:800;color:var(--gray-800);margin-bottom:6px;">من يمكنه <span style="color:var(--pink-600);">الانضمام</span>؟</h2>
        </div>
        <div class="row g-4 justify-content-center" style="max-width:800px;margin:0 auto;">
            <div class="col-6 col-md-3">
                <div style="text-align:center;padding:24px;">
                    <div style="font-size:2.5rem;margin-bottom:12px;">💇</div>
                    <h4 style="font-size:.95rem;font-weight:700;color:var(--gray-800);margin-bottom:4px;">صوالين التجميل</h4>
                    <p style="color:var(--gray-500);font-size:.8rem;line-height:1.5;margin:0;">احصل على منتجات العناية المهنية بأسعار خاصة</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div style="text-align:center;padding:24px;">
                    <div style="font-size:2.5rem;margin-bottom:12px;">🏥</div>
                    <h4 style="font-size:.95rem;font-weight:700;color:var(--gray-800);margin-bottom:4px;">العيادات الجلدية</h4>
                    <p style="color:var(--gray-500);font-size:.8rem;line-height:1.5;margin:0;">منتجات طبية وتجميلية معتمدة لعيادات البشرة</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div style="text-align:center;padding:24px;">
                    <div style="font-size:2.5rem;margin-bottom:12px;">🧖</div>
                    <h4 style="font-size:.95rem;font-weight:700;color:var(--gray-800);margin-bottom:4px;">منتجعات السبأ</h4>
                    <p style="color:var(--gray-500);font-size:.8rem;line-height:1.5;margin:0;">حلول متكاملة للعناية في المنتجعات الصحية</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div style="text-align:center;padding:24px;">
                    <div style="font-size:2.5rem;margin-bottom:12px;">🏪</div>
                    <h4 style="font-size:.95rem;font-weight:700;color:var(--gray-800);margin-bottom:4px;">تجار التجزئة</h4>
                    <p style="color:var(--gray-500);font-size:.8rem;line-height:1.5;margin:0;">أسعار جملة وهامش ربح ممتاز للموزعين</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
