# Login 500 алдаа засах - Production deployment

## ✅ Локал дээр хийгдсэн:
- `admin/login.php` - path-уудыг `__DIR__` ашиглан зассан
- `admin/views/helper.php` - syntax алдаа зассан (line 392)
- GitHub руу push хийгдлээ

## 🚀 Production server дээр хийх:

### 1. SSH ашиглан server-тэй холбогдох:
```bash
ssh r2c69it0btr1@198.12.239.156
# эсвэл таны SSH credentials ашиглана уу
```

### 2. Git repository directory руу орох:
```bash
cd ~/public_html/shuurkhai_git
# эсвэл
cd /home/r2c69it0btr1/public_html/shuurkhai_git
```

### 3. GitHub-аас шинэ өөрчлөлтүүдийг татах:
```bash
git pull origin main
```

### 4. Шалгах:
```bash
# admin/login.php файлыг шалгах
head -5 admin/login.php

# admin/views/helper.php файлын 392-р мөрийг шалгах
sed -n '390,395p' admin/views/helper.php
```

### 5. Browser дээр тест хийх:
```
https://shuurkhai.com/shuurkhai_git/login
```

## ⚠️ Хэрэв асуудал гарвал:

### Error log шалгах:
```bash
tail -50 ~/logs/error_log
# эсвэл
tail -50 /var/log/apache2/error.log
```

### PHP syntax шалгах:
```bash
php -l admin/login.php
php -l admin/views/helper.php
```

### Файлууд байгаа эсэхийг шалгах:
```bash
ls -la admin/login.php
ls -la admin/views/helper.php
ls -la config.php
ls -la views/helper.php
```

## 📝 Тайлбар:

**Засварласан файлууд:**

1. **admin/login.php**:
   - `require_once("config.php")` → `require_once(__DIR__ . "/../config.php")`
   - `require_once("views/helper.php")` → `require_once(__DIR__ . "/views/helper.php")`
   - `require_once("views/init.php")` → `require_once(__DIR__ . "/views/init.php")`

2. **admin/views/helper.php** (line 392):
   - `$data["name;break"]` → `$data["name"]; break;`

Эдгээр өөрчлөлтүүд HTTP 500 алдааг засах ёстой.
