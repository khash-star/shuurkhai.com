# cPanel дээр засах файлууд (ЭЦСИЙН ЗААВАР)

## Асуудал:
1. Session path алдаа: `/opt/alt/php81/var/lib/php/session` олдсонгүй
2. mysqli extension идэвхжээгүй байна

## Засах файлууд:

### 1. `index.php` файл
**Байршил:** `public_html/index.php`

**Эхний мөрүүд (1-12) дараах байдалтай байх ёстой:**

```php
<?php
// CRITICAL: Error reporting MUST be first, before any output
@ini_set('display_errors', 1);
@ini_set('display_startup_errors', 1);
@error_reporting(E_ALL);

// Session path-ийг /tmp болгож засах - MUST be before session_start()
@ini_set('session.save_path', '/tmp');

// Immediate error output
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        echo "<!DOCTYPE html><html><head><title>PHP Fatal Error</title></head><body style='font-family: Arial; padding: 20px;'>";
        echo "<h1>PHP Fatal Error</h1>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($error['message']) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($error['file']) . "</p>";
        echo "<p><strong>Line:</strong> " . $error['line'] . "</p>";
        echo "</body></html>";
    }
});

// Start output immediately to catch early errors
echo "<!-- Index.php starting -->\n";

// Main entry point - displays new home page
// Start session if not already started
try {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
} catch (Exception $e) {
    die("Session Error: " . htmlspecialchars($e->getMessage()));
}
```

### 2. `config.php` файл
**Байршил:** `public_html/config.php`

**Дараах код оруулах:**

```php
<?php
/**
 * config.php - Shuurkhai.com Production Configuration
 */

// 1. Error Reporting - MUST be first, before any output
@ini_set('display_errors', 1);
@ini_set('display_startup_errors', 1);
@error_reporting(E_ALL);
@ini_set('log_errors', 1);

// 2. Database Тохиргоо
$dbhost = 'localhost'; 
$dbuser = 'r2c69it0btr1_user';
$dbpass = 'lyY0VQ@PQSJNUzfe';
$dbname = 'r2c69it0btr1_shuurkhai';

// 3. Холболт үүсгэх
if (!function_exists('mysqli_connect')) {
    die("FATAL ERROR: mysqli extension is not enabled. Please enable mysqli extension in cPanel → Select PHP Version → Extensions");
}

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    $error = mysqli_connect_error();
    http_response_code(500);
    die("<!DOCTYPE html><html><head><title>Database Error</title></head><body style='font-family: Arial; padding: 20px;'>" .
        "<h1>Database Connection Error</h1>" .
        "<p><strong>Error:</strong> " . htmlspecialchars($error) . "</p>" .
        "<p><strong>Host:</strong> " . htmlspecialchars($dbhost) . "</p>" .
        "<p><strong>User:</strong> " . htmlspecialchars($dbuser) . "</p>" .
        "<p><strong>Database:</strong> " . htmlspecialchars($dbname) . "</p>" .
        "<hr><h2>Please check:</h2><ol>" .
        "<li>Database credentials in cPanel → MySQL Databases</li>" .
        "<li>Database user has proper permissions</li>" .
        "<li>Database name is correct</li>" .
        "<li>mysqli extension is enabled</li></ol></body></html>");
}

mysqli_set_charset($conn, "utf8mb4");

// 4. Session аюулгүй байдал
// Session path-ийг /tmp болгож засах
ini_set('session.save_path', '/tmp');
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    session_start();
}

// 5. Глобал хувьсагчид
$g_title = "Шуурхай Америк Карго";
$g_description = "Welcome to Shuurkhai.com, fast and reliable cargo shipping solutions.";
$g_author = "MaGnatE @ Mindsymbol";
?>
```

### 3. mysqli extension идэвхжүүлэх

1. cPanel → Select PHP Version → Extensions
2. `mysqli` extension checkbox сонгох
3. Save товч дарах

## Шалгах:

1. `https://shuurkhai.com` хуудсыг дахин шалгах
2. Browser cache цэвэрлэх (Ctrl+F5)
3. Одоо сайт ажиллах ёстой
