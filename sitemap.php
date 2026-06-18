<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

header('Content-Type: application/xml; charset=UTF-8');
header('X-Robots-Tag: noindex', true);

$base = base_url();
if ($base === '') {
    $base = '';
}

$lang = current_lang();
$cars = cars_active();
$offers = offers_active();

$urls = [];

$urls[] = [
    'loc' => abs_url('index.php'), 
    'priority' => '1.0', 
    'changefreq' => 'daily',
    'lastmod' => date('Y-m-d')
];

$urls[] = [
    'loc' => abs_url('special-deal.php'), 
    'priority' => '0.9', 
    'changefreq' => 'daily',
    'lastmod' => date('Y-m-d')
];

$urls[] = [
    'loc' => abs_url('privacy.php'), 
    'priority' => '0.3', 
    'changefreq' => 'monthly',
    'lastmod' => date('Y-m-d', strtotime('-30 days'))
];

$urls[] = [
    'loc' => abs_url('terms.php'), 
    'priority' => '0.3', 
    'changefreq' => 'monthly',
    'lastmod' => date('Y-m-d', strtotime('-30 days'))
];

$urls[] = [
    'loc' => abs_url('payment_methods.php'), 
    'priority' => '0.4', 
    'changefreq' => 'monthly',
    'lastmod' => date('Y-m-d', strtotime('-30 days'))
];

$urls[] = [
    'loc' => abs_url('faq.php'), 
    'priority' => '0.6', 
    'changefreq' => 'monthly',
    'lastmod' => date('Y-m-d', strtotime('-30 days'))
];

// Blog pages
$urls[] = [
    'loc' => abs_url('blog.php'), 
    'priority' => '0.8', 
    'changefreq' => 'weekly',
    'lastmod' => date('Y-m-d'),
    'image' => 'uploads/blog-online-rental.svg'
];

$blog_slugs = ['guide-online-rental', 'choose-right-car', 'common-mistakes', 'first-time-rental-guide', 'best-tourist-destinations', 'car-rental-prices-comparison'];
foreach ($blog_slugs as $slug) {
    $urls[] = [
        'loc' => abs_url('blog-post.php?slug=' . $slug), 
        'priority' => '0.7', 
        'changefreq' => 'monthly',
        'lastmod' => date('Y-m-d'),
        'image' => 'uploads/blog-' . $slug . '.svg'
    ];
}

foreach ($offers as $o) {
    $offerId = (int)($o['id'] ?? 0);
    $offerImage = '';
    if (!empty($o['image_path'])) {
        $offerImage = $o['image_path'];
    } elseif (!empty($o['car_image_path'])) {
        $offerImage = $o['car_image_path'];
    }
    
    $urls[] = [
        'loc' => abs_url('offer.php?id=' . $offerId), 
        'priority' => '0.8', 
        'changefreq' => 'weekly',
        'lastmod' => date('Y-m-d'),
        'image' => $offerImage
    ];
}

foreach ($cars as $c) {
    $carId = (int)($c['id'] ?? 0);
    $carImage = $c['image_path'] ?? '';
    
    $urls[] = [
        'loc' => abs_url('car.php?id=' . $carId), 
        'priority' => '0.7', 
        'changefreq' => 'weekly',
        'lastmod' => date('Y-m-d'),
        'image' => $carImage
    ];
}

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
         xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
         xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach ($urls as $url): ?>
  <url>
    <loc><?= e($url['loc']) ?></loc>
    <lastmod><?= e($url['lastmod'] ?? date('Y-m-d')) ?></lastmod>
    <changefreq><?= e($url['changefreq']) ?></changefreq>
    <priority><?= e($url['priority']) ?></priority>
    <?php if (!empty($url['image'])): ?>
    <image:image>
      <image:loc><?= e(asset_url($url['image'])) ?></image:loc>
      <image:title>Sawa Rent Car</image:title>
    </image:image>
    <?php endif; ?>
    <xhtml:link rel="alternate" hreflang="ar" href="<?= e(str_replace('/en/', '/ar/', $url['loc'])) ?>"/>
    <xhtml:link rel="alternate" hreflang="en" href="<?= e(str_replace('/ar/', '/en/', $url['loc'])) ?>"/>
    <xhtml:link rel="alternate" hreflang="x-default" href="<?= e($url['loc']) ?>"/>
  </url>
<?php endforeach; ?>
</urlset>
