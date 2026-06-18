<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار RTL الحجز - تصميم احترافي</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/website-modern.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
        }
        .demo-header {
            text-align: center;
            padding: 40px 20px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .demo-header h1 {
            color: #fff;
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .demo-header p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
        }
        .features-list {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .feature-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            border-radius: 25px;
            color: #93c5fd;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .feature-item i {
            margin-left: 8px;
        }
    </style>
</head>
<body>
    <div class="demo-header">
        <h1>تصميم احترافي لقسم الحجز</h1>
        <p>تصميم عصري وتفاعلي مع دعم كامل للغة العربية واتجاه RTL</p>
        <div class="features-list">
            <div class="feature-item"><i class="fas fa-palette"></i> تصميم عصري</div>
            <div class="feature-item"><i class="fas fa-mobile-alt"></i> متجاوب</div>
            <div class="feature-item"><i class="fas fa-language"></i> دعم RTL</div>
            <div class="feature-item"><i class="fas fa-magic"></i> تأثيرات تفاعلية</div>
            <div class="feature-item"><i class="fas fa-shield-alt"></i> احترافي</div>
        </div>
    </div>

    <!-- ============= BOOKING FORM TEST ============= -->
    <section id="booking" class="booking-section">
        <div class="booking-wrapper">

            <div class="booking-info">
                <div class="section-kicker"><i class="fas fa-calendar-alt"></i> احجز الآن</div>
                <h2 class="section-title">احجز سيارتك اليوم</h2>
                <p class="section-sub">أرسل طلبك وسنتواصل معك خلال أقل من ساعة لتأكيد الحجز</p>

                <div class="booking-info-item">
                    <div class="booking-info-icon"><i class="fas fa-phone-alt"></i></div>
                    <div>
                        <div class="booking-info-label">رقم الهاتف</div>
                        <div class="booking-info-value phone-number">0597492182</div>
                        <div class="booking-info-value phone-number">0599930120</div>
                    </div>
                </div>
                
                <div class="booking-info-item">
                    <div class="booking-info-icon"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="booking-info-label">ساعات العمل</div>
                        <div class="booking-info-value">يومياً من 8:00 صباحاً - 10:00 مساءً</div>
                    </div>
                </div>
                
                <div class="booking-info-item">
                    <div class="booking-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <div class="booking-info-label">العنوان</div>
                        <div class="booking-info-value">البيرة، بيت المحسري، بجانب جوال</div>
                    </div>
                </div>
                
                <div class="booking-trust">
                    <div class="trust-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>بياناتك آمنة</span>
                    </div>
                    <div class="trust-badge">
                        <i class="fas fa-check-circle"></i>
                        <span>تأكيد سريع</span>
                    </div>
                </div>
            </div>

            <div class="booking-form-card">
                <div class="booking-form-title">طلب حجز سيارة</div>
                <div class="booking-form-sub">جميع الحقول المضمّنة بـ * مطلوبة</div>

                <div class="alert-success"><i class="fas fa-check-circle"></i> تم إرسال طلبك بنجاح! سنتواصل معك قريباً.</div>

                <form method="POST" action="#" enctype="multipart/form-data" id="bookingForm" dir="rtl">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">الاسم الكامل *</label>
                            <input type="text" class="form-control" name="customer_name" placeholder="أدخل اسمك الكامل" dir="auto" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">رقم الهاتف *</label>
                            <input type="tel" class="form-control" name="phone" placeholder="رقم الهاتف 05XXXXXXXX" dir="ltr" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">من تاريخ *</label>
                            <input type="date" class="form-control" name="start_date" dir="auto" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">إلى تاريخ *</label>
                            <input type="date" class="form-control" name="end_date" dir="auto" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">اختر السيارة *</label>
                        <select class="form-control" name="car_id" id="carSelect" required>
                            <option value="">-- اختر سيارة --</option>
                            <option value="1">تويوتا ياريس — 150 شيكل/يوم</option>
                            <option value="2">هوندا سيفيك — 200 شيكل/يوم</option>
                            <option value="3">نيسان صني — 180 شيكل/يوم</option>
                        </select>
                    </div>

                    <!-- Selected Deal Display -->
                    <div class="selected-deal-display" id="selectedDealDisplay" style="display:none;">
                        <div class="selected-deal-badge">
                            <i class="fas fa-tag"></i> 
                            <span id="selectedDealText">الباقة المختارة</span>
                        </div>
                        <div class="selected-deal-info">
                            <div class="selected-deal-days" id="selectedDealDays">-</div>
                            <div class="selected-deal-price" id="selectedDealPrice">₪0</div>
                        </div>
                        <button type="button" class="selected-deal-clear" onclick="clearSelectedDeal()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">صورة الهوية *</label>
                            <input type="file" class="form-control" name="id_image" accept="image/*" required>
                            <div class="form-hint">JPG أو PNG · حد أقصى 5MB</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">صورة رخصة القيادة *</label>
                            <input type="file" class="form-control" name="license_image" accept="image/*" required>
                            <div class="form-hint">JPG أو PNG · حد أقصى 5MB</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">ملاحظات</label>
                        <textarea class="form-control" name="notes" placeholder="أي متطلبات أو تفاصيل إضافية..." dir="auto"></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> إرسال الطلب
                    </button>
                    
                    <div class="booking-divider">
                        <span>أو</span>
                    </div>
                    
                    <a href="#" class="btn-whatsapp" target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp"></i>
                        احجز عبر واتساب
                    </a>
                </form>
            </div>
        </div>
    </section>

    <script>
    // Set minimum date to today
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.querySelectorAll('input[type="date"]').forEach(function(input) {
            input.setAttribute('min', today);
        });
    });
    </script>
</body>
</html>
