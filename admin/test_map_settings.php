<?php
// Simple test for map settings functionality
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/auth.php';

// Test if the required functions exist
echo "<h2>Map Settings Test</h2>";

echo "<h3>1. Testing helpers.php inclusion:</h3>";
if (function_exists('db')) {
    echo "✅ db() function exists<br>";
} else {
    echo "❌ db() function missing<br>";
}

if (function_exists('setting')) {
    echo "✅ setting() function exists<br>";
} else {
    echo "❌ setting() function missing<br>";
}

if (function_exists('current_lang')) {
    echo "✅ current_lang() function exists<br>";
} else {
    echo "❌ current_lang() function missing<br>";
}

echo "<h3>2. Testing auth.php inclusion:</h3>";
if (function_exists('require_roles')) {
    echo "✅ require_roles() function exists<br>";
} else {
    echo "❌ require_roles() function missing<br>";
}

if (function_exists('admin_role')) {
    echo "✅ admin_role() function exists<br>";
} else {
    echo "❌ admin_role() function missing<br>";
}

echo "<h3>3. Testing map_functions.php inclusion:</h3>";
if (file_exists(__DIR__ . '/../includes/map_functions.php')) {
    echo "✅ map_functions.php file exists<br>";
    require_once __DIR__ . '/../includes/map_functions.php';
    
    if (function_exists('get_map_config')) {
        echo "✅ get_map_config() function exists<br>";
    } else {
        echo "❌ get_map_config() function missing<br>";
    }
    
    if (function_exists('render_footer_map')) {
        echo "✅ render_footer_map() function exists<br>";
    } else {
        echo "❌ render_footer_map() function missing<br>";
    }
} else {
    echo "❌ map_functions.php file missing<br>";
}

echo "<h3>4. Testing database connection:</h3>";
try {
    $db = db();
    echo "✅ Database connection successful<br>";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

echo "<h3>5. Testing settings table:</h3>";
try {
    $stmt = db()->prepare("SELECT COUNT(*) as count FROM settings");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Settings table accessible, records: " . $result['count'] . "<br>";
} catch (Exception $e) {
    echo "❌ Settings table error: " . $e->getMessage() . "<br>";
}

echo "<h3>6. Testing map config retrieval:</h3>";
try {
    $config = get_map_config();
    echo "✅ Map config retrieved successfully<br>";
    echo "Latitude: " . $config['latitude'] . "<br>";
    echo "Longitude: " . $config['longitude'] . "<br>";
    echo "Zoom: " . $config['zoom'] . "<br>";
} catch (Exception $e) {
    echo "❌ Map config error: " . $e->getMessage() . "<br>";
}

echo "<h3>7. File paths test:</h3>";
echo "Current directory: " . __DIR__ . "<br>";
echo "Helpers path: " . __DIR__ . '/../includes/helpers.php' . "<br>";
echo "Auth path: " . __DIR__ . '/../includes/auth.php' . "<br>";
echo "Map functions path: " . __DIR__ . '/../includes/map_functions.php' . "<br>";

echo "<h3>8. Test completed!</h3>";
echo "<p><a href='map_settings.php'>Go to Map Settings</a></p>";
?>
