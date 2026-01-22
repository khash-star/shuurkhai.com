<?php
require_once("config.php");

// Check if columns exist and add them if they don't
$columns_to_add = [
    'otp_code' => "VARCHAR(6) DEFAULT NULL COMMENT 'OTP код'",
    'de_checkbox' => "TINYINT(1) DEFAULT 0 COMMENT 'DE checkbox'"
];

echo "<h2>Database Column Update</h2>";
echo "<pre>";

foreach ($columns_to_add as $column_name => $column_definition) {
    // Check if column exists
    $check_sql = "SHOW COLUMNS FROM orders LIKE '$column_name'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if ($check_result && mysqli_num_rows($check_result) > 0) {
        echo "Column '$column_name' already exists. Skipping...\n";
    } else {
        // Add column
        $alter_sql = "ALTER TABLE orders ADD COLUMN $column_name $column_definition";
        if (mysqli_query($conn, $alter_sql)) {
            echo "✓ Successfully added column '$column_name'\n";
        } else {
            echo "✗ Error adding column '$column_name': " . mysqli_error($conn) . "\n";
        }
    }
}

echo "</pre>";
echo "<p><a href='javascript:history.back()'>Буцах</a></p>";
?>
