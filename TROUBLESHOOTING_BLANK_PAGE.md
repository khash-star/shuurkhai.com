# 🔧 Blank Page Troubleshooting Guide

## 🐛 Асуудал: `https://shuurkhai.com/shuurkhai_git/` дээр blank page харагдаж байна

### Шалтгаанууд:

1. **PHP Error** - Error reporting хаагдсан байж магадгүй
2. **File Path** - Directory structure буруу байж магадгүй
3. **Database Connection** - Database connection алдаа
4. **Missing Files** - Required files байхгүй байж магадгүй
5. **.htaccess** - .htaccess асуудал
6. **Index File** - index.php/index.html байхгүй байж магадгүй

---

## 🔍 Шалгалт 1: PHP Error Logs шалгах

### SSH ашиглан:

```bash
# SSH connection
ssh r2c69it0btr1@198.12.239.156

# Error logs харах
tail -f ~/logs/error_log
# эсвэл
tail -f ~/public_html/shuurkhai_git/logs/php_errors.log
# эсвэл
tail -f /home/r2c69it0btr1/logs/error_log
```

### cPanel ашиглах:

1. cPanel → "Error Log" эсвэл "Metrics" → "Errors"
2. Сүүлийн errors шалгах

---

## 🔍 Шалгалт 2: Directory Structure шалгах

### SSH ашиглан:

```bash
# Directory structure шалгах
cd ~/public_html
ls -la

# shuurkhai_git directory байгаа эсэхийг шалгах
ls -la shuurkhai_git/

# Index file байгаа эсэхийг шалгах
ls -la shuurkhai_git/index.*
ls -la shuurkhai_git/*.php
```

**Хүлээгдэж буй structure:**
```
public_html/
  └── shuurkhai_git/
      ├── index.php (эсвэл index.html)
      ├── config.php
      ├── .htaccess
      └── ...
```

---

## 🔍 Шалгалт 3: PHP Error Reporting идэвхжүүлэх (Temporary)

### config.php файл засах:

```bash
cd ~/public_html/shuurkhai_git
nano config.php
```

**Temporary (debugging-ийн тулд):**
```php
// Temporary: Error reporting идэвхжүүлэх
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
```

**Дараа нь browser refresh хийх - алдааны мэдээлэл харагдана!**

**⚠️ Анхааруулга:** Production дээр debugging дууссаны дараа энэ хэсгийг буцааж хаах!

---

## 🔍 Шалгалт 4: Index File байгаа эсэхийг шалгах

### Index file үүсгэх (хэрэв байхгүй бол):

```bash
cd ~/public_html/shuurkhai_git

# index.php үүсгэх
cat > index.php << 'EOF'
<?php
// Temporary index file for testing
echo "PHP is working!";
phpinfo();
?>
EOF
```

**Browser дээр refresh хийх:**
- Хэрэв "PHP is working!" харагдвал PHP ажиллаж байна
- Хэрэв blank page байвал server configuration асуудал

---

## 🔍 Шалгалт 5: .htaccess шалгах

### .htaccess файл шалгах:

```bash
cd ~/public_html/shuurkhai_git
cat .htaccess
```

**Хэрэв .htaccess алдаатай бол:**
```bash
# .htaccess backup хийх
mv .htaccess .htaccess.backup

# Browser refresh хийх
```

---

## 🔍 Шалгалт 6: Database Connection шалгах

### config.php дээр database connection test:

```bash
cd ~/public_html/shuurkhai_git
nano test_db.php
```

**test_db.php үүсгэх:**
```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('config.php');

if ($conn) {
    echo "Database connection: SUCCESS<br>";
    echo "Database: " . mysqli_get_server_info($conn);
} else {
    echo "Database connection: FAILED<br>";
    echo "Error: " . mysqli_connect_error();
}
?>
```

**Browser дээр:** `https://shuurkhai.com/shuurkhai_git/test_db.php`

