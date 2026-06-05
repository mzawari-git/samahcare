<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\MarketingSetting;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class SeoService
{
    public function getAllPageSeoData(): array
    {
        $pages = [];

        $pages[] = $this->getPageSeo('home', 'الرئيسية', route('home'), $this->getHomeSeo());
        $pages[] = $this->getPageSeo('booking', 'الخدمات', route('booking.index'), $this->getBookingSeo());
        $pages[] = $this->getPageSeo('blog', 'المدونة', route('blog.index'), $this->getBlogSeo());
        $pages[] = $this->getPageSeo('contact', 'تواصلي معنا', route('contact'), $this->getContactSeo());
        $pages[] = $this->getPageSeo('faq', 'الأسئلة الشائعة', route('faq'), $this->getFaqSeo());
        $pages[] = $this->getPageSeo('terms', 'الشروط والأحكام', route('terms'), $this->getTermsSeo());
        $pages[] = $this->getPageSeo('privacy', 'سياسة الخصوصية', route('privacy'), $this->getPrivacySeo());
        $pages[] = $this->getPageSeo('login', 'تسجيل الدخول', route('login'), $this->getLoginSeo());
        $pages[] = $this->getPageSeo('register', 'إنشاء حساب', route('register'), $this->getRegisterSeo());

        $services = Service::where('is_active', true)->get();
        foreach ($services as $service) {
            $pages[] = $this->getPageSeo(
                'service_' . $service->id,
                $service->name_ar ?? $service->name,
                route('booking.service', $service->id),
                $this->getServiceSeo($service)
            );
        }

        $posts = BlogPost::where('is_published', true)->get();
        foreach ($posts as $post) {
            $pages[] = $this->getPageSeo(
                'blog_' . $post->id,
                $post->title_ar ?? $post->title,
                route('blog.show', $post->slug),
                $this->getBlogPostSeo($post)
            );
        }

        return $pages;
    }

    private function getPageSeo(string $key, string $title, string $url, array $defaults): array
    {
        $saved = Setting::get("seo_{$key}", null);

        return [
            'key' => $key,
            'title' => $title,
            'url' => $url,
            'meta_title' => $saved['meta_title'] ?? $defaults['meta_title'],
            'meta_description' => $saved['meta_description'] ?? $defaults['meta_description'],
            'og_title' => $saved['og_title'] ?? $defaults['og_title'],
            'og_description' => $saved['og_description'] ?? $defaults['og_description'],
            'og_image' => $saved['og_image'] ?? $defaults['og_image'],
            'keywords' => $saved['keywords'] ?? $defaults['keywords'],
            'schema_type' => $saved['schema_type'] ?? $defaults['schema_type'],
            'is_saved' => $saved !== null,
        ];
    }

    private function getHomeSeo(): array
    {
        return [
            'meta_title' => 'سماح كير | منصة الحجز والخدمات الجمالية الأولى في فلسطين',
            'meta_description' => 'سماح كير - وجهتك الأولى لحجز خدمات العناية بالبشرة والشعر والتجميل في جنين. احجزي موعدك الآن بسهولة واستمتعي بتجربة جمالية استثنائية.',
            'og_title' => 'سماح كير | خدمات جمالية فاخرة في فلسطين',
            'og_description' => 'احجزي خدمات العناية بالبشرة والشعر والتجميل في سماح كير. خبيرات معتمدات، منتجات أصلية، أسعار منافسة.',
            'og_image' => asset('images/og-home.jpg'),
            'keywords' => 'سماح كير, حجز موعد, عناية بالبشرة, عناية بالشعر, تجميل, صالون, جمال, فلسطين, جنين',
            'schema_type' => 'WebSite',
        ];
    }

    private function getBookingSeo(): array
    {
        return [
            'meta_title' => 'الخدمات | سماح كير - حجز خدمات العناية بالبشرة والجمال',
            'meta_description' => 'تصفحي خدماتنا: العناية بالبشرة، المكياج، العناية بالشعر، العناية بالأظافر. احجزي موعدكِ الآن مع خبيرات معتمدات.',
            'og_title' => 'خدماتنا | سماح كير',
            'og_description' => 'خدمات عناية بالبشرة وتجميل فاخرة بأيدي خبيرات معتمدات.',
            'og_image' => asset('images/og-services.jpg'),
            'keywords' => 'خدمات تجميل, عناية بالبشرة, مكياج, عناية بالشعر, باقات, أسعار',
            'schema_type' => 'ItemList',
        ];
    }

    private function getBlogSeo(): array
    {
        return [
            'meta_title' => 'المدونة | نصائح العناية بالبشرة والجمال - سماح كير',
            'meta_description' => 'اكتشفي أحدث نصائح العناية بالبشرة والشعر والمكياج. مقالات متخصصة من خبيرات سماح كير للجمال والعناية.',
            'og_title' => 'مدونة سماح كير - نصائح الجمال',
            'og_description' => 'مقالات ونصائح متخصصة في العناية بالبشرة والشعر والمكياج من خبيرات معتمدات.',
            'og_image' => asset('images/og-blog.jpg'),
            'keywords' => 'مدونة جمال, نصائح عناية بالبشرة, مقالات تجميل, عناية بالشعر, مكياج طبيعي',
            'schema_type' => 'Blog',
        ];
    }

    private function getContactSeo(): array
    {
        return [
            'meta_title' => 'تواصلي معنا | سماح كير - تواصل واستفسارات',
            'meta_description' => 'تواصلي مع سماح كير للاستفسار عن خدماتنا أو حجز موعد. نحن متواجدات يومياً من 9 صباحاً حتى 10 مساءً.',
            'og_title' => 'تواصلي معنا | سماح كير',
            'og_description' => 'تواصلي معنا للاستفسار عن خدماتنا وحجز موعدك.',
            'og_image' => asset('images/og-contact.jpg'),
            'keywords' => 'تواصل معنا, استفسار, حجز موعد, هاتف, بريد إلكتروني',
            'schema_type' => 'ContactPage',
        ];
    }

    private function getFaqSeo(): array
    {
        return [
            'meta_title' => 'الأسئلة الشائعة | إجابات جميع استفساراتك - سماح كير',
            'meta_description' => 'إجابات شاملة على أكثر الأسئلة تكراراً حول خدماتنا وحجوزاتنا وسياساتنا في سماح كير.',
            'og_title' => 'الأسئلة الشائعة | سماح كير',
            'og_description' => 'إجابات شاملة على جميع استفساراتك حول خدماتنا.',
            'og_image' => asset('images/og-faq.jpg'),
            'keywords' => 'أسئلة شائعة, FAQ, استفسارات, سياسات, خدمات',
            'schema_type' => 'FAQPage',
        ];
    }

    private function getTermsSeo(): array
    {
        return [
            'meta_title' => 'الشروط والأحكام | سماح كير',
            'meta_description' => 'الشروط والأحكام الاستخدام لمنصة سماح كير لحجز خدمات العناية بالبشرة والجمال.',
            'og_title' => 'الشروط والأحكام | سماح كير',
            'og_description' => 'الشروط والأحكام الاستخدام لمنصة سماح كير.',
            'og_image' => asset('images/og-default.jpg'),
            'keywords' => 'شروط وأحكام, سياسة الاستخدام',
            'schema_type' => 'WebPage',
        ];
    }

    private function getPrivacySeo(): array
    {
        return [
            'meta_title' => 'سياسة الخصوصية | سماح كير - حماية وأمان بياناتك الشخصية',
            'meta_description' => 'سياسة الخصوصية لمنصة سماح كير. تعرف على كيفية جمع واستخدام وحماية معلوماتك الشخصية، بيانات الدفع، وحقوقك الكاملة في الخصوصية وأمان المعلومات.',
            'og_title' => 'سياسة الخصوصية | سماح كير - حماية وأمان بياناتك الشخصية',
            'og_description' => 'سياسة الخصوصية لمنصة سماح كير - نوضح كيفية جمع واستخدام وحماية معلوماتك الشخصية عند استخدام خدماتنا.',
            'og_image' => asset('images/og-default.jpg'),
            'keywords' => 'سياسة الخصوصية, الخصوصية, سماح كير, حماية البيانات, أمن المعلومات, خصوصية المستخدمين, حقوق البيانات, معلومات شخصية',
            'schema_type' => 'WebPage',
        ];
    }

    private function getLoginSeo(): array
    {
        return [
            'meta_title' => 'تسجيل الدخول | سماح كير',
            'meta_description' => 'سجلي دخولكِ إلى حسابكِ في سماح كير لإدارة حجوزاتكِ وبياناتكِ.',
            'og_title' => 'تسجيل الدخول | سماح كير',
            'og_description' => 'سجلي دخولكِ إلى حسابكِ.',
            'og_image' => asset('images/og-default.jpg'),
            'keywords' => 'تسجيل دخول, login, حسابي',
            'schema_type' => 'WebPage',
        ];
    }

    private function getRegisterSeo(): array
    {
        return [
            'meta_title' => 'إنشاء حساب جديد | سماح كير',
            'meta_description' => 'سجّلي حسابكِ الجديد في سماح كير واحصلي على تجربة حجز سلسة ومميزة.',
            'og_title' => 'إنشاء حساب | سماح كير',
            'og_description' => 'سجّلي حسابكِ الجديد في سماح كير.',
            'og_image' => asset('images/og-default.jpg'),
            'keywords' => 'إنشاء حساب, تسجيل, حساب جديد',
            'schema_type' => 'WebPage',
        ];
    }

    private function getServiceSeo(Service $service): array
    {
        $name = $service->name_ar ?? $service->name;
        return [
            'meta_title' => "{$name} | سعر和服务 - سماح كير",
            'meta_description' => "احجزي خدمة {$name} في سماح كير. السعر: " . number_format($service->final_price, 2) . " ₪. خبيرات معتمدات، نتائج مضمونة.",
            'og_title' => "{$name} | سماح كير",
            'og_description' => "احجزي خدمة {$name} في سماح كير.",
            'og_image' => $service->image_url ?? asset('images/og-default.jpg'),
            'keywords' => "{$name}, حجز {$name}, سعر {$name}, سماح كير",
            'schema_type' => 'Service',
        ];
    }

    private function getBlogPostSeo(BlogPost $post): array
    {
        $title = $post->title_ar ?? $post->title;
        $excerpt = $post->excerpt_ar ?? $post->excerpt ?? mb_substr(strip_tags($post->content_ar ?? $post->content ?? ''), 0, 160);

        return [
            'meta_title' => "{$title} | سماح كير",
            'meta_description' => $excerpt,
            'og_title' => $title,
            'og_description' => $excerpt,
            'og_image' => $post->image_url ?? asset('images/og-blog.jpg'),
            'keywords' => "{$title}, مقال, نصيحة, عناية بالبشرة, سماح كير",
            'schema_type' => 'Article',
        ];
    }

    public function savePageSeo(string $key, array $data): bool
    {
        return Setting::set("seo_{$key}", $data);
    }

    public function generateAutoSeo(string $key): array
    {
        $pages = $this->getAllPageSeoData();
        $page = collect($pages)->firstWhere('key', $key);

        if (!$page) {
            return ['success' => false, 'message' => 'الصفحة غير موجودة'];
        }

        $autoData = [
            'meta_title' => $page['meta_title'],
            'meta_description' => $this->optimizeDescription($page['meta_description']),
            'og_title' => $page['og_title'],
            'og_description' => $page['og_description'],
            'og_image' => $page['og_image'],
            'keywords' => $page['keywords'],
            'schema_type' => $page['schema_type'],
        ];

        $this->savePageSeo($key, $autoData);

        return ['success' => true, 'message' => 'تم التوليد التلقائي بنجاح', 'data' => $autoData];
    }

    public function generateAllAutoSeo(): array
    {
        $pages = $this->getAllPageSeoData();
        $count = 0;

        foreach ($pages as $page) {
            if (!$page['is_saved']) {
                $this->savePageSeo($page['key'], [
                    'meta_title' => $page['meta_title'],
                    'meta_description' => $page['meta_description'],
                    'og_title' => $page['og_title'],
                    'og_description' => $page['og_description'],
                    'og_image' => $page['og_image'],
                    'keywords' => $page['keywords'],
                    'schema_type' => $page['schema_type'],
                ]);
                $count++;
            }
        }

        return ['success' => true, 'message' => "تم توليد SEO لـ {$count} صفحة"];
    }

    public function generateSchemaMarkup(string $pageType, array $data = []): array
    {
        return match ($pageType) {
            'WebSite' => $this->getWebSiteSchema(),
            'LocalBusiness' => $this->getLocalBusinessSchema(),
            'Service' => $this->getServiceSchema($data),
            'FAQPage' => $this->getFaqSchema(),
            'Article' => $this->getArticleSchema($data),
            'BreadcrumbList' => $this->getBreadcrumbSchema($data),
            'Product' => $this->getProductSchema($data),
            default => [],
        };
    }

    private function getWebSiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'سماح كير',
            'alternateName' => 'Jenin Care',
            'url' => url('/'),
            'description' => 'منصة الحجز والخدمات الجمالية الأولى في فلسطين',
            'inLanguage' => 'ar',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/booking?q={search_term_string}'),
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    private function getLocalBusinessSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BeautySalon',
            'name' => 'سماح كير',
            'alternateName' => 'Jenin Care',
            'url' => url('/'),
            'logo' => asset('images/logo.png'),
            'image' => asset('images/og-home.jpg'),
            'description' => 'منصة الحجز والخدمات الجمالية في جنين، فلسطين. خدمات العناية بالبشرة والشعر والمكياج.',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'جنين',
                'addressCountry' => 'PS',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => 32.4612,
                'longitude' => 35.2981,
            ],
            'telephone' => '',
            'email' => 'info@jenincare.com',
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'opens' => '09:00',
                'closes' => '22:00',
            ],
            'priceRange' => '$$',
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.9',
                'reviewCount' => '500',
            ],
            'sameAs' => [],
        ];
    }

    private function getServiceSchema(array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $data['name'] ?? '',
            'description' => $data['description'] ?? '',
            'provider' => [
                '@type' => 'BeautySalon',
                'name' => 'سماح كير',
            ],
            'areaServed' => [
                '@type' => 'Country',
                'name' => 'Palestine',
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => $data['price'] ?? 0,
                'priceCurrency' => 'ILS',
                'availability' => 'https://schema.org/InStock',
            ],
        ];
    }

    private function getFaqSchema(): array
    {
        $faqItems = [
            [
                '@type' => 'Question',
                'name' => 'كيف أحجز موعد في سماح كير؟',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'يمكنكِ الحجز من خلال موقعنا الإلكتروني أو عبر التواصل معنا على وسائل التواصل الاجتماعي. اخترِ الخدمة والوقت المناسب وسيتم تأكيد حجزكِ فوراً.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'ما هي ساعات العمل؟',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'نعمل يومياً من الساعة 9 صباحاً حتى 10 مساءً، بما في ذلك أيام الجمعة والسبت.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'هل يمكنني إلغاء أو تعديل موعد الحجز؟',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'نعم، يمكنكِ إلغاء أو تعديل موعد الحجز قبل 24 ساعة من موعد الحجز المحدد.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'ما هي طرق الدفع المتاحة؟',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'نقبل الدفع عند الحضور، التحويل البنكي، جوالPay، وReflect.',
                ],
            ],
        ];

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqItems,
        ];
    }

    private function getArticleSchema(array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'image' => $data['image'] ?? '',
            'author' => [
                '@type' => 'Organization',
                'name' => 'سماح كير',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'سماح كير',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
            'datePublished' => $data['date_published'] ?? now()->toIso8601String(),
            'dateModified' => $data['date_modified'] ?? now()->toIso8601String(),
        ];
    }

    private function getBreadcrumbSchema(array $data): array
    {
        $items = $data['items'] ?? [];
        $schemaItems = [];

        foreach ($items as $i => $item) {
            $schemaItems[] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $schemaItems,
        ];
    }

    private function getProductSchema(array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $data['name'] ?? '',
            'description' => $data['description'] ?? '',
            'image' => $data['image'] ?? '',
            'brand' => [
                '@type' => 'Brand',
                'name' => 'سماح كير',
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => $data['price'] ?? 0,
                'priceCurrency' => 'ILS',
                'availability' => 'https://schema.org/InStock',
            ],
        ];
    }

    private function optimizeDescription(string $desc): string
    {
        $desc = trim($desc);
        if (mb_strlen($desc) > 160) {
            $desc = mb_substr($desc, 0, 157) . '...';
        }
        return $desc;
    }

    public function getSeoStats(): array
    {
        $pages = $this->getAllPageSeoData();
        $total = count($pages);

        $seoReady = collect($pages)->filter(fn($p) => $p['is_saved'])->count();
        $missingMeta = collect($pages)->filter(fn($p) => !$p['is_saved'] && empty($p['meta_title']))->count();
        $missingKeywords = collect($pages)->filter(fn($p) => !$p['is_saved'] && empty($p['keywords']))->count();

        $blogMissing = BlogPost::where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('meta_title')->orWhere('meta_title', '');
            })->count();

        return [
            'total' => $total,
            'seo_ready' => $seoReady,
            'missing_meta' => $total - $seoReady,
            'missing_keywords' => $missingKeywords,
            'missing_og' => collect($pages)->filter(fn($p) => !$p['is_saved'])->count(),
            'blog_missing_seo' => $blogMissing,
            'services_total' => Service::where('is_active', true)->count(),
            'services_with_seo' => Service::where('is_active', true)->count(),
        ];
    }
}
