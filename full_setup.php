<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "<h1>Complete Database Setup</h1>";

// Database credentials
$host = 'localhost';
$dbname = 'u920699383_sawa';
$user = 'u920699383_sawa';
$pass = 'Mohammed@#!135';

try {
    echo "<p>Connecting to database...</p>";
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "<p style='color:green'>✓ Connected!</p>";

    // Settings
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
    
    foreach ($settings as $s) {
        $pdo->prepare('INSERT INTO settings (k, v) VALUES (?, ?) ON DUPLICATE KEY UPDATE v = VALUES(v)')->execute([$s[0], $s[1]]);
        echo "✓ {$s[0]}<br>";
    }

    // Admin User
    echo "<h2>Creating Admin User...</h2>";
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->prepare('DELETE FROM users WHERE username = ?')->execute(['admin']);
    $pdo->prepare('INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)')->execute(['admin', $hash, 'superadmin']);
    echo "✓ Admin user: admin / admin123<br>";

    // Car
    echo "<h2>Adding Car...</h2>";
    $pdo->prepare('DELETE FROM cars WHERE name_ar = ?')->execute(['كيا سيراتو']);
    $pdo->prepare('INSERT INTO cars (name_ar, name_en, type_ar, type_en, daily_price, monthly_price, is_active, is_offer, offer_details_ar, offer_details_en) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')->execute([
        'كيا سيراتو', 'Kia Cerato', 'سيدان', 'Sedan', 120.00, 2300.00, 1, 0,
        'أفضل الأسعار للباقات اليومية والأسبوعية والشهرية',
        'Best prices for daily, weekly and monthly packages'
    ]);
    $carId = $pdo->lastInsertId();
    echo "✓ Car ID: $carId<br>";

    // Slide
    echo "<h2>Adding Slide...</h2>";
    $pdo->prepare('DELETE FROM slides WHERE title_ar = ?')->execute(['انطلق في رحلتك مع سوى']);
    $pdo->prepare('INSERT INTO slides (title_ar, title_en, subtitle_ar, subtitle_en, image_path, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)')->execute([
        'انطلق في رحلتك مع سوى', 'Start your trip with Sawa',
        'أحدث السيارات، أفضل الأسعار، وخدمة ممتازة.',
        'Modern cars, great prices, and great service.',
        'uploads/slide_1.png', 1, 1
    ]);
    echo "✓ Slide added<br>";

    // Fix Config File
    echo "<h2>Fixing Config File...</h2>";
    $configContent = '<?php
declare(strict_types=1);
ini_set(\'display_errors\', \'0\');
ini_set(\'display_startup_errors\', \'0\');
error_reporting(0);

define(\'APP_NAME\', \'Sawa Rent Car\');
define(\'DEFAULT_LANG\', \'ar\');

function env_str(string $key, string $default): string {
    $v = getenv($key);
    if ($v === false || $v === \'\') { return $default; }
    return (string)$v;
}

$defaultDbHost = \'localhost\';
$defaultDbName = \'u920699383_sawa\';
$defaultDbUser = \'u920699383_sawa\';
$defaultDbPass = \'Mohammed@#!135\';

define(\'DB_HOST\', env_str(\'DB_HOST\', $defaultDbHost));
define(\'DB_NAME\', env_str(\'DB_NAME\', $defaultDbName));
define(\'DB_USER\', env_str(\'DB_USER\', $defaultDbUser));
define(\'DB_PASS\', env_str(\'DB_PASS\', $defaultDbPass));

$dbPortEnv = getenv(\'DB_PORT\');
define(\'DB_PORT\', $dbPortEnv !== false && $dbPortEnv !== \'\' ? (int)$dbPortEnv : 3306);

define(\'UPLOADS_DIR\', __DIR__ . \'/../uploads\');
define(\'UPLOADS_URL\', \'uploads\');

define(\'CARS_SOURCE_DIR\', \'\');
';

    if (file_put_contents('config/config.php', $configContent)) {
        echo "✓ config.php updated<br>";
    } else {
        echo "<p style='color:orange'>⚠ Could not write config.php - please manually update it</p>";
    }

    // Verify
    echo "<h2>Verification</h2>";
    $counts = [
        'Settings' => $pdo->query('SELECT COUNT(*) FROM settings')->fetchColumn(),
        'Users' => $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn(),
        'Cars' => $pdo->query('SELECT COUNT(*) FROM cars')->fetchColumn(),
        'Slides' => $pdo->query('SELECT COUNT(*) FROM slides')->fetchColumn(),
    ];
    foreach ($counts as $name => $count) {
        echo "<p>$name: $count</p>";
    }

    echo "<h2 style='color:green'>✓ Setup Complete!</h2>";
    echo "<p><a href='index.php'>View Website</a> | <a href='admin/'>Admin Panel</a></p>";
    echo "<p>Admin Login: admin / admin123</p>";

} catch (Throwable $e) {
    echo "<h2 style='color:red'>Error:</h2>";
    echo "<p>" . nl2br(htmlspecialchars($e->getMessage())) . "</p>";
}
?>
