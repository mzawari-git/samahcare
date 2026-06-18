<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/init.php';

if (!admin_auth()) {
    die('Admin only');
}

echo "<h1>WebP Conversion Tool</h1>";

$dir = UPLOADS_DIR;
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$count = 0;

foreach ($iterator as $file) {
    if ($file->isFile() && in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png'])) {
        $relPath = substr($file->getPathname(), strlen($dir) + 1);
        echo "Converting: $relPath<br>";
        webpify_image($relPath);
        $count++;
    }
}

echo "<p>✅ Converted $count images to WebP. <a href='index.php'>Back</a></p>";
?>

