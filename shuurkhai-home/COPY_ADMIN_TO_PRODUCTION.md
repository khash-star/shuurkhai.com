# Admin directory production дээр үүсгэх заавар

Debug хуудас харуулж байна: **admin/ directory ба admin/login.php байхгүй**.

## Шийдэл

### 1. Admin directory-г хуучин сайтаас хуулах

Production server дээр:

```bash
cd ~/public_html/shuurkhai_git

# Хуучин сайтаас admin directory хуулах
# Хэрэв хуучин сайт ~/public_html/shuurkhai/ дээр байвал:
cp -r ~/public_html/shuurkhai/admin ./

# Эсвэл хуучин backup-аас:
# cp -r ~/backup/shuurkhai/admin ./

# Эрх өгөх
chmod -R 755 admin/
```

### 2. admin/login.php path-уудыг засах

Production дээрх `admin/login.php` доторх path-уудыг засах:

```bash
cd ~/public_html/shuurkhai_git/admin
nano login.php
```

Эхний мөрүүдийг:
```php
require_once("config.php");
require_once("views/helper.php");
require_once("views/init.php");
```

Дараах байдлаар засах:
```php
require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/../views/helper.php");
require_once(__DIR__ . "/../views/init.php");
```

### 3. Эсвэл шууд засах (sed ашиглан)

```bash
cd ~/public_html/shuurkhai_git/admin

# Backup хийх
cp login.php login.php.backup

# Path-уудыг засах
sed -i "s|require_once(\"config.php\");|require_once(__DIR__ . \"/../config.php\");|g" login.php
sed -i "s|require_once(\"views/helper.php\");|require_once(__DIR__ . \"/../views/helper.php\");|g" login.php
sed -i "s|require_once(\"views/init.php\");|require_once(__DIR__ . \"/../views/init.php\");|g" login.php
```

### 4. Шалгах

```bash
# admin/login.php байгаа эсэх
ls -la admin/login.php

# PHP syntax шалгах
php -l admin/login.php

# Эхний мөрүүдийг харах
head -10 admin/login.php
```

### 5. Browser дээр test хийх

**https://shuurkhai.com/shuurkhai_git/login**

Одоо ажиллах ёстой.

---

## Хэрэв admin directory бүхэлдээ байхгүй бол

Хуучин сайтаас бүх admin файлуудыг хуулах:

```bash
cd ~/public_html/shuurkhai_git

# Бүх admin directory хуулах
cp -r ~/public_html/shuurkhai/admin ./

# Эрх өгөх
find admin -type d -exec chmod 755 {} \;
find admin -type f -exec chmod 644 {} \;
```

Дараа нь дээрх path засваруудыг хийх.
