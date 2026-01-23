# Login HTTP 500 засах заавар

Локал дээр нэвтрэх ажиллаж, production дээр `/login` нээхэд **HTTP 500** гарч байвал доорх зүйлсийг шалгана уу.

---

## 1. Error log шалгах

Production server дээр:

```bash
# Хамгийн сүүлийн алдаанууд
tail -100 ~/logs/error_log

# Эсвэл Apache error log
tail -100 /var/log/apache2/error.log
```

Тэнд **Fatal error**, **require**, **config**, **Permission denied** гэх мэт үг гарч байгаа эсэхийг хайна уу.

---

## 2. Debug хуудас ажиллуулах

Эхлээд `login_debug.php` татаад ажиллуулна:

```bash
cd ~/public_html/shuurkhai_git
git pull origin main

# Хэрэв файл shuurkhai-home дотор бол root руу хуулна
cp shuurkhai-home/login_debug.php ./
# Эсвэл шууд:
# cp shuurkhai-home/login_debug.php login_debug.php
```

Дараа нь browser дээр нээнэ:

**https://shuurkhai.com/shuurkhai_git/login_debug.php**

Энэ хуудас:
- Config, helper path зөв эсэхийг
- `admin/login.php` байгаа эсэхийг
- Database холболт ажиллаж байгаа эсэхийг

харуулна. Үр дүнг үзээд алдааг засна.

**Анхаар:** Шалгаад дууссны дараа `login_debug.php`-г устгана уу:
```bash
rm login_debug.php
# эсвэл
rm shuurkhai-home/login_debug.php
```

---

## 3. admin/login.php ба config path

`.htaccess`-д `RewriteRule ^login/?$ admin/login.php [L]` гэж байвал `/login` нь `admin/login.php` руу очно.

`admin/login.php` ихэвчлэн ийм байдаг:

```php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../views/helper.php';
```

`admin/` нь `~/public_html/shuurkhai_git/admin/` бол:
- `../config.php` → `~/public_html/shuurkhai_git/config.php`
- `../views/helper.php` → `~/public_html/shuurkhai_git/views/helper.php`

**Шалгах:**
- `config.php` болон `views/helper.php` эдгээр замд байгаа эсэх
- Файлуудын эрх: `chmod 644`, directory `755`

---

## 4. Түгээмэл шалтгаанууд

| Шалтгаан | Шийдэл |
|----------|--------|
| `config.php` олдохгүй | Зөв path эсэхийг шалгаж, `__DIR__ . '/../config.php'` зэргийг production бүтэцтэй тааруулна |
| `helper.php` олдохгүй | `views/helper.php` байгаа эсэх, path засна |
| DB холболт алдаатай | `config.php` доторх DB host, user, password, database нэр production-д тохирсон эсэхийг шалгана |
| PHP version ялгаа | Локал болон server дээрх PHP хувилбар ижил эсэхийг шалгана |
| Session алдаа | `session_start()` дуудагдаж, `session` folder бичих эрхтэй эсэхийг шалгана |

---

## 5. RewriteBase шалгах

`.htaccess` дотор:

```apache
RewriteBase /shuurkhai_git/
```

гэж тохирсон эсэхийг шалгана. Буруу байвал `/login` rewrite буруу болж 500 гарч болно.

---

## 6. Хурдан шалгалт

```bash
cd ~/public_html/shuurkhai_git

# Файлууд байгаа эсэх
ls -la config.php
ls -la views/helper.php
ls -la admin/login.php

# PHP syntax шалгах (алдаа байвал харуулна)
php -l admin/login.php
php -l config.php
```

Эдгээрийг хийсний дараа error log болон `login_debug.php`-ийн гарцыг харж, алдааг нь засна.
