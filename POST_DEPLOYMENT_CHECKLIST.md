# ✅ Post-Deployment Checklist

## 🎯 Хийгдсэн Алхмууд

✅ Git clone/pull хийгдсэн  
✅ config.php copy хийгдсэн  
✅ .htaccess copy хийгдсэн  
✅ php.ini copy хийгдсэн  

---

## 📋 Дараагийн Алхмууд

### 1. ✅ Configuration файлууд шалгах

```bash
# config.php шалгах
cd ~/public_html/shuurkhai_git
cat config.php | grep -E "dbhost|dbuser|dbname"
```

**Шалгах зүйлс:**
- ✅ Database credentials зөв байгаа эсэх
- ✅ Production database ашиглаж байгаа эсэх
- ✅ Error reporting production mode дээр хаагдсан эсэх

### 2. ✅ Index File байгаа эсэхийг шалгах

```bash
# Index file байгаа эсэхийг шалгах
ls -la index.php
ls -la index.html

# Хэрэв байхгүй бол:
# Root directory-г шалгах
ls -la
```

**Хэрэв index.php байхгүй бол:**
- Root directory-г шалгах (views/, user/, admin/ гэх мэт)
- .htaccess дээр DirectoryIndex тохируулсан эсэх

### 3. ✅ .htaccess шалгах

```bash
# .htaccess файл шалгах
cat .htaccess

# Хэрэв алдаатай бол:
mv .htaccess .htaccess.backup
```

**Шалгах зүйлс:**
- ✅ RewriteEngine On байгаа эсэх
- ✅ DirectoryIndex тохируулсан эсэх
- ✅ Error syntax байгаа эсэх

### 4. ✅ PHP Error Reporting идэвхжүүлэх (Temporary)

```bash
# config.php засах
nano config.php
```

**Temporary debugging:**
```php
// Temporary: Error reporting идэвхжүүлэх
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
```

**Browser refresh хийх** - Одоо алдааны мэдээлэл харагдана!

### 5. ✅ Database Connection тест хийх

```bash
# Test file үүсгэх
cat > test_db.php << 'EOF'
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('config.php');

if ($conn) {
    echo "✅ Database connection: SUCCESS<br>";
    echo "Database: " . mysqli_get_server_info($conn) . "<br>";
    echo "Database name: " . mysqli_get_server_info($conn);
} else {
    echo "❌ Database connection: FAILED<br>";
    echo "Error: " . mysqli_connect_error();
}
?>
EOF
```

**Browser дээр:** `https://shuurkhai.com/shuurkhai_git/test_db.php`

**⚠️ Анхааруулга:** Тест дууссаны дараа `test_db.php` устгах!

### 6. ✅ File Permissions засах

```bash
# Permissions засах
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

# Cache, logs directories үүсгэх
mkdir -p cache logs
chmod -R 755 cache/ logs/

# Owner засах
chown -R r2c69it0btr1:r2c69it0btr1 .
```

### 7. ✅ Composer Install (хэрэв шаардлагатай бол)

```bash
# Composer install
composer install --no-dev --optimize-autoloader

# Эсвэл хэрэв composer байхгүй бол
php composer.phar install --no-dev --optimize-autoloader
```

### 8. ✅ Error Logs шалгах

```bash
# Error logs харах
tail -f ~/logs/error_log
# эсвэл
tail -f logs/php_errors.log
```

### 9. ✅ Simple Test File үүсгэх

```bash
# Simple test file үүсгэх
echo "<?php echo 'PHP is working!'; ?>" > test.php
```

**Browser дээр:** `https://shuurkhai.com/shuurkhai_git/test.php`

**Хэрэв "PHP is working!" харагдвал:**
- ✅ PHP ажиллаж байна
- ✅ Server configuration зөв

**Хэрэв blank page байвал:**
- ❌ Server configuration асуудал
- ❌ PHP ажиллахгүй байна

### 10. ✅ Directory Structure шалгах

```bash
# Root directory-г шалгах
ls -la

# Index file байгаа эсэхийг шалгах
ls -la index.*
ls -la *.php | head -5
```

**Хүлээгдэж буй structure:**
```
shuurkhai_git/
├── index.php (эсвэл views/, user/, admin/ гэх мэт)
├── config.php ✅
├── .htaccess ✅
├── lib/
├── views/
└── ...
```

---

## 🔧 Blank Page Шийдэх

### Хамгийн хурдан арга:

1. **Error reporting идэвхжүүлэх:**
```bash
nano config.php
# Temporary: error_reporting(E_ALL); ini_set('display_errors', 1);
```

2. **Browser refresh хийх**

3. **Алдааны мэдээлэл харах**

4. **Алдаа засах**

5. **Error reporting буцааж хаах**

---

## 📝 Дүгнэлт

**Хийгдсэн:**
- ✅ Git clone/pull
- ✅ Config files copy

**Дараагийн алхам:**
1. Error reporting идэвхжүүлэх (temporary)
2. Browser refresh → Алдаа харах
3. Алдаа засах
4. Error reporting буцааж хаах

**Дэлгэрэнгүй:** `TROUBLESHOOTING_BLANK_PAGE.md`
