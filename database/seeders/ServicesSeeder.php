<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->where('id', '>=', 1)->update(['category' => 'face']);

        DB::table('services')->where('id', 1)->update(['category' => 'body', 'name_ar' => 'المساج اللمفاوي العطري', 'duration' => '60', 'sort_order' => 3]);
        DB::table('services')->where('id', 2)->update(['category' => 'face', 'name_ar' => 'علاج وجه متقدم', 'duration' => '90', 'sort_order' => 2]);
        DB::table('services')->where('id', 3)->update(['category' => 'body', 'name_ar' => 'الحمام المغربي التقليدي', 'duration' => '75', 'sort_order' => 7]);
        DB::table('services')->where('id', 4)->update(['category' => 'extremities', 'name_ar' => 'بديكير ومنيكير', 'duration' => '60', 'sort_order' => 6]);
        DB::table('services')->where('id', 5)->update(['category' => 'body', 'name_ar' => 'المساج بالأحجار الساخنة', 'duration' => '60', 'sort_order' => 5]);
        DB::table('services')->where('id', 6)->update(['category' => 'body', 'name_ar' => 'لف الجسم (Body Wrapping)', 'duration' => '90', 'sort_order' => 6]);

        $services = [
            ['name_ar' => 'التنظيف العميق وتوازن البشرة', 'name_en' => 'Deep Cleansing Facial', 'category' => 'face', 'description_ar' => 'بروتوكول Christina للتحكم بالدهون وتنظيف المسام الواسعة. بروتوكول صارم للبشرة الدهنية والمختلطة لتنظيف المسام العميقة والتحكم الجذري في الإفرازات الدهنية.', 'price' => 200, 'discount_price' => null, 'duration' => '60-75', 'sort_order' => 1, 'is_active' => true, 'is_featured' => true],
            ['name_ar' => 'النضارة الفورية للعرائس', 'name_en' => 'Bridal Glow (GIGI Ester C)', 'category' => 'face', 'description_ar' => 'بروتوكول GIGI Ester C لتوهج فوري وتفتيح التصبغات. بروتوكول فاخر مصمم خصيصاً للعرائس لمنح البشرة توهجاً فورياً وتفتيحاً للتصبغات باستخدام فيتامين C المركز.', 'price' => 350, 'discount_price' => null, 'duration' => '75', 'sort_order' => 2, 'is_active' => true, 'is_featured' => true],
            ['name_ar' => 'التقشير الزجاجي (Dermaplaning)', 'name_en' => 'Dermaplaning', 'category' => 'face', 'description_ar' => 'إزالة الشعر الوبري والخلايا الميتة بشفرة طبية لبشرة زجاجية ناعمة تمتص المنتجات بشكل أفضل.', 'price' => 180, 'discount_price' => null, 'duration' => '45', 'sort_order' => 3, 'is_active' => true, 'is_featured' => false],
            ['name_ar' => 'الشد الفوري بخيوط الحرير', 'name_en' => 'Silk Thread Lifting', 'category' => 'face', 'description_ar' => 'بروتوكول Christina Silk الفاخر لملء الخطوط الدقيقة وشد البشرة بشكل فوري دون تدخل جراحي.', 'price' => 400, 'discount_price' => null, 'duration' => '60', 'sort_order' => 4, 'is_active' => true, 'is_featured' => true],
            ['name_ar' => 'الميزوثيرابي السطحي (Dermapen)', 'name_en' => 'Microneedling (Dermapen)', 'category' => 'face', 'description_ar' => 'تحفيز الكولاجين بالوخز الدقيق لعلاج ندبات حب الشباب وتصغير المسام الواسعة وتجديد شباب البشرة.', 'price' => 300, 'discount_price' => null, 'duration' => '60', 'sort_order' => 5, 'is_active' => true, 'is_featured' => true],
            ['name_ar' => 'التقشير البحري (Rose de Mer)', 'name_en' => 'Marine Peel (Rose de Mer)', 'category' => 'face', 'description_ar' => 'تقشير طبيعي 100% لتجديد البشرة وعلاج التصبغات العميقة. بديل آمن للتقشير الكيميائي لعلاج ندبات حب الشباب العميقة والتصبغات المستعصية.', 'price' => 350, 'discount_price' => null, 'duration' => '45', 'sort_order' => 6, 'is_active' => true, 'is_featured' => false],
            ['name_ar' => 'العلاج بالضوء المرئي (LED)', 'name_en' => 'LED Light Therapy', 'category' => 'face', 'description_ar' => 'تحفيز الخلايا بأطوال موجية مختلفة لعلاج حب الشباب والتجاعيد والتصبغات.', 'price' => 150, 'discount_price' => null, 'duration' => '30', 'sort_order' => 7, 'is_active' => true, 'is_featured' => false],
            ['name_ar' => 'فاشيال الأكسجين', 'name_en' => 'Oxygen Facial', 'category' => 'face', 'description_ar' => 'ضخ أكسجين نقي مع سيرومات مركزة لترطيب عميق ونضارة فورية وممتلئة للبشرة.', 'price' => 280, 'discount_price' => null, 'duration' => '60', 'sort_order' => 8, 'is_active' => true, 'is_featured' => true],
            ['name_ar' => 'التقشير الكيميائي', 'name_en' => 'Chemical Peel', 'category' => 'face', 'description_ar' => 'أحماض AHA/BHA لتجديد البشرة وعلاج التصبغات والندبات السطحية.', 'price' => 200, 'discount_price' => null, 'duration' => '30', 'sort_order' => 9, 'is_active' => true, 'is_featured' => false],
            ['name_ar' => 'الشد بالتيار الميكروي', 'name_en' => 'Microcurrent Lifting', 'category' => 'face', 'description_ar' => 'تحفيز عضلات الوجه بتيار منخفض لشد طبيعي فوري. بديل غير جراحي للشد.', 'price' => 250, 'discount_price' => null, 'duration' => '45', 'sort_order' => 10, 'is_active' => true, 'is_featured' => false],
            ['name_ar' => 'علاج الكلف والنمش والتصبغات', 'name_en' => 'Melasma & Pigmentation Treatment', 'category' => 'face', 'description_ar' => 'بروتوكول متقدم لعلاج الكلف والنمش والتصبغات الجلدية باستخدام تقنيات متعددة تشمل التقشير الكيميائي الخفيف والسيرومات المفتحة والعلاج بالضوء المرئي الأخضر لتوحيد لون البشرة واستعادة نضارتها.', 'price' => 350, 'discount_price' => 280, 'duration' => '60-75', 'sort_order' => 11, 'is_active' => true, 'is_featured' => true],
            ['name_ar' => 'السنفرة وتلميع الجسم', 'name_en' => 'Body Scrub & Polish', 'category' => 'body', 'description_ar' => 'تهيئة الجلد لجهاز الليزر وإزالة التقرن الجريبي والخلايا الميتة المتراكمة.', 'price' => 150, 'discount_price' => null, 'duration' => '30', 'sort_order' => 1, 'is_active' => true, 'is_featured' => false],
            ['name_ar' => 'تنظيف الظهر العميق', 'name_en' => 'Back Facial', 'category' => 'body', 'description_ar' => 'علاج حبوب الظهر والزيوان بالبخار والاستخراج اليدوي.', 'price' => 200, 'discount_price' => null, 'duration' => '45', 'sort_order' => 2, 'is_active' => true, 'is_featured' => false],
            ['name_ar' => 'المساج الخشبي (Maderotherapy)', 'name_en' => 'Maderotherapy', 'category' => 'body', 'description_ar' => 'نحت الجسم الكولومبي بالأخشاب وتكسير السيلوليت. تقنية كولومبية طبيعية 100% تستخدم أدوات خشبية لتكسير الدهون العنيدة وتدمير السيلوليت ونحت القوام.', 'price' => 300, 'discount_price' => null, 'duration' => '45', 'sort_order' => 4, 'is_active' => true, 'is_featured' => true],
            ['name_ar' => 'التجويف (Cavitation)', 'name_en' => 'Cavitation', 'category' => 'body', 'description_ar' => 'تفتيت الدهون بالموجات فوق الصوتية غير الجراحي. بديل غير جراحي لشفط الدهون.', 'price' => 350, 'discount_price' => null, 'duration' => '40', 'sort_order' => 8, 'is_active' => true, 'is_featured' => false],
            ['name_ar' => 'رفع الرموش بالكيراتين', 'name_en' => 'Lash Lift & Keratin', 'category' => 'extremities', 'description_ar' => 'رفع وتجعيد الرموش طبيعياً باستخدام محاليل الرفع والكيراتين. بديل طبيعي للرموش الصناعية يدوم 6-8 أسابيع.', 'price' => 150, 'discount_price' => null, 'duration' => '45', 'sort_order' => 1, 'is_active' => true, 'is_featured' => true],
            ['name_ar' => 'سبا ديتوكس فروة الرأس', 'name_en' => 'Scalp Detox Spa', 'category' => 'extremities', 'description_ar' => 'الطقس الياباني لتنظيف الفروة والاسترخاء المائي. طقس ياباني فاخر يركز على صحة فروة الرأس وإزالة تراكمات الزيوت وتنشيط البصيلات.', 'price' => 200, 'discount_price' => null, 'duration' => '60', 'sort_order' => 2, 'is_active' => true, 'is_featured' => true],
            ['name_ar' => 'تصفيح وتحديد الحواجب', 'name_en' => 'Brow Lamination', 'category' => 'extremities', 'description_ar' => 'إعادة هيكلة شعر الحواجب لإبقائها في الشكل المثالي. تمنح مظهراً كثيفاً ومرتباً يستمر لأسابيع.', 'price' => 120, 'discount_price' => null, 'duration' => '45-60', 'sort_order' => 3, 'is_active' => true, 'is_featured' => true],
            ['name_ar' => 'أظافر الجل', 'name_en' => 'Gel Nails', 'category' => 'extremities', 'description_ar' => 'طلاء جل يدوم طويلاً (2-3 أسابيع) مع العناية الكاملة بالأظافر والكيوتيكل.', 'price' => 100, 'discount_price' => null, 'duration' => '60', 'sort_order' => 4, 'is_active' => true, 'is_featured' => false],
            ['name_ar' => 'بديكير طبي', 'name_en' => 'Medical Pedicure', 'category' => 'extremities', 'description_ar' => 'علاج الأقدام المتشققة والأظافر الغائرة والفطريات. علاج طبي متكامل للأقدام.', 'price' => 180, 'discount_price' => null, 'duration' => '60', 'sort_order' => 5, 'is_active' => true, 'is_featured' => false],
            ['name_ar' => 'سبا البارافين للأطراف', 'name_en' => 'Paraffin Hand & Foot Spa', 'category' => 'extremities', 'description_ar' => 'علاج حراري فاخر لليدين والقدمين لترطيب عميق وتخفيف آلام المفاصل.', 'price' => 120, 'discount_price' => null, 'duration' => '45', 'sort_order' => 7, 'is_active' => true, 'is_featured' => false],
            ['name_ar' => 'علاج التشققات العميقة', 'name_en' => 'Deep Cracks Treatment', 'category' => 'extremities', 'description_ar' => 'طقس استشفائي لإزالة الجلد الميت القاسي والتشققات العميقة.', 'price' => 150, 'discount_price' => null, 'duration' => '45', 'sort_order' => 8, 'is_active' => true, 'is_featured' => false],
            ['name_ar' => 'ترطيب البارافين الملكي', 'name_en' => 'Royal Paraffin Treatment', 'category' => 'extremities', 'description_ar' => 'علاج حراري لفتح المسام ودفع الزيوت لأعمق الطبقات. ترطيب عميق يدوم لأسبوع.', 'price' => 100, 'discount_price' => null, 'duration' => '30', 'sort_order' => 9, 'is_active' => true, 'is_featured' => false],
        ];

        foreach ($services as $service) {
            DB::table('services')->insert(array_merge($service, [
                'tenant_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