**⚠️ Анхааруулга:** Тест дууссаны дараа `test_db.php` файлыг устгах!

---

## 🔍 Шалгалт 7: File Permissions шалгах

### Permissions засах:

```bash
cd ~/public_html/shuurkhai_git

# Permissions шалгах
ls -la

# Permissions засах
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

# Owner засах
chown -R r2c69it0btr1:r2c69it0btr1 .
```

---

## 🔍 Шалгалт 8: Git Repository шалгах

### Git repository зөв clone хийгдсэн эсэхийг шалгах:

```bash
cd ~/public_html/shuurkhai_git

# Git status шалгах
git status

# Git remote шалгах
git remote -v

# Хэрэв git repository биш бол:
# 1. Directory-г устгах
rm -rf shuurkhai_git

# 2. Дахин clone хийх
cd ~/public_html
git clone git@github.com:khash-star/shuurkhai.com.git shuurkhai_git
```

---

## 🔍 Шалгалт 9: Directory Path шалгах

### URL path vs actual directory:

**URL:** `https://shuurkhai.com/shuurkhai_git/`

**Actual directory:** `~/public_html/shuurkhai_git/`

**Хэрэв directory нэр өөр байвал:**
```bash
# Directory нэрийг засах
cd ~/public_html
mv shuurkhai shuurkhai_git  # эсвэл урвуу
```

**Эсвэл .htaccess ашиглах:**
```apache
# .htaccess
RewriteEngine On
RewriteRule ^shuurkhai_git/(.*)$ shuurkhai/$1 [L]
```

---

## 🔍 Шалгалт 10: PHP Version шалгах

### PHP version шалгах:

```bash
# PHP version шалгах
php -v

# Эсвэл test file үүсгэх
echo "<?php phpinfo(); ?>" > ~/public_html/shuurkhai_git/phpinfo.php
```

**Browser дээр:** `https://shuurkhai.com/shuurkhai_git/phpinfo.php`

**⚠️ Анхааруулга:** phpinfo.php файлыг production дээр устгах!

---

## ✅ Хамгийн Түрүүнд Хийх Зүйлс

### 1. Error Logs шалгах:
```bash
tail -f ~/logs/error_log
```

### 2. PHP Error Reporting идэвхжүүлэх (temporary):
```php
// config.php дээр
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### 3. Index file байгаа эсэхийг шалгах:
```bash
ls -la ~/public_html/shuurkhai_git/index.*
```

### 4. Simple test file үүсгэх:
```php
<?php echo "PHP is working!"; ?>
```

---

## 🎯 Хамгийн Их Магадлалтай Шалтгаан

1. **Index file байхгүй** - `index.php` эсвэл `index.html` байхгүй
2. **PHP error** - Error reporting хаагдсан, алдаа харагдахгүй
3. **Directory path** - URL path vs actual directory нэр таарахгүй
4. **Database connection** - Database connection алдаа
5. **File permissions** - Permissions буруу

---

## 🔧 Шууд Шийдэл

### Алхам 1: Error reporting идэвхжүүлэх

```bash
ssh r2c69it0btr1@198.12.239.156
cd ~/public_html/shuurkhai_git
nano config.php
```

**config.php дээр (temporary):**
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Алхам 2: Browser refresh хийх

**Одоо алдааны мэдээлэл харагдана!**

### Алхам 3: Алдаа засах

Алдааны мэдээллээс хамаарч засах.

### Алхам 4: Error reporting буцааж хаах

```php
// Production mode
$is_production = true;
if ($is_production) {
    error_reporting(0);
    ini_set('display_errors', 0);
}
```

---

## 📝 Дүгнэлт

Blank page-ийн шалтгаан ихэнхдээ:
- PHP error (display_errors хаагдсан)
- Index file байхгүй
- Directory path буруу

**Хамгийн хурдан шийдэл:** Error reporting идэвхжүүлэх → Алдаа харах → Засах
