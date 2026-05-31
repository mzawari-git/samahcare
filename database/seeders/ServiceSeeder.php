<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name_ar' => 'مساج استرخائي',
                'name_en' => 'Relaxation Massage',
                'description_ar' => 'جلسة مساج استرخائي كامل للجسم باستخدام زيوت طبيعية',
                'description_en' => 'Full body relaxation massage using natural oils',
                'price' => 250,
                'duration' => 60,
                'sort_order' => 1,
                'is_featured' => true,
            ],
            [
                'name_ar' => 'علاج وجه متقدم',
                'name_en' => 'Advanced Facial Treatment',
                'description_ar' => 'علاج متقدم للوجه لتنقية البشرة وتجديد خلاياها',
                'description_en' => 'Advanced facial treatment for skin cleansing and rejuvenation',
                'price' => 350,
                'duration' => 90,
                'sort_order' => 2,
                'is_featured' => true,
            ],
            [
                'name_ar' => 'حمام مغربي',
                'name_en' => 'Moroccan Bath',
                'description_ar' => 'حمام مغربي تقليدي مع صابون بلدي وزيت أركان',
                'description_en' => 'Traditional Moroccan bath with beldi soap and argan oil',
                'price' => 400,
                'duration' => 120,
                'sort_order' => 3,
                'is_featured' => true,
            ],
            [
                'name_ar' => 'باديكير ومنيكير',
                'name_en' => 'Pedicure & Manicure',
                'description_ar' => 'عناية كاملة باليدين والقدمين مع طلاء أظافر احترافي',
                'description_en' => 'Complete hand and foot care with professional nail polish',
                'price' => 180,
                'duration' => 60,
                'sort_order' => 4,
                'is_featured' => false,
            ],
            [
                'name_ar' => 'مساج بالحجارة الساخنة',
                'name_en' => 'Hot Stone Massage',
                'description_ar' => 'مساج علاجي باستخدام الحجارة البركانية الساخنة',
                'description_en' => 'Therapeutic massage using hot volcanic stones',
                'price' => 300,
                'duration' => 75,
                'sort_order' => 5,
                'is_featured' => true,
            ],
            [
                'name_ar' => 'علاج الجسم بالطين',
                'name_en' => 'Body Mud Treatment',
                'description_ar' => 'لفائف الطين الطبيعي لتنقية الجسم وإزالة السموم',
                'description_en' => 'Natural mud wraps for body detoxification',
                'price' => 280,
                'duration' => 90,
                'sort_order' => 6,
                'is_featured' => false,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
