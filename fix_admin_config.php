<?php
/**
 * Quick Fix Script for admin/config.php
 * 
 * This script fixes the database connection issue by updating admin/config.php
 * to use the root config.php instead of hardcoded database credentials.
 * 
 * Usage:
 * 1. Upload this file to: /home/r2c69it0btr1/public_html/shuurkhai_git/
 * 2. Access via browser: https://shuurkhai.com/shuurkhai_git/fix_admin_config.php
 * 3. The script will update admin/config.php automatically
 * 4. Delete this file after running (for security)
 */

// Security: Only allow this to run once or with a secret key
$secret_key = 'fix_' . date('Ymd'); // Change this or add authentication
$allowed_key = isset($_GET['key']) ? $_GET['key'] : '';

// Uncomment the line below and set a secure key if you want to protect this script
// if ($allowed_key !== $secret_key) { die('Access denied. Provide ?key=fix_YYYYMMDD'); }

$admin_config_path = __DIR__ . '/admin/config.php';
$backup_path = __DIR__ . '/admin/config.php.backup.' . date('YmdHis');

// Check if admin/config.php exists
if (!file_exists($admin_config_path)) {
    die("Error: admin/config.php not found at: $admin_config_path");
}

// Read current file
$current_content = file_get_contents($admin_config_path);

// Check if already fixed (contains require_once for root config.php)
if (strpos($current_content, "require_once(__DIR__ . \"/../config.php\")") !== false) {
    echo "<h2>✅ admin/config.php is already fixed!</h2>";
    echo "<p>The file already uses the root config.php. No changes needed.</p>";
    echo "<p><strong>Next step:</strong> Make sure your database password is configured in config.php</p>";
    exit;
}

// Create backup
if (copy($admin_config_path, $backup_path)) {
    echo "<p>✅ Backup created: " . basename($backup_path) . "</p>";
} else {
    echo "<p>⚠️ Warning: Could not create backup. Proceeding anyway...</p>";
}

// New content for admin/config.php
$new_content = '<?php
ob_start();
@date_default_timezone_set("Asia/Ulaanbaatar");

// Include root config.php for database connection
// This ensures we use the same database configuration with environment variable support
require_once(__DIR__ . "/../config.php");

//GLOBAL VARIABLES
$g_title="Шуурхай админ";
$g_icon="assets/images/favicon.png";

define ("USA_OFFICE_name","www.SHuurkhai.com");
define ("USA_OFFICE_id","0");
define ("USA_OFFICE_tel","773-621-6807");
define ("USA_OFFICE_address","1888 S Elmhurst rd, Mount prospect, IL, 60056");
define ("MNG_OFFICE_address","БЗД 14-р хороо, 13-р хороолол");
define ("USA_OFFICE_zip","60026");
?>
';

// Write new content
if (file_put_contents($admin_config_path, $new_content)) {
    echo "<h2>✅ Success! admin/config.php has been updated</h2>";
    echo "<p>The file now uses the root config.php with environment variable support.</p>";
    echo "<hr>";
    echo "<h3>⚠️ IMPORTANT: Configure Database Password</h3>";
    echo "<p>You still need to configure the database password. Choose one method:</p>";
    echo "<ol>";
    echo "<li><strong>Edit config.php directly:</strong> Update line 19 in config.php with your database password</li>";
    echo "<li><strong>Set environment variables:</strong> Add SetEnv directives to .htaccess</li>";
    echo "</ol>";
    echo "<p>See FIX_DATABASE_CONNECTION_PRODUCTION.md for detailed instructions.</p>";
    echo "<hr>";
    echo "<p><strong>⚠️ Security:</strong> Delete this fix script (fix_admin_config.php) after use!</p>";
} else {
    echo "<h2>❌ Error: Could not write to admin/config.php</h2>";
    echo "<p>Please check file permissions. The file needs to be writable.</p>";
    if (file_exists($backup_path)) {
        echo "<p>Backup is available at: " . basename($backup_path) . "</p>";
    }
}

?>
