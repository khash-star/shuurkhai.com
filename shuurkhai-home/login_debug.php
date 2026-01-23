<?php
/**
 * Login 500 алдаа шалгах debug хуудас
 * Production: https://shuurkhai.com/shuurkhai_git/login_debug.php
 * Ажиллуулсны дараа устгана уу (аюулгүй байдлын үүднээс)
 */

// Display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

header('Content-Type: text/html; charset=utf-8');
echo "<pre style='font-family:monospace;padding:20px;background:#f5f5f5;'>\n";
echo "=== Login 500 Debug ===\n\n";

echo "1. PHP: " . PHP_VERSION . "\n";
echo "2. __DIR__: " . __DIR__ . "\n";
echo "3. __FILE__: " . __FILE__ . "\n";
echo "4. Document root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') . "\n";
echo "5. Script filename: " . ($_SERVER['SCRIPT_FILENAME'] ?? 'N/A') . "\n\n";

// Simulate admin/login.php path logic (login is rewritten to admin/login.php)
$adminDir = __DIR__ . '/admin';
$adminDirAlt = __DIR__ . '/shuurkhai-home'; // when repo is subdir
$configPaths = [
    __DIR__ . '/config.php',
    __DIR__ . '/../config.php',
    $adminDir . '/../config.php',
    $adminDir . '/../../config.php',
    dirname(__DIR__) . '/config.php',
];

echo "6. Config paths (login = admin/login.php, so config often at ../ or ../../):\n";
foreach ($configPaths as $i => $p) {
    $exists = file_exists($p);
    echo "   [$i] " . ($exists ? 'OK' : 'MISSING') . " $p\n";
}

$helperPaths = [
    __DIR__ . '/views/helper.php',
    __DIR__ . '/../views/helper.php',
    $adminDir . '/../views/helper.php',
    $adminDir . '/../../views/helper.php',
    dirname(__DIR__) . '/views/helper.php',
];
echo "\n7. Helper paths:\n";
foreach ($helperPaths as $i => $p) {
    $exists = file_exists($p);
    echo "   [$i] " . ($exists ? 'OK' : 'MISSING') . " $p\n";
}

echo "\n8. admin/ directory exists: " . (is_dir($adminDir) ? 'YES' : 'NO') . "\n";
echo "9. admin/login.php exists: " . (file_exists($adminDir . '/login.php') ? 'YES' : 'NO') . "\n";

// Try loading config (same as login might do)
echo "\n10. Try require config:\n";
$configLoaded = false;
foreach ($configPaths as $p) {
    if (file_exists($p)) {
        try {
            require_once $p;
            $configLoaded = true;
            echo "    Loaded: $p\n";
            break;
        } catch (Throwable $e) {
            echo "    ERROR loading $p: " . $e->getMessage() . "\n";
        }
    }
}
if (!$configLoaded) echo "    No config loaded.\n";

echo "\n11. \$conn defined: " . (isset($conn) ? 'YES' : 'NO') . "\n";
if (isset($conn)) {
    echo "    DB connect test: ";
    try {
        @$conn->ping();
        echo "OK\n";
    } catch (Throwable $e) {
        echo "FAIL - " . $e->getMessage() . "\n";
    }
}

echo "\n=== End debug ===\n";
echo "</pre>\n";
echo "<p><a href='/shuurkhai_git/'>Нүүр</a> | <a href='/shuurkhai_git/login'>Login</a></p>\n";
