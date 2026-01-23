# Quick cPanel Config Setup

## Database Connection (config.php)

cPanel дээр `shuurkhai` database байгаа тул `config.php` файлыг дараах байдлаар тохируулах:

### 1. cPanel MySQL Databases дээрх мэдээлэл:

1. **cPanel → MySQL Databases** руу очих
2. **Current Databases** хэсэгт database name-ийг харах
3. **Current Users** хэсэгт database user-ийг харах
4. User-г database-тай холбох (Add User To Database)

### 2. config.php файл үүсгэх:

cPanel File Manager эсвэл SSH ашиглах:

```bash
cd ~/public_html/shuurkhai_new
cp config.example.php config.php
```

### 3. config.php файлыг edit хийх:

```php
<?php
// Database configuration - cPanel дээрх мэдээлэл
$dbhost = 'localhost';  // Ихэвчлэн localhost
$dbuser = 'cpanel_username_dbuser';  // cPanel MySQL user (Current Users хэсгээс)
$dbpass = 'your_database_password';  // Database password
$dbname = 'cpanel_username_shuurkhai';  // Database name (Current Databases хэсгээс)

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
$g_description="Welcome to Shuurkhai.com, your premier choice for fast and reliable cargo shipping solutions.";
$g_keywords="Shuurkhai, Cargo, delivery, online track, from US, deliver in Mongolia";
?>
```

### 4. Permissions тохируулах:

```bash
chmod 644 config.php
```

### 5. Database Connection Test:

`test_db.php` файл үүсгэх:
```php
<?php
require_once('config.php');
if ($conn) {
    echo "✅ Database connected!<br>";
    echo "Database: " . $dbname;
} else {
    echo "❌ Connection failed: " . mysqli_connect_error();
}
?>
```

Browser: `https://shuurkhai.com/shuurkhai_new/test_db.php`

**Анхаар:** Test хийсний дараа `test_db.php` файлыг устгах!

## PHP Version

cPanel → Select PHP Version:
- PHP 8.1 эсвэл 8.2 сонгох
- Extensions: mysqli, mbstring, curl, openssl

## Шалгах

1. `https://shuurkhai.com/shuurkhai_new/` - нүүр хуудас
2. `https://shuurkhai.com/shuurkhai_new/user/login` - login хуудас
