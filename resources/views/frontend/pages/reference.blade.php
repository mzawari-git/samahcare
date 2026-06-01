<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
    <title>دليل الجلسات - مرجع داخلي</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3A5A40',
                        secondary: '#C19A6B',
                        accent: '#F3EFE7',
                        dark: '#1B2E22',
                        light: '#FAFAF8'
                    },
                    fontFamily: {
                        sans: ['Tajawal', 'sans-serif'],
                        serif: ['Amiri', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #FAFAF8;
            scroll-behavior: smooth;
        }
        body.modal-open {
            overflow: hidden;
        }
        .hero-bg {
            background: linear-gradient(rgba(27, 46, 34, 0.75), rgba(58, 90, 64, 0.65)), url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=1920&auto=format&fit=crop') center/cover no-repeat;
            background-attachment: fixed;
        }
        .glass-panel {
            background: rgba(250, 250, 248, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(193, 154, 107, 0.2);
        }
        .tab-active {
            border-bottom: 3px solid #C19A6B;
            color: #3A5A40;
            font-weight: bold;
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #F3EFE7; }
        ::-webkit-scrollbar-thumb { background: #C19A6B; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #3A5A40; }
        
        #service-modal {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .modal-enter {
            opacity: 1;
            transform: translateY(0);
        }
        .modal-leave {
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
        }
    </style>
</head>
<body class="text-gray-800 antialiased font-sans">

    <nav class="fixed w-full z-40 glass-panel shadow-sm transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <i class="fa-solid fa-leaf text-secondary text-3xl"></i>
                    <div>
                        <h1 class="text-2xl font-bold text-primary font-serif">مركز سماح</h1>
                        <p class="text-xs text-gray-500 tracking-wider">دليل الجلسات - مرجع داخلي</p>
                    </div>
                </div>
                <div class="hidden md:flex space-x-8 space-x-reverse items-center">
                    <a href="#home" class="text-gray-700 hover:text-primary transition font-medium">الرئيسية</a>
                    <a href="#about" class="text-gray-700 hover:text-primary transition font-medium">عن المركز</a>
                    <a href="#services" class="text-gray-700 hover:text-primary transition font-medium">دليل الخدمات</a>
                </div>
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-primary text-2xl focus:outline-none">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-light border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#home" class="block px-3 py-2 text-gray-700 hover:bg-accent rounded-md">الرئيسية</a>
                <a href="#services" class="block px-3 py-2 text-gray-700 hover:bg-accent rounded-md">الخدمات</a>
            </div>
        </div>
    </nav>

    <section id="home" class="hero-bg h-screen flex items-center justify-center relative pt-20">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-16">
            <span class="text-secondary font-bold tracking-widest uppercase mb-4 block">مرجع داخلي للخبيرات</span>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 font-serif leading-tight">
                دليل بروتوكولات الجلسات <br>التدريبية والمرجعية
            </h1>
            <p class="text-lg md:text-xl text-gray-200 mb-10 font-light">
                مرجع شامل ومفصل لجميع جلسات المركز، مصمم خصيصاً للخبيرات والأخصائيات. يحتوي على خطوات العمل، المنتجات المستخدمة، والصور التوضيحية.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#services" class="bg-secondary text-white px-8 py-3 rounded-full font-bold hover:bg-white hover:text-primary transition duration-300 shadow-lg">ابدئي التصفح</a>
            </div>
        </div>
    </section>

    <section id="about" class="py-20 bg-light pt-24 lg:pt-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-primary mb-6 font-serif">الهندسة التشغيلية للجمال</h2>
                    <div class="w-20 h-1 bg-secondary mb-6"></div>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        في "مركز سماح"، نؤمن أن النمو المستدام والجمال الحقيقي لا يتطلبان بالضرورة تدخلات جراحية قاسية. لقد قمنا بتصميم خدماتنا بدقة بالغة، معتمدين على الإدارة الذكية للموارد.
                    </p>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        نحن ندمج الطابع الطبيعي المريح لـ "وادي سلامة" مع أحدث تقنيات الليزر (ICE PLUS AR TECHNO) والبروتوكولات الطبية المعتمدة عالمياً.
                    </p>
                    <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary">
                        <h4 class="font-bold text-primary mb-2"><i class="fa-solid fa-info-circle text-secondary ml-2"></i>ملاحظة هامة</h4>
                        <p class="text-gray-700 text-sm leading-relaxed">هذا الدليل مخصص للاستخدام الداخلي فقط. يرجى عدم مشاركة الرابط مع العملاء أو نشره على وسائل التواصل الاجتماعي.</p>
                    </div>
                </div>
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?q=80&w=600&auto=format&fit=crop" alt="مركز سماح من الداخل" class="rounded-2xl shadow-2xl z-10 relative">
                    <div class="absolute -bottom-6 -right-6 w-full h-full border-4 border-secondary rounded-2xl z-0"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-20 bg-accent relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-primary mb-4 font-serif">دليل العمليات والبروتوكولات</h2>
                <div class="w-24 h-1 bg-secondary mx-auto mb-4"></div>
                <p class="text-gray-600 max-w-2xl mx-auto">تعرفي على تفاصيل جلساتنا العلاجية والتجميلية، واضغطي على الجلسة لعرض صفحتها الكاملة.</p>
            </div>

            <div class="flex flex-wrap justify-center mb-12 border-b border-gray-300">
                <button onclick="switchTab('face')" id="tab-face" class="tab-btn tab-active px-6 py-3 text-lg font-medium transition-colors duration-300 flex items-center gap-2 mx-2">
                    <i class="fa-solid fa-spa"></i> العناية بالوجه
                </button>
                <button onclick="switchTab('body')" id="tab-body" class="tab-btn text-gray-500 hover:text-primary px-6 py-3 text-lg font-medium transition-colors duration-300 flex items-center gap-2 mx-2">
                    <i class="fa-solid fa-leaf"></i> العناية بالجسم
                </button>
                <button onclick="switchTab('spa')" id="tab-spa" class="tab-btn text-gray-500 hover:text-primary px-6 py-3 text-lg font-medium transition-colors duration-300 flex items-center gap-2 mx-2">
                    <i class="fa-solid fa-hands-bubbles"></i> سبا الأطراف
                </button>
            </div>

            <div id="content-face" class="tab-content grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer" onclick="openModal('data-face-1')">
                    <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?q=80&w=400&auto=format&fit=crop" class="w-full h-48 object-cover">
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-primary mb-2">التنظيف العميق وتوازن البشرة</h3>
                        <p class="text-gray-500 text-sm mb-4">بروتوكول Christina للتحكم بالدهون وتنظيف المسام الواسعة.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer" onclick="openModal('data-face-2')">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=400&auto=format&fit=crop" class="w-full h-48 object-cover">
                        <span class="absolute top-4 right-4 bg-secondary text-white text-xs px-3 py-1 rounded-full font-bold shadow">خيار العرائس</span>
                    </div>
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-primary mb-2">النضارة الفورية للعرائس</h3>
                        <p class="text-gray-500 text-sm mb-4">بروتوكول GIGI Ester C لتوهج فوري وتفتيح التصبغات.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer" onclick="openModal('data-face-3')">
                    <img src="https://images.unsplash.com/photo-1590439471364-192aa70c0b53?q=80&w=400&auto=format&fit=crop" class="w-full h-48 object-cover">
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-primary mb-2">التقشير الزجاجي (Dermaplaning)</h3>
                        <p class="text-gray-500 text-sm mb-4">إزالة الشعر الوبري والخلايا الميتة بشفرة طبية لبشرة زجاجية.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer" onclick="openModal('data-face-4')">
                    <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?q=80&w=400&auto=format&fit=crop" class="w-full h-48 object-cover">
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-primary mb-2">الشد الفوري بخيوط الحرير</h3>
                        <p class="text-gray-500 text-sm mb-4">بروتوكول Christina Silk الفاخر لملء الخطوط الدقيقة.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-face-5')">
                    <span class="absolute top-4 right-4 bg-green-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?q=80&w=400&auto=format&fit=crop" class="w-full h-48 object-cover relative">
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-primary mb-2">الميزوثيرابي السطحي (Dermapen)</h3>
                        <p class="text-gray-500 text-sm mb-4">تحفيز الكولاجين بالوخز الدقيق لعلاج الندبات والمسام.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-face-6')">
                    <span class="absolute top-4 right-4 bg-secondary text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">دليل مصور</span>
                    <img src="https://images.unsplash.com/photo-1556228578-0d85b1a4d571?q=80&w=400&auto=format&fit=crop" class="w-full h-48 object-cover relative">
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-primary mb-2">التقشير البحري (Rose de Mer)</h3>
                        <p class="text-gray-500 text-sm mb-4">تقشير طبيعي 100% لتجديد البشرة وعلاج التصبغات العميقة.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض الدليل المصور <i class="fa-solid fa-image mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-face-7')">
                    <span class="absolute top-4 right-4 bg-blue-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=400&auto=format&fit=crop" class="w-full h-48 object-cover relative">
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-primary mb-2">العلاج بالضوء المرئي (LED)</h3>
                        <p class="text-gray-500 text-sm mb-4">تحفيز الخلايا بأطوال موجية مختلفة لعلاج حب الشباب والتجاعيد.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-face-8')">
                    <span class="absolute top-4 right-4 bg-purple-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?q=80&w=400&auto=format&fit=crop" class="w-full h-48 object-cover relative">
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-primary mb-2">فاشيال الأكسجين (Oxygen Facial)</h3>
                        <p class="text-gray-500 text-sm mb-4">ضخ أكسجين نقي مع سيرومات لترطيب عميق ونضارة فورية.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-face-9')">
                    <span class="absolute top-4 right-4 bg-orange-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <img src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?q=80&w=400&auto=format&fit=crop" class="w-full h-48 object-cover relative">
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-primary mb-2">التقشير الكيميائي (Chemical Peel)</h3>
                        <p class="text-gray-500 text-sm mb-4">أحماض AHA/BHA لتجديد البشرة وعلاج التصبغات والندبات.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-face-10')">
                    <span class="absolute top-4 right-4 bg-pink-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?q=80&w=400&auto=format&fit=crop" class="w-full h-48 object-cover relative">
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-primary mb-2">الشد بالتيار الميكروي (Microcurrent)</h3>
                        <p class="text-gray-500 text-sm mb-4">تحفيز عضلات الوجه بتيار منخفض لشد طبيعي فوري.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>
            </div>

            <div id="content-body" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer" onclick="openModal('data-body-1')">
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center text-secondary text-2xl mb-4"><i class="fa-solid fa-fire"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">السنفرة وتلميع الجسم</h3>
                        <p class="text-gray-500 text-sm mb-4">تهيئة الجلد لجهاز الليزر وإزالة التقرن الجريبي.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer" onclick="openModal('data-body-2')">
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center text-secondary text-2xl mb-4"><i class="fa-solid fa-wind"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">تنظيف الظهر العميق</h3>
                        <p class="text-gray-500 text-sm mb-4">علاج حبوب الظهر والزيوان بالبخار (Back Facial).</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer" onclick="openModal('data-body-3')">
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center text-secondary text-2xl mb-4"><i class="fa-solid fa-spa"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">المساج اللمفاوي العطري</h3>
                        <p class="text-gray-500 text-sm mb-4">طقس وادي سلامة للاسترخاء وطرد السموم.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-body-4')">
                    <span class="absolute top-4 right-4 bg-green-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center text-amber-700 text-2xl mb-4"><i class="fa-solid fa-tree"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">المساج الخشبي (Maderotherapy)</h3>
                        <p class="text-gray-500 text-sm mb-4">نحت الجسم الكولومبي بالأخشاب وتكسير السيلوليت.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-body-5')">
                    <span class="absolute top-4 right-4 bg-secondary text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">دليل مصور</span>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center text-white text-2xl mb-4"><i class="fa-solid fa-gem"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">المساج بالأحجار الساخنة</h3>
                        <p class="text-gray-500 text-sm mb-4">طقس علاجي بالأحجار البركانية لإذابة التوتر العضلي.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض الدليل المصور <i class="fa-solid fa-image mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-body-6')">
                    <span class="absolute top-4 right-4 bg-teal-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-teal-50 rounded-full flex items-center justify-center text-teal-600 text-2xl mb-4"><i class="fa-solid fa-box"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">لف الجسم (Body Wrapping)</h3>
                        <p class="text-gray-500 text-sm mb-4">لف الجسم بالأعشاب والطين لنحت القوام وشد البشرة.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-body-7')">
                    <span class="absolute top-4 right-4 bg-indigo-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600 text-2xl mb-4"><i class="fa-solid fa-wave-square"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">التجويف (Cavitation)</h3>
                        <p class="text-gray-500 text-sm mb-4">تفتيت الدهون بالموجات فوق الصوتية غير الجراحي.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-body-8')">
                    <span class="absolute top-4 right-4 bg-rose-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-rose-50 rounded-full flex items-center justify-center text-rose-600 text-2xl mb-4"><i class="fa-solid fa-bath"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">الحمام المغربي التقليدي</h3>
                        <p class="text-gray-500 text-sm mb-4">طقس التنقية المغربي بالصابون البلدي والكياسة.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>
            </div>

            <div id="content-spa" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer" onclick="openModal('data-spa-1')">
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center text-secondary text-2xl mb-4"><i class="fa-solid fa-droplet"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">علاج التشققات العميقة</h3>
                        <p class="text-gray-500 text-sm mb-4">طقس استشفائي لإزالة الجلد الميت القاسي.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer" onclick="openModal('data-spa-2')">
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center text-secondary text-2xl mb-4"><i class="fa-solid fa-fire-flame-curved"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">ترطيب البارافين الملكي</h3>
                        <p class="text-gray-500 text-sm mb-4">علاج حراري لفتح المسام ودفع الزيوت لأعمق الطبقات.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer" onclick="openModal('data-spa-3')">
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center text-secondary text-2xl mb-4"><i class="fa-solid fa-eye"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">رفع الرموش بالكيراتين</h3>
                        <p class="text-gray-500 text-sm mb-4">Lash Lift & Keratin Tint لعيون جذابة طبيعياً.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-spa-4')">
                    <span class="absolute top-4 right-4 bg-green-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-500 text-2xl mb-4"><i class="fa-solid fa-water"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">سبا ديتوكس فروة الرأس</h3>
                        <p class="text-gray-500 text-sm mb-4">الطقس الياباني لتنظيف الفروة والاسترخاء المائي.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-spa-5')">
                    <span class="absolute top-4 right-4 bg-secondary text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">دليل مصور</span>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-pink-50 rounded-full flex items-center justify-center text-pink-500 text-2xl mb-4"><i class="fa-solid fa-eye"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">تصفيح وتحديد الحواجب</h3>
                        <p class="text-gray-500 text-sm mb-4">Brow Lamination لترتيب وتكثيف الحاجب طبيعياً.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض الدليل المصور <i class="fa-solid fa-image mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-spa-6')">
                    <span class="absolute top-4 right-4 bg-red-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center text-red-600 text-2xl mb-4"><i class="fa-solid fa-hand-sparkles"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">أظافر الجل (Gel Nails)</h3>
                        <p class="text-gray-500 text-sm mb-4">طلاء جل يدوم طويلاً مع العناية بالأظافر والكيوتيكل.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-spa-7')">
                    <span class="absolute top-4 right-4 bg-cyan-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-cyan-50 rounded-full flex items-center justify-center text-cyan-600 text-2xl mb-4"><i class="fa-solid fa-shoe-prints"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">بديكير طبي (Medical Pedicure)</h3>
                        <p class="text-gray-500 text-sm mb-4">علاج الأقدام المتشققة والأظافر الغائرة والفطريات.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col hover:shadow-xl transition-shadow cursor-pointer relative" onclick="openModal('data-spa-8')">
                    <span class="absolute top-4 right-4 bg-yellow-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow z-10">جديد</span>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="w-12 h-12 bg-yellow-50 rounded-full flex items-center justify-center text-yellow-600 text-2xl mb-4"><i class="fa-solid fa-hands"></i></div>
                        <h3 class="text-xl font-bold text-primary mb-2">سبا البارافين للأطراف</h3>
                        <p class="text-gray-500 text-sm mb-4">علاج حراري فاخر لليدين والقدمين لترطيب عميق.</p>
                        <div class="mt-auto bg-primary text-white font-bold text-sm py-2 px-4 rounded-xl text-center w-full">عرض التفاصيل الكاملة <i class="fa-solid fa-arrow-left mr-1"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="service-modal" class="fixed inset-0 bg-light z-50 modal-leave flex flex-col overflow-hidden">
        <div class="bg-white border-b border-gray-200 px-4 py-4 flex justify-between items-center shadow-sm shrink-0">
            <h2 class="text-xl font-bold text-primary font-serif">الدليل التفصيلي للجلسة</h2>
            <button onclick="closeModal()" class="text-gray-600 hover:text-red-600 bg-gray-100 hover:bg-red-50 rounded-full px-4 py-2 flex items-center gap-2 font-bold transition">
                <span>إغلاق</span>
                <i class="fa-solid fa-times text-lg"></i>
            </button>
        </div>
        <div class="overflow-y-auto flex-grow bg-accent">
            <div id="modal-body" class="max-w-4xl mx-auto bg-white min-h-full shadow-2xl"></div>
        </div>
    </div>

    <div id="modal-templates" class="hidden">
        <div id="data-face-1">
            <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">التنظيف العميق وتوازن البشرة</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">60-75 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">بروتوكول صارم للبشرة الدهنية والمختلطة لتنظيف المسام العميقة، التحكم الجذري في الإفرازات الدهنية، وتهدئة البشرة الملتهبة والمعرضة للحبوب دون التسبب بجفافها.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التنظيف المزدوج (Double Cleanse)</h5>
                            <p class="text-gray-600 mb-2">تبليل اليدين والوجه، ثم تدليك الغسول بحركات دائرية لمدة دقيقتين لإزالة الأوساخ السطحية والمكياج.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Christina Bio Phyto Mild Facial Cleanser</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">استعادة التوازن (Toning)</h5>
                            <p class="text-gray-600 mb-2">مسح البشرة بقطنة مبللة بالتونر لتضييق المسام وإعادة توازن الـ pH.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Christina Comodex Purify & Balance Toner</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التقشير والتبخير</h5>
                            <p class="text-gray-600 mb-2">توزيع المقشر وتشغيل البخار (بمسافة 30 سم) لمدة 7-10 دقائق لتليين الرؤوس السوداء.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الاستخراج والتعقيم</h5>
                            <p class="text-gray-600 mb-2">تفريغ المسام يدوياً، ثم توزيع ماسك معالج لـ 15 دقيقة للامتصاص وتقليل الاحمرار.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Christina Illustrious Mask</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الختام والحماية</h5>
                            <p class="text-gray-600 mb-2">الطبطبة بسيروم مرطب، ثم إنهاء الجلسة بكريم حماية يمنع اللمعان.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Christina Comodex Mattify & Protect SPF 15</span></div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">مسام نظيفة تماماً، توازن تام للإفرازات الدهنية، وبشرة هادئة ومطفأة (Matte) خالية من اللمعان المزعج.</p>
                </div>
            </div>
        </div>

        <div id="data-face-2">
            <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">النضارة الفورية للعرائس (GIGI Ester C)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">75 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">بروتوكول فاخر مصمم خصيصاً للعرائس لمنح البشرة توهجاً فورياً وتفتيحاً للتصبغات باستخدام فيتامين C المركز.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">تنظيف لطيف</h5>
                            <p class="text-gray-600 mb-2">تنظيف البشرة بلطف لإزالة الشوائب والمكياج وتجهيزها للبروتوكول.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">GIGI Ester C Cleanser</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التقشير الإنزيمي</h5>
                            <p class="text-gray-600 mb-2">تطبيق التقشير الإنزيمي لمدة 10 دقائق لإذابة الخلايا الميتة وتفتيح البشرة.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">GIGI Ester C Enzymatic Peel</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">سيروم فيتامين C المركز</h5>
                            <p class="text-gray-600 mb-2">تطبيق سيروم فيتامين C المركز مع مساج لمدة 5 دقائق لتعزيز الامتصاص والتوهج.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">GIGI Ester C Serum</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">ماسك التوهج</h5>
                            <p class="text-gray-600 mb-2">تطبيق ماسك التفتيح والتوهج لمدة 20 دقيقة لتوحيد لون البشرة وإشراقتها.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">GIGI Ester C Brightening Mask</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الختام والحماية</h5>
                            <p class="text-gray-600 mb-2">إنهاء الجلسة بكريم النهار مع حماية من الشمس للحفاظ على النتائج.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">GIGI Ester C Day Cream SPF 30</span></div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">بشرة متوهجة ومشرقة فورياً، تفتيح ملحوظ للتصبغات، وملمس ناعم كالحرير.</p>
                </div>
            </div>
        </div>

        <div id="data-face-3">
            <img src="https://images.unsplash.com/photo-1590439471364-192aa70c0b53?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">التقشير الزجاجي (Dermaplaning)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">45 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">إزالة طبقة الخلايا الميتة والشعر الوبري (الزغب) بشفرة طبية حادة للحصول على بشرة زجاجية ناعمة تمتص المنتجات بشكل أفضل.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التنظيف المزدوج</h5>
                            <p class="text-gray-600 mb-2">تنظيف مزدوج وإزالة المكياج بالكامل لضمان بشرة نظيفة تماماً قبل البدء.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التعقيم والتجفيف</h5>
                            <p class="text-gray-600 mb-2">تعقيم البشرة بالكحول الطبي وتجفيفها تماماً لضمان مرور سلس للشفرة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التقشير بالشفرة</h5>
                            <p class="text-gray-600 mb-2">تمرير شفرة Dermaplaning بزاوية 45 درجة بحركات قصيرة وخفيفة على كامل الوجه (تجنب منطقة العينين).</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الترطيب العميق</h5>
                            <p class="text-gray-600 mb-2">تطبيق سيروم الهيالورونيك المرطب لاستغلال امتصاص البشرة العالي بعد التقشير.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التهدئة والحماية</h5>
                            <p class="text-gray-600 mb-2">ماسك مهدئ بارد لمدة 15 دقيقة ثم واقي شمس لحماية البشرة المقشرة.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">بشرة ناعمة كالزجاج، إزالة كاملة للشعر الوبري، امتصاص أفضل للمكياج والمنتجات.</p>
                </div>
            </div>
        </div>

        <div id="data-face-4">
            <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">الشد الفوري بخيوط الحرير (Christina Silk)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">60 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">بروتوكول Christina Silk الفاخر الذي يستخدم خيوط الحرير الطبيعية لملء الخطوط الدقيقة وشد البشرة بشكل فوري دون تدخل جراحي.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التنظيف العميق</h5>
                            <p class="text-gray-600 mb-2">تنظيف عميق وتونر لتجهيز البشرة لاستقبال خيوط الحرير.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">السيروم التحضيري</h5>
                            <p class="text-gray-600 mb-2">تطبيق السيروم التحضيري لتجهيز البشرة وتسهيل ذوبان خيوط الحرير.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Christina Silk Preparatory Serum</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">تطبيق خيوط الحرير</h5>
                            <p class="text-gray-600 mb-2">وضع خيوط الحرير الطبيعية على مناطق الخطوط (الجبهة، حول الفم، حول العينين) وتذويبها بالتدليك.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">ماسك الشد</h5>
                            <p class="text-gray-600 mb-2">تطبيق ماسك شد الحرير لمدة 20 دقيقة لتثبيت النتائج وتعزيز الشد.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Christina Silk Firming Mask</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الختام المكثف</h5>
                            <p class="text-gray-600 mb-2">سيروم الحرير المكثف وكريم الحرير للختام والحماية.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Christina Silk Intensive Serum + Silk Cream</span></div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">شد فوري وملحوظ، امتلاء الخطوط الدقيقة، بشرة أكثر تماسكاً ونعومة.</p>
                </div>
            </div>
        </div>

        <div id="data-face-5">
            <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">الميزوثيرابي السطحي (Dermapen)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">60 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">تحفيز الكولاجين والإيلاستين طبيعياً عبر الوخز الدقيق (Microneedling)، مما يساعد في علاج ندبات حب الشباب، تصغير المسام الواسعة، وتجديد شباب البشرة.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التعقيم الطبي والتخدير</h5>
                            <p class="text-gray-600 mb-2">التعقيم الطبي والتخدير الموضعي الاختياري لمدة 15 دقيقة لضمان راحة العميلة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">تطبيق الأمبولة العلاجية</h5>
                            <p class="text-gray-600 mb-2">تطبيق الأمبولة العلاجية حسب حالة البشرة لتعمل كمزلق للجهاز وتدخل لعمق الجلد.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Mesoestetic Hyaluronic Acid Ampoules</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الوخز بجهاز الديرمابن</h5>
                            <p class="text-gray-600 mb-2">الوخز بجهاز الديرمابن بإبر معقمة لمرة واحدة بحركات دائرية على كامل الوجه.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التهدئة الفائقة</h5>
                            <p class="text-gray-600 mb-2">تطبيق ماسك ورقي مثلج للتهدئة وتقليل الاحمرار الفوري.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">بشرة مشدودة وممتلئة بعد أيام، اختفاء تدريجي للتصبغات والندبات، تحسن هائل في ملمس الجلد.</p>
                </div>
            </div>
        </div>

        <div id="data-face-6">
            <img src="https://images.unsplash.com/photo-1556228578-0d85b1a4d571?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">التقشير البحري العميق (Rose de Mer)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">45 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">تقشير ميكانيكي حيوي 100% طبيعي يعتمد على سيليكات المرجان البحري. بديل آمن للتقشير الكيميائي لعلاج ندبات حب الشباب العميقة والتصبغات المستعصية.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2 flex items-center gap-2"><i class="fa-solid fa-camera text-secondary"></i> خطوات التنفيذ (دليل مصور):</h4>
                <div class="space-y-8">
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xl shrink-0">1</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">التنظيف بصابون السافون</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">غسل الوجه جيداً باستخدام الصابون المخصص لتجريد البشرة من أي زيوت وتجهيز المسام لاستقبال جزيئات المرجان. يشطف بماء فاتر.</p>
                                <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Christina Rose de Mer Savon Supreme</span></div>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=400&auto=format&fit=crop" alt="تنظيف البشرة" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xl shrink-0">2</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">تطبيق وفرك المقشر البحري</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">خلط مسحوق المرجان البحري مع المنشط المائي، وتوزيعه على الوجه. فركه بحركات دائرية دقيقة لمدة 3-5 دقائق لغرس السيليكات الدقيقة داخل البشرة.</p>
                                <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Rose de Mer Sea Herbal Deep Peel + Activator</span></div>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?q=80&w=400&auto=format&fit=crop" alt="تطبيق المقشر" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xl shrink-0">3</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">التهدئة وتغليف البشرة</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">بعد شطف المقشر، يتم وضع ماسك التهدئة العميق لاحتجاز المكونات داخل الجلد وتقليل الاحمرار الشديد.</p>
                                <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Rose de Mer Soothing Mask</span></div>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1590439471364-192aa70c0b53?q=80&w=400&auto=format&fit=crop" alt="ماسك التهدئة" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">تقشير طبيعي كامل خلال 5 أيام، بشرة جديدة ونضرة، تفتيح ملحوظ للتصبغات العميقة والندبات.</p>
                </div>
            </div>
        </div>

        <div id="data-face-7">
            <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">العلاج بالضوء المرئي (LED)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">30 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">استخدام أطوال موجية مختلفة من الضوء المرئي لتحفيز الخلايا وعلاج مشاكل البشرة المختلفة (أزرق لحب الشباب، أحمر للتجاعيد، أخضر للتصبغات).</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التنظيف وإزالة المكياج</h5>
                            <p class="text-gray-600 mb-2">تنظيف البشرة وإزالة المكياج بالكامل لضمان وصول الضوء بشكل مباشر.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">تطبيق السيروم المناسب</h5>
                            <p class="text-gray-600 mb-2">تطبيق سيروم مناسب حسب نوع العلاج المستهدف لتعزيز نتائج الضوء.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">جلسة الضوء المرئي</h5>
                            <p class="text-gray-600 mb-2">وضع نظارات الحماية وتشغيل جهاز LED لمدة 20 دقيقة باللون المناسب لحالة البشرة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الختام والحماية</h5>
                            <p class="text-gray-600 mb-2">تطبيق كريم مرطب وواقي شمس لحماية البشرة بعد الجلسة.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">تحسن ملحوظ في حب الشباب (الضوء الأزرق)، تقليل التجاعيد (الضوء الأحمر)، تفتيح التصبغات (الضوء الأخضر).</p>
                </div>
            </div>
        </div>

        <div id="data-face-8">
            <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">فاشيال الأكسجين (Oxygen Facial)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">60 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">ضخ أكسجين نقي بضغط عالي مع سيرومات مركزة لترطيب عميق وإعطاء نضارة فورية وممتلئة للبشرة.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التنظيف والتقشير</h5>
                            <p class="text-gray-600 mb-2">تنظيف وتقشير خفيف لتجهيز البشرة لاستقبال الأكسجين والسيرومات.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">السيروم المركز</h5>
                            <p class="text-gray-600 mb-2">تطبيق سيروم الهيالورونيك المركز ليتم دفعه بعمق مع الأكسجين.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">ضخ الأكسجين النقي</h5>
                            <p class="text-gray-600 mb-2">ضخ الأكسجين النقي بجهاز Intraceuticals لمدة 30 دقيقة لدفع السيروم لأعمق طبقات البشرة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الترطيب الختامي</h5>
                            <p class="text-gray-600 mb-2">تطبيق كريم مرطب غني للحفاظ على الترطيب والنضارة.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">بشرة ممتلئة ومرطبة بعمق، نضارة فورية تدوم لأسبوع، ملمس ناعم وموحد.</p>
                </div>
            </div>
        </div>

        <div id="data-face-9">
            <img src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">التقشير الكيميائي (Chemical Peel)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">30 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">استخدام أحماض AHA/BHA بتركيزات طبية لتقشير الطبقة السطحية من البشرة وعلاج التصبغات والندبات السطحية.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التنظيف والتعقيم</h5>
                            <p class="text-gray-600 mb-2">تنظيف وتعقيم البشرة لإزالة جميع الشوائب وتجهيزها للتقشير.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">تطبيق محلول التقشير</h5>
                            <p class="text-gray-600 mb-2">تطبيق محلول التقشير (Glycolic Acid 30% أو Salicylic Acid 20%) لمدة 3-5 دقائق حسب نوع البشرة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">معادلة الحمض</h5>
                            <p class="text-gray-600 mb-2">معادلة الحمض بمحلول خاص لإيقاف عملية التقشير وحماية البشرة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التهدئة والحماية</h5>
                            <p class="text-gray-600 mb-2">تطبيق ماسك مهدئ وكريم مرطب مع واقي شمس عالي الحماية.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">تقشير خفيف خلال 3-5 أيام، بشرة جديدة أكثر نضارة، تفتيح التصبغات السطحية.</p>
                </div>
            </div>
        </div>

        <div id="data-face-10">
            <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">الشد بالتيار الميكروي (Microcurrent)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">45 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">تحفيز عضلات الوجه بتيار كهربائي منخفض جداً لشد العضلات ورفعها بشكل طبيعي فوري (بديل غير جراحي للشد).</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التنظيف وتطبيق الجل الموصل</h5>
                            <p class="text-gray-600 mb-2">تنظيف البشرة وتطبيق جل موصل لتسهيل مرور التيار الميكروي.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">تحفيز عضلات الوجه</h5>
                            <p class="text-gray-600 mb-2">تمرير أقطاب Microcurrent على مسارات عضلات الوجه (الجبين، الخدين، الذقن، الرقبة) لمدة 30 دقيقة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الختام والترطيب</h5>
                            <p class="text-gray-600 mb-2">تطبيق سيروم شد وكريم مرطب للحفاظ على نتائج الرفع والشد.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">شد فوري وملحوظ لعضلات الوجه، رفع الحواجب والوجنتين، مظهر أكثر شباباً.</p>
                </div>
            </div>
        </div>

        <div id="data-body-1">
            <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">السنفرة وتلميع الجسم</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">30 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">تهيئة الجلد لجلسات الليزر وإزالة التقرن الجريبي (Keratosis Pilaris) والخلايا الميتة المتراكمة.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">توزيع المقشر</h5>
                            <p class="text-gray-600 mb-2">توزيع مقشر الجسم الخشن (سكر + زيت لوز) بحركات دائرية على كامل الجسم.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block">مقشر الجسم بالسكر وزيت اللوز الحلو</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التركيز على المناطق الخشنة</h5>
                            <p class="text-gray-600 mb-2">التركيز على المناطق الخشنة (المرفقين، الركبتين، الكعبين) لفركها بشكل مكثف.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الشطف</h5>
                            <p class="text-gray-600 mb-2">شطف الجسم بماء دافئ لإزالة بقايا المقشر والخلايا الميتة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الترطيب العميق</h5>
                            <p class="text-gray-600 mb-2">تطبيق كريم مرطب غني للحفاظ على نعومة البشرة وترطيبها.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">بشرة ناعمة وملساء، استعداد مثالي لجلسات الليزر.</p>
                </div>
            </div>
        </div>

        <div id="data-body-2">
            <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">تنظيف الظهر العميق (Back Facial)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">45 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">علاج حبوب الظهر والرؤوس السوداء والزيوان باستخدام البخار والاستخراج اليدوي.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التنظيف المضاد للبكتيريا</h5>
                            <p class="text-gray-600 mb-2">تنظيف الظهر بغسول مضاد للبكتيريا لإزالة الشوائب والزيوت الزائدة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التبخير</h5>
                            <p class="text-gray-600 mb-2">تبخير لمدة 10 دقائق لتليين المسام وتسهيل عملية الاستخراج.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الاستخراج اليدوي</h5>
                            <p class="text-gray-600 mb-2">استخراج يدوي للرؤوس السوداء والحبوب بتقنية معقمة وآمنة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">ماسك الطين المنقي</h5>
                            <p class="text-gray-600 mb-2">ماسك طين منقي لمدة 15 دقيقة لامتصاص الدهون وتهدئة البشرة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الختام المضاد للبكتيريا</h5>
                            <p class="text-gray-600 mb-2">كريم مهدئ مضاد للبكتيريا لحماية الظهر ومنع ظهور حبوب جديدة.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Christina Comodex Back Treatment Kit</span></div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">ظهر نظيف خالٍ من الحبوب والرؤوس السوداء.</p>
                </div>
            </div>
        </div>

        <div id="data-body-3">
            <img src="https://images.unsplash.com/photo-1544161513-01f1437ccb8d?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">المساج اللمفاوي العطري</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">60 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">طقس استرخاء مستوحى من وادي سلامة، يجمع بين المساج اللمفاوي لتصريف السموم والزيوت العطرية للاسترخاء العميق.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">اختيار مزيج الزيوت</h5>
                            <p class="text-gray-600 mb-2">اختيار مزيج الزيوت العطرية (لافندر + نعناع + إكليل الجبل) حسب تفضيل العميلة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">المساج اللمفاوي</h5>
                            <p class="text-gray-600 mb-2">مساج لمفاوي خفيف باتجاه العقد اللمفاوية لتصريف السموم والسوائل المحتبسة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التركيز على مناطق التوتر</h5>
                            <p class="text-gray-600 mb-2">التركيز على الرقبة والأكتاف وأسفل الظهر لتفكيك التشنجات العضلية.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">اللف بالمناشف الدافئة</h5>
                            <p class="text-gray-600 mb-2">لف الجسم بمناشف دافئة لمدة 10 دقائق لتعزيز الامتصاص والاسترخاء.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">استرخاء عميق، تخفيف التوتر العضلي، شعور بخفة الجسم.</p>
                </div>
            </div>
        </div>

        <div id="data-body-4">
            <div class="h-64 bg-amber-800 flex items-center justify-center relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=1200&auto=format&fit=crop')] opacity-40 bg-cover bg-center"></div>
                <h2 class="text-4xl text-white font-bold relative z-10 drop-shadow-md">المساج الخشبي الكولومبي</h2>
            </div>
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">نحت الجسم الخشبي (Maderotherapy)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">45 دقيقة للمنطقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">تقنية كولومبية طبيعية 100% تستخدم أدوات خشبية لتكسير الدهون العنيدة وتدمير السيلوليت ونحت القوام.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2 flex items-center gap-2"><i class="fa-solid fa-camera text-secondary"></i> خطوات التنفيذ (دليل مصور):</h4>
                <div class="space-y-8">
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-amber-600 text-white flex items-center justify-center font-bold text-xl shrink-0">1</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">التهيئة بالزيت الحار</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">توزيع زيت مساج مضاد للسيلوليت وتسخين العضلات بمساج يدوي تمهيدي لتنشيط الدورة الدموية.</p>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=400&auto=format&fit=crop" alt="التهيئة بالزيت" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-amber-600 text-white flex items-center justify-center font-bold text-xl shrink-0">2</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">العجلة الخشبية (The Roller)</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">استخدام رولر خشبي مضلع وتمريره بحركات سريعة وقوية على مناطق تجمع السيلوليت لتكسير الخلايا الدهنية المحتبسة.</p>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=400&auto=format&fit=crop" alt="العجلة الخشبية" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-amber-600 text-white flex items-center justify-center font-bold text-xl shrink-0">3</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">الكأس السويدي (Swedish Cup)</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">استخدام كأس خشبي يعمل بتقنية الشفط الفراغي لسحب الدهون المكسرة وتوجيهها باتجاه العقد اللمفاوية.</p>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1519823551278-64ac92734fb1?q=80&w=400&auto=format&fit=crop" alt="الكأس السويدي" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-amber-600 text-white flex items-center justify-center font-bold text-xl shrink-0">4</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">لوح النحت (Contouring Board)</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">استخدام أداة النحت المسطحة لمسح وتنعيم الجلد ودفع السوائل الزائدة بشكل نهائي خارج المنطقة المستهدفة.</p>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=400&auto=format&fit=crop" alt="لوح النحت" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">انخفاض ملحوظ في السيلوليت، نحت لملامح الجسم، شعور بخفة الساقين.</p>
                </div>
            </div>
        </div>

        <div id="data-body-5">
            <div class="h-64 bg-gray-900 flex items-center justify-center relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1544161513-01f1437ccb8d?q=80&w=1200&auto=format&fit=crop')] opacity-60 bg-cover bg-center"></div>
                <h2 class="text-4xl text-white font-bold relative z-10 drop-shadow-lg">المساج بالأحجار البركانية</h2>
            </div>
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">المساج بالأحجار الساخنة (Hot Stone Therapy)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">60-90 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">دمج الحرارة العميقة مع المساج اليدوي. أحجار بازلت ملساء تريح العضلات فورياً وتحسن الدورة الدموية.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2 flex items-center gap-2"><i class="fa-solid fa-camera text-secondary"></i> خطوات التنفيذ (دليل مصور):</h4>
                <div class="space-y-8">
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-gray-700 text-white flex items-center justify-center font-bold text-xl shrink-0">1</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">تسخين الأحجار والزيوت</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">تسخين أحجار البازلت في جهاز مائي خاص لدرجة حرارة مريحة، وتجهيز زيت المساج العطري الدافئ.</p>
                                <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block">زيت اللوز الحلو مع الخزامى</span></div>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1544161513-01f1437ccb8d?q=80&w=400&auto=format&fit=crop" alt="أحجار ساخنة" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-gray-700 text-white flex items-center justify-center font-bold text-xl shrink-0">2</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">وضع الأحجار على مسارات الطاقة</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">وضع الأحجار الساخنة على نقاط استراتيجية على طول العمود الفقري والأكتاف لإيصال الدفء لعمق العضلة.</p>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1519823551278-64ac92734fb1?q=80&w=400&auto=format&fit=crop" alt="توزيع الأحجار" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-gray-700 text-white flex items-center justify-center font-bold text-xl shrink-0">3</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">المساج الانزلاقي بالأحجار</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">استخدام الأحجار الساخنة كأداة لعمل مساج انزلاقي عميق على العضلات لفكك العقد العضلية دون ضغط مزعج.</p>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=400&auto=format&fit=crop" alt="المساج بالأحجار" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">إذابة التوتر العضلي، استرخاء ذهني وجسدي عميق.</p>
                </div>
            </div>
        </div>

        <div id="data-body-6">
            <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">لف الجسم (Body Wrapping)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">90 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">لف الجسم بمزيج من الأعشاب والطين والمكونات النشطة لنحت القوام، شد البشرة، وطرد السموم عبر التعرق.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">تقشير الجسم</h5>
                            <p class="text-gray-600 mb-2">تقشير الجسم بالكامل لإزالة الخلايا الميتة وتجهيز البشرة لامتصاص المكونات النشطة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">تطبيق مزيج الطين والأعشاب</h5>
                            <p class="text-gray-600 mb-2">تطبيق مزيج الطين والأعشاب (طين أخضر + طحالب بحرية + كافيين) على المناطق المستهدفة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">اللف الحراري</h5>
                            <p class="text-gray-600 mb-2">لف الجسم بغلاف حراري لمدة 40 دقيقة لتعزيز التعرق وطرد السموم.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">إزالة اللفاف والشطف</h5>
                            <p class="text-gray-600 mb-2">إزالة اللفاف وشطف الجسم بماء دافئ لإزالة بقايا الطين.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">كريم الشد المرطب</h5>
                            <p class="text-gray-600 mb-2">تطبيق كريم شد مرطب للحفاظ على نتائج النحت والشد.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">فقدان محيط مؤقت (1-3 سم)، بشرة مشدودة وناعمة، شعور بخفة الجسم.</p>
                </div>
            </div>
        </div>

        <div id="data-body-7">
            <img src="https://images.unsplash.com/photo-1519823551278-64ac92734fb1?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">التجويف (Cavitation)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">40 دقيقة للمنطقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">تفتيت الخلايا الدهنية باستخدام الموجات فوق الصوتية منخفضة التردد، بديل غير جراحي لشفط الدهون.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">تحديد المنطقة وقياس المحيط</h5>
                            <p class="text-gray-600 mb-2">تحديد المنطقة المستهدفة وقياس المحيط لتتبع التقدم خلال الجلسات.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">تطبيق الجل الموصل</h5>
                            <p class="text-gray-600 mb-2">تطبيق جل موصل على البشرة لتسهيل مرور الموجات فوق الصوتية.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">جهاز التجويف</h5>
                            <p class="text-gray-600 mb-2">تمرير جهاز التجويف بحركات دائرية لمدة 30 دقيقة لتفتيت الخلايا الدهنية.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">المساج اللمفاوي</h5>
                            <p class="text-gray-600 mb-2">مساج لمفاوي يدوي لمدة 10 دقائق لتصريف الدهون المكسرة عبر الجهاز اللمفاوي.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">تعليمات ما بعد الجلسة</h5>
                            <p class="text-gray-600 mb-2">نصيحة بشرب 2 لتر ماء يومياً لمدة 3 أيام لمساعدة الجسم على التخلص من الدهون المكسرة.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">تقليل محيط المنطقة (2-5 سم بعد 4-6 جلسات)، بشرة أكثر تماسكاً.</p>
                </div>
            </div>
        </div>

        <div id="data-body-8">
            <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">الحمام المغربي التقليدي</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">75 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">طقس التنقية المغربي التقليدي باستخدام الصابون البلدي والكياسة لإزالة الجلد الميت المتراكم وتنقية البشرة بعمق.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التبخير</h5>
                            <p class="text-gray-600 mb-2">تعريض الجسم للبخار لمدة 15 دقيقة لفتح المسام وتليين الجلد الميت.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الصابون البلدي</h5>
                            <p class="text-gray-600 mb-2">تطبيق الصابون البلدي (الصابون الأسود) على كامل الجسم وتركه 10 دقائق لتنقية البشرة.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block">الصابون البلدي المغربي</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الفرك بالكياسة</h5>
                            <p class="text-gray-600 mb-2">فرك الجسم بالكياسة المغربية بحركات دائرية قوية لإزالة الجلد الميت المتراكم.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block">الكياسة المغربية</span></div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الشطف</h5>
                            <p class="text-gray-600 mb-2">شطف الجسم بماء دافئ لإزالة جميع بقايا الصابون والجلد الميت.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الترطيب والتغذية</h5>
                            <p class="text-gray-600 mb-2">تطبيق ماء الورد وزيت الأرغان للترطيب والتغذية العميقة.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block">ماء الورد + زيت الأرغان</span></div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">بشرة ناعمة كالحرير، إزالة كاملة للجلد الميت المتراكم، شعور بالنظافة العميقة.</p>
                </div>
            </div>
        </div>

        <div id="data-spa-1">
            <img src="https://images.unsplash.com/photo-1519823551278-64ac92734fb1?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">علاج التشققات العميقة</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">45 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">طقس استشفائي للقدمين واليدين لإزالة الجلد الميت القاسي والتشققات العميقة باستخدام المقشرات والملطفات.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">النقع بماء إبسوم</h5>
                            <p class="text-gray-600 mb-2">نقع الأطراف بماء دافئ مع ملح إبسوم لمدة 15 دقيقة لتليين الجلد المتشقق.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التقشير الخشن</h5>
                            <p class="text-gray-600 mb-2">تطبيق كريم مقشر بحبيبات خشنة وفرك المناطق المتشققة لإزالة الجلد القاسي.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">حجر الخفاف</h5>
                            <p class="text-gray-600 mb-2">استخدام حجر الخفاف للتشققات العميقة لإزالة الطبقات القاسية المتراكمة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">ماسك الترطيب العميق</h5>
                            <p class="text-gray-600 mb-2">تطبيق ماسك مرطب غني ولف الأطراف بمناشف دافئة لمدة 15 دقيقة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الختام بزبدة الشيا</h5>
                            <p class="text-gray-600 mb-2">كريم زبدة الشيا للختام لحماية البشرة وترطيبها بعمق.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">أطراف ناعمة خالية من التشققات، بشرة مرطبة بعمق.</p>
                </div>
            </div>
        </div>

        <div id="data-spa-2">
            <img src="https://images.unsplash.com/photo-1544161513-01f1437ccb8d?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">ترطيب البارافين الملكي</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">30 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">علاج حراري باستخدام شمع البارافين الدافئ لفتح المسام ودفع الزيوت المرطبة لأعمق طبقات الجلد.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التنظيف والتقشير</h5>
                            <p class="text-gray-600 mb-2">تنظيف وتقشير خفيف للأطراف لإزالة الخلايا الميتة وتجهيز البشرة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">غمس البارافين</h5>
                            <p class="text-gray-600 mb-2">غمس اليدين/القدمين في شمع البارافين الدافئ (3-4 طبقات) لتشكيل طبقة حرارية عازلة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">اللف والانتظار</h5>
                            <p class="text-gray-600 mb-2">لف الأطراف بأكياس بلاستيكية ومناشف دافئة لمدة 20 دقيقة لتعزيز الامتصاص.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الإزالة والتدليك</h5>
                            <p class="text-gray-600 mb-2">إزالة البارافين وتدليك الأطراف بزيت مرطب للحفاظ على النعومة.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">ترطيب عميق يدوم لأسبوع، بشرة ناعمة كالحرير، تخفيف آلام المفاصل.</p>
                </div>
            </div>
        </div>

        <div id="data-spa-3">
            <img src="https://images.unsplash.com/photo-1522337660859-02fbefca4702?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">رفع الرموش بالكيراتين (Lash Lift)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">45 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">رفع وتجعيد الرموش طبيعياً باستخدام محاليل الرفع والكيراتين، بديل طبيعي للرموش الصناعية يدوم 6-8 أسابيع.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التنظيف وإزالة المكياج</h5>
                            <p class="text-gray-600 mb-2">تنظيف الرموش وإزالة المكياج بالكامل لضمان التصاق المحاليل بشكل صحيح.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">لصق الرموش على القالب</h5>
                            <p class="text-gray-600 mb-2">لصق الرموش على قالب سيليكون بالحجم المناسب لتحديد درجة التجعيد.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">محلول الرفع</h5>
                            <p class="text-gray-600 mb-2">تطبيق محلول الرفع (Lifting Lotion) لمدة 8-12 دقيقة لكسر روابط الشعر وإعادة تشكيلها.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">محلول التثبيت</h5>
                            <p class="text-gray-600 mb-2">تطبيق محلول التثبيت (Setting Lotion) لمدة 8 دقائق لتثبيت الشكل الجديد للرموش.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الصبغة والكيراتين</h5>
                            <p class="text-gray-600 mb-2">صبغة اختيارية ثم سيروم الكيراتين لتغذية الرموش وإعطائها لمعة صحية.</p>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Professional Lash Lift Kit (Step 1 + Step 2 + Keratin Serum)</span></div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">رموش مرفوعة ومجعدة طبيعياً، مظهر أوسع للعينين، يدوم 6-8 أسابيع.</p>
                </div>
            </div>
        </div>

        <div id="data-spa-4">
            <div class="h-64 bg-blue-900 flex items-center justify-center relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=1200&auto=format&fit=crop')] opacity-50 bg-cover bg-center"></div>
                <h2 class="text-4xl text-white font-bold relative z-10 drop-shadow-md">ديتوكس فروة الرأس الياباني</h2>
            </div>
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">سبا ديتوكس فروة الرأس</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">60 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">طقس ياباني فاخر يركز على صحة فروة الرأس، إزالة تراكمات الزيوت، تنشيط البصيلات، واسترخاء مائي.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2 flex items-center gap-2"><i class="fa-solid fa-camera text-secondary"></i> خطوات التنفيذ (دليل مصور):</h4>
                <div class="space-y-8">
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-xl shrink-0">1</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">الفحص والتمشيط</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">فحص الفروة باستخدام كاميرا دقيقة (اختياري)، ثم تمشيط الشعر بفرشاة خشبية لفك التشابك وتنشيط الدورة الدموية السطحية.</p>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=400&auto=format&fit=crop" alt="الفحص والتمشيط" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-xl shrink-0">2</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">التقشير والديتوكس</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">وضع مقشر خاص بفروة الرأس لإذابة الدهون الصلبة وإزالة القشرة، مع تدليك لطيف.</p>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=400&auto=format&fit=crop" alt="التقشير والديتوكس" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-xl shrink-0">3</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">شلال المياه (Halo Water Fall)</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">استخدام قوس المياه الخاص لصب ماء دافئ بشكل مستمر على جبهة وفروة رأس العميلة، مما يحفز العصب المبهم ويؤدي لاسترخاء عميق.</p>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?q=80&w=400&auto=format&fit=crop" alt="شلال المياه" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-xl shrink-0">4</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">الغسيل والمساج اللمفاوي</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">غسل الشعر بشامبو منقي، يليه عمل مساج لمفاوي مكثف للرأس والرقبة والأكتاف لفك التشنجات العضلية.</p>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1590439471364-192aa70c0b53?q=80&w=400&auto=format&fit=crop" alt="الغسيل والمساج" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">فروة رأس نظيفة تماماً، شعر لامع بحجم طبيعي، تخفيف هائل للصداع والتوتر.</p>
                </div>
            </div>
        </div>

        <div id="data-spa-5">
            <div class="h-64 bg-pink-900 flex items-center justify-center relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522337660859-02fbefca4702?q=80&w=1200&auto=format&fit=crop')] opacity-50 bg-cover bg-center"></div>
                <h2 class="text-4xl text-white font-bold relative z-10 drop-shadow-md">تصفيح وتحديد الحواجب</h2>
            </div>
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">تصفيح وتحديد الحواجب (Brow Lamination)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">45-60 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">إعادة هيكلة شعر الحواجب لإبقائها في الشكل والاتجاه المرغوبين. تمنح مظهراً كثيفاً ومرتباً يستمر لأسابيع.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2 flex items-center gap-2"><i class="fa-solid fa-camera text-secondary"></i> خطوات التنفيذ (دليل مصور):</h4>
                <div class="space-y-8">
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-pink-500 text-white flex items-center justify-center font-bold text-xl shrink-0">1</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">التنظيف وتطبيق كريم الرفع</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">تنظيف الحاجبين من الزيوت والمكياج. تمشيط الشعر للأعلى، ثم وضع محلول الرفع لكسر روابط الكيراتين الطبيعية وتغليفها بنايلون.</p>
                                <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Professional Brow Perming Lotion (Step 1)</span></div>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1599305090598-fe179d501227?q=80&w=400&auto=format&fit=crop" alt="تطبيق كريم الرفع" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-pink-500 text-white flex items-center justify-center font-bold text-xl shrink-0">2</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">التثبيت بالشكل الجديد</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">بعد إزالة المحلول الأول، يتم تمشيط الشعر بدقة بالشكل المثالي، ثم يوضع محلول التثبيت لبناء روابط الشعر من جديد.</p>
                                <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm"><span class="text-gray-500 block mb-1">المنتج المستخدم:</span><span class="text-primary font-bold block font-sans" dir="ltr">Brow Neutralizer / Setting Lotion (Step 2)</span></div>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1620055375549-bfa34a5d8985?q=80&w=400&auto=format&fit=crop" alt="تثبيت الحواجب" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-4 md:w-3/5">
                            <div class="w-12 h-12 rounded-full bg-pink-500 text-white flex items-center justify-center font-bold text-xl shrink-0">3</div>
                            <div>
                                <h5 class="text-xl font-bold text-dark mb-2">الصبغة والتغذية العميقة</h5>
                                <p class="text-gray-600 mb-3 leading-relaxed">صبغ الحواجب لملء الفراغات بصرياً (اختياري). تختتم الجلسة بوضع سيروم الكيراتين لتغذية الشعرة وإعطائها لمعة صحية.</p>
                            </div>
                        </div>
                        <div class="md:w-2/5 w-full h-48 overflow-hidden rounded-xl shrink-0 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1512496015851-a1cbfc314a99?q=80&w=400&auto=format&fit=crop" alt="التغذية العميقة" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">حواجب مرتبة وكثيفة طبيعياً، تدوم 4-6 أسابيع.</p>
                </div>
            </div>
        </div>

        <div id="data-spa-6">
            <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">أظافر الجل (Gel Nails)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">60 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">طلاء جل يدوم طويلاً (2-3 أسابيع) مع العناية الكاملة بالأظافر والكيوتيكل للحصول على أظافر أنيقة ومقواة.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التنظيف وإزالة الطلاء</h5>
                            <p class="text-gray-600 mb-2">تنظيف الأظافر وإزالة الطلاء القديم بالكامل.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">العناية بالكيوتيكل</h5>
                            <p class="text-gray-600 mb-2">دفع وقص الكيوتيكل بعناية للحصول على مظهر نظيف ومرتب.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">تشكيل الأظافر</h5>
                            <p class="text-gray-600 mb-2">تشكيل الأظافر بالمبرد حسب الشكل المطلوب (مربع، لوزي، بيضاوي).</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">طبقة الأساس</h5>
                            <p class="text-gray-600 mb-2">تطبيق طبقة الأساس (Base Coat) وتجفيفها بمصباح UV/LED.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">لون الجل</h5>
                            <p class="text-gray-600 mb-2">تطبيق لون الجل (2-3 طبقات) مع التجفيف بمصباح UV/LED بين كل طبقة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">6</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">طبقة الحماية</h5>
                            <p class="text-gray-600 mb-2">تطبيق طبقة الحماية (Top Coat) وتجفيف نهائي بمصباح UV/LED.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">7</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">زيت الكيوتيكل</h5>
                            <p class="text-gray-600 mb-2">تطبيق زيت الكيوتيكل للترطيب والعناية بالبشرة المحيطة بالأظافر.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">أظافر أنيقة بلون ثابت يدوم 2-3 أسابيع بدون تقشير.</p>
                </div>
            </div>
        </div>

        <div id="data-spa-7">
            <img src="https://images.unsplash.com/photo-1519823551278-64ac92734fb1?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">بديكير طبي (Medical Pedicure)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">60 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">علاج طبي متكامل للأقدام يعالج التشققات العميقة، الأظافر الغائرة، الفطريات السطحية، والجلد القاسي.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">النقع الطبي</h5>
                            <p class="text-gray-600 mb-2">نقع القدمين بماء دافئ مع مطهر طبي لمدة 15 دقيقة لتليين الجلد وتعقيم الأقدام.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">قص وتشكيل الأظافر</h5>
                            <p class="text-gray-600 mb-2">قص وتشكيل الأظافر بشكل طبي صحيح لمنع الأظافر الغائرة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">علاج الأظافر الغائرة</h5>
                            <p class="text-gray-600 mb-2">تنظيف تحت الأظافر وعلاج الأظافر الغائرة بتقنية طبية آمنة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">إزالة الجلد القاسي</h5>
                            <p class="text-gray-600 mb-2">إزالة الجلد القاسي بالمشرط الطبي (Scalpel) بعناية فائقة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التقشير الطبي</h5>
                            <p class="text-gray-600 mb-2">فرك القدمين بمقشر طبي لإزالة بقايا الجلد الميت وتنظيف البشرة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">6</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الختام الطبي</h5>
                            <p class="text-gray-600 mb-2">تطبيق كريم مضاد للفطريات ومرطب طبي لحماية القدمين وترطيبهما.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">أقدام نظيفة وصحية، علاج التشققات والفطريات، أظافر مرتبة.</p>
                </div>
            </div>
        </div>

        <div id="data-spa-8">
            <img src="https://images.unsplash.com/photo-1544161513-01f1437ccb8d?q=80&w=1200&auto=format&fit=crop" class="w-full h-64 object-cover">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-3xl font-bold text-primary font-serif">سبا البارافين للأطراف (Hand &amp; Foot Paraffin Spa)</h2>
                    <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-bold shadow">45 دقيقة</span>
                </div>
                <div class="bg-accent p-6 rounded-xl border-r-4 border-secondary mb-8">
                    <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><i class="fa-solid fa-bullseye text-secondary"></i> الهدف من الجلسة</h4>
                    <p class="text-gray-700 leading-relaxed">علاج حراري فاخر يجمع بين تقشير الأطراف وغمرها في شمع البارافين الدافئ لترطيب عميق وتخفيف آلام المفاصل.</p>
                </div>
                <h4 class="text-2xl font-bold text-dark mb-6 border-b pb-2">خطوات وبروتوكول العمل:</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">التقشير</h5>
                            <p class="text-gray-600 mb-2">تنظيف وتقشير اليدين والقدمين بمقشر السكر لإزالة الخلايا الميتة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الترطيب التحضيري</h5>
                            <p class="text-gray-600 mb-2">تطبيق كريم مرطب غني لتجهيز البشرة لاستقبال البارافين.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">غمس البارافين</h5>
                            <p class="text-gray-600 mb-2">غمس الأطراف في شمع البارافين الدافئ (4-5 طبقات) لتشكيل طبقة حرارية عازلة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">4</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">اللف الحراري</h5>
                            <p class="text-gray-600 mb-2">لف الأطراف بغلاف حراري ومناشف دافئة لمدة 25 دقيقة لتعزيز الامتصاص.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">5</div>
                        <div>
                            <h5 class="text-lg font-bold text-dark mb-1">الإزالة والتدليك</h5>
                            <p class="text-gray-600 mb-2">إزالة البارافين وتدليك الأطراف بزيت الأرغان للحفاظ على النعومة والترطيب.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-green-50 p-6 rounded-xl border border-green-200">
                    <h4 class="font-bold text-green-800 mb-2 text-lg"><i class="fa-solid fa-check-circle mr-2"></i> النتيجة النهائية</h4>
                    <p class="text-green-700">ترطيب عميق يدوم لأسابيع، بشرة ناعمة كالحرير، تخفيف آلام المفاصل والروماتيزم.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white pt-16 pb-8 border-t-4 border-secondary mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <i class="fa-solid fa-leaf text-secondary text-3xl"></i>
                    <h2 class="text-2xl font-bold text-white font-serif">مركز سماح</h2>
                </div>
                <p class="text-gray-400 mb-6 text-sm">دليل داخلي للخبيرات والأخصائيات - ليس للنشر العام</p>
                <p class="text-gray-500 text-xs">&copy; {{ date('Y') }} مركز سماح للعناية والتجميل. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-md');
                nav.style.background = 'rgba(253, 251, 247, 0.98)';
            } else {
                nav.classList.remove('shadow-md');
                nav.style.background = 'rgba(253, 251, 247, 0.9)';
            }
        });

        document.getElementById('mobile-menu-btn').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('tab-active', 'text-primary');
                el.classList.add('text-gray-500');
            });
            document.getElementById('content-' + tabName).classList.remove('hidden');
            const activeBtn = document.getElementById('tab-' + tabName);
            activeBtn.classList.add('tab-active', 'text-primary');
            activeBtn.classList.remove('text-gray-500');
        }

        const modal = document.getElementById('service-modal');
        const modalBody = document.getElementById('modal-body');

        function openModal(templateId) {
            const template = document.getElementById(templateId);
            if (template) {
                modalBody.innerHTML = template.innerHTML;
            } else {
                modalBody.innerHTML = `<div class="p-12 text-center"><i class="fa-solid fa-gears text-4xl text-secondary mb-4"></i><h2 class="text-2xl font-bold text-primary">جاري إعداد دليل هذه الجلسة</h2><p class="text-gray-500 mt-2">يرجى العودة لاحقاً لرؤية التفاصيل.</p></div>`;
            }
            modal.classList.remove('modal-leave');
            modal.classList.add('modal-enter');
            document.body.classList.add('modal-open');
        }

        function closeModal() {
            modal.classList.remove('modal-enter');
            modal.classList.add('modal-leave');
            document.body.classList.remove('modal-open');
            setTimeout(() => {
                modalBody.innerHTML = '';
            }, 400);
        }
    </script>
</body>
</html>
