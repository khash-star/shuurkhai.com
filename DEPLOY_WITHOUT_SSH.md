# SSH-гүйгээр Production руу Deploy хийх заавар

SSH холболт амжилтгүй болсон тул доорх аргуудыг ашиглана уу.

## 🎯 Арга 1: cPanel File Manager (Хамгийн хялбар) ✅

### Алхам 1: Локал дээр зассан файлуудыг олох

Засварласан 2 файл:
- `c:\xampp\htdocs\shuurkhai\admin\login.php`
- `c:\xampp\htdocs\shuurkhai\admin\views\helper.php`

### Алхам 2: cPanel нээх

1. Browser дээр: `https://shuurkhai.com:2083` (эсвэл hosting provider-ийн cPanel URL)
2. cPanel username/password-оор нэвтрэх

### Алхам 3: File Manager ашиглах

1. cPanel дээр **"File Manager"** олох
2. `public_html/shuurkhai_git` directory руу орох
3. Дараах файлуудыг олох:
   - `admin/login.php`
   - `admin/views/helper.php`

### Алхам 4: Файлуудыг засах

**admin/login.php** файлыг edit хийх:
1. `admin/login.php` дээр right-click → **"Edit"**
2. Эхний 5 мөрийг доорх байдлаар засах:

```php
<?php
    require_once(__DIR__ . "/../config.php");
    require_once(__DIR__ . "/views/helper.php");
    require_once(__DIR__ . "/views/init.php");
?>
```

3. **"Save Changes"** дарах

**admin/views/helper.php** файлыг edit хийх:
1. `admin/views/helper.php` дээр right-click → **"Edit"**
2. 392-р мөрийг олох (Ctrl+F: `name;break`)
3. Доорх байдлаар засах:

**Хуучин:**
```php
case "name": return $data["name;break"];
```

**Шинэ:**
```php
case "name": return $data["name"]; break;
```

4. **"Save Changes"** дарах

### Алхам 5: Тест хийх

Browser дээр: `https://shuurkhai.com/shuurkhai_git/login`

---

## 🎯 Арга 2: FTP Client ашиглах (FileZilla, WinSCP)

### Алхам 1: FTP Client суулгах

- **FileZilla**: https://filezilla-project.org/
- **WinSCP**: https://winscp.net/

### Алхам 2: FTP холболт үүсгэх

**FTP мэдээлэл:**
- Host: `ftp.shuurkhai.com` (эсвэл IP: `198.12.239.156`)
- Username: `r2c69it0btr1` (эсвэл cPanel username)
- Password: cPanel password
- Port: `21` (FTP) эсвэл `22` (SFTP)

### Алхам 3: Файлуудыг upload хийх

1. Локал дээр:
   - `c:\xampp\htdocs\shuurkhai\admin\login.php`
   - `c:\xampp\htdocs\shuurkhai\admin\views\helper.php`

2. Remote дээр:
   - `/public_html/shuurkhai_git/admin/login.php`
   - `/public_html/shuurkhai_git/admin/views/helper.php`

3. Файлуудыг drag & drop эсвэл upload хийх

---

## 🎯 Арга 3: cPanel Git Version Control (Хэрэв боломжтой бол)

1. cPanel → **"Git Version Control"** олох
2. `shuurkhai_git` repository-г олох
3. **"Pull or Deploy"** дарах
4. **"Update from Remote"** дарах
5. Branch: `main` сонгох
6. **"Update"** дарах

---

## ✅ Шалгах

Deploy хийсний дараа:

1. **Browser дээр тест:**
   ```
   https://shuurkhai.com/shuurkhai_git/login
   ```

2. **Хэрэв асуудал гарвал:**
   - cPanel → **"Error Log"** шалгах
   - Эсвэл cPanel → **"Terminal"** (хэрэв боломжтой бол):
     ```bash
     php -l admin/login.php
     php -l admin/views/helper.php
     ```

---

## 📝 Засварласан өөрчлөлтүүд

### 1. admin/login.php
```php
// Хуучин:
require_once("config.php");
require_once("views/helper.php");
require_once("views/init.php");

// Шинэ:
require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/views/helper.php");
require_once(__DIR__ . "/views/init.php");
```

### 2. admin/views/helper.php (line 392)
```php
// Хуучин:
case "name": return $data["name;break"];

// Шинэ:
case "name": return $data["name"]; break;
```

---

## ⚠️ Анхаарах зүйлс

- Файлуудыг засахын өмнө backup хийх нь зөв
- cPanel File Manager дээр "Code Editor" ашиглах нь илүү тохиромжтой
- Файлуудыг засварласны дараа browser cache цэвэрлэх (Ctrl+F5)
