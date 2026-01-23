# Login 500 алдаа хурдан засах

## 1. Debug хуудас ажиллуулах

Production server дээр:

```bash
cd ~/public_html/shuurkhai_git
git pull origin main

# login_debug.php ажиллуулах
# Browser дээр нээнэ: https://shuurkhai.com/shuurkhai_git/login_debug.php
```

Энэ хуудас config.php, helper.php, admin/login.php байгаа эсэх, DB холболт ажиллаж байгаа эсэхийг харуулна.

## 2. Error log шалгах

```bash
# Хамгийн сүүлийн алдаанууд
tail -50 ~/logs/error_log

# Эсвэл
tail -50 ~/public_html/error_log

# Real-time харах
tail -f ~/logs/error_log
```

## 3. admin/login.php файл шалгах

```bash
cd ~/public_html/shuurkhai_git

# admin/login.php байгаа эсэх
ls -la admin/login.php

# Эхний мөрүүдийг харах
head -30 admin/login.php

# PHP syntax шалгах
php -l admin/login.php
```

## 4. Түгээмэл шалтгаанууд

### A. config.php олдохгүй байна

`admin/login.php` ихэвчлэн:
```php
require_once __DIR__ . '/../config.php';
```

Production дээр `config.php` байгаа эсэхийг шалгах:
```bash
ls -la config.php
ls -la ../config.php
```

### B. helper.php олдохгүй байна

```bash
ls -la views/helper.php
ls -la ../views/helper.php
```

### C. Database холболт алдаатай

`config.php` доторх DB мэдээлэл production-д тохирсон эсэхийг шалгах:
- DB host
- DB user
- DB password  
- DB name

### D. PHP version ялгаа

```bash
php -v
```

## 5. Хэрэв admin/login.php байхгүй бол

Хуучин сайтаас хуулах эсвэл шинээр үүсгэх:

```bash
# Backup хийх (хэрэв байвал)
cp admin/login.php admin/login.php.backup

# Хуучин сайтаас хуулах (хэрэв байвал)
# cp ~/public_html/shuurkhai/admin/login.php admin/login.php
```

## 6. Хурдан засах (хэрэв path асуудал бол)

`admin/login.php` доторх path-уудыг засах:

```bash
nano admin/login.php
```

Хайх: `require_once __DIR__ . '/../config.php';`

Production бүтэцтэй тохируулах:
- Хэрэв `config.php` root дээр байвал: `__DIR__ . '/../config.php'` зөв
- Хэрэв `config.php` parent дээр байвал: `dirname(__DIR__) . '/config.php'`

## 7. Test хийх

```bash
# PHP файлыг шууд ажиллуулах (browser-гүйгээр)
php admin/login.php
```

Хэрэв алдаа гарвал terminal дээр харагдана.

---

**Анхаарах:** `login_debug.php` ажиллуулсны дараа үр дүнг харж, алдааг засна уу.
