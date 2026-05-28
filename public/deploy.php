<?php
/**
 * GitHub Auto-Deploy
 * Place in public/ folder on your server
 * Visit: https://jenincare.shop/public/deploy.php?token=jenincare2026
 * This pulls latest code from GitHub + runs migrations + clears caches
 */

$SECRET_TOKEN = 'jenincare2026';

if (($_GET['token'] ?? '') !== $SECRET_TOKEN) {
    header('HTTP/1.0 403 Forbidden');
    die('Access denied. Use ?token=jenincare2026');
}

header('Content-Type: text/html; charset=utf-8');
echo '<!DOCTYPE html><html dir="rtl"><head><meta charset="utf-8"><title>Deploy</title>';
echo '<style>body{font-family:Arial;background:#1a1a2e;color:#e0e0e0;padding:20px;line-height:1.8;direction:rtl}';
echo '.ok{color:#00ff88}.err{color:#ff6b6b}.info{color:#60a5fa}pre{background:#0f0f23;padding:10px;border-radius:8px;overflow-x:auto}</style>';
echo '</head><body><h1>JeninCare Deploy</h1>';

function run($cmd, $desc = '') {
    $output = []; $code = 0;
    exec($cmd . ' 2>&1', $output, $code);
    $color = $code === 0 ? 'ok' : 'err';
    echo "<p class='$color'><b>$desc</b> (exit: $code)</p>";
    if (!empty($output)) echo '<pre>' . implode("\n", $output) . '</pre>';
}

echo '<p class="info">' . date('Y-m-d H:i:s') . ' — Starting deploy...</p>';

$root = dirname(__DIR__);

// 1. Git pull
run("cd $root && git pull origin main 2>&1", '1. Git Pull');

// 2. Composer install (if composer.json changed)
if (file_exists($root . '/composer.json')) {
    run("cd $root && php ~/bin/composer install --no-interaction --prefer-dist --optimize-autoloader 2>&1", '2. Composer Install');
}

// 3. Database migrations
run("cd $root && php artisan migrate --force 2>&1", '3. Database Migrations');

// 4. Clear all caches
run("cd $root && php artisan view:clear 2>&1", '4. Clear Views');
run("cd $root && php artisan cache:clear 2>&1", '5. Clear Cache');
run("cd $root && php artisan config:clear 2>&1", '6. Clear Config');
run("cd $root && php artisan route:clear 2>&1", '7. Clear Routes');

echo '<h2 style="color:#00ff88">DEPLOY COMPLETE</h2>';
echo '<p><a href="/">Visit Homepage</a> | <a href="/admin">Visit Admin</a></p>';
echo '</body></html>';
