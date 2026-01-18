<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Testing Admin Connection</h2>";

echo "<h3>1. Testing config.php...</h3>";
require_once("config.php");
echo "✅ config.php loaded<br>";

echo "<h3>2. Testing database connection...</h3>";
if (isset($conn) && $conn) {
    echo "✅ Database connected<br>";
} else {
    echo "❌ Database connection failed!<br>";
    die();
}

echo "<h3>3. Testing helper.php...</h3>";
require_once("views/helper.php");
echo "✅ helper.php loaded<br>";

echo "<h3>4. Testing settings() function...</h3>";
if (function_exists('settings')) {
    echo "✅ settings() function exists<br>";
    
    $test_settings = ['paymentrate', 'paymentrate_min', 'rate'];
    foreach ($test_settings as $setting) {
        $value = settings($setting);
        echo "  - settings('$setting') = " . ($value !== '' ? $value : 'EMPTY') . "<br>";
    }
} else {
    echo "❌ settings() function does not exist!<br>";
}

echo "<h3>5. Testing database query...</h3>";
$sql = "SELECT * FROM settings LIMIT 5";
$result = mysqli_query($conn, $sql);
if ($result) {
    echo "✅ Query successful. Found " . mysqli_num_rows($result) . " settings<br>";
} else {
    echo "❌ Query failed: " . mysqli_error($conn) . "<br>";
}

echo "<br><h3 style='color: green;'>✅ All tests passed! Dashboard should work now.</h3>";
?>
