<?php
/**
 * Password Migration Script
 * 
 * Энэ script нь одоогийн plain text/md5 password-уудыг 
 * password_hash() ашиглан hash хийхэд тусална.
 * 
 * АНХААРУУЛГА: Энэ script-ийг ажиллуухаас өмнө database backup хийх!
 * 
 * Ашиглах:
 * 1. Database backup хийх
 * 2. Энэ файлыг browser эсвэл command line-аас ажиллуулах
 * 3. Migration хийгдсэний дараа энэ файлыг устгах
 */

require_once("config.php");

// Security: Зөвхөн admin эсвэл command line-аас ажиллуулах
if (php_sapi_name() !== 'cli') {
    // Browser-аас ажиллуулах бол admin эсэхийг шалгах
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        die("Access denied. This script can only be run by administrators or from command line.");
    }
}

echo "Password Migration Script\n";
echo "========================\n\n";

// 1. Одоогийн password column-ийг шалгах
$check_sql = "SHOW COLUMNS FROM customer LIKE 'password'";
$result = mysqli_query($conn, $check_sql);
if (!$result || mysqli_num_rows($result) == 0) {
    die("Error: 'password' column not found in customer table.\n");
}

// 2. password_hash column нэмэх (хэрэв байхгүй бол)
$check_hash_sql = "SHOW COLUMNS FROM customer LIKE 'password_hash'";
$result_hash = mysqli_query($conn, $check_hash_sql);
if (!$result_hash || mysqli_num_rows($result_hash) == 0) {
    echo "Adding 'password_hash' column...\n";
    $add_column_sql = "ALTER TABLE customer ADD COLUMN password_hash VARCHAR(255) NULL AFTER password";
    if (mysqli_query($conn, $add_column_sql)) {
        echo "✓ 'password_hash' column added successfully.\n\n";
    } else {
        die("Error adding column: " . mysqli_error($conn) . "\n");
    }
}

// 3. Бүх customer-үүдийг авах
$customers_sql = "SELECT customer_id, username, password, password_hash FROM customer WHERE password IS NOT NULL AND password != ''";
$customers_result = mysqli_query($conn, $customers_sql);

if (!$customers_result) {
    die("Error fetching customers: " . mysqli_error($conn) . "\n");
}

$total = mysqli_num_rows($customers_result);
$migrated = 0;
$skipped = 0;
$errors = 0;

echo "Found $total customers with passwords.\n";
echo "Starting migration...\n\n";

// 4. Password-уудыг hash хийх
while ($customer = mysqli_fetch_array($customers_result)) {
    $customer_id = intval($customer['customer_id']);
    $username = $customer['username'] ?? '';
    $old_password = $customer['password'] ?? '';
    $password_hash = $customer['password_hash'] ?? '';
    
    // Хэрэв аль хэдийн hash хийгдсэн бол алгасах
    if (!empty($password_hash) && strlen($password_hash) > 20) {
        echo "Skipping customer ID $customer_id (already hashed)\n";
        $skipped++;
        continue;
    }
    
    // Password hash хийх
    if (!empty($old_password)) {
        $new_hash = password_hash($old_password, PASSWORD_BCRYPT, ['cost' => 12]);
        
        // Database-д хадгалах
        $customer_id_escaped = mysqli_real_escape_string($conn, $customer_id);
        $new_hash_escaped = mysqli_real_escape_string($conn, $new_hash);
        
        $update_sql = "UPDATE customer SET password_hash = '$new_hash_escaped' WHERE customer_id = '$customer_id_escaped' LIMIT 1";
        
        if (mysqli_query($conn, $update_sql)) {
            echo "✓ Migrated customer ID $customer_id (username: $username)\n";
            $migrated++;
        } else {
            echo "✗ Error migrating customer ID $customer_id: " . mysqli_error($conn) . "\n";
            $errors++;
        }
    } else {
        echo "Skipping customer ID $customer_id (empty password)\n";
        $skipped++;
    }
}

echo "\n";
echo "Migration Complete!\n";
echo "===================\n";
echo "Total customers: $total\n";
echo "Migrated: $migrated\n";
echo "Skipped: $skipped\n";
echo "Errors: $errors\n\n";

if ($migrated > 0) {
    echo "IMPORTANT: After verifying the migration works correctly:\n";
    echo "1. Update login.php to use password_hash instead of plain password\n";
    echo "2. Test login functionality\n";
    echo "3. Once confirmed working, you can optionally remove the old 'password' column\n";
    echo "4. Delete this migration script for security\n";
}
