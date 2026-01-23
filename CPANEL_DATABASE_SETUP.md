# cPanel Database болон PHP Setup

## 1. Database Connection Тохируулах

### cPanel дээр Database мэдээлэл олох:

1. **cPanel → MySQL Databases**
   - Database name: `username_shuurkhai` (эсвэл таны үүсгэсэн database name)
   - Database user: `username_dbuser` (эсвэл таны үүсгэсэн user)
   - Database password: (таны password)

2. **config.php файл үүсгэх**
   ```bash
   cd ~/public_html/shuurkhai_new
   cp config.example.php config.php
   ```

3. **config.php файлыг edit хийх**
   cPanel File Manager эсвэл SSH ашиглах:
   
   ```php
   <?php
   // Database configuration
   $dbhost = 'localhost';  // cPanel дээр ихэвчлэн localhost
   $dbuser = 'username_dbuser';  // cPanel MySQL user
   $dbpass = 'your_password';  // Database password
   $dbname = 'username_shuurkhai';  // Database name
   
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
   if (!$conn) {
       die("Database connection failed: " . mysqli_connect_error());
   }
   mysqli_set_charset($conn,'utf8');
   mysqli_select_db($conn,$dbname);
   
   //GLOBAL VARIABLES
   $g_title="Шуурхай Америк Карго";
   $g_favicon="assets/images/favicon.png";
   $g_author="MaGnatE @ Mindsymbol";
   $g_description="Welcome to Shuurkhai.com...";
   $g_keywords="Shuurkhai, Cargo, delivery...";
   ?>
   ```

4. **Permissions тохируулах**
   ```bash
   chmod 644 config.php
   ```

## 2. PHP Version Тохируулах

### cPanel дээр PHP version сонгох:

1. **cPanel → Select PHP Version**
   - PHP version: **8.1** эсвэл **8.2** (PHP 8.0+ шаардлагатай)
   - Extensions идэвхжүүлэх:
     - `mysqli` (Database connection)
     - `mbstring` (Multibyte string support)
     - `curl` (HTTP requests)
     - `openssl` (Security)
     - `zip` (Archive support)

2. **PHP Settings тохируулах**
   - `display_errors`: Off (production дээр)
   - `error_reporting`: E_ALL & ~E_DEPRECATED
   - `memory_limit`: 256M эсвэл илүү
   - `upload_max_filesize`: 10M
   - `post_max_size`: 10M

## 3. Database Connection Test

### Test файл үүсгэх:

`public_html/shuurkhai_new/test_db.php`:
```php
<?php
require_once('config.php');

if ($conn) {
    echo "✅ Database connection successful!<br>";
    echo "Database: " . $dbname . "<br>";
    echo "Charset: " . mysqli_character_set_name($conn) . "<br>";
    
    // Test query
    $result = mysqli_query($conn, "SELECT 1");
    if ($result) {
        echo "✅ Query test successful!<br>";
    }
} else {
    echo "❌ Database connection failed!<br>";
    echo "Error: " . mysqli_connect_error();
}
?>
```

Browser дээр: `https://shuurkhai.com/shuurkhai_new/test_db.php`

**Анхаар:** Test хийсний дараа энэ файлыг устгах!

## 4. Common cPanel Database Issues

### Issue 1: "Access denied for user"
**Шалтгаан:** Database user-д database-д access байхгүй
**Засвар:**
- cPanel → MySQL Databases
- Database user-г database-тай холбох (Add User To Database)

### Issue 2: "Unknown database"
**Шалтгаан:** Database name буруу
**Засвар:** cPanel дээрх database name-ийг шалгах

### Issue 3: "Connection refused"
**Шалтгаан:** $dbhost буруу
**Засвар:** cPanel дээр ихэвчлэн `localhost` байна, гэхдээ зарим hosting provider-д өөр байж болно

## 5. Production Settings

### config.php дээр production settings:

```php
<?php
// Production error settings
error_reporting(0);  // Production дээр errors нуух
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log');

// Database configuration
$dbhost = 'localhost';
$dbuser = 'your_cpanel_db_user';
$dbpass = 'your_cpanel_db_password';
$dbname = 'your_cpanel_db_name';

// ... бусад код
?>
```

## 6. Шалгах

1. **Database connection test**
   - `test_db.php` файл ажиллуулах

2. **Browser дээр шалгах**
   - `https://shuurkhai.com/shuurkhai_new/` - нүүр хуудас
   - `https://shuurkhai.com/shuurkhai_new/user/login` - login хуудас

3. **Error log шалгах**
   - cPanel → Error Log
   - Эсвэл `public_html/shuurkhai_new/error_log` файл

## 7. Troubleshooting

**Хэрэв database connection алдаа гарвал:**
1. Database credentials зөв эсэхийг шалгах
2. Database user-д database-д access байгаа эсэхийг шалгах
3. cPanel MySQL service ажиллаж байгаа эсэхийг шалгах
4. `test_db.php` файл ашиглан connection test хийх

**Хэрэв PHP алдаа гарвал:**
1. PHP version 8.0+ байгаа эсэхийг шалгах
2. Required extensions идэвхтэй эсэхийг шалгах
3. Error log шалгах
