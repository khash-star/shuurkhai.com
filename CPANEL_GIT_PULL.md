# cPanel Git Version Control ашиглан Deploy хийх

## 🎯 Арга 1: cPanel Git Version Control (Хамгийн хялбар)

### Алхам 1: cPanel нээх
1. `https://shuurkhai.com:2083` нээх
2. cPanel username/password-оор нэвтрэх

### Алхам 2: Git Version Control олох
1. cPanel дээр **"Git Version Control"** эсвэл **"Git"** хэсэг олох
2. Хэрэв олдохгүй бол: cPanel → **"Software"** → **"Git Version Control"**

### Алхам 3: Repository олох
1. `shuurkhai_git` эсвэл `shuurkhai.com` гэсэн repository-г олох
2. Хэрэв байхгүй бол **"Create"** эсвэл **"Clone"** дарах

### Алхам 4: Pull хийх
1. Repository-ийн хажууд **"Pull or Deploy"** эсвэл **"Update"** товч олох
2. Дарах
3. **"Update from Remote"** сонгох
4. Branch: `main` сонгох
5. **"Update"** эсвэл **"Pull"** дарах

### Алхам 5: Шалгах
Browser дээр: `https://shuurkhai.com/shuurkhai_git/login`

---

## 🎯 Арга 2: cPanel Terminal (Web Terminal)

### Алхам 1: Terminal нээх
1. cPanel → **"Terminal"** эсвэл **"Web Terminal"** олох
2. Хэрэв байхгүй бол hosting provider-оос идэвхжүүлэх хэрэгтэй

### Алхам 2: Git Pull хийх
```bash
cd ~/public_html/shuurkhai_git
git pull origin main
```

### Алхам 3: Шалгах
```bash
# Файлууд засагдсан эсэхийг шалгах
head -5 admin/login.php
sed -n '390,395p' admin/views/helper.php
```

---

## 🎯 Арга 3: Repository шинээр Clone хийх (хэрэв байхгүй бол)

### cPanel Git Version Control дээр:

1. **"Create"** эсвэл **"Clone"** дарах
2. Дараах мэдээлэл оруулах:
   - **Repository URL**: `https://github.com/khash-star/shuurkhai.com.git`
   - **Repository Branch**: `main`
   - **Clone Directory**: `public_html/shuurkhai_git`
   - **Repository Name**: `shuurkhai_git`
3. **"Create"** дарах

---

## ✅ Шалгах

### 1. Файлууд засагдсан эсэхийг шалгах:

**admin/login.php** эхний мөрүүд:
```php
<?php
    require_once(__DIR__ . "/../config.php");
    require_once(__DIR__ . "/views/helper.php");
    require_once(__DIR__ . "/views/init.php");
?>
```

**admin/views/helper.php** 392-р мөр:
```php
case "name": return $data["name"]; break;
```

### 2. Browser дээр тест:
```
https://shuurkhai.com/shuurkhai_git/login
```

---

## ⚠️ Хэрэв асуудал гарвал

### Git pull хийхэд алдаа гарвал:
```bash
# Force pull (болгоомжтой ашиглах)
cd ~/public_html/shuurkhai_git
git fetch origin
git reset --hard origin/main
```

### Файлууд засагдаагүй бол:
cPanel File Manager ашиглан гараар засах (QUICK_FIX_CPANEL.md үзнэ үү)

### Error log шалгах:
cPanel → **"Error Log"** эсвэл **"Metrics"** → **"Errors"**

---

## 📝 Тайлбар

GitHub-аас pull хийснээр дараах файлууд автоматаар шинэчлэгдэнэ:
- ✅ `admin/login.php` (path-ууд зассан)
- ✅ `admin/views/helper.php` (syntax алдаа зассан)

Эдгээр өөрчлөлтүүд HTTP 500 алдааг засах ёстой.
