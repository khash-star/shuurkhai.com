<?php
/**
 * DEBUG_500_ERROR.php
 * 
 * Энэ файлыг public_html дээр байрлуулж, browser дээр нээхэд
 * PHP алдаануудыг харах боломжтой болно.
 * 
 * АНХААР: Production дээр энэ файлыг ашигласны дараа УСТГАХ!
 */

// Error reporting идэвхжүүлэх
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<h1>PHP Configuration Check</h1>";

// 1. PHP Version
echo "<h2>PHP Version:</h2>";
echo "<p>" . phpversion() . "</p>";

// 2. config.php файл байгаа эсэхийг шалгах
echo "<h2>config.php файл:</h2>";
if (file_exists(__DIR__ . '/config.php')) {
    echo "<p style='color: green;'>✅ config.php файл байна</p>";
    
    // config.php файлыг include хийх
    try {
        require_once(__DIR__ . '/config.php');
        echo "<p style='color: green;'>✅ config.php файл амжилттай load хийгдлээ</p>";
        
        // Database connection шалгах
        if (isset($conn) && $conn) {
            echo "<p style='color: green;'>✅ Database connection амжилттай</p>";
        } else {
            echo "<p style='color: red;'>❌ Database connection алдаа</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ config.php алдаа: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ config.php файл олдсонгүй</p>";
}

// 3. .htaccess файл байгаа эсэхийг шалгах
echo "<h2>.htaccess файл:</h2>";
if (file_exists(__DIR__ . '/.htaccess')) {
    echo "<p style='color: green;'>✅ .htaccess файл байна</p>";
} else {
    echo "<p style='color: orange;'>⚠️ .htaccess файл олдсонгүй</p>";
}

// 4. index.php файл байгаа эсэхийг шалгах
echo "<h2>index.php файл:</h2>";
if (file_exists(__DIR__ . '/index.php')) {
    echo "<p style='color: green;'>✅ index.php файл байна</p>";
} else {
    echo "<p style='color: red;'>❌ index.php файл олдсонгүй</p>";
}

// 5. File permissions шалгах
echo "<h2>File Permissions:</h2>";
$files_to_check = ['config.php', 'index.php', '.htaccess'];
foreach ($files_to_check as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        $perms = fileperms(__DIR__ . '/' . $file);
        echo "<p>$file: " . substr(sprintf('%o', $perms), -4) . "</p>";
    }
}

// 6. Error log байгаа эсэхийг шалгах
echo "<h2>Error Log:</h2>";
$error_log_path = __DIR__ . '/error_log';
if (file_exists($error_log_path)) {
    echo "<p style='color: green;'>✅ error_log файл байна</p>";
    $log_content = file_get_contents($error_log_path);
    if (!empty($log_content)) {
        echo "<h3>Сүүлийн алдаанууд:</h3>";
        echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd; max-height: 300px; overflow: auto;'>";
        echo htmlspecialchars(substr($log_content, -2000)); // Сүүлийн 2000 тэмдэгт
        echo "</pre>";
    } else {
        echo "<p>error_log файл хоосон байна</p>";
    }
} else {
    echo "<p style='color: orange;'>⚠️ error_log файл олдсонгүй</p>";
}

// 7. PHP алдаануудыг шалгах
echo "<h2>PHP Errors:</h2>";
$errors = error_get_last();
if ($errors) {
    echo "<pre style='background: #ffe6e6; padding: 10px; border: 1px solid #ff9999;'>";
    print_r($errors);
    echo "</pre>";
} else {
    echo "<p style='color: green;'>✅ PHP алдаа байхгүй</p>";
}

echo "<hr>";
echo "<p><strong>АНХААР:</strong> Энэ файлыг debug хийсний дараа УСТГАХ!</p>";
?>
