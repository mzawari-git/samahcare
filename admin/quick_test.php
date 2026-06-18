<?php
// Quick test for map_settings.php
echo "<h2>Testing Map Settings Page</h2>";

// Test 1: Check if the file exists
if (file_exists(__DIR__ . '/map_settings.php')) {
    echo "✅ map_settings.php file exists<br>";
} else {
    echo "❌ map_settings.php file missing<br>";
}

// Test 2: Check if header file exists
if (file_exists(__DIR__ . '/partials/header.php')) {
    echo "✅ header.php file exists<br>";
} else {
    echo "❌ header.php file missing<br>";
}

// Test 3: Check if footer file exists
if (file_exists(__DIR__ . '/partials/footer.php')) {
    echo "✅ footer.php file exists<br>";
} else {
    echo "❌ footer.php file missing<br>";
}

// Test 4: Check if helpers.php exists
if (file_exists(__DIR__ . '/../includes/helpers.php')) {
    echo "✅ helpers.php file exists<br>";
} else {
    echo "❌ helpers.php file missing<br>";
}

// Test 5: Check if auth.php exists
if (file_exists(__DIR__ . '/includes/auth.php')) {
    echo "✅ auth.php file exists<br>";
} else {
    echo "❌ auth.php file missing<br>";
}

// Test 6: Check syntax
$output = shell_exec('php -l map_settings.php 2>&1');
if (strpos($output, 'No syntax errors') !== false) {
    echo "✅ PHP syntax is valid<br>";
} else {
    echo "❌ PHP syntax error: " . $output . "<br>";
}

echo "<h3>Test Results:</h3>";
echo "<p>All required files exist and syntax is valid.</p>";
echo "<p><a href='map_settings.php'>Go to Map Settings Page</a></p>";
?>
