<?php
/**
 * Check Required Database Tables
 * This script checks if all required tables exist for the homepage
 */

require_once("config.php");

if (!$conn) {
    die("❌ Database connection failed!");
}

echo "<h2>Database Tables Check for Homepage</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr><th>Table Name</th><th>Status</th><th>Row Count</th><th>Required For</th></tr>";

$required_tables = [
    'sliders' => 'Homepage carousel/slider images',
    'shops' => 'Featured shops section',
    'advantages' => 'Mini services section',
    'pages' => 'Page content (page_id 14, 15)',
    'testimonial' => 'Testimonials section',
    'settings' => 'Site settings (tel, email, social links)'
];

$all_exist = true;

foreach ($required_tables as $table => $purpose) {
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    $exists = mysqli_num_rows($result) > 0;
    
    if ($exists) {
        $count_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM `$table`");
        $count_data = mysqli_fetch_assoc($count_result);
        $count = $count_data['count'];
        $status = "✅ EXISTS";
        $color = "green";
    } else {
        $count = 0;
        $status = "❌ MISSING";
        $color = "red";
        $all_exist = false;
    }
    
    echo "<tr>";
    echo "<td><strong>$table</strong></td>";
    echo "<td style='color: $color;'>$status</td>";
    echo "<td>$count rows</td>";
    echo "<td>$purpose</td>";
    echo "</tr>";
}

echo "</table>";

// Check specific page IDs
echo "<br><h3>Checking Required Page Content:</h3>";
$page_ids = [14, 15];
foreach ($page_ids as $page_id) {
    $result = mysqli_query($conn, "SELECT * FROM pages WHERE page_id = $page_id");
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo "✅ Page ID $page_id exists: <strong>" . ($data['title'] ?? 'No title') . "</strong><br>";
    } else {
        echo "❌ Page ID $page_id is missing!<br>";
        $all_exist = false;
    }
}

// Check settings
echo "<br><h3>Checking Required Settings:</h3>";
$required_settings = ['tel', 'email', 'facebook', 'youtube', 'instagram', 'footer_text'];
foreach ($required_settings as $setting) {
    $result = mysqli_query($conn, "SELECT * FROM settings WHERE shortname = '$setting'");
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo "✅ Setting '$setting' exists<br>";
    } else {
        echo "⚠️ Setting '$setting' is missing<br>";
    }
}

if ($all_exist) {
    echo "<br><h2 style='color: green;'>✅ All required tables exist! Homepage should work.</h2>";
} else {
    echo "<br><h2 style='color: red;'>❌ Some required tables are missing. Please create them.</h2>";
}

mysqli_close($conn);
?>
