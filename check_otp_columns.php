<?php
require_once("config.php");

// Check if columns exist
echo "<h2>Checking OTP columns in orders table:</h2>";

$check_otp = mysqli_query($conn, "SHOW COLUMNS FROM orders LIKE 'otp_code'");
$check_de = mysqli_query($conn, "SHOW COLUMNS FROM orders LIKE 'de_checkbox'");

echo "<p>otp_code column exists: " . (mysqli_num_rows($check_otp) > 0 ? "YES ✓" : "NO ✗") . "</p>";
echo "<p>de_checkbox column exists: " . (mysqli_num_rows($check_de) > 0 ? "YES ✓" : "NO ✗") . "</p>";

// Check if there's any data
echo "<h2>Checking for orders with OTP codes:</h2>";
$result = mysqli_query($conn, "SELECT order_id, otp_code, de_checkbox FROM orders WHERE otp_code IS NOT NULL AND otp_code != '' LIMIT 10");
if ($result && mysqli_num_rows($result) > 0) {
    echo "<p>Found " . mysqli_num_rows($result) . " orders with OTP codes:</p>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Order ID</th><th>OTP Code</th><th>DE Checkbox</th></tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['otp_code'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['de_checkbox'] ?? 0) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>No orders found with OTP codes in the database.</p>";
}

// Check recent orders
echo "<h2>Recent 5 orders (all columns):</h2>";
$result2 = mysqli_query($conn, "SELECT order_id, otp_code, de_checkbox, created_date FROM orders ORDER BY order_id DESC LIMIT 5");
if ($result2 && mysqli_num_rows($result2) > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Order ID</th><th>Created Date</th><th>OTP Code</th><th>DE Checkbox</th></tr>";
    while ($row = mysqli_fetch_array($result2)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['created_date'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['otp_code'] ?? 'NULL/EMPTY') . "</td>";
        echo "<td>" . ($row['de_checkbox'] ?? 'NULL/0') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Test SELECT query similar to tracks.php
echo "<h2>Testing SELECT query (like tracks.php):</h2>";
$start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'))." 00:00:00";
$sql = "SELECT * FROM orders WHERE created_date>'$start_date' AND is_online='1' AND (boxed=0 OR boxed IS NULL) ORDER BY order_id DESC LIMIT 5";
$result3 = mysqli_query($conn, $sql);
if ($result3 && mysqli_num_rows($result3) > 0) {
    echo "<p>Query executed successfully. Checking if otp_code is in result:</p>";
    $row = mysqli_fetch_array($result3);
    echo "<pre>";
    echo "Keys in result array:\n";
    print_r(array_keys($row));
    echo "\n\nSample row data:\n";
    echo "order_id: " . ($row['order_id'] ?? 'NOT SET') . "\n";
    echo "otp_code: " . (isset($row['otp_code']) ? "'" . $row['otp_code'] . "'" : 'NOT SET') . "\n";
    echo "de_checkbox: " . (isset($row['de_checkbox']) ? $row['de_checkbox'] : 'NOT SET') . "\n";
    echo "</pre>";
} else {
    echo "<p style='color: red;'>No results from test query.</p>";
}
?>
