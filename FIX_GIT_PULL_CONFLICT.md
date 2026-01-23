# Git Pull Conflict засах - Production Server

## 🔴 Асуудал:
```
error: Your local changes to the following files would be overwritten by merge:
	.htaccess
Please commit your changes or stash them before you merge.
Aborting.
```

## ✅ Шийдэл:

### Арга 1: Local өөрчлөлтүүдийг Stash хийх (Зөвлөмжлөгдөнө)

Production server дээр дараах командуудыг ажиллуулаарай:

```bash
cd ~/public_html/shuurkhai_git

# 1. Local өөрчлөлтүүдийг stash хийх (хадгалах)
git stash

# 2. GitHub-аас pull хийх
git pull origin main

# 3. Stash хийсэн өөрчлөлтүүдийг буцааж авах (хэрэв хэрэгтэй бол)
# git stash pop
```

**Анхаар:** Хэрэв `.htaccess` файлд production-д зориулсан чухал өөрчлөлтүүд байвал, stash pop хийсний дараа шалгаж, шаардлагатай өөрчлөлтүүдийг дахин нэмнэ.

---

### Арга 2: Local өөрчлөлтүүдийг Commit хийх

```bash
cd ~/public_html/shuurkhai_git

# 1. Local өөрчлөлтүүдийг commit хийх
git add .htaccess
git commit -m "Production .htaccess changes"

# 2. GitHub-аас pull хийх (merge conflict гарч болно)
git pull origin main

# 3. Хэрэв conflict гарвал засах
# git mergetool
# эсвэл гараар засах
```

---

### Арга 3: Force Pull (⚠️ Болгоомжтой - Local өөрчлөлтүүд алдагдана)

```bash
cd ~/public_html/shuurkhai_git

# 1. Local өөрчлөлтүүдийг устгах (backup хийх нь зөв)
cp .htaccess .htaccess.backup_$(date +%Y%m%d_%H%M%S)

# 2. Local өөрчлөлтүүдийг устгах
git checkout -- .htaccess

# 3. GitHub-аас pull хийх
git pull origin main
```

---

## ✅ Pull хийсний дараа шалгах:

### 1. Файлууд засагдсан эсэхийг шалгах:

```bash
# admin/login.php шалгах
head -5 admin/login.php
```

Энэ нь доорх байдлаар харагдах ёстой:
```php
<?php
    require_once(__DIR__ . "/../config.php");
    require_once(__DIR__ . "/views/helper.php");
    require_once(__DIR__ . "/views/init.php");
?>
```

```bash
# admin/views/helper.php шалгах
sed -n '390,395p' admin/views/helper.php
```

392-р мөр нь:
```php
case "name": return $data["name"]; break;
```

### 2. Browser дээр тест хийх:
```
https://shuurkhai.com/shuurkhai_git/login
```

---

## 📝 Тайлбар:

**Stash** нь local өөрчлөлтүүдийг түр хугацаанд хадгалж, дараа нь буцааж авах боломжтой болгодог. Энэ нь production server дээрх `.htaccess` файлд байгаа production-д зориулсан тохиргоонуудыг хадгалахад тусална.

**Анхаарах:** `.htaccess` файлд production-д зориулсан чухал тохиргоонууд байж болно (жишээ нь: RewriteBase, security headers гэх мэт). Stash pop хийсний дараа эдгээр тохиргоонуудыг шалгаж, шаардлагатай бол дахин нэмнэ.
