<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'config/db.php';

echo "<h1>Database Import Script</h1>";
echo "<p>Database: " . (defined('DB_NAME') ? DB_NAME : 'unknown') . "</p>";

try {
    // Insert Settings
    echo "<h2>Inserting Settings...</h2>";
    $settings = [
        ['company_address_ar', 'البيرة، بيت المحسري، بجانب جوال'],
        ['company_address_en', 'Al-Bireh, Beit Al-Muhasri, beside Jawwal'],
        ['company_name_ar', 'شركة سوى لتأجير السيارات'],
        ['company_name_en', 'Sawa Rent Car'],
        ['company_phone_1', '0597492182'],
        ['company_phone_2', '0599930120'],
        ['company_working_hours_ar', 'يومياً من 8:00 صباحاً - 10:00 مساءً'],
        ['company_working_hours_en', 'Daily from 8:00 AM - 10:00 PM'],
        ['pay_enable_cash', '1'],
        ['pay_enable_jawwal', '1'],
        ['pay_cards_mode', 'sandbox'],
        ['price_day_1', '120'],
        ['price_day_3', '330'],
        ['price_day_10', '1000'],
        ['price_day_15', '1350'],
        ['price_day_20', '1700'],
        ['price_day_30', '2400'],
        ['price_monthly', '2300'],
        ['site_theme', 'blue'],
        ['site_url', 'https://sawarentcar.online'],
        ['social_facebook', 'https://www.facebook.com/Sawarentcar'],
    ];
    
    $stmt = db()->prepare('INSERT INTO settings (k, v) VALUES (:k, :v) ON DUPLICATE KEY UPDATE v = VALUES(v)');
    foreach ($settings as $s) {
        $stmt->execute([':k' => $s[0], ':v' => $s[1]]);
        echo "✓ {$s[0]}<br>";
    }
    echo "<p>Settings inserted: " . count($settings) . "</p>";

    // Insert User
    echo "<h2>Inserting Admin User...</h2>";
    $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);
    db()->prepare('INSERT INTO users (username, password_hash, role) VALUES (:u, :p, :r) ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash)')
        ->execute([':u' => 'admin', ':p' => $passwordHash, ':r' => 'superadmin']);
    echo "✓ Admin user created (admin / admin123)<br>";

    // Insert Car
    echo "<h2>Inserting Car...</h2>";
    db()->prepare('INSERT INTO cars (name_ar, name_en, type_ar, type_en, daily_price, monthly_price, is_active) VALUES (:n, :ne, :t, :te, :d, :m, :a) ON DUPLICATE KEY UPDATE name_ar = VALUES(name_ar)')
        ->execute([
            ':n' => 'كيا سيراتو',
            ':ne' => 'Kia Cerato',
            ':t' => 'سيدان',
            ':te' => 'Sedan',
            ':d' => 120.00,
            ':m' => 2300.00,
            ':a' => 1
        ]);
    echo "✓ Car: كيا سيراتو<br>";

    // Insert Slide
    echo "<h2>Inserting Slide...</h2>";
    db()->prepare('INSERT INTO slides (title_ar, title_en, subtitle_ar, subtitle_en, image_path, sort_order, is_active) VALUES (:t, :te, :s, :se, :i, :o, :a) ON DUPLICATE KEY UPDATE title_ar = VALUES(title_ar)')
        ->execute([
            ':t' => 'انطلق في رحلتك مع سوى',
            ':te' => 'Start your trip with Sawa',
            ':s' => 'أحدث السيارات، أفضل الأسعار، وخدمة ممتازة.',
            ':se' => 'Modern cars, great prices, and great service.',
            ':i' => 'uploads/slide_1.png',
            ':o' => 1,
            ':a' => 1
        ]);
    echo "✓ Slide created<br>";

    // Verify
    echo "<h2>Verification</h2>";
    $settingsCount = db()->query('SELECT COUNT(*) as c FROM settings')->fetch()['c'];
    $usersCount = db()->query('SELECT COUNT(*) as c FROM users')->fetch()['c'];
    $carsCount = db()->query('SELECT COUNT(*) as c FROM cars')->fetch()['c'];
    $slidesCount = db()->query('SELECT COUNT(*) as c FROM slides')->fetch()['c'];
    
    echo "<p>Settings: $settingsCount</p>";
    echo "<p>Users: $usersCount</p>";
    echo "<p>Cars: $carsCount</p>";
    echo "<p>Slides: $slidesCount</p>";

    echo "<h2 style='color:green'>Import Complete!</h2>";
    echo "<p><a href='index.php'>View Website</a></p>";
    echo "<p><a href='admin/'>Admin Panel</a></p>";

} catch (Throwable $e) {
    echo "<h2 style='color:red'>Error:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
}
?>
