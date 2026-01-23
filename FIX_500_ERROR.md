# HTTP 500 Error Шийдэл

## Алдаа:
```
HTTP ERROR 500
shuurkhai.com can't currently handle this request
```

## Шалтгаанууд:

### 1. config.php файл байхгүй эсвэл буруу

**Шалгах:**
1. cPanel → File Manager → `public_html`
2. `config.php` файл байгаа эсэхийг шалгах
3. Хэрэв байхгүй бол:
   - `config.example.php`-аас copy хийх
   - Database credentials засах

**Засвар:**
```php
$dbhost = 'localhost';
$dbuser = 'cpanel_db_username';
$dbpass = 'database_password';
$dbname = 'shuurkhai';
```

### 2. Database Connection алдаа

**Шалгах:**
1. cPanel → phpMyAdmin
2. Database `shuurkhai` байгаа эсэхийг шалгах
3. Database user байгаа эсэхийг шалгах

**Засвар:**
- `config.php` файлд зөв database credentials байх ёстой

### 3. PHP Error

**Шалгах:**
1. cPanel → File Manager → `public_html`
2. `error_log` файл байгаа эсэхийг шалгах
3. Эсвэл cPanel → Error Log

**Засвар:**
- Error log-ийг уншаад алдааны мэдээлэл харах

### 4. File Permissions

**Шалгах:**
1. cPanel → File Manager
2. `public_html` directory-ийн permissions шалгах
3. `index.php` файлын permissions шалгах

**Засвар:**
- Directory: `755`
- Files: `644`

### 5. .htaccess файл асуудал

**Шалгах:**
1. cPanel → File Manager → `public_html`
2. `.htaccess` файл байгаа эсэхийг шалгах
3. `.htaccess` файлын агуулгыг шалгах

**Засвар:**
- `.htaccess` файлд `RewriteBase /` байх ёстой

---

## Хурдан Шийдэл:

### Алхам 1: Error Log шалгах

1. **cPanel → Error Log** руу орох
2. **Сүүлийн алдаануудыг харах**
3. **Алдааны мэдээлэл унших**

### Алхам 2: config.php файл шалгах

1. **cPanel → File Manager → public_html**
2. **config.php файл байгаа эсэхийг шалгах**
3. **Хэрэв байхгүй бол үүсгэх:**
   - `config.example.php`-аас copy хийх
   - Database credentials засах

### Алхам 3: PHP Error Reporting идэвхжүүлэх (Test хийхэд)

`public_html/index.php` файлын эхэнд нэмэх:
```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

**Анхаар:** Production дээр энэ нь аюултай, зөвхөн test хийхэд ашиглах!

---

## Хамгийн их магадлалтай шалтгаан:

1. **config.php файл байхгүй** - 90%
2. **Database connection алдаа** - 5%
3. **PHP syntax error** - 3%
4. **File permissions** - 2%

---

## Шалгах дараалал:

1. ✅ Error Log шалгах
2. ✅ config.php файл байгаа эсэхийг шалгах
3. ✅ Database connection шалгах
4. ✅ .htaccess файл шалгах
5. ✅ File permissions шалгах
